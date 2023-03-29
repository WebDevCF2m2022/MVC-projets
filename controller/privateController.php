<?php
# debug with file's name
# echo __FILE__;
# var_dump($_SESSION);

if(isset($_GET['disconnect'])){

    // si déconnexion renvoie true
    if(deconnect()){
        // redirection
        header("Location: ./");
    }

}else{
    // appel due la méthode (fonction) modèle PostModel pour afficher tous les articles SANS restrictions
    $postAll = postAdminHomepageAll($connectPDO);
    // on compte le nombre d'articles
    $postCount = count($postAll);
    // appel de la vue de l'accueil
    include "../view/privateView/privateHomepageView.php";
}