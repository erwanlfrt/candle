<?php
session_start();
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
    <p>List of books</p>
    <table border="2">
    <tr>
      <td>Id</td>
      <td>titre</td>
      <td>auteur</td>
    </tr>

  <?php
  $records = mysqli_query($db,"select * from livre;"); // fetch data from database
  while($data = mysqli_fetch_array($records)){
    // get the name of the author
    $author = $data['id_auteur'];
    $queryCheck = "SELECT nom_auteur FROM auteur where id_auteur='".$author."'";
    $exec_requete = mysqli_query($db,$queryCheck);
    $reponse = mysqli_fetch_array($exec_requete);
    $name_author= $reponse['nom_auteur'];  
  ?>
    <tr>
      <td><?php echo $data['id_livre']; ?></td>
      <td><?php echo $data['titre']; ?></td>
      <td><a href="?action=edit&table=author&id=<?php echo $author; ?>"><?php echo $name_author; ?></a></td>
      <td><a href="?action=edit&table=book&id=<?php echo $data['id_livre']; ?>">Edit</a></td>
      <td><a href="?action=delete&control&table=book&id=<?php echo $data['id_livre']; ?>">Delete</a></td>
    </tr>	
  <?php
  }
  ?>
  </table>
  <button><a href="?action=add&table=book">Add book</a></button>
  </body>
</html>