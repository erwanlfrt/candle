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
      <link rel="stylesheet" href="View/style/list.css?version=1">
    </head>
    <body>
      <div id="menuBar">
        <p id="logo">g</p>
        <p><a href="/?action=home">Accueil</a></p>
      </div>
      <div id="main">
        <?php 
          if($_SESSION["role"] === "0" || $_SESSION['role'] === "1"){
          ?>
            <table border="2" style="margin-bottom : 2%; margin-top : 2%">
            <tr>
              <th>Tables</th>
            <?php
              $tableList = array("auteur", "livre", "bougie", "collection", "odeur", "recette", "event", "user");
              $countTables = array();

              foreach($tableList as $table){
                $queryCheck = "SELECT count(*) FROM $table ";
                $exec_requete = mysqli_query($db,$queryCheck);
                $reponse = mysqli_fetch_array($exec_requete);
                $count = $reponse['count(*)'];
                ?><tr><th><?php echo $table; ?></th><td><?php echo $count; ?></td></tr> <?php
              }
            ?>
          </table>
          <table style="margin-bottom : 2%; margin-top : 2%">
          <tr>
            <th>Nombre de livres par écrivain</th>
          </tr>
          <?php

            $query = "SELECT id_auteur, nom_auteur from auteur;";
            $exec_request = mysqli_query($db,$query);

            while($data = mysqli_fetch_array($exec_request)){
              $query = "SELECT count(*) from livre where id_auteur = ".$data['id_auteur'].";";
              $exec_requete= mysqli_query($db,$query);
              $reponse = mysqli_fetch_array($exec_requete);
              $count = $reponse['count(*)'];
          ?>
              <tr>
                <th><?php echo $data["nom_auteur"]; ?> </th>
                <td><?php echo $count; ?></td>
              </tr>           
            <?php  
            }
            ?>
            </table>
            
            <table style="margin-bottom : 2%; margin-top : 2%">
              <tr>
              <th>Recette par quantité</th>
              </tr>
              <?php
              $query = "SELECT id_recette, quantité from recette";
              $exec_requete= mysqli_query($db,$query);
              while($data = mysqli_fetch_array($exec_requete)){
                ?>
                <tr>
                  <th><?php echo $data["id_recette"] ?></th>
                  <td><?php echo $data["quantité"]?></td>
                </tr>
                <?php
              }
              ?>
            </table>
            <table style="margin-bottom : 2%; margin-top : 2%"> 
              <tr>
                <th>Nombre de bougie par collection</th>
              </tr>
              <?php
              $query = "SELECT id_collection, nom_collection from collection";
              $exec_requete= mysqli_query($db,$query);
              while($data = mysqli_fetch_array($exec_requete)){
                $query = "select count(*) from bougie where id_collection = ".$data["id_collection"].";";
                $exec_request= mysqli_query($db,$query);
                $reponse = mysqli_fetch_array($exec_request);
                $count = $reponse['count(*)'];
                ?>
                <tr>
                  <th><?php echo $data["nom_collection"]; ?></th>
                  <td><?php echo $count; ?></td>
                </tr>
                <?php
              }
          }
          else{
            ?>
            <p>Vous n'êtes pas autorisé à accéder à cette page</p>
            <?php
          } 
        ?>
        </table>
      </div>
     
    </body>
  </html>