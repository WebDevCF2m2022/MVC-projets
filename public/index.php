<?php
# PHP SESSION CONNECT
session_start();

# Dependencies
require_once "../config.php";# DB
require_once "../model/PostModel.php";# table post
require_once "../model/CategoryModel.php";# table category
require_once "../model/UserModel.php";# table user


# Connexion PDO
try {
    $connectPDO = new PDO(
        DB_TYPE.':host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.';charset='.DB_CHARSET,
        DB_LOGIN,
        DB_PWD
    );
    // sur certains serveurs, l'affichage d'erreur est désactivé par défaut pour le driver (extension) PDO, ici on va choisir l'activation si on est en mode dev ou test, mais pas en prod (production voir config.php)
    if(ENV=="dev"||ENV=="test"){
        // activation de l'affichage des erreurs
        $connectPDO->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }

}catch(Exception $e){
    die($e->getMessage());

}


# Router

// connected
if(isset($_SESSION['myID'])&&$_SESSION['myID']==session_id()){
    require_once "../controller/privateController.php";
  
// public
}else{
    require_once "../controller/publicController.php";
}


# good practice
$connectPDO = null;