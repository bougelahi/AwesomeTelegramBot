<?php
require 'vendor/autoload.php';

use Telegram\Bot\Commands\Command;

class SubscribeCommand extends Command
{

    protected $name = "subscribe";

    protected $description = "Start Command to get you started";

    public function handle($arguments)
    {
        if (!($arguments == null or empty($this->arguments))) {
            $user_id = $this->telegram->getWebhookUpdates()->getMessage()->getChat()->getId();

            if (subscribeRss($arguments, $user_id)) {
                $this->replyWithMessage(['text' => 'Успешно!']);
            } else {
                $this->replyWithMessage(['text' => 'Уже подписан, друган!']);
            }
        } else {
            $this->replyWithMessage(['text' => 'Для подписки на каталог необходимо указать его URL. Пример: /subcribe example.com/rss']);
        }
    }
}