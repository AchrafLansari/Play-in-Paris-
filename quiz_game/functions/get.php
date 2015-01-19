<?php

require_once(__DIR__.'/allocine.class.php');

function get_title ($json)
{
return $json->{'movie'}->{'originalTitle'};	
}
function get_synopsis ($json)
{
  if(isset($json->{'movie'}->{'synopsis'})){
return $json->{'movie'}->{'synopsis'};
    }else 
        return '';
}
function get_trailer ($json)
{
return $json->{'movie'}->{'trailer'}->{'href'};


}



?>