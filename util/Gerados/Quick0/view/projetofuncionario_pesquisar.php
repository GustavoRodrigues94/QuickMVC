<?php
	include_once("../dao/ProjetofuncionarioDAO.php");
	include_once("../util/Funcoes.php");
	Funcoes::setarCaracteres();

	$listaProjetofuncionario = NULL;
	$todos = NULL;

	if(isset($_POST['comando']) and($_POST['comando'] == "Pesquisar")){
		$cod_projetofuncionario = $_POST['cod_projetofuncionario'];
		$projetofuncionarioDAO = new ProjetofuncionarioDAO();
		$listaProjetofuncionario = $projetofuncionarioDAO->obterPorId($cod_projetofuncionario);
	}else{
		if(isset($_POST['comando']) and($_POST['comando'] == "Mostrar Todos Registros")){
			$projetofuncionarioDAO = new ProjetofuncionarioDAO();
			$todos = $projetofuncionarioDAO->obterTodos();
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
<title>Pesquisa De Projetofuncionario</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<h1>Pesquisa De Projetofuncionario</h1>

<form action="projetofuncionario_pesquisar.php" method="post">
<input name="cod_projetofuncionario" type="text" size="50" placeholder="Informe o código"/>
<label>
	<input type="submit" name="comando" id="button" value="Pesquisar" />
	<input type="submit" name="comando" id="button" value="Mostrar Todos Registros" />
</label>
</form>

<table border="1" cellpadding="1" cellspacing="0">
	<tr>
 		<th> Cod_projetofuncionario </th>  <th> Editar </th>
	</tr>
<?php
	if($listaProjetofuncionario != NULL){
		echo "<tr>";
		echo "<td>" . $listaProjetofuncionario->getCod_projetofuncionario() . "</td>";
		echo "<td> <a href=projetofuncionario_cadastrar.php?cod_projetofuncionario=".$listaProjetofuncionario->getCod_projetofuncionario().">Editar</a> </td>";
		echo "</tr>";
	}	else{
			if($todos != NULL){
			foreach($todos as $projetofuncionario){
				echo "<tr>";
				echo "<td>" . $projetofuncionario->getCod_projetofuncionario() . "</td>";
				echo "<td> <a href=projetofuncionario_cadastrar.php?cod_projetofuncionario=".$projetofuncionario->getCod_projetofuncionario().">Editar</a> </td>";
			}
		}
	}
?>
</table>
<?php
	Funcoes::criarLink("projetofuncionario_cadastrar.php","Cadastrar Projetofuncionario");
?>
</body>
</html>
