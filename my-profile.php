<?php 
    // On r�cup�re la session courante
session_start();
    // On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');
    // Si l'utilisateur n'est plus logu�
    // On le redirige vers la page de login
if(strlen($_SESSION['login'])==0) {
	// Si l'utilisateur est d�connect�
	// L'utilisateur est renvoy� vers la page de login : index.php
header('location:index.php');
}else{
	    // Sinon on peut continuer. Apr�s soumission du formulaire de profil
    $mapping = [0=>"inactif",1=>"actif",2=>"supprimé"];
    	// On recupere l'id du lecteur (cle secondaire)
        $sid =$_SESSION['rdid'];
        // On recupere le nom complet du lecteur

        $mail =$_SESSION ['login'];

        $sql="SELECT * FROM tblreaders WHERE ReaderId LIKE :sid";
        $query=$dbh->prepare($sql);
        $query->bindParam(':sid', $sid, PDO::PARAM_STR);
        $query->execute();
        $result= $query->fetch();
        $fullname = $result['FullName'];
        $mobileno = $result['MobileNumber'];
        $regate = $result['RegDate'];
        $update = $result['UpdateDate'];

        $status = $result['Status'];
        if(!empty ($_POST)){
        $newFullname = $_POST['fullname'];
        $newMobile = $_POST['mobileno'];
        $newMail = $_POST['email'];
        // On update la table tblreaders avec ces valeurs
        // $sql2 = "UPDATE tblreaders SET FullName = $fullname, MobileNumber = $mobileno, EmailId = $mail WHERE  ReaderId LIKE $sid";
        $sql2 = "UPDATE tblreaders SET FullName = :fullname, MobileNumber = :mobileno, EmailId = :email WHERE  ReaderId LIKE :sid";
        $query2 =$dbh-> prepare($sql2); 
        $query2->bindParam(':fullname', $newFullname, PDO::PARAM_STR);
        $query2->bindParam(':mobileno', $newMobile, PDO::PARAM_STR);
        $query2->bindParam(':email', $newMail, PDO::PARAM_STR);
        $query2->bindParam(':sid', $sid, PDO::PARAM_STR);
        $query2->execute();
}
}
?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne | Profil</title>
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
<div class="container-fluid">
    <div class="row">
         <div class="col-md-9 offset-md-1">
                 <fieldset class="form-group border p-3">
                    <!--On affiche le titre de la page : EDITION DU PROFIL-->
                 <legend class="header-line">MON COMPTE</legend>
                <!--On affiche le formulaire-->
                <!--On affiche l'identifiant - non editable-->
                <span>Identifiant : <?php echo $sid  ?></span><br>
			    <!--On affiche la date d'enregistrement - non editable-->
                <span>Date d'enregistrement : <?php echo $regate ?></span><br>
                <!--On affiche la date de derniere mise a jour - non editable-->
                <span>Derniere mise a jour : <?php echo $update ?></span><br>
			    <!--On affiche la statut du lecteur - non editable-->
                <span>Status : <?php echo $mapping[$status]  ?></span><br>
			        <form name="signup" method="post" action="my-profile.php">
                         <div>
                            <label>Entrez votre nom complet :</label>
                            <input class="form-control" type="text" name="fullname" value="<?php echo $fullname ?>"  />
                        </div>
                        <!--On affiche le numero de portable- editable-->
                        <div>
                            <label>Portable :</label>
                            <input class="form-control" type="text" name="mobileno" maxlength="10" value="<?php echo $mobileno ?>"  />
                        </div>
                        <!--On affiche l'email- editable-->         
                        <div>
                            <label>Email :</label>
                            <input class="form-control" type="email" name="email" id="emailid"  value ="<?php echo $mail?>"     />
                            <span id="user-availability-status" style="font-size:12px;"></span> 
                        </div>
                        <hr>                      
                            <button type="submit" name="login" class="btn btn-outline-success" id="submit">Mettre a jour</button>
                        <hr>
                    </form>
        </div>
    </div>
</div>
	 <?php include('includes/footer.php');?>
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

  
