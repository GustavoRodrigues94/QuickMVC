<?php
	include_once("Conexao.php");
	include_once("../model/Cargo.php");

Class CargoDAO{

	private $link;
	private $sql;

	function __construct(){
		$this->link = Conexao::getConnection();
	}


	function __destruct(){
		Conexao::closeConnection($this->link);
	}


	function gravar($cargo){

		$cod_cargo = $cargo->getCod_cargo();
		$nome = $cargo->getNome();


		if($cargo->getCod_cargo() == null){
			$this->sql = "INSERT INTO cargo (cod_cargo, nome) VALUES ('$cod_cargo', '$nome') ";
		}
		else{
			$this->sql = "UPDATE cargo set nome ='$nome' where cod_cargo = '$cod_cargo'";
		}
		$resultado = mysql_query($this->sql,$this->link);
		if($resultado)
			return true;
		else
			return false;
	}

	function excluir($cargo){
		$cod_cargo = $cargo->getCod_cargo();
		$this->sql = "delete from cargo where cod_cargo = '$cod_cargo'";
		$resultado = mysql_query($this->sql,$this->link);
		if($resultado > 0)
			return true;
		else
			return false;
	}

	function obterPorId($cod_cargo){
		$this->sql = "select * from cargo where cod_cargo = '$cod_cargo'";
		$resultado = mysql_query($this->sql,$this->link);
		if(mysql_num_rows($resultado) > 0){
			$registro = mysql_fetch_array($resultado);
			$cargo = new Cargo();
			$cargo->setCod_cargo($registro["cod_cargo"]);
			$cargo->setNome($registro["nome"]);
		return $cargo;
		}
	}
	function obterTodos(){
		$this->sql = "select * from cargo";
		$resultado = mysql_query($this->sql,$this->link);
		$linhas = mysql_num_rows($resultado);
		if($linhas > 0){
			$arrayCargo = array();
			$i = 0;
			while($registros = mysql_fetch_array($resultado)){
				$cargo = new Cargo();
				$cargo->setCod_cargo($registros["cod_cargo"]);
				$cargo->setNome($registros["nome"]);
				$arrayCargo[$i]=$cargo;
				$i++;
			}
			return $arrayCargo;
		}
	}
}
?>

