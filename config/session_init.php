<?php

//Start session
session_start();

function isLoggedIn(){
    if(isset($_SESSION['loggedin'])){
        return true;
    }
    else{
        return false;
    }
}

function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_role'] = $user->role;
        $_SESSION['name'] = $user->first_name;
        $_SESSION['profileImg'] = $user->img;
    }

//Redirect
function redirect($page){
    header('location: ' . URLROOT . '/' . $page);
}

?>
