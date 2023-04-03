<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>DB - BDD : Les bases de données <?=$user["userscreen"]?></title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
<?php
// fonctionne pour les include / require - chemin relatif
include_once "inc/menuPublicView.php";

?>
<!-- Page content-->
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8">

                <!-- Post header-->
                <header class="mb-4">
                    <!-- Post title-->
                    <h1 class="fw-bolder mb-1">DB - BDD : <?=$user["userscreen"]?></h1>
                    <!-- Post meta content-->
                    
                    <p class="fs-5 mb-4">Site de préparation du travail de groupe du <a href="https://github.com/WebDevCF2m2022/MVC-projets" target="_blank">CF2m</a> utilisant des morceaux d'articles libres depuis <a href="https://fr.wikipedia.org/wiki/Wikip%C3%A9dia:Accueil_principal" target="_blank">Wikipédia</a>. Les spécifications techniques sont : MVC avec un dossier publique, PHP 8 procédural et MariaDB.</p>
                    <p class="fs-5 mb-4"><?=$user["userscreen"]?> | <?=$user["username"]?></p>
                    <?php // var_dump($_GET) ?>
                </header>

            <?php
            if(empty($nbPost)):
                ?>
                <h2 class="fw-bolder mb-1">Pas encore de message</h2>
            <?php
            else:
                ?>
                <h2 class="fw-bolder mb-1">Nous avons <?=$nbPost?> article(s)</h2>
                <?php
                foreach($recupAllPost as $item):
                    ?>
                    <!-- Post content-->
                    <article>
                        <section class="mb-5">
                            <h2 class="fw-bolder mb-4 mt-5"><?=$item['title']?></h2>
                            <div class="text-muted fst-italic mb-2">Posté par <a href="?userId=<?=$item['iduser']?>"><?=$item['userscreen']?></a> le <?=dateToFrench($item['datecreate'])?></div>
                            <!-- Post categories-->
                            <?php
                        // on a des catégories    
                        if(!is_null($item['idcategory'])):
                            $idcategory = explode(',',$item['idcategory']);
                            $titlecategory = explode('||0||',$item['titlecategory']);
                            #var_dump($idcategory,$titlecategory);
                            // tant que l'on a des catégories
                            foreach($idcategory as $key=>$value):
                            ?>
                            
                            <a class="badge bg-secondary text-decoration-none link-light" href="?categoryId=<?=$value?>"><?=$titlecategory[$key]?></a>
                             
                             <?php
                             endforeach;
                        endif;
                             ?>
                            <p class="fs-5 mb-4"><?=trunCate($item['contentshort'])?> <a href="?postId=<?=$item['id']?>">... Lire la suite</a></p>
                        </section>
                    </article>

                <?php
                endforeach;
            endif;
            ?>

</div>

<?php include "../view/footerView.php"; ?>