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

    //get informations about recipe
    $qry = mysqli_query($db,"select quantité, id_bougie, id_odeur from recette where id_recette='$id';"); // select query
    $data = mysqli_fetch_array($qry); // fetch data
    $quantity = $data["quantité"];
    $id_bougie = $data["id_bougie"];
    $id_odeur = $data["id_odeur"];

    //get candle name
    $qry = mysqli_query($db,"select nom_bougie from bougie where id_bougie='$id_bougie';"); // select query
    $data2 = mysqli_fetch_array($qry); // fetch data
    $candle_name = $data2["nom_bougie"];

    //get smell name
    $qry = mysqli_query($db,"select nom_odeur from odeur where id_odeur='$id_odeur';"); // select query
    $data3 = mysqli_fetch_array($qry); // fetch data
    $smell_name = $data3["nom_odeur"];
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
            <form action="?action=edit&table=recipe&control&id=<?php echo $id; ?>" method="POST">
                <p>Modifier une recette</p>
                <input class="textField" type="text" id="quantity" name="quantity" value=<?php echo $quantity ?>>
                <input class="textField" type="text" id="candle" name="candle" value=<?php echo $candle_name ;?>>
                <input class="textField" type="text" id="smell" name="smell" value=<?php echo $smell_name;?>>
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
