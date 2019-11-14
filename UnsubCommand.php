<?php


use Telegram\Bot\Commands\Command;

class UnsubCommand extends Command
{

    protected $name = "unsubscribe";

    public function handle($arguments)
    {

        if ($arguments == null or empty($arguments)) {
            $this->replyWithMessage(['text' => 'Для того, чтобы отписаться от RSS ленты введите её идентификатор. Пример: /unsubscribe 777']);
        } else {
            $user_id = $this->telegram->getWebhookUpdates()->getMessage()->getChat()->getId();
            if (unsubRss(intval($arguments), $user_id)) {
                $this->replyWithMessage(['text' => 'Успешно отписался!']);
            } else {
                $this->replyWithMessage(['text' => 'Ты не подписан на этот каталог, дружок!']);
            }
        }
    }
}