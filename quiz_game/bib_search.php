<?php
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
?>