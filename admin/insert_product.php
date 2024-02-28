<?php
// Inclut le fichier config.php qui contient les informations de db à la base de données.
include('db.php');

//Récupère les données soumises via le formulaire en utilisant $_POST pour les champs de texte et $_FILES pour les fichiers (images).

// Récupération des données du formulaire
$titre = $_POST['titre'];
$avantages = $_POST['avantages'];
$prix = $_POST['prix'];
$prix_reduit = isset($_POST['prix_reduit']) ? $_POST['prix_reduit'] : null;
$nb_etoiles = isset($_POST['nb_etoiles']) ? $_POST['nb_etoiles'] : null;
$nombre_ratings = isset($_POST['ratings']) ? $_POST['ratings'] : null; 
$nombre_achat_mensuel = isset($_POST['achat_mensuel']) ? $_POST['achat_mensuel'] : null;
$lien_amazon = isset($_POST['lien_amazon']) ? $_POST['lien_amazon'] : null;
$avantages_produit = isset($_POST['avantages_produit']) ? $_POST['avantages_produit'] : null;
$commentaires_produit = isset($_POST['commentaires']) ? $_POST['commentaires'] : null;

// Vérifier si le répertoire "uploads" existe, sinon le créer
$uploadsDir = 'uploads/';
if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
}

// Traitement de l'image principale (Déplace le fichier de l'image principale vers le répertoire "uploads",Insère le chemin de l'image principale dans la table "images_principales".)
// $cheminImagePrincipale = $uploadsDir . basename($_FILES['img_principale']['name']);

$nomImage = $_FILES['img_principale']['name']; 
$infosFichier = pathinfo($_FILES['img_principale']['name']);
$extensionImage = $infosFichier['extension'];
$renommeNomImage = $titre.'_'.date('Ymdhis').'.'.$extensionImage;
$imagePrincipaleUnique = str_replace($nomImage, $_FILES['img_principale']['name'], $renommeNomImage);
$cheminImagePrincipale = $uploadsDir . basename($imagePrincipaleUnique);

move_uploaded_file($_FILES['img_principale']['tmp_name'], $cheminImagePrincipale);

// Commencer une transaction pour l'insertion d'un nouveau produit
try {
    // Début de la transaction pour garantir l'intégrité des données lors de l'insertion.
    $db->beginTransaction();

    // Insérer le produit dans la table Produits (Utilise une requête préparée pour insérer les informations du produit dans la table "produits".)
    
    $sql = "INSERT INTO produits (titre, avantages, prix, prix_reduit, nb_etoiles, ratings, achat_mensuel, lien_amazon) 
            VALUES (:titre, :avantages, :prix, :prix_reduit, :nb_etoiles, :nombre_ratings, :nombre_achat_mensuel, :lien_amazon)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':avantages', $avantages);
    $stmt->bindParam(':prix', $prix);
    $stmt->bindParam(':prix_reduit', $prix_reduit);
    $stmt->bindParam(':nb_etoiles', $nb_etoiles);
    $stmt->bindParam(':nombre_ratings', $nombre_ratings);
    $stmt->bindParam(':nombre_achat_mensuel', $nombre_achat_mensuel);
    $stmt->bindParam(':lien_amazon', $lien_amazon);
    $stmt->execute();

    // Récupérer l'ID du produit nouvellement inséré (pour récupérer l'ID du produit que nous venons d'insérer.)
    $idProduit = $db->lastInsertId();

    // Insérer les avantages dans la table Avantages
    $sqlAvantages = "INSERT INTO avantages (id_produit, avantage) VALUES (:id_produit, :avantage)";
    $stmtAvantages = $db->prepare($sqlAvantages);
    $stmtAvantages->bindParam(':id_produit', $idProduit);
    $stmtAvantages->bindParam(':avantage', $avantages_produit);
    $stmtAvantages->execute();

    // Insérer les commentaires dans la table Commentaires
    $sqlCommentaires = "INSERT INTO commentaires (id_produit, commentaire) 
                        VALUES (:id_produit, :commentaire)";
    $stmtCommentaires = $db->prepare($sqlCommentaires);
    $stmtCommentaires->bindParam(':id_produit', $idProduit);
    $stmtCommentaires->bindParam(':commentaire', $commentaires_produit);
    $stmtCommentaires->execute();

    // Insérer l'image principale dans la table Images Principales
    $sqlImagePrincipale = "INSERT INTO images_principales (id_produit, img_principale, type_image) 
                          VALUES (:id_produit, :img_principale, 'principale')";
    $stmtImagePrincipale = $db->prepare($sqlImagePrincipale);
    $stmtImagePrincipale->bindParam(':id_produit', $idProduit);
    $stmtImagePrincipale->bindParam(':img_principale', $cheminImagePrincipale);
    $stmtImagePrincipale->execute();

    

    // Traitement des images miniatures (Vérifie si des fichiers d'images miniatures ont été soumis,Pour chaque fichier miniature, le déplace vers le répertoire "uploads" et insère le chemin dans la table "images_miniatures")
    if (!empty($_FILES['img_thumbs']['name'][0])) {
        foreach ($_FILES['img_thumbs']['tmp_name'] as $key => $tmp_name) {
            $originalFileName = basename($_FILES['img_thumbs']['name'][$key]);
            $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
            
            // Créer un nom de fichier unique en utilisant le timestamp
            $uniqueFileName = time() . '_' . uniqid() . '.' . $fileExtension;
            
            $cheminImageMiniature = $uploadsDir . $uniqueFileName;
            move_uploaded_file($tmp_name, $cheminImageMiniature);
    
            // Insérer l'image miniature dans la table Images Miniatures
            $sqlImageMiniature = "INSERT INTO images_miniatures (id_produit, img_thumbs, type_image) 
                                  VALUES (:id_produit, :img_thumbs, 'miniature')";
            $stmtImageMiniature = $db->prepare($sqlImageMiniature);
            $stmtImageMiniature->bindParam(':id_produit', $idProduit);
            $stmtImageMiniature->bindParam(':img_thumbs', $cheminImageMiniature);
            $stmtImageMiniature->execute();
        }
    }
    

    // Valider la transaction
    $db->commit();

    // Rediriger vers la page d'accueil  après l'insertion réussie.
    $_SESSION['messageInfos'] = 'div class="messageInfos"><h2 class="valide"><i class="fa-solid fa-face-smile-wink"></i> Le produit à bien été ajouté.</h2></div>';
    header("Location: dashboard.php");
    exit();

    // Gestion des erreurs avec une transaction
} catch (Exception $e) {
    // En cas d'erreur lors de l'exécution des requêtes, annuler la transaction 
    $db->rollBack();

    // Gérer l'erreur comme nécessaire (Affiche un message d'erreur.)
    $_SESSION['messageInfos'] = 'div class="messageInfos"><h2 class="valide"><i class="fa-solid fa-triangle-exclamation"></i> Le produit n\'à pas été ajouté.</h2></div>';
    header("Location: dashboard.php");
    exit();
    die("Erreur : " . $e->getMessage());
} finally { // Dans le bloc finally, la db à la base de données est fermée 
    // Fermer la db à la base de données
    $db = null;
}
?>
