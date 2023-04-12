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

//  Pouvoir insérer un article AVEC ses catégories, AVEC une transaction
function postAdminInsert(PDO $db, int $idUser, string $title, string $content, array $idCateg=[]):bool{
    // début de transaction, arrête les autocommit, il faut appeler $db->commit() pour que toutes les requêtes soient effectivement validées
    $db->beginTransaction();
    // requêtes préparées contre les injections SQL (! au tableau $idCateg, on peut falsifier son contenu)
    $preparePost = $db->prepare("INSERT INTO `post` (`title`,`content`,`user_id`) VALUES (:title, :content, :iduser)");

    $preparePost->bindValue(":iduser", $idUser, PDO::PARAM_INT);
    $preparePost->bindValue(":title", $title, PDO::PARAM_STR);
    $preparePost->bindValue(":content", $content, PDO::PARAM_STR);

    // insertion du Post

    $preparePost->execute();

    // récupération immédiate de l'id inséré par la connexion de l'utilisateur actuel (table Post)
    $postLastInsertId = $db->lastInsertId();


    // pour insérer les catégories dans la table M2M, on ne garde que les valeurs qui doivent être des integer dans des champs category_has_post

    // si le tableau n'est pas vide (catégories potentielles)
if(!empty($idCateg)){

    // requête préparée
    $prepareCategory_has_post = $db->prepare("INSERT INTO `category_has_post` (`category_id`,`post_id`) VALUES (:idcateg, :idpost)");
    // $valeur par défaut (sera remplacée en cas de validité du tableau)
    $categId = 100;

    // attribution des valeurs par référence, $value est donc une valeur par défaut qui ne sera pas utilisée
    $prepareCategory_has_post->bindParam("idpost",$postLastInsertId,PDO::PARAM_INT);
    $prepareCategory_has_post->bindParam("idcateg",$categId,PDO::PARAM_INT);

    foreach ($idCateg as $value) {
        if(ctype_digit($value)){
            $categId = (int) $value;
            $prepareCategory_has_post->execute();
        }
    }

}

    try{
        // on essaye d'envoyer toutes nos requêtes à la DB
        $db->commit();
        return true;
    }catch(Exception $e){
        // si une erreur dans au moins 1 requête
        // on les annule toutes
        $db->rollBack();
        die($e->getMessage());
    }

}

// on veut modifier un post, avec les catégories qui ne se trouvent pas dans la table post: action avec plusieures requêtes = transaction
function postAdminUpdate(PDO $db, array $postForm): bool|string {
    // on est ICI et aucune variable n'a PAS été vérifiée !
    # var_dump($postForm); 

    // si il n'existe pas de post 'id' (champs caché) ou qu'il ne correspond pas au champs dans l'URL (hack)
    if(!isset($postForm['id'])||$postForm['id']!=$_GET['updatePost']){
        return "Le champs id ne correspond pas !";
    }

    // pour récupérer les variables on peut utiliser extract 
    // !!! c'est un danger de sécurité, ici on l'utilise car seul l'admin a accès au formulaire
    // on va utiliser un préfix 'myPostTable' pour éviter toute collision
    // doc : https://www.php.net/manual/fr/function.extract.php

    extract($postForm,EXTR_PREFIX_ALL,"myPostTable");
    // echo $myPostTable_id;

    // protection des variables (l'extract est donc peu utile dans notre cas):
    $myPostTable_id = (int) $myPostTable_id;
    $myPostTable_title = htmlspecialchars(strip_tags(trim($myPostTable_title)),ENT_QUOTES);
    $myPostTable_content = htmlspecialchars(strip_tags(trim($myPostTable_content)),ENT_QUOTES);
    // transforme en timestamp, retourne false en cas d'échec - doc : https://www.php.net/manual/fr/function.strtotime.php
    $myPostTable_datecreate = strtotime($myPostTable_datecreate); 
    $myPostTable_user_id = (int) $myPostTable_user_id;

    // si tout est valide
    if(!empty($myPostTable_id)&&!empty($myPostTable_title)&&!empty($myPostTable_content)&&!empty($myPostTable_user_id)&& $myPostTable_datecreate!=false){
        // converstion de timestamp en datetime
        $myPostTable_datecreate_datetime = date("Y-m-d H:i:s",$myPostTable_datecreate);
        // début de transaction
        $db->beginTransaction();
        // on écrit la requête
        $sql = "UPDATE `post` SET `title` = :title, `content` = :texte, `datecreate` = :datecreate, `user_id` = :userid
                WHERE `id` = :id ;
        ";
        // on prépare la requête
        $postUpdate = $db->prepare($sql);

        // attribution des valeurs
        $postUpdate->bindValue(':id',$myPostTable_id,PDO::PARAM_INT);
        $postUpdate->bindValue(':title',$myPostTable_title);
        $postUpdate->bindValue(':texte',$myPostTable_content);
        $postUpdate->bindValue(':datecreate',$myPostTable_datecreate_datetime);
        $postUpdate->bindValue(':userid',$myPostTable_user_id,PDO::PARAM_INT);

        // exécution de la requête
        $postUpdate->execute();

        // on doit supprimer les relations m2m avec de category_has_post pour pouvoir effectuer le changement si il y en a
        $db->exec("DELETE FROM `category_has_post` WHERE `post_id` = $myPostTable_id");

        // une ou des catégories sont cochées
        if(isset($postForm['category_id'])){
            // préparation de la requête
            $sql = "INSERT INTO `category_has_post` (`category_id`, `post_id`) VALUES ";
            foreach($postForm['category_id'] as $item){
                $sql .= (ctype_digit($item))? "(". (int) $item .", $myPostTable_id)," : "";
            }
            $sql = substr($sql,0,-1);
            $db->exec($sql);
        }

        // fermeture de transaction (l'autocommit est réactivé si aucun commit n'est présent en fin de page )
        try{
            // soumission
            $db->commit();
            // envoie d'un bool
            return true;
        }catch(Exception $e){
            // bonne pratique - retour en arrière
            $db->rollBack();
            // on aurait pu envoyer false, mais comme on affiche les erreurs au format texte
            return $e->getMessage();
        }

    }else{
        return "Un des champs n'est pas au format valide";
    }


    return true;
}