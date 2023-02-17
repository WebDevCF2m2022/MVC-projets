<?php

/**
 * Public homepage function All Posts
 * @param mysqli $db
 * @return array|Exception
 */
function postHomepageAll(mysqli $db): array|Exception{
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
        /* WHERE p.id =77 */
            GROUP BY p.id, p.datecreate
    ORDER BY p.datecreate DESC;";

    try{
        $query = mysqli_query($db,$sql);
    }catch(Exception $e){
        die($e->getMessage());
    }
    return mysqli_fetch_all($query,MYSQLI_ASSOC);
}


/**
 * Public detail Post by id
 *
 * @param mysqli $db
 * @param int $id
 * @return array|Exception
 */
function postOneById(mysqli $db, int $id): array|Exception|null{

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


// cut the text
/**
 * @param string $txt
 * @return string
 */
function cutTheText(string $txt): string {
    // find the position of the last space in the string, give an int or false if not found
    $lastSpaceNb = strrpos($txt," ");
    // if false we return the original text
    if($lastSpaceNb===false) return $txt;
    // if true we cut the text and return it
    return substr($txt,0,$lastSpaceNb);
}

// date fr (non object function, see this page for alternatives https://www.php.net/manual/fr/book.datetime.php )
/**
 * @param string $date
 * @return string
 */
function datetimeToFrench(string $date): string {
    // create a timestamp from a datetime
    $timestamp = strtotime($date);
    // arrays with french values
    $semaine = [" Dimanche "," Lundi "," Mardi "," Mercredi "," Jeudi ",
        " vendredi "," samedi "];
    $mois = [1=>" janvier "," février "," mars "," avril "," mai "," juin ",
        " juillet "," août "," septembre "," octobre "," novembre "," décembre "];
    // return french date
    return $semaine[date("w",$timestamp)]." ".date("d",$timestamp)." ".$mois[date("n",$timestamp)]." ".date("Y \à H \h i",$timestamp);
}

/**
 * create real links on URL
 * @param string $text
 * @return string
 */
function createURL(string $text): string{
    return preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"\\2\" target=\"_blank\" rel=\"nofollow\">\\2</a>", $text);
}