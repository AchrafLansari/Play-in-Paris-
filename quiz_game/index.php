<?php
include_once('functions/search.php');
include_once('functions/get.php');
require_once(__DIR__.'/functions/allocine.class.php');

define('ALLOCINE_PARTNER_KEY', '100043982026');
define('ALLOCINE_SECRET_KEY', '29d185d98c984a359e6e6f26a0474269');

$allocine = new Allocine(ALLOCINE_PARTNER_KEY, ALLOCINE_SECRET_KEY);


$film_search=file_get_contents("liste_film.txt") ;
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
<html>
    <head>

        <style>
            body {
            	background-image:url("BG.png")
		  }

		  #ccontainer{
		  width:550px;

		  margin: 0 auto;
		  margin-top:100px;
		  }

		  #myCanvas {
		//background:#FFFFFF;
		#bande{
		width:550px;
		margin: 0 auto;
	    margin-top:100px;
		}
            }

        </style>

        <script>
			
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
				
				var Questions = [<?php echo "'".  utf8_decode(addslashes($word))."'";
					
								 ?>];
											
				var Options =[<?php echo '"'.get_title($myjson[0]).'"';?>,
								<?php echo '"'.get_title($myjson[1]).'"';?>,
								<?php echo '"'.get_title($myjson[2]).'"';?>];


				quizbg.onload = function(){
			      context.drawImage(quizbg, 0, 0);
				  SetQuestions();
				}//quizbg
				quizbg.src = "quizbg.png";


 



				SetQuestions = function(){

					Question=Questions[qnumber];
					CorrectAnswer=<?php echo $random_qs+1; ?>;

					Option1=Options[qnumber];Option2=Options[1];Option3=Options[2];
					

					context.textBaseline = "middle";
					context.font = "14pt Calibri,Arial";
					context.fillText(<?php echo "'".utf8_decode(addslashes(substr($word,0,125)))."'";?>,12,textpos1);
					<?php if(strlen($word) > 125 ){ ?>
					context.fillText(<?php echo "'".utf8_decode(addslashes(substr($word,125,175)))."'";?>,12,textpos1+15);
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
		  context.fillText("Click again to continue",20,380);
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
		
		
		}
		
		
		else{
		context.fillText("ouppps you LOSE ",20,100);
		context.fillText("Oupppps Try again you have a Wrong answers: "+String(wronganswers),20,240);
		}
			}};//windowonload

        </script>


    </head>
    <body onload="init();">

    <div id="ccontainer">
<canvas id="myCanvas" width="550" height="400">

</canvas>
			
</div>

 <script>
	function divaffiche(){
      document.getElementById("bande").style.display = "block";
		document.getElementById("ccontainer").style.display = "none";
    
    }
	</script>
	<center><div id="bande" width="550" height="400" style ="margin-bottom:300px;">
                <object
		type="application/x-shockwave-flash"
		data="<?php echo '"'.get_trailer($myjson[0]).'"';?>"
		width="400" height="326">
		<param name="movie" value=<?php echo '"'.get_trailer($myjson[$random_qs]).'"';?>>
		<param name="allowFullScreen" value="true">	
		<param name="allowScriptAccess" value="always">
		</object>
 			<h1> you have won ! Enjoy The trailer </h1>
</div></center>


</body>
</html>
