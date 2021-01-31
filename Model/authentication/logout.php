<?php   
session_start(); 
session_destroy(); //destroy the session
header("location: ?action=login"); //to redirect back to login webpage after loggin out.
exit();
?>