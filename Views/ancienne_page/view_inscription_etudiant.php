<?php require "view_begin.php"; ?>

    

      <div class="form-header">
        <h1>Créer un compte</h1>
      </div>
        <form action="?controller=inscription&action=inscription" method="post">
            <div class="page" id="page1">
                <h3>Identité</h3>
                <div>
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div>
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>
                <div class="box">
                <label for="departement">Département</label>
                <select name="departement">
                    <option selected>Département</option>
                <option>Informatique</option>
              </select>
            </div>
            <div class="box">
              <label for="formation">Formation scolaire</label>
              <select name="formation">
                <option selected>Formation</option>
              <option>But2Info</option>
            </select>
        </div>
              
              <div>
                <label for="groupe">Groupe :</label>
                <input type="text" id="groupe" name="groupe" required>
                </div>  
                       </div> -->
                
                <button class="next" type="button">Suivant</button>
            </div>
            <div class="page" id="page2">

                <h3>Informations personnelles</h3>

                <label for="date_naissance">Date de naissance :</label>
                <select name="date_naissance" id="date_naissance_jour">
<option value="-1">Jour :</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
</select>
<select name="date_naissance" id="date_naissance_mois">
<option value="-1">Mois :</option>
<option value="January">Janvier</option>
<option value="February">Février</option>
<option value="March">Mars</option>
<option value="April">Avril</option>
<option value="May">Mai</option>
<option value="June">Juin</option>
<option value="July">Juillet</option>
<option value="August">Août</option>
<option value="September">Septembre</option>
<option value="October">Octobre</option>
<option value="November">Novembre</option>
<option value="December">Décembre</option>
</select>
<select name="date_naissance" id="date_naissance_annee">
<option value="-1">Année :</option>
<option value="2019">2019</option>
<option value="2018">2018</option>
<option value="2017">2017</option>
<option value="2016">2016</option>
<option value="2015">2015</option>
<option value="2014">2014</option>
<option value="2013">2013</option>
<option value="2012">2012</option>
<option value="2011">2011</option>
<option value="2010">2010</option>
<option value="2009">2009</option>
<option value="2008">2008</option>
<option value="2007">2007</option>
<option value="2006">2006</option>
<option value="2005">2005</option>
<option value="2004">2004</option>
<option value="2003">2003</option>
<option value="2002">2002</option>
<option value="2001">2001</option>
<option value="2000">2000</option>
<option value="1999">1999</option>
<option value="1998">1998</option>
<option value="1997">1997</option>
<option value="1996">1996</option>
<option value="1995">1995</option>
<option value="1994">1994</option>
<option value="1993">1993</option>
<option value="1992">1992</option>
<option value="1991">1991</option>
<option value="1990">1990</option>
<option value="1989">1989</option>
<option value="1988">1988</option>
<option value="1987">1987</option>
<option value="1986">1986</option>
<option value="1985">1985</option>
<option value="1984">1984</option>
<option value="1983">1983</option>
<option value="1982">1982</option>
<option value="1981">1981</option>
<option value="1980">1980</option>
</select>
<!--<div>
    <label for="tel">Téléphone :</label>
    <input type="tel" id="tel" name="tel" required>
</div>-->
                <div>
                    <label for="email">E-mail :</label>
                    <input type="email" id="email" name="email" required>
                </div>
                    <!--<label for="sexe">Sexe :</label>

                    <div class="radio">
                        <input id="homme" name="sexe" type="radio">
                        <label  for="sexe" class="radio-label">Homme</label>
                    </div>
                    <div class="radio">
                        <input id="femme" name="sexe" type="radio" checked>
                        <label for="sexe" class="radio-label">Femme</label>
                    </div>-->

                <!--<div>
                    <label for="adresse">Adresse :</label>
                    <input type="text" id="adresse" name="adresse" required>
                </div>
                <div>
                    <label for="cp">Code postal :</label>
                    <input type="text" id="cp" name="cp" required>
                </div>
                <div>
                    <label for="ville">Ville :</label>
                    <input type="text" id="ville" name="ville" required>
                </div>-->
                <button class="prev" type="button">Précédent</button>
                <button class="next" type="button">Suivant</button>
            </div>

            <div class="page" id="page3">
                <h3>Identifiants</h3>
                <div>
                    <label for="num_etud">Numéro étudiant :</label>
                    <input type="text" id="num_etud" name="num_etud" required>
                </div>
                <div>
                    <label for="pass">Mot de passe :</label>
                    <input type="password" id="pass" name="pass" required>
                </div>
                <div>
                    <label for="pass1">Confirmer le mot de passe :</label>
                    <input type="password" id="pass1" name="pass1" required>
                </div>
                <button class="prev" type="button">Précédent</button>
                <button>Terminer</button>
            </div>
        </form>
    
    <script src="Content/js/inscription_etudiant.js"></script>
    <!--Réalisé par Ony -->
	<?php require "view_end.php"; ?>