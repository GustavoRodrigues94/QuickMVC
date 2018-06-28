
<?php
	include_once("../model/Banco.php");
	include_once("../dao/BancoDAO.php");
	include_once("../util/Funcoes.php");
	
		
	//..pegando as variáveis via POST
	$servidor = $_POST['servidor'];
	$usuario = $_POST['usuario'];
	$senha = $_POST['senha'];
	$nomeBanco = $_POST['nomeBanco'];

	
	//..se o comando for gerar, então...
	if($_POST["comando"] == "Gerar Código"){
		if($banco = new Banco($nomeBanco, $servidor, $usuario, $senha)){
			//invoca a classe BancoDAO
			$bancoDAO = new BancoDAO();
			//gera as pastas na arquitetura MVC e retorna o nome da pasta
			$nomePasta = Funcoes::GerarPastasMVC();
			
			$banco->leTabelas();
			$tabelas = $banco->getTabelas();
			$bancoDAO->GerarModel($nomePasta, $tabelas);
			$bancoDAO->GerarViewCadastrar($tabelas);
			$bancoDAO->GerarViewPesquisar($tabelas);
			$bancoDAO->GerarController($tabelas);
			$bancoDAO->GerarUtil();
			$bancoDAO->GerarDAO($tabelas);
			$bancoDAO->GerarConexao($banco);
			$bancoDAO->GerarFuncoes();
			$bancoDAO->GerarIndex($tabelas);
			echo " <p align='center'>Arquitetura MVC gerada com sucesso! </br></p>";

			echo "<p align='center'> Pasta gerada: <font color='purple'><b>".$nomePasta."</font></b></p>";


		}else{
			echo "não conectado";
		}
	    //..destrói o objeto e fecha a conexão com o banco através do destruct
		unset($banco);
	}
  
?>