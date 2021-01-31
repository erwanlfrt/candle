<?php
session_start();
if(isset($_SESSION['token']) && isset($_SESSION['token_time']) && isset($_POST['token']))
{
	if($_SESSION['token'] == $_POST['token'])
	{
		$timestamp_ancien = time() - (5*60);
		if($_SESSION['token_time'] < $timestamp_ancien)
		{
                header("location: ?action=forbidden");
                exit();
		}
	}
}
else if($_GET['action'] !== "delete"){
    header("location: ?action=forbidden");
    exit();
}

//database connection
require_once 'Model/databaseConnection.php';
use \Model\DatabaseConnection;
$db = DatabaseConnection::getDatabaseConnection(); 

/**
 * add smell
 * @param db database connection
 */
function addSmell($db){
    if(isset($_POST['name']) && isset($_POST['smellStatus'])){ //if valid form

        //avoid XSS attack
        $name = mysqli_real_escape_string($db, htmlspecialchars($_POST['name']));
        $status = mysqli_real_escape_string($db, htmlspecialchars($_POST['smellStatus']));
    
        if($name !== "" && $status !== ""){ //if inputs are not empty
            $queryCheck = "SELECT count(*) FROM odeur WHERE nom_odeur='".$name."'";
            $exec_requete = mysqli_query($db,$queryCheck);
            $reponse = mysqli_fetch_array($exec_requete);
            $count = $reponse['count(*)'];

            if($count!=0){
                header('Location: ?action=add&table=smell&erreur=2'); //smell already exist
            }
            else{
                //insert smell
                $requete = "INSERT INTO odeur (nom_odeur, statut_odeur) VALUES ('".$name."', '".$status."')";
                $exec_requete = mysqli_query($db,$requete);
                $reponse = mysqli_fetch_array($exec_requete);

                header('Location: ?action=list&table=smell'); //go back to list
            }
        }
        else{
            header('Location: ?action=add&table=smell');
        }
    
    }
    else{
        header('Location: ?action=add&table=smell');
    }
    
}

/**
 * edit smell
 * @param db database connection
 */
function editSmell($db){
    $id = $_GET['id'];
    
    if(isset($_POST['update'])){
        //avoid XSS attack
        $name = mysqli_real_escape_string($db, htmlspecialchars($_POST['name']));
        $smellStatus = mysqli_real_escape_string($db, htmlspecialchars($_POST['smellStatus']));

        //edit
        mysqli_query($db,"update odeur set nom_odeur='$name', statut_odeur='$smellStatus'where id_odeur='$id'");
        mysqli_close($db); // Close connection
        header("location: ?action=list&table=smell"); // redirects to all records page
        exit;
    }
}


/**
 * Delete smell
 * @param db database connection
 */
function deleteSmell($db){
    $id = mysqli_real_escape_string($db,htmlspecialchars($_GET['id']));

    //Check if the smell is not present into recipe table

    $check1 = mysqli_query($db, "SELECT count(*) from recipe WHERE id_bougie='$id';");
    $count = mysqli_fetch_array($check1)["count(*)"];

    if($count == 0){
        mysqli_query($db,"DELETE FROM odeur WHERE id_odeur='$id'");
    }

    header("location: ?action=list&table=smell"); // redirects to all records page
}

if(isset($_POST['update'])){ //if we want to edit
    editSmell($db);
}
else if($_GET['action'] === "delete"){
    deleteSmell($db);
}
else{ //else we want to add
    addSmell($db);
}
?>