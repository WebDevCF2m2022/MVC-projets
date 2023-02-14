<?php
/**
 * public
 */
# debug with file's name
# echo __FILE__;

# homepage's data from MODEL
$recupAllPost = postHomepageAll($db);

# homepage's view from VIEW
require "../view/publicView/publicHomepageView.php";