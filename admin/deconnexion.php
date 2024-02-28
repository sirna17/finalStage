<?php
	session_start();
	
	if(!isset($_SESSION['prenom']) && empty($_SESSION['prenom'])){
        header('location:../index.php');
        exit();
    }

	require 'db.php';
	
	session_destroy();
	
	unset($_SESSION['email']);
	unset($_SESSION['password']);
	
	header('Location: ../index.php');

