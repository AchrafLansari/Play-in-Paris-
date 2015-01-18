

<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="fr"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="fr"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="fr"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="fr"> <!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Intégration API Twitter 1.1 | NOE interactive</title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="skinNoe/skin.css" />

<meta name='robots' content='noindex,nofollow' />
<link rel='stylesheet' id='demo-css'  href='twitterapi.css' type='text/css' media='all' />

<meta name="description" content="How to use the latest Twitter 1.1 API, by NOE Interactive, by NOE Interactive" />
<meta name="keywords" content="Twitter, oAuth, NOE Interactive, php" />
<link rel="canonical" href="http://noe-interactive.com/demo/!/twitterapi"/>
<script type="text/javascript" src="http://dev.chez-syl.fr/drag_and_drop/js/jquery.js"></script>
<script type="text/javascript" src="drag.js"></script>';
</head>

<body class="page lang-fr">


          
                <?php
				
		session_start();
                    //1 - Settings (please update to math your own)
                    $consumer_key='bZVCiUXhg3VLyRJrN5IgMZQtT'; //Provide your application consumer key
                    $consumer_secret='ZbUYpG1mT1GzGhYISFwiRwO7LppJ5liUvZwM18EDR4sI4YZGlB'; //Provide your application consumer secret
                    $oauth_token = '2926738149-QbmKrWzZu4ZNmXaOS01N1tljUUVD2vFE8pnQbkh'; //Provide your oAuth Token
                    $oauth_token_secret = '1ZkmbUPcJ2SdyvPmtB4wlYLtJ6qUvrslth8BzogD8VVOT'; //Provide your oAuth Token Secret
					  
                    //You can now copy paste the folowing

                    if(!empty($consumer_key) && !empty($consumer_secret) && !empty($oauth_token) && !empty($oauth_token_secret)) {

                    //2 - Include @abraham's PHP twitteroauth Library
                    require_once('twitteroauth/twitteroauth.php');

                    //3 - Authentication
                    /* Create a TwitterOauth object with consumer/user tokens. */
                    $connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);

                    //4 - Start Querying
                    $query = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=play_in_paris&count=10"; //Your Twitter API query
                    $content = $connection->get($query);
						//var_dump ($content) ;

                    }
                   

                    if(!empty($consumer_key) && !empty($consumer_secret) && !empty($oauth_token) && !empty($oauth_token_secret)) {
                        
                            if(!empty($content)){ 
                              $tweet = $content [rand(0,count($content))];
								
								
                            }
                                
                    } else {
                        echo'<p>Please update your settings to provide valid credentials</p>';
                    }
                    echo '</div>';
							echo'<link rel="stylesheet" type="text/css" href="drag.css">';
					
					
								$phrase= $tweet->text ;
 								$_SESSION['phrase']=$phrase;
								$sentence = preg_split("/[?!\s]/", $phrase);
								
								//var_dump ($sentence);
								echo $taille= count($sentence);
								
									echo '<ul id="liste">';
								//$tab_correct=$sentence ;
//var_dump($tab_correct);
								shuffle ($sentence) ;
								
								
								for ($i = 0; $i < $taille; $i++) 
								{
									echo'<li draggable="true" id="'.$i.'">'.$sentence[$i].'</li>';
								}
								echo "<br><br><br><br>";
//								
									echo"</ul>";
//var_dump ($phrase);
						
						


			
				

/*
 * Transform Tweet plain text into clickable text
 */
function parseTweet($text) {
    $text = preg_replace('#http://[a-z0-9._/-]+#i', '<a  target="_blank" href="$0">$0</a>', $text); //Link
    $text = preg_replace('#@([a-z0-9_]+)#i', '@<a  target="_blank" href="http://twitter.com/$1">$1</a>', $text); //usernames
    $text = preg_replace('# \#([a-z0-9_-]+)#i', ' #<a target="_blank" href="http://search.twitter.com/search?q=%23$1">$1</a>', $text); //Hashtags
    $text = preg_replace('#https://[a-z0-9._/-]+#i', '<a  target="_blank" href="$0">$0</a>', $text); //Links
    return $text;
}

                ?>
            </section>
        </div>
    </article>
</section>
	</div><!-- #main -->

	<div class="visualClear"></div>


 </div><!-- #wrapper -->
<div id="output"></div>
</body>
</html>