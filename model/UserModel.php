<?php



/**
 * 
 * @param mysqli $mydb
 * @param int $iduser
 * 
 * @return array|null
 */
function getOneUserById(mysqli $mydb, int $iduser): array|null {

    $sql="SELECT id, username, userscreen FROM user WHERE id=$iduser";
    try{
        $query = mysqli_query($mydb,$sql);
    }catch(Exception $e){
        die($e->getMessage());
    }
    return mysqli_fetch_assoc($query);
}

function connectUserByUsername(mysqli $db, string $uname, string $pwd) :bool|string {
    // protection des chaînes contre injection sql
    $uname = mysqli_real_escape_string($db,$uname);
    $pwd = mysqli_real_escape_string($db,$pwd);

    // sql, on prend l'utilisateur si il existe même si son mot de passe ne correspond pas
    $sql = "SELECT * FROM user WHERE username='$uname'";

    try{
        $query = mysqli_query($db,$sql);
    }catch(Exception $e){
        die($e->getMessage());
    }
    // si on a un user
    if(mysqli_num_rows($query)==1){
        $response = mysqli_fetch_assoc($query);
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