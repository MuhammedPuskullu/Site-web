<?php 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=pepf2;charset=utf8;','user','user'); // on se connecte a la base de donnée 

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<link href="gerant.css" rel="stylesheet" type="text/css" />
	<title>PEPF Travaux d'habitat</title>
	<link rel="icon" type="image/png" href="images/Logo_PEPF.png"/>
	<meta name="viewport" content="width = device-width, initial-scale=1">
	
	
</head>
<body>
	<div id="menu">
		<div class="item-left"><img src="images/Logo2PEPF(2).png"></div>
		<div class="menu2">
			<div class="menuitem"><a href="gerant.php">Gérant</a></div>
			
		</div>
		<div class="menu2">
			<div class="menuitem"><a href="deconnexion.php">Déconnexion</a></div>
		</div>
	</div>
	<div id="texte">
		<div class="textediv">
			<h1>Les devis demandés : </h1>
            <?php 
           $afficheDevis = $bdd->prepare('SELECT * FROM devis ORDER BY id_devis DESC  ;'); // on prepare la table client avec les information que l'utilisateur va rentré
           $afficheDevis->execute();
           $resultat = $afficheDevis->fetchAll(PDO::FETCH_ASSOC);
           
           
           echo '<table border="1">';
                echo '<thead>
                        <tr>
                            <th>Titre du devis</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th>Texte</th>
                            <th>Téléphone</th>
                            <th>Date<th>
                            <th>Photo</th>
                            
                        </tr>
                    </thead>';
                echo '<tbody>';
                foreach ($resultat as $row) {
                    echo '<tr>';
                    echo '<td>' . $row['titre_devis'] . '</td>';
                    echo '<td>' . $row['nom_devis'] . '</td>';
                    echo '<td>' . $row['prenom_devis'] . '</td>';
                    echo '<td>' . $row['email_devis'] . '</td>';
                    echo '<td>' . $row['adresse_devis'] . '</td>';
                    echo '<td>' . $row['texte_devis'] . '</td>';
                    echo '<td>' . $row['tel_devis'] . '</td>';
                    echo '<td>' . $row['date_devis'] . '</td>';
                    echo '<td>';
                
                    // Vérifier si le champ photo_devis est vide ou non
                    if(!empty($row['photo_devis'])) {
                        // Si le champ n'est pas vide, afficher le lien vers la photo
                        echo '<a href="' . $row['photo_devis']. '" target="_blank">Voir la photo</a>';
                    } else {
                        // Si le champ est vide, afficher un message indiquant que la photo n'est pas disponible
                        echo 'Pas de photo';
                    }
                
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
            ?>
            

		</div>
		<div class="textediv2">
				<h1>Les rendez-vous prient par les clients :</h1>
                <?php 
           $afficheRdv = $bdd->prepare('SELECT type_rdv, date_rdv, heure_rdv, adresse_rdv, tel_rdv, texte_rdv, rendez_vous.id_client, nom , prenom, email 
           FROM rendez_vous, client WHERE client.id_client = rendez_vous.id_client ORDER BY id_rdv DESC  ;'); // on prepare la table client avec les informatiokn que l'utilisateur va rentrer 
           $afficheRdv->execute();
           $resultat1 = $afficheRdv->fetchAll(PDO::FETCH_ASSOC);
           echo '<table border="1">';
                echo '<thead>
                        <tr>
                            <th>Type du rdv</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th>id_client</th>
                            <th>Texte</th>
                            <th>Téléphone</th>
                            <th>Heure du rdv</th>
                            <th>Date du rdv</th>
                        </tr>
                    </thead>';
                echo '<tbody>';
                foreach ($resultat1 as $row) {
                    echo '<tr>';
                    echo '<td>' . $row['type_rdv'] . '</td>';
                    echo '<td>' . $row['nom'] . '</td>';
                    echo '<td>' . $row['prenom'] . '</td>';
                    echo '<td>' . $row['email'] . '</td>';
                    echo '<td>' . $row['adresse_rdv'] . '</td>';
                    echo '<td>' . $row['id_client'] . '</td>';
                    echo '<td>' . $row['texte_rdv'] . '</td>';
                    echo '<td>' . $row['tel_rdv'] . '</td>';
                    echo '<td>' . $row['heure_rdv'] . '</td>';
                    echo '<td>' . $row['date_rdv'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
                    
            ?>
		</div>
		<div class="textediv4">
        <h1>Les avis laissés par les clients :</h1>
                <?php 
           $afficheAvis = $bdd->prepare('SELECT * FROM commenatire ORDER BY id_avis DESC  ;'); 
           $afficheAvis->execute();
           $resultat2 = $afficheAvis->fetchAll(PDO::FETCH_ASSOC);
           echo '<table border="1">';
                echo '<thead>
                        <tr>
                            <th>Id Avis</th>
                            <th>Titre de l\'avis</th>
                            <th>Contenu de l\'avis</th>
                            <th>Photo</th>
                            <th>Date</th>
                            <th>id_client</th>
                        </tr>
                    </thead>';
                echo '<tbody>';
                foreach ($resultat2 as $row) {
                    echo '<tr>';
                    echo '<td>' . $row['id_avis'] . '</td>';
                    echo '<td>' . $row['titre_com'] . '</td>';
                    echo '<td>' . $row['texte_com'] . '</td>';
                    echo '<td>' . $row['photos_com'] . '</td>';
                    echo '<td>' . $row['date_com'] . '</td>';
                    echo '<td>' . $row['id_client'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';     
            ?>
		</div>
        <div class="textediv5">
        <form method="POST" action="gerant.php" class="repondre">
                <h1>Répondre aux clients : </h1>
                <div class="boite">
                    <input type="text" placeholder="Id de l'avis" name ="id_avis"  />
                   
                </div>
                <div class="boite">
                    <textarea cols="50" rows="3" maxlength="300" name="texte_reponse" id="bloccomm" name="texte" placeholder="Donnez votre avis ..."></textarea>
                    
                </div>
                <div class="messagederreur">
				<?php
					if(isset($_POST['repondre'])){
						if(!empty($_POST['texte_reponse'])AND !empty($_POST['id_avis'])){

                            $date_clicked = date('Y-m-d H:i:s');;
                            $id_avis = $_POST['id_avis'];
                            $id_gerant = $_SESSION['id_gerant'];
                            $reponse = $_POST['texte_reponse'];
                            
                            $verifReponse = $bdd->prepare("SELECT * FROM reponse WHERE id_avis = ?");
                            $verifReponse->execute(array($id_avis));

                            if($verifReponse->rowCount()>0){
                                echo '<p> Il existe déjà une reponse pour cet avis.</p>';
                            }else{

                            $insertReponse = $bdd->prepare('INSERT INTO reponse(texte_reponse,date_reponse,id_gerant,id_avis)
                                VALUES(?,?,?,?)'); // on prepare la table client avec les informatiokn que l'utilisateur va rentrer 
                            $insertReponse->execute(array($reponse,$date_clicked,$id_gerant,$id_avis));}
					
                        }else{
							echo '<p>Veuillez renseigner tous les champs s\'il vous plaît.</p>';
							
						    }
                    }
			
				    ?>
			    </div>
                <script language='javascript'>
                    // Masquer le message d'erreur après 5 secondes
                    setTimeout(function(){
                        var messageErreur = document.querySelector('.messagederreur');
                        if(messageErreur) {
                            messageErreur.style.display = 'none';
                        }
                    }, 5000);
                </script>
                <div class="bouton">
					<button type="submit" name="repondre">Envoyer votre avis</button>
				</div>
            </form>
        </div>
        <div class="textediv6">
            <form method="POST" action="gerant.php" class="supprimer">
                <h1>Supprimez un avis qui vous déplait : </h1>
                <div class="boite">
                    <input type="text" placeholder="Id de l'avis" name ="id_avis_supp"  />
                   
                </div>
                <div class="messagederreur">
				<?php
					if(isset($_POST['supp_avis'])){

						if(!empty($_POST['is_avis_supp'])){

                                $id_avis_supp = $_POST['id_avis_supp'];

                                $suppAvis = $bdd->prepare("DELETE FROM commenatire WHERE id_avis = $id_avis_supp;"); // on prepare la table client avec les informatiokn que l'utilisateur va rentrer 
                                $suppAvis->execute();
						} else{
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
					<button type="submit" name="supp_avis">Supprimer l'avis</button>
				</div>
            </form>
        </div>
		<div class="textediv4">
        <h1>Plus de statistique sur les avis laissés par les clients :</h1>
                <?php 
           $afficheNbAvisParClient = $bdd->prepare('SELECT COUNT(id_avis), id_client FROM commenatire GROUP BY id_client;'); // on prepare la table client avec les informatiokn que l'utilisateur va rentrer 
           $afficheNbAvisParClient->execute();
           $resultat3 = $afficheNbAvisParClient->fetchAll(PDO::FETCH_ASSOC);
           echo '<table border="1">';
                echo '<thead>
                        <tr>
                            <th>Nombre d\'avis</th>
                            <th>Par le client n° :</th>
                        </tr>
                    </thead>';
                echo '<tbody>';
                foreach ($resultat3 as $row) {
                    echo '<tr>';
                    echo '<td>' . $row['COUNT(id_avis)'] . '</td>';
                    echo '<td>' . $row['id_client'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';     
            ?>
		</div>
		
		
	</div>
</body>
</html>