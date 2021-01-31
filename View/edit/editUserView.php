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

    //get information about user
    $qry = mysqli_query($db,"select login, role from user where id='$id';"); // select query
    $data = mysqli_fetch_array($qry); // fetch data
    $name =  $data["login"];
    $role = $data["role"];
    
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
            
            <form action="?action=edit&table=user&control&id=<?php echo $id; ?>" method="POST">
                <p>Modifier un utilisateur</p>
                <input class="textField" type="text" id="login" name="login" value=<?php echo $name; ?>>
                <div>
                    <p>Rôle : </p>
                    <div class="radioLine">
                        <input <?php if($role === '1'){ echo 'checked' ;}?> type="radio" id="role1" name="roleStatus" value="1">
                        <label for="role1">admin</label>
                    </div>

                    <div class="radioLine">
                        <input <?php if($role === '2'){ echo 'checked' ;}?> type="radio" id="role2" name="roleStatus" value="2">
                        <label for="role2">user</label>
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

