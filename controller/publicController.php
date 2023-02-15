<?php
/**
 * public
 */
# debug with file's name
# echo __FILE__;

# récupération du menu
$recupMenu = getAllCategoryMenu($db);

# homepage's datas from MODEL
$recupAllPost = postHomepageAll($db);

# Post count
$nbPost = count($recupAllPost);


# homepage's view from VIEW
require "../view/publicView/publicHomepageView.php";