<?php session_start();
 if(!isset($_SESSION["login"])){
       
    header("Location: index.php?msg1= Vous etes deconnecté.Veuillez vous connecter svp!");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Inclure le fichier de style de Bootstrap -->
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
    <h1 class="container">Page d'administration du site</h1>
    <div class="btn"><a href="index.php">Page de l'index</a></div>
    <br>
    <div class="btn"><a href="deconnexion.php">Se Deconnecter</a></div>
    <?php
    ?>
 <p id ="liste"></p>
<script>
 function showTable(str) {
    var xhttp;
    if (str == "") {
        document.getElementById("liste").innerHTML = "";
        return;
    }
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        document.getElementById("liste").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "listetudiants.php?q="+str, true);
    xhttp.send();
 
}


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
  };
}
</script>

<script>
window.onload = function() {
  showTable();
}
</script>



<script>
function searchStudents() {
  // Récupération de la valeur du champ de recherche
  var searchValue = document.querySelector("input[name=search]").value;

  // Envoi d'une requête AJAX pour récupérer les résultats de la recherche
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "listetudiants.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      // Mise à jour du tableau avec les résultats de la recherche
      document.querySelector("#students-table tbody").innerHTML = xhr.responseText;
    }
  }
  xhr.send("search=" + searchValue);
}

</script>

    <form  action="admin.php" method="POST">
  <label for="search">Rechercher par :</label>
  <br>
  <select name="search_by" >
    <option value="id">Id</option>
    <option value="prenoms">Prenoms</option>
    <option value="nom">Nom</option>
    <option value="email">Email</option>
    <option value="adresse">Adresse</option>
    <option value="telephone">Telephone</option>
  </select>
  <input type="text" name="search_query" placeholder="Entrez votre recherche">
  <input type="submit" name="search" value="Rechercher">
</form>
<?php
// Vérifiez si le formulaire a été soumis
if(isset($_POST['search'])) {
    // Récupérez les données du formulaire
    $search_by = $_POST['search_by'];
    $search_query = $_POST['search_query'];
  
    // Créez une connexion PDO
    include("conn.php");
    $conn = new PDO("mysql:host=$server;dbname=$bd", $user, $mdp);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    // Préparez la requête de recherche en utilisant des paramètres nommés pour éviter les injections SQL
    $stmt = $conn->prepare("SELECT * FROM etudiants WHERE $search_by LIKE :search_query");
    $stmt->execute(array(':search_query' => "%$search_query%"));
  
  // Affichez les résultats de la recherche sous forme de tableau
  if(isset($_POST['search_query'])){
  echo '<table>';
  echo '<tr><th>Id</th><th>Prenoms</th><th>Nom</th><th>Login</th><th>Mdp</th><th>Email</th><th>Adresse</th><th>Telephone</th></tr>';
  while($row = $stmt->fetch()) {
    echo '<tr>';
    echo '<td >' . $row['id'] . '</td>';
    echo '<td >' . $row['prenom'] . '</td>';
    echo '<td >' . $row['nom'] . '</td>';
    echo '<td >' . $row['login'] . '</td>';
    echo '<td >' . $row['mdp'] . '</td>';
    echo '<td >' . $row['telephone'] . '</td>';
    echo '<td >' . $row['adresse'] . '</td>';
    echo '<td >' . $row['email'] . '</td>';
    echo '</tr>';
  }
  echo '</table>';
}
else echo "entrer des valeur pour rechercher";
  
}
?>


    
</body>
</html>