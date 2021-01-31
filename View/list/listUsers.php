<?php 
  session_start();
  
  //database connection
  require_once 'Model/databaseConnection.php';
  use \Model\DatabaseConnection;
  $db = DatabaseConnection::getDatabaseConnection(); 
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>TP PHP</title>
    <link rel="stylesheet" href="View/style/list.css">
  </head>
  <body>
    <div id="menuBar">
     <p id="logo">g</p>
     <p><a href="/?action=home">Accueil</a></p>
    </div>
    
    
    
    <div id="main">
    <p>List of users</p>
    <?php 
      if($_SESSION["role"] === "0" || $_SESSION['role'] === "1"){
      ?>
        <table border="2">
        <tr>
          <td>Login</td>
          <td>role</td>
        </tr>
      <?php
      $records = mysqli_query($db,"select * from user;"); // fetch data from database
    
      while($data = mysqli_fetch_array($records))
      {
          $role = "";
          if($data['role'] === "0"){
            $role = "root";
          }
          elseif($data['role'] === "1"){
            $role = "admin";
          }
          else{
            $role = "user";
          }
      ?>
        <tr>
          <td><?php echo $data['login']; ?></td>
          <td><?php echo $role; ?></td>
          <?php
            if($data['role'] !== "0" && intval($_SESSION['role']) < intval($data['role'])){ //on fait en sorte qu'on ne puisse pas modifier root à tout prix et que l'on ne puisse pas modifier un utilisateur du même rôle que nous
              ?>
              <td><a href="/?action=edit&table=user&id=<?php echo $data['id']; ?>">Edit</a></td>
              <?php
            } 
            ?>
          
          
        </tr>	
      <?php
      }
      ?>
      </table>
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