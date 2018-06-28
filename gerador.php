<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->

<!DOCTYPE html>
<html>
<head>
<title>QuickMVC - Gerador De Código PHP</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Gerador de código através do banco de dados" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Custom Theme files -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- //Custom Theme files -->

</head>
<body>
	<!-- main -->
	<div class="main">
		<p align="center" ><img src="Imagens/Logo.jpg" width="400px" ></p>
		<h1 align="center">QuickMVC - Gerador De Código PHP</h1>
		<div class="main-row">
			<div class="agileits-top"> 

			<font color="white">
				<?php
					$servidor = $_POST['servidor'];
					$usuario = $_POST['usuario'];
					$senha = $_POST['senha'];
					$banco = $_POST['banco'];
					
					// Conecta-se ao banco de dados MySQL
					$mysqli = new mysqli($servidor, $usuario, $senha, $banco);
					// Caso algo tenha dado errado, exibe uma mensagem de erro
					if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
					else {
						echo "Conectado no servidor " .$servidor.  " no banco de dados " .$banco;
					}

						//query para receber todas as tabelas do banco de dados
						$sqlTabelas = "SHOW TABLES FROM $banco";
						$queryTabelas = $mysqli->query($sqlTabelas) or trigger_error($mysqli->error." [$sql]"); 

						echo "<br><br>";

						while($resultado1 = $queryTabelas->fetch_array()) {
							$i = 0;
							echo "<font color='red'>" .$resultado1[$i] ."<br></font>";

							//query para receber todas as colunas de determinada tabela do banco de dados
							$sqlColunas = "SHOW COLUMNS FROM $resultado1[$i]";
							$queryColunas = $mysqli->query($sqlColunas) or trigger_error($mysqli->error." [$sql]");

							while($resultado2 = $queryColunas->fetch_assoc()) {
								
								echo $resultado2["Field"] . " ... (" . $resultado2["Type"] . ")";
								echo "<br>";
								

							}

							$i++;
						}


				?>

				</font>

			</div>	 
		</div>	
		<!-- copyright -->
		<div class="copyright">
			<p> © 2016 QuickMVC . All rights reserved </p>
		</div>
		<!-- //copyright -->
	</div>	
	<!-- //main --> 
</body>
</html>