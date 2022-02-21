<?php
// On demarre ou on recupere la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');

// On invalide le cache de session $_SESSION['alogin'] = ''
if(isset($_SESSION['login']) && $_SESSION['alogin']!=''){
	$_SESSION = array();
}
error_log(md5("mille"));
	// Apres la soumission du formulaire de login (plus bas dans ce fichier)
     if(isset($_POST['login'])) {
 		 // On verifie si le code captcha est correct en comparant ce que l'utilisateur a saisi dans le formulaire
		// $_POST["vercode"] et la valeur initialis�e $_SESSION["vercode"] lors de l'appel a captcha.php (voir plus bas
					if($_POST['vercode'] != $_SESSION['vercode']){
					echo "<script>alert('le code est incorrect')<script>";
			} else {
                // Le code est correct, on peut continuer
          	// On recupere le nom de l'utilisateur saisi dans le formulaire
            $nom = $_POST['username'];
                // On recupere le mot de passe saisi par l'utilisateur et on le crypte (fonction md5)
            $mdp = md5($_POST['password']);

			error_log($nom);
			error_log($mdp);
               // On construit la requete qui permet de retrouver l'utilisateur a partir de son nom et de son mot de passe
               // depuis la table admin
			$sql = "SELECT  UserName , Password FROM admin WHERE UserName  LIKE :username AND Password LIKE :password";
			$query = $dbh->prepare($sql);
			$query->bindParam(':username',$nom, PDO::PARAM_STR);
			$query->bindParam(':password', $mdp, PDO::PARAM_STR);
			$query->execute();

			$result = $query->fetch(PDO::FETCH_OBJ);
     	     // Si le resultat de recherche n'est pas vide 
			  if(!empty($result)) { 
        	     // On stocke le nom de l'utilisateur  $_POST['username'] en session $_SESSION
				 $_SESSION['alogin'] = $_POST['username'];
        	     // On redirige l'utilisateur vers le tableau de bord administration (n'existe pas encore)
				 header('location:admin/dashboard.php');

        	     // sinon le login est refuse. On le signal par une popup
		}  else {
			echo "<script>alert('login invalide')</script>" ;
	}
}
}


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
    <!-- On inclue le fichier header.php qui contient le menu de navigation-->
<?php include('includes/header.php');?>



<!--On affiche le formulaire de login-->
<div class="container-fluid">
	<div class="row">
        <div class="col-md-9 offset-md-1">
			<fieldset class="form-group border p-3">
				<legend class="header-line">Administration</legend>
				<form method="POST">
        			<div>
        				<label>Entrez le nom de l'utilisateur</label>
        				<input   class="form-control" type="text" name="username" required>
						<!-- <span id="user-availability-status" style="font-size:12px;"></span>  -->
        			</div>
        			<div>
        				<label>Mot de passe</label>
        				<input   class="form-control" type="password" name="password" required>
        			</div>
					<hr>
        			<div>
        				<label>Code de verification</label>
        				<input    type="text" name="vercode"  maxlength="5" required >&nbsp; <img src="captcha.php">
        			</div>
        			<hr>
        			<button type="submit" name="login" class="btn btn-info">LOGIN</button>
        		</form>
				<hr>
        </div>
    </div>
</div>
                           
                           
	

      <!-- CONTENT-WRAPPER SECTION END-->
<?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>





