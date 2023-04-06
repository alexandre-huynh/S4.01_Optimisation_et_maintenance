<?php //session_start();?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<title>SAE 3.01 : <?= $_SESSION['attribut']['personne']?></title>
    <meta charset="UTF-8">
    <meta name="author" content="Ony Brunella">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"/>
<link href="Content/css/professeur_profile.css" rel="stylesheet" type="text/css"/>
  
</head>
<body>  
  <nav class="cc-navbar navbar navbar-expand-lg navbar-dark w-100" style="z-index: 1;">
    <div class="container-fluid"> 
    
          <input id="menu__toggle_profile" type="checkbox" />
          <label class="menu__btn_profile" for="menu__toggle_profile">
            <span></span>
          </label>       
<ul class="menu__box_profile">
<li><a class="menu__item_profile" href="#">Changer de thème</a></li>
<li><a class="menu__item_profile" href="#">Modifier le mot de passe</a></li>
<li><a class="menu__item_profile" href="?controller=deconnexion">Se déconnecter</a></li>
</ul>
    </div>
  </nav>
  <div class="main-content" style="z-index: 999;">

    <!-- Page content -->

          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
                <div class="col-8">
                  <h3 class="mb-0">Profils de mes étudiants</h3>
                </div>
                <div><a href="?controller=test&action=accueil_enseignant2&niveau=2"><?php if (!isset($_GET["niveau"]) || $_GET["niveau"]==2) : ?>>><?php endif ?> BUT2 - Semestre 4</a></div>
                <div><a href="?controller=test&action=accueil_enseignant2&niveau=3"><?php if (isset($_GET["niveau"]) && $_GET["niveau"]==3) : ?>>><?php endif ?> BUT3 - Semestre 6</a></div>
            <div class="card-body">
              <div class="container">
              <table class="table table-dark table-striped table-hover table-bordered">
                <thead>
                  <tr>
                    <th>ETUDIANT</th>
                    <th>GROUPE</th>
					<th>MISSION</th>
                    <th>ENTREPRISE</th>
					<th>LIEU</th>
                    </tr>
                </thead>
				<tbody>
                    <!-- Titre pour chaque années de promotion -->
                    <?php foreach(array_reverse($annees_promo) as $v):?>
                        <tr>
                            <!--
                            Ex pour la promotion 2022 / 2023,
                            on a la valeur 2023,
                            donc afficher 2023 - 1 = 2022 puis 2023
                            -->
                            <th>Promotion <?= $v-1;?> / <?= $v;?></th>
                        </tr>
                        <?php foreach($stages[$v] as $infos):?>
                            <tr>
                            <div>
                                <th scope="row"><a href='?controller=test&action=stage_etudiant&student_id=<?= e($infos['Student_ID'])?>&stage_id=<?= e($infos['Stage_ID'])?>&annee=<?= $v?>&niveau=<?= e($_GET['niveau'])?>'>Stage de <?= e($infos['Nom'])?></a></th>
                                <td><?= e($infos['Groupe'])?></td>
                                <td><?= e($infos['Mission'])?></td>
                                <td><?= e($infos['Entreprise'])?></td>
                                <td><?= e($infos['Lieu'])?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php endforeach ?>


              </tbody>
			  <?php ?><?php ?>
              </table>
            </div>
              





          </div>
          </div>
        </div>
      </div>
</body>
</html>