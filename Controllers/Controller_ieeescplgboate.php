<?php


class Controller_ieeescplgboate extends Controller
{
    

    public function action_default()
    {
		
        $this->action_page_ajout();
    }

	public function action_page_ajout()
    {
		/*
		Cette fonction amène a une page spécial proposant de créer des Département/Composante,
			des Groupes, des Utilisateur, ou de faire une auto incrémentation des tables.
		La complexité de cette fonction est constante O(1) car elle ne contient aucune boucle, 
		elle n'appel que la fonction render() dont la complexité ne dépend pas de la taille d'éléments en entrée.
		*/
		
        $data = [
            "title" => "Inscription",
        ];
        $this->render("ajout", $data);
    }
	
	public function action_page_comp()
    {
		/*
		Cette fonction réccupère tous les Départements existant et les envoie sur 
			la page d'ajout de Département/Composante.
		La complexité de cette fonction est également constante O(1) car elle effectue un nombre constant d'opérations indépendantes de la taille des entrées. 	
		*/
        $m = Model::getModel();
		$departements=$m->takeDepartements();
        $data = [
            "title" => "Inscription",
			'departements'=>$departements
        ];
        $this->render("create_composante", $data);
    }
	
	public function action_page_groupe1()
    {
		/*
		Cette fonction réccupère tous les Départements existant et les envoie sur 
			la première page d'ajout de Groupes.
		La complexité de cette fonction est également constante O(1) car elle effectue un nombre constant d'opérations indépendantes de la taille des entrées.
			
		*/
        $m = Model::getModel();
		$departements=$m->takeDepartements();
        $data = [
            "title" => "Inscription",
			'departements'=>$departements
        ];
        $this->render("create_groupe1", $data);
    }
	
	public function action_page_groupe2()
    {
		/*
		Cette fonction réccupère le département sélectionner en paramètre sur la première page
			et reccupère avec les Composantes qui lui sont associer,
			et les envoies sur la deuxième page d'ajout de Groupes.
		La complexité de cette fonction est également constante O(1) car elle effectue un nombre constant d'opérations.
		Si les données sont postées, elle effectue un nombre constant d'opérations indépendantes de la taille des entrées. Elle appelle une fonction (getModel) qui ne dépend pas de la taille des entrées.
		*/
		if(isset($_POST['submit'])){
			$m = Model::getModel();
			$composantes=$m->takeComposantes($_POST['departement']);
			$data = [
				"title" => "Inscription",
				'departement'=>$_POST['departement'],
				'composantes'=>$composantes
			];
			$this->render("create_groupe2", $data);
		}
        $data = [
            "title" => "PA"
        ];
        $this->render("accueil", $data);
    }
	
	
	public function action_ajout_composante()
    {
		/*
		Cette fonction réccupère les informations sélectionner en paramètre sur la page des Département/Composante
			et ajoute les information dans la base de données, biensur il faut qu'elles soient valide.
		La complexité de cette fonction est constante O(1).L'appel de la fonction render() ne modifie rien car elle est elle meme est de complexité constante.
		*/
		if(isset($_POST['submit'])){
			
			if (isset($_POST['departement'])&&isset($_POST['composante'])){
				$departement=$_POST['departement'];
				if ($departement=='autre' && $_POST['autre']!=''){
					$departement=$_POST['autre'];
				}
				if($departement!=''){
					$m = Model::getModel();
					
					$m->ajoutComp($departement,$_POST['composante']);
					$this->action_page_comp();
					
				}
			}
		}
		$data = [
			"title" => "PA"
		];
		$this->render("accueil", $data);
    }
	
	
	public function action_ajout_groupe()
    {
		/*
		Cette fonction réccupère les informations sélectionner en paramètre sur la page des Groupes
			et ajoute les information dans la base de données, biensur il faut qu'elles soient valide.
		La complexité de cette fonction est également constante O(1).
		*/
		if(isset($_POST['submit'])){
			
			if (isset($_POST['departement'])&&isset($_POST['composante'])&&isset($_POST["groupe"])){
				if ($_POST["groupe"]!=''){
					$infos=[
						"groupe"=>$_POST["groupe"],
						"niveau"=>$_POST["niveau"],
						"promo"=>$_POST["promo"],
						
					];
					$m = Model::getModel();
					$m->ajoutGroupe($_POST['departement'],$_POST['composante'],$infos);
					$this->action_page_groupe1();
				
				}
			}
		}
		$data = [
			"title" => "PA"
		];
		$this->render("accueil", $data);
    }
	

