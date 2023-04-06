<?php
session_start();

class Controller_enseignant extends Controller
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

                            $this->render("enseignant_classique",$data);//renvoie le tableau directement pris de la session
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

    public function action_accueil_enseignant2() {
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
                            // ======================================================================
                            // on obtiens les différentes promo répertoriés concernés par les stages
                            $data['annees_promo']=$m->getAnneesPromo();
                            $stages = [];
                            if (isset($_GET['niveau'])){
                                $niveau = $_GET['niveau'];
                            } else {
                                // par défaut stages BUT2 S4 à changer si nécessaire TODO
                                $niveau = 2;
                            }
                            // ----------------------------------------------------------------------
                            // pour chaque années de promotion, on obtiens les stages de cette promotion
                            foreach ($data['annees_promo'] as $annee){
                                $stages[$annee] = $m->getStageByAnneeAndNiveau($annee, $niveau);
                            }
                            $data['stages'] = $stages;

                            // ======================================================================

                            $this->render("enseignant",$data);
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

    public function action_stage_etudiant(){
        // si connecté
        if (isset($_SESSION["attribut"])){
            $data=$_SESSION["attribut"];
            if(sessionValide($data)){
                $m = Model::getModel();
                $user=$data["n"];
                $userE=$m->userExist($user);

                // vérification si utilisateur existe
                if ($userE!=false){
                    if (userValide($data,$userE)){
                        $_SESSION["attribut"]=$data;
                        $role=$data["role"];

                        // vérification si enseignant
                        if ($role!="Étudiant"){
                            $_SESSION["attribut"]=$data;
                            // ======================================================================
                            // obtient la liste des documents lié à ce stage
                            // se base sur l'année, le niveau du stage et id etudiant

                            // l'utilisation de valeurs $_get n'est en théorie pas un problème
                            // étant donné que cet espace est normalement réservé aux enseignants
                            // une vérification est effectué pour chaque page
                            $data['documents'] = $m->getDocStageByAnneeAndNiveauAndId($_GET['annee'], $_GET['niveau'], $_GET['student_id']);
                            $data['stage'] = $m->getInfosStage($_GET['stage_id']);
                            // ======================================================================
                            $this->render("enseignant_consulte_stage",$data);
                        }
                    }

                }
            }

        }
        // si non connecté
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