<?php if(isset($data)){ ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<title>SAE3.01 : Inscription Parti 3</title>
		
	</head>
	<body>
		<form action='?controller=ieeescplgboate&action=inscription' method="POST">
		<?php if($data['role']=='e'){ ?>
		<p>PROMO :</p>
			<?php	foreach($data['promos'] as $promo){			?>
			<label><input type='radio' name="promo" value="<?= $promo?>"/><p><?= $promo?></p></label>
			<?php }?>
		<?php }?>
		<p>USERNAME :</p><input required type='text' name='user'/>
		<br/>
		<p>MOT DE PASSE :</p><input required type='text' name='mdp'/>
		
		<?php foreach ($data as $cle => $valeur){?>
			<input type='hidden' name="<?= $cle?>" value="<?= $valeur?>"/>
			
			
		<?php }?>
		<input type='submit' value='Entrer' name='submit'/>
		<br/>
		</form>
	</body>
</html>

<?php  }?>