<?php

namespace app\modules\api\components;

class CommandHandler
{
    public $allowedCommands = [
        '/menu' => 'sendMenu'
    ];

    private $command = null;

    public function __construct(string $command)
    {
        $this->setCommand($command);

        call_user_func_array([$this, 'sendMenu'], []);
    }

    public function sendMenu()
    {
        var_dump(444);
    }

    /**
     * @return null
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param null $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }

}