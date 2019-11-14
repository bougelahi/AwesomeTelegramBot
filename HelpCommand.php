<?php


use Telegram\Bot\Commands\Command;

class HelpCommand extends Command
{

    protected $name = "help";

    public function handle($arguments)
    {
        $this->replyWithMessage(['text' => '/subscribe [URL] - команда необходимая для подписки на RSS рассылку.
/subs - получить список своих RSS подписок
/unsubscribe [ID] - отписаться от RRS ленты. ID можно получить через команду /subs']);
    }
}