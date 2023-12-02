<!-- <!doctype html>
<html>
<head>
<meta http-equiv="refresh" content="5" />
</head>
</html> -->
<?php 
//include 'jeu-2048.php';                     //pour utiliser la variable globale score

function grille_pleine()
{
    global $grille;
    for ($i = 0 ; $i <= 3;$i++)
    {
        for ($j = 0 ; $j <= 3;$j++)
        {
            if($grille[$i][$j]==0)
            { 
                return false;
            }
        }
    }
    return true;
}

function message_bouton () 
{
    if(isset($_GET['action-joueur-haut']))
    {
        write_log("HAUT");
        decale_haut();
        fusion_haut();
        place_nouveau_nb();
        fichier_vers_matrice();
    }
    if(isset($_GET['action-joueur-gauche']))
    {
        write_log("GAUCHE");
        decale_gauche();
        fusion_gauche();
        place_nouveau_nb();
        fichier_vers_matrice();
        
    }
    if(isset($_GET['action-joueur-bas']))
    {
        write_log("BAS");
        decale_bas();
        fusion_bas();
        place_nouveau_nb();
        fichier_vers_matrice();
    }
    if(isset($_GET['action-joueur-droite']))
    {
        write_log("DROITE");
        decale_droite();
        fusion_droite();
        place_nouveau_nb();
        fichier_vers_matrice();
    }
    if(isset($_GET['action-joueur-reset']))
    {
        write_log("RESET");
    }
}

function affiche_score ()
{
    // $temp = 0;
    global $score;
    $score = fichier_vers_score();
    echo $score;
    // $temp = fichier_vers_score();
    // $temp++;
    // score_vers_fichier($temp);
    // echo $temp;
}

function score_vers_fichier($input)
{
    // global $score;
    // if(isset($_GET['action-joueur-reset']))
    // { 
    file_put_contents('score.txt', $input);
    // }
}

function fichier_vers_score()
{
    // if(isset($_GET['action-joueur-reset']))
    // { 
    return trim(file_get_contents('score.txt'));
    // }

}

function write_log($mesg)
{
    file_put_contents('logs-2048.txt' , $mesg."\n" ,FILE_APPEND);
}

function affiche_logs($nbl) 
{
    $logs = file('logs-2048.txt');
    foreach ($logs as $i => $line) {
        echo "Ligne " . ($i+1) . " : " . htmlspecialchars($line) . "<br />\n";
    }
}

function initmatrice()      //inutile
{
    global $grille;
    for ($i = 0 ; $i <= 3;$i++)
    {
        $grille[$i] = array();
        for ($j = 0 ; $j <= 3;$j++)
        {
            $grille [$i][$j] = 0;
        }
    }
    matrice_vers_fichier();
}

function nouvelle_partie()
{
    global $zero;
    global $score;
    global $grille;
    score_vers_fichier($zero);
    $score = fichier_vers_score();
    // echo $score;
    // $grille = array();
    for ($i = 0 ; $i <= 3;$i++)
    {
        $grille[$i] = array();
        for ($j = 0 ; $j <= 3;$j++)
        {
            $grille [$i][$j] = 0;
        }
    }
    $res = array();
    $res = tirage_position_vide();
    $x=$res[0];
    $y=$res[1];
    $grille[$x][$y]=2;
    $r = array();
    $r = tirage_position_vide();
    $x=$r[0];
    $y=$r[1];
    $grille[$x][$y]=2;
    matrice_vers_fichier();
}

function matrice_vers_fichier()
{
    global $grille;
    file_put_contents('grille.txt', "\n");
    for ($i = 0 ; $i <= 3;$i++)
    {
        for ($j = 0 ; $j <= 3;$j++)
        {
            file_put_contents('grille.txt', $grille [$i][$j], FILE_APPEND);
            file_put_contents('grille.txt', " ", FILE_APPEND);
        }
        file_put_contents('grille.txt', "\n", FILE_APPEND);
    }
}

function fichier_vers_matrice()
{
    global $grille;
    // $chaine va contenir tout ce qu'il y a dans le fichier 'grille.txt'
    $chaine = file_get_contents('grille.txt');
    // on remplace dans $chaine tous les sauts de ligne par des espaces
    $chaine = str_replace("\n", " ", $chaine);
    // $valeurs est un tableau 1D qui va contenir tous les nombres de la grille
    $valeurs = explode(' ', $chaine);
    $n = 1;
    for ($i = 0; $i <= 3 ; $i++)
    {
	    for ($j = 0; $j <= 3; $j++) 
	    {
		    $grille[$i][$j] = (int) ($valeurs[$n]);
		    $n++;
	    }
	    $n++;
    }   
}

