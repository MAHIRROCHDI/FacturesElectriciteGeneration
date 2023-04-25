<?php 
session_start() ; 
    unset($_SESSION['client_id']) ; 
    header("Location:login.php"); 
    exit(0) ;
?>