<?php 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=pepf2;charset=utf8;','user','user'); // on se connecte a la base de donnée 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<link href="RDVcss.css" rel="stylesheet" type="text/css" />
	<title>PEPF Travaux d'habitat</title>
	<link rel="icon" type="image/png" href="images/Logo_PEPF.png"/>
	<meta name="viewport" content="width = device-width, initial-scale=1">
	
</head>
<body>
	<div id="menu">
		<div class="item-left"><img src="images/Logo2PEPF(2).png"></div>
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
        <?php
                if(isset($_SESSION['id_client'])){
                    echo ' <div class="menuitem"><a href="deconnexion.php">Deconnexion</a></div>';
                }else {
                    echo ' <div class="menuitem"><a href="connexion.php">Connexion</a></div>';
                }
                ?>
		</div>
	</div>

	<div class="textediv1">
		<div class="rdvtexte">
			<h1> Prenez un rendez-vous rapidement avec notre specialiste </h1>
			<p>Vous voulez aller plus vite dans la realisation de votre projet ?
				<br> Alors n'attendez pas, prenez un rdv pour avoir un contacte direcet avec nous.</br>
			</p>
		</div>
		<form class="formulaire" method="POST">
			<h1> Prenez votre rdv avec notre specialiste </h1>
			<div class="bt">
				<div class="btgauche">	
					<div class="boite">
						<select id="heure" name="heure_rdv">
							<option value="08:00">8:00</option>
							<option value="09:00">9:00</option>
							<option value="17:00">17:00</option>
							<option value="18:00">18:00</option>	
						</select>
					</div>
					<div class="boite">
						<input type="text" placeholder="Type : Electricté, Rénovation..." name="type_rdv" title="Type : Electricté, Rénovation..."/>
						<i class="fa-solid fa-user"></i>
					</div>
					<div class="boite">
						<textarea cols="50" rows="3" maxlength="300" name="texte_rdv" id="bloccomm" name="texte" placeholder="Mon rdv concerne un projet de renovation..."></textarea>
						<i class="fa-solid fa-pen"></i>
					</div>
				</div>
				<div class="btdroite">
					<div class="boite">
						<input type="date" id="date" name="date_rdv" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" max="2025-01-01">
						<i class="fa-solid fa-envelope"></i>
					</div>
					<div class="boite">
						<input type="tel" name="tel" id="tel" placeholder="+33 x xx xx xx xx" title="Téléphone au format +33 x xx xx xx xx"  />
						<i class="fa-solid fa-phone"></i>
					</div>
					<div class="boite">
						<input type="text"  placeholder="Adrresse postale" title="adresse" name="adresse_rdv" id="adresse" >
						<i class="fa-solid fa-house"></i>
					</div>		
				</div>
			</div>
			<div class="messagederreur">
				<?php
					if(isset($_POST['envoi_rdv'])) {
						// On vérifie si une session n'est pas ouverte
						if(!isset($_SESSION['id_client'])) {
							header('Location: connexion.php');
							exit;
						}
						if(!empty($_POST['date_rdv']) AND  !empty($_POST['heure_rdv']) AND !empty($_POST['tel']) AND !empty($_POST['adresse_rdv']) AND !empty($_POST['type_rdv'])){
							$heure_actuelle = date('H:i');
							$date_actuelle = date('Y-m-d');
							if(($heure_actuelle > $_POST['heure_rdv']) AND ($date_actuelle == $_POST['date_rdv'])){
								echo '<p>Veuillez essayer un autre jour ou une autre heure s\'il vous plait.</p>';
							}else {
								$date = $_POST['date_rdv']; 
								$heure = $_POST['heure_rdv'];
								$tel = $_POST['tel'];
								$adresse = $_POST['adresse_rdv'];
								$type = $_POST['type_rdv'];
								$texte = $_POST['texte_rdv'];
								$id = $_SESSION['id_client'];
								
								$verifRdv = $bdd->prepare("SELECT * FROM rendez_vous WHERE adresse_rdv = ? AND heure_rdv = ?");
								$verifRdv->execute(array($adresse,$heure));

								if($verifRdv->rowCount()>0){
									echo '<p>Un rendez vous est deja pris a cette heure et ce jour.</p>';
								}else{
									$insertRdv = $bdd->prepare('INSERT INTO rendez_vous(date_rdv, type_rdv, adresse_rdv, tel_rdv, texte_rdv, id_client, heure_rdv) VALUES(?,?,?,?,?,?,?)');
									$insertRdv->execute(array($date, $type, $adresse, $tel, $texte, $id, $heure));
								}
							}
						} else {
							echo '<p>Veuillez renseigner tous les champs s\'il vous plaît.</p>';
							
						}
					}
				
				?>
			</div>

				
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
				<button type="submit" name="envoi_rdv">Prendre le rdv</button>
			</div>
		</form>
	</div>


</body>
</html>