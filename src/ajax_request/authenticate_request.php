<?php

session_start();

header('Content-Type: application/json');

require('../envir/password.php');

$password = $_POST['password_proposition'] ?? '';

if ($password === PASSWORD) {
    // si mdp bon => set le cookie admin

    session_regenerate_id(true);
    // génère un nouveau session_id
    // good practice de ne pas juste lvl up une session mais de la changer avant de modifier ses droits d'accès
    // => pour éviter que quelqu'un copie ce session_id pour avoir ces mêmes droits post-modifs

    $_SESSION['access_granted'] = true;

    // et renvoie que c'est ok
    echo json_encode([
        'success' => true
    ]);
} else {
    // sinon renvoie que le mdp n'est pas bon
    echo json_encode([
        'success' => false,
        'message' => 'Mot de passe incorrect'
    ]);
}
exit;

?>