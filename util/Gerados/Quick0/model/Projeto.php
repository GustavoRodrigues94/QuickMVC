<?php
 
	Class Projeto {
 
 		private $cod_projeto;
 		private $nome_projeto;
 		private $data_incio;

 		public function setCod_projeto($cod_projeto){
 			$this->cod_projeto = $cod_projeto;
 		}

 		public function getCod_projeto(){
 			return $this->cod_projeto;
 		}

 		public function setNome_projeto($nome_projeto){
 			$this->nome_projeto = $nome_projeto;
 		}

 		public function getNome_projeto(){
 			return $this->nome_projeto;
 		}

 		public function setData_incio($data_incio){
 			$this->data_incio = $data_incio;
 		}

 		public function getData_incio(){
 			return $this->data_incio;
 		}

	}

?>