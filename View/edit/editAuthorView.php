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

    //get name of the author
    $qry = mysqli_query($db,"select nom_auteur from auteur where id_auteur='$id';"); // select query
    $data = mysqli_fetch_array($qry); // fetch data
    $name =  $data["nom_auteur"]
    
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
            <form action="?action=edit&table=author&control&id=<?php echo $id; ?>" method="POST">
                <p>Modifier un auteur</p>
                <input class="textField" type="text" name="name" value=<?php echo $name; ?> Required>
                <input type="hidden" name="token" id="token" value="<?php echo $token;?>"/>
                <input type="submit" id="submit" name="update" value="Update">
            </form>
        </div>

        <div>
        <?php
            if(isset($_GET['erreur'])){
                $err = $_GET['erreur'];
                if($err==1 || $err==2)
                {
                    echo "<p style='color:red'>Author already exist</p>";
                }
                elseif($err==3){
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
    </body>
</html>
