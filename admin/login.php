<?php
	require_once 'db.php';

	session_start();
	

	if(isset($_SESSION['prenom']) && !empty($_SESSION['prenom'])){
        header('location: dashboard.php');
    }

	$message = ' ';

	if(isset($_POST['valider'])){
		// Récupère les variables depuis le formulaires
		$email = $_POST['email'];
		$password = $_POST['password'];

		// Traitement et insertion dans la base de données
		if(empty($email) || empty($password)){ // Vérification
			$message =  '<div class="messageInfos"><h1 style="color:#f00"><i class="fa-solid fa-triangle-exclamation"></i> Veuillez remplir tous les champs</h2></div>';
		}else{ 
			$sql_select = 'SELECT * FROM administrateurs WHERE email = :email';
			
			$req_select = $db->prepare($sql_select);
			$req_select->bindValue(':email', $email);
			$req_select->execute();
					
			$data = $req_select->fetch(PDO::FETCH_OBJ);

			$hash = @$data->pass;
		
			

			if($data && password_verify($password, $hash)){
				$_SESSION['administrateurID'] = $data->administrateurID;
				$_SESSION['nom'] = $data->nom;
				$_SESSION['prenom'] = $data->prenom;
				$_SESSION['email'] = $data->email;
				
				setcookie('email', $_POST['email'], time()+3600*24*7, '/');
			
				header('location:dashboard.php');
			}else{
				$message = '<div class="messageInfos"><h1 style="color:#f00"><i class="fa-solid fa-ban"></i> Accès refusé !</h1></div>';
			}				
		} 
	}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<?php //require_once('inc/meta.php'); ?>
		<link rel="stylesheet" href="css/login.css">
		<script src="https://kit.fontawesome.com/02b1d6d912.js" crossorigin="anonymous"></script>
		<title>Technomania - Connexion</title>
		<style>
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
		<section>
			<?php echo $message; ?>
			<div id="formulaire">
				<form action="" method="post" id="login">
					<div id="header-form">
						<i class="fa-solid fa-key"></i>
						<h1>Login</h1>
					</div>
					
					<div class="container-input">
						<i class="fa-solid fa-at"></i>
						<input type="email" name="email" id="email" placeholder="Votre email" value="<?php if(isset($_COOKIE['email'])) echo $_COOKIE['email']; ?>">
					</div>

					<div class="container-input">
						<i class="fa-solid fa-lock"></i>
						<input type="password" name="password" id="password" placeholder="Votre mot de passe" value="<?php if(isset($_COOKIE['password'])) echo $_COOKIE['password']; ?>">
					</div>

					<div class="container-submit">
						<input type="submit" name="valider" value="Login">
					</div>
				</form>
			</div>
    	</section>
	</body>
	<script src="js/verif_formulaire.js"></script>
</html>


