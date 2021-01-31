
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
      <form action="?action=add&table=recipe&control" method="post">
        <div>
              <input class="textField" type="text" id="quantity" name="quantity" placeholder="quantity">
              <input class="textField" type="text" id="candle" name="candle" placeholder="candle">
              <input class="textField" type="text" id="smell" name="smell" placeholder="smell">
        </div>
        <div class="button">
          <input type="submit" id='submit' value='add recipe' >
        </div>
        <div>
          <?php
              if(isset($_GET['erreur'])){
                $err = $_GET['erreur'];
                if($err==1 || $err==2)
                {
                      echo "<p style='color:red'>Recipe already exist</p>";
                }
                elseif($err==3){
                      echo "<p style='color:red'>Invalid form</p>";
                }
                elseif($err==4){
                      echo "<p style='color:red'>Candle unkown</p>";
                } 
                elseif($err==5){
                  echo "<p style='color:red'>Smell unknown</p>";
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
    }
  ?>
  </body>
</html>