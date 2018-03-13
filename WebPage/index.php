<html>
<!-- COMIENZO DEL CODIGO -->
<title>Web Position</title>
<link type="text/css" rel="stylesheet" href="estilos-div.css" />
<meta charset="utf-8">
	
		<head>
			<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
			<script src="ajax.js">	
      </script>
<!-- TITULO PRINCIPAL-->		
			<div id = 'logo_uninorte'>
				<!--<img src="un.png" align = "left" color="gray">-->
			</div>
			<div class = "encabezado"  >
			<img src = "un.png" align="left" width = "60px" heigt="60px">
			<center><h1 style = "	font: oblique bold 120% cursive;font-size:30px">DYNAMIC SOLUTIONS
					<small>Telemetry</small>
				</h1></center>
			</div>	
					
		</head>
		
			<body>
				<div id = "second_container" >
						<center><fieldset style="width:30%;color:black;"><!--DEMARCACIÓN DEL DIV "Contenido"-->
						<!--DIV DONDE SE MUESTRA LA INFORMACIÓN LATITUD,LONGITUD,HORA-->
							<legend style = "background:#BDBDBD"><b>Information</b></legend>
							<div id="contenido" style = "background:#BDBDBD" >
									
							</div>	
						</fieldset></center>
						<!--DIV QUE CONTIENE EL DIV DONDE SE MUESTRA EL MAPA DE GOOGLE MAPS-->
						<div id= "container">

						<!--TITULO DEL MAPA	-->
						<center><h1 style = "color:white;font: oblique bold 120% cursive;font-size:20px">DISPLAYING POSITION </h1></center>
						<!--CODIGO PHP DONDE IMPORTAN DATOS DEL ARCHIVO REFRESH.PHP, PERO ELIMINANDO LA INFORMACIÓN QUE MUESTRA-->
            <?php 
							ob_start();
							include 'refresh.php';
							ob_clean();
						?>
						<!--DIV DEL MAPA-->
						<fieldset>
            <div id="map"></div>
						</fieldset>
            <!--ESTILO NECESARIO PARA EJECUTAR EL MAPA-->               
								 <style>
								  #map {
									height: 50%;
									width: 100%;
								   }
                	</style>
                   <!--SCRIPT DEL MAPA-->             
									<script>
									var map;
									// FUNCIÓN QUE DESPLAZA EL MARCADOR CUANDO RECIBE LAS NUEVAS COORDENADAS
									function moveToLocation(lat, lng){
											var center = new google.maps.LatLng(lat, lng);
											// using global variable:
											//map.panTo(center);
									}
									// FUNCIÓN PRINCIPAL QUE SE INICIALIZA EN EL MAPA. ESTÁ DECLARADO EN LA API KEY
								  function initMap() {
									//DECLARACIÓN DE LAS VARIABLES DE POSICIÓN Y PARÁMETROS NECESARIOS PARA EL MAPA
									var uluru = {lat:parseFloat('<?php echo $lat;?>'),lng: parseFloat('<?php echo $lon;?>')};
									var parameters = {
									  zoom: 15,
									  center: uluru
									};
									map = new google.maps.Map(document.getElementById('map'),parameters) 
									//MARCADOR INICIAL EN LA POSICIÓN INICIAL DE LA BASE DE DATOS
									var marker = new google.maps.Marker({
									  position: uluru,
									  map: map
                  });
									}   
									//FUNCIÓN QUE EXTRAE LOS VALORES DE POSICIÓN DEL JSON QUE SE GENERA EN LOCATION.PHP								
									setInterval(function reload_map(){
										//INSTRUCCIÓN NECESARIA PARA ACTUALIZAR LA INFORMACIÓN EN BACKGROUND
										$.ajax({
													url: 'location.php',
													dataType: "json",
													success: function (data){
													//EXTRACCIÓN DE VALORES DEL OBJETO DE TIPO JSON IMPORTADO DE LOCATION.PHP	
													var obj_que =	jQuery.parseJSON(JSON.stringify(data));
													$(jQuery.parseJSON(JSON.stringify(data))).each(function() {
														//NUEVA LATITUD Y LONGITUD
														var LATITUDE = this.latitud;
														var LONGITUDE = this.longitud;
														//SE AGREGA EL NUEVO MARCADOR
														addMarker(new google.maps.LatLng(LATITUDE, LONGITUDE), map);
														moveToLocation(parseFloat(LATITUDE),parseFloat(LONGITUDE));
													});
													},
													error: function() {
															console.log('Error: ' + json_obj);
													}
												});
											//TIEMPO DE ACTUALIZACIÓN DEL MARCADOR: 5 SEGUNDOS
											},5000);
											//FUNCIÓN QUE AGREGA EL MARCADOR
											function addMarker(latLng, map) {
												//ATRIBUTOS DEL MARCADOR
												var marker = new google.maps.Marker({
														position: latLng,
														map: map,
														draggable: false, 
														animation: google.maps.Animation.DROP
												});
												return marker;
									}								
				        </script>
								</div>
								<!--SCRIPT QUE DECLARA LA API KEY DE GOOGLE MAPS-->
								<script async defer
								src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-ME1K7mHCv4Aeep1OL86E8TKqRUkDyQM&callback=initMap">
								</script>
							
								</div>
			</body>	
			</div>				
</html>	

	