<?php

require "../config.php";

try{
    $db = mysqli_connect(DB_HOST,DB_LOGIN,DB_PWD,DB_NAME,DB_PORT);
}catch(Exception $e){

}