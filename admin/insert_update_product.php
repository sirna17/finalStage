<?php
    session_start();
    
    require_once 'db.php';

    if(!isset($_SESSION['prenom']) && empty($_SESSION['prenom'])){
        header('location:../index.php');
        exit();
    }

    if(isset($_POST['valider'])){
        if(isset($_POST['id_produit'], $_POST['titre'], $_POST['avantages'], $_POST['prix'], $_POST['prix_reduit'], $_POST['lien_amazon'], $_POST['achat_mensuel'], $_POST['nb_etoiles'], $_POST['ratings'])){
            $id_produit = $_POST['id_produit'];
            $titre = $_POST['titre'];
            $avantages = $_POST['avantages'];
            $prix = $_POST['prix'];
            $prix_reduit = $_POST['prix_reduit'];
            $lien_amazon = $_POST['lien_amazon'];
            $achat_mensuel = $_POST['achat_mensuel'];
            $nb_etoiles = $_POST['nb_etoiles'];
            $ratings = $_POST['ratings'];

            /* Si tous les champs sont vides */
            if(empty($titre) && empty($avantages) && empty($prix) && empty($prix_reduit) && empty($lien_amazon) && empty($achat_mensuel) && empty($nb_etoiles) && empty($ratings)){
                $_SESSION['messageInfos'] = '<div class="messageInfos"><h2 class="invalide"><i class="fa-solid fa-triangle-exclamation"></i> Vous devez remplir tous les champs</h2></div>';
                header('location: update_product.php?id_produit='.$id_produit.'');
                exit();
            }

            /* Si pas de titre */
            if($titre == ''){
                $_SESSION['messageInfos'] = '<div class="messageInfos"><h2 class="invalide"><i class="fa-solid fa-triangle-exclamation"></i> Vous devez saisir un titre pour le produit</h2></div>';
                header('location: update_product.php?id_produit='.$id_produit.'');
                exit();
            }

            /* Si les avantages ne sont pas remplis */
            if($avantages == ''){
                $_SESSION['messageInfos'] = '<div class="messageInfos"><h2 class="invalide"><i class="fa-solid fa-triangle-exclamation"></i> Vous devez saisir les avantages</h2></div>';
                header('location: update_product.php?id_produit='.$id_produit.'');
                exit();
            }

            /* Si le prix est vide */
            if($prix == ''){
                $_SESSION['messageInfos'] = '<div class="messageInfos"><h2 class="invalide"><i class="fa-solid fa-triangle-exclamation"></i> Vous devez entrer un prix</h2></div>';
                header('location: update_product.php?id_produit='.$id_produit.'');
                exit();
            }

            if($prix_reduit == ''){
                $_SESSION['messageInfos'] = '<div class="messageInfos"><h2 class="invalide"><i class="fa-solid fa-triangle-exclamation"></i> Vous devez entrer un prix réduit</h2></div>';
                header('location: update_product.php?id_produit='.$id_produit.'');
                exit();
            }

            // Si pas de lien Amazon
            if($lien_amazon == ''){
                $_SESSION['messageInfos'] = '<div class="messageInfos"><h2 class="invalide"><i class="fa-solid fa-triangle-exclamation"></i> Vous devez enter un lien Amazon</h2></div>';
                header('location: update_product.php?id_produit='.$id_produit.'');
                exit();
            }
            

             /* Si pas d'achat mensuel */
             if($achat_mensuel == ''){
                $_SESSION['messageInfos'] = '<div class="messageInfos"><h2 class="invalide"><i class="fa-solid fa-triangle-exclamation"></i> Vous devez un nombre d\'achat mensuel</h2></div>';
                header('location: update_product.php?id_produit='.$id_produit.'');
                exit();
            }

            /* Si pas d'étoiles */
            if($nb_etoiles == ''){
                $_SESSION['messageInfos'] = '<div class="messageInfos"><h2 class="invalide"><i class="fa-solid fa-triangle-exclamation"></i> Vous devez entrer un nombre d\'étoiles</h2></div>';
                header('location: update_product.php?id_produit='.$id_produit.'');
                exit();
            }

            // Si pas de ratings
            if($ratings == ''){
                $_SESSION['messageInfos'] = '<div class="messageInfos"><h2 class="invalide"><i class="fa-solid fa-triangle-exclamation"></i> Vous devez entrer un nombre d\'avis</h2></div>';
                header('location: update_product.php?id_produit='.$id_produit.'');
                exit();
            }
        
            $sql = 'UPDATE produits
                    SET 
                        titre = :titre, 
                        avantages = :avantages, 
                        prix = :prix, 
                        prix_reduit = :prix_reduit, 
                        lien_amazon = :lien_amazon,
                        achat_mensuel = :achat_mensuel,
                        nb_etoiles = :nb_etoiles,
                        ratings = :ratings
                    WHERE id_produit = '.$id_produit.'';
            
            $req = $db->prepare($sql);

            $req->bindParam(':titre', $titre, PDO::PARAM_STR);
            $req->bindParam(':avantages', $avantages, PDO::PARAM_STR);
            $req->bindParam(':prix', $prix, PDO::PARAM_STR);
            $req->bindParam(':prix_reduit', $prix_reduit, PDO::PARAM_STR);
            $req->bindParam(':lien_amazon', $lien_amazon, PDO::PARAM_STR);
            $req->bindParam(':achat_mensuel', $achat_mensuel, PDO::PARAM_STR);
            $req->bindParam(':nb_etoiles', $nb_etoiles, PDO::PARAM_STR);
            $req->bindParam(':ratings', $ratings, PDO::PARAM_STR);

            $req->execute();

            $_SESSION['messageInfos'] = '<div class="messageInfos"><h2 class="valide"><i class="fa-solid fa-check"></i> Les produits ont bien été mis à jour.</h2></div>';

            header('Location: select_product.php');
            
            exit();
        }
    }else{
        $_SESSION['messageInfos'] = '<div class="messageInfos"><h2 class="invalide"><i class="fa-solid fa-xmark"></i> Les produits n\'ont pas été mis à jour.</h2></div>';

        header('Location: update_product.php');
            
        exit();
    }
