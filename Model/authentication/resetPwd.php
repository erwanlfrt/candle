<?php
session_start();
require_once 'Model/databaseConnection.php';
use \Model\DatabaseConnection;


if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_confirm'])){ //If form is valid
    $db = DatabaseConnection::getDatabaseConnection(); 
    
    //avoid XSS attack
    $username = mysqli_real_escape_string($db,htmlspecialchars($_POST['username'])); 
    $password = mysqli_real_escape_string($db,htmlspecialchars($_POST['password']));
    $confirmPassword = mysqli_real_escape_string($db,htmlspecialchars($_POST['password_confirm']));

    
    if($username !== "" && $password !== "" && $confirmPassword !== ""){    //if inputs are not empty

        //check if user already exist in database
        $queryCheck = "SELECT count(*) FROM user WHERE login= '".$username."'"; 
        $exec_request = mysqli_query($db,$queryCheck);
        $response = mysqli_fetch_array($exec_request);
        $count = $response['count(*)'];

        if($count != 0){ //User already exist in database
            if($confirmPassword === $password){ //if confirmPassword and password match
                //get id
                $getIdRequest = "SELECT id FROM user WHERE login='$username'";
                $execIdRequest = mysqli_query($db, $getIdRequest);
                $response = mysqli_fetch_array($execIdRequest);
                $userId = $response['id'];

                //update user
                $request = "UPDATE user SET login='$username', pwd='$password' WHERE id='$userId'";
                $exec_request = mysqli_query($db,$request);

                header('Location: ?action=login'); //go back to login webpage
            }
            else{
                header('Location: ?action=resetPwd&erreur=3'); //passwords don't matched
            }
           
        }
        else{
            header('Location: ?action=resetPwd&erreur=5'); //user doesn't exist
        }
        
    }
    else
    {
       header('Location: ?action=resetPwd&erreur=1'); //empty input
    }
}
else{
   header('Location: ?action=resetPwd&erreur=1'); //invalid form
}
mysqli_close($db); // close database connection
?>