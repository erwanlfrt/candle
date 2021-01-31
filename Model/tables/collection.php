<?php
session_start();

require_once 'Model/databaseConnection.php';
use \Model\DatabaseConnection;
$db = DatabaseConnection::getDatabaseConnection(); 


/**
 * Add collection to database
 * @param db database connection
 */
function addCollection($db){
    if(isset($_POST['name'])){ //if valid form
        //avoid XSS attack
        $name = mysqli_real_escape_string($db, htmlspecialchars($_POST['name']));
    
        if($name !== ""){ //if input not empty
            $queryCheck = "SELECT count(*) FROM collection WHERE nom_collection='".$name."'";
            $exec_requete = mysqli_query($db,$queryCheck);
            $reponse = mysqli_fetch_array($exec_requete);
            $count = $reponse['count(*)'];

            if($count!=0){
                header('Location: ?action=add&table=collection&erreur=2'); //collection already exist
            }
            else{
                //insert new collection
                $requete = "INSERT INTO collection(nom_collection) VALUES ('".$name."')";
                $exec_requete = mysqli_query($db,$requete);

                header('Location: ?action=list&table=collection'); //go back to list
            }
        }
        else{
            header('Location: ?action=add&table=collection'); //invalid form
        }
    
    }
    else{
        header('Location: ?action=list&table=collection'); //invalid form
    }
}

/**
 * Edit collection
 * @param db database connection
 */
function editCollection($db){
    $id = $_GET['id'];
    
    if(isset($_POST['update'])){
        //avoid XSS attack
        $name = mysqli_real_escape_string($db, htmlspecialchars($_POST['name']));
        
        //edit collection
        mysqli_query($db,"update collection set nom_collection='$name'where id_collection='$id'");
        mysqli_close($db); // Close connection
        header("location: ?action=list&table=collection"); // redirects to all records page
        exit;

    }
}

/**
 * Delete collection
 * @param db database connection
 */
function deleteCollection($db){
    $id = mysqli_real_escape_string($db,htmlspecialchars($_GET['id']));

    //Check if the collection is not present into candle table

    $check1 = mysqli_query($db, "SELECT count(*) from candle WHERE id_collection='$id';");
    $count = mysqli_fetch_array($check1)["count(*)"];

    if($count == 0){
        mysqli_query($db,"DELETE FROM collection WHERE id_collection='$id'");
    }

    header("location: ?action=list&table=collection"); // redirects to all records page
}

if(isset($_POST['update'])){ //if we want to update
    editCollection($db);
}
else if($_GET['action'] === "delete"){
    deleteCollection($db);
}
else{ //else we want to add
    addCollection($db);
}


?>