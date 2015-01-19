<?php


//Function découpage chaine de caratères// 
function tokenisation ($separateurs, $texte)
{
	$arrayElements = array();
	
	$tok = strtok($texte, $separateurs);

	while ($tok !== false) 
	{
		if( strlen($tok) > 2 )$arrayElements[] = $tok;
		$tok = strtok($separateurs);
	}
	return $arrayElements;
}

//Afficher un tableau
function print_tab($tab_mots)
{
	foreach ( $tab_mots  as  $position => $valeur )
	{
		echo $position , " => " , $valeur,  "<br>" ;
	}
}

//Récupération du title
function  get_title($html)
{
	$modele = '/<title>(.*)<\/title>/i' ;

	preg_match($modele, $html, $tab_resultat) ;

    return $tab_resultat[1];
}

?>