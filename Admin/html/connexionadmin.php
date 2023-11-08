<?php
//On démarre une nouvelle session
session_start();
/*On utilise session_id() pour récupérer l'id de session s'il existe.
     *Si l'id de session n'existe  pas, session_id() rnevoie une chaine
     *de caractères vide*/
require_once 'config.php';

if (!empty($_POST['email']) && !empty($_POST['password'])) // Si il existe les champs email, password et qu'il sont pas vident
{
    // Patch XSS
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $email = strtolower($email); // email transformé en minuscule

    // On regarde si l'administrateur est inscrit dans la table administrateur
    $check = $bdd->prepare('SELECT email, nom, prenom, password, token FROM utilisateurs WHERE email = ?');
    $check->execute(array($email));
    $data = $check->fetch();
    $row = $check->rowCount();


    // Si > à 0 alors l'administrateur existe
    if ($row > 0) {
        // Si le mail est bon niveau format
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Si le mot de passe est le bon
            if (password_verify($password, $data['password'])) {
                // On créer la session et on redirige sur menuadmin.php
                $_SESSION['user'] = $data['token'];
                header('Location:MenuAdmin.php');
                die();
            } else {
                header('Location:../../index.php?login_err=password');
                die();
            }
        } else {
            header('Location:login.php?login_err=email');
            die();
        }
    } else {
        header('Location:login.php?login_err=already');
        die();
    }
} else {
    header('Location:../../index.php');
    die();
} // si le formulaire est envoyé sans aucune données
