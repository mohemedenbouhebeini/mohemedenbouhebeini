<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <?php  if(!isset($_SESSION["login"])){ ?>
        <form  action="index.php" method="POST">
        <fieldset >
        <legend > Page de connexion</legend> 
        <br><input type="text" name="login" placeholder="login" ><br>
        <br><input type="password" name="mdp" placeholder="mot de passe" ><br>
        <br><input type="submit" value="se connecter"><br>
        </fieldset>
        </form>
        <?php } else{ ?>
        <a href="deconnexion.php">Se deconnecter</a>
        <br>
        <a href="admin.php">Aller à la page d'administration</a>
        <?php };?>
    <?php
     
      
        include("conn.php");
        try {
            //connexion au serveur de BD
            $conn = new PDO("mysql:host=$server;dbname=$bd", $user);
            // Définir le mode d'erreur PDO comme l'exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           // echo "Connected successfully";
           //recupération login et mdp saisie par le user
           if(isset($_REQUEST["login"])){
            //on vérifie si le login et le mdp correspondent au login et au mdp d'un user  stockés dans la table 
            $login=$_REQUEST["login"];
            $mdp=$_REQUEST["mdp"];
            $sql = "SELECT * FROM etudiants Where login='$login' and   mdp='$mdp' ";
            $result = $conn->query($sql);
            //Si login et mdp sont dans la table on cree la session et on redirige vers admin
            if ($result->rowCount()> 0) {
                $_SESSION["login"]=$_REQUEST["login"];
                $_SESSION["mdp"]=$_REQUEST["mdp"];
                header("Location: admin.php?msg= Bienvenue à la page d'administration du site");

            } 
            else {//sinon on envoie un message d'erreur
                echo "<span style='color:red '>login ou mot de passe erronné</span>"; 
            }

           }
        if(isset($_REQUEST["msg"])){
            echo "<br>";
            $b=$_REQUEST["msg"];
            echo "<span style='color: yellow '> $b</span>";
        }
        if(isset($_REQUEST["msg1"])){
            echo "<br>";
            $c=$_REQUEST["msg1"];
            echo "<span style='color:violet' > $c</span>";
    
        }
  
        }catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
       
     
        ?>
    
</body>
</html>