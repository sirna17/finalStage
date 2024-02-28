<?php
    session_start();

    require_once 'db.php';

    if(!isset($_SESSION['prenom']) && empty($_SESSION['prenom'])){
        header('location:../index.php');
        exit();
    }

    // Traitement du formulaire
    if (isset($_POST['valider'])) {
        // Nom de l'image avec le préfixe 'uploads/' et un identifiant unique (timestamp)
        $newFileName = 'uploads/' . time() . '_' . $_FILES['img_principale']['name'];

        // Chemin de destination pour sauvegarder l'image
        $destination = __DIR__ . '/' . $newFileName;

        // Déplace l'image téléchargée vers le dossier de destination
        move_uploaded_file($_FILES['img_principale']['tmp_name'], $destination);
            
        // Récupère l'image principale
        $sqlSelectImagePrincipale = 'SELECT * FROM images_principales WHERE id_image_principale = ' . $_POST['id_produit'];
        $reqSelectImagePrincipale = $db->query($sqlSelectImagePrincipale);
        $data = $reqSelectImagePrincipale->fetch(PDO::FETCH_OBJ);
        $image_principale = $data->img_principale;
            
        // Met à jour le nom de l'image principale dans la base de données
        $sqlUpdateImagePrincipale = 'UPDATE images_principales SET img_principale = :img_principale WHERE id_image_principale = :id_produit';
        $reqUpdateImagePrincipale = $db->prepare($sqlUpdateImagePrincipale);
        $reqUpdateImagePrincipale->bindParam(':img_principale', $newFileName);
        $reqUpdateImagePrincipale->bindParam(':id_produit', $_POST['id_produit']);
        $reqUpdateImagePrincipale->execute();

        header('location: update_product.php?id_produit='.$_POST['id_produit']);
        exit;
    }
    ?>