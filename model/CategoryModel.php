<?php
# menu
function getAllCategoryMenu(mysqli $db): array {
    $sql ="SELECT id, title FROM category ORDER BY id ASC";
    try{
        $query=mysqli_query($db,$sql);
    }catch(Exception $e){
        die($e->getMessage());
    }
    return mysqli_fetch_all($query,MYSQLI_ASSOC);
}

// récupère une catégorie complète
function recupCategoryById(mysqli $db,int $id):array|null{
    $recup = "SELECT * FROM category where id=$id";
    try{
        $query=mysqli_query($db,$recup);
    }catch(Exception $e){
        die($e->getMessage());
    }
    return mysqli_fetch_assoc($query);
}

