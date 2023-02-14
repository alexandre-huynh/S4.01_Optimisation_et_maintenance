<?php


/**
 * Fonction échappant les caractères html dans $message
 * @param string $message chaîne à échapper
 * @return string chaîne échappée
 */
function e($message)
{
    return htmlspecialchars($message, ENT_QUOTES);
}


function formation($i){
	/*
	N'est pas utilisé !
	Mais été censé être utiliser dans l'inscription. 
	La complexité de cette fonction est de O(1), car elle effectue un nombre constant d'opérations (vérification de condition) indépendamment de la taille de l'entrée.
	Elle retourne une seule valeur en fonction de la valeur de l'entrée, qui est comparée à 0 et 1.
	*/
	if ($i==0){
		$formation="BUT 1ère année";
	}
	
	elseif ($i==1){
		$formation="BUT 2ème année";
	}
	
	else {
		$formation="Il n'y a pas de formation enregistré";
	}
	
	return $formation;
}

function pdate($date){
	/* 
	Cette fonction renvoie au format d'un texte la date, reçu de la base de donnée, en paramètre.
	Si $date="2022-12-31 14:43:00" alors le retour est "31 décembre 2022, 14:43".
	La complexité de cette fonction est de O(1), car elle effectue un nombre constant d'opérations (découpage de chaînes, 
	accès à un tableau et ce indépendamment de la taille de l'entrée.
	*/
	$mois=["janvier","février","mars","avril","mai","juin","juillet","août","septembre","octobre","novembre","décembre"];
	$tout=explode(" ",$date);
	$jour=explode("-",$tout[0]);
	$heure=explode(":",$tout[1]);
	return "".$jour[2]." ".$mois[$jour[1]-1]." ".$jour[0].", ".$heure[0].":".$heure[1];
 }

function np($nom,$prenom){
	/* 
	Cette fonction renvois les deux chaines entrer en paramètre concaténer.
	La complexité de cette fonction est O(1), elle ne dépend pas de la taille des entrées,
	 elle prend simplement deux variables, nom et prénom, et les concatène pour créer une chaine de caractères "Prenom Nom"
	*/
	return e($prenom)." ".e($nom);
}

function sessionValide($session){
	/* 
	Cette fonction vérifie que le tableau de la session 
		envoyé en paramètre contient bien les bons paramètres.
	La complexité de cette fonction est en O(1), car elle effectue un certain nombre de vérifications (isset) sur les champs nomPersonne, 
	prenomPersonne, personne, role, n, mail, Formation) de la variable $session, 
	ces vérifications ont toutes une complexité constante et ne dépendent pas de la taille des entrées.
	*/	
		
		return isset($session["nomPersonne"]) && isset($session["prenomPersonne"]) && isset($session["personne"])
		&& isset($session["role"]) && isset($session["n"]) && isset($session["mail"])
		&& isset($session["Formation"]);
	}
	
function userValide($session,$user){
	/* 
	Cette fonction vérifie que le tableau de la session 
		et le tableau renvoyer par userExist du Model
		envoyé en paramètre contiennent les mêmes informations.
	La complexité de cette fonction est en O(1), car elle effectue un certain nombre de comparaisons (vérification de l'égalité des valeurs des champs nomPersonne, 
	prenomPersonne, personne, role, mail, Formation) 
	entre les données stockées dans les variables $session et $user, ces comparaisons ont toutes une complexité constante et ne dépendent pas de la taille des entrées. 
	*/
	return $session["nomPersonne"]==$user["nomPersonne"] && $session["prenomPersonne"]==$user["prenomPersonne"] && $session["personne"]==$user["personne"]
		&& $session["role"]==$user["role"] && $session["n"]==$user["n"] && $session["mail"]==$user["mail"]
		&& $session["Formation"]==$user["Formation"];
	
}
		
		
		


function typeValide($type){
	/*
	Cette fonction vérifie si le type entrer en paramètre est valide pour nos besoins.
	La complexité de cette fonction est en O(n), car elle utilise la fonction "in_array" qui parcours tous les éléments du tableau $types pour voir si $type y est présent. 
	Le temps d'exécution de la fonction augmente proportionnellement avec la taille de $types, si le tableau est plus grand, le parcours sera plus long.
	*/
	$types=["BOS","CV","LM","JDB","RS","RSF"];
	return in_array($type,$types);
	
}

