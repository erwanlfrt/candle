<?php 
  session_start();
  //prevent CSRF with a token.
  $token = uniqid(rand(), true); //generate a token
  $_SESSION['token'] = $token;  //add token to session
  $_SESSION['token_time'] = time(); //add the token's date of creation.

?>
<?php 
    //database connection
    require_once 'Model/databaseConnection.php';
    use \Model\DatabaseConnection;
    $db = DatabaseConnection::getDatabaseConnection(); 

    $id = $_GET['id'];

    //get information about smell
    $qry = mysqli_query($db,"select nom_odeur, statut_odeur from odeur where id_odeur='$id';"); // select query
    $data = mysqli_fetch_array($qry); // fetch data
    $name =  $data["nom_odeur"];
    $statut = $data["statut_odeur"];
?>


<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>TP PHP</title>
        <link rel="stylesheet" href="View/style/edit.css">
    </head>
    <body>
        <div id="menuBar">
            <p id="logo">g</p>
            <p><a href="/?action=home">Accueil</a></p>
        </div>
        <?php 
            if($_SESSION["role"] === "0" || $_SESSION['role'] === "1"){
        ?>
        <div id="main">
            <form action="?action=edit&table=smell&control&id=<?php echo $id; ?>" method="POST">
                <p>Modifier une odeur</p>
                <input type="text" name="name" value=<?php echo $name ?> Required>
                <div>
                    <p>Smell status :</p>
                    <div class="radioLine">
                        <input <?php if($statut === 'possess'){echo 'checked';}?> type="radio" id="smellStatus1" name="smellStatus" value="possess">
                        <label for="smellStatus1">Possess</label>
                    </div>
                    
                    <div class="radioLine">
                        <input <?php if($statut === 'wish'){echo 'checked';}?> type="radio" id="smellStatus2" name="smellStatus" value="wish">
                        <label for="smellStatus2">Wish</label>
                    </div>

                    <div class="radioLine"> 
                        <input <?php if($statut === 'idea'){echo 'checked';}?> type="radio" id="smellStatus3" name="smellStatus" value="idea">
                        <label for="smellStatus3">Idea</label>
                    </div>
                </div>
                <input type="hidden" name="token" id="token" value="<?php echo $token;?>"/>
                <input id="submit" type="submit" name="update" value="Update">
            </form>
        </div>
        <?php
            }
            else{
            ?>
            <p>Vous n'êtes pas autorisé à accéder à cette page</p>
            <?php
            } 
        ?>
    </body>
</html>
