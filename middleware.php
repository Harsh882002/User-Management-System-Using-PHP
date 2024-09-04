<?php
// session_start(); // Ensure session is started

if(isset($_SESSION['is_user_loggedin'])){
    return true;
    header("Location: add_user.php");

}else{
    header("Location: index.php");
    exit; // Ensure script execution stops after redirection
}
?>