    public function action_inscription_page1()
    {
		/*
		Cette fonction réccupère tous les Départements existant et les envoie sur 
			la première page d'ajout d'Utilisateur.
		La complexité de cette fonction est constante (O(1)) car elle effectue un nombre constant d'opérations indépendantes de la taille des entrées. 
		Elle appelle une fonction (getModel) qui ne dépend pas de la taille des entrées.
		*/
		$m = Model::getModel();
		$departements=$m->takeDepartements();
        $data = [
            "title" => "Inscription Etudiant",
			'departements'=>$departements
        ];
        $this->render("inscription_page1", $data);
    }
	
	
	
	public function action_inscription_page2()
    {
		/*
		Cette fonction réccupère le département sélectionner en paramètre sur la première page
			et reccupère avec les Composantes qui lui sont associer, 
			et les envoies sur la deuxième page d'ajout d'Utilisateur.
		
		*/
		if(isset($_POST['submit'])){
			if (isset($_POST['nom'])&&isset($_POST['prenom'])&&isset($_POST['mail'])&&isset($_POST['role'])&&isset($_POST['departement'])){
				if (preg_match('/^.+@[a-z]+\.[a-z]+$/',$_POST['mail'])){
					$m = Model::getModel();
					$composantes=$m->takeComposantes($_POST['departement']);
					$data=[
						"nom"=>e($_POST['nom']),
						"prenom"=>e($_POST['prenom']),
						"mail"=>$_POST['mail'],
						"role"=>$_POST['role'],
						'departement'=>$_POST['departement'],
						'composantes'=>$composantes
					];
					$this->render("inscription_page2", $data);
				}
			}
		}
        $data = [
            "title" => "PA",
        ];
        $this->render("accueil", $data);
    }

	public function action_inscription_page2_1()
    {
		/*
		Cette fonction réccupère le département et la composante sélectionner en paramètre sur la deuxième page
			et reccupère avec les Groupes qui lui sont associer, et d'autres informations,
			et les envoies sur cette page d'ajout d'Utilisateur.
		Cette page n'est visible que si on créer un étudiant.
		Cette fonction possède également une complexité constante car aucune boucle n'est effectuée.
		*/
		if(isset($_POST['submit'])){
			if (isset($_POST['nom'])&&isset($_POST['prenom'])&&isset($_POST['mail'])&&isset($_POST['role'])&&isset($_POST['departement'])&&isset($_POST['composante'])){
				
				$m = Model::getModel();
				$groupes=$m->takeGroupes($_POST['departement'],$_POST['composante']);
				$data=[
					"nom"=>e($_POST['nom']),
					"prenom"=>e($_POST['prenom']),
					"mail"=>$_POST['mail'],
					"role"=>$_POST['role'],
					'departement'=>$_POST['departement'],
					'composante'=>$_POST['composante'],
					'groupes'=>$groupes
				];
				$this->render("inscription_page2_1", $data);
			
			}
		}
        $data = [
            "title" => "PA",
        ];
        $this->render("accueil", $data);}



