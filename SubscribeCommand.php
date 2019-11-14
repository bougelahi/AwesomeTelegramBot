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
            $status = subscribeRss($arguments, $user_id);

            if ($status == 1) {
                $this->replyWithMessage(['text' => 'Успешно!']);
            } elseif ($status == 0) {
                $this->replyWithMessage(['text' => 'Уже подписан, друган!']);
            } else {
                $this->replyWithMessage(['text' => 'Неверный URL!']);
            }
        } else {
            $this->replyWithMessage(['text' => 'Для подписки на каталог необходимо указать его URL. 
Пример: /subcribe https://example.com/rss']);
        }
    }
}