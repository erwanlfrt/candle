<?php
session_start();

//Database connection
require_once 'Model/databaseConnection.php';
use \Model\DatabaseConnection;
$db = DatabaseConnection::getDatabaseConnection(); 

/**
 * Add author to dabatase
 * @param db database connection
 */
function addAuthor($db){
    if(isset($_POST['name'])){
        
        //avoid XSS attack
        $name = mysqli_real_escape_string($db, htmlspecialchars($_POST['name']));
    
        if($name !== ""){ //if name not empty

            //check if author doesn't already exist in database
            $queryCheck = "SELECT count(*) FROM auteur WHERE nom_auteur='".$name."'";
            $exec_requete = mysqli_query($db,$queryCheck);
            $reponse = mysqli_fetch_array($exec_requete);
            $count = $reponse['count(*)'];

            if($count!=0){
                header('Location: ?action=add&table=author&erreur=2'); //author already exist
            }
            else{
                //insert new author
                $requete = "INSERT INTO auteur (nom_auteur) VALUES ('".$name."')";
                $exec_requete = mysqli_query($db,$requete);

                header('Location: ?action=list&table=author'); //go back to author list webpage.
            }
        }
        else{
            header('Location: ?action=add&table=author&erreur=3'); //invalid form
        }
    
    }
    else{
        header('Location: ?action=add&table=author&erreur=3'); //invalid form
    }
}

/**
 * edit an author
 * @param $db database connection
 */
function editAuthor($db){
    $id = $_GET['id']; // get id through query string

    if(isset($_POST['update'])){

        //avoid XSS attack
        $name = mysqli_real_escape_string($db, htmlspecialchars($_POST['name']));


        if($name !== ""){ //if name not empty
            mysqli_query($db,"UPDATE auteur SET nom_auteur='$name' WHERE id_auteur='$id'");
            mysqli_close($db); // Close connection
            header("location:?action=list&table=author"); // redirects to all records page
            exit;
        }
        else{
            header('Location: ?action=edit&table=author&erreur=3'); //invalid form
        }
    }
}

/**
 * Delete author
 * @param db database connection
 */
function deleteAuthor($db){
    $id = mysqli_real_escape_string($db,htmlspecialchars($_GET['id']));

    //Check if the smell is not present into book table.

    $check1 = mysqli_query($db, "SELECT count(*) from livre WHERE id_auteur='$id';");
    $count = mysqli_fetch_array($check1)["count(*)"];

    if($count == 0){
        mysqli_query($db,"DELETE FROM auteur WHERE id_auteur='$id'");
    }

    header("location: ?action=list&table=author"); // redirects to all records page
}



if(isset($_POST['update'])) { //if we want to edit
    editAuthor($db);
}
else if($_GET['action'] === "delete"){
    deleteAuthor($db);
}
else{ //else we want to add
    addAuthor($db);
}

?>