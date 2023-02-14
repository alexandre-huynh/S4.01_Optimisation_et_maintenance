<?php if(isset($role) && isset($groupes)){ ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<title>SAE3.01 : Inscription Parti 2</title>
		
	</head>
	<body>
	
	
		<form action='?controller=ieeescplgboate&action=inscription_page3' method="POST">
		
		
		<p>GROUPE :</p>
		<?php foreach($groupes as $group){?>
		<label><input type="radio" name="groupe" value="<?= $group?>" />		<p><?= $group?></p></label>
		<?php  }?>
		
		
		<input type='hidden' name='nom' value='<?= $nom?>'/>
		<input type='hidden' name='prenom' value='<?= $prenom?>'/>
		<input type='hidden' name='mail' value='<?= $mail?>'/>
		<input type='hidden' name='role' value='<?= $role?>'/>
		<input type='hidden' name='departement' value='<?= $departement?>'/>
		<input type='hidden' name='composante' value='<?= $composante?>'/>

		<input type='submit' value='Suivant' name='submit'/>
		<br/>
		</form>
		
		


<?php  }?>