function affiche_case($i,$j)
{
    global $grille;
    $val = $grille [$i][$j];
    if ($grille [$i][$j]!=0)
    {
		switch ($grille[$i][$j]) 
		{ 
		case 2: echo "<div class='c2'> $val </div>"; break;
		case 4: echo "<div class='c4'> $val </div>"; break;
		case 8: echo "<div class='c8'> $val </div>"; break;
		case 16: echo "<div class='c16'> $val </div>"; break;
		case 32: echo "<div class='c32'> $val </div>"; break;
		case 64: echo "<div class='c64'> $val </div>"; break;
		case 128: echo "<div class='c128'> $val </div>"; break;
		case 256: echo "<div class='c256'> $val </div>"; break;
		case 512: echo "<div class='c512'> $val </div>"; break;
		default: echo "<div class='c0'> $val </div>"; break;
		}
        //echo $grille [$i][$j];
    }
    else 
    {
        echo " ";
        //echo 0;
    }
}

function tirage_position_vide()
{ 
    global $grille;
    global $fin;
    $bon = false;
    for ($i = 0; $i <= 3 ; $i++)
    {
	    for ($j = 0; $j <= 3; $j++) 
	    {
            if($grille[$i][$j]==0)
            {
                $bon = true;
                break;
            }
        }
        if ($bon) {
            break;
        }
    }

    if ($bon) {
        do{
            $i=rand(0, 3);
            $j=rand(0, 3);
        }
        while($grille[$i][$j]!=0);
        $res = array();
        $res[0] = $i;
        $res[1] = $j;
        return $res;
    } else {
        $fin=true;     //inutile
        echo "<div class='fin' > !!!PERDU!!! </div>";
    }

}

function tirage_2ou4()
{
    $res=rand(1,2);
    $res=$res*2;
    return $res;
}

function place_nouveau_nb()
{
    global $grille;
    global $fin;
    $position = array();
    $position = tirage_position_vide();
    $x=$position[0];
    $y=$position[1];
    $grille[$x][$y]=tirage_2ou4();
    matrice_vers_fichier();
}

function decale_ligne_gauche($l)
{
    global $grille;
    $ligne = array_fill(0,4,0);
    $i = 0;
    for ($j = 0; $j < 4; $j++)
    {
	    if ($grille[$l][$j] != 0)
	    {
		$ligne[$i] = $grille[$l][$j];
		$i++;
	    }
    }
$grille[$l] = $ligne;
}

function decale_gauche()
{
    for($l=0;$l<=3;$l++)
    {
        decale_ligne_gauche($l);
    }
    matrice_vers_fichier(); 
    

}

function decale_ligne_droite($l)
{
    global $grille;
    $ligne = array_fill(0,4,0);
    $i = 3;
    for ($j = 3; $j >= 0; $j--)
    {
	    if ($grille[$l][$j] != 0)
	    {
		$ligne[$i] = $grille[$l][$j];
		$i--;
	    }
    }
$grille[$l] = $ligne;
}

function decale_droite()
{
    for($l=0;$l<=3;$l++)
    {
        decale_ligne_droite($l);
        matrice_vers_fichier(); 
    }
}

function decale_col_haut($c)
{
    global $grille;
    $colonne = array_fill(0,4,0);
    $i = 0;
    for ($j = 0; $j < 4; $j++)
    {
	    if ($grille[$j][$c] != 0)
	    {
		$colonne[$i] = $grille[$j][$c];
		$i++;
	    }
    }
	for ($x=0; $x<4; $x++)
	{
			$grille[$x][$c]=$colonne[$x];
		
	}
}

function decale_haut()
{
    for($c=0;$c<=3;$c++)
    {
        decale_col_haut($c);
        matrice_vers_fichier(); 
    }
}

function decale_col_bas($c)
{
    global $grille;
    $colonne = array_fill(0,4,0);
    $i = 3;
    for ($j = 3; $j >= 0; $j--)
    {
	    if ($grille[$j][$c] != 0)
	    {
		$colonne[$i] = $grille[$j][$c];
		$i--;
	    }
    }
	for ($x=0; $x<4; $x++)
	{
			$grille[$x][$c]=$colonne[$x];
	}
}

function decale_bas()
{
    for($c=0;$c<=3;$c++)
    {
        decale_col_bas($c);
        matrice_vers_fichier(); 
    }
}

function fusion_ligne_gauche($l)
{
    global $grille;
    global $score;
    if ($grille[$l][0] == $grille[$l][1])
    {
	    $grille[$l][0] = 2 * $grille[$l][0];
	    $grille[$l][1] = 0;
        $score = $score + $grille[$l][0];
        score_vers_fichier($score);
	    if ($grille[$l][2] == $grille[$l][3])
	    {
		    $grille[$l][2] = 2 * $grille[$l][2];
		    $grille[$l][3] = 0;
            $score = $score + $grille[$l][2];
            score_vers_fichier($score);	
	    }		
    }
    else if ($grille[$l][1] == $grille[$l][2])
    {
	    $grille[$l][1] = 2 * $grille[$l][1];
	    $grille[$l][2] = 0;
        $score = $score + $grille[$l][1];
        score_vers_fichier($score);
    }	
    else if ($grille[$l][2] == $grille[$l][3])
    {
	    $grille[$l][2] = 2 * $grille[$l][2];
	    $grille[$l][3] = 0;
        $score = $score + $grille[$l][2];
        score_vers_fichier($score);
    }	
}

