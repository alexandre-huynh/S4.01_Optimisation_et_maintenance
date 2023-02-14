<?php 
session_start();

class Controller_enseignant extends Controller
{

public function action_accueil_enseignant()
    {
		/*
		Cette fonction verifie si il y a une fonction qui existe, et si elle est complètement valide,
			et si cela est bon elle renvoie les informations nécessaire au bonne affichage de la page.
		La complexité de cette fonction est de O(1) car elle vérifie simplement les conditions d'existence
		 et de validité des sessions et des utilisateurs, puis rend la vue en fonction du rôle de l'utilisateur
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
							
						if ($role!="Étudiant"){
							$_SESSION["attribut"]=$session;
							$session['documents']=$m->derniersDoc();
							$_SESSION["documents"]=$session['documents'];
							$this->render("professeur_profile",$session);//renvoie le tableau directement pris de la session
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
        $this->action_accueil_enseignant();
    }
}
	
	?>