<?php if(isset($title) && isset($departements)){ ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<title>SAE3.01 : Ajout Composante</title>
		
	</head>
	<body>
	<form action='?controller=ieeescplgboate&action=ajout_composante' method="POST">
	
	<p>DEPARTEMENT :</p>
	<?php foreach($departements as $dep){?>
	
		<label><input type="radio" name="departement" value="<?= $dep?>"/>		 <p><?= $dep?></p></label>
		
	<?php  }?>
	<label><input type="radio" name="departement" value="autre" checked />		 <p>Autre :</p></label><input type='text' name='autre'/>
	<br/>
	<p>COMPOSANTE :</p>
	<label><input type="text" name="composante" required /></label>
	
	<input type='submit' value='Entrer' name='submit'/>
	</form>
	</body>
</html>


<?php }?>