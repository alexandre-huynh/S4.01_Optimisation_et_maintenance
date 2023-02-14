<?php 
if(isset($_SESSION['attribut'])&&isset($_SESSION['document'])&&isset($_SESSION['commentaires'])){
	$session=$_SESSION['attribut'];
	if(sessionValide($session)&&$_SESSION['document']!=""&&$_SESSION['commentaires']!=""){
		if (!isset($data)||!isset($document)||!isset($commentaires)){
			$data=$session;
			$document=$_SESSION['document'];
			$commentaires=$_SESSION['commentaires'];//a mettre dans session
		}
		?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset = "utf-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link href="Content/css/commentaire.css" rel="stylesheet" type="text/css">
<title></title>
</head>
<body>
<p><a class="btn btn-order" href="?controller=enseignant">revenir sur la page d'accueil</a></p>
<div class="bloc-form">
<h2>Poster un commentaire</h2>
<h3>Nom du document:</h3><p class="user"><a href='<?= $document['url']?>'><?= $document['nomDoc']?></a></p>
<h3>Étudiant :</h3><p class="user"><?= $document['nomPersonne']?></p>
<br/>
<h2>Commentaires:</h2>
<form action='?controller=commentaire&action=commentaire' method="POST" class="corps-form">
   <input type="hidden" name="docID" value="<?= $document['docID']?>"/>
   <input type="hidden" name="user" value="<?= $session['n']?>"/>
   <input type="hidden" name="nomPersonne" value="<?= $document['nomPersonne']?>"/>
   <input type="hidden" name="nomDoc" value="<?= $document['nomDoc']?>"/>
   <input type="hidden" name="url" value="<?= $document['url']?>"/>
   <textarea name="commentaire" placeholder="Votre commentaire..." rows="5" cols="30"></textarea><br/>
   <input type="submit" value="Poster mon commentaire" name="submit_commentaire" class="btn btn-order" />
</form>
<br /><br />
<?php 
	if ($commentaires!=[]) {?>
<?php foreach($commentaires as $comInfo) { ?>
	<p class="user"><b><?= $comInfo['personne'] ?> :</b> <?= $comInfo['commentaire'] ?><br /></p>
<?php } ?>
<?php }?>
</div>
</body>
</html>
<?php }?>
<?php }?>