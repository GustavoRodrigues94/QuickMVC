<?php
	include_once("../dao/ProjetofuncionarioDAO.php");
	include_once("../util/Funcoes.php");
	include_once("../util/Mensagens.php");

	Funcoes::setarCaracteres();

		$cod_projetofuncionario = $_POST['cod_projetofuncionario'];
		$projeto = $_POST['projeto'];
		$funcionario = $_POST['funcionario'];

		$projetofuncionario = new Projetofuncionario();
		$projetofuncionario->setCod_projetofuncionario($cod_projetofuncionario);
		$projetofuncionario->getProjeto()->setCod_projeto($projeto);
		$projetofuncionario->getFuncionario()->setCod_funcionario($funcionario);

	if($_POST["comando"] == "Gravar"){
		$projetofuncionarioDAO = new ProjetofuncionarioDAO();
		if ($projetofuncionarioDAO->gravar($projetofuncionario))
			Mensagem::msgSucesso();
		else
			Mensagem::msgErro();
		unset($projetofuncionarioDAO);
		Funcoes::criarLink("../view/projetofuncionario_cadastrar.php","Voltar");
	}


	if($_POST["comando"] == "Excluir"){
		$projetofuncionarioDAO = new ProjetofuncionarioDAO();
		if ($projetofuncionarioDAO->excluir($projetofuncionario))
			Mensagem::msgSucesso();
		else
			Mensagem::msgErro();
		unset($projetofuncionarioDAO);
		Funcoes::criarLink("../view/projetofuncionario_cadastrar.php","Voltar");
	}


	if($_POST["comando"] == "Pesquisar"){
		header("Location: ../view/projetofuncionario_pesquisar.php");
	}


?>
