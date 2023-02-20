<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>DB - BDD : Erreur 404</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
<?php
include "inc/publicMenu.php";
?>
<!-- Page content-->
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8">

                <!-- Post header-->
                <header class="mb-4">
                    <!-- Post title-->
                    <h1 class="fw-bolder mb-1">DB - BDD : Erreur 404</h1>

                </header>
            <h2 class="fw-bolder mb-1"><?=$detailError?></h2>
            <p class="fs-5 mb-4">Retournez à l'accueil pour voir les autres articles</p>
            <p class="fs-5 mb-4"><a href="./">Retour à l'accueil</a></p>
        </div>
</div>
    <?php
    include "inc/publicFooter.php";
    ?>
