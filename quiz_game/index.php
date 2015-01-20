<?php
header('charset=utf-8');
include_once('../quiz_game/functions/search.php');
include_once('../quiz_game/functions/get.php');
require_once('../quiz_game/functions/allocine.class.php');

define('ALLOCINE_PARTNER_KEY', '100043982026');
define('ALLOCINE_SECRET_KEY', '29d185d98c984a359e6e6f26a0474269');

$allocine = new Allocine(ALLOCINE_PARTNER_KEY, ALLOCINE_SECRET_KEY);


$film_search=file_get_contents("../quiz_game/liste_film.txt") ;
$tab_films  = tokenisation("\n", $film_search );
$tab_films = array_map('rtrim', $tab_films);
$result = array();
$myjson = array();

for($i=0;$i<3;$i++){
    $result[$i] = $allocine->get(recup_id_films($tab_films,$allocine));
    //var_dump($result[$i]);
    $myjson[$i] = json_decode($result[$i]);
    
}
?>

        <script>
            $(document).ready(function(){
                init();
            });
            
            function init(){
                
                
                document.getElementById("bande").style.display = "none";
    
                

                var canvas = document.getElementById("myCanvas");
                var context = canvas.getContext("2d");
				var quizbg = new Image();
				var Question = new String;
				var Option1 = new String;
				var Option2 = new String;
				var Option3 = new String;
				var mx=0;
				var my=0;
				var CorrectAnswer = 0;
				var qnumber = 0;
				var rightanswers=0;
				var wronganswers=0;
				var QuizFinished = false;
				var lock = false;
				var textpos1=50;
				var textpos2=145;
				var textpos3=230;
				var textpos4=325;
				
				<?php       
                                                $random_qs = rand(0,2); 
                                                $word=get_synopsis($myjson[$random_qs]); 
                                          
                                       ?>
				
				var Questions = [<?php echo "'". addslashes($word)."'";
					
								 ?>];
											
				var Options =[<?php echo '"'.get_title($myjson[0]).'"';?>,
								<?php echo '"'.get_title($myjson[1]).'"';?>,
								<?php echo '"'.get_title($myjson[2]).'"';?>];


				quizbg.onload = function(){
			      context.drawImage(quizbg, 0, 0);
				  SetQuestions();
				}//quizbg
				quizbg.src = "../quiz_game/quizbg.png";


 



				SetQuestions = function(){

					Question=Questions[qnumber];
					CorrectAnswer=<?php echo $random_qs+1; ?>;

					Option1=Options[qnumber];Option2=Options[1];Option3=Options[2];
					

					context.textBaseline = "middle";
					context.font = "14pt Calibri,Arial";
					<?php if(strlen($word) >125 ){ ?>
					context.fillText( <?php $word_final= "'".addslashes(substr($word,0,60))."'";
									 echo substr_replace($word_final,"...",57)."'";?>,12,textpos1);
					<?php } ?>
					<?php  if(strlen($word) < 125 ){ ?>
					context.fillText(<?php echo "'".addslashes(substr($word,0,60))."'";
						
						$word_final= "'".addslashes(substr($word,61,80))."'";
									 echo substr_replace($word_final,"...",77)."'";?>,12,textpos1);?>,12,textpos1+15);
                                        <?php } ?>
				
					context.fillText(Option1,20,textpos2);
					context.fillText(Option2,20,textpos3);
					context.fillText(Option3,20,textpos4);


				}//SetQuestions

				canvas.addEventListener('click',ProcessClick,false);

				function ProcessClick(ev) {

				my=ev.y-canvas.offsetTop;

				if(ev.y == undefined){
					my = ev.pageY - canvas.offsetTop;
				}

			if(lock){
				ResetQ();
			}//if lock

			else{

			if(my>110 && my<180){GetFeedback(1);}
			if(my>200 && my<270){GetFeedback(2);}
			if(my>290 && my<360){GetFeedback(3);}

			}//!lock

				}//ProcessClick



		GetFeedback = function(a){

		  if(a==CorrectAnswer){
		  	context.drawImage(quizbg, 0,400,75,70,480,110+(90*(a-1)),75,70);
			rightanswers++;
			//drawImage(image, sx, sy, sWidth, sHeight, dx, dy, dWidth, dHeight)
		  }
		  else{
		    context.drawImage(quizbg, 75,400,75,70,480,110+(90*(a-1)),75,70);
			wronganswers++;
		  }
		  lock=true;
		  context.font = "14pt Calibri,Arial";
		  context.fillText("Click Here to watch the trailer",20,380);
		}//get feedback


		ResetQ= function(){
		lock=false;
		context.clearRect(0,0,550,400);
		qnumber++;
		if(qnumber==Questions.length){EndQuiz();}
		else{
		context.drawImage(quizbg, 0, 0);
		SetQuestions();}
		}


		EndQuiz=function(){
		canvas.removeEventListener('click',ProcessClick,false);
		context.drawImage(quizbg, 0,0,550,90,0,0,550,400);
		context.font = "20pt Calibri,Arial";
		//context.fillText("You have finished the quiz!",20,100);
		context.font = "10pt Calibri,Arial";
		if (rightanswers==1)
		{
		divaffiche();
		context.fillText("you Did It ;) watch the trailer",20,100);
		context.font = "20pt Calibri,Arial";
		var id = <?php echo $_GET['id']?>;
                cinema.removeLayer(id);
		score+=20;
                $("#score_utilisateur" ).text(score);
		}
		
		
		else{
			context.font = "40pt Calibri,Arial";
		context.fillText("Oups ",20,100);
		context.fillText("Sorry you lose",20,240);
		
		}
			}};//windowonload

        </script>


    </head>
    <body>
		<style>
		  #myCanvas {
		background:#EBF5FF;
		  }
</style>
    <div id="ccontainer">
<center><canvas id="myCanvas" width="550" height="400">

	</canvas></center>
			
</div>
 <script>
	function divaffiche(){
      document.getElementById("bande").style.display = "block";
		document.getElementById("ccontainer").style.display = "none";
    
    }
 </script>
	<center>
        <div id="bande" width="550" height="400" style ="margin-top:0px;">
                <object
		type="application/x-shockwave-flash"
		data="<?php echo '"'.get_trailer($myjson[0]).'"';?>"
		width="400" height="326">
		<param name="movie" value=<?php echo '"'.get_trailer($myjson[$random_qs]).'"';?>>
		<param name="allowFullScreen" value="true">	
		<param name="allowScriptAccess" value="always">
		</object>
 			<h1> you have won ! Enjoy The trailer </h1>
        </div>
        </center>