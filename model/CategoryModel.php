<?php
# menu - to PDO with query
function getAllCategoryMenu(PDO $db): array {
    $sql ="SELECT id, title FROM category ORDER BY id ASC";
    try{
        $query=$db->query($sql);
    }catch(Exception $e){
        die($e->getMessage());
    }
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// récupère une catégorie complète
function recupCategoryById(PDO $db,int $id):array|bool{
    $recup = "SELECT * FROM category where id=?";
    $prepare = $db -> prepare($recup);
    try{
        $prepare->execute([$id]);
    }catch(Exception $e){
        die($e->getMessage());
    }
    $bp = $prepare->fetch(PDO::FETCH_ASSOC);
    $prepare->closeCursor();
    return $bp;
}

