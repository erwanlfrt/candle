<?php
session_start();

//database connection
require_once 'Model/databaseConnection.php';
use \Model\DatabaseConnection;
$db = DatabaseConnection::getDatabaseConnection(); 

/**
 * Add an event to database
 */
function addEvent($db){
    if(isset($_POST['name'])){ //if valid form
        
        //avoid XSS attack
        $name = mysqli_real_escape_string($db, htmlspecialchars($_POST['name']));
    
        if($name !== ""){ //if input is not empty
            $queryCheck = "SELECT count(*) FROM event WHERE name='".$name."'";
            $exec_requete = mysqli_query($db,$queryCheck);
            $reponse = mysqli_fetch_array($exec_requete);
            $count = $reponse['count(*)'];
            if($count!=0){
                header('Location: ?action=list&table=event&erreur=2'); //event already exist
            }
            else{
                //insert event
                $requete = "INSERT INTO event (name) VALUES ('".$name."')";
                $exec_requete = mysqli_query($db,$requete);
                $reponse = mysqli_fetch_array($exec_requete);
                header('Location: ?action=list&table=event'); //redirect to list of event
            }
        }
        else{
            header('Location: ?action=list&table=event'); //invalid form
        }
    
    }
    else{
        header('Location: ?action=list$table=event'); //invalid form
    }
}

/**
 * edit an event
 * @param db database connection
 */
function editEvent($db){
    $id = $_GET['id']; 
    if(isset($_POST['update'])){
        //avoid XSS attack
        $name = mysqli_real_escape_string($db, htmlspecialchars($_POST['name']));
        
        //update event
        mysqli_query($db,"update event set name='$name'where id='$id'");
        mysqli_close($db); // Close connection
        header("location: ?action=list&table=event"); // redirects to all records page
        exit;
    }
}

/**
 * Delete event
 * @param db database connection
 */
function deleteEvent($db){
    $id = mysqli_real_escape_string($db,htmlspecialchars($_GET['id']));

    //Check if the event is not associated into events table

    $check1 = mysqli_query($db, "SELECT count(*) from events WHERE id_event='$id';");
    $count = mysqli_fetch_array($check1)["count(*)"];

    if($count == 0){
        mysqli_query($db,"DELETE FROM event WHERE id='$id'");
    }

    header("location: ?action=list&table=event"); // redirects to all records page
}

if(isset($_POST['update'])){ //if we want to update
    editEvent($db);
}
else if($_GET['action'] === "delete"){
    deleteEvent($db);
}
else{ //if we want to add
    addEvent($db);  
}

?>