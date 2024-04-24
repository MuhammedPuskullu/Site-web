<?php 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=pepf2;charset=utf8;','user','user'); // on se connecte a la base de donnée 

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="icon" type="image/png" href="images/Logo_PEPF.png"/>
    <link rel="stylesheet" href="connexion.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="div1">
        <form method="POST" action="">
            <h1>Inscrivez-vous</h1>
            <div class="input-box">
                <input type="text" name="nom" placeholder="Nom" >
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="input-box">
                <input type="text" name="prenom" placeholder="Prenom" >
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" >
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div class="input-box">
                <input type="text" id="telephone" name="tel" placeholder="+33 x xx xx xx xx" pattern="[0-9]{2}[-\s]?[0-9]{2}[-\s]?[0-9]{2}[-\s]?[0-9]{2}[-\s]?[0-9]{2}" title="Votre numero de téléphone">
                <i class="fa-solid fa-phone"></i>
            </div>
            <div class="input-box">
                <input type="password" name="mdp_client" placeholder="Mot de passe" >
                <i class="fa-solid fa-lock"></i>
            </div>
            <div class="messagederreur">
            <?php
                if(isset($_POST['envoi'])){// correspond au bouton s'inscrire 
                    // on verifie si l'utilisateur a rentré tous les champs, si oui on ouvre la session, sinon on renvoie un message d'erreur.
                    if(!empty($_POST['nom'])AND !empty($_POST['prenom']) AND !empty($_POST['email'])
                        AND !empty($_POST['tel']) AND !empty($_POST['mdp_client'])){
                        
                        include 'VerifierFormulaire.php';
                        $tel = $_POST['tel']; 
                        $resultat2 = VerifierTel($tel);
                        $motDePasse = $_POST['mdp_client'];
                        $resultat = verifierMotDePasse($motDePasse);


                        if ($resultat == 1){
                            if($resultat2==1){
                                $nom = htmlspecialchars($_POST['nom']); // crypter le nom du client, pour plus de securité 
                                $prenom = htmlspecialchars($_POST['prenom']);// de meme pour le prenom du client 
                                $email = htmlspecialchars($_POST['email']);// de meme pour l'email du client 
                                $tel = htmlspecialchars($_POST['tel']);// de meme pour le tel du client 
                                $mdp = sha1($_POST['mdp_client']);// de meme pour le mdp du client, il existe d'autre moyen plus securisé pour crypter les données des clients...

                                // on insere le client dans la base de donnée
                                $insertUser = $bdd->prepare('INSERT INTO client(nom,prenom,email,tel,mdp_client)VALUES(?,?,?,?,?)'); // on prepare la table client avec les informatiokn que l'utilisateur va rentrer 
                                $insertUser->execute(array($nom,$prenom,$email,$tel,$mdp));



                                //on ouvre une nouvelle session, on recuperenat l'id du client 
                                $recupUser = $bdd->prepare('SELECT * FROM client WHERE nom = ? AND prenom = ? AND email = ? AND tel = ? AND mdp_client = ?');
                                $recupUser->execute(array($nom, $prenom, $email, $tel, $mdp));
                                if ($recupUser->rowCount() > 0){
                                $_SESSION['nom'] = $nom;
                                $_SESSION['prenom'] = $prenom;
                                $_SESSION['email'] = $email;
                                $_SESSION['tel'] = $tel;
                                $_SESSION['mdp_client'] = $mdp;
                                $_SESSION['id_client'] = $recupUser->fetch()['id_client'];
                                }
                                header("Location: connexion.php");
                            }else {echo $resultat2;}
                        }else {
                            echo $resultat;
                        }

                    } else 

                        echo "<p>Veuillez compléter tous les champs...<p>";
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
            <button type="submit" name="envoi" class="btn">S'inscrire</button>

            <div class="register-link">
                <p>Vous avez deja un compte ? <a href="connexion.php">Connectez-vous</a>
            </p>
            </div>
        </form>
    </div>

</body>

</html>