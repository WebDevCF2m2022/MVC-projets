<?php



/**
 * 
 * @param mysqli $mydb
 * @param int $iduser
 * 
 * @return array|null
 */
function getOneUserById(mysqli $mydb, int $iduser): array|null {

    $sql="SELECT id, username, userscreen FROM user WHERE id=$iduser";
    try{
        $query = mysqli_query($mydb,$sql);
    }catch(Exception $e){
        die($e->getMessage());
    }
    return mysqli_fetch_assoc($query);
}