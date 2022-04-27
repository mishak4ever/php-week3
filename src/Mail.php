<?php

namespace Base;

class Mail {

    const USER_NAME = 'robot';

    private static $smtp_transport;
    private static $mailer;
    private static $targetEmail;
    private static $_instance;
    private static $message;

    private function __construct() {

        try {
            $smtp_transport = (new \Swift_SmtpTransport(SMTP_HOST, SMTP_PORT))
                    ->setUsername(EMAIL_LOGIN)
                    ->setPassword(EMAIL_PASSWORD)
                    ->setEncryption(SMTP_ENCRIPTION);

            self::$mailer = new \Swift_Mailer($smtp_transport);
        } catch (Exception $exc) {
            return false;
        }
    }

    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function sendMail(string $mail, string $title, string $content) {
        try {
            $message = (new \Swift_Message($title))
                    ->setFrom([EMAIL_LOGIN => self::USER_NAME])
                    ->setTo([$mail])
                    ->setBody($content);
            return self::$mailer->send($message);
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

}
