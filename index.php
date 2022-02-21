<?php
// On demarre ou on recupere la session courante
session_start();
// On inclue le fichier de configuration et de connexion a la base de donnees
include('includes/config.php');
// On invalide le cache de session
if(isset($_SESSION['login']) && $_SESSION['login']!='') {
	$_SESSION['login'] = '';
}

// Apr�s la soumission du formulaire de login ($_POST['login'] existe - voir pourquoi plus bas)
if(isset($_POST['login'])){
// On verifie si le code captcha est correct en comparant ce que l'utilisateur a saisi dans le formulaire
// $_POST["vercode"] et la valeur initialisee $_SESSION["vercode"] lors de l'appel a captcha.php (voir plus bas)
	if($_POST['vercode'] != $_SESSION['vercode']){
// Le code est incorrect on informe l'utilisateur par une fenetre pop_up
	echo "<script>alert('le code est incorrect')<script>";
} else {
	// Le code est correct, on peut continuer
	// On recupere le mail de l'utilisateur saisi dans le formulaire
		$email = $_POST['email'];
	// On recupere le mot de passe saisi par l'utilisateur et on le crypte (fonction md5)
		$password = md5($_POST['password']);
		
	// On construit la requete SQL pour recuperer l'id, le readerId et l'email du lecteur � partir des deux variables ci-dessus
    // dans la table tblreaders
	$sql = "SELECT * FROM tblreaders WHERE EmailId LIKE :email AND Password LIKE :password";
	$query = $dbh->prepare($sql);
	$query->bindParam(':email',$email, PDO::PARAM_STR);
	$query->bindParam(':password', $password, PDO::PARAM_STR);
	// On execute la requete
	$query->execute();
			   // On stocke le resultat de recherche dans une variable $result
	$result = $query->fetch(PDO::FETCH_OBJ);
	
		 if(!empty($result)) {
				// Si le resultat de recherche n'est pas vide
    			// On stocke l'identifiant du lecteur (ReaderId) dans $_SESSION['rdid']
				$_SESSION['rdid'] = $result->ReaderId;

				if ($result->Status == 1) {
				// Si le statut du lecteur est actif (egal a 1)
        		// On stocke l'email du lecteur dans $_SESSION['login']
					$_SESSION['login'] = $_POST['email'];
				// l'utilisateur est redirige vers dashboard.php
					header('location:dashboard.php');
				} else {
				// Sinon le compte du lecteur a ete bloque. On informe l'utilisateur par un popup
					echo "<script>alert('Compte bloqué')</script>";			 
			 	}
			} else {
                // Sinon la connexion n'est pas valide. On informe l'utilisateur par un popup
			    echo "<script>alert('Utilisateur inconnu')</script>";
			}
	}
}
?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <title>Gestion de bibliotheque en ligne</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet"/>
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet"/>
</head>
<body>
 <!--On inclue ici le menu de navigation includes/header.php-->
<?php include('includes/header.php');?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9 offset-md-1">
			<fieldset class="form-group border p-3">
            	<legend class="header-line">LOGIN LECTEUR</legend>
					<form name="signup" method="post">
                        <div>
                            <label>Entrez votre email</label>
							<input placeholder="Entre votre mail" class="form-control" type="email" name="email" required>
        				</div>
                        <div>
                            <label>Mot de passe</label>
								<input placeholder="Entre votre mot de passe" class="form-control" type="password" name="password" require>
								<span class="psw"><a href="user-forgot-password.php">Mot de passe oublié ?</a></span>
                        </div>
                        <span id="message"></span>
                        <div>
                            <label>Code de verification :</label>
                                <input type="text"  name="vercode" maxlength="5" autocomplete="off" required style="width: 150px; height: 25px;" />&nbsp;<img src="captcha.php">
                                </div> 
								<button type="submit" name='login' class="btn btn-primary" id="submit">Login</button>  
								<span><a href="signup.php">Je n'ai pas de compte</a></span>                             
                        <hr>
                    </form>
        </div>
    </div>
</div>
<!-- error_log(print_r($_SESSION,1));
error_log(print_r($_POST,1)); -->
<!-- error_log($email);
		error_log($password); -->
		<!-- error_log($sql);
		error_log(print_r($result, 1)); -->
<?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
