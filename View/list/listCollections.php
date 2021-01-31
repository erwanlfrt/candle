<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <!--
    Modified from the Debian original for Ubuntu
    Last updated: 2016-11-16
    See: https://launchpad.net/bugs/1288690
  -->
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
    <p>List of collections</p>
    <table border="2">
    <tr>
      <td>Id</td>
      <td>Name</td>
    </tr>

    <?php
      //database connection
      require_once 'Model/databaseConnection.php';
      use \Model\DatabaseConnection;
      $db = DatabaseConnection::getDatabaseConnection(); 

      $records = mysqli_query($db,"select * from collection;"); // fetch data from database

      while($data = mysqli_fetch_array($records)){
    ?>
      <tr>
        <td><?php echo $data['id_collection']; ?></td>
        <td><?php echo $data['nom_collection']; ?></td> 
        <td><a href="?action=edit&table=collection&id=<?php echo $data['id_collection']; ?>">Edit</a></td>
        <!-- <td><a href="deleteAuthor.php?id=<?php echo $data['id_collection']; ?>">Delete</a></td> -->
      </tr>	
    <?php
    }
    ?>
    </table>
    <button><a href="?action=add&table=collection">Add collection</a></button>
  </body>
</html>