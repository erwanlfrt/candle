<?php
session_start();

//database connection
require_once 'Model/databaseConnection.php';
use \Model\DatabaseConnection;
$db = DatabaseConnection::getDatabaseConnection(); 

/**
 * edit user
 * @param db database connection
 */
function editUser($db){
    $id = $_GET['id'];
    
    if(isset($_POST['update'])){
        //avoid XSS attack
        $login = mysqli_real_escape_string($db, htmlspecialchars($_POST['login']));
        $role = mysqli_real_escape_string($db,htmlspecialchars($_POST['roleStatus']));
        
        //if role is not root
        if($role != '0'){
            //if role and login are not empty
            if(!empty($login) && !empty($role)){
                //edit user
                mysqli_query($db,"update user set login='$login', role='$role' where id='$id'");
            }
        }
        mysqli_close($db); // Close connection
        header("location: ?action=list&table=user"); // redirects to all records page
        exit;
    }
    
}

/**
 * Delete user
 * @param db database connection
 */
function deleteUser($db){
    $id = mysqli_real_escape_string($db,htmlspecialchars($_GET['id']));
    
    mysqli_query($db,"DELETE FROM user WHERE id='$id'");
    header("location: ?action=list&table=user"); // redirects to all records page
}

if(isset($_POST['update'])){
    editUser($db);
}
else{
    deleteUser($db);
}
?>