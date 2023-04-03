<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>DB - BDD : Insérer un article</title>
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
                    <h1 class="fw-bolder mb-1">DB - BDD : Insérer un article</h1>
                    <!-- Post meta content-->
                    
                    <p class="fs-5 mb-4">Site de préparation du travail de groupe du <a href="https://github.com/WebDevCF2m2022/MVC-projets" target="_blank">CF2m</a> utilisant des morceaux d'articles libres depuis <a href="https://fr.wikipedia.org/wiki/Wikip%C3%A9dia:Accueil_principal" target="_blank">Wikipédia</a>. Les spécifications techniques sont : MVC avec un dossier publique, PHP 8 procédural et MariaDB.</p>
                    <h3>DB - BDD : Accueil de l'administration</a></h3>
                    <h4>Bienvenue <?=$_SESSION['userscreen']?></h4>
                </header>
        </div>
        <div class="col-lg-12">
        <h3>Insertion d'un article :  </h3>
                    <form method="POST" action="" name="Insert">
  <div class="mb-3">
    <?php
      if(isset($message)):
    ?>
<button type="button" class="btn btn-warning"><?=$message?></button><br>
    <?php
      endif;
    ?>
    <label for="exampleInputEmail1" class="form-label">title</label>
    <input name="title" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
    <div id="emailHelp" class="form-text">title</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">contentshort</label>
    <input name="contentshort" type="text" class="form-control" id="exampleInputPassword1" required>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>
                
                </div>
            </div>
            </div>

<?php include "../view/footerView.php"; ?>