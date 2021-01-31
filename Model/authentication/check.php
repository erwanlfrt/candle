<?php
session_start();
require_once 'Model/databaseConnection.php';
use \Model\DatabaseConnection;

if(isset($_POST['username']) && isset($_POST['password'])){ //check if we have a username and a password at least.
   
    $db = DatabaseConnection::getDatabaseConnection();      
    // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
    // pour éliminer toute attaque de type injection SQL et XSS

    //prevent XSS 
    $username = mysqli_real_escape_string($db,htmlspecialchars($_POST['username'])); 
    $password = mysqli_real_escape_string($db,htmlspecialchars($_POST['password']));


    //prevent CSRF with a token.
   $token = uniqid(rand(), true); //generate a token
   $_SESSION['token'] = $token;  //add token to session
   $_SESSION['token_time'] = time(); //add the token's date of creation.

   if($username !== "" && $password !== ""){ //If username and password are not empty
        $request = "SELECT role FROM user where login= '".$username."' and pwd = '".$password."' "; //get the user's role.
        $exec_request = mysqli_query($db,$request); //execution of role request.
        $reponse      = mysqli_fetch_array($exec_request); //putting result into array
        $role = $reponse['role']; //get the role.
        if(isset($role)){ //if we have role then username and password are correct
            $_SESSION['username'] = $username; //adding username to session
            $_SESSION['role'] = $role; //adding role to session
            header('Location: ?action=home'); //go to home webpage
        }
        else{
            header('Location: ?action=login&erreur=4'); //username or password incorrect
        }
    }
    else
    {
       header('Location: ?action=login&erreur=1'); //invalid form
    }
}
else
{
   header('Location: ?action=login&erreur=1'); //invalid form
}
mysqli_close($db); //close database connection
?>