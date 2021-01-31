<?php
session_start();
require_once 'Model/databaseConnection.php';
use \Model\DatabaseConnection;

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_confirm'])) //if form is valid
{
    $db = DatabaseConnection::getDatabaseConnection(); 
    //prevent XSS attack
    $username = mysqli_real_escape_string($db,htmlspecialchars($_POST['username'])); 
    $password = mysqli_real_escape_string($db,htmlspecialchars($_POST['password']));
    $confirmPassword = mysqli_real_escape_string($db,htmlspecialchars($_POST['password_confirm']));

    if($username !== "" && $password !== "" && $confirmPassword !== ""){   //if inputs are not empty

        //Check if first user inserted in database
        $queryCheck = "SELECT count(*) FROM user";
        $exec_requete = mysqli_query($db,$queryCheck);
        $reponse      = mysqli_fetch_array($exec_requete);
        $count = $reponse['count(*)'];

        //If first user inserted then he get role zero and become root.
        if($count==0){
            if($confirmPassword === $password){ //if passwords are equal
                //insert new user
                $requete = "INSERT INTO user (login,pwd,role) VALUES ('".$username."','".$password."',0) "; //role = 0 for root user
                $exec_requete = mysqli_query($db,$requete);
                $reponse      = mysqli_fetch_array($exec_requete);

                header('Location: ?action=login'); //go back to login page
            }
            else{
                header('Location: ?action=signup&erreur=3'); //passwords are different
            }
        }
        else{
            //Check if there is not already a user in database with the same username
            $queryCheck = "SELECT count(*) FROM user WHERE login= '".$username."'";
            $exec_requete = mysqli_query($db,$queryCheck);
            $reponse      = mysqli_fetch_array($exec_requete);
            $count = $reponse['count(*)'];

            //if user already exist in database
            if($count!=0){ 
                header('Location: ?action=signup&erreur=2'); //redirect to signup webpage with error = 2 (it means user already exist)
            }
            else{
                if($confirmPassword === $password){
                    //inser new user
                    $requete = "INSERT INTO user (login,pwd,role) VALUES ('".$username."','".$password."',2) ";
                    $exec_requete = mysqli_query($db,$requete);
                    $reponse      = mysqli_fetch_array($exec_requete);
                    header('Location: ?action=login'); //Go back to login webpage
                }
                else{
                    header('Location: ?action=signup&erreur=3'); // passwords are different, warn user
                }
                
            }
        }
    }
    else{
       header('Location: ?action=signup&erreur=1'); //invalid form
    }
}
else{
   header('Location: ?action=signup&erreur=1'); //invalid form
}
mysqli_close($db); //close database connection
?>