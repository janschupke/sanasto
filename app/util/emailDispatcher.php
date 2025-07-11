<?php

use io\schupke\sanasto\core\exception\EmailConstructionException;

/**
 * Represents an email message that will be sent by the dispatcher.
 */
class EmailMessage {
    private $to;
    private $subject;
    private $message;
    private $headers;

    function __construct($replyTo) {
        $this->headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
        $this->headers .= "From: noreply@sanasto.eu" . "\r\n";

        if ($replyTo != null) {
            $this->headers .= "Reply-to: " . $replyTo . "\r\n";
        }

    }

    public function getTo() {
        return $this->to;
    }
    public function setTo($to) {
        $this->to = $to;
    }

    public function getSubject() {
        return $this->subject;
    }
    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function getMessage() {
        return $this->message;
    }
    public function setMessage($message) {
        $this->message = $message;
    }

    public function getHeaders() {
        return $this->headers;
    }
}

/**
 * Takes care of all e-mail related logic.
 */
class EmailDispatcher {

    /**
     * Called from within the application, this method
     * takes care of preparing and sending the message.
     * @param string $recipient an email address of the recipient.
     * @param string $subject the subject of the message.
     * @param string message the message that will be in the email body.
     * @param string $replyTo Requested reply-to email address.
     * @return true if successfully sent, false otherwise.
     */
    public static function send($recipient, $subject, $message, $replyTo = null) {
        self::validateData($recipient, $subject, $message, $replyTo);

        $email = self::createEmail($recipient, $subject, $message, $replyTo);
        return self::dispatch($email);
    }

    /**
     * Ensures that the provided data are valid for construction of the email.
     * @param string $recipient an email address of the recipient.
     * @param string $subject the subject of the message.
     * @param string message the message that will be in the email body.
     * @param string $replyTo Requested reply-to email address.
     * @throws EmailConstructionException in case of any validation errors.
     */
    private static function validateData($recipient, $subject, $message, $replyTo = null) {
        if (!InputValidator::validateEmail($recipient)) {
            throw new EmailConstructionException("Invalid recipient.");
        }

        if ($replyTo != null and !InputValidator::validateEmail($replyTo)) {
            throw new EmailConstructionException("Invalid reply-to.");
        }

        if (InputValidator::isEmpty($subject)) {
            throw new EmailConstructionException("Empty subject.");
        }

        if (InputValidator::isEmpty($message)) {
            throw new EmailConstructionException("Empty message.");
        }
    }

    /**
     * Creates an instance of the EmailMessage based on the provided data.
     * @param string $recipient an email address of the recipient.
     * @param string $subject the subject of the message.
     * @param string message the message that will be in the email body.
     * @param string $replyTo Requested reply-to email address.
     * @return EmailMessage an instance of the message to be sent.
     */
    private static function createEmail($recipient, $subject, $message, $replyTo = null) {
        global $l;

        $email = new EmailMessage($replyTo);

        $subject = ($l["email"]["global"]["subject"]["prefix"] . " - " . $subject);
        $emailBody = ("<b>" . $l["email"]["global"]["head"] . "</b>");
        $emailBody .= "<br /><br />";
        $emailBody .= $message;
        $emailBody .= "<br /><br />";
        $emailBody .= ("<i>" . $l["email"]["global"]["foot"] . "</i>");

        $email->setTo($recipient);
        $email->setSubject($subject);
        $email->setMessage($emailBody);

        return $email;
    }

    /**
     * Calls the PHP's mail() function to finally send the provided email.
     * @param EmailMessage $email an instance of the message to be sent.
     * @return true if successfully sent, false otherwise.
     */
    private static function dispatch(EmailMessage $email) {
        $mailStatus = mail(
            $email->getTo(),
            $email->getSubject(),
            wordwrap($email->getMessage()),
            $email->getHeaders());

        return $mailStatus;
    }
}
