<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title>Paint in Paris</title>
		
		<link rel="stylesheet" href="css/jquery.svg.css">
		<link rel="stylesheet" href="css/jquery.parallax.css">
		<link rel="stylesheet" href="css/paint.css">
		
	    <script type="text/javascript" src="js/jquery-2.1.3.min.js"></script>
	    <script type="text/javascript" src="js/queue.v1.min.js" ></script>
	    <script type="text/javascript" src="js/svg.min.js" ></script>
	    <script type="text/javascript" src="js/jquery.svganim.js" ></script>
	    <script type="text/javascript" src="js/jquery.svg.js" ></script>
	    <script type="text/javascript" src="js/jquery.parallax.js" ></script>
	    <script type="text/javascript" src="js/jquery.event.frame.js" ></script>
		<script>
			var calques = [1];
			var tab_visibilite_calque = [true];
			var tab_lock_calque = [false];
			var tab_rotation_calque = [0];
			var tab_rotation_vitesse = [0];
			var id = <?php echo $_GET['id']?>;
			
			var calque_actif = 1;
			
			$(function(){
				$('#svg-panel').svg({onLoad: initSVG, settings: {id: "parallax", class_: "parallax-viewport", width: "400px", height: "300px"}});
				$('#image-fond-action').click(changerFond);
				$('#svg-panel').click(paint);
				$('#reset').click(reset);
				
				$('#parallax .parallax-layer').parallax({
					mouseport: jQuery("svg")[0]
				});
			});
			
			function initSVG(svg){
				var svg = $('#svg-panel').svg('get');
				
				var fond = svg.group(null, "fond", {class_: "parallax-layer", width: "600px", height: "600px"});
				var image = 'http://images.lpcdn.ca/641x427/201306/25/708114-tour-eiffel-paris.jpg';
				svg.image(fond, 0, 0, 400, 300, image);
				
				svg.group(null, "g_calque_1", {class_: "parallax-layer", width: "1000px", height: "1000px"});
				select_calque('1');
			}
			
			function save_svg() {
			    var serializer = new XMLSerializer();
			    var xmlString = serializer.serializeToString($("svg")[0]);
			    var imgData = 'data:image/svg+xml;base64,' + btoa(xmlString);
			    $("#download").attr("href", imgData);

                paintLayer.removeLayer(id);
				score+=20;
                $("#score_utilisateur" ).text(score);
			}
			
			function ajout_calque(){
				var nombre = calques.length + 1;
				
				if(nombre > 7){
					return;
				}
				
				var svg = $('#svg-panel').svg('get');
				
				tab_visibilite_calque[nombre - 1] = true;
				tab_lock_calque[nombre - 1] = false;
				calques[nombre - 1] = nombre;
			
				tab_rotation_calque[nombre - 1] = 0;
				tab_rotation_vitesse[nombre - 1] = 0;
				
				svg.group(null, "g_calque_"+nombre, {class_: "parallax-layer", width: "1000px", height: "1000px"});
				
				var col_visible = '<td id="show-'+nombre+'" onclick="show('+nombre+', \'show-'+nombre+'\')">Oui</td>';
				var col_lock = '<td id="lock-'+nombre+'" onclick="lock('+nombre+', \'lock-'+nombre+'\')">Non</td>';
				var col_nom = '<td><input type="text" value="Calque '+ nombre +'" maxlength="15" style="width: 100px;"></td>';
				
				$("#calques").append('<tr id="calque_'+nombre+'" onclick="select_calque('+nombre+')">' + col_visible + col_lock + col_nom + '</tr>');
			}
			
			function show(calque, element){
				var svg = $('#svg-panel').svg('get');
				var groupe = svg.getElementById("g_calque_"+calque);
				
				switch(tab_visibilite_calque[calque-1]){
					case true:
						tab_visibilite_calque[calque-1] = false;
						$('#'+element).text("Non");
						groupe.style.visibility = "hidden";
						break;
					case false:
						tab_visibilite_calque[calque-1] = true;
						$('#'+element).text("Oui");
						groupe.style.visibility = "visible";
						break;
				}
			}
			
			function lock(calque, element){
				switch(tab_lock_calque[calque-1]){
					case true:
						tab_lock_calque[calque-1] = false;
						$('#'+element).text("Non");
						break;
					case false:
						tab_lock_calque[calque-1] = true;
						$('#'+element).text("Oui");
						break;
				}
			}
			
			function select_calque(calque){
				if(tab_lock_calque[calque-1] == false){	
					if($("#calque_"+calque_actif).hasClass("calque_actif")){
						$("#calque_"+calque_actif).removeClass("calque_actif");
					}
					calque_actif = calque;
					$("#calque_"+calque).addClass("calque_actif");
					
					$("#input-rotation")[0].value = tab_rotation_calque[calque-1];
					//$("#vitesse-rotation")[0].value = tab_rotation_vitesse[calque-1];
				}
			}
			
			function reset(){
				var svg = $('#svg-panel').svg('get');
				svg.clear();
				
				var fond = svg.group(null, "fond", {class_: "parallax-layer"});
				var image = 'http://images.lpcdn.ca/641x427/201306/25/708114-tour-eiffel-paris.jpg';
				svg.image(fond, 0, 0, 400, 300, image);
				
				calques = [1];
				tab_visibilite_calque = [true];
				tab_lock_calque = [false];
				tab_rotation_calque = [0];
				calque_actif = 1;  
				
				var html = '<tr><td>Visible</td><td>Verrou</td><td align="center">Nom</td></tr>'
						+ '<tr id="calque_1" onclick="select_calque(\'1\')">'
						+ '<td id="show-1" onclick="show(\'1\', \'show-1\')">Oui</td>'
						+ '<td id="lock-1" onclick="lock(\'1\', \'lock-1\')">Non</td>'
						+ '<td><input type="text" value="Calque 1" maxlength="15" style="width: 100px;"></td></tr>';
				
				$("#calques")[0].innerHTML = html;
			}
			
			function changerFond(){
				var svg = $('#svg-panel').svg('get');
				var image = $('#image-fond').val();
				var fond = svg.getElementById("fond");
				fond.remove();
				var fond = svg.group(null, "fond", {class_: "parallax-layer"});
				svg.image(fond, 0, 0, 400, 300, image);		
			}
			
			function paint(evt){
				if(tab_lock_calque[calque_actif - 1] == true){
					return;
				}
				
				var svg = $('#svg-panel').svg('get');
				
				var x = evt.offsetX;
				var y = evt.offsetY;
				var taille = $('#taille-element').val();
				var forme = $('#forme-element').val();
				var opacite = $('#opacite-element').val()/100;
				
				var couleur = "#000000";
				
				var groupe = svg.getElementById("g_calque_"+calque_actif);
				
				switch ($('#couleur-element').val()){
					case 'Rouge' :
						couleur = '#ff0000';
						break;
					case 'Orange' :
						couleur = '#ffA500';
						break;
					case 'Jaune' :
						couleur = '#00ff00';
						break;
					case 'Vert' :
						couleur = '#00ff00';
						break;
					case 'Bleu' :
						couleur = '#0000ff';
						break;
					case 'Violet' :
						couleur = '#ff00ff';
						break;
					case 'Blanc' :
						couleur = '#ffffff';
						break;
					case 'Noir' :
						couleur = '#000000';
						break;
					default:
						couleur = '#000000';
				}
				
				switch(forme){
					case 'Carr�' :
						svg.rect(groupe, x-(taille/2), y-(taille/2), taille, taille, 0, 0, {fill: couleur, opacity:opacite});
						break;
					case 'Cercle' :
						svg.circle(groupe, x - (taille/4), y - (taille/4), (taille/2), {fill: couleur, opacity: opacite});
						break;
					case 'Image' :
						var image = $('#image').val();
						svg.image(groupe, x-(taille/2), y-(taille/2), taille, taille, image, {opacity: opacite});
						break;
				}
			}
			
			function set_rotation(){
				var rotation = $("#input-rotation").val();
				tab_rotation_calque[calque_actif - 1] = rotation;
				
				animate_calque();
			}
			
			function animate_calque(){
				var svg = $('#svg-panel').svg('get');
				
				var rotation = tab_rotation_calque[calque_actif - 1];
				
				var groupe = svg.getElementById("g_calque_"+calque_actif);
				$(groupe).animate({svgTransform: 'rotate('+ rotation*10 +', 200, 150)'}, 0.1);
			}
			
			function set_music(){
				var svg = $('#svg-panel').svg('get');
				
				var fichier = $('#musique').val();
				//fichier = "01-a-horse-with-no-name.mp3";
				
				var script = "new Audio('"+ fichier +"').play();";
				svg.script(null, script, "javascript");
				
				//$('#parallax').attr("onload", "audio.play(); alert('ok')");
			}
		</script>
	</head>
	<body>
		<div id="conteneur" class="container" style="margin-top: -25px;">
			<div id="principal" class="row" style="width: 610px;">
				<div id="svg-panel" class="col-md-8">
				</div>
				<div id="menu" class="col-md-4" style="font-size: 0.8em;">
					<h3>Calques</h3>
					<table id="calques">
						<tr>
							<td>Visible</td>
							<td>Verrou</td>
							<td align="center">Nom</td>
						</tr>
						<tr id="calque_1" onclick="select_calque('1')">
							<td id="show-1" onclick="show('1', 'show-1')">Oui</td>
							<td id="lock-1" onclick="lock('1', 'lock-1')">Non</td>
							<td><input type="text" value="Calque 1" maxlength="15" style="width: 100px;"></td>
						</tr>
					</table>
					<div class="row col-md-12">
						<label>Rotation</label><input id="input-rotation" onchange="set_rotation()" type="number" min="0" max="360"/>
					</div>
					<div class="row col-md-12">
						<a href="#" onclick="ajout_calque()">Cr�er un calque</a> - <a href="#" id="reset">Reset</a>
					</div>
				</div>
			</div>
			<div id="menu-palette" class="row" style="width: 610px; font-size: 0.8em;">
				
				<div class="row">
					<div class="col-md-3">
						<label>Forme</label>
						<select id="forme-element">
							<option>Carr�</option>
							<option>Cercle</option>
							<option>Image</option>
						</select>
					</div>
					<div class="col-md-3">
						<label>Taille</label>
						<input id="taille-element" type="number" value="10" min="1" max="200" style="height: 20px; width:60px;"/>
					</div>
					
					<div class="col-md-3">
						<label>Couleur</label>
						<select id="couleur-element">
							<option style="background-color: red" selected="selected">Rouge</option>
							<option style="background-color: orange;">Orange</option>
							<option style="background-color: yellow;">Jaune</option>
							<option style="background-color: green;">Vert</option>
							<option style="background-color: blue;">Bleu</option>
							<option style="background-color: purple;">Violet</option>
							<option style="background-color: white;">Blanc</option>
							<option style="background-color: black; color: white;">Noir</option>
					</select>
					</div>
					
					<div class="col-md-3">
						<label>Opacit�</label>
						<input id="opacite-element" type="number" value="100" min="0" max="100"  style="height: 20px; width:60px;"/>
					</div>				
				</div>
				<div class="row">
				
					<div class="col-md-3">
						<label>Image</label>
						<input title="Lien de l'image" id="image" type="url" value="http://fc07.deviantart.net/fs70/f/2010/232/6/9/Pika_Pika_by_Sprits.png"  style="width: 80px; height: 20px;"/>
					</div>
					<div class="col-md-3">
						<label>Fond</label>
						<input id="image-fond" type="url" style="width: 70px; height: 20px;"/>
						<a href="#" id="image-fond-action">Ok</a>
					</div>
					
					<div class="col-md-3">
						<label>MP3</label>
						<input id="musique" type="url" style="width: 70px; height: 20px;" value="http://www.ghostwhisperer.us/Music/America/America%20-%20Horse%20With%20No%20Name.mp3"/>
						<a href="#" id="charger-musique" onclick="set_music()">Ok</a>
					</div>
					
					<div class="col-md-3">
						<a href="" onclick="save_svg()" id="download" download>T�l�charger</a>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>