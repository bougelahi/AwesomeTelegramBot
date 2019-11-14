<?php

use Telegram\Bot\Commands\Command;

class SubsCommand extends Command
{

    protected $name = "subs";

    public function handle($arguments)
    {
        $chat_id = $this->telegram->getWebhookUpdates()->getMessage()->getChat()->getId();
        $res = getSubs($chat_id);
        while ($row = $res->fetch_assoc()){
            $this->replyWithMessage(['text' => 'Ахахах.' . $row['id'] .' Что это?' . $row['title']]);
        }
    }
}