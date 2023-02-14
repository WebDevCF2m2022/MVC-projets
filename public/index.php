<?php
# Dependencies
require_once "../config.php";# DB
require_once "../model/PostModel.php";# table post

# Connexion
try{
    $db = mysqli_connect(DB_HOST,DB_LOGIN,DB_PWD,DB_NAME,DB_PORT);
    mysqli_set_charset($db,DB_CHARSET);
}catch(Exception $e){
    exit($e->getMessage());
}

# Router

// connected
if(false){
    require_once "../controller/privateController.php";
  
// public
}else{
    require_once "../controller/publicController.php";
}


# good practice
mysqli_close($db);