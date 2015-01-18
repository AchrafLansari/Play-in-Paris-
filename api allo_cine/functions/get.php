<?php

require_once(__DIR__.'/allocine.class.php');

function get_title ($json)
{
return $json->{'movie'}->{'originalTitle'};	
}
function get_synopsis ($json)
{
return $json->{'movie'}->{'synopsis'};
}
function get_trailer ($json)
{
return $json->{'movie'}->{'trailer'}->{'href'};


}



?>