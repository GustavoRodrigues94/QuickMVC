<?php
	include_once("../dao/FuncionarioDAO.php");
	include_once("../util/Funcoes.php");
	include_once("../util/Mensagens.php");

	Funcoes::setarCaracteres();

		$cod_funcionario = $_POST['cod_funcionario'];
		$nome = $_POST['nome'];
		$cpf = $_POST['cpf'];
		$ddd = $_POST['ddd'];
		$telefone = $_POST['telefone'];
		$salario = $_POST['salario'];
		$cargo = $_POST['cargo'];

		$funcionario = new Funcionario();
		$funcionario->setCod_funcionario($cod_funcionario);
		$funcionario->setNome($nome);
		$funcionario->setCpf($cpf);
		$funcionario->setDdd($ddd);
		$funcionario->setTelefone($telefone);
		$funcionario->setSalario($salario);
		$funcionario->getCargo()->setCod_cargo($cargo);

	if($_POST["comando"] == "Gravar"){
		$funcionarioDAO = new FuncionarioDAO();
		if ($funcionarioDAO->gravar($funcionario))
			Mensagem::msgSucesso();
		else
			Mensagem::msgErro();
		unset($funcionarioDAO);
		Funcoes::criarLink("../view/funcionario_cadastrar.php","Voltar");
	}


	if($_POST["comando"] == "Excluir"){
		$funcionarioDAO = new FuncionarioDAO();
		if ($funcionarioDAO->excluir($funcionario))
			Mensagem::msgSucesso();
		else
			Mensagem::msgErro();
		unset($funcionarioDAO);
		Funcoes::criarLink("../view/funcionario_cadastrar.php","Voltar");
	}


	if($_POST["comando"] == "Pesquisar"){
		header("Location: ../view/funcionario_pesquisar.php");
	}


?>
