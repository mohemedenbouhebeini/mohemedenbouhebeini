<?php 
session_start();
if(!isset($_SESSION["login"]))
  header("Location:index.php?msg=veuiller vous connecter");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
	<?php 
     $id = $_GET['id'];
     include("conn.php");
     try {
        $conn = new PDO("mysql:host=$server;dbname=$bd", $user);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
       $stmt = $conn->prepare("DELETE FROM etudiants WHERE id = :id");
       $stmt->bindParam(':id', $id);
       $stmt->execute();
       
       // Rediriger l'utilisateur vers la page qui affiche la liste des étudiants
       header('Location: listetudiants.php');
     } catch(PDOException $e) {
       echo "Erreur : " . $e->getMessage();
     }
     
	?>
</body>
</html>