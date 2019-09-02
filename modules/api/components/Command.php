<?php


namespace app\modules\api\components;


class Command
{
    const TYPE_TEXT_MESSAGE = 'text_message';

    const TYPE_CALLBACK_QUERY = 'callback_query';

    public $text = null;

    public $message;

    public $firstName = null;

    public $languageCode = 'en';

    public $chatID = null;

    public $callbackID = null;

    public $isCommand = false;


    public $type = self::TYPE_TEXT_MESSAGE;

    public function __construct(array $data)
    {
        if (isset($data['message'])) {
            $this->setCommandAttributes($data['message']);
        } elseif (isset($data['callback_query'])) {
            $this->setCallbackAttributes($data['callback_query']);
        }
    }

    public function setCallbackAttributes($callback)
    {
        $this->type = self::TYPE_CALLBACK_QUERY;
        $this->callbackID = $callback['id'];
        $this->setCommandAttributes($callback['message']);
    }

    /**
     * @param array $data
     */
    public function setCommandAttributes($message)
    {
        $this->message = $message;
        $this->text = $message['text'] ?? null;
        $this->text = $message['text'] ?? null;
        $this->firstName = $message['from']['first_name'] ?? null;
        $this->languageCode = $message['from']['language_code'] ?? 'en';
        $this->chatID = (string)$message['chat']['id'] ?? null;
        $this->isCommand = (!empty($message['entities'][0]['type']) AND
            $message['entities'][0]['type'] === 'bot_command') ? true : false;
    }

}