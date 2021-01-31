

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>TP PHP</title>
    <link rel="stylesheet" href="View/style/style.css">
  </head>
  <body>
    <div class="main">
      <p id="title">Welcome</p>
      <p id="logo">g</p>
      <form action="?action=check" method="post">
        <div>
            <input type="text" id="username" name="username" placeholder="Username">
        </div>
        <div>
            <input type="password" id="password" name="password" placeholder="Password">
        </div>
        <div class="button">
          <input type="submit" class="submit" id='submit' value='Log in' >
        </div>
        <?php
            if(isset($_GET['erreur'])){
              $err = $_GET['erreur'];
              if($err==1)
              {
                echo "<p style='color:red'>Invalid form</p>";
              }
              elseif($err==2){
                echo "<p style='color:red'>User already exist</p>";
              }
              elseif($err==3)
              {
                echo "<p style='color:red'>Passwords don't match</p>";
              }
              elseif($err==4)
              {
                echo "<p style='color:red'>wrong login and/or password</p>";
              }
          }
          ?>
      </form>
      <p>Don't have an account? <a href="/?action=signup">Sign up</a></p>
      <p><a href="/?action=resetPwd">Forgot password ?</a></p>
    </div>
  </body>
</html>

