<?php
 include_once("Projeto.php");
 include_once("Funcionario.php");
 
	Class Projetofuncionario {
 
 		private $cod_projetofuncionario;
 		private $projeto;
 		private $funcionario;

		function __construct(){
			$this->projeto = new Projeto();
			$this->funcionario = new Funcionario();
		}

 		public function setCod_projetofuncionario($cod_projetofuncionario){
 			$this->cod_projetofuncionario = $cod_projetofuncionario;
 		}

 		public function getCod_projetofuncionario(){
 			return $this->cod_projetofuncionario;
 		}

 		public function setProjeto($projeto){
 			$this->projeto = $projeto;
 		}

 		public function getProjeto(){
 			return $this->projeto;
 		}

 		public function setFuncionario($funcionario){
 			$this->funcionario = $funcionario;
 		}

 		public function getFuncionario(){
 			return $this->funcionario;
 		}

	}

?>