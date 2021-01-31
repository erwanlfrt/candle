<?php 
  session_start();
  //prevent CSRF with a token.
  $token = uniqid(rand(), true); //generate a token
  $_SESSION['token'] = $token;  //add token to session
  $_SESSION['token_time'] = time(); //add the token's date of creation.

?>
<!DOCTYPE html>
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
        if($_SESSION["role"] === "0" || $_SESSION['role'] === "1"){ //webpage not available for non-admin user
      ?>
      <div id="main">
        <form action="?action=add&table=author&control" method="post">
          <div>
              <input class="textField" type="text" id="name" name="name" placeholder="name">
          </div>
          <div class="button">
            <input type="hidden" name="token" id="token" value="<?php echo $token;?>"/>
            <input type="submit" id='submit' value='add author' >
          </div>
          <div>
          <?php
              if(isset($_GET['erreur'])){
                  $err = $_GET['erreur'];
                  if($err==1 || $err==2)
                  {
                    echo "<p style='color:red'>Author already exist</p>";
                  }
                  elseif($err==3){
                      echo "<p style='color:red'>Invalid form</p>";
                  }
              }
          ?>
        </div>
      </form>
      </div>
      <?php
        }
        else{
          ?>
          <p>Vous n'êtes pas autorisé à accéder à cette page</p>
          <?php
        } ?>
  </body>
</html>