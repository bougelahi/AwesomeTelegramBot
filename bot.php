<meta charset="UTF-8">
<?php
require 'vendor/autoload.php';
require 'bussinesLogic.php';
require 'StartCommand.php';
require 'SubscribeCommand.php';
require 'UnsubCommand.php';


use Telegram\Bot\Api;

$telegram = new Api("953687965:AAHRKY6JNOY0ssCKLDs-P8rr1cDfsRXHARk");

$telegram->addCommand(StartCommand::class);
$telegram->addCommand(SubscribeCommand::class);
$telegram->addCommand(UnsubCommand::class);
$telegram->commandsHandler(true);
$update = $telegram->getWebhookUpdates();

$message = $update->getMessage()->getText();
$chat_id = $update->getMessage()->getChat()->getId();
$first_name = $update->getMessage()->getChat()->getFirstName();

saveUser($update);



