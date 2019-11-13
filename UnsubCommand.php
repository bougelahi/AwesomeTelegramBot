<?php


use Telegram\Bot\Commands\Command;

class UnsubCommand extends Command
{

    protected $name = "unsubscribe";

    public function handle($arguments)
    {
        $user_id = $this->telegram->getWebhookUpdates()->getMessage()->getChat()->getId();
        if (unsubRss(intval($arguments), $user_id)) {
            $this->replyWithMessage(['text' => 'Успешно отписался!']);
        } else {
            $this->replyWithMessage(['text' => 'Ты не подписан на этот каталог, дружок!']);
        }
    }
}