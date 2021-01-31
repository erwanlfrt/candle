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
    <p>List of events</p>
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

        $records = mysqli_query($db,"select * from event;"); // fetch data from database

        while($data = mysqli_fetch_array($records)){
      ?>
        <tr>
          <td><?php echo $data['id']; ?></td>
          <td><?php echo $data['name']; ?></td> 
          <td><a href="?action=edit&table=event&id=<?php echo $data['id']; ?>">Edit</a></td>
          <!-- <td><a href="deleteAuthor.php?id=<?php echo $data['id']; ?>">Delete</a></td> -->
        </tr>	
      <?php
      }
      ?>
    </table>
    <button><a href="?action=add&table=event">Add event</a></button>
  </body>
</html>