	public function action_inscription_page3()
    {
		/*
		Cette fonction réccupère le département, la composante et le groupe, si étudiant, sélectionner en paramètre sur la dernière page
			et reccupère avec les Promos qui lui sont associer, et d'autres informations,
			et les envoies sur cette page d'ajout d'Utilisateur.
		La complexité de cette fonction est également constante O(1) dans la mesure où le nombre d'éléments a vérifier n'influent pas spécifiquement le temps d'execution ou l'espace mémoire.
		
		*/
		if (isset($_POST['submit'])){
			if (isset($_POST['nom'])&&isset($_POST['prenom'])&&isset($_POST['mail'])&&isset($_POST['role'])&&isset($_POST['departement'])&&isset($_POST['composante'])){
			
				$data['nom']=$_POST['nom'];
				$data['prenom']=$_POST['prenom'];
				$data['mail']=$_POST['mail'];
				$data['role']=$_POST['role'];
				$m = Model::getModel();
				$ex=$m->personneExist($data);
				if (!$ex){
					$data['departement']=$_POST['departement'];
					$data['composante']=$_POST['composante'];
					if ($data['role']=='e'){
						$data["groupe"]=$_POST["groupe"];
						$data['promos']=$m->takePromos($_POST['departement'],$_POST['composante'],$_POST["groupe"]);
					}
					$d=[
						'data'=>$data
                    ];
					
					$this->render("inscription_page3", $d);
				}
				
			}
		}
		
        $dat = [
            "title" => "PA",
        ];
        $this->render("accueil", $dat);
    }
	
	
	
	public function action_inscription()
    {
		/*
		Cette fonction réccupère toutes les information sélectionner en paramètre sur la dernière page
			et beaucoups d'autres informations des pages précédentes,
			et créer un Utilisateur avec, il créer aussi ses dossiers, si étudiant.
		Elle renvoie sur la page Ajout. Donc a la première action.
		La complexité de cette fonction est O(n) c'est à dire linéaire car au vu des vérification et des dossiers à créer, n est sucesptible de grandir en focntion du nombre de donnée qui s'ajoute.
		
		*/
		if (isset($_POST['submit'])){
			if (isset($_POST['nom'])&&isset($_POST['prenom'])&&isset($_POST['mail'])&&isset($_POST['role'])&&isset($_POST['departement'])&&isset($_POST['composante'])&&isset($_POST['user'])&&isset($_POST['mdp'])){
			
				$m = Model::getModel();
				$userE=$m->userExist($_POST['user']);//existe ou pas
				
				if ($userE==false){//si il existe pas
						$data=[
							"nom"=>$_POST['nom'],
							"prenom"=>$_POST['prenom'],
							"mail"=>$_POST['mail'],
							"role"=>$_POST['role'],
							"departement"=>$_POST['departement'],
							"composante"=>$_POST['composante'],
							"user"=>$_POST['user'],
							"mdp"=>$_POST['mdp']
							];
							if ($data['role']=='e'){	/*créer une vérif si le groupe est valide*/
								$data["groupe"]=$_POST["groupe"];
								$data["promo"]=$_POST["promo"];
								$chemin= "Document_Stage/".$data['user']."/";  //ETUDIANT ID A REMPLACER PAR $_SESSION[Student_ID]
								dirname($chemin);
								$f=mkdir($chemin,0700,true);
								dirname($chemin.'Bordereau_d-offre_de_stage/');
								$f=mkdir($chemin.'Bordereau_d-offre_de_stage/',0700,true);
								dirname($chemin.'CV/');
								$f=mkdir($chemin.'CV/',0700,true);
								dirname($chemin.'Lettre_de_Motivation/');
								$f=mkdir($chemin.'Lettre_de_Motivation/',0700,true);
								dirname($chemin.'Journal_de_Bord/');
								$f=mkdir($chemin.'Journal_de_Bord/',0700,true);
								dirname($chemin.'Mini_Rapport_de_Stage/');
								$f=mkdir($chemin.'Mini_Rapport_de_Stage/',0700,true);
								dirname($chemin.'Rapport_final/');
								$f=mkdir($chemin.'Rapport_final/',0700,true);
							}
							
							$m->userCreater($data);
							
							$this->action_inscription_page1();
						}
					}
					
				}
				
	
			$d=[
				'data'=>'data'
            ];
			$this->render("accueil", $d);
	}
	
