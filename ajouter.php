<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <?php
       //vérifier que le bouton ajouter a bien été cliqué
       if(isset($_POST['button'])){
           //extraction des informations envoyé dans des variables par la methode POST
           extract($_POST);
           //verifier que tous les champs ont été remplis
           if(isset($prenom)  && isset($nom) && isset($login) && isset($mdp) && isset($adresse) && isset($telephone) && isset($email)){
                //connexion à la base de donnée
                include_once "conn.php";
                //requête d'ajout
                $con = mysqli_connect($server,$user,$mdp,$bd);
                $req = mysqli_query($con , "INSERT INTO etudiants VALUES(NULL, '$prenom','$nom','$login','$mdp',
                                            '$adresse','$telephone','$email')");
                if($req){//si la requête a été effectuée avec succès , on fait une redirection
                    header("location: index.php");
                }else {//si non
                    $message = "Etudiant non ajouté";
                }

           }else {
               //si non
               $message = "Veuillez remplir tous les champs !";
           }
       }
    
    ?>
    <div class="form">
        <a href="index.php" class="back_btn"><img src="images/back.ipj"> Retour</a>
        <h2>Ajouter un etudiant</h2>
        <p class="erreur_message">
            <?php 
            // si la variable message existe , affichons son contenu
            if(isset($message)){
                echo $message;
            }
            ?>

        </p>
        <form action="" method="POST">
            <label>Prénom</label>
            <input type="text" name="prenom">
            <label>Nom</label>
            <input type="text" name="nom">
            <label>Login</label>
            <input type="text" name="login">
            <label>Mdp</label>
            <input type="text" name="mdp">
            <label>Adresse</label>
            <input type="text" name="adresse">
            <label>Tel.</label>
            <input type="text" name="telephone">
            <label>Email</label>
            <input type="text" name="email">
            <input type="submit" value="Ajouter" name="button">
        </form>
    </div>
</body>
</html>