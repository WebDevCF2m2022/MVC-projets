<?php
# debug with file's name
# echo __FILE__;
# var_dump($_SESSION);

if (isset($_GET['disconnect'])) {
    // si déconnexion renvoie true
    if (deconnect()) {
        // redirection
        header("Location: ./");
        exit();
    }

// on veut rapidement activer ou désactiver un article depuis l'accueil de l'admin    
}elseif(isset($_GET['postVisible'],$_GET['id'])
    &&ctype_digit($_GET['postVisible'])
    &&ctype_digit($_GET['id'])
    ){
    $postId = (int) $_GET['id'];
    $postVisible = (int) $_GET['postVisible'];

    if (postAdminUpdateVisible($connectPDO, $postId, $postVisible)) {
        header("Location: ./?m=L'article dont l'id est $postId a été modifié");
        exit();
    } else {
        header("Location: ./?m=Problème lors de la modification de l'article!");
        exit();
    }

// on veut ajouter un Post   
}elseif(isset($_GET['createPost'])){

    // si on a envoyé le formulaire d'insertion
    if(isset($_POST['title'],$_POST['content'],$_POST['user_id'])){
        $UserId = (int) $_POST['user_id']; // si erreur => 0
        $postTitle = htmlspecialchars(strip_tags(trim($_POST['title'])),ENT_QUOTES);
        $postContent = htmlspecialchars(strip_tags(trim($_POST['content'])),ENT_QUOTES);
        // ternaire ! si tableau les valeurs et clefs ne sont pas protégée contre une manipulation externe (injection etc...)
        $idCateg = (isset($_POST['category_id'])&&is_array($_POST['category_id']))? $_POST['category_id'] : [];

    if(!empty($UserId)&&!empty($postTitle)&&!empty($postContent)) {
        //  Pouvoir insérer un article AVEC ses catégories
        $insert = postAdminInsert($connectPDO, $UserId, $postTitle, $postContent, $idCateg);
        if($insert===true){
            $message = "Article inséré dans la DB";
        }
    }
    }

    // Appel des catégories pour le multi-choix dans le formulaire
    $categoryChoice = getAllCategoryMenu($connectPDO);

    // Appel des utilisateurs
    $userChoice = getAllUsers($connectPDO);

    // appel de la vue pour insertion
    include "../view/privateView/privateInsertView.php";

// on veut modifier un Post   
}elseif(isset($_GET['updatePost'])&&ctype_digit($_GET['updatePost'])){

    // si on a envoyé le formulaire de modification
    if(isset($_POST['title'])){
        // pas de vérification des variables $_POST au niveau du contrôleur !!! -> TOUTES LES Vérification doivent se trouver dans la fonction ! 
        $post = postAdminUpdate($connectPDO,$_POST); 
        // si le retour est une chaîne de caractère
        if(is_string($post)){
            // affichage de l'erreur
            $message = $post;
        }
        // dans changements ont été effectués
        if($post===true){
            $message = "L'article a bien été modifié<script>
            setTimeout(\"location.href = './';\", 2000);
             </script>";
        }
    }

    $idUpdatePost = (int) $_GET['updatePost'];

    // chargement de l'article
    # one article by id
    $recupPost = postOneById($connectPDO,$idUpdatePost);

    if(is_bool($recupPost)){
        # récupération du menu pour l'erreur 404
        $recupMenu = getAllCategoryMenu($connectPDO);
        // création de l'erreur pour la 404
        $error = "Cet article n'existe plus";
        // appel de la vue 404
        include_once "../view/publicView/404View.php";
       
    // on a trouvé l'article    
    }else{

    // Appel des catégories pour le multi-choix dans le formulaire
    $categoryChoice = getAllCategoryMenu($connectPDO);

    // Appel des utilisateurs
    $userChoice = getAllUsers($connectPDO);

    // appel de la vue pour insertion
    include "../view/privateView/privateUpdateView.php";
}

// on veut supprimer un post    
}elseif(isset($_GET['deletePost'])&&ctype_digit($_GET['deletePost'])){

    $postId = (int) $_GET['deletePost'];

    if(postAdminDeleteById($connectPDO,$postId)){
        header("Location: ./?m=L'article dont l'id est $postId a été supprimé");
        exit();
    }else{
        header("Location: ./?m=Problème lors de la modification de l'article!");
        exit();
    }

    
// accueil    
}else{
    // appel due la méthode (fonction) modèle PostModel pour afficher tous les articles SANS restrictions
    $postAll = postAdminHomepageAll($connectPDO);
    // on compte le nombre d'articles
    $postCount = count($postAll);
    // appel de la vue de l'accueil
    include "../view/privateView/privateHomepageView.php";
}