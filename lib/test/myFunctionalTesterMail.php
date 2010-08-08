<?php
/**
 * Тестер для проверки исходящих писем
 *
 * @author Max <maxim.olenik@gmail.com>
 */

class myFunctionalTesterMail extends sfTester
{
    /**
     * myMailInvokerSave
     */
    private $_invoker = null;

    /**
     * Директория для хранения исходящих писем
     */
    private $_mailDir;

    /**
     * Директория фикстур
     */
    private $_templateDir;

    /**
     * Список email, которые должны вернуть ошибку
     */
    private $_errors;


    /**
     * Конструктор
     *
     * @return void
     */
    public function __construct(sfTestFunctional $browser)
    {
        $this->browser  = $browser;
    }


    /**
     * Выполняется перед каждым запросом браузера
     *
     * @return void
     */
    public function prepare()
    {
        // Инициализировать директории
        $this->_mailDir     = $this->_initDir('app_mail_save_dir');
        $this->_templateDir = $this->_initDir('app_mail_template_dir', $create = false);
        // Очистить директорию с письмами
        $this->reset();


        // Обработчик писем
        $this->_invoker = new myMailInvokerSave($this->_mailDir);
        Swift_DependencyContainer::getInstance()
            ->register('transport.mailinvoker')
            ->asValue($this->_invoker);
        // Указать ошибочные email
        if ($this->_errors) {
            $this->_invoker->setErrors($this->_errors);
            $this->_errors = null;
        }

    }


    /**
     * Выполняется перед каждым вызовом $browser->with('mail')
     *
     * @return void
     */
    public function initialize()
    {
    }


    /**
     * Сбрасывает временные настройки и удаляет сохраненные письма
     *
     * @return void
     */
    public function reset()
    {
        $this->_errors = array();
        sfToolkit::clearDirectory($this->_mailDir);
    }


    /**
     * Получить обработчик писем
     *
     * @return myMailInvokerSave
     */
    public function getMailInvoker()
    {
        return $this->_invoker;
    }


    /**
     * Установить список email, которые должны вернуть ошибку
     *
     * @param  array $emails - array("email1", "emaill2")
     * @return void
     */
    public function setErrors(array $emails)
    {
        $this->_errors = $emails;
        return $this->getObjectToReturn();
    }


    /**
     * Получить образец письма для сравнения
     *
     * @param  string $name - название файла в TEST_DATA_DIR/mail/
     * @return string
     */
    public function getTemplate($name)
    {
        $file = $this->_templateDir.'/'.$name;
        if (!file_exists($file)) {
            throw new Exception(__METHOD__.": mail template not found `{$file}`");
        }
        return file_get_contents($file);
    }


    /**
     * Получить сохраненное письмо
     *
     * @param  int $mailNum - порядковый номер письма, начиная с 1
     * @return string
     */
    public function getMail($mailNum)
    {
        $mail = $this->_invoker->getMail($mailNum);

        $mail = preg_replace(
            array(
                "#\r\n #",
                "#\nMessage-ID\:.*\n#",
                "#\nDate\:.*\n#",
                "#\n\n\n(.*)$#se",
                "#=\?utf-8\?Q\?([^\?]+)\?=#e",
            ),
            array(
                "",
                "\n",
                "\n",
                "'\n\n\n'.trim(base64_decode('\\1'))",
                "quoted_printable_decode(str_replace('_', ' ', '\\1'))",
            ),
            $mail);

        return $mail;
    }


    /**
     * Посчитать кол-во отправленных писем
     *
     * @return int
     */
    public function count()
    {
        return $this->_invoker->count();
    }


    /**
     * Проверить кол-во отправленных писем
     *
     * @param  int $expectedCount - Кол-во писем
     */
    public function checkCount($expectedCount)
    {
        PHPUnit_Framework_Assert::assertEquals((int)$this->count(), (int)$expectedCount, "Count sent mails");
        return $this->getObjectToReturn();
    }


    /**
     * Проверить, что отправленное письмо содержит указанную строку
     *
     * @param  int    $mailNum - порядковый номер письма, начиная с 1
     * @param  string $needle  - искомая строка
     */
    public function checkContains($mailNum, $needle, $ignoreCase = false)
    {
        $mail = $this->getMail($mailNum);
        PHPUnit_Framework_Assert::assertContains($needle, $mail, sprintf("Email (%d) contains `%s`, got:\n\n%s\n", $mailNum, $needle, $mail), $ignoreCase);
        return $this->getObjectToReturn();
    }


    /**
     * Проверить содержимое отправленного письма
     *
     * Вырезает лишние заголовки
     * Переконвертирует из Base64 и Quoted-Printable
     *
     * @param  int    $mailNum       - порядковый номер письма, начиная с 1
     * @param  string $templateName    - название файла в TEST_DATA_DIR/mail/
     * @param  array  $replacements  - массив подстановок, которые необходимо сделать в эталоне
     * @param  string $mess          - тестовое сообщение
     */
    public function checkMail($mailNum, $templateName, array $replacements = array(), $mess = '')
    {
        $expectedText = trim($this->getTemplate($templateName));
        $replacements["\r"] = '';
        if ($replacements) {
            $expectedText = strtr($expectedText, $replacements);
        }

        $actualText = $this->getMail($mailNum);

        if ($expectedText !== $actualText) {
            $expectedFile = tempnam('/tmp', 'expected');
            file_put_contents($expectedFile, $expectedText);
            $actualFile = tempnam('/tmp', 'actual');
            file_put_contents($actualFile, $actualText);
            $diff = `colordiff {$expectedFile} {$actualFile}`;
            unlink($expectedFile);
            unlink($actualFile);

            PHPUnit_Framework_Assert::fail($mess."\nExpected VS Actual\n".$diff);
        }

        return $this->getObjectToReturn();
    }


    /**
     * Получить директорию из конфига и создать при необходимости
     *
     * @param  string $paramName - Имя параметра
     * @param  bool   $create    - Создать директорию (рекурсивно), если ее нет
     * @return string            - Полный путь к директории
     */
    private function _initDir($paramName, $create = true)
    {
        if (!$dir = sfConfig::get((string)$paramName)) {
            throw new Exception(__METHOD__.": Expected config param `{$paramName}`");
        }
        $dir = DIR.DIRECTORY_SEPARATOR.$dir;

        if ($create && !is_dir($dir)) {
            if (!mkdir($dir, 0777, true)) {
                throw new Exception(__METHOD__.": Failed to create dir `{$dir}`");
            }
        }

        return realpath($dir);
    }

}
