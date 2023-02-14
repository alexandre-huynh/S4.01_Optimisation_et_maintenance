<?php if(isset($title) && isset($departements)){ ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<title>SAE3.01 : Inscription Parti 1</title>
		
	</head>
	<body>
	
	<form action='?controller=ieeescplgboate&action=inscription_page2' method="POST">
	
	<p>NOM :</p><input required type='text' name='nom'/>
	
	<p>PRENOM :</p><input required type='text' name='prenom'/>
	
	<p>MAIL :</p><input required type='text' name='mail'/>
	
	<p>ROLE :</p>
	<label><input type="radio" name="role" value="e" checked /><p>Étudiant</p></label>
    <label><input type="radio" name="role" value="Enseignant Tuteur"/><p>Enseignant Tuteur</p></label>
    <label><input type="radio" name="role" value="Enseignant Validateur"/><p>Enseignant Validateur</p></label>
	<label><input type="radio" name="role" value="Membre du Secrétariat"/><p>Membre du Secrétariat</p></label>
	<label><input type="radio" name="role" value="Coordinatrice de stage"/><p>Coordinatrice de stage</p></label>
	<p>DEPARTEMENT :</p>
	<?php foreach($departements as $dep){?>
	
		<label><input type="radio" name="departement" value="<?= $dep?>"/>		 <p><?= $dep?></p></label>
		
	<?php  }?>
	
	<input type='submit' value='Suivant' name='submit'/>
	
	</form>
	</body>
</html>

<?php  }?>