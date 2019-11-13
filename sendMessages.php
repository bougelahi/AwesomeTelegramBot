<?php
require 'vendor/autoload.php';
require 'bussinesLogic.php';

$connect = getConnect();

use Telegram\Bot\Api;

$telegram = new Api("953687965:AAHRKY6JNOY0ssCKLDs-P8rr1cDfsRXHARk");

$res = $connect->query("SELECT user_id, rss_id, last_message_guid FROM rss_subs");

while ($row = $res->fetch_assoc()) {
    var_dump($row);
    $user_id = $row['user_id'];
    $rss_id = intval($row['rss_id']);
    $last = $row['last_message_guid'];
    $telegram->sendMessage(['chat_id' => $user_id, 'text' => "Новый пост: " . $user_id . $rss_id . $last]);
}

function getMessages()
{

}

closeConnect($connect);