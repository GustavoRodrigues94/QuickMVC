<?php
class BancoDAO{
	private $nomePasta;


	/////////////////////////////////////////////////////////////////////////////////////
	//..Função responsável por gerar o model do sistema
	public function GerarModel($nomePasta, $tabelas){
			//esse é o nome da pasta que foi gerada
			$this->nomePasta = $nomePasta;
			//a palavra this é uma palavra reservada do php, portanto tive que fazer isso para escrever $this-> em um arquivo texto
			$concatenarThis = "this";
			//essa é a quebra de linha no arquivo texto
			$quebra = chr(13).chr(10);


		//esse laço passa em todas as tabelas do banco
		foreach($tabelas as $tabela) {

			//..Criando arquivo no caminho da pasta gerada
			$open = fopen('../util/Gerados/'.$this->nomePasta.'/model/'.$tabela->getNomeMaiusculo().'.php','a');

			//escrevendo linha por linha no arquivo 
			fwrite($open,"<?php".$quebra);
			
			//verificando se existe uma tabela estrangeira		
				foreach($tabela->getColunas() as $coluna){
					if($coluna->getChave() == "MUL"){
						fwrite($open," include_once(\"".$coluna->getFkTabelaMaiusculo().".php\");".$quebra);
					}
				}
				

			fwrite($open," ".$quebra);
			fwrite($open,"	Class ".$tabela->getNomeMaiusculo()." {".$quebra);
			fwrite($open," ".$quebra);

			//..esse laço passa em todas as colunas de cada tabela do banco
    		foreach($tabela->getColunas() as $coluna) {					
				fwrite($open," 		private $".$coluna->getNome().";".$quebra);
				//..fim do criador de private
			}//..fim do laço de colunas

			fwrite($open,"".$quebra);
			//verificando se existe tabela estrangeira, se existir irá criar o construtor
			if($tabela->verificaTabEstrangeira()){

				fwrite($open,"		function __construct(){".$quebra);
				foreach($tabela->getColunas() as $coluna) {
					if($coluna->getChave() == "MUL"){
						fwrite($open,"			$"."this->".$coluna->getNome()." = new ".$coluna->getFkTabelaMaiusculo()."();".$quebra);
					}
				}
				fwrite($open,"		}".$quebra);
				fwrite($open,"".$quebra);
			}

			//..esse laço passa em todas as colunas de cada tabela do banco
			foreach($tabela->getColunas() as $coluna) {
				//criador de sets
				fwrite($open," 		public function set".$coluna->getNomeMaiusculo()."($".$coluna->getNome()."){".$quebra);
				fwrite($open," 			$".$concatenarThis."->".$coluna->getNome()." = $".$coluna->getNome().";".$quebra);
				fwrite($open," 		}".$quebra);
				fwrite($open,"".$quebra);
				//criador de gets
				fwrite($open," 		public function get".$coluna->getNomeMaiusculo()."(){".$quebra);
				fwrite($open," 			return $".$concatenarThis."->".$coluna->getNome().";".$quebra);
				fwrite($open," 		}".$quebra);
				fwrite($open,"".$quebra);
				//fim criador de gets

    		}//..fim do laço de colunas

    	fwrite($open,"	}".$quebra);
		fwrite($open,"".$quebra);
		fwrite($open,"?>");
		fclose($open);
		}//..fim do laço de tabelas
	}//..fim da função criarModel
	/////////////////////////////////////////////////////////////////////////////////////

