<?php
session_start();


require_once("functions/functions.php");
$ELEVES = csv_to_array("csv/hrdata.csv" , ';');
if ($ELEVES === false) {
    echo "ERREUR";
    exit;
}

$message="";
  $modif=array();	

	if (isset($_GET['id'])&&$_GET['id']) {
		
		$getId=$_GET['id'];
    
		foreach($ELEVES as $key=>$value) {
			if ($value[0]==$_GET['id']) {
        $modif=$value;
        
			}
			
		} 
		  if($_POST){  		
	
			foreach($ELEVES as $key=> $eleve) {

        if($eleve[0]==$getId){                  
                $ELEVES[$key][1]=$_POST["nom"];
                $ELEVES[$key][2]=$_POST['prenom'];
                $ELEVES[$key][4]=$_POST['date-de-naissance'];
                $ELEVES[$key][3]=getAge($_POST['date-de-naissance']);			       
                $ELEVES[$key][5]=$_POST["adresse"];
                $ELEVES[$key][6]=$_POST["adresse-1"];
			        	$ELEVES[$key][7]=$_POST['code-postal'];
                $ELEVES[$key][8]=$_POST['ville'];
                $ELEVES[$key][9]=$_POST['numero-de-telephone-portable'];
			        	$ELEVES[$key][10]=$_POST['numero-de-telephone-fixe'];
                $ELEVES[$key][11]=$_POST['email'];
				        $ELEVES[$key][12]=$_POST['profil'];
                $ELEVES[$key][13]=$_POST['competence-1'];
                $ELEVES[$key][14]=$_POST['competence-2'];
                $ELEVES[$key][15]=$_POST['competence-3'];
                $ELEVES[$key][16]=$_POST['competence-4'];
                $ELEVES[$key][17]=$_POST['competence-5'];
                $ELEVES[$key][18]=$_POST['competence-6'];
                $ELEVES[$key][19]=$_POST['competence-7'];
                $ELEVES[$key][20]=$_POST['competence-8'];
                $ELEVES[$key][21]=$_POST['competence-9'];
                $ELEVES[$key][22]=$_POST['competence-10'];
                $ELEVES[$key][23]=$_POST['site-web'];
                $ELEVES[$key][24]=$_POST['profil-linkedin'];
                $ELEVES[$key][25]=$_POST['profil-viadeo'];
                $ELEVES[$key][26]=$_POST['profil-facebook'];             
				
              }
    
  } saveFile("csv/hrdata.csv",$ELEVES);

      if (!isset($_SESSION["name"]))  {
        header("location:connexion.php");
      } else {
            header ("location:index.php?connexion=true");     		
      }
  }
 }  


          if (isset($_GET['action'])&&$_GET['action']=="add") {

            if($_POST){
                
                /*procédure de vérification d'un Nom, Prenom, email, déjà existant dans le tableau */
                  $find=false;
                  foreach($ELEVES as $key=>$value) {
                    if (trim(strtolower($_POST['email']))==trim(strtolower($value[11]))) {
                      $find=true;
                      $message="D'après les informations fournies et d'après notre base de données, il semble qu'on possède déjà votre Curriculum Vitae !";
                    }
                    
                  }
                
                  if (!$find) {
                    $max=0;
                    for ($i=1; $i<count($ELEVES);$i++){
                      $valeur=$ELEVES[$i][0];
                      
                      if ((int)$valeur>$max){
                          $max=(int)$valeur;
                          }            
                    }

                    $new=array();
                            $new[]=$max+1;
                            $new[]=$_POST['nom'];
                            $new[]=$_POST['prenom'];
                            $new[]=getAge($_POST['date-de-naissance']); 
                            $new[]=$_POST['date-de-naissance'];
                            $new[]=$_POST['adresse'];
                            $new[]=$_POST['adresse-1'];
                            $new[]=$_POST['code-postal'];
                            $new[]=$_POST['ville'];
                            $new[]=$_POST['numero-de-telephone-portable'];
                            $new[]=$_POST['numero-de-telephone-fixe'];
                            $new[]=$_POST['email'];
                            $new[]=$_POST['profil'];
                            $new[]=$_POST['competence-1'];
                            $new[]=$_POST['competence-2'];
                            $new[]=$_POST['competence-3'];
                            $new[]=$_POST['competence-4'];
                            $new[]=$_POST['competence-5'];
                            $new[]=$_POST['competence-6'];
                            $new[]=$_POST['competence-7'];
                            $new[]=$_POST['competence-8'];
                            $new[]=$_POST['competence-9'];
                            $new[]=$_POST['competence-10'];
                            $new[]=$_POST['site-web'];
                            $new[]=$_POST['profil-linkedin'];
                            $new[]=$_POST['profil-viadeo'];
                            $new[]=$_POST['profil-facebook'];
                            $datas[]=$new;  
                            
                              save("csv/hrdata.csv",$datas);                             

                            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0)
                              {
                                // Testons si le fichier n'est pas trop gros
                                if ($_FILES['file']['size'] <= 8000000)
                                {
                                  // Testons si l'extension est autorisée
                                  $infosfichier = pathinfo($_FILES['file']['name']);
                                  $extension_upload = $infosfichier['extension'];
                                  $extensions_autorisees = array('pdf', 'docx');
                                  if (in_array($extension_upload, $extensions_autorisees))
                                  {
                                          // On peut valider le fichier et le stocker définitivement
                                          move_uploaded_file($_FILES['file']['tmp_name'], 'faits/' . basename($_FILES['file']['name']));
                                          echo "L'envoi a bien été effectué !";
                                  }
                                }
                              }   
                    }  
            }


          }

 if (!isset($_SESSION["name"]))  {
	header("location:connexion.php");
} else {
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <title>modification d'un candidat</title>
</head>

<body class="">
      <div class="container">
            <?php print $message;?>
                        <header>
                          <h1>Modification d'un candidat</h1>
                          <div class="btn-group" style="margin-left:75%;">
                         <?php if (!isset($_SESSION["name"]))  {
                            header("location:connexion.php");
                          } else { ?>
                            <a href="index.php?connexion=return" class="btn btn-success">Menu Principal</a>
                            <?php } ?>
                            <a class="btn btn-warning" href="connexion.php?disconnect=1">Se déconnecter</a>
                          </div>  
                        </header> <br><br>                   

                    <!-- Formulaire -->  

                    <div class="accordion" id="accordionExample">
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            1-Données personnelles
                          </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                          <div class="accordion-body ">
                         
                          <form class="" method="post" enctype="multipart/form-data">
                           <div class="row">
                             <div class="col-md-4">
                              <label for="Nom">* Nom :</label>
                              <input type="text" name="nom" class="form-control" id="nom" value="<?php if (count($modif)&&trim($modif[1],'NULL')) {print $modif[1];} ?>" placeholder="" required>
                            </div>
                            <div class="col-md-4">
                              <label for="Prenom">* Prénom :</label>
                              <input type="text" name="prenom" class="form-control" id="Prenom" value="<?php if (count($modif)&&trim($modif[2],'NULL')) {print $modif[2];} ?>" placeholder="" required>
                            </div>
                            <div class="col-md-4">
                              <label for="Birthdate">* Date de naissance :</label>
                              <input type="date" name="date-de-naissance" class="form-control " id="testDdN" value="<?php if (count($modif)&&trim($modif[4],'NULL')) {print $modif[4];} ?>" placeholder="" required>
                            </div>             
                            <div class="col-md-4">
                              <label for="Adresse">* Adresse :</label>
                              <input type="text" name="adresse" class="form-control " id="testAdresse" value="<?php if (count($modif)&&trim($modif[5],'NULL')) {print $modif[5];} ?>" placeholder="" >
                            </div>
                            <div class="col-md-4">
                              <label for="Adresse1">Adresse 2 :</label>                    
                              <input type="text" name="adresse-1" class="form-control " id="testAdresse1" value="<?php if (count($modif)&&trim($modif[6],'NULL')) {print $modif[6];} ?>" placeholder="" >      
                            </div>
                            <div class="col-md-4">
                              <label for="CP">* Code Postal :</label>
                              <input type="text" name="code-postal" class="form-control " id="CP" value="<?php if (count($modif)&&trim($modif[7],'NULL')) {print $modif[7];} ?>" placeholder="" >
                            </div>
                            <div class="col-md-4">
                              <label for="">* Ville :</label>
                              <input type="text" name="ville" class="form-control " id="Ville" value="<?php if (count($modif)&&trim($modif[8],'NULL')) {print $modif[8];} ?>" placeholder="" >
                            </div>
                            <div class="col-md-4">
                              <label for="">* Tel portable :</label>
                              <input type="text" name="numero-de-telephone-portable" class="form-control " id="Port" value="<?php if (count($modif)&&trim($modif[9],'NULL')) {print $modif[9];} ?>" placeholder="" required>
                            </div>
                            <div class="col-md-4">
                              <label for="Fixe">Tel fixe :</label>
                              <input type="text" name="numero-de-telephone-fixe" class="form-control " id="Fixe" value="<?php if (count($modif)&&trim($modif[10],'NULL')) {print $modif[10];}?>" placeholder="" >
                            </div>
                            <div class="col-md-4">
                              <label for="email">* Email :</label>
                              <input type="email" name="email" class="form-control " id="email" value="<?php if (count($modif)&&trim($modif[11],'NULL')) {print $modif[11];}?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" placeholder="" required>
                            </div> 
                          </div>                       
                          </div>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                           2-Profil et compétences
                          </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                          <div class="accordion-body">
                            <div class="row">
                          <div class="col-md-4">
                              <label for="profil">Profil :</label>
                              <input type="text" name="profil" class="form-control " id="profil" value="<?php if (count($modif)&&trim($modif[12],'NULL')) {print $modif[12];}?>" placeholder="" required>
                            </div>
          <!-- Compétences  de 1 à 5 obligatoires, les autres facultatives-->
                            <div class="col-md-4">
                              <label for="competence1">* Compétence 1 :</label>
                              <input type="text" name="competence-1" class="form-control " id="competence1" value="<?php if (count($modif)&&trim($modif[13],'NULL')) {print $modif[13];} ?>" placeholder="" required>
                            </div>
                            <div class="col-md-4">
                              <label for="competence2">* Compétence 2 :</label>
                              <input type="text" name="competence-2" class="form-control " id="competence2" value="<?php if (count($modif)&&trim($modif[14],'NULL')) {print $modif[14];} ?>" placeholder="" required>
                            </div>
                            <div class="col-md-4">
                              <label for="Competence3">* Compétence 3 :</label>
                              <input type="text" name="competence-3" class="form-control " id="competence3" value="<?php if (count($modif)&&trim($modif[15],'NULL')) {print $modif[15];} ?>" placeholder="" required>
                            </div>
                            <div class="col-md-4">
                              <label for="Competence4">* Compétence 4 :</label>
                              <input type="text" name="competence-4" class="form-control " id="competence4" value="<?php if (count($modif)&&trim($modif[16],'NULL')) {print $modif[16];} ?>" placeholder="" required>
                            </div>
                            <div class="col-md-4">
                              <label for="Competence5">* Compétence 5 :</label>
                              <input type="text" name="competence-5" class="form-control " id="competence5" value="<?php if (count($modif)&&trim($modif[17],'NULL')) {print $modif[17];} ?>" placeholder="" required>
                            </div>
                            <div class="col-md-4">
                              <label for="competence-6">Compétence 6 :</label>
                              <input type="text" name="competence-6" class="form-control " id="competence6" value="<?php if (count($modif)&&trim($modif[18],'NULL')) {print $modif[18];} ?>" placeholder="" >
                            </div>
                            <div class="col-md-4">
                              <label for="competence-7">Compétence 7 :</label>
                              <input type="text" name="competence-7" class="form-control " id="competence7" value="<?php if (count($modif)&&trim($modif[19],'NULL')) {print $modif[19];} ?>" placeholder="" >
                            </div>
                            <div class="col-md-4">
                              <label for="competence-8">Compétence 8 :</label>
                              <input type="text" name="competence-8" class="form-control " id="competence8" value="<?php if (count($modif)&&trim($modif[20],'NULL')) {print $modif[20];} ?>" placeholder="" >
                            </div>
                            <div class="col-md-4">
                              <label for="competence-9">Compétence 9 :</label>
                              <input type="text" name="competence-9" class="form-control " id="competence9" value="<?php if (count($modif)&&trim($modif[21],'NULL')) {print $modif[21];} ?>" placeholder="" >
                            </div>
                            <div class="col-md-4">
                              <label for="competence-10">Compétence 10 :</label>
                              <input type="text" name="competence-10" class="form-control " id="competence10" value="<?php if (count($modif)&&trim($modif[22],'NULL')) {print $modif[22];} ?>" placeholder="" >
                            </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            3-Réseaux sociaux
                          </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                          <div class="accordion-body">
                            <div class="row">
                          <div class="col-md-4">
                              <label for="url"><span class="field-name">Site web personnel :</span></label>
                              <input type="url" autocomplete="url" name="site-web" class="form-control " id="url" value="<?php if (count($modif)&&trim($modif[23],'NULL')) {print $modif[23];} ?>" placeholder="" >
                            </div>
                            <div class="col-md-4">
                              <label for="Viadeo">Viadéo :</label>
                              <input type="text" name="profil-viadeo" class="form-control " id="viadeo" value="<?php if (count($modif)&&trim($modif[24],'NULL')) {print $modif[24];} ?>" placeholder="" >
                            </div>
                            <div class="col-md-4">
                              <label for="Linkedin">LinkedIn :</label>
                              <input type="text" name="profil-linkedin" class="form-control " id="Linkedin" value="<?php if (count($modif)&&trim($modif[25],'NULL')) {print $modif[25];} ?>" placeholder="" >
                            </div>
                            <div class="col-md-4">
                              <label for="fb">Facebook :</label>
                              <input type="text" name="profil-facebook" class="form-control " id="Fb" value="<?php if (count($modif)&&trim($modif[26],'NULL')) {print $modif[26];} ?>" placeholder="" ><br>
                            </div> 
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="card">
                      <h5 class="card-header">* Importer votre Curriculum Vitae</h5>
                      <div class="card-body">
                      <div class="input-group">
                        <input type="file"  name="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                      </div>
                      </div>
                    </div>
                    <br><br>
                    <div class="col-6 text-center">
                      <button type="submit" class="btn btn-primary">Enregistrer la modification</button>
                    </div>
                  </form>                  
                </div>
              </div>
            </div>
          </div>
        </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</body>
</html>
<?php } 