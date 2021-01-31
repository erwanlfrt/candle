<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>TP PHP</title>
    <link rel="stylesheet" href="View/style/list.css?version=1">
  </head>
  <body>
    <div id="menuBar">
     <p id="logo">g</p>
     <p><a href="/?action=home">Accueil</a></p>
    </div>

    <div id="main">
      <p>List of authors</p>
      <table border="2">

      <?php
        //Database connection
        require_once 'Model/databaseConnection.php';
        use \Model\DatabaseConnection;
        $db = DatabaseConnection::getDatabaseConnection(); 
        $records = mysqli_query($db,"select * from auteur;"); // fetch data from database

        while($data = mysqli_fetch_array($records)){
      ?>
        <tr>
          <td class="authorList"><?php echo $data['nom_auteur']; ?></td> 
          <td><a href="?action=edit&table=author&id=<?php echo $data['id_auteur']; ?>">Edit</a></td>
        </tr>	
      <?php
        }
      ?>
      </table>
      <button><a href="/?action=add&table=author">Add author</a></button>
    </div>
  </body>
</html>