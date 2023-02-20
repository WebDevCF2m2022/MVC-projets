<?php

/**
 * @param $db
 * @param int $id
 * @return array|NULL
 */
function getOneUser($db, int $id): array|NULL{
    $sql ="SELECT id, username,userscreen FROM user WHERE id = $id";
    try {
        $request = mysqli_query($db, $sql);
    }catch(Exception $e){
        exit($e->getMessage());
    }
    return mysqli_fetch_assoc($request);
}