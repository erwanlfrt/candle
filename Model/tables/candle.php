<?php
session_start();

//database connection
require_once 'Model/databaseConnection.php';
use \Model\DatabaseConnection;
$db = DatabaseConnection::getDatabaseConnection(); 

/**
 * add candle to database
 * @param db database connection
 */
function addCandle($db){
    if(isset($_POST['name']) && isset($_POST['candleStatus']) && isset($_POST['title']) && isset($_POST['collection'])){ //if valid form


        //avoid XSS attack
        $name = mysqli_real_escape_string($db, htmlspecialchars($_POST['name']));
        $status = mysqli_real_escape_string($db, htmlspecialchars($_POST['candleStatus']));
        $title= mysqli_real_escape_string($db, htmlspecialchars($_POST['title']));
        $collection = mysqli_real_escape_string($db, htmlspecialchars($_POST['collection']));
        $events = $_POST["eventProp"];


        if($name !== "" && $status !== "" && $title !== "" && $collection !== ""){ //if inputs are not empty
            //check if candle doesn't already exist
            $queryCheck = "SELECT count(*) FROM bougie WHERE nom_bougie='".$name."'";
            $exec_requete = mysqli_query($db,$queryCheck);
            $reponse = mysqli_fetch_array($exec_requete);
            $count = $reponse['count(*)'];

            if($count !=0 ){
                header('Location: ?action=add&table=candle&erreur=2'); //candle already exist
            }
            else{
                
                //check if book exist
                $queryCheck = "SELECT id_livre FROM livre where
                titre='".$title."'";
                $exec_requete = mysqli_query($db,$queryCheck);
                $reponse = mysqli_fetch_array($exec_requete);
                $idLivre = $reponse['id_livre'];

                if(isset($idLivre)){
                    //check if collection exist
                    $queryCheck = "SELECT id_collection FROM collection where
                    nom_collection='".$collection."'";
                    $exec_requete = mysqli_query($db,$queryCheck);
                    $reponse = mysqli_fetch_array($exec_requete);
                    $idCollection = $reponse['id_collection'];

                    if(isset($idCollection)){
                        //insert collection
                        $requete = "INSERT INTO bougie (nom_bougie, id_livre, id_collection, statut_bougie) VALUES ('".$name."', '".$idLivre."', '".$idCollection."', '".$status."')";
                        $exec_requete = mysqli_query($db,$requete);
                        $reponse = mysqli_fetch_array($exec_requete);


                        //get id of inserted candle
                        $requete = "SELECT max(id_bougie) from bougie";
                        $exec_requete = mysqli_query($db,$requete);
                        $reponse = mysqli_fetch_array($exec_requete);
                        $idBougie = $reponse["max(id_bougie)"];

                        //If we have associated events
                        if(isset($events)){

                            //add association between each event and candle in association table called "events".
                            for($i = 0; $i <sizeof($events); $i++){
                                //get id of event
                                $qry = mysqli_query($db, "SELECT id from event where name='".$events[$i]."';");
                                $reponse = mysqli_fetch_array($qry);
                                $idEvent= $reponse['id'];
                                
                                //insert association between event and candle into events table
                                $qry2 = mysqli_query($db, "INSERT INTO events (id_bougie, id_event) VALUES (".$idBougie.", ".$idEvent.");");
                            }
                        }
                        header('Location: ?action=list&table=candle'); //go back to list of candle
                    }
                    else{
                        header('Location: ?action=add&table=candle&erreur=5'); //wrong collection
                    }
    
                    
                }
                else{
                    header('Location: ?action=add&table=candle&erreur=4'); //wrong book
                }
                
            }
        }
        else{
            header('Location: ?action=add&table=candle'); //invalid form
        }
    }
    else{
        header('Location: ?action=add&table=candle'); //invalid form
    }
}


/**
 * edit a candle
 * @param db database connection
 */
