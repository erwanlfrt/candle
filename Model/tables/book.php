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

//Database connection
require_once 'Model/databaseConnection.php';
use \Model\DatabaseConnection;
$db = DatabaseConnection::getDatabaseConnection(); 


/**
 * add book to database 
 * @param db database connection
 */
function addBook($db){
    if(isset($_POST['title']) && isset($_POST['author'])){  

        //avoid XSS attack
        $title = mysqli_real_escape_string($db, htmlspecialchars($_POST['title']));
        $author = mysqli_real_escape_string($db, htmlspecialchars($_POST['author']));
    
        if($title !== "" && $author !== ""){ //if valid form
            //check if book doesn't already exist
            $queryCheck = "SELECT count(*) FROM livre WHERE titre='".$title."'";
            $exec_requete = mysqli_query($db,$queryCheck);
            $reponse = mysqli_fetch_array($exec_requete);
            $count = $reponse['count(*)'];
            if($count!=0){
                header('Location: ?action=add&table=book&erreur=2'); //book already exist
            }
            else{
                //Check if author exist
                $queryCheck = "SELECT id_auteur FROM auteur WHERE nom_auteur='".$author."'";
                $exec_requete = mysqli_query($db,$queryCheck);
                $reponse = mysqli_fetch_array($exec_requete);
                $id= $reponse['id_auteur'];    

                if(isset($id)){ //author exist
                    //insert book
                    $requete = "INSERT INTO livre (titre, id_auteur ) VALUES ('".$title."', '".$id."')";
                    $exec_requete = mysqli_query($db,$requete);
                    $reponse = mysqli_fetch_array($exec_requete);
                    header('Location: ?action=list&table=book'); //back to list of books
                }
                else{
                    header('Location: ?action=add&table=book&erreur=4'); //author doesn't exist
                } 
                
            }
        }
        else{
            header('Location: ?action=add&table=book'); //invalid form
        }
    }
}

/**
 * Edit a book
 * @param $db database connection
 */
function editBook($db){
    $id_book = $_GET['id'];
    if(isset($_POST['update'])){
        
        //avoid XSS attack
        $title = mysqli_real_escape_string($db, htmlspecialchars($_POST['title']));
        $author = mysqli_real_escape_string($db, htmlspecialchars($_POST['author']));

        if($title !== "" && $author !== ""){ //check if unputs are not empty
            //Check if author exist
            $queryCheck = "SELECT id_auteur FROM auteur WHERE nom_auteur='".$author."'";
            $exec_requete = mysqli_query($db,$queryCheck);
            $reponse = mysqli_fetch_array($exec_requete);
            $id= $reponse['id_auteur'];     

            if(isset($id)){ //author is valid
                //update book
                $requete = "UPDATE livre SET titre='$title', id_auteur='$id' WHERE id_livre ='$id_book' ";
                $exec_requete = mysqli_query($db,$requete);
                $reponse = mysqli_fetch_array($exec_requete);

                header('Location: ?action=list&table=book&erreur='.$id_book); //redirect to list of books
            }
            else{
                header('Location: ?action=edit&table=book&id='.$id_book.'&erreur=1'); //author doesn't exist
            } 
                
        }
        else{
            header('Location: ?action=edit&table=book&id='.$id_book.'&erreur=2'); //invalid form
        }

    }
}

/**
 * Delete book
 * @param db database connection
 */
function deleteBook($db){
    $id = mysqli_real_escape_string($db,htmlspecialchars($_GET['id']));

    //Check if the book is not present into candle table

    $check1 = mysqli_query($db, "SELECT count(*) from bougie WHERE id_livre='$id';");
    $count = mysqli_fetch_array($check1)["count(*)"];

    if($count == 0){
        mysqli_query($db,"DELETE FROM livre WHERE id_livre='$id'");
    }

    header("location: ?action=list&table=book"); // redirects to all records page
}


if(isset($_POST['update'])){ //if we want to edit
    editBook($db);
}
else if($_GET['action'] === "delete"){
    deleteBook($db);
}
else{ //we want to add
    addBook($db);
}

?>