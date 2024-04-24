<?php 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=pepf2;charset=utf8;','user','user'); // on se connecte a la base de donnée 

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link href="AVIS.css" rel="stylesheet" type="text/css" />
        <title>PEPF Travaux d'habitat</title>
        <link rel="icon" type="image/png" href="images/Logo_PEPF.png"/>
        <meta name="viewport" content="width = device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                <div class="menuitem"><a href="RDV.php"><p>Prenez un RDV<p></a></div>
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



        <div id="interfacedisc">

            <form method="POST" action="AVIS1.php" class="ecrire">
                <h1>Donnez votre avis </h1>
                <div class="boite">
                    <input type="text" placeholder="Titre de votre avis" name ="titre_avis"  />
                   
                </div>
                <div class="boite">
                    <textarea cols="50" rows="3" maxlength="300" name="texte_avis" id="bloccomm" name="texte" placeholder="Donnez votre avis ..."></textarea>
                    
                </div>
                <div class="messagederreur">
				<?php
					if(isset($_POST['envoi_avis'])){
						if(!isset($_SESSION['id_client'])) {
							header('Location: connexion.php');
							exit;
						}
					
						if(empty($_POST['titre_avis'])AND empty($_POST['texte_avis'])){
                            echo '<p>Veuillez renseigner tous les champs s\'il vous plaît.</p>';
                            
						} else {
							
							$date_clicked = date('Y-m-d H:i:s');
                            $titre = $_POST['titre_avis'];
                            $texte = $_POST['texte_avis'];
                            $id_client = $_SESSION['id_client'];
            
                            $insertAvis = $bdd->prepare('INSERT INTO commenatire(titre_com,texte_com,date_com,id_client)
                                VALUES(?,?,?,?)'); 
                            $insertAvis->execute(array($titre,$texte,$date_clicked,$id_client));
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
					<button type="submit" name="envoi_avis">Envoyer votre avis</button>
				</div>
            </form>
        <?php

                $afficheAvis = $bdd->prepare('SELECT id_avis,titre_com,texte_com,date_com,nom 
                FROM commenatire, client WHERE commenatire.id_client = client.id_client ORDER BY id_avis DESC  ;'); // on prepare la table client avec les informatiokn que l'utilisateur va rentrer 
                $afficheAvis->execute();
                $resultat = $afficheAvis->fetchAll(PDO::FETCH_ASSOC);

                foreach ($resultat as $row) {
                echo '<article><h1>' . $row['titre_com'] . '</h1><p>'.'Le '.$row['date_com'].',  <u>'.$row['nom'].'</u> a publié :<br><br> '.$row['texte_com'].'</br></br>';

                // Requête SQL pour vérifier si un élément existe à la fois dans la table 1 et la table 2
                $sql = "SELECT COUNT(*) AS count_result FROM commenatire t1 INNER JOIN reponse t2 ON t2.id_avis = {$row['id_avis']}";
                //on execute la requete
                $result_count = $bdd->query($sql);

                // Récupère le nombre de résultats
                $row_count = $result_count->fetch(PDO::FETCH_ASSOC);
                $count = $row_count['count_result'];

                // Vérifie si un élément existe à la fois dans la table 1 et la table 2
                if ($count > 0) {
                $sql_t2 = "SELECT * FROM reponse WHERE id_avis = {$row['id_avis']}";
                $result_t2 = $bdd->query($sql_t2);

                // Parcourir les résultats de la table t2
                while ($row_t2 = $result_t2->fetch(PDO::FETCH_ASSOC)) {
                // Afficher le contenu de la table t2
                echo '</p><div class="reponse"><p><u>Reponse du gerant le '.$row_t2['date_reponse'].' :</u><br><br> ' . $row_t2['texte_reponse'].'</br></br></p></div></article>'; // Remplacez 'champ_contenu' par le nom du champ que vous voulez afficher
                }
                } else {
                echo ' <br><em><font size="2pt">0 reponse</font></em></br></p></article>'; // Retourne 0 sinon
                }
                } 
    
       
            ?>

        </div>

    </body>
</html>