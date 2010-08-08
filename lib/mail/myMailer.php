<?php

/**
 * Mailer
 */
class myMailer extends sfMailer
{
    /**
     * Создать сообщение
     *
     * Конфигурирует сообщение и подставляет системный адрес отправителя
     *
     * @param  string|array $to
     * @param  string       $subject
     * @param  strong       $body
     * @return Swift_Messge
     */
    public function newMessage($to = null, $subject = null, $body = null)
    {
        $from = array($email = sfConfig::get('app_mail_admin_email') => sfConfig::get('app_mail_admin_name'));
        $message = $this->compose($from, $to, $subject, $body)
            ->setReplyTo($email)
            ->setReturnPath($email)
            ->setEncoder(new Swift_Mime_ContentEncoder_Base64ContentEncoder);

        return $message;
    }


    /**
     * Создает и отправляет сообщение
     *
     * @param  string|array $to
     * @param  string       $subject
     * @param  strong       $body
     * @return Swift_Messge
     */
    public function createAndSend($to = null, $subject = null, $body = null, $from = null, $replyto = null, array $attachments = null)
    {
        $message = $this->newMessage($to, $subject, $body);

        if ($from) {
            $message->setFrom($from);
        }

        if ($replyto) {
            $message->setReplyTo($replyto);
        }

        if ($attachments) {
            foreach ($attachments as $name => $attach) {
                $message->attach(new Swift_Attachment(file_get_contents($attach[0]), $name, $attach[1]));
            }
        }

        return $this->send($message);
    }
}
