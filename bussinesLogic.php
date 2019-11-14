<?php
require 'vendor/autoload.php';


use Telegram\Bot\Objects\Update;


function saveUser(Update $update)
{
    $db_connect = getConnect();

    $id = $update->getMessage()->getChat()->getId();
    $username = $update->getMessage()->getChat()->getUsername();
    $firstName = $update->getMessage()->getChat()->getFirstName();
    $lastName = $update->getMessage()->getChat()->getLastName();

    $statement = $db_connect->prepare("call saveUser(?,?,?,?)");
    $statement->bind_param("isss", $id, $username, $firstName, $lastName);
    $statement->execute();
    $statement->close();
    closeConnect($db_connect);
}

function rssExist($rss_url)
{
    $connect = getConnect();
    $statement = $connect->prepare("SELECT * FROM rss where url like ?");
    $statement->bind_param("s", $rss_url);
    $statement->execute();
    return $statement->get_result()->num_rows > 0;
}

function isSub($user_id, $rss_id)
{
    $connect = getConnect();
    $statement = $connect->prepare("SELECT * FROM rss_subs where user_id = ? and rss_id = ?");
    $statement->bind_param("ii", $user_id, $rss_id);
    $statement->execute();
    return $statement->get_result()->num_rows > 0;
}

function getRssId($rss_url)
{
    $connect = getConnect();
    if (!rssExist($rss_url)) {
        $stmt = $connect->prepare("INSERT INTO rss (title, url) values (?,?)");
        $stmt->bind_param("ss", getTitle($rss_url), $rss_url);
        var_dump($stmt->execute());
        $stmt->close();
    }

    $stmt = $connect->prepare("SELECT id from rss where url like ?");
    $stmt->bind_param("s", $rss_url);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc()['id'];
    $stmt->close();
    $connect->commit();
    $connect->close();
    return $result;
}

function getSubList($user_id)
{
}

function subscribeRss($rss_url, $user_id)
{
    $rss_id = getRssId($rss_url);
    if (isSub($user_id, $rss_id)) {
        return 0;

    } elseif (getTitle($rss_url) == null) {
        return 2;
    } else {
        $connect = getConnect();
        $statement = $connect->prepare("INSERT INTO rss_subs (user_id, rss_id) values (?,?)");
        $statement->bind_param("ii", $user_id, $rss_id);
        $statement->execute();
        $statement->close();
        closeConnect($connect);
        return 1;
    }
}

function unsubRss($rss_id, $user_id)
{
    if (isSub($user_id, $rss_id)) {
        $connect = getConnect();
        $statement = $connect->prepare("DELETE FROM rss_subs where user_id = ? and rss_id = ?");
        $statement->bind_param("ii", $user_id, $rss_id);
        $statement->execute();
        $statement->close();
        closeConnect($connect);
        return true;
    } else {
        return false;
    }
}

function getTitle($rss_url)
{
    $feeds = file_get_contents($rss_url);
    $rss = simplexml_load_string($feeds);
    return $rss->channel->title;
}

function getConnect()
{
    return mysqli_connect('localhost',
        'root',
        'fe5jvsmz',
        'Elizarov2002');
}

function closeConnect(mysqli $connect)
{
    $connect->commit();
    $connect->close();
}