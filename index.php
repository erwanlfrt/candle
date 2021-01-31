<?php
session_start();
require('Controller/controller.php');


if (isset($_GET['action'])) {
    
    if(empty($_SESSION['username']) && !(strpos($_GET['action'],"login") !== false) && !(strpos($_GET['action'], "signup") !== false) && !(strpos($_GET['action'], "resetPwd")  !== false) && !(strpos($_GET['action'],"check") !== false) && !(strpos($_GET['action'], "register") !== false)){
        forbidden();
    }
    elseif(strpos($_GET['action'],'login') !== false && isset($_SESSION['username'])){
        logout();
    }
    /*
    if(strpos($_GET['action'],"login") !== false){
        forbidden();
    }*/
    else{
        //controller
        if(strpos($_GET['action'],'check') !== false){
            check();
        }
        if(strpos($_GET['action'],'register') !== false){
            register();
        }
        if(strpos($_GET['action'],'resetPassword') !== false){
            resetPassword();
        }
        if(strpos($_GET['action'],"logout") !== false){
            logout();
        }
        

        //View
        if (strpos($_GET['action'],'login') !== false) {
            login();
        }
        elseif(strpos($_GET['action'],'forbidden') !== false){
            forbidden();
        }
        elseif(strpos($_GET['action'],'signup') !== false){
            signup();
        }
        elseif(strpos($_GET['action'],'resetPwd') !== false){
            resetPwd();
        }
        elseif(strpos($_GET['action'],'home') !== false){
            home();
        }
        elseif(strpos($_GET['action'],"stats") !== false){
            stats();
        }
        else{
            if(isset($_GET['table'])){
                computeAction($_GET['action'], $_GET['table'], $_GET['control']);
            }
            else{
                login();
            }
            
        }
    }

    
}
else {
    login();
}
?>