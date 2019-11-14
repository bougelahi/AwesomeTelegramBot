<?php
require 'vendor/autoload.php';
require 'bussinesLogic.php';

$connect = getConnect();

use Telegram\Bot\Api;

$telegram = new Api("953687965:AAHRKY6JNOY0ssCKLDs-P8rr1cDfsRXHARk");

$res = $connect->query("SELECT user_id, rss_id, last_message_guid FROM rss_subs");

while ($row = $res->fetch_assoc()) {
    $user_id = $row['user_id'];
    $rss_id = intval($row['rss_id']);
    $last = $row['last_message_guid'];
    getMessages($connect, $rss_id, $user_id, $telegram);
    $telegram->sendMessage(['chat_id' => $user_id, 'text' => "Новый пост: " . $user_id . $rss_id . $last]);
}

function getMessages(mysqli $connect, $rss_id, $user_id, Api $telegram)
{
    $stmt = $connect->prepare("SELECT * FROM rss where id = ?");
    $stmt->bind_param("i", $rss_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        sendMessages($row['url'], $user_id, $telegram);
    }
}

function sendMessages($rss_url, $user_id, Api $telegram)
{
    $feeds = file_get_contents($rss_url);
    $rss = simplexml_load_string($feeds);
    echo $rss->channel->item[0]->title;

    for ($i = 200; $i >= 0; $i--) {
        if (!($rss->channel->item[$i] == null)) {
            $telegram->sendMessage(['chat_id' => $user_id, 'text' => strval($rss->channel->item[$i]->title)]);
        }
    }
}

function getLastIdByGuid($guid, SimpleXMLElement $rss)
{

}

closeConnect($connect);