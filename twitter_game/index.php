
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
                    require_once('../twitter_game/twitteroauth/twitteroauth.php');

                    //3 - Authentication
                    /* Create a TwitterOauth object with consumer/user tokens. */
                    $connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);

                    //4 - Start Querying
                    $query = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=play_in_paris&count=10"; //Your Twitter API query
                    $content = $connection->get($query);
						//var_dump ($content) ;

                    
                  
                            ?>
 





        <div id="columns">
          <?php
             if(!empty($consumer_key) && !empty($consumer_secret) && !empty($oauth_token) && !empty($oauth_token_secret)) {
                        
                            if(!empty($content)){ 
                              $tweet = $content [rand(0,count($content)-1)];
                              }
                             $phrase= $tweet->text ;
 								$_SESSION['phrase']=$phrase;
								$sentence = preg_split("/[?!\s]/", $phrase);
								
								//var_dump ($sentence);
								$taille= count($sentence);
                                                                shuffle ($sentence) ;
                                                                
                                                                $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
                                                                
                                                                for ($i = 0; $i < $taille; $i++) 
								{
                                                                  $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
                                                                  echo '<div class="column" draggable="true"  id="'.$i.'" style="background:'.$color.'" ><header>'.$sentence[$i].'</header></div>';
                                                                }
                          function parseTweet($text) {
                            $text = preg_replace('#http://[a-z0-9._/-]+#i', '<a  target="_blank" href="$0">$0</a>', $text); //Link
                            $text = preg_replace('#@([a-z0-9_]+)#i', '@<a  target="_blank" href="http://twitter.com/$1">$1</a>', $text); //usernames
                            $text = preg_replace('# \#([a-z0-9_-]+)#i', ' #<a target="_blank" href="http://search.twitter.com/search?q=%23$1">$1</a>', $text); //Hashtags
                            $text = preg_replace('#https://[a-z0-9._/-]+#i', '<a  target="_blank" href="$0">$0</a>', $text); //Links
                            return $text;
                          }
             }
            }
          ?>
        </div>
        <div id="output"></div>
    <script>
  var dragSrcEl = null;

function handleDragStart(e) {
  // Target (this) element is the source node.
  //this.style.opacity = '0.4';

  dragSrcEl = this;

  e.dataTransfer.effectAllowed = 'move';
  e.dataTransfer.setData('text/html', this.innerHTML);
}

function handleDragOver(e) {
  if (e.preventDefault) {
    e.preventDefault(); // Necessary. Allows us to drop.
  }

  e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.

  return false;
}

function handleDragEnter(e) {
  // this / e.target is the current hover target.
  this.classList.add('over');
}

function handleDragLeave(e) {
  this.classList.remove('over');  // this / e.target is previous target element.
}

function handleDrop(e) {
  // this/e.target is current target element.
  
   
  if (e.stopPropagation) {
    e.stopPropagation(); // Stops some browsers from redirecting.
  }

  // Don't do anything if dropping the same column we're dragging.
  if (dragSrcEl != this) {
    // Set the source column's HTML to the HTML of the column we dropped on.
    dragSrcEl.innerHTML = this.innerHTML;
    this.innerHTML = e.dataTransfer.getData('text/html');
  }
  
  var mot="" , dataString;
			$( ".column" ).each(function( index ) {
  			 mot+= $( this ).text() +" ";
				});
			dataString ='requete='+mot;
			
			$.ajax({
				  url: '../twitter_game/ajax.php',
				  data: dataString,
				type : 'POST' ,
				dataType:'html',
				success:function(data)
					{
						$( '#output' ).append(data);
						var id = <?php echo $_GET['id']?>;

						if(data != ""){
							piafLayer.removeLayer(id);
						}
					}
				});
  return false;
}

function handleDragEnd(e) {
  // this/e.target is the source node.

  [].forEach.call(cols, function (col) {
    col.classList.remove('over');
  });
}

var cols = document.querySelectorAll('#columns .column');
[].forEach.call(cols, function(col) {
  col.addEventListener('dragstart', handleDragStart, false);
  col.addEventListener('dragenter', handleDragEnter, false)
  col.addEventListener('dragover', handleDragOver, false);
  col.addEventListener('dragleave', handleDragLeave, false);
  col.addEventListener('drop', handleDrop, false);
  col.addEventListener('dragend', handleDragEnd, false);
});

</script>

