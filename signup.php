<?php
// On r�cup�re la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');
if(isset($_POST['signup'])) {
    // Aapr�s la soumission du formulaire de compte (plus bas dans ce fichier)
	// On v�rifie si le code captcha est correct en comparant ce que l'utilisateur a saisi dans le formulaire
	// $_POST["vercode"] et la valeur initialis�e $_SESSION["vercode"] lors de l'appel � captcha.php (voir plus bas
    if($_POST['vercode']!= $_SESSION['vercode']) {
        echo "<script>alert('Code de verification incorrect')</script>";
    } else {
    //On lit le contenu du fichier readerid.txt au moyen de la fonction file. Ce fichier contient le dernier identifiant lecteur cree.
        if(TRUE===file_exists("readerid.txt")) {
            $hits = file("readerid.txt");
            // On incr�mente de 1 la valeur lue
            $hits[0]++;
            // On ouvre le fichier readerid.txt en �criture
            
            $fp = fopen("readerid.txt", "w");
                // On �crit dans ce fichier la nouvelle valeur
            fputs($fp, "$hits[0]");
                // On referme le fichier
            fclose($fp);

                // On r�cup�re le nom saisi par le lecteur
            $fname = $_POST['fullname'];
                    // On r�cup�re le num�ro de portable
            $mobileno = $_POST['mobileno'];
                    // On r�cup�re l'email
            $email =$_POST['email'];
                    // On r�cup�re le mot de passe
            $password = md5($_POST['password']);
                    // On fixe le statut du lecteur � 1 par d�faut (actif)
            $status = 1;
            // On pr�pare la requete d'insertion en base de donn�e de toutes ces valeurs dans la table tblreaders
            $sql = "INSERT INTO tblreaders (ReaderId, FullName, MobileNumber, EmailId, Password, Status) VALUES 
            (:ReaderId, :FullName, :MobileNumber, :EmailId, :Password, :Status)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':ReaderId', $hits[0], PDO::PARAM_STR);
            $query->bindParam(':FullName', $fname, PDO::PARAM_STR);
            $query->bindParam(':MobileNumber', $mobileno, PDO::PARAM_STR);
            $query->bindParam(':EmailId', $email, PDO::PARAM_STR);
            $query->bindParam(':Password', $password, PDO::PARAM_STR);
            $query->bindParam(':Status', $status, PDO::PARAM_STR);
                // On �xecute la requete
            $query->execute();
            error_log(print_r($query,1));
                    // On r�cup�re le dernier id ins�r� en bd (fonction lastInsertId)
            $lastInsert = $dbh->lastInsertId();
            error_log(print_r($lastInsert, 1));
                    // Si ce dernier id existe, on affiche dans une pop-up que l'op�ration s'est bien d�roul�e, et on affiche l'identifiant lecteur (valeur de $hit[0])
            if($lastInsert !== FALSE){
                echo "<script> alert('Vous etes enregistre avec succes, votre ID est ".$hits[0]."')</script>";
                        
            }else {
                echo "<script>alert('Un probleme et survenu')</script>";
                        // Sinon on afficher qu'il y a eu un probleme
            }
        }       else {
            echo "<script>alert(''Fichier reader.txt absent')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang = "FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <title>Gestion de bibliotheque en ligne | Signup</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <!-- link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' / -->
    <script type="text/javascript">
    // On cree une fonction valid()  de validation sans param�tre qui renvoie 
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

window.addEventListener("load", valid);
    
    // On cree une fonction avec l'email pass� en param�tre et qui v�rifie la disponibilit� de l'email
    function checkAvailability(str) {
        let xhr = new XMLHttpRequest();
        xhr.open("GET" , "check_availability.php?emailid=" + str);
        xhr.responseType = "text";
        xhr.send();

        xhr.onload = function() {
            document.getElementById('user-availability-status').innerHTML = xhr.response;
        }
        xhr.onerror = function(){
            alert("Une erreur s'est produite");
        }
    }
	// Cette fonction effectue un appel AJAX vers check_availability.php
	
	
    </script>
</head>
<body>
 <!-- On inclue le fichier header.php qui contient le menu de navigation-->

<?php include('includes/header.php');?>
<!--On affiche le titre de la page : CREER UN COMPTE-->  
        <!--On affiche le formulaire de creation de compte-->
        <!--A la suite de la zone de saisie du captcha, on ins�re l'image cr��e par captcha.php : <img src="captcha.php">  -->
	
<div class="container-fluid">
    <div class="row">
             <div class="col-md-9 offset-md-1">
                    <fieldset class="form-group border p-3">
                        <legend class="header-line">Créer un Compte</legend>
                    
                            <form name="signup" method="post">
                                <div>
                                    <label>Entrez votre nom complet</label>
                                    <input placeholder="Entre votre Nom" class="form-control" type="text" name="fullname"  required />
                                </div>
                                <div>
                                    <label>Portable :</label>
                                    <input placeholder="Entre votre Numero de telephone complet" class="form-control" type="text" name="mobileno" maxlength="10"  required />
                                </div>
                                            
                                <div>
                                    <label>Email :</label>
                                    <input placeholder="Entre votre email" class="form-control" type="email" name="email" id="emailid" onBlur="checkAvailability(this.value)"  autocomplete="off" required  />
                                    <span  id="user-availability-status" style="font-size:12px;"></span> 
                                </div>

                                <div>
                                    <label>Mot de passe :</label>
                                    <input placeholder="Entre votre mot de passe" class="form-control" type="password" name="password" id="password" required  />
                                </div>
                                <div >
                                    <label>Confirmez le mot de passe :</label>
                                    <input placeholder="Confirmez votre mot de passe" class="form-control"  type="password" name="confirmpassword" id="check-password" onBlur="return valid()" required  />
                                </div>
                                
                                <span id="message"></span>
                                
                                <div>
                                    <label>Code de verification :</label>
                                    <input type="text"  name="vercode" maxlength="5" autocomplete="off" required style="width: 150px; height: 25px;" />&nbsp;<img src="captcha.php">
                                </div>                                
                                <button type="submit" name="signup" class="btn btn-danger" id="submit">Enregistrer</button>
                            </form>
                            <hr>
              </div>
        </div>
    </div>
     <!-- On appelle la fonction valid() dans la balise <form> onSubmit="return valid(); -->
    <!-- On appelle la fonction checkAvailability() dans la balise <input> de l'email onBlur="checkAvailability(this.value)" -->
    



      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </body>
</html>









