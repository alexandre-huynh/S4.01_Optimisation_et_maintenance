<?php

class Model
{
    /**
     * Attribut contenant l'instance PDO
     */
    private $bd;

    /**
     * Attribut statique qui contiendra l'unique instance de Model
     */
    private static $instance = null;

    /**
     * Constructeur : effectue la connexion à la base de données.
     */
    private function __construct()
    {
        include "credentials.php";
        $this->bd = new PDO($dsn, $login, $mdp);
        $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->bd->query("SET nameS 'utf8'");
    }

    /**
     * Méthode permettant de récupérer un modèle car le constructeur est privé (Implémentation du Design Pattern Singleton)
     */
    public static function getModel()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }



/**
* Fonction upload_fichier 
*/

	public function upload_fichier($fichier,$typeDeFichier,$user){
		/* 
		Cette fonction permet l'ajout d'un document dans la base de donnée.
		Elle prend en paramètres le nom du fichier, 
			le type de document (CV,Lettre_de_motivation, etc..),
			et le Username de l'élève qui dépose un document.
		Cette fonction ne renvoie rien, elle ajoute un document 
			dans la base de donnée avec :
			- le Type donner par $typeDeDocument, 
			- le Student_ID, l'id de l'utilisateur, récupérer avec le $user,
			- l'URL, le nom du fichier, qui est donné par $fichier,
			- la version qui est obtenu en comptant le nombre de fichier du 
				même type, déposer par ce même utilisateur, déjà existant,
			- et le Date_heure, la date de l'envoie (l'heure est avec),
				qui est obtenue en faisant un date("Y-m-d H:i:s", $dt),
				$dt étant le temps donner par time(),
			et si le type de documentest Bordereau_d-offre_de_Stage 
			il ajoute aussi le document dans la Table BOS, en récuppérant, 
			au passage, le Document_ID du document venant d'être poster.
			
		La complexité de cette fonction est en O(1) car elle n'effectue pas requete complexe, elle est donc constante.
		*/ 
		$id=$this->getID($user);
		$version=$this->getNewVersion($user,$typeDeFichier);
		
		$dt = time();
		$date=date( "Y-m-d H:i:s", $dt );
		$req =$this->bd->prepare('INSERT INTO Document(Type,Student_ID,Date_heure,URL,version) value(:typeDeFichier,:id,:date,:fichier,:version)');
		$req->bindValue(':typeDeFichier',$typeDeFichier);
		$req->bindValue(':id',$id);
		$req->bindValue(':fichier',$fichier);
		$req->bindValue(":date",$date);
		$req->bindValue(":version",$version);
		$req ->execute();
		
		if ($typeDeDocument='Bordereau_d-offre_de_Stage'){
			$reqDocID=$this->bd->prepare("SELECT Document_ID AS Vers FROM Document WHERE Student_ID=:id AND Type=:typeDeFichier AND URL=:fichier AND version=:version AND Date_heure=:date");
			$reqDocID->bindValue(':typeDeFichier',$typeDeFichier);
			$reqDocID->bindValue(':id',$id);
			$reqDocID->bindValue(':fichier',$fichier);
			$reqDocID->bindValue(":date",$date);
			$reqDocID->bindValue(":version",$version);
			$reqDocID ->execute();
			$DocID=$reqDocID->fetchAll(PDO::FETCH_ASSOC);
			
			
			$reqBOS =$this->bd->prepare('INSERT INTO BOS(Document_ID,Status,BOS_Flag,Date_heure) value(:DocID,:statue,false,:date)');
			$reqBOS->bindValue(':DocID',$DocID[0]['Vers']);
			$reqBOS->bindValue(':statue',"RAS");
			$reqBOS->bindValue(":date",$date);
			$reqBOS ->execute();
		}
		return (bool) $req->rowCount();

	}
	
	public function nomDocExist($user,$type,$url){
		/*
		Cette fonction renvoie vrai ou faux (true/false) 
			selon si un document tester existe deja 
			dans la base de donnée.
		Pour faire cette vérification, elle prend en paramètre :
			- $user, qui est le Username de l'utilisateur qui 
				veut poster le document,
			- $type, qui est le type du document à poster,
			- $url, qui est le nom du document.
		Cette fonction vérifie donc si le document a poster existe.
			et donc pour cela utilise les différents paramètre,
			le $user sert a récupérer l'id de l'étudiant.
		La complexité de cette fonction est O(1) car elle effectue une seule requête à la base de données pour vérifier si un document existe en utilisant l'ID de l'utilisateur, 
		le type de document et l'URL du document comme critères de recherche. 
		Elle n'utilise pas de boucles ou d'opérations répétitives qui pourraient augmenter la complexité de la fonction. 

		*/ 
		$id=$this->getID($user);
		$reqDocID=$this->bd->prepare("SELECT COUNT(Document_ID) AS nb FROM Document WHERE Student_ID=:id AND Type=:type AND URL=:url");
		$reqDocID->bindValue(':type',$type);
		$reqDocID->bindValue(':id',$id);
		$reqDocID->bindValue(':url',$url);
		$reqDocID ->execute();
		$DocID=$reqDocID->fetchAll(PDO::FETCH_ASSOC);
		
		return $DocID[0]['nb']==1;
		
	}
	
	public function getNewVersion($user,$type){
		/*
		Cette fonction reccupère la nouvelle version, pour l'upload.
		Elle prend en paramètres le nom d'utilisateur, $user,
			et le type de document, $type.
		Elle compte le nombre de fichier du type présciser, 
			poster par l'utilisateur, et ajoute 1 a ce
			nombre afin de pouvoir changer de version.
			Si aucun fichier existe dans ce type,
			pour cet utilisateur, il met 1 (car il n'y en a pas).
		La complexité de cette fonction est O(1), car elle effectue une seule requête à la base de données.
 */
		$id=$this->getID($user);
		$req =$this->bd->prepare("SELECT COUNT(version) AS Vers FROM Document WHERE Student_ID=:id AND Type=:type");//recupere Username, à écrire
		$req->bindValue(":id",$id);
		$req->bindValue(":type",$type);
		$req ->execute();
		$m=$req->fetchAll(PDO::FETCH_ASSOC);
		
		return $m[0]["Vers"]+1;
	}
	
	
	
	public function last50($user){
		/*
		Cette fonction renvoie les 50 dernier document envoyer
			par un utilisateur précis, elle les renvoie 
			en ordre décroissant afin d'avoir les derniers
			document poster en premiers. Doit être utilisé pour un étudiant.
		Elle prend en paramètre le Username, le nom d'utilisateur 
			de l'étudiant, $user, et renvoie les donnée nécessaires des
			50 derniers documents poster par l'étudiant pour la page étudiante.
		La complexité de cette fonction est O(n) où n est le nombre de documents retournés par la requête. 
		Cette fonction effectue une seule requête à la base de données pour récupérer les informations des 50 derniers documents 
		d'un utilisateur donné en utilisant l'ID de l'utilisateur comme critère de recherche. 
		Elle utilise ensuite une boucle pour parcourir les résultats de la requête et les formater en un tableau d'informations.Elle retourne finalement ce tableau. 
	*/
		$id=$this->getID($user);
		
		$reqInfos =$this->bd->prepare("SELECT Type,Date_heure,URL,version FROM Document WHERE Student_ID=:id ORDER BY Date_heure DESC LIMIT 50");
		$reqInfos->bindValue(":id",$id);
		$reqInfos ->execute();
		$last50=$reqInfos->fetchAll(PDO::FETCH_ASSOC);
		$infos=[];
		$nom=$this->getNom($user);
		$prenom=$this->getPrenom($user);
		$pn=$prenom.' '.$nom;
		foreach($last50 as $info){
			$infos[]=[
				'type'=>$info['Type'],
				'personne'=>$pn,
				'date'=>$info['Date_heure'],
				'url'=>$info['URL'],
				'version'=>$info['version']
			];
			
		}
		return $infos;
	}
	
	
	
	
	public function derniersDoc(){
		/*
		Cette fonction renvoie un tableau ayant toute les données nécessaires 
			de tout les dernier documents envoyé par tout les étudiant, 
			pour l'affichage de la page enseignante
		Cette fonction ne prend aucun paramètres. Si il n'y a pas de 
			document posté le tableau est vide.
		La complexité de cette fonction est O(n) où n est le nombre de documents retournés par la requête. Cette fonction effectue une seule requête 
		à la base de données pour récupérer les informations de tous les documents triés par ordre décroissant de date d'ajout. 
		Elle utilise ensuite une boucle pour parcourir les résultats de la requête et pour obtenir des informations supplémentaires sur l'utilisateur qui a ajouté le document 
		en utilisant des fonctions comme getUser, getPrenom, getNom, getDepartement, getFormation. Elle retourne finalement un tableau contenant ces informations.
		 */
		$reqInfos =$this->bd->prepare("SELECT Type,Document_ID,Student_ID,Date_heure,URL,version FROM Document ORDER BY Date_heure DESC");
		$reqInfos ->execute();
		$Docs=$reqInfos->fetchAll(PDO::FETCH_ASSOC);
		$infos=[];
		foreach($Docs as $info){
			$user=$this->getUser($info['Student_ID'],'Etudiant');
			$personne=$this->getPrenom($user)." ".$this->getNom($user);
			$departement=$this->getDepartement($user);
			$composante=$this->getFormation($user);
			$infos[]=[
				'type'=>$info['Type'],
				'docID'=>$info['Document_ID'],
				'personne'=>$personne,
				'date'=>$info['Date_heure'],
				'url'=>$info['URL'],
				'version'=>$info['version'],
				'user'=>$user
			];
			
		}
		return $infos;
	}

    public function getDocByAnnee($annee){
        $requete = $this->bd->prepare('SELECT Type,Document_ID, CONCAT(Nom, Prenom) AS "Personne", Date_heure, URL, Version, Username FROM Document JOIN Etudiant USING(Student_ID) JOIN Login ON etudiant.Student_ID=login.User_ID WHERE YEAR(document.Date_heure) = :annee ORDER BY Date_heure DESC');
        $requete->bindValue(':annee',$annee);
        $requete-> execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }
	
	
	
	public function getM($user){
		/*
		Cette fonction renvoie le Mot de Passe hacher
			de l'utilisateur voulant ce connecter. 
		Elle prend en paramètre le Username, le nom d'utilisateur, 
			$user, et renvoie le Mot de Passe pour 
			tester la fonctionnalité de connexion.
		La complexité de cette fonction est O(1) car elle effectue une seule requête à la base de données pour 
		récupérer le mot de passe haché de l'utilisateur en utilisant le nom d'utilisateur comme critère de recherche.
		 */
		$req =$this->bd->prepare("SELECT Password FROM Login WHERE Username=:user");
		$req->bindValue(":user",$user);
		$req ->execute();
		$m=$req->fetchAll(PDO::FETCH_ASSOC);
		
		return $m[0]["Password"];
	}
	
	public function getID($user){ 
		/*
		Cette fonction renvoie l'ID de l'utilisateur. 
		Elle prend en paramètre le Username, le nom d'utilisateur,
			 $user, et renvoie l'ID de l'utilisateur.
		 La complexité de cette fonction est O(1) car elle effectue une seule requête à la base de données pour récupérer 
		 l'ID de l'utilisateur en utilisant le nom d'utilisateur comme critère de recherche.
		  */
		$reqID =$this->bd->prepare("SELECT User_ID FROM Login WHERE Username=:user");
		$reqID->bindValue(":user",$user);
		$reqID ->execute();
		$mid=$reqID->fetchAll(PDO::FETCH_ASSOC);
		
		return $mid[0]["User_ID"];
	}
	
	
	

	public function getUser($id,$role){
		/*
		Cette fonction renvoie le Username, soit le nom d'utilisateur apparessant dans Login. 
		Elle prend en paramètre l'ID de l'utilisateur, le nom d'utilisateur, 
			$user, et le Rôle de cette utilisateur,
			et renvoie son Username.
		La complexité de cette fonction est O(1) car elle effectue une seule requête à la base de données pour récupérer le nom d'utilisateur en utilisant 
		l'ID de l'utilisateur et le rôle comme critères de recherche. 
		*/
		
		if ($role=='Etudiant'){
			$reqUser =$this->bd->prepare("SELECT Username FROM Login WHERE User_ID=:id AND Rôle=true");
		}
		else{
			$reqUser =$this->bd->prepare("SELECT Username FROM Login WHERE User_ID=:id AND Rôle=false");
		}
		$reqUser->bindValue(":id",$id);
		$reqUser ->execute();
		$mid=$reqUser->fetchAll(PDO::FETCH_ASSOC);
		
		return $mid[0]["Username"];
	}
	
	
	public function roleTable($user) {
		/*
		Cette fonction renvoie un tableau contennant le rôle de l'utilisateur
			et le nom de l'ID a utilisé selon le rôle.
			L'utilisateur entrer en paramètre afin de pouvoir des tests rapidement
			dans d'autre fonction du Model. 
		Elle prend en paramètre le Username, le nom d'utilisateur, $user.
		La complexité de cette fonction est O(1) car elle effectue une seule requête à la base de données pour récupérer
		 le rôle de l'utilisateur en utilisant le nom d'utilisateur comme critère de recherche. 
		*/
		$reqRole =$this->bd->prepare("SELECT Rôle FROM Login WHERE Username=:user");//recupere Username, à vérifier
		$reqRole ->bindValue(":user",$user);
		$reqRole ->execute();
		$role=$reqRole->fetchAll(PDO::FETCH_ASSOC);
		if ($role[0]["Rôle"]){//if true, true represente l'Etudiant
			$roleNom="Etudiant";//dans quel tab on va selon le rôle
			$roleID="Student_ID";//quel est l'id de la personne
		} else{
			$roleNom="Personnel";
			$roleID="Personnel_ID";
		}
        $data[]=$roleNom;
        $data[]=$roleID;
        return $data;
		
	}
	
	
	
	
	public function getNom($user) {
		/*
		Cette fonction renvoie le Nom de l'utilisateur. 
		Elle prend en paramètre le Username, le nom d'utilisateur,
			$user, et renvoie le Nom de l'utilisateur, en vérifiants
			son rôle d'avance.
		La complexité de cette fonction est O(1) car elle utilise d'abord la fonction roleTable qui est de complexité O(1) pour déterminer 
		le nom de la table à utiliser pour récupérer le nom de l'utilisateur.
		Elle effectue ensuite une seule requête à la base de données pour récupérer le nom de l'utilisateur en utilisant le nom d'utilisateur comme critère de recherche.
		*/
		$info=$this->roleTable($user);
		
		if ($info[0]=="Etudiant"){
			$reqNom=$this->bd->prepare("SELECT Nom FROM Login JOIN Etudiant ON User_ID=Student_ID WHERE Username=:user");//recupere Username, à écrire
		}
		elseif ($info[0]=="Personnel"){
			$reqNom=$this->bd->prepare("SELECT Nom FROM Login JOIN Personnel ON User_ID=Personnel_ID WHERE Username=:user");
		}
		
		$reqNom ->bindValue(":user",$user);
		$reqNom->execute();
		$nom=$reqNom->fetchAll(PDO::FETCH_ASSOC);
		
		return $nom[0]["Nom"];
	}
	
	
	
	public function getPrenom($user) {
		/*
		Cette fonction renvoie le Prenom de l'utilisateur.
		Elle prend en paramètre le Username, le nom d'utilisateur, $user, 
			et renvoie le Prenom de l'utilisateur, en vérifiants son rôle d'avance.
		La complexité de cette fonction est O(1) car elle utilise d'abord la fonction roleTable qui est de complexité O(1) 
		pour déterminer le nom de la table à utiliser pour récupérer le prénom de l'utilisateur. 
		Elle effectue ensuite une seule requête à la base de données pour récupérer le prénom de l'utilisateur en utilisant le nom d'utilisateur comme critère de recherche.

		*/ 
		$info=$this->roleTable($user);
		
		if ($info[0]=="Etudiant"){
			$reqPrenom=$this->bd->prepare("SELECT Prenom FROM Login JOIN Etudiant ON User_ID=Student_ID WHERE Username=:user");//recupere Username, à écrire
		}
		elseif ($info[0]=="Personnel"){
			$reqPrenom=$this->bd->prepare("SELECT Prenom FROM Login JOIN Personnel ON User_ID=Personnel_ID WHERE Username=:user");
		}
		
		$reqPrenom ->bindValue(":user",$user);
		$reqPrenom ->execute();
		$prenom=$reqPrenom->fetchAll(PDO::FETCH_ASSOC);
		
		return $prenom[0]["Prenom"];
	}
	
	
	
	public function getRole($user) {
		/*
		Cette fonction renvoie le Rôle de l'utilisateur. 
		Elle prend en paramètre le Username, le nom d'utilisateur, $user, 
			et renvoie le Nom de l'utilisateur, en vérifiants son rôle d'avance. 
			Soit Étudiant soit un Rôle de la table Personnel.
		La complexité de cette fonction est O(1) car elle utilise d'abord la fonction roleTable qui est de complexité O(1) 
		pour déterminer le nom de la table à utiliser pour récupérer le rôle de l'utilisateur. 
		*/
		$info=$this->roleTable($user);
		
		if ($info[0]=='Etudiant'){
			return 'Étudiant';
			
		}
		else{
			$reqRole=$this->bd->prepare("SELECT Personnel.Rôle FROM Login JOIN Personnel ON User_ID=Personnel_ID WHERE Username=:user");//recupere Username, à écrire
			$reqRole ->bindValue(":user",$user);
			$reqRole ->execute();
			$role=$reqRole->fetchAll(PDO::FETCH_ASSOC);
			
			return $role[0]["Rôle"];
		}
	}
	
	
	
	public function getMail($user) {
		/*
		Cette fonction renvoie le Mail de l'utilisateur. 
		Elle prend en paramètre le Username, le nom d'utilisateur, $user, 
			et renvoie le Mail de l'utilisateur, en vérifiants son rôle d'avance. 
		La complexité de cette fonction est O(1) car elle utilise d'abord la fonction roleTable qui est de complexité O(1) 
		pour déterminer le nom de la table à utiliser pour récupérer l'adresse mail de l'utilisateur. Elle effectue ensuite une seule requête à la base de données 
		pour récupérer l'adresse mail de l'utilisateur en utilisant le nom d'utilisateur comme critère de recherche.
		*/
		$info=$this->roleTable($user);
		
		if ($info[0]=="Etudiant"){
			$reqMail=$this->bd->prepare("SELECT Mail FROM Login JOIN Etudiant ON User_ID=Student_ID WHERE Username=:user");//recupere Username
		}
		elseif ($info[0]=="Personnel"){
			$reqMail=$this->bd->prepare("SELECT Mail FROM Login JOIN Personnel ON User_ID=Personnel_ID WHERE Username=:user");//recupere Username
		}
		
		$reqMail ->bindValue(":user",$user);
		$reqMail ->execute();
		$mail=$reqMail->fetchAll(PDO::FETCH_ASSOC);
		
		return $mail[0]["Mail"];
	}
	
	
	public function getDepartement($user) {
		/*
		Cette fonction renvoie le Département de l'utilisateur.
		Elle prend en paramètre le Username, le nom d'utilisateur, $user, 
			et renvoie le Département de l'utilisateur, en vérifiants son rôle d'avance.
		La complexité de cette fonction est O(2) car elle utilise d'abord la fonction roleTable qui est de complexité O(1) 
		pour déterminer le rôle de l'utilisateur et donc la table à utiliser pour récupérer le département de l'utilisateur. 
		Elle effectue ensuite deux requêtes à la base de données : une pour récupérer l'ID de la formation de l'utilisateur et l'autre pour récupérer le département 
		de cette formation en utilisant l'ID de la formation comme critère de recherche.
 */
		$info=$this->roleTable($user);
		
		if ($info[0]=="Etudiant"){
			$reqG_ID=$this->bd->prepare("SELECT Groupe_ID FROM Login JOIN Etudiant ON User_ID=Student_ID WHERE Username=:user");//recupere Username, à écrire
			
			$reqG_ID ->bindValue(":user",$user);
			$reqG_ID ->execute();
			$G_ID=$reqG_ID->fetchAll(PDO::FETCH_ASSOC);
			$reqF_ID=$this->bd->prepare("SELECT Formation_ID FROM Groupe WHERE Groupe_ID=:G_ID");
			$reqF_ID ->bindValue(":G_ID",$G_ID[0]['Groupe_ID']);
			$reqF_ID ->execute();
			
			
		}
		elseif ($info[0]=="Personnel"){
			$reqF_ID=$this->bd->prepare("SELECT Formation_ID FROM Login JOIN Personnel ON User_ID=Personnel_ID WHERE Username=:user");//recupere Username, à écrire
			$reqF_ID ->bindValue(":user",$user);
			$reqF_ID ->execute();
		}
		
		
		$F_ID=$reqF_ID->fetchAll(PDO::FETCH_ASSOC);
		
		$reqFormation=$this->bd->prepare("SELECT Département FROM Formation WHERE Formation_ID=:F_ID");
		$reqFormation ->bindValue(":F_ID",$F_ID[0]["Formation_ID"]);
		$reqFormation ->execute();
		$Formation=$reqFormation->fetchAll(PDO::FETCH_ASSOC);
		
		return $Formation[0]["Département"];
	}

	
	
	public function getFormation($user) {
		/*
		Cette fonction renvoie la Composante de l'utilisateur.
		Elle prend en paramètre le Username, le nom d'utilisateur, $user, 
			et renvoie la Composante de l'utilisateur, en vérifiants son rôle d'avance.
		La complexité de cette fonction est de O(1) pour la fonction roleTable() et de O(n) pour les requêtes SQL qui sont effectuées ensuite. 
		Cela signifie qu'elle est linéaire par rapport à la taille des données dans la base de données. 
 */
		$info=$this->roleTable($user);
		
		if ($info[0]=="Etudiant"){
			$reqG_ID=$this->bd->prepare("SELECT Groupe_ID FROM Login JOIN Etudiant ON User_ID=Student_ID WHERE Username=:user");//recupere Username, à écrire
			
			$reqG_ID ->bindValue(":user",$user);
			$reqG_ID ->execute();
			$G_ID=$reqG_ID->fetchAll(PDO::FETCH_ASSOC);
			$reqF_ID=$this->bd->prepare("SELECT Formation_ID FROM Groupe WHERE Groupe_ID=:G_ID");
			$reqF_ID ->bindValue(":G_ID",$G_ID[0]['Groupe_ID']);
			$reqF_ID ->execute();
			
			
		}
		elseif ($info[0]=="Personnel"){
			$reqF_ID=$this->bd->prepare("SELECT Formation_ID FROM Login JOIN Personnel ON User_ID=Personnel_ID WHERE Username=:user");//recupere Username, à écrire
			$reqF_ID ->bindValue(":user",$user);
			$reqF_ID ->execute();
		}
		
		
		$F_ID=$reqF_ID->fetchAll(PDO::FETCH_ASSOC);
		
		$reqFormation=$this->bd->prepare("SELECT Composante FROM Formation WHERE Formation_ID=:F_ID");
		$reqFormation ->bindValue(":F_ID",$F_ID[0]["Formation_ID"]);
		$reqFormation ->execute();
		$Formation=$reqFormation->fetchAll(PDO::FETCH_ASSOC);
		
		return $Formation[0]["Composante"];
	}




	public function formationValide($dep,$comp){
		/*
		Cette fonction vérifie si une formation donner existe.
		Elle prend en paramètre le Département, $dep, et la Composante, $comp,
			et vérifie la validité de la Formation avec la base de données.
		Renvoie true si existe, false sinon.
		La complexité de cette fonction est O(1) car elle effectue une seule requête SQL qui compte le nombre de lignes dans la table "Formation" qui correspondent 
		aux valeurs spécifiées pour les colonnes "Département" et "Composante", puis retourne un résultat booléen indiquant si le nombre de lignes correspondantes est égal à 1
 */
		$reqFormationV=$this->bd->prepare("SELECT COUNT(Formation_ID) AS nb FROM Formation WHERE Département=:dep AND Composante=:comp");
		$reqFormationV ->bindValue(":dep",$dep);
		$reqFormationV ->bindValue(":comp",$comp);
		$reqFormationV ->execute();
		$FormationV=$reqFormationV->fetchAll(PDO::FETCH_ASSOC);
		return $FormationV[0]['nb']==1;
	}


	public function groupeValide($groupe,$dep,$comp){
		/*
		Cette fonction vérifie si une formation donner existe.
		Elle prend en paramètre le Département, $dep,
			la Composante, $comp,
			et le Groupe, $groupe,
			et vérifie la validité de la Formation, avec son groupe, avec la base de données.
		Renvoie true si existe, false sinon. 
		La complexité de cette fonction est linéaire, car elle effectue des opérations de base (préparer et exécuter une requête, 
		lier des valeurs, compter les résultats) qui sont toutes en O(n), où n est le nombre de lignes retournées par la requête SQL. 
		La fonction appelle également une autre fonction "formationValide" qui est également en complexité linéaire
		*/
		if($this->formationValide($dep,$comp)){
			$reqGroupeV=$this->bd->prepare("SELECT COUNT(Groupe_ID) AS nb FROM Groupe JOIN Formation ON Formation_ID WHERE Nom=:groupe AND Département=:dep AND Composante=:comp");
			$reqGroupeV ->bindValue(":groupe",$groupe);
			$reqGroupeV ->bindValue(":dep",$dep);
			$reqGroupeV ->bindValue(":comp",$comp);
			$reqGroupeV ->execute();
			$GroupeV=$reqGroupeV->fetchAll(PDO::FETCH_ASSOC);
			return $GroupeV[0]['nb']==1;
		}
	}

	public function takeDepartements(){
		/* 
		Cette fonction renvoie un tableau contenant les Départements existants.
		Elle prend aucun paramètres.
		Cette fonction est utilisé pour la création de Composantes, de Groupes, et l'inscription.
		La complexité de cette fonction est de O(n) où n est le nombre de départements différents dans la table Formation. 
		La requête SQL est en O(m) où m est le nombre de lignes de la table Formation et la boucle foreach est en O(n). 
		*/ 
		$reqDep=$this->bd->prepare("SELECT DISTINCT Département FROM Formation");
		$reqDep ->execute();
		$Dep=$reqDep->fetchAll(PDO::FETCH_ASSOC);
		$Departements=[];
		foreach ($Dep as $dep){
			$Departements[]=$dep['Département'];
		}
		return $Departements;
		
	}
	
	
	public function takeComposantes($departement){
		/* 
		Cette fonction renvoie un tableau contenant les Composantes existantes. 
		Elle prend en paramètre le Département, $département et renvoie un tableau de Composantes.
		On avait pas expliquer a notre groupe ce qu'étais une Composante,
			ou un Département donc on a chercher 
			et penser que une Composante etait une composante du département 
			tel que le BUT INFO était pour nous une composante du Département Informatique.
		Cette fonction est utilisé pour la création de Groupes, et l'inscription.
		La complexité de ces deux fonctions est en O(n), où n est le nombre de départements ou de composantes dans la table de formation. Cela est dû au fait 
		que les deux fonctions utilisent une boucle pour parcourir tous les enregistrements 
		de la table de formation et stocker les valeurs distinctes de Département ou Composante dans un tableau.
		*/ 
		$reqComp=$this->bd->prepare("SELECT DISTINCT Composante FROM Formation WHERE Département=:dep");
		$reqComp ->bindValue(":dep",$departement);
		$reqComp ->execute();
		$Comp=$reqComp->fetchAll(PDO::FETCH_ASSOC);
		foreach ($Comp as $dep){
			$Composantes[]=$dep['Composante'];
		}
		return $Composantes;
	}
	
	
	public function takeGroupes($departement,$composante){
		/*
		Cette fonction renvoie un tableau contenant les Groupes existants. 
		Elle prend en paramètre le Département, $département,
			et la Composante, $composante
			et renvoie un tableau de Groupes.
		Cette fonction est utilisé pour l'inscription.
		La complexité de cette fonction est également de O(n), où n est le nombre de groupes correspondant aux critères de département
		et de composante donnés dans la requête SQL. 
		*/
		$reqGroup=$this->bd->prepare("SELECT DISTINCT Nom FROM Groupe JOIN Formation ON Groupe.Formation_ID=Formation.Formation_ID WHERE Département=:dep AND Composante=:comp");
		$reqGroup ->bindValue(":dep",$departement);
		$reqGroup ->bindValue(":comp",$composante);
		$reqGroup ->execute();
		$Group=$reqGroup->fetchAll(PDO::FETCH_ASSOC);
		$groupes=[];
		foreach ($Group as $group){
			$groupes[]=$group['Nom'];
		}
		return $groupes;
		
	}
	
	public function takePromos($departement,$composante,$groupe){
		/*
		Cette fonction renvoie un tableau contenant les Promos (ex de promo:2023-2024) existantes. 
		Elle prend en paramètre le Département, $département,
			la Composante, $composante,
			et le Groupes, $groupes et renvoie un tableau de Promos. 
		Cette fonction est utilisé pour l'inscription. 
		La complexité de cette fonction est également de O(n), où n est le nombre de promotions correspondant aux critères de département, 
		de composante et de groupe donnés dans la requête SQL. 
		*/
		$reqPromos=$this->bd->prepare("SELECT Promotion FROM Groupe JOIN Formation ON Groupe.Formation_ID=Formation.Formation_ID WHERE Département=:dep AND Composante=:comp AND Nom=:groupe");
		$reqPromos ->bindValue(":dep",$departement);
		$reqPromos ->bindValue(":comp",$composante);
		$reqPromos ->bindValue(":groupe",$groupe);
		$reqPromos ->execute();
		$Promo=$reqPromos->fetchAll(PDO::FETCH_ASSOC);
		$promos=[];
		foreach ($Promo as $promo){
			$promos[]=$promo['Promotion'];
		}
		return $promos;
		
	}
	
	
	
	public function takeCommentaires($docID){
		/*
		Cette fonction renvoie un tableau contenant les Commentaire existants. 
		Elle prend en paramètre l'ID du Documents et renvoie 
			un tableau de Commentaires en décroissant, donc du plus récent au plus loingtain.
		Cette fonction est utilisé pour la page de l'enseignant, afin d'afficher les commentaires envoyés.
		La complexité de cette fonction est de O(n) * O(m), où n est le nombre de commentaires 
		correspondant à l'ID du document donné dans la requête SQL, et où m est la complexité de la fonction getUser().
		 */
		$reqComs=$this->bd->prepare("SELECT Commentaire_ID,Personnel_ID,Commentaire FROM Commentaire WHERE Document_ID=:docID ORDER BY Commentaire_ID DESC");
		$reqComs ->bindValue(":docID",$docID);
		$reqComs ->execute();
		$Coms=$reqComs->fetchAll(PDO::FETCH_ASSOC);
		$commentaires=[];
		foreach ($Coms as $com){
			$user=$this->getUser($com['Personnel_ID'],'Autre');
			$personne=$this->getPrenom($user)." ".$this->getNom($user);
			$commentaires[]=["personne"=>$personne,"commentaire"=>$com['Commentaire'],'user'=>$user,"comID"=>$com['Commentaire_ID']];
		}
		return $commentaires;
		
	}
	
	
	
	
	public function userExist($user){
		/*
		Cette fonction vérifie si un utilisateur envoyé en paramètre existe, et renvoie un tableau contenant les informations nécéssaire 
			a la connexion, et donc à la session. 
			Si il n'existe pas, la fonction renvoie false. 
		Elle prend en paramètre un nom d'utilisateur, $user.
		La complexité de cette fonction est de O(1) pour la requête SQL qui vérifie si l'utilisateur existe, suivie de O(m) pour la requête SQL 
		pour récupérer les informations de l'utilisateur si il existe, où m est le nombre d'informations récupérées pour l'utilisateur.
		
		*/ 
		$req =$this->bd->prepare("SELECT COUNT(Username) AS nb FROM Login WHERE Username=:user");
		$req->bindValue(":user",$user);
		$req ->execute();
		$t=$req->fetchAll(PDO::FETCH_ASSOC);
		if ($t[0]["nb"]==1){
			$data=[];
			$nomPersonne=$this->getNom($user);
			$prenomPersonne=$this->getPrenom($user);
			
			$data["nomPersonne"]=$nomPersonne;
			$data["prenomPersonne"]=$prenomPersonne;
			$data["personne"]=np($nomPersonne,$prenomPersonne);
			$data["role"]=$this->getRole($user);
			$data["n"]=$user;//n pour le prenom et nom
			$data["mail"]=$this->getMail($user);
			$data["Formation"]=$this->getFormation($user);
			
			return $data;
		}
		return false;
	}
	
	
	public function personneExist($data){
		/*
		Cette fonction vérifie si un utilisateur envoyé dans le tableau en paramètre existe, 
			et renvoie true si il existe, si les informations de la session sont bonnes
			(le tableau en paramètre contien les informations de la session).
		Elle prend en paramètre un tableau contenant les informations d'une session existante.
		La complexité de cette fonction est de O(1) pour la requête SQL qui vérifie si la personne existe.
		*/ 
		$role=$data['role'];
		
		if ($role=='e'){
			$req =$this->bd->prepare("SELECT COUNT(Nom) AS nb FROM Etudiant WHERE Nom=:nom AND Prenom=:prenom AND Mail=:mail");
			
		}
		
		else {
			$req =$this->bd->prepare("SELECT COUNT(Nom) AS nb FROM Personnel WHERE Nom=:nom AND Prenom=:prenom AND Mail=:mail AND Rôle=:role");
			$req->bindValue(":role",$role);
		
		}
		
		$req->bindValue(":nom",$data['role']);
		$req->bindValue(":prenom",$data['role']);
		$req->bindValue(":mail",$data['role']);
		$req ->execute();
		$t=$req->fetchAll(PDO::FETCH_ASSOC);
		
		return $t[0]['nb']==1;
		
	}
	
	
	public function ajoutComp($departement,$composante){
		/*
		Cette fonction insert dans la base de données une Formation.
		Elle prend en paramètre un Département, $departement,et une Composante, $composante.
		Cette fonction est utilisée dans l'inscription.
		La complexité de cette fonction est de O(1) pour l'insertion de la composante dans la table Formation
		*/
		$reqAjComp=$this->bd->prepare("INSERT INTO Formation(Département,Composante) value(:dep,:comp)");
		$reqAjComp ->bindValue(":dep",$departement);
		$reqAjComp ->bindValue(":comp",$composante);
		$reqAjComp -> execute();
	}
	
	
	
	public function ajoutGroupe($departement,$composante,$infos){
		/* 
		Cette fonction insert dans la base de données un Groupe.Elle prend en paramètre un Département, $departement,une Composante, $composante
			et un tableau contenant les informations du Groupe, $info.
			Cette fonction est utilisée dans l'inscription.
		La complexité de cette fonction est de O(1) pour la première requête SQL qui récupère l'ID de la formation
		 correspondant aux critères de département et de composante donnés, suivie de O(1) pour la seconde requête SQL qui ajoute le groupe à la table Groupe en utilisant 
		l'ID de la formation récupéré ainsi que les informations de promotion, de nom de groupe et de niveau données. 
		
		*/ 
		$reqIDFormation=$this->bd->prepare("SELECT Formation_ID FROM Formation WHERE Département=:dep AND Composante=:comp");
		$reqIDFormation->bindValue(':dep',$departement);
		$reqIDFormation->bindValue(':comp',$composante);
		$reqIDFormation ->execute();
		$F_ID=$reqIDFormation->fetchAll(PDO::FETCH_ASSOC);//reccupère l'ID de la formation
		
		$reqAjGroup=$this->bd->prepare("INSERT INTO Groupe(Formation_ID,Promotion,Nom,Niveau) value(:F_ID,:promo,:nom,:niveau)");
		$reqAjGroup ->bindValue(":F_ID",$F_ID[0]['Formation_ID']);
		$reqAjGroup ->bindValue(":promo",$infos['promo']);
		$reqAjGroup ->bindValue(":nom",$infos['groupe']);
		$reqAjGroup ->bindValue(":niveau",$infos['niveau']);
		$reqAjGroup -> execute();
	}
	
	
	public function ajoutCommentaire($docID,$user,$commentaire){
		/*
		Cette fonction insert dans la base de données un Commentaire.
		Elle prend en paramètre l'ID du Document ou est mis le Commentaire, $docID,
			le nom d'utilisateur de la personne qui l'envoie, $user,
			et le commentaire qu'il a écrit.
		Cette fonction est utilisée dans la fonctionnalité commentaire, pour l'envoie de commentaire.
		La complexité de cette fonction est de O(1) pour l'insertion d'un commentaire dans la table Commentaire, cela est dû au fait que la fonction effectue une seule requête 
		d'insertion en utilisant les valeurs de l'ID de l'utilisateur, de l'ID du document et du contenu du commentaire pour ajouter une nouvelle entrée à la table.
		La fonction utilise également la fonction getID() qui a une complexité O(1) pour récupérer l'ID de l'utilisateur.

	*/ 
		$id=$this->getID($user);
		$reqAjCom=$this->bd->prepare("INSERT INTO Commentaire(Personnel_ID,Document_ID,Commentaire,Visibility_flag,Vue_flag) value(:id,:docID,:com,true,false)");
		$reqAjCom ->bindValue(":id",$id);
		$reqAjCom ->bindValue(":docID",$docID);
		$reqAjCom ->bindValue(":com",$commentaire);
		$reqAjCom -> execute();
		
		
		
	}
	
	
	public function userCreater($data){
		/*	
		Cette fonction créer un utilisateur.Elle prend en paramètre un tableau contenant toutes les informations 
			nécessaires a la création d'un utilisateur.
			Qu'il soit étudiant ou autre.
		Cette fonction est utilisée dans l'inscription.
		
		*/
		$reqIDFormation=$this->bd->prepare("SELECT Formation_ID FROM Formation WHERE Département=:dep AND Composante=:comp");
		$reqIDFormation->bindValue(':dep',$data['departement']);
		$reqIDFormation->bindValue(':comp',$data['composante']);
		$reqIDFormation ->execute();
		$F_ID=$reqIDFormation->fetchAll(PDO::FETCH_ASSOC);//reccupère l'ID de la formation
		
		
		if ($data['role']=='e'){
			$reqIDGroupe=$this->bd->prepare("SELECT Groupe_ID FROM Groupe WHERE Nom=:groupe AND Formation_ID=:formation AND Promotion=:promo");
			$reqIDGroupe->bindValue(':groupe',$data['groupe']);
			$reqIDGroupe->bindValue(':formation',$F_ID[0]['Formation_ID']);
			$reqIDGroupe->bindValue(':promo',$data['promo']);
			$reqIDGroupe->execute();
			$G_ID=$reqIDGroupe->fetchAll(PDO::FETCH_ASSOC);//reccupère l'ID du groupe
			
			
			$reqCreateP=$this->bd->prepare("INSERT INTO Etudiant(Nom,Prenom,Mail,Stage_detention,Visibility_flag,Groupe,Groupe_ID) value(:nom,:prenom,:mail,false,false,:groupe,:groupeID)");
			$reqCreateP->bindValue(':nom',$data['nom']);
			$reqCreateP->bindValue(':prenom',$data['prenom']);
			$reqCreateP->bindValue(':mail',$data['mail']);
			$reqCreateP->bindValue(':groupe',$data['groupe']);
			$reqCreateP->bindValue(':groupeID',$G_ID[0]['Groupe_ID']);
			$reqCreateP ->execute();//Creer la personne dans la table Etudiant
			
			$reqUserID=$this->bd->prepare("SELECT Student_ID FROM Etudiant WHERE Nom=:nom AND Prenom=:prenom AND Mail=:mail AND Groupe=:groupe AND Groupe_ID=:groupeID");
			$reqUserID->bindValue(':nom',$data['nom']);
			$reqUserID->bindValue(':prenom',$data['prenom']);
			$reqUserID->bindValue(':mail',$data['mail']);
			$reqUserID->bindValue(':groupe',$data['groupe']);
			$reqUserID->bindValue(':groupeID',$G_ID[0]['Groupe_ID']);
			$reqUserID -> execute();
			$S_ID= $reqUserID->fetchAll(PDO::FETCH_ASSOC);//reccupère l'ID de l'Etudiant
			$s_ID=$S_ID[0]['Student_ID'];
			
			$reqCreateL=$this->bd->prepare("INSERT INTO Login(Username,Password,User_ID,Rôle) value(:user,:mdp,:uid,true)");
			$reqCreateL->bindValue(':user',$data['user']);
			$reqCreateL->bindValue(':mdp',password_hash($data['mdp'], PASSWORD_DEFAULT));
			$reqCreateL->bindValue(':uid',$s_ID);
			$reqCreateL ->execute();//Creer l'utilisateur
		}
		
		elseif ($data['role']=='Enseignant Tuteur' ||  $data['role']=='Enseignant Validateur' || $data['role']=='Membre du Secrétariat' || $data['role']=='Coordinatrice de stage') {
			$reqCreateP=$this->bd->prepare("INSERT INTO Personnel(Nom,Prenom,Mail,Visibility_flag,Rôle,Formation_ID) value(:nom,:prenom,:mail,false,:role,:formationID)");
			$reqCreateP->bindValue(':nom',$data['nom']);
			$reqCreateP->bindValue(':prenom',$data['prenom']);
			$reqCreateP->bindValue(':mail',$data['mail']);
			$reqCreateP->bindValue(':role',$data['role']);
			$reqCreateP->bindValue(':formationID',$F_ID[0]['Formation_ID']);
			$reqCreateP ->execute();//Creer la personne dans la table Personnel
			
			$reqUserID=$this->bd->prepare("SELECT Personnel_ID FROM Personnel WHERE Nom=:nom AND Prenom=:prenom AND Mail=:mail AND Rôle=:role AND Formation_ID=:formationID");
			$reqUserID->bindValue(':nom',$data['nom']);
			$reqUserID->bindValue(':prenom',$data['prenom']);
			$reqUserID->bindValue(':mail',$data['mail']);
			$reqUserID->bindValue(':role',$data['role']);
			$reqUserID->bindValue(':formationID',$F_ID[0]['Formation_ID']);
			$reqUserID -> execute();
			$S_ID= $reqUserID->fetchAll(PDO::FETCH_ASSOC);//reccupère l'ID du personnel
			$s_ID=$S_ID[0]['Personnel_ID'];
			
			
			$reqCreateL=$this->bd->prepare("INSERT INTO Login(Username,Password,User_ID,Rôle) value(:user,:mdp,:uid,false)");
			$reqCreateL->bindValue(':user',$data['user']);
			$reqCreateL->bindValue(':mdp',password_hash($data['mdp'], PASSWORD_DEFAULT));
			$reqCreateL->bindValue(':uid',$s_ID);
			$reqCreateL ->execute();//Creer l'utilisateur
		}
		
		
		
		
	}

    public function getAnneesPromo(){
        $requete = $this->bd->prepare('SELECT DISTINCT SUBSTRING(groupe.Promotion, 6,4) as "Année de stage" FROM groupe;');
        $requete-> execute();
        $reponse = [];
        while ($ligne = $requete->fetch(PDO::FETCH_NUM)) {
            $reponse[] = $ligne[0];
        }
        return $reponse;
    }
}
	
