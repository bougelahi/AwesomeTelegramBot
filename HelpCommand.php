<?php


use Telegram\Bot\Commands\Command;

class HelpCommand extends Command
{

    protected $name = "help";

    public function handle($arguments)
    {
        $this->replyWithMessage(['text' => 'Тут должна быть помощь']);
    }
}