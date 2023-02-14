<?php
session_start();

class Controller_connexion extends Controller
{
    public function action_connexion()
    {
		/*
		Cette fonction verifie si il y a un post, si il y en a pas elle verifie si il y a une session valide de présente, 
			si il y en a pas elle envoie sur la page de login (connexion),
			vérifie si  l'utilisateur existe, si il n'existe pas elle renvoie sur la page de login,
			si le mot de passe est bon, si pas bon renvoie sur le login avec un message d'erreur,
			si il y a pas de session d'active, il la créer, si une existe il connecte juste avec la nouvelle session en modifiant l'ancienne.
		La complexité de cette fonction est O(n), car elle effectue plusieurs vérifications de données (si le post existe,
		si l'utilisateur existe, si le mot de passe est valide, etc.) et des appels à des fonctions de modèle (userExist, getM...) 
		qui peuvent avoir des complexités variables. Cependant, dans l'ensemble, la complexité globale reste linéaire 
		
		*/
		if (isset($_POST["user_login"])){//si on le post
			$user=$_POST["user_login"];
			$m = Model::getModel();
			$userE=$m->userExist($user);//renvoie tableau avec les donnée nécésssaire si existe
			if ($userE!=false){//utilisateur exist
				if (password_verify($_POST["user_password"],$m->getM($user))/*true ou false*/){
					if (!isset($_SESSION['attribut'])){

						if ($userE['role']=="Étudiant"){
							$userE['last50']=$m->last50($user);
							$_SESSION['attribut']=$userE;
							$this->render("etudiant_profile",$userE);
						}
						
						else{
							$userE['documents']=$m->derniersDoc();
							$_SESSION['attribut']=$userE;
							$_SESSION['documents']=$userE['documents'];
							
							$this->render("professeur_profile",$userE);//

						}
						
					}
					else{
							$_SESSION['attribut']=$userE;
							$role=$userE["role"];
							
							if ($role=="Étudiant"){
								$userE['last50']=$m->last50($user);
								$this->render("etudiant_profile",$userE);//renvoie le tableau directement pris du session
							}
							elseif($role=="Enseignant Tuteur"){
								$userE['documents']=$m->derniersDoc();
								$_SESSION['documents']=$userE['documents'];
								$this->render("professeur_profile",$userE);//
								
							}
							
							elseif ($role=="Enseignant Validateur"){
								$userE['documents']=$m->derniersDoc();
								$_SESSION['documents']=$userE['documents'];
								$this->render("professeur_profile",$userE);
							}
							
							elseif ($role=="Membre du Secrétariat"){
								$userE['documents']=$m->derniersDoc();
								$_SESSION['documents']=$userE['documents'];
								$this->render("professeur_profile",$userE);
							}
							
							elseif ($role=="Coordinatrice de stage"){
								$userE['documents']=$m->derniersDoc();
								$_SESSION['documents']=$userE['documents'];
								$this->render("professeur_profile",$userE);
							}
						

					}
					
				}
			}
			
			$data = [
				"title" => "Page d'accueil de ",//a changer
				"message"=>"Le nom d'utilisateur ou le mot de passe sont incorrecte"
			];
			$this->render("login", $data);//renvoie le message
			
		}//fin de si on post 
		
		
		
		else{//sinon ... generalement si ya une session existante
			if (isset($_SESSION["attribut"])){//si le session attribut existe 
				$session=$_SESSION["attribut"];
				if(sessionValide($session)){//si le session attribut existe et a les bon attribut
					$m = Model::getModel();
					$user=$session["n"];
					$userE=$m->userExist($user);
					
					if ($userE!=false){
						if (userValide($session,$userE)){
							
							$_SESSION["attribut"]=$session;
							$role=$session["role"];
							
							if ($role=="Étudiant"){
								$session['last50']=$m->last50($user);
								$_SESSION["attribut"]=$session;
								$this->render("etudiant_profile",$session);//renvoie le tableau directement pris du session
							}
							elseif($role=="Enseignant Tuteur"){
								$userE['documents']=$m->derniersDoc();
								$_SESSION['documents']=$userE['documents'];
								$this->render("professeur_profile",$session);//
								
							}
							
							elseif ($role=="Enseignant Validateur"){
								$userE['documents']=$m->derniersDoc();
								$_SESSION['documents']=$userE['documents'];
								$this->render("professeur_profile",$session);
							}
							
							elseif ($role=="Membre du Secrétariat"){
								$userE['documents']=$m->derniersDoc();
								$_SESSION['documents']=$userE['documents'];
								$this->render("professeur_profile",$session);
							}
							
							elseif ($role=="Coordinatrice de stage"){
								$userE['documents']=$m->derniersDoc();
								$_SESSION['documents']=$userE['documents'];
								$this->render("professeur_profile",$session);
							}
						}
					}
				}
				
				
			}
			$data = [
				"title" => "Page d'accueil de ",//a changer
				"message"=>""
			];
			$this->render("login",$data);
			
		}
	
	}//fin de l'action de connexion
		
    
	
	
	
	
	
	
	public function action_page_connexion()
    {
		/*
		Cette fonction vérifie si il y a une session de présente existe, et si elle est valide, et si non, alors elle amene le login.
		La complexité de cette fonction est O(1) car elle vérifie simplement l'existence et la validité d'une session. Si la session est valide,
		 elle effectue quelques vérifications supplémentaires pour déterminer le rôle de l'utilisateur et rendre la vue appropriée. 
		*/
		if (isset($_SESSION["attribut"])){//si le session attribut existe et a les bon attribut
			$session=$_SESSION["attribut"];
			if(sessionValide($session)){
				$m = Model::getModel();
				$user=$session["n"];
				$userE=$m->userExist($user);
					
				if ($userE!=false){
					if (userValide($session,$userE)){
						$_SESSION["attribut"]=$session;
						$role=$session["role"];
							
						if ($role=="Étudiant"){
							$session['last50']=$m->last50($user);
							$_SESSION["attribut"]=$session;
							$this->render("etudiant_profile",$session);//renvoie le tableau directement pris du session
						}
						elseif($role=="Enseignant Tuteur"){
							$this->render("professeur_profile",$session);//
								
						}
							
						elseif ($role=="Enseignant Validateur"){
							$this->render("professeur_profile",$session);
						}
							
						elseif ($role=="Membre du Secrétariat"){
							$this->render("professeur_profile",$session);
						}
							
						elseif ($role=="Coordinatrice de stage"){
							$this->render("professeur_profile",$session);
						}
					}
				}
			}
			
		}
		$data = [
			"title" => "Page d'autentification",
		];
		$this->render("login", $data);
    }
    
	
	
	
	
	

    public function action_default()
    {
        $this->action_page_connexion();
    }
}