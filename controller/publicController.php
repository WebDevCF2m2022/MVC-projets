<?php
/**
 * public
 */
# debug with file's name
# echo __FILE__;

# récupération du menu
$recupMenu = getAllCategoryMenu($connectPDO);

// si on est sur la partie "lire la suite" - détail de l'article
if (isset($_GET['postId'])&&ctype_digit($_GET['postId'])) {

    $idpost = (int) $_GET['postId'];
    # one article by id
    $recupPost = postOneById($connectPDO,$idpost);

    if(is_bool($recupPost)){
        // création de l'erreur pour la 404
        $error = "Cet article n'existe plus";
        // appel de la vue 404
        include_once "../view/publicView/404View.php";
       
    // on a trouvé l'article    
    }else{

        // appel de la vue de l'article complet
        require_once('../view/publicView/detailView.php');
}

// si on est sur la partie catégorie
}elseif(isset($_GET['categoryId'])&&ctype_digit($_GET['categoryId'])){   
    
    $id = (int) $_GET['categoryId'];

    $recupcateg=recupCategoryById($connectPDO,$id);

    // si 404 $recupcateg == null
    if(is_null($recupcateg)){
        // création de l'erreur pour la 404
        $error = "Cet catégorie n'existe plus";
        // appel de la vue 404
        include_once "../view/publicView/404View.php";

    }else{
        $recupAllPost = postByCategoryId($connectPDO, $id);

        # Post count

        $nbPost = count($recupAllPost);


        include_once("../view/publicView/publicCategorieView.php");
}

// si on est sur la partie utilisateur
}elseif(isset($_GET['userId'])&&ctype_digit($_GET['userId'])){ 

    $iduser = (int) $_GET['userId'];
    $user = getOneUserById($connectPDO,$iduser);

    // si 404 $user == null
    if(is_bool($user)){
        // création de l'erreur pour la 404
        $error = "Cet utilisateur n'existe plus";
        // appel de la vue 404
        include_once "../view/publicView/404View.php";
    }else{

        $recupAllPost = postByUserId($connectPDO,$iduser);

        # Post count
        $nbPost = count($recupAllPost);

        include_once "../view/publicView/publicUserView.php";
    }

// si on veut se connecter
}elseif(isset($_GET['connect'])){ 

    // si la personne a envoyé le formulaire
    if(isset($_POST['username'],$_POST['userpwd'])){
        $connect = connectUserByUsername($connectPDO,
                                $_POST['username'],
                                $_POST['userpwd']
                            );
        // si $connect est du texte
        if(is_string($connect)) {
            $message = $connect;
        // sinon (par défaut un booléen)
        }else{
            header("Location: ./");
            exit();
        }
    }

    # View
    include "../view/publicView/connectView.php";

// sinon on est sur l'accueil    
}else{
    # homepage's datas from MODEL
    $recupAllPost = postHomepageAll($connectPDO);

    # Post count
    $nbPost = count($recupAllPost);


    # homepage's view from VIEW
    require "../view/publicView/publicHomepageView.php";
}