<html>
<head>
  <title>User Registration</title>
  <link rel="stylesheet" href="View/style/style.css">
</head>
<body>
  <div class="main">
      <h1 id="title">Register</h1>
      <p id="logo">g</p>
    
      <form action="?action=register" method="POST">
        <input type="text" name="username" placeholder="username"/><br />
        <input type="password" name="password" placeholder="password" /><br />
        <input type="password" name="password_confirm" placeholder="confirm password" /><br />
        <input type="submit"  class="submit" value="Register" />
      </form>
      <div>
        <?php
                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1)
                    {
                      echo "<p style='color:red'>Invalid form</p>";
                    }
                    else if($err==2){
                      echo "<p style='color:red'>User already exist</p>";
                    }
                    else if($err==3)
                    {
                      echo "<p style='color:red'>Passwords don't match</p>";
                    }
                    else if($err==4)
                    {
                      echo "<p style='color:red'>wrong login and/or password</p>";
                    }
                }
        ?>
      </div>
  </div>
  
</body>
</html>