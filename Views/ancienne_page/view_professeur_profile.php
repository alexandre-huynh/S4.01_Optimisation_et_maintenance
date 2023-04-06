<?php //session_start();?>
<?php 
if(isset($_SESSION['attribut'])&&isset($_SESSION['documents'])){
	$session=$_SESSION['attribut'];
	if(sessionValide($session)&&$_SESSION['documents']!=""){
		if (!isset($data)||!isset($documents)){
			$data=$session;
			$documents=$_SESSION['documents'];
		}
		?>

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

       
            <div class="card-body">
              <div class="container">
              <table class="table table-dark table-striped table-hover table-bordered">
                <thead>
                  <tr>
                    <th>DOCUMENT</th>
					<th>ÉTUDIANT</th>
                    <th>DATE</th>
                    <th>TYPE</th>
					<th>VERSION</th>
					<th>COMMENTAIRES</th><!-- form disant 'Voir les commentaires' avec plein d'hidden comme le Document_ID-->
                    </tr>
                </thead><?php //"Document_Stage/".$user.'/'.$doc.'/'.$fichier
					if(isset($documents)){
					if ($documents!=[]){?>
				<tbody>
					<?php //"Document_Stage/".$user.'/'.$doc.'/'.$fichier
					foreach($documents as $infos){?>
				<tr>
				<div>
					<th scope="row"><a href='Document_Stage/<?= $infos['user']?>/<?= $infos['type']?>/<?= $infos['url']?>'><?= $infos['url']?></a></th>
					<td><?= $infos['personne']?></td>
					<td><?= pdate($infos['date'])?></td>
					<td><?= typeDoc($infos['type'])?></td>
					<td><?= $infos['version']?></td>
						</div>
					<td>
			
						<form action='?controller=commentaire' method='post'>
							<input type='hidden' name='url' value='Document_Stage/<?= $infos['user']?>/<?= $infos['type']?>/<?= $infos['url']?>' />
							<input type='hidden' name='nomDoc' value='<?= $infos['url']?>' />
							<input type='hidden' name='user' value='<?= $infos['user']?>' />
							<input type='hidden' name='nomPersonne' value='<?= $infos['personne']?>' />
							<input type='hidden' name='docID' value='<?= $infos['docID']?>' />
							<input type='submit' value='Voir les commentaires'/>
						</form>
					</td>
				</tr>
				<?php }?>
				
                  
              </tbody>
			  <?php }?><?php }?>
              </table>
            </div>
              





          </div>
          </div>
        </div>
      </div>
</body>
</html>
<?php }?>
<?php }?>