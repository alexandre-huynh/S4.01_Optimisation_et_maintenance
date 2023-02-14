<?php 
session_start();
class Controller_commentaire extends Controller
	{ 
	
	public function action_commentaire(){
		/*
		Cette fonction verifie si il y a un post, si l'utilisateur est bon grace a beaucoup de test,
			si le post est valide (si il n'est pas vide), et qu'il a les info nécéssaire,
			et si tout est valide il ajoute un commentaire dans la base de données.
			Si rien est valide il renvoie a la page de login (si ya pas de session).
		La complexité de cette fonction est de O(1) car elle ne fait qu'une seule requête à la base de données pour ajouter un commentaire et une seule boucle pour afficher les commentaires.
		*/

		if(isset($_POST['docID'])&&isset($_POST['user'])&&isset($_POST['commentaire'])){
            $docID = $_POST['docID'];
			if (isset($_SESSION["attribut"])){//si le cookie attribut existe et a les bon attribut
				$session=$_SESSION["attribut"];
				if(sessionValide($session)){
					$m = Model::getModel();
					$user=$session["n"];
					$userE=$m->userExist($user);
						
					if ($userE!=false && $_POST['commentaire']!=''){
						$m->ajoutCommentaire($_POST['docID'],$_POST['user'],$_POST['commentaire']);
						$data=[
							"document" => [
								'docID'=>$docID,
								'nomPersonne'=>$_POST['nomPersonne'],
								'nomDoc'=>$_POST['nomDoc'],
								'url'=>$_POST['url']],
							"commentaires"=>$m->takeCommentaires($docID)
						];
						$_SESSION['commentaires']=$data['commentaires'];
						$this->render('commentaire',$data);
					}
				}
			}

		} 
	
	$data = [
			"title"=>"Page d'authentification"
        ];
        $this->render("login", $data);
	}
	
	
	public function action_page_commentaire(){
		/*
		Cette fonction verifie si il y a un post, si l'utilisateur est bon grace a beaucoup de test,
			si le post est valide (si il n'est pas vide), et qu'il a les info nécéssaire.
			et si tout est valide il nous amène a la page de commentaire avec les données nécéssaire a l'affichage de la page.
			Si rien est valide il renvoie a la page de login (si ya pas de session).
		La complexité de cette fonction est similaire à celle de la fonction action_commentaire, c'est-à-dire O(1) pour vérifier la validité de la session et de l'utilisateur, 
		O(1) pour récupérer les commentaires et les informations du document, et O(1) pour afficher la vue. 
		*/
        if(isset($_POST['docID'])&&isset($_POST['nomPersonne'])&&isset($_POST['nomDoc'])&&isset($_POST['url'])){
            $docID = $_POST['docID'];
			if (isset($_SESSION["attribut"])){
				$session=$_SESSION["attribut"];
				if(sessionValide($session)){
					$m = Model::getModel();
					$user=$session["n"];
					$userE=$m->userExist($user);
						
					if ($userE!=false){
						$data=[
							"document" => [
								'docID'=>$docID,
								'nomPersonne'=>$_POST['nomPersonne'],
								'nomDoc'=>$_POST['nomDoc'],
								'url'=>$_POST['url']],
							"commentaires"=>$m->takeCommentaires($docID)
						];
						$_SESSION['commentaires']=$data['commentaires'];
						$_SESSION['document']=$data['document'];
						$this->render('commentaire',$data);
						
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
        $this->action_page_commentaire();
    }
}
?>