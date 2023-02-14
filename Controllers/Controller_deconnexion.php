<?php
session_start();

class Controller_deconnexion extends Controller
{
    public function action_deconnexion()
    {
		/*
		Cette fonction vide toute les session pouvant existées et nous envoie a la page de login (connexion).
		La complexité de cette fonction est O(1), car elle effectue un nombre constant d'opérations, 
		qui sont la suppression des variables de session et la redirection vers la page de connexion.
		*/
		$_SESSION['attribut']="";
		$_SESSION['document']="";
		$_SESSION['documents']="";
		$_SESSION['commentaires']="";
		
        $data = [
            "title" => "Deconnexion",
        ];
        $this->render("login", $data);
    }

    public function action_default()
    {
        $this->action_deconnexion();
    }
}
