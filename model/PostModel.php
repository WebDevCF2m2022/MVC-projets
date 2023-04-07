<?php
// public homepage function All Posts if visible = 1
function postHomepageAll(PDO $db): array{
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
        WHERE p.visible = 1
            GROUP BY p.id
    ORDER BY p.datecreate DESC, p.id DESC;";

    try{
        $query = $db->query($sql);
    }catch(Exception $e){
        die($e->getMessage());
    }
    // création d'une variable qui contient le résultat pour retirer le return de cette ligne (bp -> bonne pratique)
    $bp = $query->fetchAll(PDO::FETCH_ASSOC);
    // remet le curseur au début du jeu de résultat pour les DB compatibles, efface le résultat sous mysql et mariadb, il est donc facultatif mais recommandé
    $query->closeCursor();
    // on renvoie le résultat après la fermeture du jeu de résultat
    return $bp;
}

// public detail Post by id
// ?array < PHP 8
// array|null > PHP 8
function postOneById(PDO $db, int $id): array|bool{
    // si mauvais format : 0
    // $id = (int) $id;

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
        WHERE p.id = ?
            GROUP BY p.id;";

    try{
        $prepare = $db->prepare($sql);
        // mettre la valeur dans un tableau ne permet pas de vérifier ni le type ni la taille, c'est un raccourci de bindValue
        $query = $prepare->execute([$id]);
    }catch(Exception $e){
        die($e->getMessage());
    }
    $bp = $prepare->fetch(PDO::FETCH_ASSOC);
    $prepare->closeCursor();
    return $bp;

}

// public post by category id
function postByCategoryId(PDO $db,int $idcateg): array{
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
        WHERE c.id = :id
            GROUP BY p.id
    ORDER BY p.datecreate DESC;";

    $prepare = $db->prepare($sql);
    $prepare->bindValue(':id',$idcateg,PDO::PARAM_INT);
    try{
        $prepare->execute();
    }catch(Exception $e){
        die($e->getMessage());
    }
    $return = $prepare->fetchAll(PDO::FETCH_ASSOC);
    $prepare->closeCursor();
    return $return;
}

// public post by user id
function postByUserId(PDO $db,int $iduser): array{
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
       
        WHERE u.id = ?
            GROUP BY p.id
    ORDER BY p.datecreate DESC;";
    $prepare = $db->prepare($sql);
    try{
        $prepare->execute([$iduser]);
    }catch(Exception $e){
        die($e->getMessage());
    }
    $return = $prepare->fetchAll(PDO::FETCH_ASSOC);
    $prepare->closeCursor();
    return $return;
}

// cut the text
    function trunCate (string $text): string{
    // fonction qui trouve un numérique qui est la dernière sous chaine dans une chaine pour remplacer $cut : " "
    $cut = strrpos($text, ' ');
    return substr ($text, 0,$cut);
}
// date fr
  // Convertit une date ou un timestamp en français//
  function dateToFrench(string $date, string $format="l j F Y \à h \h i "): string{
    $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    $french_days = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche');
    $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
    return str_replace($english_months, $french_months, str_replace($english_days, $french_days, date($format, strtotime($date) ) ) );}


    /*
ADMIN FUNCTIONS
    */

// private admin homepage function All Posts
function postAdminHomepageAll(PDO $db): array{
    $sql = "SELECT p.id, p.title, LEFT(p.content, 255) AS contentshort, p.datecreate, p.visible,
    u.id AS iduser, u.userscreen, 
    GROUP_CONCAT(c.id) AS idcategory, 
    GROUP_CONCAT(c.title SEPARATOR '||0||') AS titlecategory
    FROM post p
        LEFT JOIN user u
            ON p.user_id = u.id
        LEFT JOIN category_has_post h 
            ON p.id = h.post_id
        LEFT JOIN category c 
            ON c.id = h.category_id
            #WHERE p.id =150
            GROUP BY p.id
        
    ORDER BY p.datecreate DESC, p.id DESC;";

    try{
        $query = $db->query($sql);
    }catch(Exception $e){
        die($e->getMessage());
    }
    // création d'une variable qui contient le résultat pour retirer le return de cette ligne (bp -> bonne pratique)
    $bp = $query->fetchAll(PDO::FETCH_ASSOC);
    // remet le curseur au début du jeu de résultat pour les DB compatibles, efface le résultat sous mysql et mariadb, il est donc facultatif mais recommandé
    $query->closeCursor();
    // on renvoie le résultat après la fermeture du jeu de résultat
    return $bp;
}
// changement de la visibilité d'un post sur la page d'accueil de l'admin
function postAdminUpdateVisible(PDO $db, int $id, int $visible):bool{
    $sql="UPDATE `post` SET `visible` = ? WHERE `id` = ?;";
    $prepare = $db->prepare($sql);
    try{
        $prepare->execute([$visible,$id]);
    }catch(Exception $e){
        die($e->getMessage());
    }
    return $prepare->rowCount();
}

// pour supprimer un post
function postAdminDeleteById(PDO $db, int $id): bool {
    // pour utiliser l'exec plutôt que le prepare/execute, mauvaise pratique
    $sql="DELETE FROM `post` WHERE id=$id";

    try{
        // envoie 1 en cas de réussite (nb de lignes affectées par exec), 0 en cas d'échec -> true ou false
        return ($db->exec($sql))? true : false;
    }catch(Exception $e){
        die($e->getMessage());
    }

}

// ON EST LA // EXERCICE Pouvoir insérer un article AVEC ses catégories, si possible avec une transaction
function postAdminInsert(PDO $db, int $idUser, string $title, string $content, array $idCateg=[]):bool{
    $db->beginTransaction();
    try{
    $sql = $db->prepare("INSERT INTO post (title, content, user_id) VALUES (?,?,?)");
    $sql->bindParam(1,$title,PDO::PARAM_STR);
    $sql->bindParam(2,$content,PDO::PARAM_STR);
    $sql->bindParam(3,$idUser,PDO::PARAM_INT);
    $sql->execute();
    $idLastPost = $db->lastInsertId();
    #$db->commit();
    if(!empty($idCateg)){
    #$db->beginTransaction();
    $sqlPostHasCategory = $db->prepare("INSERT INTO category_has_post (category_id,post_id) VALUES (?,?)");
    foreach ($idCateg as  $item){
       /* foreach ($pr as $key => &$val) {
            $csql->bindParam($key, $val);
        }*/
        if(ctype_digit(($item))){
    
    $sqlPostHasCategory->bindParam(1,$item,PDO::PARAM_INT);
    $sqlPostHasCategory->bindParam(2,$idLastPost,PDO::PARAM_INT);
    
    $sqlPostHasCategory->execute();
        }
    }
    }
    $db->commit();
    /*echo "idCateg";
    var_dump($idCateg);
    echo "idUser";
    var_dump($idUser);
    echo "idLastPost";
    var_dump($idLastPost);*/
    
}catch(Exception $e){
    $e = "Un problème est survenu lors de l'ajout de votre article ";
    $db->rollBack();

   }

    
    return true;
}