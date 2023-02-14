<?php if(isset($role) && isset($composantes)){ ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<title>SAE3.01 : Inscription Parti 2</title>
		
	</head>
	<body>
	
	<?php if ($role=="e"){ ?>
		<form action='?controller=ieeescplgboate&action=inscription_page2_1' method="POST">
		
		
		
		
		<p>COMPOSANTE :</p>
		<?php foreach($composantes as $comp){?>
		<label><input type="radio" name="composante" value="<?= $comp?>"/>				<p><?= $comp?></p></label>
		<?php  }?>
		
		
		
		<input type='hidden' name='nom' value='<?= $nom?>'/>
		<input type='hidden' name='prenom' value='<?= $prenom?>'/>
		<input type='hidden' name='mail' value='<?= $mail?>'/>
		<input type='hidden' name='role' value='<?= $role?>'/>
		<input type='hidden' name='departement' value='<?= $departement?>'/>
		
		<input type='submit' value='Suivant' name='submit'/>
		<br/>
		</form>
		
		
	
	<?php } ?>
	
<?php if ($role=='Enseignant Tuteur' ||  $role=='Enseignant Validateur' || $role=='Membre du Secrétariat' || $role=='Coordinatrice de stage'){ ?>
		<form action='?controller=ieeescplgboate&action=inscription_page3' method="POST">
		
		
		<p>COMPOSANTE :</p>
		<?php foreach($composantes as $comp){?>
		<label><input type="radio" name="composante" value="<?= $comp?>"/>				<p><?= $comp?></p></label>
		<?php  }?>
		
		<input type='hidden' name='nom' value='<?= $nom?>'/>
		<input type='hidden' name='prenom' value='<?= $prenom?>'/>
		<input type='hidden' name='mail' value='<?= $mail?>'/>
		<input type='hidden' name='role' value='<?= $role?>'/>
		<input type='hidden' name='departement' value='<?= $departement?>'/>
		<br/>
		<input type='submit' value='Suivant' name='submit'/>
		</form>
		
		
	
	<?php }?>
	
	</body>
</html>

<?php  }?>