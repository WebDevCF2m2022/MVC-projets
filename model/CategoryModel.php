<?php
# menu
function getAllCategoryMenu($db){
    $sql ="SELECT id, title FROM category ORDER BY id ASC";
    try{
        $query=mysqli_query($db,$sql);
    }catch(Exception $e){
        die($e->getMessage());
    }
    return mysqli_fetch_all($query,MYSQLI_ASSOC);
}