<?php

use Telegram\Bot\Commands\Command;

class SubsCommand extends Command
{

    protected $name = "subs";

    /**
     * @inheritDoc
     */
    public function handle($arguments)
    {
        $first_name = $this->telegram->getWebhookUpdates()->getMessage()->getChat()->getId();
        $this->replyWithMessage(['text'=>'Ахахах. Что это?']);
    }
}