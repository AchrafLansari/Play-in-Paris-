<?php
require_once(__DIR__.'/allocine.class.php');


function recup_id_films($tab_films,$allocine)
{
$choix =$tab_films[rand(0,sizeof($tab_films)-1)] ;
var_dump($choix);
$result = $allocine->search(utf8_decode($choix));
var_dump($result);

$myjson = json_decode($result);
$id_film = $myjson->{'feed'}->{'movie'}[0]->{'code'};

return $id_film ;
}
function recup_choix ($tab_films,$allocine)
{
$choix =$tab_films[rand(0,sizeof($tab_films))] ;
$result = $allocine->search($tab_films[rand(0,sizeof($tab_films))]);
return $choix;
}
function recup_choix_option ($tab_films,$allocine)
{
$choix_option =$tab_films[rand(0,sizeof($tab_films))] ;
$result_option = $allocine->search($tab_films[rand(0,sizeof($tab_films))]);
return $choix_option;
}
function recup_choix_option_1 ($tab_films,$allocine)
{
$choix_option_1 =$tab_films[rand(0,sizeof($tab_films))] ;
$result_option_1 = $allocine->search($tab_films[rand(0,sizeof($tab_films))]);
return $choix_option_1;
}
function tokenisation ($separateurs, $texte)
{
	$arrayElements = array();
	
	$tok = strtok($texte, $separateurs);

	while ($tok !== false) 
	{
		if( strlen($tok) > 2 )$arrayElements[] = utf8_decode($tok);
		$tok = strtok($separateurs);
	}
	return $arrayElements;
}	
	


