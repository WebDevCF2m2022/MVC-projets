<?php
/**
 * public
 */
# debug with file's name
# echo __FILE__;

# récupération du menu
$recupMenu = getAllCategoryMenu($db);

// si on est sur la partie "lire la suite" - détail de l'article
if (isset($_GET['postId'])&&ctype_digit($_GET['postId'])) {

    $idpost = (int) $_GET['postId'];
    # one article by id
    $recupPost = postOneById($db,$idpost);

    if(is_null($recupPost)){
        // création de l'erreur pour la 404
        $error = "Cet article n'existe plus";
        // appel de la vue 404
        include_once "../view/publicView/404View.php";
        
    }else{

        require_once('../view/publicView/detailView.php');
}

// si on est sur la partie catégorie
}elseif(isset($_GET['categoryId'])&&ctype_digit($_GET['categoryId'])){   
    
    $id = (int) $_GET['categoryId'];

    $recupcateg=recupAll($db,$id);

    // si 404 $recupcateg == null
    if(is_null($recupcateg)){
        // création de l'erreur pour la 404
        $error = "Cet catégorie n'existe plus";
        // appel de la vue 404
        include_once "../view/publicView/404View.php";

    }else{
        $recupAllPost = postByCategoryId($db, $id);

        # Post count

        $nbPost = count($recupAllPost);


        include_once("../view/publicView/publicCategorieView.php");
}

// si on est sur la partie utilisateur
}elseif(isset($_GET['userId'])&&ctype_digit($_GET['userId'])){ 

    $iduser = (int) $_GET['userId'];
    $user = getOneUserById($db,$iduser);

    // si 404 $user == null
    if(is_null($user)){
        // création de l'erreur pour la 404
        $error = "Cet utilisateur n'existe plus";
        // appel de la vue 404
        include_once "../view/publicView/404View.php";
    }else{

        $recupAllPost = postByUserId($db,$iduser);

        # Post count
        $nbPost = count($recupAllPost);

        include_once "../view/publicView/publicUserView.php";
    }



// sinon on est sur l'accueil    
}else{
    # homepage's datas from MODEL
    $recupAllPost = postHomepageAll($db);

    # Post count
    $nbPost = count($recupAllPost);


    # homepage's view from VIEW
    require "../view/publicView/publicHomepageView.php";
}