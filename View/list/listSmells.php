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
    <p>List of smells</p>
    <table border="2">
      <tr>
        <td>Id</td>
        <td>Name</td>
        <td>Status</td>
      </tr>
      <?php
        //database connection
        require_once 'Model/databaseConnection.php';
        use \Model\DatabaseConnection;

        $db = DatabaseConnection::getDatabaseConnection(); 

        $records = mysqli_query($db,"select * from odeur;"); // fetch data from database

        while($data = mysqli_fetch_array($records))
        {
      ?>
      <tr>
        <td><?php echo $data['id_odeur']; ?></td>
        <td><?php echo $data['nom_odeur']; ?></td> 
        <td><?php echo $data['statut_odeur']; ?></td> 
        <td><a href="?action=edit&table=smell&id=<?php echo $data['id_odeur']; ?>">Edit</a></td>
        <!-- <td><a href="deleteAuthor.php?id=<?php echo $data['id_odeur']; ?>">Delete</a></td> -->
      </tr>	
      <?php
        }
      ?>
    </table>
    <button><a href="?action=add&table=smell">Add smell</a></button>

  </body>
</html>