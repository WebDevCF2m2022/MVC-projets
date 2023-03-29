<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>DB - BDD : Accueil de l'administration</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
<?php
// fonctionne pour les include / require - chemin relatif
 include_once "inc/menuPrivateView.php";

?>
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8">

                <!-- Post header-->
                <header class="mb-4">
                    <!-- Post title-->
                    <h1 class="fw-bolder mb-1">DB - BDD : Accueil de l'administration</h1>
                    <!-- Post meta content-->
                    
                    <p class="fs-5 mb-4">Site de préparation du travail de groupe du <a href="https://github.com/WebDevCF2m2022/MVC-projets" target="_blank">CF2m</a> utilisant des morceaux d'articles libres depuis <a href="https://fr.wikipedia.org/wiki/Wikip%C3%A9dia:Accueil_principal" target="_blank">Wikipédia</a>. Les spécifications techniques sont : MVC avec un dossier publique, PHP 8 procédural et MariaDB.</p>
                    <h3>DB - BDD : Accueil de l'administration</a></h3>
                    <h4>Bienvenue <?=$_SESSION['userscreen']?></h4>
                </header>
                <?php
// Pas de post
if($postCount==0):
                ?>
<h3>Pas encore d'article sur votre site</h3>
                <?php
// on a des post                
else:
                ?>
<h3>Nous avons <?=$postCount?> article(s)</h3>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>title</th>
            <th>contentshort</th>
            <th>datecreate</th>
            <th>visible</th>
            <th>userscreen</th>
            <th>titlecategory</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
    </thead><tbody>
                <?php
    foreach($postAll as $item):
    ?>
<tr>
    <td><?=$item['id']?></td>
            <td>title</td>
            <td>contentshort</td>
            <td>datecreate</td>
            <td>visible</td>
            <td>userscreen</td>
            <td>titlecategory</td>
            <td>Update</td>
            <td>Delete</td>
</tr>
    <?php
    endforeach;
    ?>
 </tbody>
</table>
    <?php
endif;
                ?>
                

</div>

<!-- Footer-->
<footer class="py-5 bg-dark">
    <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2022</p></div>
</footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
</body>
</html>