<?php
require_once("functions/functions.php");

$datas=readCsv("csv/users.csv");
if ($datas === false) {
  echo "ERREUR";
  exit;
}

  $find=false;
$message="";
if ($_POST)
{ 
      if ($_POST['pwd']==$_POST['rpwd'])
      { 
             
     foreach($datas as $key => $value)
      {
          if ($value[2]==$_POST['mail'])
          {
              $find=true;
              $message="Vous avez déjà un compte enregistrer avec cette adresse mail !<br> Veuillez-vous connecter !.";
          }     
          
      }  

      if (!$find) {
        $new=array();
        $new[]=$_POST["firstName"];
        $new[]=$_POST["lastName"];
        $new[]=$_POST["mail"];
        $new[]=password_hash($_POST["pwd"], PASSWORD_ARGON2I);
        $datas[]=$new;
        
       saveFile("csv/users.csv",$datas);

       header("location:connexion.php");
       if ($send===true) {
        /* redirection vers la page d'identification si inscription réussie */
        header("Location:connexion.php?register=ok");
      } else {
        $error=$send;
      }
          }
         }else {
          $error="Mail déjà enregistré. Vous pouvez vous connecter ou choisir une autre adresse mail !.";
        }
}
    
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"  integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body style="background-color:beige;">
    <div class="container">
        <div> <?php print $message ?> </div>

                    <div class="card" style="width: 18rem;margin-left:30%; margin-top:10%;">
                    <div class="card-body text-center">
                      Enregistrer vous :
                    </div>
                    </div>
                    <div class="card" style="width:800px;margin-top:10%; margin-left:10%;">
                 <div class="card-body">
                    <form method="post" class="row g-3">        
                    <div class="col-md-4">
                        <label for="firstname">* Prénom </label>
                        <input class="form-control" type="text" name="firstName" id="firstname" value="<?php if (isset($_POST['firstName'])&& $_POST['firstName'])print $_POST['firstName'];  ?>" required> 
                    </div>

                    <div class="col-md-4">
                        <label for="lasttName">* Nom </label>
                        <input class="form-control" type="text" name="lastName" id="lastName" value="<?php if (isset($_POST['lastName'])&& $_POST['lastName'])print $_POST['lastName'];?>" required> 
                    </div>

                    <div class="col-md-4">
                        <label for="email">* Email </label>
                        <input class="form-control" type="email" name="mail" id="email" value="<?php if (isset($_POST['mail'])&& $_POST['mail'])print $_POST['mail'];  ?>" required> 
                    </div>

                    <div class="col-md-4">
                        <label for="pwd">* Mot de passe </label>
                        <input class="form-control" type="password" name="pwd" id="pwd" required> 
                    </div>

                    <div class="col-md-4">
                        <label for="rpwd">* Confirmer le mot de passe</label>
                        <input class="form-control" type="password" name="rpwd" id="rpwd"required> 
                    </div>
                    
                    <div class="col-12" style="margin-top:2%;">
                        <button class="btn btn-primary" type="submit" value="" name="register">Enregistrer</button>
                    </div>      
             </form> 
            </div>
            </div>  
                <br><br>
             <div class="col-md-12" style="margin-left:70%;">
                <a class="btn btn-info" href="connexion.php" type="button">Se connecter</a>
            </div> 
     

 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>