function typePhrase($type){
	/*
	Cette fonction est utilisé pour la page d'upload (de dépots de fichiers/documents).
	Elle renvoie une phrase pour compléter le "Ajouté " dans la page d'upload, avec le type reçu en paramètre.
		Si le type n'est pas valide, elle renvoie false.
	La complexité de cette fonction est en O(1) , car elle fonctionne de la même manière que les fonctions précédentes. 
	Elle utilise la fonction "typeValide()" pour vérifier si la variable $type est égale à une des valeurs possibles ("BOS", "CV", "LM", "JDB", "RS", "RSF"), 
	et si c'est le cas, elle renvoie une chaine de caractère correspondante. Sinon, elle renvoie false.
	*/
	if (typeValide($type)){
		if ($type=="BOS"){
			return "un bordereau d'offre de stage";
		}
		
		elseif ($type=="CV"){
			return "un CV";
		}
		
		elseif ($type=="LM"){
			return "une lettre de motivation";
		}
		
		elseif ($type=="JDB"){
			return "un journal de bord";
		}
		
		elseif ($type=="RS"){
			return "un mini-rapport de stage";
		}
		
		elseif ($type=="RSF"){
			return "le rapport final de stage";
		}
	}
	return false;
	
}

function typeDeDocument($type){
	/*
	Cette fonction est utilisé pour la base de données.
	Elle renvoie un le type qui va être montrer dans la base de données, avec le type reçu en paramètre.
		Si le type n'est pas valide, elle renvoie false.
		Ex : si $type='BOS' elle retourne "Bordereau_d-offre_de_Stage".
	La complexité de cette fonction est en O(1).
	Elle vérifie si la variable $type est égale à une des valeurs possibles ("BOS", "CV", "LM", "JDB", "RS", "RSF"), 
	et si c'est le cas, elle renvoie une valeur correspondante. Sinon, elle renvoie false.
	*/
	if (typeValide($type)){
		if ($type=="BOS"){
			return "Bordereau_d-offre_de_Stage";
		}
		
		elseif ($type=="CV"){
			return "CV";
		}
		
		elseif ($type=="LM"){
			return "Lettre_de_Motivation";
		}
		
		elseif ($type=="JDB"){
			return "Journal_De_Bord";
		}
		
		elseif ($type=="RS"){
			return "Mini_Rapport_de_Stage";
		}
		
		elseif ($type=="RSF"){
			return "Rapport_final";
		}
	}
	return false;
	
}

function typeDoc($type){
	/*
	Cette fonction est utilisé pour récupérer le type de la base de données et l'afficher d'une manière plus adapté a l'utilisateur sur la page enseignant et étudiant.
	Elle renvoie un le type qui va être montrer sur les pages dit précédement, avec le type reçu en paramètre.
		Si le type n'est pas valide, elle renvoie false.
		Ex : si $type='Lettre_de_Motivation' elle retourne "Lettre de Motivation".
	La complexité de cette fonction est en O(1), car elle ne dépend pas de la taille des entrées, 
	elle vérifie simplement si la variable $type est égale à une des valeurs possibles 
	( "Bordereau_d-offre_de_Stage", "CV", "Lettre_de_Motivation", 
	"Journal_De_Bord", "Mini_Rapport_de_Stage", "Rapport_final") , 
	et si c'est le cas, elle renvoie une valeur correspondante. Sinon, elle renvoie false. 
	*/
		if ($type=="Bordereau_d-offre_de_Stage"){
			return "BOS";
		}
		
		elseif ($type=="CV"){
			return "CV";
		}
		
		elseif ($type=="Lettre_de_Motivation"){
			return "Lettre de Motivation";
		}
		
		elseif ($type=="Journal_De_Bord"){
			return "Journal De Bord";
		}
		
		elseif ($type=="Mini_Rapport_de_Stage"){
			return "Mini Rapport de Stage";
		}
		
		elseif ($type=="Rapport_final"){
			return "Rapport final de Stage";
		}
	
	return false;
	
}

function promos(){
	/*
    Cette fonction renvoie des promos selon l'année.
	Elle est utilisée dans l'inscription et sert a proposer des année de choix lors de la création de groupes.
		Ex : si on est en avant juillet, pour cette année elle donne ['2022-2023','2023-2024'],
			si on est après elle renverrai ['2023-2024','2024-2025'].
    La complexité de cette fonction est en O(1), car elle effectue un certain nombre d'opérations (calcul de la date actuelle, 
	décomposition de la date en mois et année, calcul des années pour les promotions) qui ont toutes une complexité constante 
	et ne dépendent pas de la taille des entrées. 
  */
	$dt = time();
	$date=date( "m-Y", $dt );
	$data=explode('-',$date);
	$annee=$data[1];
	if ($data[0]>7){
		$annee1=$annee;
		$annee2=$annee+1;
		$annee3=$annee+2;
		$promo1=[$annee1,$annee2];
		$promo2=[$annee2,$annee3];
		$promos=[implode('-',$promo1),implode('-',$promo2)];
	}
	else{
		$annee1=$annee-1;
		$annee2=$annee;
		$annee3=$annee+1;
		$promo1=[$annee1,$annee2];
		$promo2=[$annee2,$annee3];
		$promos=[implode('-',$promo1),implode('-',$promo2)];
	}
	
	return $promos;
	
}

?>
