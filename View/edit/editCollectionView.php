<?php 
    //database connection
    require_once 'Model/databaseConnection.php';
    use \Model\DatabaseConnection;
    $db = DatabaseConnection::getDatabaseConnection(); 

    $id = $_GET['id'];
    //get name of collection
    $qry = mysqli_query($db,"select nom_collection from collection where id_collection='$id';"); // select query
    $data = mysqli_fetch_array($qry); // fetch data
    $name =  $data["nom_collection"];
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
            <form action="?action=edit&table=collection&control&id=<?php echo $id; ?>" method="POST">
                <p>Modifier une collection</p>
                <input  class="textField" type="text" name="name" value=<?php echo $name; ?> Required>
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
