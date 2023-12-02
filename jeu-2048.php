<!doctype html>
<?php 
$zero = 0;
$score = 0;
$grille = array();
$fin = false;
//  array_fill(0,4,array_fill(0,4,0));;
require_once 'fonction.php';
?>                                          <!--accès aux fonctions du fichier fonction.php-->

<!--jeu-2048.php-->
<html>
<head>
    <link rel="icon" type="image/png" sizes="16x16" href="https://www.1formatik.com/images/favicon/favicon-16x16.png"
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2048.css">
    <title> 2048 </title>
</head>

<body>
    <?php
        if(isset($_GET['action-joueur-reset']))
        { 
            nouvelle_partie();
        } else {
            fichier_vers_matrice();
            matrice_vers_fichier(); 
            $score=fichier_vers_score();
        }
    
//    initmatrice()
    ?>
    <div class="grand">
    <h1 class="title">
            2048
    </h1>
    <div class="score">                                             <!--SCORE-->
        SCORE
        <br />
        <?php 
        affiche_score();
        ?>
        </div>
    </div>
    <form name="2048" method="get" action="jeu-2048.php">             <!--formulaire-->
    <div class="bouton1">                                                               <!--clavier-->
    <input type="submit" name="action-joueur-haut" value="^" />
    </div>
    <div class="bouton2">
    <input type="submit" name="action-joueur-gauche" value="<" />
    <input type="submit" name="action-joueur-bas" value="v" />
    <input type="submit" name="action-joueur-droite" value=">" />
    </div>
    <?php
    testfin();
    message_bouton ();
    //echo "<pre>".print_r($grille, true)."</pre>";  //affiche le tableau
    ?>
    <div class="grille">                                                 <!--JEU-->
        <br/>
        <div class="ligne">
            <div class="cellule"><?php affiche_case(0,0) ?></div>
            <div class="cellule"><?php affiche_case(0,1) ?></div>
            <div class="cellule"><?php affiche_case(0,2) ?></div>
            <div class="cellule"><?php affiche_case(0,3) ?></div>
        </div>
        <div class="ligne">
            <div class="cellule"><?php affiche_case(1,0) ?></div>
            <div class="cellule"><?php affiche_case(1,1) ?></div>
            <div class="cellule"><?php affiche_case(1,2) ?></div>
            <div class="cellule"><?php affiche_case(1,3) ?></div>
        </div>
        <div class="ligne">
            <div class="cellule"><?php affiche_case(2,0) ?></div>
            <div class="cellule"><?php affiche_case(2,1) ?></div>
            <div class="cellule"><?php affiche_case(2,2) ?></div>
            <div class="cellule"><?php affiche_case(2,3) ?></div>
        </div>
        <div class="ligne">
            <div class="cellule"><?php affiche_case(3,0) ?></div>
            <div class="cellule"><?php affiche_case(3,1) ?></div>
            <div class="cellule"><?php affiche_case(3,2) ?></div>
            <div class="cellule"><?php affiche_case(3,3) ?></div>
        </div>
    </div>
    <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

    <br/>
    <div class="reset">                                             <!--NEW GAME-->
            <!--<a href="https://lifasr2.univ-lyon1.fr/axel.vaganay/jeu-2048/jeu-2048.php">New Game</a>-->
            <a> <input type="submit" name="action-joueur-reset" value="New Game" /></a>
        </div>
    <div class="reponse">
    <?php
    //message_bouton();                                                                //appel fonction boutons dans "fonction.php"
    ?>          
    </div>
    <br/>
    <div class="regle">                                                 <!--REGLE-->
        Le but du jeu est de faire glisser les tuiles sur la grille, pour combiner les tuiles de memes valeurs et creer ainsi une tuile portant le nombre 2048.
    </div>
    <br/>
    </form>
    <div class="lien">
    <a href="http://perso.univ-lyon1.fr/olivier.gluck/supports_enseig.html#LIFASR2">SITE WEB TP</a>             <!--LIEN-->
    </div>
</body>
</html>
