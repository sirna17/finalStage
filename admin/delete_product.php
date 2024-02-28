<?php
    session_start();

    require_once 'db.php';
    
    if(!isset($_SESSION['prenom']) && empty($_SESSION['prenom'])){
        header('location:../index.php');
        exit();
    }

    
    if(isset($_GET['id_produit'])){
        $db->query('DELETE FROM produits WHERE id_produit=' .$_GET["id_produit"]. '');
		header('Location: select_product.php');
    }else{
        $message = 'Le produit n\'a pas pu être supprimer';
    }