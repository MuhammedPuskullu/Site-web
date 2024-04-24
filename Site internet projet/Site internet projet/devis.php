<?php 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=pepf2;charset=utf8;','user','user'); // on se connecte a la base de donnée 
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<link href="devis.css" rel="stylesheet" type="text/css" />
		<link rel="icon" type="image/png" href="images/Logo_PEPF.png"/>
		<meta name="viewport" content="width = device-width, initial-scale=1">
		<title>PEPF Travaux d'habitat - Devis</title>
		<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
        
	</head>
	<body>	

		<div id="menu">
			<div class="item-left">
				<img src="images/Logo2PEPF(2).png">
			</div>
			<div class="menu2">
				<div class="menuitem"><a href="index-PEPF.php"><p>Accueil</p></a></div>
				<div class="menuitem"><a href="index-PEPF.php"><p>Sur nous</p></a></div>
				<div class="menuitem"><a href="index-PEPF.php"><p>Galerie</p></a></div>
				<div class="menuitem"><a href="index-PEPF.php"><p>Contact</p></a></div>
				<div class="menuitem"><a href="devis.php"><p>Demander un devis</p></a></div>
				<div class="menuitem"><a href="RDV.php"><p>Prenez un RDV</p></a></div>
				<div class="menuitem"><a href="AVIS1.php"><p>Avis</p></a></div>
			</div>
			<div class="menu2">
				<div class="menuitem"><a href=""></a></div>
			</div>
		</div>

		<div class="textediv1">
			<div class="devistexte">
				<h1> Demendez votre devis gratuitement et obtenez un devis au meilleur prix </h1>
				<p> Après votre demande, vous receverez le devis par mail sous 3-4 jours, n'hesitez pas a reagrder vos spams.<br> Si le devis vous convient, veuillez nous le retournez par email.</br></p>
			</div>
			<form class="formulaire" method="POST">
				<h1> Demandez votre devis </h1>
                <div class="bt">
                    <div class="btgauche">	
                        <div class="boite">
                            <input type="text" placeholder="Prenom" name="prenom_devis" title="prenom_devis"/>
                            <i class="fa-solid fa-user"></i>
                        </div>

                        <div class="boite">
                            <input type="text" placeholder="Nom" name="nom_devis" title="Nom" />
                            <i class="fa-solid fa-user"></i>
                        </div>

                        <div class="boite">
                            <input type="email" placeholder="Email"  name="email_devis" id="email" minlength="6" />
                            <i class="fa-solid fa-envelope"></i>
                        </div>

                        <div class="boite">
                            <input type="text"  placeholder="Adrresse postale" title="adresse" name="adresse_devis" id="adresse" >
                            <i class="fa-solid fa-house"></i>
                        </div>		
                    </div>
                    <div class="btdroite">
                        <div class="boite">
                            <input type="tel" name="tel_devis" id="tel" placeholder="+33 x xx xx xx xx" title="Téléphone au format +33 x xx xx xx xx"  />
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div class="boite">
                            <input type="hidden" name="MAX_FILE_SIZE" value="3000" />
                            <input placeholder="Choisissez un fichier" name="photo_devis" type="file"/>
                        </div>
                        <div class="boite">
                            <input type="text" placeholder="Titre de votre devis" name ="titre_devis" title="titre" />
                            <i class="fa-solid fa-pen"></i>
                        </div>
                        <div class="boite">
                            <textarea cols="50" rows="3" maxlength="300" name="texte_devis" id="bloccomm" name="texte" placeholder="Mon devis concerne un projet de renovation..."></textarea>
                            <i class="fa-solid fa-pen"></i>
                        </div>
                    </div>
                </div>
               
                    <?php
                    if(isset($_POST['envoi_devis'])){
                        if(!empty($_POST['nom_devis'])AND !empty($_POST['prenom_devis']) AND !empty($_POST['email_devis'])AND !empty($_POST['tel_devis']) AND !empty($_POST['adresse_devis'])AND !empty($_POST['titre_devis'])AND !empty($_POST['texte_devis'])){
                            $date_clicked = date('Y-m-d H:i:s');
                            $nom = $_POST['nom_devis'];
                            $prenom = $_POST['prenom_devis']; 
                            $email = $_POST['email_devis'];
                            $tel = $_POST['tel_devis'];
                            $adresse = $_POST['adresse_devis'];
                            $titre = $_POST['titre_devis'];
                            $texte = $_POST['texte_devis'];
                            $fichier = $_FILES['photo_devis'];
    
                            // on insere le devis dans la base de donnée
                            $insertDevis = $bdd->prepare('INSERT INTO devis(nom_devis,prenom_devis,photo_devis,tel_devis,adresse_devis,email_devis,titre_devis,texte_devis,date_devis)
                                VALUES(?,?,?,?,?,?,?,?,?)');
                            $insertDevis->execute(array($nom,$prenom,$fichier,$tel,$adresse,$email,$titre,$texte,$date_clicked));
                            
                    } else {
                        echo ' <div class="messagederreur"> Veuillez rentrer tous les champs s\'il vous plait</div>';
                    }
                    }
                    ?>
                <script language='javascript'>
                    // Masquer le message d'erreur après 5 secondes
                    setTimeout(function() {
                        var messageErreur = document.querySelector('.messagederreur');
                        if(messageErreur) {
                            messageErreur.style.display = 'none';
                        }
                    }, 5000);
                </script>
				<div class="bouton">
					<button type="submit" name="envoi_devis">Envoyer le devis</button>
				</div>

                
			</form>
		</div>

    </body>
</html>