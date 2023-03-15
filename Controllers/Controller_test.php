<?php 
session_start();

class Controller_test extends Controller
{

public function action_accueil_enseignant()
    {
        if (isset($_SESSION["attribut"])){
            $data=$_SESSION["attribut"];
            if(sessionValide($data)){
                $m = Model::getModel();
                $user=$data["n"];
                $userE=$m->userExist($user);

                if ($userE!=false){
                    if (userValide($data,$userE)){
                        $_SESSION["attribut"]=$data;
                        $role=$data["role"];

                        if ($role!="Étudiant"){
                            $_SESSION["attribut"]=$data;
                            //$data['documents']=$m->derniersDoc();
                            $data['annees_promo']=$m->getAnneesPromo();
                            foreach($data['annees_promo'] as $v){
                                $data['documents'] = $m->getDocByAnnee($v);
                            }
                            $_SESSION["documents"]=$data['documents'];

                            $this->render("test_enseignant",$data);//renvoie le tableau directement pris de la session
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