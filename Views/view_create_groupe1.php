<?php if(isset($title)&&isset($departements)){ ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<title>SAE3.01 : Ajout Groupe</title>
		
	</head>
	<body>
	<form action='?controller=ieeescplgboate&action=page_groupe2' method="POST">
	<p>DEPARTEMENT :</p>
	<?php foreach($departements as $dep){?>
	
		<label><input type="radio" name="departement" value="<?= $dep?>"/>		 <p><?= $dep?></p></label>
		
	<?php  }?>
	
	<input type='submit' value='Suivant' name='submit'/>
	</form>
	</body>
</html>


<?php }?>