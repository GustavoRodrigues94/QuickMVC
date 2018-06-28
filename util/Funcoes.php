<?php

class Funcoes{

	//Função responsável por gerar uma pasta com nome único com a estrutura MVC (Model, View, Controller)
	public function GerarPastasMVC(){

		$aleatorio = 0;

		//Função dentro da função GerarPastasMVC responsável por gerar um número aleatório que irá concatenar com o nome da pasta, por exemplo: util/Gerados/Quick6548
		function GerarNumero(){
			$aleatorio = rand(0 , 9999);

			return $aleatorio;
		}

		//Laço infinito até criar uma pasta com nome único
		while(1){
			    $pathName = "../util/Gerados/Quick".$aleatorio;
			    if(!file_exists($pathName)){
					mkdir($pathName);
					break;
			    } else {
			    	$aleatorio = GerarNumero();
			    }
		}

		//setando os nomes das pastas que serão criadas
		$pastaController = $pathName."/controller/";
		$pastaDao = $pathName."/dao/";
		$pastaUtil = $pathName."/util/";
		$pastaModel= $pathName."/model/";
		$pastaView = $pathName."/view/";	

		//criando as pastas que acima foram setadas
		if(!file_exists($pastaController)) {
			if(!mkdir($pastaController)){
				die('Falha ao criar a pasta controller');
			}
		}

		if(!file_exists($pastaDao)) {
			if(!mkdir($pastaDao)){
				die('Falha ao criar a pasta dao');
			}
		}

		if(!file_exists($pastaUtil)) {
			if(!mkdir($pastaUtil)){
				die('Falha ao criar a pasta util');
			}
		}

		if(!file_exists($pastaModel)) {
			if(!mkdir($pastaModel)){
				die('Falha ao criar a pasta model');
			}
		}

		if(!file_exists($pastaView)) {
			if(!mkdir($pastaView)){
				die('Falha ao criar a pasta model');
			}
		}

		//Retorna o nome da pasta criada
		return "Quick".$aleatorio;

	}
	//Fim da função GerarPastasMVC

}


?>