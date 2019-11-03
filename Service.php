<?php

require "vendor/autoload.php";

use Telegram\Bot\Objects\Update;

class Service
{
    private $db_connect;

    function setMessage(Update $update)
    {
        $chat_id = $update->getMessage()->getChat()->getId();
        $text = $update->getMessage()->getText();
        $query = "INSERT INTO Messages (chat_id, text) VALUES ($chat_id, '$text')";
        $this->db_connect->query($query);
        $this->db_connect->commit();
    }

    function setUser(Update $update)
    {
        $chat_id = $update->getMessage()->getChat()->getId();
        $username = $update->getMessage()->getChat()->getUsername();
        $first_name = $update->getMessage()->getChat()->getFirstName();
        $last_name = $update->getMessage()->getChat()->getLastName();
        $query = "INSERT INTO Users (chat_id, username, first_name, last_name)
                  VALUES ('$chat_id', '$username', '$first_name', '$last_name') ON DUPLICATE KEY
                  UPDATE username = '$username',
                  first_name = '$first_name',
                  last_name = '$last_name'";

        $this->db_connect->query($query);
        $this->db_connect->commit();
    }

    function __construct()
    {
        $this->db_connect = mysqli_connect('localhost', 'root', 'fe5jvsmz', 'Elizarov2002');
        $this->db_connect->set_charset('utf8');
    }

    function __destruct()
    {
        $this->db_connect->close();
    }

}