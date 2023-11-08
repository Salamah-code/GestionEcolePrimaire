<?php
require_once 'config.php'; // On inclu la connexion à la bdd

// Si les variables existent et qu'elles ne sont pas vides
if (!empty($_POST['email']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['password']) && !empty($_POST['password_retype'])) {
    // Patch XSS
    $email = addslashes(htmlspecialchars($_POST['email']));
    $nom = addslashes(htmlspecialchars($_POST['nom']));
    $prenom = addslashes(htmlspecialchars($_POST['prenom']));
    $password = addslashes(htmlspecialchars($_POST['password']));
    $password_retype = addslashes(htmlspecialchars($_POST['password_retype']));

    // On vérifie si l'utilisateur existe
    $check = $bdd->prepare('SELECT email FROM utilisateurs WHERE email = ?');
    $check->execute(array($email));
    $data = $check->fetch();
    $row = $check->rowCount();

    $email = strtolower($email); // on transforme toute les lettres majuscule en minuscule pour éviter que Foo@gmail.com et foo@gmail.com soient deux compte différents ..

    // Si la requete renvoie un 0 alors l'utilisateur n'existe pas 
    if ($row == 0) {
        if (strlen($email) <= 100) { // On verifie que la longueur du mail <= 100
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // Si l'email est de la bonne forme
                if (strlen($nom) <= 100) { // On verifie que la longueur du pseudo <= 100
                    if (strlen($prenom) <= 100) { // On verifie que la longueur du pseudo <= 100 
                        if ($password === $password_retype) { // si les deux mdp saisis sont bon

                            // On hash le mot de passe avec Bcrypt, via un coût de 12
                            $cost = ['cost' => 12];
                            $password = password_hash($password, PASSWORD_BCRYPT, $cost);

                            // On stock l'adresse IP
                            $ip = $_SERVER['REMOTE_ADDR'];

                            // On insère dans la base de données
                            $insert = $bdd->prepare('INSERT INTO utilisateurs(email, nom, prenom, password, ip, token) VALUES(:email, :nom, :prenom, :password, :ip, :token)');
                            $insert->execute(array(
                                'email' => $email,
                                'nom' => $nom,
                                'prenom' => $prenom,
                                'password' => $password,
                                'ip' => $ip,
                                'token' => bin2hex(openssl_random_pseudo_bytes(64))
                            ));
                            // On redirige avec le message de succès
                            header('Location:inscriptionadmin.php?reg_err=success');
                        } else {
                            header('Location:inscriptionadmin.php?reg_err=password');
                        }
                    } else {
                        header('Location:inscriptionadmin.php?reg_err=prenom_length');
                    }
                } else {
                    header('Location:inscriptionadmin.php?reg_err=nom_length');
                }
            } else {
                header('Location:inscriptionadmin.php?reg_err=email');
            }
        } else {
            header('Location:inscriptionadmin.php?reg_err=email_length');
        }
    } else {
        header('Location:inscriptionadmin.php?reg_err=already');
    }
}
