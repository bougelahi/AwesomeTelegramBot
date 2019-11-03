<?php
require 'vendor/autoload.php';
require 'Service.php';

use Telegram\Bot\Api;

$service = new Service();

$telegram = new Api("953687965:AAHRKY6JNOY0ssCKLDs-P8rr1cDfsRXHARk");

$update = $telegram->getWebhookUpdates();

$service->setUser($update);
$service->setMessage($update);