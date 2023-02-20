<?php
// public homepage function All Posts
function postHomepageAll($db){
    $sql = "SELECT p.id, p.title, LEFT(p.content, 255) AS contentshort, p.datecreate, u.id AS iduser, u.userscreen, 
    GROUP_CONCAT(c.id) AS idcategory, 
    GROUP_CONCAT(c.title SEPARATOR '||0||') AS titlecategory
    FROM post p
        INNER JOIN user u
            ON p.user_id = u.id
        LEFT JOIN category_has_post h 
            ON p.id = h.post_id
        LEFT JOIN category c 
            ON c.id = h.category_id
        #WHERE p.id =77
            GROUP BY p.id
    ORDER BY p.datecreate DESC;";

    try{
        $query = mysqli_query($db,$sql);
    }catch(Exception $e){
        die($e->getMessage());
    }
    return mysqli_fetch_all($query,MYSQLI_ASSOC);
}

// public detail Post by id
function postOneById($db,$id){
    // si mauvais format : 0
    $id = (int) $id;

    $sql = "SELECT p.id, p.title, p.content, p.datecreate, 
    u.id AS iduser, u.userscreen, 
    GROUP_CONCAT(c.id) AS idcategory, 
    GROUP_CONCAT(c.title SEPARATOR '||0||') AS titlecategory
    FROM post p
        INNER JOIN user u
            ON p.user_id = u.id
        LEFT JOIN category_has_post h 
            ON p.id = h.post_id
        LEFT JOIN category c 
            ON c.id = h.category_id
        WHERE p.id = $id
            GROUP BY p.id;";

    try{
        $query = mysqli_query($db,$sql);
    }catch(Exception $e){
        die($e->getMessage());
    }
    return mysqli_fetch_assoc($query);
}

// public homepage function All Posts
function postCategory($db,int $idcateg){
    $sql = "SELECT p.id, p.title, LEFT(p.content, 255) AS contentshort, p.datecreate, u.id AS iduser, u.userscreen, 
    GROUP_CONCAT(c2.id) AS idcategory, 
    GROUP_CONCAT(c2.title SEPARATOR '||0||') AS titlecategory
    FROM post p
        INNER JOIN user u
            ON p.user_id = u.id
        LEFT JOIN category_has_post h 
            ON p.id = h.post_id
        LEFT JOIN category c 
            ON c.id = h.category_id
        /* ici l'alias est très utile, il permet d'ajouter les catégories en évitant le blocage de l'autre jointure car WHERE c.id = $idcateg, c2.id est comme venant d'une autre table */    
        LEFT JOIN category_has_post h2 
            ON p.id = h2.post_id
        LEFT JOIN category c2 
            ON c2.id = h2.category_id
        WHERE c.id = $idcateg
            GROUP BY p.id
    ORDER BY p.datecreate DESC;";

    try{
        $query = mysqli_query($db,$sql);
    }catch(Exception $e){
        die($e->getMessage());
    }
    return mysqli_fetch_all($query,MYSQLI_ASSOC);
}

// truncate text

// date fr
