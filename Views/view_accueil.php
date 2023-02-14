<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>SAE3.01 : Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel = "stylesheet" href="Content/css/accueil.css"/>
  </head>
  <body>
    <nav class="cc-navbar navbar navbar-expand-lg position-fixed navbar-dark w-100" >
        <div class="container-fluid">
          <a class="navbar-brand text-uppercase fw-bolder mx-4 py-3"  href="https://www.univ-paris13.fr/">USPN</a>
          <button class="navbar-toggler">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="#">Acceuil</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="#">A propos</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active " href="#">Vous etes</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active " href="#">Contact</a>
                </li>
                <li class="nav-item">
                  <a class="btn btn-order1 rounded-0" href="?controller=connexion"> Se connecter</a>
                </li>
            </ul>
          </div>
        </div>
      </nav>
      <section class="banner d-flex justify-content align-items-center pt-5">
          <div class="container my-5 py-5">
            <div class ="row">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <h1 class="text-principal py3 Redressed banner-desc">Bienvenue sur la plateforme de gestion de Stage</h1>
                    <p> 
                      <a href="?controller=connexion"><button class="btn btn-order1 ">Se connecter</button></a>
                    </p>
                    <img src="Content/img/SeeMore.png" class="SeeMore" alt="Voir plus"></img>
                </div>
            </div>
          </div>
      </section>
      <section cc-menu py-5 Montserrat>
        <div class = "container">
          <div class ="row">
            <h3>Vous Êtes</h3>
            <div class="row row-cols-1 row-cols-md-4 g-1">
              <div class="col">
                <div class="card h-90">
                  <img src="Content/img/face.png" class="card-img-top " alt="image d'utilisateur">
                  <div class="card-body">
                    <h5 class="text-center ">Etudiant</h5>
                    <p class="card-text">Vous avez le statut d'étudiant.</p>
                  </div>
                  <div class="card-footer">
                    <a href="?controller=connexion"><button class="btn btn-order ">Se connecter</button></a>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card h-90">
                  <img src="Content/img/face.png" class="card-img-top" alt="image d'utilisateur">
                  <div class="card-body">
                    <h5 class="text-center">Enseignant</h5>
                    <p class="card-text">Vous avez le statut d'Enseignant.</p>
                  </div>
                  <div class="card-footer">
                    <a href="?controller=connexion"><button class="btn btn-order ">Se connecter</button></a>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card h-90">
                  <img src="Content/img/face.png" class="card-img-top" alt="image d'utilisateur">
                  <div class="card-body">
                    <h5 class="text-center">Membre du secrétariat</h5>
                    <p class="card-text">Vous avez le statut de secrétaire.</p>
                  </div>
                  <div class="card-footer">
                    <a href="?controller=connexion"><button class="btn btn-order ">Se connecter</button></a>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card h-90">
                  <img src="Content/img/face.png" class="card-img-top" alt="image d'utilisateur">
                  <div class="card-body">
                    <h5 class="text-center">Coordinatrice de stage</h5>
                    <p class="card-text">Vous êtes coordinatrice de stage.</p>
                  </div>
                  <div class="card-footer">
                   <a href="?controller=connexion"><button class="btn btn-order ">Se connecter</button></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <div class = "container-info">
        <div class = "container-img">
          <img src="Content/img/Bibliotheque.JPEG" class="img-fluid" alt="image d'utilisateur">
        </div>
        <div class="container-txt">
            <h3 class="text-center">A Propos</h3>
            <p class="text">Le stage est une période d'activité professionnelle de mise en pratique des acquis et fondamentaux suivant la formation du stagiaire.<br>
              En effet, le stage est une expérience professionnalisante dans laquelle l’étudiant va découvrir le monde du travail. <br>Les étudiants seront amenés à suivre un stage durant leur 2ème ( 8 à 10 semaines en entreprises) et en 3ème années.
              Cette expérimentation au sein d’une entreprise permettra aux étudiants de monter en compétence, de découvrir l’univers du travail et représente un levier en termes de pré-recrutement.<br>
              De ce fait, les avantages sont multiples et vous permettront d’envisager au mieux votre poursuite d’étude et en contre partie votre insertion dans le monde professionnel.
              Le stage est une période d'activité professionnelle de mise en pratique des acquis et fondamentaux suivant la formation du stagiaire.<br>             
            </p>
            <div>
              <a href ="https://www.univ-paris13.fr/"><button class="btn btn-order " style ="margin-top:100px;" style ="justify-items: center;">Contactez-nous</button></a>
            </div>
        </div>        
      </div>
<!---footer-->
<div class="pop">
	<div class="cont"><h2>Contact</h2>
		<p>iutv-info-creip[at]univ-paris13.fr</p>
		<p>Sylvie.cardoso@univ-paris13.fr</p>
	</div>
	<div class="cont"><h2>Accès USPN</h2>
		<a href="https://cas.univ-paris13.fr/cas/login?service=https%3A%2F%2Fent.univ-paris13.fr">Ent</a>
		<a href="?controller=connexion">Me connecter</a>
		<a href="#">Inscription</a><!--?controller=inscription&action=inscription_etudiant-->
	</div>
	<div class="cont"><h2>Conditions générales</h2>
		<a href="#">Conditions</a>
	</div>
</div>
<!---footer-->
  </body>
</html>