<?php
 session_start();
if ($_POST)
						{
							$query=$_POST['requete'];
							$query_new=substr($query,0,-1);
							
							if ($query_new== $_SESSION['phrase'])
							{
								
								echo "You Win";
							}
						}
						else
						{
							header ('looks like an error');
							exit ();
						}
?>