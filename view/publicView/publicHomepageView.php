<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DB - BDD : Les bases de données</title>
</head>
<body>
    <h1>DB - BDD : Les bases de données</h1>
    <?php
    if(empty($nbPost)):
    ?>
    <h2>Pas encore de message</h2>
    <?php
    else:
    ?>
    <h2>Nous avons <?=$nbPost?> article(s)</h2>
        <?php
        foreach($recupAllPost as $item):
        ?>
    <div class="message">
            <h4><?=$item['title']?></h4>
            <p><?=$item['contentshort']?> ... Lire la suite</p>
    </div>

    <?php
        endforeach;
    endif;
    ?>
</body>
</html>