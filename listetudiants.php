<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <<!-- Inclure le fichier de style de Bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
 crossorigin="anonymous">

<!-- Inclure le fichier de script de Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" 
integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" 
crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
<?php


if(isset($_REQUEST["msg"])){
    echo "<br>";
    $b=$_REQUEST["msg"];
    echo "<span style='color:green'> $b</span>";

}

include("conn.php");
try {
    //connexion au serveur de BD
    $conn = new PDO("mysql:host=$server;dbname=$bd", $user, $mdp);
    // Définir le mode d'erreur PDO comme l'exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
   //recupération login et mdp saisie par le user

    //on vérifie si le login et le mdp correspondent au login et au mdp d'un user  stockés dans la table 
   
    $sql = "SELECT * FROM etudiants ";
    $result = $conn->query($sql);
    //affichage   
    if ($result->rowCount() > 0) {
        ?>   
           <table border = "1">
             <tr>
               <th>Id</th>
               <th>Prenoms</th>
               <th>Nom</th>
               <th>login</th>
               <th>mdp</th>
               <th>Telephone</th>
               <th>Adresse</th>
               <th>Email</th>
               <th>Supprimer</th>
               <th>Modifier</th>
             </tr>

             <div class="btn"><a href="ajouter.php">Ajouter un nouvel utilisateur</a></div>

            <?php 
           // Afficher les données de chaque ligne
           while($row = $result->fetch(PDO::FETCH_NUM)) {
               //$id=$row["Id"];
              echo "<tr>";
               foreach($row as $i => $valeur){
                   if ($i == 0) {
                       echo "<td><a href='details.php?id=$valeur'>$valeur</a></td>";
                   } else {
                       echo "<td> $valeur </td>";
                   }
               }
               ?>
                 <td>
                  <div class="btn"><a href="supprimer.php?id=<?=$row[0]?>">supprimer</a></div>
               </td>
               <td>
               <div class="btn"><a href="modifier1.php?id=<?=$row[0]?>"> modifier</a></div>
               </td>
               <?php
              echo "</tr>";
           }
           echo "</table>";
           
           } else {
           echo "0 results";
   }
   

         
}catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}


if (!empty($str)) {
    $stmt = $conn->prepare("SELECT * FROM etudiants WHERE nom LIKE :str");
    $stmt->bindParam(':str', '%' . $str . '%');
} else {
    $stmt = $conn->prepare("SELECT * FROM etudiants");
}
$stmt->execute();
$result = $stmt->fetchAll();

?>

<script>
  // Récupération de l'élément HTML pour afficher le résultat
var resultElement = document.getElementById('p');

// Gestionnaire d'événement pour le bouton de soumission
function submitForm() {
  // Récupération des données du formulaire
  var data = document.getElementById('form').elements.namedItem('input').value;

  // Création de l'objet XMLHttpRequest
  var xhr = new XMLHttpRequest();

  // Configuration de la requête HTTP
  xhr.open('POST', 'listetudiants.php');
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  // Envoi de la requête HTTP
  xhr.send('data=' + encodeURIComponent(data));

  // Fonction de rappel de la requête
  xhr.onload = function() {
    if (xhr.status === 200) {
      // Mise à jour de l'élément HTML avec la réponse de listetudiants.php
      resultElement.innerHTML = xhr.responseText;
    } else {
      // Affichage d'un message d'erreur
      resultElement.innerHTML = 'Error: ' + xhr.status;
    }
  }
}

</script>

</body>
</html>