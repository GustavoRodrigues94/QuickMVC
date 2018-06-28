<?php
	include_once("Conexao.php");
	include_once("../model/Projeto.php");

Class ProjetoDAO{

	private $link;
	private $sql;

	function __construct(){
		$this->link = Conexao::getConnection();
	}


	function __destruct(){
		Conexao::closeConnection($this->link);
	}


	function gravar($projeto){

		$cod_projeto = $projeto->getCod_projeto();
		$nome_projeto = $projeto->getNome_projeto();
		$data_incio = $projeto->getData_incio();


		if($projeto->getCod_projeto() == null){
			$this->sql = "INSERT INTO projeto (cod_projeto, nome_projeto, data_incio) VALUES ('$cod_projeto', '$nome_projeto', '$data_incio') ";
		}
		else{
			$this->sql = "UPDATE projeto set nome_projeto ='$nome_projeto', data_incio ='$data_incio' where cod_projeto = '$cod_projeto'";
		}
		$resultado = mysql_query($this->sql,$this->link);
		if($resultado)
			return true;
		else
			return false;
	}

	function excluir($projeto){
		$cod_projeto = $projeto->getCod_projeto();
		$this->sql = "delete from projeto where cod_projeto = '$cod_projeto'";
		$resultado = mysql_query($this->sql,$this->link);
		if($resultado > 0)
			return true;
		else
			return false;
	}

	function obterPorId($cod_projeto){
		$this->sql = "select * from projeto where cod_projeto = '$cod_projeto'";
		$resultado = mysql_query($this->sql,$this->link);
		if(mysql_num_rows($resultado) > 0){
			$registro = mysql_fetch_array($resultado);
			$projeto = new Projeto();
			$projeto->setCod_projeto($registro["cod_projeto"]);
			$projeto->setNome_projeto($registro["nome_projeto"]);
			$projeto->setData_incio($registro["data_incio"]);
		return $projeto;
		}
	}
	function obterTodos(){
		$this->sql = "select * from projeto";
		$resultado = mysql_query($this->sql,$this->link);
		$linhas = mysql_num_rows($resultado);
		if($linhas > 0){
			$arrayProjeto = array();
			$i = 0;
			while($registros = mysql_fetch_array($resultado)){
				$projeto = new Projeto();
				$projeto->setCod_projeto($registros["cod_projeto"]);
				$projeto->setNome_projeto($registros["nome_projeto"]);
				$projeto->setData_incio($registros["data_incio"]);
				$arrayProjeto[$i]=$projeto;
				$i++;
			}
			return $arrayProjeto;
		}
	}
}
?>

