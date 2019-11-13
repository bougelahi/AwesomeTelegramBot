<?php
require 'vendor/autoload.php';

use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{

    protected $name = "start";

    protected $description = "Start Command to get you started";

    public function handle($arguments)
    {
        $first_name = $this->telegram->getWebhookUpdates()->getMessage()->getChat()->getFirstName();
        $this->replyWithMessage(['text' => 'Привет, ' . $first_name . "! Это бот для RSS рассылки."]);
    }
}