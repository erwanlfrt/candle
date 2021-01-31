<?php
session_start();

//database connection
require_once 'Model/databaseConnection.php';
use \Model\DatabaseConnection;
$db = DatabaseConnection::getDatabaseConnection(); 


/**
 * add a recipe
 * @param db database connection
 */
function addRecipe($db){
    if(isset($_POST['quantity']) && isset($_POST['smell']) && isset($_POST['candle'])){ //if valid form
        
        //avoid XSS attack
        $quantity = mysqli_real_escape_string($db, htmlspecialchars($_POST['quantity']));
        $smell= mysqli_real_escape_string($db, htmlspecialchars($_POST['smell']));
        $candle= mysqli_real_escape_string($db, htmlspecialchars($_POST['candle']));

        if($quantity !== "" && $smell !== "" && $candle !== "" ){ //if inputs are not empty

            //Check if candle exist
            $queryCheck = "SELECT id_bougie FROM bougie WHERE nom_bougie='".$candle."'";
            $exec_requete = mysqli_query($db,$queryCheck);
            $reponse = mysqli_fetch_array($exec_requete);
            $idCandle = $reponse['id_bougie'];

            if(isset($idCandle)){
                //Check if smell exist
                $queryCheck = "SELECT id_odeur FROM odeur WHERE nom_odeur='".$smell."'";
                $exec_requete = mysqli_query($db,$queryCheck);
                $reponse = mysqli_fetch_array($exec_requete);
                $idSmell = $reponse['id_odeur'];

                if(isset($idSmell)){
                    //insert recipe
                    $requete = "INSERT INTO recette (id_bougie, id_odeur, quantité) VALUES ('".$idCandle."', '".$idSmell."', '".$quantity."')";
                    $exec_requete = mysqli_query($db,$requete);
                    $reponse = mysqli_fetch_array($exec_requete);

                    header('Location: ?action=list&table=recipe'); //go back to list
                }
                else{
                    header('Location: ?action=add&table=recipe&erreur=5'); //wrong smell
                }

                
            }
            else{
                header('Location: ?action=add&table=recipe&erreur=4'); //wrong candle
            }
                
        }
        else{
            header('Location: ?action=list&table=recipe'); //invalid form
        }

    }
    else{
        header('Location: ?action=liste&table=recipe'); //invalid form
    }

}

/**
 * edit a recipe
 */
function editRecipe($db){
    $id_recipe= $_GET['id'];
    if(isset($_POST['update'])){
        
        //avoid XSS attack
        $quantity = mysqli_real_escape_string($db, htmlspecialchars($_POST['quantity']));
        $smell= mysqli_real_escape_string($db, htmlspecialchars($_POST['smell']));
        $candle= mysqli_real_escape_string($db, htmlspecialchars($_POST['candle']));

        if($quantity !== "" && $smell !== "" && $candle !== "" ){ //if inputs are not empty
            //Check if candle exist
            $queryCheck = "SELECT id_bougie FROM bougie where
            nom_bougie='".$candle."'";
            $exec_requete = mysqli_query($db,$queryCheck);
            $reponse = mysqli_fetch_array($exec_requete);
            $idCandle = $reponse['id_bougie'];
            if(isset($idCandle)){
                //Check if smell exist
                $queryCheck = "SELECT id_odeur FROM odeur where
                nom_odeur='".$smell."'";
                $exec_requete = mysqli_query($db,$queryCheck);
                $reponse = mysqli_fetch_array($exec_requete);
                $idSmell = $reponse['id_odeur'];

                if(isset($idSmell)){
                    //update recipe
                    $requete = "UPDATE recette SET id_bougie='$idCandle', id_odeur='$idSmell', quantité='$quantity' WHERE id_recette='$id_recipe'";
                    $exec_requete = mysqli_query($db,$requete);
                    $reponse = mysqli_fetch_array($exec_requete);

                    header('Location: ?action=list&table=recipe'); //go back to list
                }
                else{
                    header('Location: ?action=list&table=recipe&erreur=5'); //wrong smell
                }

                
            }
            else{
                header('Location: ?action=list&table=recipe&erreur=4'); //wrong candle
            }
                
        }
        else{
            header('Location: ?action=list&table=recipe'); //go back to list if invalid form
        }

    }

}

/**
 * Delete recipe
 * @param db database connection
 */
function deleteRecipe($db){
    $id = mysqli_real_escape_string($db,htmlspecialchars($_GET['id']));
    
    mysqli_query($db,"DELETE FROM recette WHERE id_recette='$id'");
    header("location: ?action=list&table=recipe"); // redirects to all records page
}

if(isset($_POST['update'])){ //if we want to update
    editRecipe($db);
}
else if($_GET['action'] === "delete"){
    deleteRecipe($db);
}
else{ //if we want to add
    addRecipe($db);
}


?>