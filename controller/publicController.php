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

    # ICI
    var_dump($recupPost);

// si on est sur la partie catégorie
}elseif(isset($_GET['categoryId'])&&ctype_digit($_GET['categoryId'])){    


// si on est sur la partie utilisateur
}elseif(isset($_GET['userId'])&&ctype_digit($_GET['userId'])){ 


// sinon on est sur l'accueil    
}else{
    # homepage's datas from MODEL
    $recupAllPost = postHomepageAll($db);

    # Post count
    $nbPost = count($recupAllPost);


    # homepage's view from VIEW
    require "../view/publicView/publicHomepageView.php";
}