<?php
session_start();
require_once 'functions/functions.php';

//Step 1 we get the file
$ELEVES = csv_to_array("csv/hrdata.csv",";");
    if ($ELEVES === false) {
        echo "ERREUR";
        exit;
    }

    $SEARCH_TYPES = array('nom_asc' => 'Trier par nom de A à Z', 'nom_desc' => 'Trier par nom de Z à A',
    'ville_asc' => 'Trier par ville de A à Z', 'ville_desc' => 'Trier par ville de Z à A',
    'profil_asc' => 'Trier par profil recherché de A à Z',
    'profil_desc' => 'Trier par profil recherché de Z à A',
    'age_asc' => 'Trier par âge en ordre croissant',
    'age_desc' => 'Trier par âge en ordre décroissant'
      );


if ($_POST) {

    $find=false;
    
    if (isset($_POST["search-bar"])){          
        if ($_POST["search-bar"]){
            $ELEVES=search($_POST["search-bar"]); 
            $find=true;
         }
      }   

     $search_type = $_POST['filter-type'];
    //we filter only the allowed criteria
    if (array_key_exists($search_type, $SEARCH_TYPES) === false) {
        $search_type = '';
      }

    switch ($search_type) {
        case 'nom_asc':        
            foreach ($ELEVES as $key => $value)
               {    
                  $nom[$key]=$value[1];                
               }           
               array_multisort ($nom, SORT_ASC, $ELEVES);
            break;
        case 'nom_desc' :
            foreach ($ELEVES as $key => $value)
               {    
                  $nom[$key]=$value[1];
               }           
               array_multisort ($nom, SORT_DESC, $ELEVES);
            break;         
         case 'ville_asc';
            foreach ($ELEVES as $key => $value)
               {      
                  $ville[$key]=$value[8];
               }               
               array_multisort ($ville, SORT_ASC, $ELEVES);
            break;

         case 'ville_desc' :
            foreach ($ELEVES as $key => $value)
               {    
                  $ville[$key]=$value[8];
               }                   
               array_multisort ($ville, SORT_DESC, $ELEVES);
            break;

         case 'profil_asc' :
            foreach ($ELEVES as $key => $value)
               {    
                  $profil[$key]=$value[12];
               }                       
               array_multisort ($profil, SORT_ASC, $ELEVES);
            break;

         case 'profil_desc' :
            foreach ($ELEVES as $key => $value)
               {    
                  $profil[$key]=$value[12];
               }                       
               array_multisort ($profil, SORT_DESC, $ELEVES);
            break;

         case 'age_asc' :
            foreach ($ELEVES as $key => $value)
               {    
                  $age[$key]=getAge($value[4]);
               }                       
               array_multisort ($age, SORT_ASC, $ELEVES);
            break;

         case 'age_desc' :
            foreach ($ELEVES as $key => $value)
               {    
                  $age[$key]=getAge($value[4]);
               }                       
               array_multisort ($age, SORT_DESC, $ELEVES);
            break;                              
      } 
       
}


?>
    
   <!doctype html>
   <html lang="fr">
   <head>
         <title>CV-Thèque</title>
         <meta charset="utf-8">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
         <link rel="stylesheet" type="text/css" href="css/index.css">
   </head>
   <body>    
         <header>
               <h1>CV-Thèque</h1>
            <nav class="btn-group">
                 <a href="modif.php?action=add" class="btn btn-success">Nouveau candidat</a>    
                 <a href="connexion.php?action=disconnect" class="btn btn-warning">Se déconnecter</a> 
            </nav>
         </header>
         <div class="container" >
               <form method="post" class="row g-2">
                     <div class="form-floating col-6">
                         <input type="search" class="form-control" placeholder="" name="search-bar" id="search-bar" value="<?php if(isset($_POST["search-bar"])&&$_POST["search-bar"]) {print $_POST["search-bar"];}?>">
                         <label for="search-bar">Rechercher un candidat :</label>
                     </div>
                     <div class="form-floating col-4" >
                        <select id="filter" name="filter-type" class="form-select">
                                 <?php foreach ($SEARCH_TYPES as $key => $search) { ?>
                                    <option  value="<?= $key; ?>" <?php if(isset($_POST["filter-type"])&&$_POST["filter-type"]==$key) {print "selected";} ?>>  <?= $search ?> </option>
                                 <?php } ?>
                        </select>
                        <label for="filter">Mode de tri :</label>
                     </div>
                     <div class="col-12">
                        <button class="btn btn-outline-success" type="submit"  name="recherche">Rechercher</button>
                     </div>
               </form>
        
         <div class="contenu">
         <br>
         <br>
         <br>                     
         <!--DEBUT DU TABLEAU OU LISTE-->
         <div class="items" >
            <?php      
         foreach ($ELEVES as $key => $eleve) { 

            //a competency chart is completed for this student
            
            $COMPETENCES = array();
            for ($nb = 13; $nb <22; $nb++) {
               // //cas ou la 1er compétence dans csv est vide
               if (isset($eleve[$nb]) === false)
                   {  continue;}
               if (is_null($eleve[$nb]))
                    { continue;}
               if ($eleve[$nb] === '')
                    { continue;}
               if (trim($eleve[$nb]) === '')
                    { continue;}
               // //on remplace les valeurs incorrecte
               if (trim($eleve[$nb]) === 'NULL')
                    { continue;}
               $COMPETENCES[] = $eleve[$nb];
            } ?>
            
            <div class="card flip-card">
            <div class="flip-card-inner">
               <div class="flip-card-front">
                  <img src="pictures/Avatar_Aang.png" class="card-img-top" alt="Avatar" style="width:300px;height:300px;">
               </div>
               <div class="flip-card-back">
                  <h5 class="card-title"><?= $eleve[2] . ' ' . $eleve[1]; ?></h5>
                  <h4><?= $eleve[12]; ?></h4>
                  <span><?= $eleve[8]; ?></span>
                  <span><?= getAge($eleve[4]); ?> ans</span> 
                  <div class="competences">
                           <?php foreach ($COMPETENCES as $competences) {    ?>
                                    <span class="skills" style=""><?= $competences; ?></span>
                           <?php } ?>
                        <a href="modif.php?id=<?php print $eleve[0];?>" class="btn btn-primary">Modifier</a>
                  </div> 
               </div>
            </div>
            </div>

        <?php }  ?>
            
        </div>
      </div>
   </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>
</html>

                