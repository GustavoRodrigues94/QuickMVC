<?php
	include_once("../dao/FuncionarioDAO.php");
	include_once("../util/Funcoes.php");
	Funcoes::setarCaracteres();

	$listaFuncionario = NULL;
	$todos = NULL;

	if(isset($_POST['comando']) and($_POST['comando'] == "Pesquisar")){
		$cod_funcionario = $_POST['cod_funcionario'];
		$funcionarioDAO = new FuncionarioDAO();
		$listaFuncionario = $funcionarioDAO->obterPorId($cod_funcionario);
	}else{
		if(isset($_POST['comando']) and($_POST['comando'] == "Mostrar Todos Registros")){
			$funcionarioDAO = new FuncionarioDAO();
			$todos = $funcionarioDAO->obterTodos();
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
<title>Pesquisa De Funcionario</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<h1>Pesquisa De Funcionario</h1>

<form action="funcionario_pesquisar.php" method="post">
<input name="cod_funcionario" type="text" size="50" placeholder="Informe o código"/>
<label>
	<input type="submit" name="comando" id="button" value="Pesquisar" />
	<input type="submit" name="comando" id="button" value="Mostrar Todos Registros" />
</label>
</form>

<table border="1" cellpadding="1" cellspacing="0">
	<tr>
 		<th> Cod_funcionario </th>  <th> nome </th>  <th> cpf </th>  <th> ddd </th>  <th> telefone </th>  <th> salario </th>  <th> Editar </th>
	</tr>
<?php
	if($listaFuncionario != NULL){
		echo "<tr>";
		echo "<td>" . $listaFuncionario->getCod_funcionario() . "</td>";
		echo "<td>" . $listaFuncionario->getNome() . "</td>";
		echo "<td>" . $listaFuncionario->getCpf() . "</td>";
		echo "<td>" . $listaFuncionario->getDdd() . "</td>";
		echo "<td>" . $listaFuncionario->getTelefone() . "</td>";
		echo "<td>" . $listaFuncionario->getSalario() . "</td>";
		echo "<td> <a href=funcionario_cadastrar.php?cod_funcionario=".$listaFuncionario->getCod_funcionario().">Editar</a> </td>";
		echo "</tr>";
	}	else{
			if($todos != NULL){
			foreach($todos as $funcionario){
				echo "<tr>";
				echo "<td>" . $funcionario->getCod_funcionario() . "</td>";
				echo "<td>" . $funcionario->getNome() . "</td>";
				echo "<td>" . $funcionario->getCpf() . "</td>";
				echo "<td>" . $funcionario->getDdd() . "</td>";
				echo "<td>" . $funcionario->getTelefone() . "</td>";
				echo "<td>" . $funcionario->getSalario() . "</td>";
				echo "<td> <a href=funcionario_cadastrar.php?cod_funcionario=".$funcionario->getCod_funcionario().">Editar</a> </td>";
			}
		}
	}
?>
</table>
<?php
	Funcoes::criarLink("funcionario_cadastrar.php","Cadastrar Funcionario");
?>
</body>
</html>
