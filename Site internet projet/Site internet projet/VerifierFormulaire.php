<?php
function verifierMotDePasse($motDePasse) {
    // Vérifie la longueur du mot de passe
    if (strlen($motDePasse) < 8) {
        return "<p>Le mot de passe doit contenir au moins 8 caractères.</p>";
    }
    
    // Vérifie la présence de chiffres
    if (!preg_match("#[0-9]+#", $motDePasse)) {
        return "<p>Le mot de passe doit contenir au moins un chiffre.</p>";
    }
    
    // Vérifie la présence de lettres minuscules
    if (!preg_match("#[a-z]+#", $motDePasse)) {
        return "<p>Le mot de passe doit contenir au moins une lettre minuscule.</p>";
    }
    
    // Vérifie la présence de lettres majuscules
    if (!preg_match("#[A-Z]+#", $motDePasse)) {
        return "<p>Le mot de passe doit contenir au moins une lettre majuscule.</p>";
    }
    
    // Vérifie la présence de caractères spéciaux
    if (!preg_match("#\W+#", $motDePasse)) {
        return "<p>Le mot de passe doit contenir au moins un caractère spécial.</p>";
    }
    
    // Si toutes les conditions sont remplies, le mot de passe est valide
    return 1;
}

// $motDePasse = "Pervin41@";
// $resultat = verifierMotDePasse($motDePasse);
// echo $resultat;




function VerifierTel($tel){ 
    $pattern = "/^0[1-9]([ .-]?[0-9]{2}){4}$/";
    // Vérifie si le numéro de téléphone correspond au motif regex
    if (!preg_match($pattern, $tel)) {
        echo "<p>Le numéro de téléphone n'est pas valide.</p>";
    } else {
        return 1;
    }
}
?>