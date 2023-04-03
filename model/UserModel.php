<?php



/**
 * 
 * @param PDO $mydb
 * @param int $iduser
 * 
 * @return array|null
 */
function getOneUserById(PDO $mydb, int $iduser): array|bool {

    $sql="SELECT id, username, userscreen FROM user WHERE id=?";
    $prepare = $mydb->prepare($sql);
    try{
        $prepare->execute([$iduser]);
    }catch(Exception $e){
        die($e->getMessage());
    }
    $return = $prepare->fetch(PDO::FETCH_ASSOC);
    $prepare->closeCursor();
    return $return;
}

function getAllUsers(PDO $mydb): array {
    try{
        $query = $mydb->query("SELECT id, userscreen FROM user ORDER BY userscreen ASC;");
        $out = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $out;
    }catch(Exception $e){
        die($e->getMessage());
    }
}

function connectUserByUsername(PDO $db, string $uname, string $pwd) :bool|string {

    // sql, on prend l'utilisateur si il existe même si son mot de passe ne correspond pas
    $sql = "SELECT * FROM user WHERE username=?";
    $prepare = $db->prepare($sql);
    try{
        $prepare->execute([$uname]);
    }catch(Exception $e){
        die($e->getMessage());
    }
    // si on a un user
    if($prepare->rowCount()==1){
        $response = $prepare->fetch(PDO::FETCH_ASSOC);
        // on vérifie si le mot de passe crypté dans la DB correspond à celui entré par l'utilisateur
        if(password_verify($pwd,$response['userpwd'])){
            // création d'une session valide
            // remplissage de la variable de session avec le contenu de la requête
            $_SESSION = $response;
            // suppression de 2 variables inutiles
            unset($_SESSION['userpwd'],$_SESSION['useruniqid']);
            // création de la variable de session
            $_SESSION['myID']=session_id();

            return true;

        }else{
            return "Login et/ou mot de passe incorrecte 2";
        }
    }else{
        return "Login et/ou mot de passe incorrecte 1";
    }

}

// déconnexion
function deconnect(): bool{
    # destruction des variables de sessions (réinitialisation du tableau $_SESSION)
    $_SESSION = [];

    # suppression du cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    # Destruction du fichier lié sur le serveur
    session_destroy();

    return true;
}