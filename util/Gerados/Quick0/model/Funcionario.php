<?php
 include_once("Cargo.php");
 
	Class Funcionario {
 
 		private $cod_funcionario;
 		private $nome;
 		private $cpf;
 		private $ddd;
 		private $telefone;
 		private $salario;
 		private $cargo;

		function __construct(){
			$this->cargo = new Cargo();
		}

 		public function setCod_funcionario($cod_funcionario){
 			$this->cod_funcionario = $cod_funcionario;
 		}

 		public function getCod_funcionario(){
 			return $this->cod_funcionario;
 		}

 		public function setNome($nome){
 			$this->nome = $nome;
 		}

 		public function getNome(){
 			return $this->nome;
 		}

 		public function setCpf($cpf){
 			$this->cpf = $cpf;
 		}

 		public function getCpf(){
 			return $this->cpf;
 		}

 		public function setDdd($ddd){
 			$this->ddd = $ddd;
 		}

 		public function getDdd(){
 			return $this->ddd;
 		}

 		public function setTelefone($telefone){
 			$this->telefone = $telefone;
 		}

 		public function getTelefone(){
 			return $this->telefone;
 		}

 		public function setSalario($salario){
 			$this->salario = $salario;
 		}

 		public function getSalario(){
 			return $this->salario;
 		}

 		public function setCargo($cargo){
 			$this->cargo = $cargo;
 		}

 		public function getCargo(){
 			return $this->cargo;
 		}

	}

?>