	public function action_auto_inscription(){
		/*
		Cette fonction contient un tableau de Département/Composante, un autre de Groupes associer au tableau d'avant,
			et enfin un tableau contenant  32 étudiants et 4 enseignant, et les ajoutes tous dans la base de données,
			cette fonction est une fonction nous permettant de faire des tests.
		*/
		$departComp=[
			["departement"=>'Informatique',"composante"=>'B.U.T. Informatique'],
			["departement"=>'Informatique',"composante"=>'B.U.T. Passerelle'],
			["departement"=>'Informatique',"composante"=>'B.U.T. STID'],
			["departement"=>'Informatique',"composante"=>'B.U.T. GEII'],
			["departement"=>'Informatique',"composante"=>'Licence Professionnelle MICDTL'],
			["departement"=>'Informatique',"composante"=>'B.U.T. Réseaux & Télécommunications'],
			["departement"=>'Électronique',"composante"=>'Licence Professionnelle MECSE'],
			["departement"=>'Électronique',"composante"=>'Licence Professionnelle EON'],
			["departement"=>'Réseaux/Télécoms',"composante"=>'B.U.T. Réseaux & Télécommunications'],
			["departement"=>'Réseaux/Télécoms',"composante"=>'B.U.T. GEII'],
			["departement"=>'Réseaux/Télécoms',"composante"=>'B.U.T. Informatique'],
			["departement"=>'Ressources Humaines',"composante"=>'B.U.T. GEA'],
			["departement"=>'Droit/Juridique',"composante"=>'B.U.T. Carrières Juridiques'],
			["departement"=>'Droit/Juridique',"composante"=>'Licence Professionnelle Métiers du Notariat'],
			["departement"=>'Assurance/Banque',"composante"=>'B.U.T. Carrières Juridiques'],
			["departement"=>'Assurance/Banque',"composante"=>'B.U.T. GEA'],
			["departement"=>'Assurance/Banque',"composante"=>'Licence Professionnelle ABF'],
			["departement"=>'Gestion des Entreprises',"composante"=>'Licence Professionnelle CP']
		];
		
		$groupes=[
			["departement"=>'Informatique',"composante"=>'B.U.T. Informatique',"groupe"=>'Athos',"niveau"=>2,"promo"=>'2022-2023'],
			["departement"=>'Informatique',"composante"=>'B.U.T. Informatique',"groupe"=>'Aramis',"niveau"=>2,"promo"=>'2022-2023'],
			["departement"=>'Informatique',"composante"=>'B.U.T. Informatique',"groupe"=>'Porthos',"niveau"=>2,"promo"=>'2022-2023'],
			["departement"=>'Informatique',"composante"=>'B.U.T. Informatique',"groupe"=>'Lovelace',"niveau"=>3,"promo"=>'2023-2024'],
			["departement"=>'Informatique',"composante"=>'B.U.T. Informatique',"groupe"=>'Hopper',"niveau"=>3,"promo"=>'2023-2024'],
			["departement"=>'Informatique',"composante"=>'B.U.T. Informatique',"groupe"=>'Lepaute',"niveau"=>3,"promo"=>'2023-2024'],
			
			["departement"=>'Informatique',"composante"=>'B.U.T. Passerelle',"groupe"=>'Passerelle',"niveau"=>2,"promo"=>'2022-2023'],
			["departement"=>'Informatique',"composante"=>'B.U.T. Passerelle',"groupe"=>'Passerelle',"niveau"=>2,"promo"=>'2023-2024'],
			
			["departement"=>'Informatique',"composante"=>'B.U.T. STID',"groupe"=>'Staatskunde',"niveau"=>2,"promo"=>'2022-2023'],
			
			["departement"=>'Informatique',"composante"=>'B.U.T. GEII',"groupe"=>'Lavoisier',"niveau"=>2,"promo"=>'2022-2023'],
			
			["departement"=>'Informatique',"composante"=>'Licence Professionnelle MICDTL',"groupe"=>'Hammourabi',"niveau"=>2,"promo"=>'2022-2023'],
			
			["departement"=>'Informatique',"composante"=>'B.U.T. Réseaux & Télécommunications',"groupe"=>'Hooke',"niveau"=>2,"promo"=>'2022-2023'],
			
			["departement"=>'Électronique',"composante"=>'Licence Professionnelle MECSE',"groupe"=>'Pentode',"niveau"=>2,"promo"=>'2022-2023'],
			
			["departement"=>'Électronique',"composante"=>'Licence Professionnelle EON',"groupe"=>'Feynman',"niveau"=>2,"promo"=>'2022-2023'],
			
			["departement"=>'Réseaux/Télécoms',"composante"=>'B.U.T. Réseaux & Télécommunications',"groupe"=>'Hooke',"niveau"=>2,"promo"=>'2022-2023'],
			
			["departement"=>'Réseaux/Télécoms',"composante"=>'B.U.T. GEII',"groupe"=>'Lavoisier',"niveau"=>2,"promo"=>'2022-2023'],
			
			["departement"=>'Réseaux/Télécoms',"composante"=>'B.U.T. Informatique',"groupe"=>'Network',"niveau"=>2,"promo"=>'2022-2023'],
			
			["departement"=>'Ressources Humaines',"composante"=>'B.U.T. GEA',"groupe"=>'Cantet',"niveau"=>2,"promo"=>'2022-2023'],
			
			["departement"=>'Droit/Juridique',"composante"=>'B.U.T. Carrières Juridiques',"groupe"=>'Feuchère',"niveau"=>2,"promo"=>'2022-2023'],
			
			["departement"=>'Droit/Juridique',"composante"=>'Licence Professionnelle Métiers du Notariat',"groupe"=>'Ambrosiano',"niveau"=>2,"promo"=>'2022-2023'],
			
			["departement"=>'Assurance/Banque',"composante"=>'B.U.T. Carrières Juridiques',"groupe"=>'Feuchère',"niveau"=>2,"promo"=>'2022-2023'],
			
			["departement"=>'Assurance/Banque',"composante"=>'B.U.T. GEA',"groupe"=>'Cantet',"niveau"=>2,"promo"=>'2022-2023'],
			
			["departement"=>'Assurance/Banque',"composante"=>'Licence Professionnelle ABF',"groupe"=>'Trapeza',"niveau"=>2,"promo"=>'2022-2023'],
			
			["departement"=>'Gestion des Entreprises',"composante"=>'Licence Professionnelle CP',"groupe"=>'Sumer',"niveau"=>2,"promo"=>'2022-2023']
		];
		
		$m = Model::getModel();
		foreach($departComp as $infos){
			$m->ajoutComp($infos['departement'],$infos['composante']);
			
		}
		foreach($groupes as $groupe){
				$m->ajoutGroupe($groupe['departement'],$groupe['composante'],$groupe);
				
			}
			
			
		$users=[
			["nom"=>'Haude',"prenom"=>'Aucéane',"mail"=>'haude.auceane15@gmail.com',"role"=>'e',"departement"=>'Informatique',"composante"=>'B.U.T. Informatique',"groupe"=>'Athos',"promo"=>'2022-2023',"user"=>'12107562',"mdp"=>'azerty'],
			["nom"=>'Portier',"prenom"=>'Moïse',"mail"=>'portier.moise@gmail.com',"role"=>'e',"departement"=>'Informatique',"composante"=>'B.U.T. Informatique',"groupe"=>'Athos',"promo"=>'2022-2023',"user"=>'12107900',"mdp"=>'azerty'],
			["nom"=>'Morgan',"prenom"=>'Xavier',"mail"=>'morgan.xavier@gmail.com',"role"=>'e',"departement"=>'Informatique',"composante"=>'B.U.T. Informatique',"groupe"=>'Athos',"promo"=>'2022-2023',"user"=>'12102301',"mdp"=>'azerty'],
			["nom"=>'Baten',"prenom"=>'Liam',"mail"=>'baten.liam@gmail.com',"role"=>'e',"departement"=>'Informatique',"composante"=>'B.U.T. Informatique',"groupe"=>'Athos',"promo"=>'2022-2023',"user"=>'12105095',"mdp"=>'azerty'],
			["nom"=>'Brunelle',"prenom"=>'Janine',"mail"=>'brunelle.janine@gmail.com',"role"=>'e',"departement"=>'Informatique',"composante"=>'B.U.T. Informatique',"groupe"=>'Athos',"promo"=>'2022-2023',"user"=>'12107288',"mdp"=>'azerty'],
			["nom"=>'Marchal',"prenom"=>'Paola',"mail"=>'marchal.paola@gmail.com',"role"=>'e',"departement"=>'Informatique',"composante"=>'B.U.T. Informatique',"groupe"=>'Aramis',"promo"=>'2022-2023',"user"=>'12105055',"mdp"=>'azerty'],
			["nom"=>'Vallée',"prenom"=>'Tatiana',"mail"=>'vallee.tatiana@gmail.com',"role"=>'e',"departement"=>'Informatique',"composante"=>'B.U.T. Informatique',"groupe"=>'Aramis',"promo"=>'2022-2023',"user"=>'12102216',"mdp"=>'azerty'],
			["nom"=>'Desmarais',"prenom"=>'Geneviève',"mail"=>'desmarais.geneviere@gmail.com',"role"=>'e',"departement"=>'Informatique',"composante"=>'B.U.T. Informatique',"groupe"=>'Porthos',"promo"=>'2022-2023',"user"=>'12106008',"mdp"=>'azerty'],
			["nom"=>'Laframboise',"prenom"=>'Mélissa',"mail"=>'laframboise.melissa@gmail.com',"role"=>'e',"departement"=>'Informatique',"composante"=>'B.U.T. Informatique',"groupe"=>'Porthos',"promo"=>'2022-2023',"user"=>'12100952',"mdp"=>'azerty'],
			["nom"=>'Toutain',"prenom"=>'Jean-Charles',"mail"=>'toutain.jeancharles@gmail.com',"role"=>'e',"departement"=>'Informatique',"composante"=>'B.U.T. Passerelle',"groupe"=>'Passerelle',"promo"=>'2022-2023',"user"=>'12102241',"mdp"=>'azerty'],
			["nom"=>'De Verley',"prenom"=>'Michaël',"mail"=>'deverley.michael@gmail.com',"role"=>'e',"departement"=>'Informatique',"composante"=>'B.U.T. Passerelle',"groupe"=>'Passerelle',"promo"=>'2022-2023',"user"=>'12106433',"mdp"=>'azerty'],
			["nom"=>'Oui',"prenom"=>'Shérine',"mail"=>'oui.sherine@gmail.com',"role"=>'e',"departement"=>'Informatique',"composante"=>'B.U.T. STID',"groupe"=>'Staatskunde',"promo"=>'2022-2023',"user"=>'12108981',"mdp"=>'azerty'],
			["nom"=>'Baschet',"prenom"=>'Kévin',"mail"=>'baschet.kevin@gmail.com',"role"=>'e',"departement"=>'Informatique',"composante"=>'B.U.T. STID',"groupe"=>'Staatskunde',"promo"=>'2022-2023',"user"=>'12103630',"mdp"=>'azerty'],
			["nom"=>'Marais',"prenom"=>'Abel',"mail"=>'marais.abel@gmail.com',"role"=>'e',"departement"=>'Informatique',"composante"=>'B.U.T. GEII',"groupe"=>'Lavoisier',"promo"=>'2022-2023',"user"=>'12103418',"mdp"=>'azerty'],
			["nom"=>'Du Toit',"prenom"=>'Timothé',"mail"=>'dutoit.timothe@gmail.com',"role"=>'e',"departement"=>'Informatique',"composante"=>'B.U.T. GEII',"groupe"=>'Lavoisier',"promo"=>'2022-2023',"user"=>'12106390',"mdp"=>'azerty'],
			["nom"=>'Lemaître',"prenom"=>'Adolphe',"mail"=>'lemaitre.adolphe@gmail.com',"role"=>'e',"departement"=>'Informatique',"composante"=>'Licence Professionnelle MICDTL',"groupe"=>'Hammourabi',"promo"=>'2022-2023',"user"=>'12104559',"mdp"=>'azerty'],
			["nom"=>'Lecocq',"prenom"=>'Gilbert',"mail"=>'lecoq.gilbert@gmail.com',"role"=>'e',"departement"=>'Informatique',"composante"=>'Licence Professionnelle MICDTL',"groupe"=>'Hammourabi',"promo"=>'2022-2023',"user"=>'12107363',"mdp"=>'azerty'],
			["nom"=>'Swen',"prenom"=>'Christophe',"mail"=>'swen.christophe@gmail.com',"role"=>'e',"departement"=>'Informatique',"composante"=>'B.U.T. Réseaux & Télécommunications',"groupe"=>'Hooke',"promo"=>'2022-2023',"user"=>'12107718',"mdp"=>'azerty'],
			["nom"=>'Laforet',"prenom"=>'Silvine',"mail"=>'laforet.silvine@gmail.com',"role"=>'e',"departement"=>'Informatique',"composante"=>'B.U.T. Réseaux & Télécommunications',"groupe"=>'Hooke',"promo"=>'2022-2023',"user"=>'12108107',"mdp"=>'azerty'],
			["nom"=>'Baudelaire',"prenom"=>'Géraldine',"mail"=>'baudelaire.geraldine@gmail.com',"role"=>'e',"departement"=>'Électronique',"composante"=>'Licence Professionnelle MECSE',"groupe"=>'Pentode',"promo"=>'2022-2023',"user"=>'12109079',"mdp"=>'azerty'],
			["nom"=>'Gigot',"prenom"=>'Aimée',"mail"=>'gigot.aimee@gmail.com',"role"=>'e',"departement"=>'Électronique',"composante"=>'Licence Professionnelle MECSE',"groupe"=>'Pentode',"promo"=>'2022-2023',"user"=>'12109046',"mdp"=>'azerty'],
			["nom"=>'La Sueur',"prenom"=>'Angeline',"mail"=>'lasueur.angeline@gmail.com',"role"=>'e',"departement"=>'Réseaux/Télécoms',"composante"=>'B.U.T. GEII',"groupe"=>'Lavoisier',"promo"=>'2022-2023',"user"=>'12107804',"mdp"=>'azerty'],
			["nom"=>'Deschanel',"prenom"=>'Désirée',"mail"=>'deschanel.desiree@gmail.com',"role"=>'e',"departement"=>'Réseaux/Télécoms',"composante"=>'B.U.T. Informatique',"groupe"=>'Network',"promo"=>'2022-2023',"user"=>'12106672',"mdp"=>'azerty'],
			["nom"=>'Marais',"prenom"=>'Élisée',"mail"=>'marais.elisee@gmail.com',"role"=>'e',"departement"=>'Ressources Humaines',"composante"=>'B.U.T. GEA',"groupe"=>'Cantet',"promo"=>'2022-2023',"user"=>'12107102',"mdp"=>'azerty'],
			["nom"=>'Beaumont',"prenom"=>'Anne-Marie',"mail"=>'beaumont.annemarie@gmail.com',"role"=>'e',"departement"=>'Droit/Juridique',"composante"=>'B.U.T. Carrières Juridiques',"groupe"=>'Feuchère',"promo"=>'2022-2023',"user"=>'12109446',"mdp"=>'azerty'],
			["nom"=>'Secret',"prenom"=>'Victoria',"mail"=>'secret.victoria@gmail.com',"role"=>'e',"departement"=>'Droit/Juridique',"composante"=>'B.U.T. Carrières Juridiques',"groupe"=>'Feuchère',"promo"=>'2022-2023',"user"=>'12102950',"mdp"=>'azerty'],
			["nom"=>'Porte-boneur',"prenom"=>'Marinette',"mail"=>'porteboneur.marinette@gmail.com',"role"=>'e',"departement"=>'Droit/Juridique',"composante"=>'Licence Professionnelle Métiers du Notariat',"groupe"=>'Ambrosiano',"promo"=>'2022-2023',"user"=>'12106918',"mdp"=>'azerty'],
			["nom"=>'Boulle',"prenom"=>'Violette',"mail"=>'boulle.violette@gmail.com',"role"=>'e',"departement"=>'Droit/Juridique',"composante"=>'Licence Professionnelle Métiers du Notariat',"groupe"=>'Ambrosiano',"promo"=>'2022-2023',"user"=>'12101799',"mdp"=>'azerty'],
			["nom"=>'Noir',"prenom"=>'Ludovic',"mail"=>'noir.ludovic@gmail.com',"role"=>'e',"departement"=>'Assurance/Banque',"composante"=>'B.U.T. GEA',"groupe"=>'Cantet',"promo"=>'2022-2023',"user"=>'12101913',"mdp"=>'azerty'],
			["nom"=>'Côté',"prenom"=>'Xavier',"mail"=>'cote.xavier@gmail.com',"role"=>'e',"departement"=>'Assurance/Banque',"composante"=>'Licence Professionnelle ABF',"groupe"=>'Trapeza',"promo"=>'2022-2023',"user"=>'12103038',"mdp"=>'azerty'],
			["nom"=>'Carré',"prenom"=>'Racine',"mail"=>'carre.racine@gmail.com',"role"=>'e',"departement"=>'Assurance/Banque',"composante"=>'Licence Professionnelle ABF',"groupe"=>'Trapeza',"promo"=>'2022-2023',"user"=>'12108950',"mdp"=>'azerty'],
			["nom"=>'De Villepin',"prenom"=>'Jean-François',"mail"=>'devillepin.jeanfrancois@gmail.com',"role"=>'e',"departement"=>'Gestion des Entreprises',"composante"=>'Licence Professionnelle CP',"groupe"=>'Sumer',"promo"=>'2022-2023',"user"=>'12109741',"mdp"=>'azerty'],
			["nom"=>'Reynaud',"prenom"=>'Christophe-Victor',"mail"=>'reynaud.cvictor@gmail.com',"role"=>'Enseignant Validateur',"departement"=>'Assurance/Banque',"composante"=>'B.U.T. GEA',"user"=>'17495',"mdp"=>'azerty'],
			["nom"=>'Barbier',"prenom"=>'Aimée',"mail"=>'barbier.aimee@gmail.com',"role"=>'Enseignant Tuteur',"departement"=>'Électronique',"composante"=>'Licence Professionnelle MECSE',"user"=>'14819',"mdp"=>'azerty'],
			["nom"=>'Fontaine',"prenom"=>'Joseph',"mail"=>'fontaine.joseph@gmail.com',"role"=>'Enseignant Tuteur',"departement"=>'Informatique',"composante"=>'B.U.T. STID',"user"=>'13093',"mdp"=>'azerty'],
			["nom"=>'Berthelot',"prenom"=>'Célina-Sophie',"mail"=>'berthelot.csophie@gmail.com',"role"=>'Enseignant Validateur',"departement"=>'Informatique',"composante"=>'B.U.T. Informatique',"user"=>'11001',"mdp"=>'azerty']

		];
		foreach ($users as $user){
			if ($user['role']=='e'){	/*créer une vérif si le groupe est valide*/
				$chemin= "Document_Stage/".$user['user']."/";  //ETUDIANT ID A REMPLACER PAR $_SESSION[Student_ID]
				dirname($chemin);
				$f=mkdir($chemin,0700,true);
				dirname($chemin.'Bordereau_d-offre_de_stage/');
				$f=mkdir($chemin.'Bordereau_d-offre_de_stage/',0700,true);
				dirname($chemin.'CV/');
				$f=mkdir($chemin.'CV/',0700,true);
				dirname($chemin.'Lettre_de_Motivation/');
				$f=mkdir($chemin.'Lettre_de_Motivation/',0700,true);
				dirname($chemin.'Journal_de_Bord/');
				$f=mkdir($chemin.'Journal_de_Bord/',0700,true);
				dirname($chemin.'Mini_Rapport_de_Stage/');
				$f=mkdir($chemin.'Mini_Rapport_de_Stage/',0700,true);
				dirname($chemin.'Rapport_final/');
				$f=mkdir($chemin.'Rapport_final/',0700,true);
			}
							
			$m->userCreater($user);
			
		}
		
		$data=['title'=>'PA'];
		$this->render('accueil',$data);
		
	}
		
}


