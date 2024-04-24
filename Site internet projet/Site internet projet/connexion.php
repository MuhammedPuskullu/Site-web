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
    <title>Connexion</title>
    <link rel="icon" type="image/png" href="images/Logo_PEPF.png"/>
    <link rel="stylesheet" href="connexion.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="div1">
        <h1>Connexion</h1>
        <form method="POST" action="">
        
            <div class="input-box">
                <input type="tel" id="tel" name="tel" placeholder="+33 x xx xx xx xx" pattern="[0-9]{2}[-\s]?[0-9]{2}[-\s]?[0-9]{2}[-\s]?[0-9]{2}[-\s]?[0-9]{2}" title="Votre numero de téléphone">
                <i class="fa-solid fa-phone"></i>

            <div class="input-box">
                <input name="mdp_client" type="password" placeholder="Mot de passe">
                <i class="fa-solid fa-lock"></i>
            </div>
            <div class="messagederreur">
            <?php
                if(isset($_POST['envoi'])){ 
                    if((!empty($_POST['tel'])) AND !empty($_POST['mdp_client'])){
                        $tel = htmlspecialchars($_POST['tel']);
                        $mdp= sha1($_POST['mdp_client']);

                        $recupUser = $bdd->prepare('SELECT * FROM client WHERE tel = ? AND mdp_client = ?');
                        $recupUser->execute(array($tel,$mdp));

                        $recupGerant = $bdd->prepare('SELECT * FROM gerant WHERE tel_gerant = ? AND mdp_gerant = ?');
                        $recupGerant-> execute(array($tel,$mdp));

                        if ($recupUser->rowCount() > 0){
                        $_SESSION['tel'] = $tel;
                        $_SESSION['mdp_client'] = $mdp;
                        $_SESSION['id_client'] = $recupUser->fetch()['id_client'];
                        header('Location: AVIS1.php ');

                        } elseif ($recupGerant->rowCount() > 0){
                            $_SESSION['tel_gerant'] = $tel;
                            $_SESSION['mdp_gerant'] = $mdp;
                            $_SESSION['id_gerant'] = $recupGerant->fetch()['id_gerant'];
                            header('Location: gerant.php ');
                            }else {
                            echo'<p>Votre numero de telephone ou mot de passe est incorrecte.<p>';
                            
                        }
                    }else {
                        echo"<p>Veuillez remplir tous les champs<p>";
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
            <button type="submit" name="envoi" class="btn">Se connecter</button>

            <div class="register-link">
                <p>Vous n'avez pas de compte ? <a href="inscription2.php">Inscrivez vous</a></p>
            </div>
        </form>
    </div>

</body>

</html>