function fusion_gauche()
{
	global $score;
    for($l=0;$l<=3;$l++)
    {
        fusion_ligne_gauche($l);
        matrice_vers_fichier(); 
    }
    $score=fichier_vers_score();
}

function fusion_ligne_droite($l)
{
    global $grille;
    global $score;
    if ($grille[$l][0] == $grille[$l][1])
    {
	    $grille[$l][0] = 0;
	    $grille[$l][1] = 2 * $grille[$l][1];
        $score = $score + $grille[$l][1];
        score_vers_fichier($score);
	    if ($grille[$l][2] == $grille[$l][3])
	    {
		    $grille[$l][2] = 0;
		    $grille[$l][3] = 2 * $grille[$l][3];
            $score = $score + $grille[$l][3];	
            score_vers_fichier($score);	
	    }		
    }
    else if ($grille[$l][1] == $grille[$l][2])
    {
	    $grille[$l][1] = 0;
	    $grille[$l][2] = 2 * $grille[$l][2];
        $score = $score + $grille[$l][2];
        score_vers_fichier($score);
    }	
    else if ($grille[$l][2] == $grille[$l][3])
    {
	    $grille[$l][2] = 0;
	    $grille[$l][3] = 2 * $grille[$l][3];
        $score = $score + $grille[$l][3];
        score_vers_fichier($score);
    }	
}

function fusion_droite()
{
	global $score;
    for($l=0;$l<=3;$l++)
    {
        fusion_ligne_droite($l);
        matrice_vers_fichier(); 
    }
    $score=fichier_vers_score();
}

function fusion_colonne_haut($c)
{
    global $grille;
    global $score;
    if ($grille[0][$c] == $grille[1][$c])
    {
	    $grille[0][$c] = 2 * $grille[0][$c];
	    $grille[1][$c] = 0;
        $score = $score + $grille[0][$c];
        score_vers_fichier($score);
	    if ($grille[2][$c] == $grille[3][$c])
	    {
		    $grille[2][$c] = 2 * $grille[2][$c];
		    $grille[3][$c] = 0;		
            $score = $score + $grille[2][$c];
            score_vers_fichier($score);
	    }		
    }
    else if ($grille[1][$c] == $grille[2][$c])
    {
	    $grille[1][$c] = 2 * $grille[1][$c];
	    $grille[2][$c] = 0;
        $score = $score + $grille[1][$c];
        score_vers_fichier($score);
    }	
    else if ($grille[2][$c] == $grille[3][$c])
    {
	    $grille[2][$c] = 2 * $grille[2][$c];
	    $grille[3][$c] = 0;
        $score = $score + $grille[2][$c];
        score_vers_fichier($score);
    }	
}

function fusion_haut()
{
	global $score;
    for($c=0;$c<=3;$c++)
    {
        fusion_colonne_haut($c);
        matrice_vers_fichier(); 
    }
    $score=fichier_vers_score();
}

function fusion_colonne_bas($c)
{
    global $grille;
    global $score;
    if ($grille[0][$c] == $grille[1][$c])
    {
	    $grille[0][$c] = 0;
	    $grille[1][$c] = 2 * $grille[1][$c];
        $score = $score + $grille[1][$c];
        score_vers_fichier($score);
	    if ($grille[2][$c] == $grille[3][$c])
	    {
		    $grille[2][$c] = 0;
		    $grille[3][$c] = 2 * $grille[3][$c];		
            $score = $score + $grille[3][$c];
            score_vers_fichier($score);
	    }		
    }
    else if ($grille[1][$c] == $grille[2][$c])
    {
	    $grille[1][$c] = 0;
	    $grille[2][$c] = 2 * $grille[2][$c];
        $score = $score + $grille[2][$c];
        score_vers_fichier($score);
    }	
    else if ($grille[2][$c] == $grille[3][$c])
    {
	    $grille[2][$c] = 0;
	    $grille[3][$c] = 2 * $grille[3][$c];
        $score = $score + $grille[3][$c];
        score_vers_fichier($score);
    }	
}

function fusion_bas()
{
	global $score;
    for($c=0;$c<=3;$c++)
    {
        fusion_colonne_bas($c);
        matrice_vers_fichier(); 
    }
   $score=fichier_vers_score();
}

function testfin()     //inutile
{
    global $fin;
    if($fin)
    {
        echo "<div class='fin' > !!!PERDU!!! </div>";
    }
}
?>
