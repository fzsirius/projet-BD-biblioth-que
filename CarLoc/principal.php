<?php
    session_start();
?>  

  <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Principal</title>
    <link rel="stylesheet" type="text/css" href="style.css">
	
	<style>
body {
  margin: 0;
}

.container {
  position: relative;
  top: 50px;
  display: flex;
  justify-content: center;
  padding: 50px 0;
  background-image: url('assets/img/a.jpg');
  background-size: cover;
  width: 100%; 
}

form {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: rgba(255,255,255,0.9);
  border-radius: 10px;
  padding: 30px;
  box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.2);
  margin: 45px;
}

label {
  font-weight: bold;
  margin-right: 20px;
  font-size: 14px;
}

input[type="text"], select {
  padding: 10px;
  font-size: 14px;
  border-radius: 5px;
  box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.1);
  width: 25%;
}

input[type="submit"] {
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 10px;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  transition: all 0.3s ease-in-out;
}

input[type="submit"]:hover {
  background-color: #0069d9;
  transform: scale(1.05);
}


	</style>
  </head>
  <body>
  
  <?php
  require_once("nav.php");?>
  
  
  
  
	<?php
	
	//le but ici est de récuperer les données de la base
		  require_once('include.php'); // Charge le fichier include.php
		  
		  
		  $db = new connexionDB();  //creation d'une instance de connexionDB
		  $conn = $db->DB();

		  

			try {
			  // Connexion à la base de données

			  // Récupération des données de la table "véhicule"

			  $resultat = $conn->query("SELECT DISTINCT annee FROM Voiture ORDER BY annee DESC");
			  $annees = $resultat->fetchAll(PDO::FETCH_COLUMN);

			  $resultat = $conn->query("SELECT DISTINCT nbre_sieges FROM Voiture ORDER BY nbre_sieges ASC");
			  $sieges = $resultat->fetchAll(PDO::FETCH_COLUMN);

			  $resultat = $conn->query("SELECT DISTINCT type_energie FROM Voiture ORDER BY type_energie ASC");
			  $energies = $resultat->fetchAll(PDO::FETCH_COLUMN);

			  $resultat = $conn->query("SELECT DISTINCT categorie FROM Voiture ORDER BY categorie ASC");
			  $categories = $resultat->fetchAll(PDO::FETCH_COLUMN);

			} catch (PDOException $e) { //gestion d'erreur en cas de problèmes de connexion à la BD
			  echo "Erreur : " . $e->getMessage();
			}

			// Récupération des données de la table "client"
			
			// Fermeture de la connexion à la base de données
			$conn = null;

		  ?>
		  
		  
		  
    <div class="container">
      <form method="post" action="resultats.php"> <!-- J'AI MIS LE PARAMETRE ACTION POUR ALLER VERS UNE NOUVELLE PAGE APRES LE FORMULAIRE-->
        <label>Marque:</label>
        <input type="text" name="brand">

        <label>Modèle:</label>
        <input type="text" name="model">
		
		

		<label for="annee">Année:</label>
		<select id="annee" name="annee">
			<option value="toutes">Toutes</option>
			<?php
			foreach ($annees as $annee) {
				echo '<option value="' . $annee . '">' . $annee . '</option>';     //on ne va afficher que les années qui existent dans la base
			}
			?>
		</select>

			  


		<label for="type_energie">Energie:</label>
		<select id="type_energie" name="energie">
			<option value="tous">Toutes</option>
			<?php foreach ($energies as $energie) { ?>
				<option value="<?= $energie ?>"><?php echo $energie; ?></option>
			<?php } ?>
		</select>


<!--
        <label>Kilométrage:</label>
        <select name="km">
          <option value="">Tous</option>
          <option value="0-50000">0-50,000</option>
          <option value="50001-100000">50,001-100,000</option>
          <option value="100001-150000">100,001-150,000</option>
          <option value="150001-200000">150,001-200,000</option>
          <option value="200001+">200,001 et plus</option>
        </select>

-->



        <input type="submit" name="search" value="Recherche">
      </form>
    </div>
	
	<br/><br/><br/>
	
	<?php


// Vérifier si une session est active
if (!isset($_SESSION['client'])) {
    // Afficher les liens "Nouveau Client" et "Se connecter"
    echo '<a href="nouveau.php">Nouveau Client</a>';
    echo '<BR/>';
    echo '<a href="connexion.php">Se connecter</a>';
} else {
    // Afficher un message de bienvenue et un lien pour se déconnecter
    echo 'Bienvenu ' . $_SESSION['client']['prenom'] . ' ' . $_SESSION['client']['nom']." ". $_SESSION['client']['id'];
    echo '<BR/>';
    echo '<BR/>';
    echo '<a href="deconnexion.php">Se déconnecter</a>';
    echo '<BR/>';echo '<BR/>';
    echo '<a href = panier.php>Mon panier</a>';
     echo '<BR/>';echo '<BR/>';
     echo '<a href="profil_client.php">Profil</a>';
   // echo '<a href = "articles/article">Ajouter article au panier</a>';
}
?>
  </body>
</html>
