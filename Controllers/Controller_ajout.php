<?php
session_start();

class Controller_ajout extends Controller
{
    public function action_ajout()
    {
		/*
		Cette fonction verifie si l'utilisateur est bon grace a beaucoup de test,si il y a un post, si le fichier envoyé est 'Valide' a l'upload,
			et si tout est valide il envoie le fichier dans la base de données et le met dans son dossier.
			Si il y a une erreur un message d'erreur est envoyé a la page d'envoie de fichier et il n'est pas implémenter.
			Si rien est valide il renvoie a la page de login (si ya pas de session).Si ya une session il renvoie a la page étudiant.
		La fonction action_ajout() effectue des comparaisons et des appels de fonctions donc sa complexité est généralement O(1) pour les comparaisons et
		 O(n) pour les appels de fonctions. 
		 En résumé la complexité globale de cette fonction est O(1) + O(1) + O(n) + O(taille_du_fichier) qui est principalement dominé par la taille du fichier à déplacer.
		*/
        if(isset($_POST['submit'])){
				if (isset($_SESSION['attribut'])){
					$session=$_SESSION["attribut"];
					if(sessionValide($session)){
					
						$m = Model::getModel();
						$user=$session["n"];
						$userE=$m->userExist($user);
							
						if ($userE!=false){
							if (userValide($session,$userE)){
								$fichier = $_FILES['file']['name'];
								$taille_maximal = 20000000;
								$taille = filesize($_FILES['file']['tmp_name']);
								$extensions = array('.png','.jpg','.jpeg','.gif','.pdf','.PNG','.JPG','.JPEG','.GIF','.PDF');
								$extension = strrchr($fichier,'.');
								
								if(!in_array($extension,$extensions)){
									$error = "Vous devez déposer un autre fichier";
								}
								if($taille > $taille_maximal){
									$error = "Le fichier est trop volumineux veuillez réesayer";
								}
								
								if(!isset($error)){
									$doc=typeDeDocument($_POST["typeDeDocument"]);
									$fichier = preg_replace('/([^.a-z0-9]+)/i',' -',$fichier);
									
										
									$file=$_FILES['file']['name'];
									$file=e($file);
									if ($file!=$fichier||$fichier!=$_FILES['file']['name']){
										$error='Veuillez enlever les caractères spéciaux du nom de votre document afin de déposer votre fichier !';
									}
									$exist=$m->nomDocExist($user,$doc,$file);
									
									if (!$exist && !isset($error)){
										move_uploaded_file($_FILES['file']['tmp_name'],"Document_Stage/".$user.'/'.$doc.'/'.$fichier);
										
										//Récupération de l'objet PDO
										
										$m = Model::getModel();
										$upload = $m->upload_fichier($file,$doc,$user);
										$session['last50']=$m->last50($user);
										$_SESSION['attribut']=$session;
									}
									elseif ($exist){
										$error='Vous avez déjà un déposé un document en ce nom. <br/>Veuillez changer le nom du document !';
									}
									elseif ($error==''){
										$error='Veuillez changer le nom du document afin de le déposer !';
										
									}
									
								}
								//Affichage de la vue
								$data = [
									"title" => "Page d'Accueil Etudiant",
									"attribut"=>$session,
									"type"=>$_POST['typeDeDocument']
								];
								if (isset($upload)) {
									if ($upload){
										$data["message"] = "Votre fichier a été ajouté.";
									} else {
										$data["message"] = "Il y a eu une erreur! Votre fichier n'a pas pu être transferé !";
									}
								}
								elseif(isset($error)){
									$data["message"]=$error;
								}
								$this->render("file_upload_exemple", $data);
							}
						}
						
						
					}
				}


		}
		
		elseif (isset($_SESSION['attribut'])){
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
							
							$this->render("etudiant_profile",$session);//renvoie le tableau directement pris de la session
						}
					}
					
				}
			}
				
		}
	$data = [
		"title" => "Page d'authentification",
        ];
	$this->render("login", $data);
	
	}
	
	
	
	
	public function action_page_ajout(){
		/*
		Cette fonction amène a une page spécial proposant de créer des Département/Composante,des Groupes, des Utilisateur, ou de faire une auto incrémentation des tables.
		La complexité de cette fonction est de O(n) où n est le nombre de conditions vérifiées dans la fonction. 
		*/
		if (isset($_SESSION['attribut'])){
			$session=$_SESSION["attribut"];
			if(sessionValide($session)){
				$m = Model::getModel();
				$user=$session["n"];
				$userE=$m->userExist($user);
				
				if ($userE!=false){
					if (userValide($session,$userE)){
					$_SESSION["attribut"]=$session;
					if(isset($_GET["type"])){
						if(typeValide($_GET["type"])){
							$data = [
							"title"=>"Page de ",
							"attribut" => $session,
							"type"=>$_GET["type"]
							];
							$session['type']=$data['type'];
							$_SESSION["attribut"]=$session;
							$data["title"]=$data["title"].$userE['personne'];
							$this->render("file_upload_exemple", $data);
							
							}
						}
					$this->render("etudiant_profile",$session);//renvoie le tableau directement pris de la session
					}
				}
			}
		}
	$data = [
		"title"=>"Page d'authenfication",
		];
	$this->render("login", $data);
	}
		
		
		
		
	

    public function action_default()
    {
        $this->action_page_ajout();
    }
}