<?php
	include_once("../dao/CargoDAO.php");
	include_once("../util/Funcoes.php");
	include_once("../util/Mensagens.php");

	Funcoes::setarCaracteres();

		$cod_cargo = $_POST['cod_cargo'];
		$nome = $_POST['nome'];

		$cargo = new Cargo();
		$cargo->setCod_cargo($cod_cargo);
		$cargo->setNome($nome);

	if($_POST["comando"] == "Gravar"){
		$cargoDAO = new CargoDAO();
		if ($cargoDAO->gravar($cargo))
			Mensagem::msgSucesso();
		else
			Mensagem::msgErro();
		unset($cargoDAO);
		Funcoes::criarLink("../view/cargo_cadastrar.php","Voltar");
	}


	if($_POST["comando"] == "Excluir"){
		$cargoDAO = new CargoDAO();
		if ($cargoDAO->excluir($cargo))
			Mensagem::msgSucesso();
		else
			Mensagem::msgErro();
		unset($cargoDAO);
		Funcoes::criarLink("../view/cargo_cadastrar.php","Voltar");
	}


	if($_POST["comando"] == "Pesquisar"){
		header("Location: ../view/cargo_pesquisar.php");
	}


?>
