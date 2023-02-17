<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>DB - BDD : Les bases de données</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="./">DB - BDD : Les bases de données</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" href="./">Accueil</a></li>
                <?php
                foreach($recupMenu as $item):
                ?>
<li class="nav-item"><a class="nav-link" href="?categoryId=<?=$item['id']?>"><?=$item['title']?></a></li>
                <?php
                endforeach;
                ?>
            </ul>
        </div>
    </div>
</nav>
<!-- Page content-->
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8">

                <!-- Post header-->
                <header class="mb-4">
                    <!-- Post title-->
                    <h1 class="fw-bolder mb-1">DB - BDD : Les bases de données</h1>
                    <!-- Post meta content-->
                    
                    <p class="fs-5 mb-4">Site de préparation du travail de groupe du <a href="https://github.com/WebDevCF2m2022/MVC-projets" target="_blank">CF2m</a> utilisant des morceaux d'articles libres depuis <a href="https://fr.wikipedia.org/wiki/Wikip%C3%A9dia:Accueil_principal" target="_blank">Wikipédia</a>. Les spécifications techniques sont : MVC avec un dossier publique, PHP 8 procédural et MariaDB.</p>
                    <?php // var_dump($_GET) ?>
                </header>
                <!-- Preview image figure-->
                <!--<figure class="mb-4"><img class="img-fluid rounded" src="https://dummyimage.com/900x400/ced4da/6c757d.jpg" alt="..." /></figure>-->
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
                            <div class="text-muted fst-italic mb-2">Posté par <a href="?userId=<?=$item['iduser']?>"><?=$item['userscreen']?></a> le <?=datetimeToFrench($item['datecreate'])?></div>
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
                            <p class="fs-5 mb-4"><?=cutTheText($item['contentshort'])?> ... <a href="?postId=<?=$item['id']?>">Lire la suite</a></p>
                        </section>
                    </article>

                <?php
                endforeach;
            endif;
            ?>

</div>

<!-- Footer-->
<footer class="py-5 bg-dark">
    <div class="container"><p class="m-0 text-center text-white">Copyright &copy; CF2m <?=date("Y")?></p></div>
</footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
</body>
</html>