<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<title>SAE3.01 : Connexion</title>
		<link rel = "stylesheet"  href = "Content/css/connexion.css"/>
		
	</head>
	<body>
<div class="button-retour">
<a href= "?controller=accueil"><button type="submit">Retour a la page d'acceuil</button></a>
</div>
<div id = "FormulaireId">
    <form action="?controller=connexion&action=connexion" method="post">
        <i class="fa-regular fa-user"></i>  
        <h2> Connectez-vous</h2>
        <div class = "separation"></div>
        <div class = "corps-formulaire">
            <div class = "groupe">
                <label for="login"> Nom de l'utilisateur</label>
                <input type="text" name="user_login" required>
            </div>
            <div class = "groupe">
                <label for="mdp"> Mot de Passe</label>
                <input type="password" name="user_password" required>
            </div>
        </div>
		<?php if (isset($message)){?>
		 <p><?= $message?></p>
		<?php }?>
        <div id = "Pied-Form" align="center">
            <div class="button">
                <a href= "?controller=connexion&action=connexion"><button type="submit">Connexion</button></a>
            </div>
            <div class="button">
                <a href= "?controller=inscription"><button type="submit">Inscription</button></a>
            </div>
        </div>
    </form>
</div>
</body>
</html>