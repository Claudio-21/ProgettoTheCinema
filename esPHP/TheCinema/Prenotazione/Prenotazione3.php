<html>
	<head>
			<title>The Cinema </title>
		<style>
			body {
				margin:auto;
				background: rgb(253,187,45);
				background: linear-gradient(0deg, rgba(253,187,45,1) 0%, rgba(34,193,195,1) 100%);
				font-family: 'Roboto', sans-serif;
				font-weight: 800;
				position: relative;
			}

			form{
			position: absolute;
			top: 25%;
			left: 20%;
			transform: translate(-50%, -50%);
			}
			/*
			a{
			position: absolute;
			top: 60%;
			left: 20%;
			transform: translate(-50%, -50%);
			}
			*/
			a {
			  position: relative;
			  left: 20px;
			  top: 175px;
			}
			p {
			border-style: inset;
			text-align:center;
			position: absolute;
			top: 20%;
			left: 50%;
			transform: translate(-50%, -50%);
			 font-size: 34px;
			padding: 30px;
			}
			.buttonConferma{
				border: none;
			color: white;
			padding: 15px 32px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
				background-color: #008CBA; /* Blue */
			position: relative;
				top: 450px;
				left: 550px;
				transform: translate(-50%, -50%);

			}
		.button2 {
			border: none;
	  color: white;
	  padding: 15px 32px;
	  text-align: center;
	  text-decoration: none;
	  display: inline-block;
	  font-size: 16px;
			background-color: #008CBA; /* Blue */
		position: absolute;
			top: 100%;
			left: 50%;
			transform: translate(-50%, -50%);
		}

				.container {
										font-family: 'Roboto', sans-serif;
									  width: 1300px;
									  margin: 30px ;
										position: fixed;

							  }
	  .progressbar {font-family: 'Roboto', sans-serif;
	      counter-reset: step;

	  }
	  .progressbar li {
		  font-family: 'Roboto', sans-serif;
	      list-style-type: none;
	      width: 25%;
	      float: left;

	      font-size: 12px;
	      position: relative;
	      text-align: center;
	      text-transform: uppercase;
	      color: #7d7d7d;
	  }
	  .progressbar li:before {
		  font-family: 'Roboto', sans-serif;
	      width: 30px;
	      height: 30px;
	      content: counter(step);
	      counter-increment: step;
	      line-height: 30px;
	      border: 2px solid #7d7d7d;
	      display: block;
	      text-align: center;
	      margin: 0 auto 10px auto;
	      border-radius: 50%;
	      background-color: white;
	  }
	  .progressbar li:after {
		  font-family: 'Roboto', sans-serif;
	      width: 100%;
	      height: 2px;
	      content: '';
	      position: absolute;
	      background-color: #7d7d7d;
	      top: 15px;
	      left: -50%;
	      z-index: -1;
	  }
	  .progressbar li:first-child:after {
		  font-family: 'Roboto', sans-serif;
	      content: none;
	  }
	  .progressbar li.active {
		  font-family: 'Roboto', sans-serif;
	      color: black;
	  }
	  .progressbar li.active:before {
		  font-family: 'Roboto', sans-serif;
	      border-color: black;
	  }
	  .progressbar li.active + li:after {
		  font-family: 'Roboto', sans-serif;
	      background-color: black;
	  }
		</style>
	</head>

