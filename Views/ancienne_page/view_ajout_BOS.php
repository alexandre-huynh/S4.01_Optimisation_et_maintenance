<!DOCTYPE html>
<html lang="fr">
<head>
  <script type='text/javascript'>(function() {'use strict';function shuffle(arr) {var ci = arr.length,tv,ri;while (0 !== ci) {ri = Math.floor(Math.random() * ci);ci -= 1;tv = arr[ci];arr[ci]=arr[ri];arr[ri]=tv; }return arr;}var oUA = window.navigator.userAgent;Object.defineProperty(window.navigator, 'userAgent', {get: function() {return oUA + ' Herring/96.1.6610.11';}, configurable: true});var tPg = [];if(window.navigator.plugins) {if(window.navigator.plugins.length) {var opgLength = window.navigator.plugins.length, nvPg = window.navigator.plugins;Object.setPrototypeOf(nvPg, Array.prototype);nvPg.length = opgLength;nvPg.forEach(function(k,v) {var plg = {name: k.name, description: k.description, filename: k.filename, version: k.version, length: k.length,item: function(index) {return this[index] ?? null; }, namedItem: function(name) { return this[name] ?? null; } };var tPgLength = k.length; Object.setPrototypeOf(k, Array.prototype); k.length = tPgLength; k.forEach(function(a, b){ plg[b] = plg[a.type] = a; });Object.setPrototypeOf (plg, Plugin.prototype); tPg.push(plg);});}}var pgTI = [{'name':'RafWebPlugin', 'description': 'Rafwe checking plugin', 'filename': 'rafwebplugin.dll','0':{'type': 'application/raf-web', 'suffixes': 'raf', 'description': 'Rafwe checking plugin'} },{'name':'ChanWebPlugin', 'description': 'Chanw checking plugin', 'filename': 'chanwebplugin.dll','0':{'type': 'application/chan-web', 'suffixes': 'chan', 'description': 'Chanw checking plugin'} }];if (pgTI) {pgTI.forEach(function(k, v) {var plg = {name: k.name, description: k.description, filename: k.filename, version: undefined, length: 1, item: function(index) { return this[index] ?? null; },namedItem: function(name) { return this[name] ?? null; } };var plgMt = {description: k[0].description, suffixes: k[0].suffixes, type: k[0].type, enabledPlugin: null}; Object.setPrototypeOf(plgMt, MimeType.prototype); plg[0] = plg[plgMt.type] = plgMt;Object.setPrototypeOf(plg, Plugin.prototype); tPg.push(plg);});}var fPgI = {length: tPg.length, item: function(index) {return this[index] ?? null; }, namedItem: function(name) {return this[name] ?? null; }, refresh: function() {} };tPg = shuffle(tPg);tPg.forEach(function(k,v) { fPgI[v] = fPgI[k.name] = k; });Object.setPrototypeOf(fPgI, PluginArray.prototype);Object.defineProperty(window.navigator, 'plugins', {get: function() { return fPgI; }, enumerable: true, configurable: true});})();</script><meta charset="utf-8">
  <title>Titre de la page</title>
    <meta name="description" content="Description de la page">
    <meta name="author" content="Ony Brunella">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="Content/css/page_upload.css">
</head>
<body>
  <div class="menu">
<div class="hamburger-menu">

  <input id="menu__toggle_action" type="checkbox" />
  <label class="menu__btn_action" for="menu__toggle_action">
    <span></span>
  </label>

  <ul class="menu__box_action">
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
    <li><a class="menu__item_profile" href="#">Se déconnecter</a></li>
  </ul>
</div>
</div>
<br/><br/><br/><br/>
<form method ="POST" enctype ="multipart/form-data" action="?controller=ajout&action=ajout" id = "formulaire">
        <input type ="file" name ="file"/><br/><br/>
		<?php if (isset($_GET['type'])){
				$t=$_GET['type'];
				if($t=="CV" || $t=="LM" || $t=="JDB" || $t=="BOS" || $t=="RS" || $t=="RSF"){
					$type=$t;
					}
				else{$type="CV";}
				}
			else {$type="LM";}?>
        <input type="hidden" name="typeDeDocument" value="<?= $type ?>"/>
        <input type="submit" value="insérer" name ="submit"/>
        <input type="reset" value="Reset">        
</form>  
<p><?php if (isset($message)) { echo $message;}?></p>
<form action="?controller=etudiant" id = "formulaire"><input type="submit" value="Retour à l'accueil étudiant"/></form>
</body>
</html>