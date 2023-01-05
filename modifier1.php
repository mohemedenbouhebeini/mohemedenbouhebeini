<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <<!-- Inclure le fichier de style de Bootstrap -->
<link rel="stylesheet" href="style2.css">

<!-- Inclure le fichier de script de Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" 
integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" 
crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
       
    <?php
        
        if (isset($_REQUEST["id"])) {//&&isset($_POST["mdp"])){
            $i = $_REQUEST["id"];
            include("conn.php");
            try{
                $conn = new PDO("mysql:host=$server;dbname=$bd",$user);
                $conn->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $sql = "SELECT * FROM etudiants WHERE id = '$i'";
                $result = $conn->query($sql);

                foreach($result as $r){
                    $t1= $r['prenom'];
                    $t2= $r['nom'];
                    $t3= $r['login'];
                    $t4=$r['mdp'];
                    $t5= $r['email'];
                    $t5= $r['adresse'];
                    $t5= $r['telephone'];
                }
            }catch(PDOException $e){
                echo "Connection failed: " . $e->getMessage();
            }
        }

    ?>

<    <div class="form">
        <a href="index.php" class="back_btn"><img src="images/back.ipj"> Retour</a>
        <h2>Modification</h2>
        <p class="erreur_message">
            <?php 
            // si la variable message existe , affichons son contenu
            if(isset($message)){
                echo $message;
            }
            ?>

        </p>
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
            <input class="" type="submit" value ="confirmer" onclick="if(window.confirm('Voulez-vous vraiment Modifier ?')){return true;}else{return false;}">
        </form>

        </div>
    </div>
    </form>

    <?php
        if(isset($_REQUEST['id']) && isset($_REQUEST['prenom']) && isset($_REQUEST['nom']) && isset($_REQUEST['email']) && isset($_REQUEST['adresse']) && isset($_REQUEST['tel'])){        
            $t1 = $_REQUEST['prenom'];
            $t2 = $_REQUEST['nom'];
            $t3 = $_REQUEST['email'];
            $t4 = $_REQUEST['adresse'];
            $t5 = $_REQUEST['tel'];                
            $id = $_REQUEST['id'];
         
            $sql  = "UPDATE etudiants SET Prenoms = '$t1', Nom = '$t2', Email = '$t3', Adresse = '$t4', Telephone = '$t5' WHERE Id = '$id' ";
            $statement = $conn->prepare($sql);
            $statement->execute();              
                
            header("Location:admin.php?msg=Modification réussi");
         
        } 
        
    ?>

</body>
</html>