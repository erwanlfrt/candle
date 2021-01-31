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
    <p>List of recipes</p>
    <table border="2">
      <tr>
        <td>Id</td>
        <td>Quantity</td>
        <td>Candle</td>
        <td>Odeur</td>
      </tr>

      <?php
        //database connection
        require_once 'Model/databaseConnection.php';
        use \Model\DatabaseConnection;
        $db = DatabaseConnection::getDatabaseConnection(); 

        $records = mysqli_query($db,"select * from recette;"); // fetch data from database

        while($data = mysqli_fetch_array($records))
        {
          // get the name of the candle
          $candle = $data['id_bougie'];
          $queryCheck = "SELECT nom_bougie FROM bougie where
          id_bougie='".$candle."'";
          $exec_requete = mysqli_query($db,$queryCheck);
          $reponse = mysqli_fetch_array($exec_requete);
          $name_candle= $reponse['nom_bougie'];  

          //get the name of the smell
          $smell= $data['id_odeur'];
          $queryCheck = "SELECT nom_odeur FROM odeur where
          id_odeur='".$smell."'";
          $exec_requete = mysqli_query($db,$queryCheck);
          $reponse = mysqli_fetch_array($exec_requete);
          $name_smell= $reponse['nom_odeur'];  
      ?>
        <tr>
          <td><?php echo $data['id_recette']; ?></td>
          <td><?php echo $data['quantité']; ?></td>
          <td><a href="?action=edit&table=candle&id=<?php echo $candle; ?>"><?php echo $name_candle; ?></a></td>
          <td><a href="?action=edit&table=smell&id=<?php echo $smell; ?>"><?php echo $name_smell; ?></a></td>
          <td><a href="?action=edit&table=recipe&id=<?php echo $data['id_recette']; ?>">Edit</a></td>
          <td><a href="?action=delete&table=recipe&control&id=<?php echo $data['id_recette']; ?>">Delete</a></td>
        </tr>	
      <?php
      }
      ?>
    </table>
    <button><a href="?action=add&table=recipe">Add recipe</a></button>
  </body>
</html>