	/////////////////////////////////////////////////////////////////////////////////////
	//Função responsável por gerar a view do sistema
	public function GerarViewCadastrar($tabelas){

		//variável para concatenar get
		$get = "_GET";

		foreach($tabelas as $tabela) {

			$open = fopen('../util/Gerados/'.$this->nomePasta.'/view/'.$tabela->getNome().'_cadastrar.php','a');
			$quebra = chr(13).chr(10);//essa é a quebra de linha
			//escrevendo linha por linha no arquivo 
			fwrite($open,"<?php".$quebra);

			//criando o include_once com o nome da classe que está sendo tratada
			fwrite($open," include_once(\"../dao/".$tabela->getNomeMaiusculo()."DAO.php\");".$quebra);
			fwrite($open,"".$quebra);

			//criando o include_once da chave estrangeira
			//verificando se a tabela em questão não é a estrangeira, se for retornará false	
			if($tabela->verificaTabEstrangeira()){
				foreach($tabela->getColunas() as $coluna){
					if($coluna->getChave() == "MUL"){
						fwrite($open," include_once(\"../dao/".$coluna->getFkTabelaMaiusculo()."DAO.php\");".$quebra);
						fwrite($open,"".$quebra);
						fwrite($open,"".$quebra);
						fwrite($open,"$".$coluna->getFkTabela()."DAO = new ".$coluna->getFkTabelaMaiusculo()."DAO();".$quebra);
						fwrite($open,"\$lista".$coluna->getFkTabelaMaiusculo()." = $".$coluna->getFkTabela()."DAO->obterTodos();".$quebra);
						fwrite($open,"".$quebra);
					}
				}
			}	
				//laço para passar em todas colunas da tabela
				foreach($tabela->getColunas() as $coluna){
					//verificando se a coluna é chave primária
					if($coluna->getChave() == "PRI") {
					fwrite($open,"  if(isset($".$get."['".$coluna->getNome()."'])){".$quebra);
					fwrite($open,"    $".$tabela->getNome()." = new ".$tabela->getNomeMaiusculo()."();".$quebra);
					fwrite($open,"    $".$coluna->getNome()." = $".$get."['".$coluna->getNome()."'];".$quebra);
					fwrite($open,"    $".$tabela->getNome()."DAO = new ".$tabela->getNomeMaiusculo()."DAO();".$quebra);
					fwrite($open,"    $".$tabela->getNome()." = $".$tabela->getNome()."DAO->obterPorId($".$coluna->getNome().");".$quebra);
					fwrite($open,"  }".$quebra);
					fwrite($open,"".$quebra);
					fwrite($open,"?>".$quebra);
					}

				}//fim laço

			//criando o cabeçalho
			fwrite($open,"".$quebra);
			fwrite($open,"<!DOCTYPE html>".$quebra);
			fwrite($open,"<html>".$quebra);
			fwrite($open,"<head>".$quebra);
			fwrite($open,"<title>Cadastro De ".$tabela->getNomeMaiusculo()."</title>".$quebra);
			fwrite($open,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />".$quebra);
			fwrite($open,"</head>".$quebra);
			fwrite($open,"<body>".$quebra);
			fwrite($open,"<h1>Cadastro De ".$tabela->getNomeMaiusculo(). "</h1>".$quebra);
			//fim do cabeçalho

			//criando o formulário
			fwrite($open,"<form name=\"form1\" method=\"POST\" action=\"../controller/".$tabela->getNomeMaiusculo()."CTR.php\">".$quebra);

				//laço para passar em todas colunas da tabela
				foreach($tabela->getColunas() as $coluna){
					//verificando se a coluna é chave primária
					if($coluna->getChave() == "PRI") {
						fwrite($open,"<label>Código".$quebra);
						fwrite($open,"<input name=\"".$coluna->getNome()."\" type=\"text\" readonly=\"readonly\" value=\"<?php if(isset($".$tabela->getNome().")) echo $".$tabela->getNome()."->get".$coluna->getNomeMaiusculo()."() ?>\" /><br />".$quebra);
						fwrite($open,"</label>".$quebra);
					}

				} //fim laço

				//laço para passar em todas colunas da tabela
				foreach($tabela->getColunas() as $coluna){
				//verificando se a coluna NÃO é chave primária
					if(!($coluna->getChave() == "PRI")) {
						fwrite($open,"<label>".$coluna->getNome().$quebra);
						fwrite($open,"</label>".$quebra);
						
						if($coluna->getTipo()=="varchar"){
							fwrite($open,"<input name=\"".$coluna->getNome()."\" type=\"text\" value=\"<?php if(isset($".$tabela->getNome().")) echo $".$tabela->getNome()."->get".$coluna->getNomeMaiusculo()."() ?>\" /><br />".$quebra);
							fwrite($open,"</label>".$quebra);
						}else{
							//verifica se o campo é inteiro e não é a chave estrangeira
							if(($coluna->getTipo()=="int")and($coluna->getChave() != "MUL")){
								fwrite($open,"<input name=\"".$coluna->getNome()."\" type=\"number\" value=\"<?php if(isset($".$tabela->getNome().")) echo $".$tabela->getNome()."->get".$coluna->getNomeMaiusculo()."() ?>\" /><br />".$quebra);
								fwrite($open,"</label>".$quebra);		
							} else{
								if($coluna->getTipo()=="double"){
									fwrite($open,"<input name=\"".$coluna->getNome()."\" type=\"number\" value=\"<?php if(isset($".$tabela->getNome().")) echo $".$tabela->getNome()."->get".$coluna->getNomeMaiusculo()."() ?>\" /><br />".$quebra);
									fwrite($open,"</label>".$quebra);		
								}else{
									if($coluna->getTipo()=="date"){
										fwrite($open,"<input name=\"".$coluna->getNome()."\" type=\"date\" value=\"<?php if(isset($".$tabela->getNome().")) echo $".$tabela->getNome()."->get".$coluna->getNomeMaiusculo()."() ?>\" /><br />".$quebra);	
										fwrite($open,"</label>".$quebra);	

									} else{
										//verifica se o campo é int e é a chave estrangeira
										if(($coluna->getTipo()=="int")and($coluna->getChave() == "MUL")){
												fwrite($open,"<select name=\"".$coluna->getNome(). "\">".$quebra);
												fwrite($open,"<?php".$quebra);
												fwrite($open, "   if(isset($".$tabela->getNome()."))".$quebra);
												fwrite($open, "   		echo \"<option value=\".$" . $tabela->getNome()."->get".$coluna->getNomeMaiusculo()."()->get".$coluna->getFkChaveMaiusculo()."() . \"/>"."\" .$".$tabela->getNome()."->get".$coluna->getNomeMaiusculo()."()->get".$coluna->getFkChaveMaiusculo()."() . "."\"</option>\";".$quebra);
												fwrite($open,"    foreach($"."lista".$coluna->getFkTabelaMaiusculo()." as $".$coluna->getNome()."){".$quebra);
												fwrite($open,"			echo \"<option value=\".$" . $coluna->getNome()."->get".$coluna->getFkChaveMaiusculo(). "().\""."".""."/>\";".$quebra);
												fwrite($open,"			echo $".$coluna->getNome()."->get".$coluna->getFkChaveMaiusculo()."();".$quebra);
												fwrite($open,"			echo \""."</option>\";".$quebra);
												fwrite($open,"	  }".$quebra);
												fwrite($open,"?>".$quebra);
												fwrite($open,"</select><br />".$quebra);
												fwrite($open,"</label>".$quebra);
										}
									}
								}
							}

						}
					}
				} //fim do foreach

		fwrite($open,"<input type=\"submit\" name=\"comando\" id=\"comando\" value=\"Gravar\" />".$quebra);
		fwrite($open,"<input type=\"submit\" name=\"comando\" id=\"comando\" value=\"Excluir\" />".$quebra);
		fwrite($open,"<input type=\"submit\" name=\"comando\" id=\"comando\" value=\"Pesquisar\" />".$quebra);
		fwrite($open,"</form>".$quebra);
		fwrite($open,"<br />".$quebra);
		fwrite($open,"<p align=\"center\"><a href=\"../index.php\""."> Voltar para o menu principal </a></p>".$quebra);


		fwrite($open,"</body>".$quebra);
		fwrite($open,"</html".$quebra);
		fclose($open);

		} // fim do laço de tabelas 

	} //fim da função GerarViewCadastrar
	/////////////////////////////////////////////////////////////////////////////////////



		/////////////////////////////////////////////////////////////////////////////////////
		//Função responsável por gerar o controller 
		public function GerarController($tabelas){

			$post = "_POST";
			foreach($tabelas as $tabela) {

				$open = fopen('../util/Gerados/'.$this->nomePasta.'/controller/'.$tabela->getNomeMaiusculo().'CTR.php','a');
				$quebra = chr(13).chr(10);//essa é a quebra de linha
				//escrevendo linha por linha no arquivo 
				fwrite($open,"<?php".$quebra);

				//criando o include_once com o nome da classe que está sendo tratada
				fwrite($open,"	include_once(\"../dao/".$tabela->getNomeMaiusculo()."DAO.php\");".$quebra);
				fwrite($open,"	include_once(\"../util/Funcoes.php\");".$quebra);
				fwrite($open,"	include_once(\"../util/Mensagens.php\");".$quebra);
				fwrite($open,"".$quebra);
				//fim includes

				fwrite($open,"	Funcoes::setarCaracteres();".$quebra);
				fwrite($open,"".$quebra);

				//laço para passar em todas colunas da tabela para criar os POSTS
				foreach($tabela->getColunas() as $coluna){
					fwrite($open,"		$".$coluna->getNome()." = $".$post."['".$coluna->getNome()."'];".$quebra);
				}// fim laço de colunas


				fwrite($open,"".$quebra);
				fwrite($open,"		$".$tabela->getNome()." = new ".$tabela->getNomeMaiusculo()."();".$quebra);


				//Laço para passar em todas colunas da tabela e criar os sets
				foreach($tabela->getColunas() as $coluna){
					//verificando se o campo não é uma chave estrangeira
					if(!($coluna->getChave() == "MUL")){
						fwrite($open,"		$".$tabela->getNome()."->set".$coluna->getNomeMaiusculo()."($".$coluna->getNome().");".$quebra);
					} 
					if($coluna->getChave() == "MUL"){
						fwrite($open,"		$".$tabela->getNome()."->"."get".$coluna->getNomeMaiusculo()."()->set".$coluna->getFkChaveMaiusculo()."($".$coluna->getNome().");".$quebra);
					}
				}// fim laço de colunas

				//gerando a chamada para o método gravar do controller
				fwrite($open,"".$quebra);
				fwrite($open,"	if($".$post."[\"comando\"] == \"Gravar\"){".$quebra);
				fwrite($open,"		$".$tabela->getNome()."DAO = new ".$tabela->getNomeMaiusculo()."DAO();".$quebra);
				fwrite($open,"		if ($".$tabela->getNome()."DAO->gravar($".$tabela->getNome()."))".$quebra);
				fwrite($open,"			Mensagem::msgSucesso();".$quebra);
				fwrite($open,"		else".$quebra);
				fwrite($open,"			Mensagem::msgErro();".$quebra);
				fwrite($open,"		unset($".$tabela->getNome()."DAO);".$quebra);
				fwrite($open,"		Funcoes::criarLink(\"../view/".$tabela->getNome()."_cadastrar.php\",\"Voltar\");".$quebra);
				fwrite($open,"	}".$quebra);
				fwrite($open,"".$quebra);
				//fim

				//gerando a chamada para o método excluir do controller
				fwrite($open,"".$quebra);
				fwrite($open,"	if($".$post."[\"comando\"] == \"Excluir\"){".$quebra);
				fwrite($open,"		$".$tabela->getNome()."DAO = new ".$tabela->getNomeMaiusculo()."DAO();".$quebra);
				fwrite($open,"		if ($".$tabela->getNome()."DAO->excluir($".$tabela->getNome()."))".$quebra);
				fwrite($open,"			Mensagem::msgSucesso();".$quebra);
				fwrite($open,"		else".$quebra);
				fwrite($open,"			Mensagem::msgErro();".$quebra);
				fwrite($open,"		unset($".$tabela->getNome()."DAO);".$quebra);
				fwrite($open,"		Funcoes::criarLink(\"../view/".$tabela->getNome()."_cadastrar.php\",\"Voltar\");".$quebra);
				fwrite($open,"	}".$quebra);
				fwrite($open,"".$quebra);
				//fim

				//gerando a chamada para a página pesquisar
				fwrite($open,"".$quebra);
				fwrite($open,"	if($".$post."[\"comando\"] == \"Pesquisar\"){".$quebra);
				fwrite($open,"		header(\"Location: ../view/".$tabela->getNome()."_pesquisar.php\");".$quebra);
				fwrite($open,"	}".$quebra);
				fwrite($open,"".$quebra);
				fwrite($open,"".$quebra);
				//fim

				fwrite($open,"?>".$quebra);


			}

		}/////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////
		/////////////////..Fim função gerar controller


		/////////////////////////////////////////////////////////////////////////////////////
		//////////////..Função gerar util Mensagens
		public function GerarUtil(){
			$open = fopen('../util/Gerados/'.$this->nomePasta.'/util/Mensagens.php','a');
			$quebra = chr(13).chr(10);//essa é a quebra de linha
			//escrevendo linha por linha no arquivo 
			fwrite($open,"<?php".$quebra);
			fwrite($open,"class Mensagem{".$quebra);
			fwrite($open,"".$quebra);
			fwrite($open,"".$quebra);
			fwrite($open,"	public static function msgSucesso(){".$quebra);
			fwrite($open,"		echo \"<p align=\\\"center\\\"> Operação realizada com sucesso! </p>\";".$quebra);
			fwrite($open,"	}".$quebra);
			fwrite($open,"".$quebra);
			fwrite($open,"	public static function msgErro(){".$quebra);
			fwrite($open,"		echo \"<p align=\\\"center\\\"> <font color=\\\"red\\\"> Não foi possível realizar a operação, tente novamente! </font> </P>\";".$quebra);
			fwrite($open,"	}".$quebra);
			fwrite($open,"".$quebra);
			fwrite($open,"".$quebra);
			fwrite($open,"}".$quebra);
			fwrite($open,"".$quebra);
			fwrite($open,"?>".$quebra);

		}
		//Fim função gerar util Mensagens

		/////////////////////////////////////////////////////////////////////////////////////
		//////////////..Função gerar DAO
		public function GerarDAO($tabelas){
			foreach($tabelas as $tabela){
				$open = fopen('../util/Gerados/'.$this->nomePasta.'/dao/'.$tabela->getNomeMaiusculo().'DAO.php','a');
				$quebra = chr(13).chr(10);//essa é a quebra de linha
				fwrite($open,"<?php".$quebra);
				fwrite($open,"	include_once(\"Conexao.php\");".$quebra);
				fwrite($open,"	include_once(\"../model/".$tabela->getNomeMaiusculo().".php\");".$quebra);
				if($tabela->verificaTabEstrangeira()){
						foreach($tabela->getColunas() as $coluna){
							if($coluna->getChave() == "MUL"){
								fwrite($open,"	include_once(\"".$coluna->getFkTabelaMaiusculo()."DAO.php\");".$quebra);
							}
						}
				}
				fwrite($open,"".$quebra);
				fwrite($open,"Class ".$tabela->getNomeMaiusculo()."DAO{".$quebra);
				fwrite($open,"".$quebra);
				fwrite($open,"	private $"."link;".$quebra);
				fwrite($open,"	private $"."sql;".$quebra);
				fwrite($open,"".$quebra);
				fwrite($open,"	function __construct(){".$quebra);
				fwrite($open,"		$"."this->link = Conexao::getConnection();".$quebra);
				fwrite($open,"	}".$quebra);
				fwrite($open,"".$quebra);
				fwrite($open,"".$quebra);
				fwrite($open,"	function __destruct(){".$quebra);	
				fwrite($open,"		Conexao::closeConnection($"."this->link);".$quebra);	
				fwrite($open,"	}".$quebra);
				fwrite($open,"".$quebra);
				fwrite($open,"".$quebra);

				//função gravar
				fwrite($open,"	function gravar($".$tabela->getNome()."){".$quebra);
				fwrite($open,"".$quebra);

				$array = array();
				foreach($tabela->getColunas() as $coluna){
					//verificando se o atributo/coluna NÃO é chave estrangeira
					if(!($coluna->getChave() == "MUL")){
						fwrite($open,"		$".$coluna->getNome()." = $".$tabela->getNome()."->get".$coluna->getNomeMaiusculo()."();".$quebra);
					}else{
						fwrite($open,"		$".$coluna->getNome()." = $".$tabela->getNome()."->get".$coluna->getNomeMaiusculo()."()->get".$coluna->getFkChaveMaiusculo()."();".$quebra);
					}

					//colocando as colunas em um array
					$array[] = $coluna->getNome();

				} //fim foreach

				fwrite($open,"".$quebra);
				fwrite($open,"".$quebra);
				foreach($tabela->getColunas() as $coluna){
					if($coluna->getChave() == "PRI"){
							fwrite($open,"		if($".$tabela->getNome()."->get".$coluna->getNomeMaiusculo()."() == null){".$quebra);
					}
				}

				$sql  = "INSERT INTO ".$tabela->getNome();				
  				$sql .= " (".implode(", ", $array).")";   				
 				$sql .= " VALUES ('$".implode("', '$", $array)."') ";

				fwrite($open,"			$"."this->sql = \"".$sql."\";".$quebra);
				fwrite($open,"		}".$quebra);
				fwrite($open,"		else{".$quebra);


				//no caso abaixo quando for o último elemento do array, a vírgula não será concatenada
				$sql  = "UPDATE ".$tabela->getNome()." set ";	
				$elementos = count($array);
				$i = 1;	
				foreach($tabela->getColunas() as $coluna){
					if(!($coluna->getChave() == "PRI"))	{
	  					$sql .= $coluna->getNome()." ='$".$coluna->getNome()."'"; 

	  					if(!($i==$elementos)){
	  						$sql .= ", ";
	  					}
  					}
  					$i++;
  				}
  				foreach($tabela->getColunas() as $coluna){
  					if($coluna->getChave() == "PRI"){
  						$sql .= " where ".$coluna->getNome()." = '$".$coluna->getNome()."'";
  					}
  				}		

				fwrite($open,"			$"."this->sql = \"".$sql."\";".$quebra);
				fwrite($open,"		}".$quebra);
				fwrite($open,"		$"."resultado = mysql_query($"."this->sql,$"."this->link);".$quebra);
				fwrite($open,"		if($"."resultado)".$quebra);
				fwrite($open,"			return true;".$quebra);
				fwrite($open,"		else".$quebra);
				fwrite($open,"			return false;".$quebra);
				fwrite($open,"	}".$quebra);
				fwrite($open,"".$quebra);
				//fim da função gravar

				//função excluir
				fwrite($open,"	function excluir($".$tabela->getNome()."){".$quebra);

				//encontrando a chave primária
				foreach($tabela->getColunas() as $coluna){
					if($coluna->getChave() == "PRI"){
						fwrite($open,"		$".$coluna->getNome()." = $".$tabela->getNome()."->get".$coluna->getNomeMaiusculo()."();".$quebra);
						fwrite($open,"		$"."this->sql = \"delete from ".$tabela->getNome()." where ".$coluna->getNome()." = '$".$coluna->getNome()."'\";".$quebra);

					}
				}
				fwrite($open,"		$"."resultado = mysql_query($"."this->sql,$"."this->link);".$quebra);
				fwrite($open,"		if($"."resultado > 0)".$quebra);
				fwrite($open,"			return true;".$quebra);
				fwrite($open,"		else".$quebra);
				fwrite($open,"			return false;".$quebra);
				fwrite($open,"	}".$quebra);
				fwrite($open,"".$quebra);
				//fim da função excluir

				//responsável por gerar o obterPorId
				foreach($tabela->getColunas() as $coluna){
					//verifica se é chave primária
					if($coluna->getChave() == "PRI"){
						fwrite($open,"	function obterPorId($".$coluna->getNome()."){".$quebra);
						fwrite($open,"		$"."this->sql = \"select * from ".$tabela->getNome()." where ".$coluna->getNome()." = '$".$coluna->getNome()."'\";".$quebra);
					}
				}
				fwrite($open,"		$"."resultado = mysql_query($"."this->sql,$"."this->link);".$quebra);
				fwrite($open,"		if(mysql_num_rows($"."resultado) > 0){".$quebra);
				fwrite($open,"			$"."registro = mysql_fetch_array($"."resultado);".$quebra);
				fwrite($open,"			$".$tabela->getNome()." = new ".$tabela->getNomeMaiusculo()."();".$quebra);
				foreach($tabela->getColunas() as $coluna){
					//verifica se a coluna não é chave estrangeira
					if(!($coluna->getChave() == "MUL")){
						fwrite($open,"			$".$tabela->getNome()."->set".$coluna->getNomeMaiusculo()."($"."registro[\"".$coluna->getNome()."\"]);".$quebra);
					}
					//se for chave estrangeira, executa abaixo
					if($coluna->getChave() == "MUL"){
						fwrite($open,"			$".$coluna->getFkTabela()."DAO = new ".$coluna->getFkTabelaMaiusculo()."DAO();".$quebra);
						fwrite($open,"			$".$tabela->getNome()."->set".$coluna->getNomeMaiusculo()."($".$coluna->getFkTabela()."DAO->obterPorId($"."registro[\"".$coluna->getNome()."\"]));".$quebra);
						fwrite($open,"			unset($".$coluna->getFkTabela()."DAO);".$quebra);
					}
				}
				fwrite($open,"		return $".$tabela->getNome().";".$quebra);
				fwrite($open,"		}".$quebra);
				fwrite($open,"	}".$quebra);
				//fim do obterPorId


				//function obterTodos
				fwrite($open,"	function obterTodos(){".$quebra);
				fwrite($open,"		$"."this->sql = \"select * from ".$tabela->getNome()."\";".$quebra);
				fwrite($open,"		$"."resultado = mysql_query($"."this->sql,$"."this->link);".$quebra);
				fwrite($open,"		$"."linhas = mysql_num_rows($"."resultado);".$quebra);
				fwrite($open,"		if($"."linhas > 0){".$quebra);
				fwrite($open,"			$"."array".$tabela->getNomeMaiusculo()." = array();".$quebra);
				fwrite($open,"			$"."i = 0;".$quebra);
				fwrite($open,"			while($"."registros = mysql_fetch_array($"."resultado)){".$quebra);
				fwrite($open,"				$".$tabela->getNome()." = new ".$tabela->getNomeMaiusculo()."();".$quebra);
				foreach($tabela->getColunas() as $coluna){
					//verifica se a coluna não é chave estrangeira
					if(!($coluna->getChave() == "MUL")){
						fwrite($open,"				$".$tabela->getNome()."->set".$coluna->getNomeMaiusculo()."($"."registros[\"".$coluna->getNome()."\"]);".$quebra);
					} 
					if($coluna->getChave() == "MUL"){
						fwrite($open,"				$".$coluna->getFkTabela()."DAO = new ".$coluna->getFkTabelaMaiusculo()."DAO();".$quebra);
						fwrite($open,"				$".$tabela->getNome()."->set".$coluna->getNomeMaiusculo()."($".$coluna->getFkTabela()."DAO->obterPorId($"."registros[\"".$coluna->getNome()."\"]));".$quebra);
						fwrite($open,"				unset($".$coluna->getFkTabela()."DAO);".$quebra);
					}
				}

				fwrite($open,"				$"."array".$tabela->getNomeMaiusculo()."[$"."i]=$".$tabela->getNome().";".$quebra);
				fwrite($open,"				$"."i++;".$quebra);
				fwrite($open,"			}".$quebra);
				fwrite($open,"			return $"."array".$tabela->getNomeMaiusculo().";".$quebra);
				fwrite($open,"		}".$quebra);
				fwrite($open,"	}".$quebra);

				//fim função obterTodos



				fwrite($open,"}".$quebra);
				fwrite($open,"?>".$quebra);	
				fwrite($open,"".$quebra);
			}
		}
		//FIM FUNÇÃO GERAR DAO
		///////////////////////////////////////////////////////////////////

		///////////////////////////////////////////////////////////////////
		////////////// Função Gerar Conexão
		public function GerarConexao($banco){
			$open = fopen('../util/Gerados/'.$this->nomePasta.'/dao/Conexao.php','a');
			$quebra = chr(13).chr(10);//essa é a quebra de linha

			fwrite($open,"<?php".$quebra);	
			fwrite($open,"	Class Conexao{".$quebra);
			fwrite($open,"".$quebra);
			fwrite($open,"		private static $"."host = \"".$banco->getServidor()."\";".$quebra);
			fwrite($open,"		private static $"."usuario = \"".$banco->getUsuario()."\";".$quebra);
			fwrite($open,"		private static $"."senha = \"".$banco->getSenha()."\";".$quebra);
			fwrite($open,"		private static $"."banco = \"".$banco->getNome()."\";".$quebra);
			fwrite($open,"		private static $"."link;".$quebra);
			fwrite($open,"".$quebra);
			fwrite($open,"		public static function getConnection(){".$quebra);
			fwrite($open,"			self::$"."link = mysql_connect(self::$"."host, self::$"."usuario, self::$"."senha);".$quebra);
			fwrite($open,"			if(!self::$"."link)".$quebra);
			fwrite($open,"				die('Falha ao conectar no banco de dados: ' . mysql_error());".$quebra);
			fwrite($open,"			$"."db_selected = mysql_select_db(self::$"."banco, self::$"."link);".$quebra);
			fwrite($open,"			if(!$"."db_selected)".$quebra);
			fwrite($open,"				die(\"Falha ao selecionar o banco: \" . mysql_error());".$quebra);
			fwrite($open,"".$quebra);
			fwrite($open,"			mysql_query(\"SET NAMES 'utf8'\");".$quebra);
			fwrite($open,"			mysql_query('SET character_set_connection=utf8');".$quebra);
			fwrite($open,"			mysql_query('SET character_set_client=utf8');".$quebra);
			fwrite($open,"			mysql_query('SET character_set_results=utf8');".$quebra);
			fwrite($open,"".$quebra);
			fwrite($open,"			return self::$"."link;".$quebra);
			fwrite($open,"		}".$quebra);
			fwrite($open,"".$quebra);
			fwrite($open,"		public static function closeConnection($"."link){".$quebra);
			fwrite($open,"			@mysql_close($"."link);".$quebra);
			fwrite($open,"		}".$quebra);
			fwrite($open,"".$quebra);
			fwrite($open,"	}".$quebra);
			fwrite($open,"".$quebra);
			fwrite($open,"?>".$quebra);
		}//fim da função gerar Conexão

		////////////////////////////////////////////
		// Função GerarFunções
		public function GerarFuncoes(){
			$open = fopen('../util/Gerados/'.$this->nomePasta.'/util/Funcoes.php','a');
			$quebra = chr(13).chr(10);//essa é a quebra de linha
			fwrite($open,"<?php".$quebra);	
			fwrite($open,"	Class Funcoes{".$quebra);
			fwrite($open,"".$quebra);
			fwrite($open,"		public static function criarLink($"."paginaDestino, $"."texto){".$quebra);
			fwrite($open,"			echo \"<p align=\\\"center\\\"> <a href=\\\"$"."paginaDestino\\\"> $"."texto </a> </p>\";".$quebra);
			fwrite($open,"		}".$quebra);
			fwrite($open,"".$quebra);
			fwrite($open,"		public static function setarCaracteres(){".$quebra);
			fwrite($open,"			header(\"Content-Type: text/html; charset=ytf-8\",true);".$quebra);
			fwrite($open,"		}".$quebra);
			fwrite($open,"".$quebra);
			fwrite($open,"	}".$quebra);
			fwrite($open,"?>".$quebra);

		}//fim GerarFuncoes
		/////////////////////////////////////////////////


		//Função view Pesquisar
		public function GerarViewPesquisar($tabelas){

			foreach($tabelas as $tabela) {

			$open = fopen('../util/Gerados/'.$this->nomePasta.'/view/'.$tabela->getNome().'_pesquisar.php','a');
			$quebra = chr(13).chr(10);//essa é a quebra de linha
			//escrevendo linha por linha no arquivo 
			fwrite($open,"<?php".$quebra);
			fwrite($open,"	include_once(\"../dao/".$tabela->getNomeMaiusculo()."DAO.php\");".$quebra);
			fwrite($open,"	include_once(\"../util/Funcoes.php\");".$quebra);
			fwrite($open,"	Funcoes::setarCaracteres();".$quebra);
			fwrite($open,"".$quebra);
			fwrite($open,"	$"."lista".$tabela->getNomeMaiusculo()." = NULL;".$quebra);
			fwrite($open,"	$"."todos = NULL;".$quebra);
			fwrite($open,"".$quebra);
			fwrite($open,"	if(isset($"."_POST['comando']) and"."($"."_POST['comando'] == "."\"Pesquisar"."\")){".$quebra);

			foreach($tabela->getColunas() as $coluna){
				if($coluna->getChave() == "PRI"){
					fwrite($open,"		$".$coluna->getNome()." = $"."_POST['".$coluna->getNome()."'];".$quebra);
					fwrite($open,"		$".$tabela->getNome()."DAO = new ".$tabela->getNomeMaiusculo()."DAO();".$quebra);
					fwrite($open,"		$"."lista".$tabela->getNomeMaiusculo()." = $".$tabela->getNome()."DAO->obterPorId($".$coluna->getNome().");".$quebra);
					fwrite($open,"	}else{".$quebra);
					fwrite($open,"		if(isset($"."_POST['comando']) and"."($"."_POST['comando'] == "."\"Mostrar Todos Registros"."\")){".$quebra);
					fwrite($open,"			$".$tabela->getNome()."DAO = new ".$tabela->getNomeMaiusculo()."DAO();".$quebra);
					fwrite($open,"			$"."todos = $".$tabela->getNome()."DAO->obterTodos();".$quebra);
					fwrite($open,"		}".$quebra);
					fwrite($open,"	}".$quebra);
					fwrite($open,"".$quebra);
					fwrite($open,"?>".$quebra);
					//criando o cabeçalho
					fwrite($open,"".$quebra);
					fwrite($open,"<!DOCTYPE html>".$quebra);
					fwrite($open,"<html>".$quebra);
					fwrite($open,"<head>".$quebra);
					fwrite($open,"<title>Pesquisa De ".$tabela->getNomeMaiusculo()."</title>".$quebra);
					fwrite($open,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />".$quebra);
					fwrite($open,"</head>".$quebra);
					fwrite($open,"<body>".$quebra);
					fwrite($open,"<h1>Pesquisa De ".$tabela->getNomeMaiusculo(). "</h1>".$quebra);
					fwrite($open,"".$quebra);
					//fim do cabeçalho

					fwrite($open,"<form action=\"".$tabela->getNome()."_pesquisar.php\" method=\"post\">".$quebra);
					fwrite($open,"<input name=\"".$coluna->getNome()."\" type=\"text\" size=\"50\" placeholder=\"Informe o código\"/>".$quebra);
					fwrite($open,"<label>".$quebra);
					fwrite($open,"	<input type=\"submit\" name=\"comando\" id=\"button\" value=\"Pesquisar\" />".$quebra);
					fwrite($open,"	<input type=\"submit\" name=\"comando\" id=\"button\" value=\"Mostrar Todos Registros\" />".$quebra);
					fwrite($open,"</label>".$quebra);
					fwrite($open,"</form>".$quebra);
					fwrite($open,"".$quebra);
					fwrite($open,"<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\">".$quebra);
					fwrite($open,"	<tr>".$quebra);

				}
			}//fim foreach de colunas

			//foreach colunas
			foreach($tabela->getColunas() as $coluna){
				if($coluna->getChave() == "PRI"){
					$texto = " 		<th> ".$coluna->getNomeMaiusculo()." </th> ";
				}

			}//fim foreach colunas

			foreach($tabela->getColunas() as $coluna){
				if(!($coluna->getChave() == "PRI") and !($coluna->getChave() == "MUL")){
					$texto .= " <th> ".$coluna->getNome()." </th> ";
				}
			}//fim foreach de colunas

			$texto .= " <th> Editar </th>";

			fwrite($open,"$texto".$quebra);
			fwrite($open,"	</tr>".$quebra);
			fwrite($open,"<?php".$quebra);
			fwrite($open,"	if($"."lista".$tabela->getNomeMaiusculo()." != NULL){".$quebra);
			fwrite($open,"		echo \"<tr>\";".$quebra);
			
			foreach($tabela->getColunas() as $coluna){
				if($coluna->getChave() == "PRI"){
					fwrite($open,"		echo \"<td>\" . $"."lista".$tabela->getNomeMaiusculo()."->get".$coluna->getNomeMaiusculo()."() . \"</td>\";".$quebra);
				}
				if(!($coluna->getChave() == "PRI") and !($coluna->getChave() == "MUL")){
					fwrite($open,"		echo \"<td>\" . $"."lista".$tabela->getNomeMaiusculo()."->get".$coluna->getNomeMaiusculo()."() . \"</td>\";".$quebra);
				}
			}//fim foreach de colunas

			foreach($tabela->getColunas() as $coluna){
				if($coluna->getChave() == "PRI"){
					fwrite($open,"		echo \"<td> <a href=".$tabela->getNome()."_cadastrar.php?".$coluna->getNome()."=\".$"."lista".$tabela->getNomeMaiusculo()."->get".$coluna->getNomeMaiusculo()."().\">Editar</a> </td>\";".$quebra);
				}

			}//fim foreach

			fwrite($open,"		echo \"</tr>\";".$quebra);
			fwrite($open,"	}	else{".$quebra);
			fwrite($open,"			if($"."todos != NULL){".$quebra);
			fwrite($open,"			foreach($"."todos as $".$tabela->getNome()."){".$quebra);
			fwrite($open,"				echo \"<tr>\";".$quebra);
			foreach($tabela->getColunas() as $coluna){
				if($coluna->getChave() == "PRI"){
					fwrite($open,"				echo \"<td>\" . $".$tabela->getNome()."->get".$coluna->getNomeMaiusculo()."() . \"</td>\";".$quebra);
				}
				if(!($coluna->getChave() == "PRI") and !($coluna->getChave() == "MUL")){
					fwrite($open,"				echo \"<td>\" . $".$tabela->getNome()."->get".$coluna->getNomeMaiusculo()."() . \"</td>\";".$quebra);
				}
			}//fim foreach de colunas

			foreach($tabela->getColunas() as $coluna){
				if($coluna->getChave() == "PRI"){
					fwrite($open,"				echo \"<td> <a href=".$tabela->getNome()."_cadastrar.php?".$coluna->getNome()."=\".$".$tabela->getNome()."->get".$coluna->getNomeMaiusculo()."().\">Editar</a> </td>\";".$quebra);
				}

			}//fim foreach
			fwrite($open,"			}".$quebra);
			fwrite($open,"		}".$quebra);
			fwrite($open,"	}".$quebra);
			fwrite($open,"?>".$quebra);
			fwrite($open,"</table>".$quebra);
			fwrite($open,"<?php".$quebra);
			fwrite($open,"	Funcoes::criarLink(\"".$tabela->getNome()."_cadastrar.php\",\"Cadastrar ".$tabela->getNomeMaiusculo()."\");".$quebra);
			fwrite($open,"?>".$quebra);
			fwrite($open,"</body>".$quebra);
			fwrite($open,"</html>".$quebra);
			}//fim foreach de tabelas
		}//fim GerarViewPesquisar

		////////////////////////////////////////////////
		///////////////////// Função GerarIndex

		public function GerarIndex($tabelas){
			$open = fopen('../util/Gerados/'.$this->nomePasta.'/index.php','a');
			$quebra = chr(13).chr(10);//essa é a quebra de linha

			//criando o cabeçalho
				fwrite($open,"<!DOCTYPE html>".$quebra);
				fwrite($open,"<html>".$quebra);
				fwrite($open,"<head>".$quebra);
				fwrite($open,"<title>Cadastros/Pesquisas</title>".$quebra);
				fwrite($open,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />".$quebra);
				fwrite($open,"</head>".$quebra);
				fwrite($open,"<body>".$quebra);
				fwrite($open,"<h4>Olá, bem vindo(a) ao menu:</h4>".$quebra);
				fwrite($open,"".$quebra);
				fwrite($open,"<ul>".$quebra);
			//fim cabeçalho

			foreach($tabelas as $tabela) {
				
				fwrite($open,"	<li> <a href=\"view/".$tabela->getNome()."_cadastrar.php\"> Cadastro/Pesquisa de ".$tabela->getNomeMaiusculo()."</a> </li>".$quebra);

			}

			fwrite($open,"</ul>".$quebra);
			fwrite($open,"</body>".$quebra);
			fwrite($open,"</html>".$quebra);
		}//Fim Gerar Index



  }//fim BancoDAO

?>