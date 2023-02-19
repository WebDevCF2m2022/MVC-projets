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

    # if no Post
    if(is_null($recupPost)){
        $detailError = "Cet article n'existe plus ! ";
        require "../view/publicView/public404View.php";
        exit();
    }

    # detail's post view from VIEW
    require "../view/publicView/publicPostDetailView.php";;

// si on est sur la partie catégorie
}elseif(isset($_GET['categoryId'])&&ctype_digit($_GET['categoryId'])){

    $idcateg = (int) $_GET['categoryId'];
    $categ = selectOneCategoryById($db,$idcateg);
    # if no Category
    if(is_null($categ)) {
        $detailError = "Cette catégorie n'existe plus ";
        require "../view/publicView/public404View.php";
        exit();
    }
    $recupAllPost = postRubriqueAll($db,$idcateg);
    # Post count
    $nbPost = count($recupAllPost);
    require "../view/publicView/publicCategoryView.php";

// si on est sur la partie utilisateur
}elseif(isset($_GET['userId'])&&ctype_digit($_GET['userId'])){

    $detailError = "La page utilisateur n'est pas encore créée ";
    require "../view/publicView/public404View.php";
    exit();

// sinon on est sur l'accueil    
}else{
    # homepage's datas from MODEL
    $recupAllPost = postHomepageAll($db);

    # Post count
    $nbPost = count($recupAllPost);


    # homepage's view from VIEW
    require "../view/publicView/publicHomepageView.php";
}