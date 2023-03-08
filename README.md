# MVC-projets
Préparation aux projets des groupes web

## Principes

### V1
Nous souhaitons obtenir un site de news (le sujet des articles est de moindre importance) en couplant PHP 8 et MariaDB.

Le site doit être en MVC procédural au départ, puis sera converti en OO (orienté objet) plus tard.

Il servira de base pour les travaux de groupe des stagiaires du CF2m. Il ne s'agira pas de faire des copier/coller, mais bien de choisir en équipe une structure ressemblante, des noms de variables et une DB proche pour rendre fonctionnel le travail demandé.

Des relations `many to many` et `many to one` seront demandées en SQL, pour permettre d'afficher des articles avec leurs rubriques et leurs auteurs.

Une administration sera présente, elle permettra de faire le `CRUD` (Create, Read, Update, Delete) des articles. Chaque stagiaire devra y avoir un accès personnel.

Le design sera libre mais devra être responsive.

# MVC

Pour Model View Controller

    /model/
    /view/
    /controller/

Principe de fonctionnement du MVC en une image :

![Modèle MVC PHP](https://github.com/WebDevCF2m2022/MVC-projets/raw/main/data/MVC.png)

## Dossier public

Seul dossier accessible à l'utilisateur final

    /public/

## Dossier data

C'est ici que se trouveront nos fichiers préparatoires et nos DB exportables

    /data/

## Fichiers racines

    README.md => documentation
    config.php.ini => fichier contenant un modèle de nos données de configuration
    .gitignore => liste ce qu'on ne veut pas mettre sur git (github etc...)

## Contrôleur frontal

C'est le fichier index.php se trouvant dans le dossier public

    public/index.php

## Première partie

### Création de la DB
Elle sera créée dans le dossier `data` avec Workbench

![mvcprojets DB](https://github.com/WebDevCF2m2022/MVC-projets/raw/main/data/mvcprojetsV1.png)

michaeljpitz

vxjk23rt
