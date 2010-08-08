<?php
/**
 * Расширенный тестер для responce
 *
 * @author Max <maxim.olenik@gmail.com>
 */

class myFunctionalTesterResponse extends sfTesterResponse
{
    /**
     * Проверить, что ответ эквивалентен указанному значению
     *
     * @param  string $text - полный текст ответа
     */
    public function checkEquals($text)
    {
        $this->tester->is($this->response->getContent(), $text,
            sprintf('response equals `%s`', substr($text, 0, 40)));

        return $this->getObjectToReturn();
    }


    /**
     * Check: проверить редирект
     *
     * @param int    $statusCode
     * @param string $uri
     */
    public function checkRedirect($statusCode, $uri)
    {
        return $this->begin()
            ->isStatusCode($statusCode)
            ->isHeader('Location', 'http://localhost'.$uri)
        ->end();
    }


    /**
     * Check: проверить вхождение подстроки
     *
     * @param string $text
     */
    public function contains($text)
    {
        $this->tester->is((false !== strpos($this->response->getContent(), $text)), true,
            sprintf('response contains `%s`', substr($text, 0, 40)));

        return $this->getObjectToReturn();
    }

}
