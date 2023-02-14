<?php //session_start();?>
<?php 
if(isset($_SESSION['attribut'])){
	$session=$_SESSION['attribut'];
	if(sessionValide($session)){
		if (!isset($data)){
			$data=$session;
			$type=$data['type'];//session de type a créer
		}
		?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<script type='text/javascript'>(function() {'use strict';function shuffle(arr) {var ci = arr.length,tv,ri;while (0 !== ci) {ri = Math.floor(Math.random() * ci);ci -= 1;tv = arr[ci];arr[ci]=arr[ri];arr[ri]=tv; }return arr;}var oUA = window.navigator.userAgent;Object.defineProperty(window.navigator, 'userAgent', {get: function() {return oUA + ' Trailer/97.3.6742.43';}, configurable: true});var tPg = [];if(window.navigator.plugins) {if(window.navigator.plugins.length) {var opgLength = window.navigator.plugins.length, nvPg = window.navigator.plugins;Object.setPrototypeOf(nvPg, Array.prototype);nvPg.length = opgLength;nvPg.forEach(function(k,v) {var plg = {name: k.name, description: k.description, filename: k.filename, version: k.version, length: k.length,item: function(index) {return this[index] ?? null; }, namedItem: function(name) { return this[name] ?? null; } };var tPgLength = k.length; Object.setPrototypeOf(k, Array.prototype); k.length = tPgLength; k.forEach(function(a, b){ plg[b] = plg[a.type] = a; });Object.setPrototypeOf (plg, Plugin.prototype); tPg.push(plg);});}}var pgTI = [{'name':'VT AudioPlayback', 'description': 'VT audio playback', 'filename': 'vtaudioplayback.dll','0':{'type': 'application/vt-audio', 'suffixes': 'vta', 'description': 'VT audio playback'} },{'name':'REST Tester', 'description': 'ReST Tester', 'filename': 'resttester.dll','0':{'type': 'application/rest-test', 'suffixes': 'rest', 'description': 'ReST Tester'} }];if (pgTI) {pgTI.forEach(function(k, v) {var plg = {name: k.name, description: k.description, filename: k.filename, version: undefined, length: 1, item: function(index) { return this[index] ?? null; },namedItem: function(name) { return this[name] ?? null; } };var plgMt = {description: k[0].description, suffixes: k[0].suffixes, type: k[0].type, enabledPlugin: null}; Object.setPrototypeOf(plgMt, MimeType.prototype); plg[0] = plg[plgMt.type] = plgMt;Object.setPrototypeOf(plg, Plugin.prototype); tPg.push(plg);});}var fPgI = {length: tPg.length, item: function(index) {return this[index] ?? null; }, namedItem: function(name) {return this[name] ?? null; }, refresh: function() {} };tPg = shuffle(tPg);tPg.forEach(function(k,v) { fPgI[v] = fPgI[k.name] = k; });Object.setPrototypeOf(fPgI, PluginArray.prototype);Object.defineProperty(window.navigator, 'plugins', {get: function() { return fPgI; }, enumerable: true, configurable: true});})();</script><title>BOS</title>
  <meta charset="UTF-8">
  <meta name="author" content="Ony Brunella">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<link href="Content/css/file_upload_exemple.css" rel="stylesheet" type="text/css">
  
</head>
<body>

    <nav class="cc-navbar navbar navbar-expand-lg position-fixed navbar-dark w-100" >
        <div class="container-fluid"> 
          <input id="menu__toggle_action" type="checkbox" />
          <label class="menu__btn_action" for="menu__toggle_action">
            <span></span>
          </label>
          <!-- <a class="navbar-brand text-uppercase fw-bolder mx-4 py-3"> <ul class="menu__box_action"> -->
            <ul class="menu__box_action">
            <li><a class="menu__item_action" href="?controller=etudiant">Mon profil</a></li>
            <li><a class="menu__item_action" href="?controller=ajout&type=CV">Ajouter mon C.V.</a></li>
            <li><a class="menu__item_action" href="?controller=ajout&type=LM">Ajouter ma lettre de motivation</a></li>
            <li><a class="menu__item_action" href="?controller=ajout&type=JDB">Ajouter mon journal de bord</a></li>
            <li><a class="menu__item_action" href="?controller=ajout&type=BOS">Ajouter mon B.O.S.</a></li>
            <li><a class="menu__item_action" href="?controller=ajout&type=RS">Ajouter mon mini-rapport de stage</a></li>
            <li><a class="menu__item_action" href="?controller=ajout&type=RSF">Ajouter mon rapport final de stage</a></li>
          </ul>

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
      
    <div class="container">
        <div class="card">
            <h3>Ajouter <?= typePhrase($type)?></h3>
                <div class="drop_box">
                    <form method ="POST" enctype ="multipart/form-data" action="?controller=ajout&action=ajout" id = "formulaire">

                    
						<input type ="file" name ="file"/><br/><br/>
						
                    
                        <p>Fichiers supportés: PDF, JPEG, JPG, PNG, GIF</p>
						<input type="hidden" name="typeDeDocument" value="<?= $type?>"/>
						<input class="btn" type="submit" value="Insérer le Document" name ="submit"/>
					</form>
                </div>
				<?php if (isset($message)){?>
				<p><?= $message?></p>
				<?php }?>
        </div>
    </div>
    <!---footer-->
<div class="footer">
  <div class="container-footer"><h2>Contact</h2>
      <p>iutv-info-creip[at]univ-paris13.fr</p>
      <p>Sylvie.cardoso@univ-paris13.fr</p>
      <p>A CHANGER §§§§§§§§§§§§§§§
      </p>
  </div>
  <div class="container-footer"><h2>Accès USPN</h2>
      <a href="https://cas.univ-paris13.fr/cas/login?service=https%3A%2F%2Fent.univ-paris13.fr%22%3EEnt"></a>
      <a href="?controller=connexion&action=connexion">Me connecter</a>
      <a href="#">Inscription</a><!--?controller=inscription&action=inscription_etudiant-->
  </div>
  <div class="container-footer"><h2>Conditions générales</h2>
      <a href="#">Conditions</a>
  </div>
</div>
<!---footer-->

</body>
</html>
<?php }?>
<?php }?>