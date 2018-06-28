<?php
	include_once("Conexao.php");
	include_once("../model/Funcionario.php");
	include_once("CargoDAO.php");

Class FuncionarioDAO{

	private $link;
	private $sql;

	function __construct(){
		$this->link = Conexao::getConnection();
	}


	function __destruct(){
		Conexao::closeConnection($this->link);
	}


	function gravar($funcionario){

		$cod_funcionario = $funcionario->getCod_funcionario();
		$nome = $funcionario->getNome();
		$cpf = $funcionario->getCpf();
		$ddd = $funcionario->getDdd();
		$telefone = $funcionario->getTelefone();
		$salario = $funcionario->getSalario();
		$cargo = $funcionario->getCargo()->getCod_cargo();


		if($funcionario->getCod_funcionario() == null){
			$this->sql = "INSERT INTO funcionario (cod_funcionario, nome, cpf, ddd, telefone, salario, cargo) VALUES ('$cod_funcionario', '$nome', '$cpf', '$ddd', '$telefone', '$salario', '$cargo') ";
		}
		else{
			$this->sql = "UPDATE funcionario set nome ='$nome', cpf ='$cpf', ddd ='$ddd', telefone ='$telefone', salario ='$salario', cargo ='$cargo' where cod_funcionario = '$cod_funcionario'";
		}
		$resultado = mysql_query($this->sql,$this->link);
		if($resultado)
			return true;
		else
			return false;
	}

	function excluir($funcionario){
		$cod_funcionario = $funcionario->getCod_funcionario();
		$this->sql = "delete from funcionario where cod_funcionario = '$cod_funcionario'";
		$resultado = mysql_query($this->sql,$this->link);
		if($resultado > 0)
			return true;
		else
			return false;
	}

	function obterPorId($cod_funcionario){
		$this->sql = "select * from funcionario where cod_funcionario = '$cod_funcionario'";
		$resultado = mysql_query($this->sql,$this->link);
		if(mysql_num_rows($resultado) > 0){
			$registro = mysql_fetch_array($resultado);
			$funcionario = new Funcionario();
			$funcionario->setCod_funcionario($registro["cod_funcionario"]);
			$funcionario->setNome($registro["nome"]);
			$funcionario->setCpf($registro["cpf"]);
			$funcionario->setDdd($registro["ddd"]);
			$funcionario->setTelefone($registro["telefone"]);
			$funcionario->setSalario($registro["salario"]);
			$cargoDAO = new CargoDAO();
			$funcionario->setCargo($cargoDAO->obterPorId($registro["cargo"]));
			unset($cargoDAO);
		return $funcionario;
		}
	}
	function obterTodos(){
		$this->sql = "select * from funcionario";
		$resultado = mysql_query($this->sql,$this->link);
		$linhas = mysql_num_rows($resultado);
		if($linhas > 0){
			$arrayFuncionario = array();
			$i = 0;
			while($registros = mysql_fetch_array($resultado)){
				$funcionario = new Funcionario();
				$funcionario->setCod_funcionario($registros["cod_funcionario"]);
				$funcionario->setNome($registros["nome"]);
				$funcionario->setCpf($registros["cpf"]);
				$funcionario->setDdd($registros["ddd"]);
				$funcionario->setTelefone($registros["telefone"]);
				$funcionario->setSalario($registros["salario"]);
				$cargoDAO = new CargoDAO();
				$funcionario->setCargo($cargoDAO->obterPorId($registros["cargo"]));
				unset($cargoDAO);
				$arrayFuncionario[$i]=$funcionario;
				$i++;
			}
			return $arrayFuncionario;
		}
	}
}
?>

