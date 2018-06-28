<?php
	include_once("../dao/ProjetoDAO.php");
	include_once("../util/Funcoes.php");
	include_once("../util/Mensagens.php");

	Funcoes::setarCaracteres();

		$cod_projeto = $_POST['cod_projeto'];
		$nome_projeto = $_POST['nome_projeto'];
		$data_incio = $_POST['data_incio'];

		$projeto = new Projeto();
		$projeto->setCod_projeto($cod_projeto);
		$projeto->setNome_projeto($nome_projeto);
		$projeto->setData_incio($data_incio);

	if($_POST["comando"] == "Gravar"){
		$projetoDAO = new ProjetoDAO();
		if ($projetoDAO->gravar($projeto))
			Mensagem::msgSucesso();
		else
			Mensagem::msgErro();
		unset($projetoDAO);
		Funcoes::criarLink("../view/projeto_cadastrar.php","Voltar");
	}


	if($_POST["comando"] == "Excluir"){
		$projetoDAO = new ProjetoDAO();
		if ($projetoDAO->excluir($projeto))
			Mensagem::msgSucesso();
		else
			Mensagem::msgErro();
		unset($projetoDAO);
		Funcoes::criarLink("../view/projeto_cadastrar.php","Voltar");
	}


	if($_POST["comando"] == "Pesquisar"){
		header("Location: ../view/projeto_pesquisar.php");
	}


?>
