<?php


    function readCsv($filename) {
		$datas=array();
		if (file_exists($filename)) {
			//on ouvre le fichier en lecture
			if (($handle = fopen($filename, "r")) !== FALSE) {
				
				//on lit le fichier ligne par ligne
				while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
					//on ajoute la ligne à un tableau php
					$datas[]=$data;
				}
				fclose($handle);
			}
		}
		return $datas;
	}

    function saveFile($filename,$datas) {		
        $fp=fopen($filename,'w');
        foreach($datas as $value) {
            //implode — Rassemble les éléments d'un tableau en une chaîne
          fwrite($fp,implode(";",$value)."\r\n");
        }
        fclose($fp);
        return true;
      }

      function save($filename,$datas) {
		
        $fp=fopen($filename,'a');
        foreach($datas as $value) {
            //implode — Rassemble les éléments d'un tableau en une chaîne
          fwrite($fp,implode(";",$value)."\r\n");
        }
        fclose($fp);
        return true;
      }
	
	function verifyToken($datas,$token) {
		$valid=false;
		foreach($datas as $value) {
			
			if ($token==md5($value[0]."-".$value[1]."-".$value[2])) {
				$_SESSION['name']=ucwords($value[0])." ".ucwords($value[1]);  
				$valid=true;
			}
		}
		return $valid;
	}
	
	function verifyAccount($datas,$login,$pwd) {
		$valid=false;
		foreach($datas as $value) {
			if ($login==$value[2]) {
				if (password_verify($pwd,$value[3]) || $value[3]=="admin") {
					
					$valid=md5($value[0]."-".$value[1]."-".$value[2]);
					$_SESSION['name']=ucwords($value[0])." ".ucwords($value[1]); 		
				}
			}
		}
		return $valid;
	}

	function verifyAccountMail($datas,$login) {
		$valid=false;
		foreach($datas as $value) {
			if ($login==$value[2]) {
				$valid=$value;
			}
		}
		return $valid;
	}


	function csv_to_array($filename = '', $delimiter = ';')
    {
            // file_exists — Vérifie si un fichier ou un dossier existe
        if (!file_exists($filename) || !is_readable($filename))
         {   return FALSE;}
        
            // variable n'a pas encore reçu de valeur.
        $header = NULL;
       
        $datas = array();
            // fopen — Ouvre un fichier ou une URL
         if (($handle = fopen($filename, 'r')) !== FALSE) {        
                 $firstLine=true;
             // fgetcsv — Obtient une ligne depuis un pointeur de fichier et l'analyse pour des champs CSV
            while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
              if($firstLine==false)
              {
                  $datas[]=$data;
              }
            $firstLine=false;              
                
            }
            fclose($handle);
        }
        
        return $datas;
    }

    function search($term) {
        $ELEVES = csv_to_array("csv/hrdata.csv" , ';');
        $tableau_search=array();
        foreach($ELEVES as $value) {
            if (trim(strtolower($term))==trim(strtolower($value[2]))||
            trim(strtolower($term))==trim(strtolower($value[1]))||
            trim(strtolower($term))==trim(strtolower($value[12]))||
            trim(strtolower($term))==trim(strtolower($value[8])))
             {
            $tableau_search[]=$value;
          
            }
            
        }
    
        return $tableau_search;
        
    }

    function getAge($date = '')
    {
        if (VerifierDate($date, 'd/m/Y') === false)
            {return false;}
        $tz = new DateTimeZone('Europe/Paris');
        $age = DateTime::createFromFormat('d/m/Y', $date, $tz)->diff(new DateTime('now', $tz))->y;
      
        return $age;  
    }

    function VerifierDate($date = '', $format = 'Y-m-d H:i:s')
    {
        try {
            $d = DateTime::createFromFormat($format, $date);
            return $d && $d->format($format) == $date;
        } catch (Exception $e) {
            return false;
        }
    }

    function NettoyerCaracteres($ch = '')
    {
        $tabAccents = array("¥" => "Y", "µ" => "u", "À" => "A", "Á" => "A", "Â" => "A", "Ã" => "A", "Ä" => "A",
                            "Å" => "A", "Æ" => "A", "Ç" => "C", "È" => "E", "É" => "E", "Ê" => "E", "Ë" => "E",
                            "Ì" => "I", "Í" => "I", "Î" => "I", "Ï" => "I", "Ð" => "D", "Ñ" => "N", "Ò" => "O",
                            "Ó" => "O", "Ô" => "O", "Õ" => "O", "Ö" => "O", "Ø" => "O", "Ù" => "U", "Ú" => "U",
                            "Û" => "U", "Ü" => "U", "Ý" => "Y", "ß" => "s", "à" => "a", "á" => "a", "â" => "a",
                            "ã" => "a", "ä" => "a", "å" => "a", "æ" => "a", "ç" => "c", "è" => "e", "é" => "e",
                            "ê" => "e", "ë" => "e", "ì" => "i", "í" => "i", "î" => "i", "ï" => "i", "ð" => "o",
                            "ñ" => "n", "ò" => "o", "ó" => "o", "ô" => "o", "õ" => "o", "ö" => "o", "ø" => "o",
                            "ù" => "u", "ú" => "u", "û" => "u", "ü" => "u", "ý" => "y", "ÿ" => "y"
        );

        // mb_detect_encoding — Détecte un encodage
        // strtr -> Remplace des caractères dans une chaîne
        // trim — Supprime les espaces (ou d'autres caractères) en début et fin de chaîne
        // preg_replace — Rechercher et remplacer par expression rationnelle standard
        // mb_strtolower — Met tous les caractères en minuscules
        $encoding = mb_detect_encoding($ch);
        $ch = strtr(($ch), $tabAccents);        
        $ch = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $ch);
        $ch = mb_strtolower(trim($ch, '-'), 'UTF-8');
        $ch = preg_replace("/[_|+ -]+/", '-', $ch);
        return $ch;
    }
    