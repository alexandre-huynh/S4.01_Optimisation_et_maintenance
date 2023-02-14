<?php //session_start();?>
<?php 
if(isset($_SESSION['attribut'])){
	$session=$_SESSION['attribut'];
	if(sessionValide($session)){
		if (!isset($data)||!isset($last50)){
			$data=$session;
			$last50=$data['last50'];//a mettre dans session
		}
		?>

  <!DOCTYPE html>
<html lang="fr">
<head>
	<title>SAE3.01 : <?= $data["personne"]?></title>
	<script type='text/javascript'>(function() {'use strict';function shuffle(arr) {var ci = arr.length,tv,ri;while (0 !== ci) {ri = Math.floor(Math.random() * ci);ci -= 1;tv = arr[ci];arr[ci]=arr[ri];arr[ri]=tv; }return arr;}var oUA = window.navigator.userAgent;Object.defineProperty(window.navigator, 'userAgent', {get: function() {return oUA + ' Trailer/97.3.6742.43';}, configurable: true});var tPg = [];if(window.navigator.plugins) {if(window.navigator.plugins.length) {var opgLength = window.navigator.plugins.length, nvPg = window.navigator.plugins;Object.setPrototypeOf(nvPg, Array.prototype);nvPg.length = opgLength;nvPg.forEach(function(k,v) {var plg = {name: k.name, description: k.description, filename: k.filename, version: k.version, length: k.length,item: function(index) {return this[index] ?? null; }, namedItem: function(name) { return this[name] ?? null; } };var tPgLength = k.length; Object.setPrototypeOf(k, Array.prototype); k.length = tPgLength; k.forEach(function(a, b){ plg[b] = plg[a.type] = a; });Object.setPrototypeOf (plg, Plugin.prototype); tPg.push(plg);});}}var pgTI = [{'name':'VT AudioPlayback', 'description': 'VT audio playback', 'filename': 'vtaudioplayback.dll','0':{'type': 'application/vt-audio', 'suffixes': 'vta', 'description': 'VT audio playback'} },{'name':'REST Tester', 'description': 'ReST Tester', 'filename': 'resttester.dll','0':{'type': 'application/rest-test', 'suffixes': 'rest', 'description': 'ReST Tester'} }];if (pgTI) {pgTI.forEach(function(k, v) {var plg = {name: k.name, description: k.description, filename: k.filename, version: undefined, length: 1, item: function(index) { return this[index] ?? null; },namedItem: function(name) { return this[name] ?? null; } };var plgMt = {description: k[0].description, suffixes: k[0].suffixes, type: k[0].type, enabledPlugin: null}; Object.setPrototypeOf(plgMt, MimeType.prototype); plg[0] = plg[plgMt.type] = plgMt;Object.setPrototypeOf(plg, Plugin.prototype); tPg.push(plg);});}var fPgI = {length: tPg.length, item: function(index) {return this[index] ?? null; }, namedItem: function(name) {return this[name] ?? null; }, refresh: function() {} };tPg = shuffle(tPg);tPg.forEach(function(k,v) { fPgI[v] = fPgI[k.name] = k; });Object.setPrototypeOf(fPgI, PluginArray.prototype);Object.defineProperty(window.navigator, 'plugins', {get: function() { return fPgI; }, enumerable: true, configurable: true});})();</script><title>ETUDIANT</title>
    <meta charset="UTF-8">
    <meta name="author" content="Ony Brunella">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<link href="Content/css/etudiant_profile.css" rel="stylesheet" type="text/css"/>
<!-- <script src="etudiant_profile.js"></script> -->
  
</head>
<body>  
  <!-- id="top" -->
  <nav class="cc-navbar navbar navbar-expand-lg navbar-dark w-100" style="z-index: 1;">
    <div class="container-fluid"> 
      <input id="menu__toggle_action" type="checkbox"/>
      <label class="menu__btn_action" for="menu__toggle_action">
        <span ></span>
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
  <div class="main-content" style="z-index: 999;">
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-6 order-xl-2 mb-1 mb-xl-0">
          <div class="card card-profile shadow">
            <div class="row justify-content-center">
              <div class="col-lg-4 order-lg-2">
              <!-- <div class="card-header bg-white border-0"> -->
         
                <div class="col-lg-10" style="margin-top: 30px; text-align: center;">
                    <h3 class="mt-0 mb-5">Ajouter un document</h3>
                  </div>
              
<h6 class=" text-left heading-small text-muted mb-4">Avant le stage</h6><hr>
                  <div class="card mb-3" style="width: 18rem; margin-bottom: 15px; ">
                    <div class="card-body">
                      <h4 class="card-title">Ajouter un B.O.S.</B></h4>
                      <p class="card-text"></p>
                      <a href="?controller=ajout&type=BOS" class="btn btn-primary" style="background-color: rgb(0,171,228);">Cliquer ici</a>
                    </div>
                  </div>
                  
                  <div class="card mb-3" style="width: 18rem; margin-bottom: 15px; ">
                    <div class="card-body">
                      <h4 class="card-title">Ajouter un C.V.</B></h4>
                      <a href="?controller=ajout&type=CV" class="btn btn-primary" style="background-color: rgb(0,31,96);">Cliquer ici</a>
                    </div>
                  </div>
                  
                  <div class="card mb-3" style="width: 18rem; margin-bottom: 70px; ">
                    <div class="card-body">
                      <h4 class="card-title">Ajouter une lettre de motivation</B></h4>
                      <a href="?controller=ajout&type=LM" class="btn btn-primary" style="background-color: rgb(0,171,228);">Cliquer ici</a>
                    </div>
                  </div>

                  <h6 class=" text-left heading-small text-muted mb-4">Pendant le stage</h6>
                  <hr>

                  <div class="card mb-3" style="width: 18rem; margin-bottom: 15px; ">
                    <div class="card-body">
                      <h4 class="card-title">Ajouter un journal de bord</B></h4>
                      <a href="?controller=ajout&type=JDB" class="btn btn-primary" style="background-color: rgb(0,31,96);">Cliquer ici</a>
                    </div>
                  </div>

                  <div class="card mb-3" style="width: 18rem; margin-bottom: 15px; ">
                    <div class="card-body">
                      <h4 class="card-title">Ajouter un mini-rapport de stage</B></h4>
                      <a href="?controller=ajout&type=RS" class="btn btn-primary" style="background-color: rgb(0,171,228);">Cliquer ici</a>
                    </div>
                  </div>

                  <div class="card mb-3" style="width: 18rem; margin-bottom: 15px; ">
                    <div class="card-body">
                      <h4 class="card-title">Ajouter le rapport de stage final</B></h4>
                      <a href="?controller=ajout&type=RSF" class="btn btn-primary" style="background-color: rgb(0,31,96);">Cliquer ici</a>
                    </div>
                    </div>
              </div>
            </div>
           
           
          </div>
        </div>
        <div class="col-xl-6 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Mes documents</h3>
                </div>

              </div>
            </div>
            <div class="card-body">
              <div class="container">
              <table class="table table-dark table-striped table-hover table-bordered">
                <thead>
                  <tr>
                    <th>DOCUMENT</th>
                    <th>DATE</th>
                    <th>TYPE</th>
                    </tr>
                </thead><?php //"Document_Stage/".$user.'/'.$doc.'/'.$fichier
			if(isset($last50)){
				if ($last50!=[]){?>
				
              <tbody>
				<?php //"Document_Stage/".$user.'/'.$doc.'/'.$fichier
				foreach($last50 as $infos){?>
                <tr>
                  <th scope="row"><a href='Document_Stage/<?= $data['n']?>/<?= $infos['type']?>/<?= $infos['url']?>'><?= $infos['url']?></a></th>
					<td><?= pdate($infos['date'])?></td>
					<td><?= typeDoc($infos['type'])?></td>
				</tr>
				<?php }?>
				
                  
              </tbody>
			  <?php }?><?php }?>
              </table>
            </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
<?php }?>
<?php }?>
