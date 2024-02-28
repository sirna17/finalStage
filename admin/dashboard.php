<?php
session_start();

require_once 'db.php';

if (isset($_SESSION['administrateurID'])) {
    $administrateurID = $_SESSION['administrateurID'];
    $prenom = $_SESSION['prenom'];
} else {
    header('location:../index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('inc/meta.php'); ?>
    <title>TECHNOMANIA - Panneaux d'administration</title>
    <style>
        h2.valide{
            color: #0f0;
        }

        h2.invalide{
            color: #f00;
            text-align: center;
        }
        
        .messageInfos{
			width: 400px;
			margin: 20px auto;
			background-color: #fff;
			border-radius: 8px;
			box-shadow: 0 1px 2px rgba(0,0,0,0.5);
			padding: 10px;
		}

		.messageInfos h1, #messageInfos h2{
			font-family: Arial, Helvetica, sans-serif;
			font-size: 1rem;
			font-weight: bold;
		}
    </style>
</head>
<body>
    <header>
        <h1>TECHNOMANIA - Dashboard</h1>

        <div>
            <span><a href="deconnexion.php"><i class="fa-solid fa-user"></i></a></span>
            <h2><?php echo ucfirst($prenom); ?></h2>
        </div>

    </header>
    <?php 
        if(isset($_SESSION['messageInfos'])) {
            echo $_SESSION['messageInfos'];
            unset($_SESSION['messageInfos']);
        }
    ?>
    <main>
        <a href="../">
            <div class="card">
                <i class="fa-solid fa-home"></i>
                <h3>Home</h3>
            </div>
        </a>


        <a href="create_account.php">
            <div class="card">
                <i class="fa-solid fa-users"></i>
                <h3>Create account</h3>
            </div>
        </a>

        <a href="formulaire_product.php">
            <div class="card">
                <i class="fa-solid fa-circle-plus"></i>
                <h3>Add product</h3>
            </div>
        </a>

        <a href="select_product.php">
            <div class="card">
                <i class="fa-solid fa-rectangle-list"></i>
                <h3>List products</h3>
            </div>
        </a>
        
        <a href="deconnexion.php">
            <div class="card">
                <i class="fa-solid fa-power-off"></i>
                <h3>Logout</h3>
            </div>
        </a> 

    </main>
</body>
</html>