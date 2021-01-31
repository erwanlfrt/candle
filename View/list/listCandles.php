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
    <p>List of candles</p>
    <table border="2">
    <tr>
      <td>Id</td>
      <td>Nom bougie</td>
      <td>Statut</td>
      <td>Livre</td>
      <td>Collection</td>
    </tr>

    <?php

      //database connection
      require_once 'Model/databaseConnection.php';
      use \Model\DatabaseConnection;
      $db = DatabaseConnection::getDatabaseConnection(); 

      $records = mysqli_query($db,"select * from bougie;"); // fetch data from database

      while($data = mysqli_fetch_array($records))
      {
        // get the title of the book
        $book = $data['id_livre'];
        $queryCheck = "SELECT titre FROM livre where
        id_livre='".$book."'";
        $exec_requete = mysqli_query($db,$queryCheck);
        $reponse = mysqli_fetch_array($exec_requete);
        $title= $reponse['titre'];  


        //get the collection
        $collection = $data['id_collection'];
        $queryCheck = "SELECT nom_collection FROM collection where
        id_collection='".$collection."'";
        $exec_requete = mysqli_query($db,$queryCheck);
        $reponse = mysqli_fetch_array($exec_requete);
        $name_collection= $reponse['nom_collection'];  


    ?>
      <tr>
        <td><?php echo $data['id_bougie']; ?></td>
        <td><?php echo $data['nom_bougie']; ?></td>
        <td><?php echo $data['statut_bougie']; ?></td>
        <td><a href="?action=edit&table=book&id=<?php echo $book; ?>"><?php echo $title; ?></a></td>
        <td><a href="?action=edit&table=collection&id=<?php echo $collection; ?>"><?php echo $name_collection; ?></a></td>
        <td><a href="?action=edit&table=candle&id=<?php echo $data['id_bougie']; ?>">Edit</a></td>
      </tr>	
    <?php
    }
    ?>
    </table>
    <button><a href="?action=add&table=candle">Add candle</a></button>

  </body>
</html>