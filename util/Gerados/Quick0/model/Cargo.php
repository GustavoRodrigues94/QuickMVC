<?php
 
	Class Cargo {
 
 		private $cod_cargo;
 		private $nome;

 		public function setCod_cargo($cod_cargo){
 			$this->cod_cargo = $cod_cargo;
 		}

 		public function getCod_cargo(){
 			return $this->cod_cargo;
 		}

 		public function setNome($nome){
 			$this->nome = $nome;
 		}

 		public function getNome(){
 			return $this->nome;
 		}

	}

?>