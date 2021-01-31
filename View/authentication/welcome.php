<?php
    session_start();
?>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="View/style/page.css?version=1">
    </head>

    <body>
        <div id="content">
            <div class="menuBar">
                <p id="logo">g</p>
                <div class="logoutDiv">
                    <p><a href="?action=logout">Log out</a></p>
                </div>
            </div>

            <div id="panels">
                <div class="userPanel panel">
                    <?php
                        if(!(empty($_SESSION['username']))){ //check if user is connected
                            $user = $_SESSION['username'];
                            // afficher un message
                            if($_SESSION['role'] == 2){ //if non-admin user
                                echo "<p class='welcomeMessage'>Bonjour $user, vous êtes connecté</br></p>";
                            }
                            if($_SESSION['role'] < 2){ //if admin user
                                echo "<div id='adminLog'><p class='welcomeMessage'>Bonjour $user, vous êtes connecté</br></p>";
                            }
                            if($_SESSION['role'] == 0){ //if root
                                echo "Attention ! Vous êtes connecté en tant que root, un grand devoir implique une grande responsabilité...";
                            }
                        }
                    ?>
                </div>
                <div class="actionPanel panel">
                    <ul> <?php
                        if($_SESSION['role'] < 2){ //if admin user
                            ?> 
                            <li><a href="/?action=list&table=user"  style="color:red">List user</a></li>
                            <?php 
                        } ?>
                        <li><a href="?action=list&table=author">Lister les auteurs</a></li>
                        <li><a href="?action=list&table=book">Lister les livres</a></li>
                        <li><a href="?action=list&table=candle">Lister les bougies</a></li>
                        <li><a href="?action=list&table=collection">Lister les collections</a></li>
                        <li><a href="?action=list&table=event">Lister les events</a></li>
                        <li><a href="?action=list&table=recipe">Lister les recettes</a></li>
                        <li><a href="?action=list&table=smell">Lister les odeurs</a></li>
                        <li><a href="?action=stats">Statistiques</a></li>
                    </ul>

                </div>
            </div>
            
        </div>
        
    </body>
</html>