function editCandle($db){
    if(isset($_POST['update'])){
        $id_candle= $_GET['id'];

        //avoid XSS attack
        $name = mysqli_real_escape_string($db, htmlspecialchars($_POST['name']));
        $status = mysqli_real_escape_string($db, htmlspecialchars($_POST['candleStatus']));
        $title= mysqli_real_escape_string($db, htmlspecialchars($_POST['title']));
        $collection = mysqli_real_escape_string($db, htmlspecialchars($_POST['collection']));
        $events = $_POST["eventProp"];
    
        if($name !== "" && $status !== "" && $title !== "" && $collection !== ""){ //if inputs are not empty
            //Check if book exist
            $queryCheck = "SELECT id_livre FROM livre where
            titre='".$title."'";
            $exec_requete = mysqli_query($db,$queryCheck);
            $reponse = mysqli_fetch_array($exec_requete);
            $idLivre = $reponse['id_livre'];

            if(isset($idLivre)){
                //Check if collection exist
                $queryCheck = "SELECT id_collection FROM collection where
                nom_collection='".$collection."'";
                $exec_requete = mysqli_query($db,$queryCheck);
                $reponse = mysqli_fetch_array($exec_requete);
                $idCollection = $reponse['id_collection'];

                if(isset($idCollection)){//update candle
                    $requete = "UPDATE bougie SET nom_bougie='$name', id_livre='$idLivre', id_collection='$idCollection', statut_bougie='$status' WHERE id_bougie='$id_candle'";
                    $exec_requete = mysqli_query($db,$requete);
                    $reponse = mysqli_fetch_array($exec_requete);
                }
                else{
                    header('Location: ?action=edit&table=candle&erreur=5');
                }
            }
            else{
                header('Location: ?action=edit&table=candle&erreur=4');
            }
            //If we have events
            if(isset($events)){
                //add new event association and do nothing for event-candle association which already exist in events table.
                for($i = 0; $i <sizeof($events); $i++){
                    //get id of event
                    $qry = mysqli_query($db, "SELECT id from event where name='".$events[$i]."';");
                    $reponse = mysqli_fetch_array($qry);
                    $idEvent= $reponse['id'];

                    //check if event-candle association doesn't already exist in events table.
                    $qry = mysqli_query($db, "SELECT count(*) from events WHERE id_bougie=".$id_candle." AND id_event=".$idEvent.";");
                    $reponse = mysqli_fetch_array($qry);
                    $count = $reponse["count(*)"];
                    //if association doesn't already exist
                    if($count == 0){
                        //add association
                        $qry2 = mysqli_query($db, "INSERT INTO events (id_bougie, id_event) VALUES (".$id_candle.", ".$idEvent.");");
                        $reponse = mysqli_fetch_array($qry2);
                    }
                    
                }
            }

            //check if candle have not been dissociated from an event
            $sql = "SELECT id_event from events WHERE id_bougie=".$id_candle.";";
            $result = $db->query($sql);
            
            while($row = $result->fetch_assoc()){
                //get name of event
                $qry = mysqli_query($db, "SELECT name from event WHERE id=".$row['id_event'].";");
                $nameEvent = mysqli_fetch_array($qry)["name"];
                
                //if event is no more into the events list then we have to delete the association.
                if(!in_array($nameEvent,$events)){
                    //delete association
                    $qry = mysqli_query($db, "DELETE FROM events WHERE id_bougie=".$id_candle." AND id_event=".$row['id_event'].";");
                }
            } 
            header('Location: ?action=list&table=candle'); //go back to list webpage
                
        }
        else{
            header('Location: ?action=list&table=candle'); //go back to list webpage
        }
    
    }
    
}

/**
 * Delete candle
 * @param db database connection
 */
function deleteCandle($db){
    $id = mysqli_real_escape_string($db,htmlspecialchars($_GET['id']));

    //Check if the candle is not present into recipe and events tables

    $check1 = mysqli_query($db, "SELECT count(*) from recipe WHERE id_bougie='$id';");
    $count = mysqli_fetch_array($check1)["count(*)"];

    $check2 = mysqli_query($db, "SELECT count(*) from events WHERE id_bougie='$id';");
    $count2 = mysqli_fetch_array($check2)["count(*)"];

    if($count == 0 && $count2 == 0){
        mysqli_query($db,"DELETE FROM bougie WHERE id_bougie='$id'");
    }

    header("location: ?action=list&table=candle"); // redirects to all records page
}

if(isset($_POST['update'])){ //if we want to edit
    editCandle($db);
}
else if($_GET['action'] === "delete"){
    deleteCandle($db);
}
else{ //we want to add
    addCandle($db); 
}


?>