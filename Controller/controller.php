<?php 

//Model

/**
 * Load check.php to check if authentication is correct.
 */
function check(){
    require('Model/authentication/check.php');
}

/**
 * Load logout.php to log out.
 */
function logout(){
    require('Model/authentication/logout.php');
}

/**
 * Load register.php to register a new user.
 */
function register(){
    require('Model/authentication/signup.php');
}

/**
 * Load resetPwd.php to reset a password. 
 */
function resetPassword(){
    require('Model/authentication/resetPwd.php');
}


//View

/**
 * load forbidden webpage.
 */
function forbidden(){
    require('View/authentication/forbidden.php');
}

/**
 * Load the home webpage.
 */
function home(){
    require('View/authentication/welcome.php');
}

/**
 * Load login webpage.
 */
function login(){
    require('View/authentication/login.php');
}

/**
 * Loada the "reset password" form.
 */
function resetPwd(){
    require('View/authentication/resetPwdForm.php');
}

/**
 * Load signup webpage.
 */
function signup(){
    require('View/authentication/register.php');
}

/**
 * Load the statistics webpage.
 */
function stats(){
    require('View/stats/stats.php');
}


//Model or View

/**
 * Load the correct file depending of the action and the table. It can load a view or a model depending on what we are looking for.
 * @param action wanted action. It can be "list", "add" or "edit"
 * @param table target table. It can be "author", "book", "candle", "collection", "event", "recipe", "smell" or "user"
 * @param control true if you want to load the Model, false if you need to load the View.
 */
function computeAction($action, $table, $control){
    $actionList = array("add", "edit", "list"); //array of possible actions
    $tableList = array("author", "book", "candle", "collection", "event", "recipe", "smell", "user"); //array of possible tables
    if(isset($action) && isset($table)){ //If we have an action and a table...
        if(in_array($action, $actionList) && in_array($table, $tableList)){ //... and the action such as the table are valid
            if($action == "list"){
                require("View/".$action."/".$action."".ucfirst($table)."s.php"); //require the listView if we want to list.
            }
            else{ //If we want to edit or to add
                if(isset($control)){
                    require("Model/tables/".$table.".php"); //load the model
                }
                else{
                    require("View/".$action."/".$action."".ucfirst($table)."View.php"); //load the view
                }
                
            }
        }
        else{
            require('View/authentication/welcome.php'); //go back to home webpage
        }
    }
    else{
        require('View/authentication/welcome.php'); //go back to home webpage
    }
}

?>