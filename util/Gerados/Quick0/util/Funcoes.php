<?php
	Class Funcoes{

		public static function criarLink($paginaDestino, $texto){
			echo "<p align=\"center\"> <a href=\"$paginaDestino\"> $texto </a> </p>";
		}

		public static function setarCaracteres(){
			header("Content-Type: text/html; charset=ytf-8",true);
		}

	}
?>
