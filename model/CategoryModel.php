<?php
# menu

/**
 * @param mysqli $db
 * @return array
 */
function getAllCategoryMenu(mysqli $db):array{
    $sql ="SELECT id, title FROM category ORDER BY id ASC";
    try{
        $query=mysqli_query($db,$sql);
    }catch(Exception $e){
        die($e->getMessage());
    }
    return mysqli_fetch_all($query,MYSQLI_ASSOC);
}


/**
 * @param mysqli $db
 * @param int $id
 * @return array|null
 */
function selectOneCategoryById(mysqli $db, int $id):array|null{
    $sql ="SELECT * FROM category WHERE id=$id";
    try{
        $query=mysqli_query($db,$sql);
    }catch(Exception $e){
        die($e->getMessage());
    }
    return mysqli_fetch_array($query);
}