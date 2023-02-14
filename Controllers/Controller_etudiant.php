<?php 
session_start();

class Controller_etudiant extends Controller
{

public function action_accueil_etudiant()
    {
		/*
		Cette fonction verifie si il y a une fonction qui existe, et si elle est complètement valide,
			et si cela est bon elle renvoie les informations nécessaire au bonne affichage de la page.
		Cette fonctino a une complexité de O(n) car elle effectue plusieurs vérifications successives sur des données de tailles différentes.
		*/
		if (isset($_SESSION["attribut"])){
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
							$this->render("etudiant_profile",$session);//renvoie le tableau directement pris de la session
						}
					}
					
				}
			}
			
		}
        $data = [
			"title"=>"Page d'authentification"
        ];
        $this->render("login", $data);
    }
	
	
public function action_default()
    {
        $this->action_accueil_etudiant();
    }
}
	
	?>