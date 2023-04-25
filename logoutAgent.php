<?php 
session_start() ; 
    unset($_SESSION['agent_id']) ; 
    header("Location:login.php"); 
    exit(0) ;
?>