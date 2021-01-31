
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>TP PHP</title>
    <link rel="stylesheet" href="View/style/style.css">
  </head>
  <body>
    <div class="main">
      <p id="title">Reset your password </p>
      <p id="logo">g</p>

      <form action="?action=resetPwd" method="post">
      <div>
          <input type="text" id="username" name="username" placeholder="username">
      </div>
      <div>
          <input type="password" id="password" name="password" placeholder="password">
      </div>
      <div>
        <input type="password" name="password_confirm" placeholder="confirm password" /><br />
      </div>
      <div class="button">
         <input type="submit" id='submit' class="submit" value='reset password' >
      </div>
      <div>
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
            elseif($err==5){
              echo "<p style='color:red'>User doesn't exist. Do you want to <a href='/?action=signup'>sign up?</a></p>";
            }
          }
      ?>
    </div>
  </form>
    </div>
    
  </body>
</html>