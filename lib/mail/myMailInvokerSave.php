<?php
/**
 * Обработчик исходящих писем - сохраняет письма на диск
 *
 * @author Max <maxim.olenik@gmail.com>
 */

class myMailInvokerSave extends myMailInvokerStub
{
    /**
     * Директория для хранения писем
     */
    private $_mailsDir = '';


    /**
     * Конструктор
     *
     * @param  string $mailsDir - директория для хранения исходящих писем
     * @return void
     */
    public function __construct($mailsDir)
    {
        if (!is_dir($mailsDir) || !is_writable($mailsDir)) {
            throw new InvalidArgumentException("Expected `{$mailsDir}` is writable dir");
        }
        $this->_mailsDir = realpath($mailsDir);
    }


    /**
     * Отправить письмо
     *
     * Сохраняет в файл
     *
     * @return void
     */
    public function mail($to, $subject, $body, $headers = null, $extraParams = null)
    {
        if (!parent::mail($to, $subject, $body, $headers, $extraParams)) {
            return false;
        }

        $data = "To: {$to}\nSubject: {$subject}\n{$headers}\n\n{$body}";
        file_put_contents($this->_makeFileName(), $data);

        return true;
    }


    /**
     * Получить сохраненное письмо
     *
     * @param  int $mailNum - порядковый номер письма, начиная с 1
     * @return string
     */
    public function getMail($mailNum)
    {
        $mailNum = (int) $mailNum;

        $mail = $this->_mailsDir . '/' . $mailNum;
        if (file_exists($mail)) {
            return file_get_contents($mail);
        }

        throw new RuntimeException(__METHOD__.": mail with index `{$mailNum}` not found");
    }


    /**
     * Посчитать кол-во сохраненных писем
     *
     * @return int
     */
    public function count()
    {
        return count(scandir($this->_mailsDir)) - 2;
    }


    /**
     * Создать имя файла для записи
     *
     * @return string
     */
    private function _makeFileName()
    {
        $result  = '';
        $counter = 1;

        do {
            $result = $this->_mailsDir . '/' . $counter;
            $counter++;
        } while (file_exists($result));

        return $result;
    }

}
