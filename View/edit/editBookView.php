<?php 
    //database connection
    require_once 'Model/databaseConnection.php';
    use \Model\DatabaseConnection;
    $db = DatabaseConnection::getDatabaseConnection(); 

    $id = $_GET['id'];

    //get information about book
    $qry = mysqli_query($db,"select titre, id_auteur from livre where id_livre='$id';"); // select query
    $data = mysqli_fetch_array($qry); // fetch data
    $title =  $data["titre"];
    $id_auteur = $data['id_auteur'];

    //get name of associated author
    $qry = mysqli_query($db,"select nom_auteur from auteur where id_auteur='$id_auteur';"); // select query
    $dataAuthor = mysqli_fetch_array($qry); // fetch data
    $name =  $dataAuthor["nom_auteur"];

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
            <form action="?action=edit&table=book&control&id=<?php echo $id; ?>" method="POST">
                <p>Modifier un auteur</p>
                <input class="textField" type="text" name="title" value=<?php echo $title ?> Required>
                <input class="textField" type="text" name="author" value=<?php echo $name ?> Required>
                <input id="submit" type="submit" name="update" value="Update">
            </form>
        </div>
    </body>
    <div>
    <?php
        if(isset($_GET['erreur'])){
            $err = $_GET['erreur'];
            if($err==1)
            {
                echo "<p style='color:red'>Author not found in database</p>";
            }
            elseif($err==2){
                echo "<p style='color:red'>Invalid form</p>";
            }
        }
      ?>
    </div>
    <?php
        }
        else{
          ?>
          <p>Vous n'êtes pas autorisé à accéder à cette page</p>
          <?php
        } ?>
</html>
