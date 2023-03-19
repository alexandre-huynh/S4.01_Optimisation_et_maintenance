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
                  <h1 class="mb-0">Stage de <?= e($documents[0]['personne']);?> chez <?= e($data['stage']['Entreprise_nom'])?>, mission <?= e($data['stage']['Mission'])?></h1>
                </div>
            <div class="card-body">
                <!--Documents-->
                <div class="container">
                    <h2>Documents liés à ce stage</h2>
                <table class="table table-dark table-striped table-hover table-bordered">
                  <tr>
                      <th>DOCUMENT</th>
                      <th>DATE</th>
                      <th>TYPE</th>
                      <th>VERSION</th>
                      <th>COMMENTAIRES</th><!-- form disant 'Voir les commentaires' avec plein d'hidden comme le Document_ID-->
                  </tr>
                </thead>
				<tbody>
                    <!-- Titre pour chaque années de promotion -->
                    <?php foreach($documents as $infos):?>
                        <tr>
                            <div>
                                <th scope="row"><a href='Document_Stage/<?= e($infos['user'])?>/<?= e($infos['type'])?>/<?= e($infos['url'])?>'><?= e($infos['url'])?></a></th>
                                <td><?= e(pdate($infos['date']))?></td>
                                <td><?= e(typeDoc($infos['type']))?></td>
                                <td><?= e($infos['version'])?></td>
                            </div>
                            <td>

                                <form action='?controller=commentaire' method='post'>
                                    <input type='hidden' name='url' value='Document_Stage/<?= e($infos['user'])?>/<?= e($infos['type'])?>/<?= e($infos['url'])?>' />
                                    <input type='hidden' name='nomDoc' value='<?= e($infos['url'])?>' />
                                    <input type='hidden' name='user' value='<?= e($infos['user'])?>' />
                                    <input type='hidden' name='nomPersonne' value='<?= e($infos['personne'])?>' />
                                    <input type='hidden' name='docID' value='<?= e($infos['docID'])?>' />
                                    <input type='submit' value='Voir les commentaires'/>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                  </tbody>
                  </table>
                </div>
                <!--Informations sur le stage-->
                <div class="container">
                    <h2>Informations sur le stage</h2>

                    <div>
                        <form action='?controller=test&action=update_info_stage' method='post'>
                            <!--Etudiant-->
                            <p>
                                <label>Etudiant stagiaire :
                                    <input type='text' name='etudiant_name' value='<?= e($data['stage']['Etudiant_name'])?>' />
                                </label>
                            </p>
                            <p>
                                <label>Mail de l'étudiant :
                                    <input type='text' name='etudiant_mail' value='<?= e($data['stage']['Etudiant_mail'])?>' />
                                </label>
                            </p>
                            <p>
                                Formation : <?=e($data['stage']['Composante'])?> (Département <?=e($data['stage']['Département'])?>)
                            </p>
                            <p>
                                Promotion : <?=e($data['stage']['Promotion'])?>
                            </p>
                            <p>
                                Groupe lors du stage : <?=e($data['stage']['Groupe_pendant'])?> <?php if (e($data['stage']['Groupe_actuel']) != e($data['stage']['Groupe_pendant']) ) : ?>(actuel : <?=e($data['stage']['Groupe_actuel'])?>)<?php endif;?>
                            </p>
                            <hr>
                            <!--Encadrant-->
                            <p>
                                <label>Enseignant encadrant :
                                    <input type='text' name='personnel_name' value='<?= e($data['stage']['Personnel_name'])?>' />
                                </label>
                            </p>
                            <p>
                                <label>Mail de l'enseignant:
                                    <input type='text' name='personnel_mail' value='<?= e($data['stage']['Personnel_mail'])?>' />
                                </label>
                            </p>
                            <hr>
                            <!--Tuteur-->
                            <p>
                                <label>Tuteur de stage :
                                    <input type='text' name='tuteur_name' value='<?= e($data['stage']['Tuteur_name'])?>' />
                                </label>
                            </p>
                            <p>
                                <label>Mail du tuteur :
                                    <input type='text' name='tuteur_mail' value='<?= e($data['stage']['Tuteur_mail'])?>' />
                                </label>
                            </p>
                            <hr>
                            <!--Entreprise-->
                            <p>
                                <label>Entreprise :
                                    <input type='text' name='entreprise_nom' value='<?= e($data['stage']['Entreprise_nom'])?>' />
                                </label>
                            </p>
                            <p>
                                <label>Description :
                                    <input type='text' name='description' value='<?= e($data['stage']['Description'])?>' />
                                </label>
                            </p>
                            <p>
                                <label>Adresse :
                                    <input type='text' name='adresse' value='<?= e($data['stage']['Adresse'])?>' />
                                </label>
                            </p>
                            <p>
                                <label>Lieu :
                                    <input type='text' name='adresse' value='<?= e($data['stage']['Lieu'])?>' />
                                </label>
                            </p>
                        </form>
                    </div>
                </div>

          </div>
          </div>
        </div>
      </div>
</body>
</html>