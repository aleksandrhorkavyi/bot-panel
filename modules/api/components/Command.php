<?php


namespace app\modules\api\components;


class Command
{
    public $text = null;

    public $message;

    public $date = null;

    public $firstName = null;

    public $languageCode = 'en';

    public $chatID = null;

    public function __construct(array $data)
    {
        $this->setAttributes($data['message']);
    }

    /**
     * @param array $data
     */
    public function setAttributes($message)
    {
        $this->message = $message;
        $this->setText($message);
        $this->setDate($message);
        $this->setFirstName($message);
        $this->setLanguageCode($message);
        $this->setChatID($message);
    }

    public function setChatID($message)
    {
        $this->chatID = (string)$message['chat']['id'] ?? null;
    }

    public function setText($message)
    {
        $this->text = $message['text'] ?? null;
    }

    public function setDate($message)
    {
        $this->date = $message['date'] ?? null;
    }

    public function setFirstName($message)
    {
        $this->firstName = $message['from']['first_name'] ?? null;
    }

    public function setLanguageCode($message)
    {
        $this->languageCode = $message['from']['language_code'] ?? 'en';
    }
}