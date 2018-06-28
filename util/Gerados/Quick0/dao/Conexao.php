<?php
	Class Conexao{

		private static $host = "localhost";
		private static $usuario = "root";
		private static $senha = "";
		private static $banco = "empresa";
		private static $link;

		public static function getConnection(){
			self::$link = mysql_connect(self::$host, self::$usuario, self::$senha);
			if(!self::$link)
				die('Falha ao conectar no banco de dados: ' . mysql_error());
			$db_selected = mysql_select_db(self::$banco, self::$link);
			if(!$db_selected)
				die("Falha ao selecionar o banco: " . mysql_error());

			mysql_query("SET NAMES 'utf8'");
			mysql_query('SET character_set_connection=utf8');
			mysql_query('SET character_set_client=utf8');
			mysql_query('SET character_set_results=utf8');

			return self::$link;
		}

		public static function closeConnection($link){
			@mysql_close($link);
		}

	}

?>
