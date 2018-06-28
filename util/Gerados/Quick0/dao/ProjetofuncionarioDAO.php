<?php
	include_once("Conexao.php");
	include_once("../model/Projetofuncionario.php");
	include_once("ProjetoDAO.php");
	include_once("FuncionarioDAO.php");

Class ProjetofuncionarioDAO{

	private $link;
	private $sql;

	function __construct(){
		$this->link = Conexao::getConnection();
	}


	function __destruct(){
		Conexao::closeConnection($this->link);
	}


	function gravar($projetofuncionario){

		$cod_projetofuncionario = $projetofuncionario->getCod_projetofuncionario();
		$projeto = $projetofuncionario->getProjeto()->getCod_projeto();
		$funcionario = $projetofuncionario->getFuncionario()->getCod_funcionario();


		if($projetofuncionario->getCod_projetofuncionario() == null){
			$this->sql = "INSERT INTO projetofuncionario (cod_projetofuncionario, projeto, funcionario) VALUES ('$cod_projetofuncionario', '$projeto', '$funcionario') ";
		}
		else{
			$this->sql = "UPDATE projetofuncionario set projeto ='$projeto', funcionario ='$funcionario' where cod_projetofuncionario = '$cod_projetofuncionario'";
		}
		$resultado = mysql_query($this->sql,$this->link);
		if($resultado)
			return true;
		else
			return false;
	}

	function excluir($projetofuncionario){
		$cod_projetofuncionario = $projetofuncionario->getCod_projetofuncionario();
		$this->sql = "delete from projetofuncionario where cod_projetofuncionario = '$cod_projetofuncionario'";
		$resultado = mysql_query($this->sql,$this->link);
		if($resultado > 0)
			return true;
		else
			return false;
	}

	function obterPorId($cod_projetofuncionario){
		$this->sql = "select * from projetofuncionario where cod_projetofuncionario = '$cod_projetofuncionario'";
		$resultado = mysql_query($this->sql,$this->link);
		if(mysql_num_rows($resultado) > 0){
			$registro = mysql_fetch_array($resultado);
			$projetofuncionario = new Projetofuncionario();
			$projetofuncionario->setCod_projetofuncionario($registro["cod_projetofuncionario"]);
			$projetoDAO = new ProjetoDAO();
			$projetofuncionario->setProjeto($projetoDAO->obterPorId($registro["projeto"]));
			unset($projetoDAO);
			$funcionarioDAO = new FuncionarioDAO();
			$projetofuncionario->setFuncionario($funcionarioDAO->obterPorId($registro["funcionario"]));
			unset($funcionarioDAO);
		return $projetofuncionario;
		}
	}
	function obterTodos(){
		$this->sql = "select * from projetofuncionario";
		$resultado = mysql_query($this->sql,$this->link);
		$linhas = mysql_num_rows($resultado);
		if($linhas > 0){
			$arrayProjetofuncionario = array();
			$i = 0;
			while($registros = mysql_fetch_array($resultado)){
				$projetofuncionario = new Projetofuncionario();
				$projetofuncionario->setCod_projetofuncionario($registros["cod_projetofuncionario"]);
				$projetoDAO = new ProjetoDAO();
				$projetofuncionario->setProjeto($projetoDAO->obterPorId($registros["projeto"]));
				unset($projetoDAO);
				$funcionarioDAO = new FuncionarioDAO();
				$projetofuncionario->setFuncionario($funcionarioDAO->obterPorId($registros["funcionario"]));
				unset($funcionarioDAO);
				$arrayProjetofuncionario[$i]=$projetofuncionario;
				$i++;
			}
			return $arrayProjetofuncionario;
		}
	}
}
?>

