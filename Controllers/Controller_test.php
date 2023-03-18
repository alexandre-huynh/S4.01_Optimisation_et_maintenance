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
                            // ancienne méthode : affiche tous les derniers docs, sans distinction année ni promotion
                            //$data['documents']=$m->derniersDoc();

                            // méthode expérimentale : non fonctionnelle
                            //$data['documents'] = $m->getDocByAnnee($);
                            /*
                            foreach($data['annees_promo'] as $v){
                                $data['documents'] = $m->getDocByAnnee($v);
                            }
                            */
                            // ======================================================================
                            // on obtiens les différentes promo répertoriés concernés par les stages
                            $data['annees_promo']=$m->getAnneesPromo();
                            $documents = [];
                            if (isset($_GET['niveau'])){
                                $niveau = $_GET['niveau'];
                            } else {
                                // par défaut stages BUT2 S4 à changer si nécessaire TODO
                              $niveau = 2;
                            }
                            // ----------------------------------------------------------------------
                            // pour chaque années de promotion, on obtiens les documents de cette promotion
                            foreach ($data['annees_promo'] as $annee){
                                $documents[$annee] = $m->getDocByAnneeAndNiveau($annee, $niveau);
                            }
                            $data['documents'] = $documents;

                            // ======================================================================
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