<?php
// On recupere la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');

// Si l'utilisateur n'est pas logue, on le redirige vers la page de login (index.php)
if(strlen($_SESSION['login'])==0) {
    header('location:index.php');
}else{
// sinon, on peut continuer,
	// si le formulaire a ete envoye : $_POST['change'] existe
error_log(print_r($_SESSION , 1));
    if(isset($_POST['change'])) {
		//On recupere le mot de passe et on le crypte (fonction md5)
        $password = md5($_POST['password']);
       
		//On recupere le nouveau mot de passe et on le crypte
        $newpassword = md5($_POST['newpassword']);
		//On recupere l'email de l'utilisateur dans le tabeau $_SESSION
        $email = $_SESSION['login'];
		//On cherche en base l'utilisateur avec ce mot de passe et cet email
        $sql = "SELECT id FROM tblreaders WHERE  Password =:password AND EmailId = :email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email',$email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();

        $result1 = $query->fetch(PDO::FETCH_OBJ);
        error_log(print_r($result1, 1));
		// Si le resultat de recherche n'est pas vide
        if(!empty($result1 )) {
			// On met a jour en base le nouveau mot de passe (tblreader) pour ce lecteur
            $newpassword = md5($_POST['newpassword']);
            $id = $result1->id;
			$sql2 = "UPDATE tblreaders SET Password =:password   WHERE  id =:id ";
            $query2 =$dbh-> prepare($sql2); 
            $query2->bindParam(':password', $newpassword, PDO::PARAM_STR);
            $query2->bindParam(':id', $id, PDO::PARAM_STR);
            $query2->execute();
    echo "<script>alert('operation reussie ')</script>" ;
		//sinon (resultat de recherche vide)
    }	else {
        echo "<script>alert('mot de passe invalide')</script>" ;
    }
        }      
?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne | changement de mot de passe</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    
    <!-- Penser au code CSS de mise en forme des message de succes ou d'erreur -->

</head>
<script type="text/javascript">

// <!-- On cree une fonction JS valid() qui verifie si les deux mots de passe saisis sont identiques -->
function valid() {
   let password = document.getElementById("password");
   let checkPassword = document.getElementById("check-password");
   let message = document.getElementById("message");
   let button = document.getElementById("submit");
// TRUE si les mots de passe saisis dans le formulaire sont identiques
   checkPassword.addEventListener('keyup', function() {
      if (password.value === checkPassword.value) {
         message.style.color = "green"
         message.innerHTML = "Les mots de passe sont identiques.";
         button.disabled = false;
         // FALSE sinon
      } else {
         message.style.color = "red"
         message.innerHTML = "Les mots de passe ne sont pas identiques.";
         button.disabled = true;
         checkPassword.focus();
         return false;
      }
   })
}
// <!-- Cette fonction retourne un booleen -->

</script>

<body>
<!-- Mettre ici le code CSS de mise en forme des message de succes ou d'erreur -->
<?php include('includes/header.php');?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9 offset-md-1">
            <fieldset class="form-group border p-3">
				<legend class="header-line">CHANGER MON MOT DE PASSE</legend>
				
				    <form name="change-password" method="post" action="change-password.php">
				        <div>
                            <label>Mot de passe actuel :</label>
                            <input placeholder="Entre" class="form-control" type="password" name="password" id="password" required  />
                        </div>
						<div>
                        <label> Nouveau Mot de passe :</label>
                            <input placeholder="Entre" class="form-control" type="password" name="newpassword" id="password" required  />
                        </div>
                        <div >
                            <label>Confirmez le mot de passe :</label>
                            <input placeholder="Comfirmez" class="form-control"  type="password" name="newpassword" id="check-password" onkeyup="return valid()" required  />
                        </div>
						<HR>
						<button type="submit" name="change" class="btn btn-info" id="submit">Changer</button>
						<HR>
                        </div>
				    </form>
							
			</div>
	    </div>
    </div>

	<!--On affiche le titre de la page : CHANGER MON MOT DE PASSE-->  
	<!--  Si on a une erreur, on l'affiche ici -->
	<!--  Si on a un message, on l'affiche ici -->
        
<!--On affiche le formulaire--> 
<!-- la fonction de validation de mot de passe est appelee dans la balise form : onSubmit="return valid();"--> 
         

 <?php include('includes/footer.php');?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>