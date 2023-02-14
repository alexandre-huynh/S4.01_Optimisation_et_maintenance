<?php


class Controller_accueil extends Controller
{
    public function action_accueil()
    {
		/*
		Permet d'accéder a la page d'accueil.
		Cette fonction est de complexité O(1) c'est a dire constante.
		 */

        $data = [
			"title"=>"Page d'Accueil",
        ];
        $this->render("accueil", $data);
    }
	
	
    public function action_default()
    {
        $this->action_accueil();
    }
}
