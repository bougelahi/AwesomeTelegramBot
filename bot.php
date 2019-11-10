<?php
require 'vendor/autoload.php';
require 'bussinesLogic.php';


use Telegram\Bot\Api;

$telegram = new Api("953687965:AAHRKY6JNOY0ssCKLDs-P8rr1cDfsRXHARk");

$update = $telegram->getWebhookUpdates();

saveUser($telegram, $update);
