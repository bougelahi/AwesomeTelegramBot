<?php
require 'vendor/autoload.php';


use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;


function saveUser(Api $telegram, Update $update)
{
    $db_connect = getConnect();

    $id = $update->getMessage()->getChat()->getId();
    $username = $update->getMessage()->getChat()->getUsername();
    $firstName = $update->getMessage()->getChat()->getFirstName();
    $lastName = $update->getMessage()->getChat()->getLastName();

    $statement = $db_connect->prepare("call saveUser(?,?,?,?)");
    $statement->bind_param("isss", $id, $username, $firstName, $lastName);
    $statement->execute();

    closeConnect($db_connect);
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