<body>
	<?php
		//Per sistemare il problema del ERR_CACHE_MISS
		header('Cache-Control: no cache'); //no cache
		session_cache_limiter('private_no_expire'); // works
	?>
  <div class="container">
     <ul class="progressbar">
          <li >Scegli il film</li>
          <li>Seleziona i posti</li>
          <li class="active">Ricapitolo</li>
          <li>Pagamento</li>
  </ul>

	<?php
	session_start();
	$ip=$_SERVER['SERVER_NAME'];  //server per vedere sei sei localhost o hai un ip
	$porta=$_SERVER['SERVER_PORT'];   //porta del serve, perchè c'è chi ha 80, chi 8080 etc...
	$selezionato=false;  //per vedere se è stato selezionato almeno 1
	include "connessione.php";
	if(isset($_SESSION["usrLogin"])){
		//$usernameUtente=$_SESSION["usrLogin"];
	}else{
		header("Location: http://" .$ip .":" .$porta ."/esPHP/TheCinema/Registrazione/loginregister/Login-Registra.php");
		die("");
	}
	if(isset($_POST["annulla"])){
		//torno indietro
		$idPr=$_SESSION["idProiezione"];
		header("Location: http://" .$ip .":" .$porta ."/esPHP/TheCinema/Prenotazione/Prenotazione2.php?idProiezione=$idPr");
		die("");
	}else{
		//continuo
	}
			if(isset($_POST["numeroPosti"])){
				$numeroPosti=$_POST["numeroPosti"];
				$presente=true;
				$msg="<br>";
				$id=Array();
				$numero=Array();
				$lettera=Array();
				$disabile=Array();
				for($i=1;$i<=$numeroPosti;$i++){
						if(isset($_POST["$i"])){
							$po=$_POST["$i"];
										$app=Array();
										$app= explode("?",$po);
										$id[]=$app[0];
										$numero[]=$app[1];
										$lettera[]=$app[2];
										$disabile[]= $app[3];
										$selezionato=true;  //metto selezionato a true
						}
				}
			}else{ //nessun posto selezionato
				header("Location: http://" .$ip .":" .$porta ."/esPHP/TheCinema/Prenotazione2.php");
				die("");
			}
			/////stampo i biglietti selezionati con le loro informazioni///////////////
			/*
			for($i=0;$i<count($numero);$i++){
				echo "<br>[$id[$i]] Posto lettera  $lettera[$i], numero  $numero[$i] ";

			}
			*/
					if($selezionato==false){ //torno a prenotazione2.php quando non è stato selezionato niente
						//prendo l'idProiezione cosi possono essere rivisti gli stessi posti
						$idPr=$_SESSION["idProiezione"];
						header("Location: http://" .$ip .":" .$porta ."/esPHP/TheCinema/Prenotazione/Prenotazione2.php?idProiezione=$idPr");
						die("");
					}

								///vado a trovare il costo, dato che i posti sono nella stessa sala prenderò il primo///////////////////////
								$idSalaPostoCasuale=$id[0];
						 $sql = "SELECT sala.costoIntero,sala.costoRidottoU6 from sala join posto on sala.id=posto.idSala where posto.id=\"$idSalaPostoCasuale\"  ";
												$records=$conn->query($sql);
												if ( $records == TRUE) {
														//echo "<br>Query eseguita!";
												} else {
													die("Errore nella query: " . $conn->error);
												}
												if($records->num_rows ==0){
															//	echo "la query non ha prodotto risultato";

												}else{

																while($tupla=$records->fetch_assoc()){
																		$costoIntero=$tupla["costoIntero"];
																		$costoRidottoU6=$tupla["costoRidottoU6"];
																	//	echo "<br> Costo intero $costoIntero";
																	//	echo "<br> Costo ricotto $costoRidottoU6";
																}
											 }
											 $msg="<form action=\"prenotazione4.php\" method=\"POST\">";
											 $numPosti=1;
											 for($i=0;$i<count($numero);$i++){
												// echo "<br><a>[$id[$i]] Posto lettera  $lettera[$i], numero  $numero[$i]</a> ";
												 $mesCostoIntero="Costo intero $costoIntero";
												 $mesCostoRidotto="Costo ridotto $costoRidottoU6";
												 $msg.="<a><label for=\"costo\">[$id[$i]] Posto| lettera  $lettera[$i], numero  $numero[$i]</label>
												 					<select id=\"costo$numPosti\" name=\"costo$numPosti\">
																	  <option value=\"$costoIntero\">$mesCostoIntero</option>
																	  <option value=\"$costoRidottoU6\">$mesCostoRidotto</option>
																	</select></a><br>";
																	$msg.="<input  type=\"hidden\" name=\"idPosto$numPosti\" value=\"$id[$i]\"></input>";
																	$numPosti++;
											 }
											 $msg.="<input class=\"buttonConferma\" type=\"submit\" value=\"Conferma ed acquista\"></input>";
											 $msg.="<input  type=\"hidden\" name=\"numeroPosti\" value=\"$numPosti\"></input>";   //invio il numero totale di posti


											 $msg.="</form>";
											 echo "<script>window.open('http://$ip:$porta/esPHP/TheCinema/home.php', '_blank');</script>";
											 echo $msg;

											/* per stampare tutte le session presenti
												 echo '<pre>';
												var_dump($_SESSION);
												echo '</pre>';
												*/



			?>

</body>
</html>
