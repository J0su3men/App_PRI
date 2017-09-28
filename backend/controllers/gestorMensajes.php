<?php

class MensajesController{

	#MOSTRAR MENSAJES EN LA VISTA
	#------------------------------------------------------------
	public function mostrarMensajesController(){

		$respuesta = MensajesModel::mostrarMensajesModel("mensajes");

		foreach ($respuesta as $row => $item){

			echo '<div class="well well-sm" id="'.$item["id"].'">
		
					<a href="index.php?action=mensajes&idBorrar='.$item["id"].'"><span class="fa fa-times pull-right"></span></a>
					<p>'.$item["fecha"].'</p>
					<h3>De: '.$item["nombre"].'</h3>
					<h5>Email: '.$item["email"].'</h5>
				  	<input type="text" class="form-control" value="'.$item["mensaje"].'" readonly>
				  	<br>
				  	<button class="btn btn-info btn-sm leerMensaje">Leer</button>

				  </div>';

		}

	}

	#BORRAR MENSAJES
	#------------------------------------------------------------

	public function borrarMensajesController(){

		if(isset($_GET["idBorrar"])){

			$datosController = $_GET["idBorrar"];

			$respuesta = MensajesModel::borrarMensajesModel($datosController, "mensajes");

			if($respuesta == "ok"){

					echo'<script>

					swal({
						  title: "¡OK!",
						  text: "¡El mesaje se ha borrado correctamente!",
						  type: "success",
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
					},

					function(isConfirm){
							 if (isConfirm) {	   
							    window.location = "mensajes";
							  } 
					});


				</script>';

			}

		}

	}

	#RESPONDER MENSAJES
	#------------------------------------------------------------
	public function responderMensajesController(){

		if(isset($_POST['enviarEmail'])){

			$email = $_POST['enviarEmail'];
			$nombre = $_POST['enviarNombre'];
			$titulo = $_POST['enviarTitulo'];
			$mensaje =$_POST['enviarMensaje'];

			$para = $email . ', ';
			$para .= 'cursos@tutorialesatualcance.com';

			$título = 'Respuesta a su mensaje';

			$mensaje ='<html>
							<head>
								<title>Respuesta a su Mensaje</title>
							</head>

							<body>
								<h1>Hola '.$nombre.'</h1>
								<p>'.$mensaje.'</p>
								<hr>
								<p><b>Juan Fernando Urrego A.</b><br>
								Instructor Tutoriales a tu Alcance<br> 
								Medellín - Antioquia</br> 
								WhatsApp: +57 301 391 74 61</br> 
								cursos@tutorialesatualcance.com</p>

								<h3><a href="http://www.tutorialesatualcance.com" target="blank">www.tutorialesatualcance.com</a></h3>

								<a href="http://www.facebook.com" target="blank"><img src="https://s23.postimg.org/cb2i89a23/facebook.jpg"></a> 
								<a href="http://www.youtube.com" target="blank"><img src="https://s23.postimg.org/mcbxvbciz/youtube.jpg"></a> 
								<a href="http://www.twitter.com" target="blank"><img src="https://s23.postimg.org/tcvcacox7/twitter.jpg"></a> 
								<br>

								<img src="https://s23.postimg.org/dsnyjtesr/unnamed.jpg">
							</body>

					   </html>';

		   $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		   $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		   $cabeceras .= 'From: <cursos@tutorialesatualcance.com>' . "\r\n";

		   $envio = mail($para, $título, $mensaje, $cabeceras);

		   if($envio){

		   		echo'<script>

						swal({
							  title: "¡OK!",
							  text: "¡El mensaje ha sido enviado correctamente!",
							  type: "success",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
						},

						function(isConfirm){
								 if (isConfirm) {	   
								    window.location = "mensajes";
								  } 
						});


				</script>';

		   }

		}

	}

	#ENVIAR MENSAJES MASIVOS
	#------------------------------------------------------------
	public function mensajesMasivosController(){

		if(isset($_POST["tituloMasivo"])){

			$respuesta = MensajesModel::seleccionarEmailSuscriptores("suscriptores");

			foreach ($respuesta as $row => $item) {

				$titulo = $_POST['tituloMasivo'];
				$mensaje =$_POST['mensajeMasivo'];

				$título = 'Mensaje para todos';

				$para = $item["email"]; 

				$mensaje ='<html>
								<head>
									<title>Respuesta a su Mensaje</title>
								</head>

								<body>
									<h1>Hola '.$item["nombre"].'</h1>
									<p>'.$mensaje.'</p>
									<hr>
									<p><b>Juan Fernando Urrego A.</b><br>
									Instructor Tutoriales a tu Alcance<br> 
									Medellín - Antioquia</br> 
									WhatsApp: +57 301 391 74 61</br> 
									cursos@tutorialesatualcance.com</p>

									<h3><a href="http://www.tutorialesatualcance.com" target="blank">www.tutorialesatualcance.com</a></h3>

									<a href="http://www.facebook.com" target="blank"><img src="https://s23.postimg.org/cb2i89a23/facebook.jpg"></a> 
									<a href="http://www.youtube.com" target="blank"><img src="https://s23.postimg.org/mcbxvbciz/youtube.jpg"></a> 
									<a href="http://www.twitter.com" target="blank"><img src="https://s23.postimg.org/tcvcacox7/twitter.jpg"></a> 
									<br>

									<img src="https://s23.postimg.org/dsnyjtesr/unnamed.jpg">
								</body>

						   </html>';

			   $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			   $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			   $cabeceras .= 'From: <cursos@tutorialesatualcance.com>' . "\r\n";

			   $envio = mail($para, $título, $mensaje, $cabeceras);

			   if($envio){

			   		echo'<script>

							swal({
								  title: "¡OK!",
								  text: "¡El mensaje ha sido enviado correctamente!",
								  type: "success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
							},

							function(isConfirm){
									 if (isConfirm) {	   
									    window.location = "mensajes";
									  } 
							});


					</script>';

			   }

			}

		}

	}

	#MENSAJES SIN REVISAR
	#------------------------------------------------------------
	public function mensajesSinRevisarController(){

		$respuesta = MensajesModel::mensajesSinRevisarModel("mensajes");

		$sumaRevision = 0;

		foreach ($respuesta as $row => $item) {

			if($item["revision"] == 0){

				++$sumaRevision;

				echo '<span>'.$sumaRevision.'</span>';
			
			}

		}

	}

	#MENSAJES REVISADOS
	#------------------------------------------------------------
	public function mensajesRevisadosController($datos){

		$datosController = $datos;

		$respuesta = MensajesModel::mensajesRevisadosModel($datosController, "mensajes");

		echo $respuesta;

	}


}