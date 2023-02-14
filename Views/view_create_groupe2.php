<?php if(isset($title)&&isset($composantes)){ ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<title>SAE3.01 : Ajout Groupe</title>
		
	</head>
	<body>
	<form action='?controller=ieeescplgboate&action=ajout_groupe' method="POST">
	<p>COMPOSANTE :</p>
	<?php foreach($composantes as $comp){?>
	
		<label><input type="radio" name="composante" value="<?= $comp?>"/>		 <p><?= $comp?></p></label>
		
	<?php  }?>
	<br/>
	<p>NOM DU GROUPE :</p>
	<label><input type="text" name="groupe" required /></label>
	<br/>
	<p>Promo :</p>
	<?php $promos=promos();
		foreach($promos as $promo){?>
	<label><input type="radio" name="promo" value="2022-2023" />		 <p><?= $promo ?></p></label>
<?php }?>
	<br/>
	<p>Niveau : </p>
	<label><input type="radio" name="niveau" value="2" checked />		 <p>2</p></label>
	<label><input type="radio" name="niveau" value="3" />		 <p>3</p></label>
	

	<input type='hidden' name='departement' value='<?= $departement?>'/>
	<input type='submit' value='Entrer' name='submit'/>
	</form>
	</body>
</html>


<?php }?>