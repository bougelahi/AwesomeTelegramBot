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
    for ($i = getLastIdByGuid(getGuid($user_id, getRssId($rss_url)), $rss); $i >= 0; $i--) {
        if (!($rss->channel->item[$i] == null)) {
            $telegram->sendMessage(['chat_id' => $user_id, 'text' => strval($rss->channel->item[$i]->guid)]);
            if ($i == 0) {
                setLastGuid($user_id, getRssId($rss_url), strval($rss->channel->item[$i]->guid));
            }
        }
    }
}

function setLastGuid($user_id, $rss_id, $last_guid)
{
    $connect = getConnect();
    $stmt = $connect->prepare("UPDATE rss_subs set last_message_guid = ? where user_id = ? and rss_id = ?");
    $stmt->bind_param("sii", $last_guid, $user_id, $rss_id);
    $stmt->execute();
}

function getGuid($user_id, $rss_id)
{
    $connect = getConnect();
    $stmt = $connect->prepare("SELECT last_message_guid from rss_subs where user_id = ? and rss_id = ?");
    $stmt->bind_param("ii", $user_id, $rss_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc()['last_message_guid'];
}

function getLastIdByGuid($guid, SimpleXMLElement $rss)
{
    for ($i = 200; $i >= 0; $i--) {
        if (strval($rss->channel->item[$i]->guid) == strval($guid)) {
            echo strval($rss->channel->item[$i]->guid) . "<BR>" . strval($guid);
            var_dump(strval($rss->channel->item[$i]->guid) == strval($guid));
            return $i - 1;
        }
    }
    return 200;
}

closeConnect($connect);