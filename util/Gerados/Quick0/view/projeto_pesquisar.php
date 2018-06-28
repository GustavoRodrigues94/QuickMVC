<?php
	include_once("../dao/ProjetoDAO.php");
	include_once("../util/Funcoes.php");
	Funcoes::setarCaracteres();

	$listaProjeto = NULL;
	$todos = NULL;

	if(isset($_POST['comando']) and($_POST['comando'] == "Pesquisar")){
		$cod_projeto = $_POST['cod_projeto'];
		$projetoDAO = new ProjetoDAO();
		$listaProjeto = $projetoDAO->obterPorId($cod_projeto);
	}else{
		if(isset($_POST['comando']) and($_POST['comando'] == "Mostrar Todos Registros")){
			$projetoDAO = new ProjetoDAO();
			$todos = $projetoDAO->obterTodos();
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
<title>Pesquisa De Projeto</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<h1>Pesquisa De Projeto</h1>

<form action="projeto_pesquisar.php" method="post">
<input name="cod_projeto" type="text" size="50" placeholder="Informe o código"/>
<label>
	<input type="submit" name="comando" id="button" value="Pesquisar" />
	<input type="submit" name="comando" id="button" value="Mostrar Todos Registros" />
</label>
</form>

<table border="1" cellpadding="1" cellspacing="0">
	<tr>
 		<th> Cod_projeto </th>  <th> nome_projeto </th>  <th> data_incio </th>  <th> Editar </th>
	</tr>
<?php
	if($listaProjeto != NULL){
		echo "<tr>";
		echo "<td>" . $listaProjeto->getCod_projeto() . "</td>";
		echo "<td>" . $listaProjeto->getNome_projeto() . "</td>";
		echo "<td>" . $listaProjeto->getData_incio() . "</td>";
		echo "<td> <a href=projeto_cadastrar.php?cod_projeto=".$listaProjeto->getCod_projeto().">Editar</a> </td>";
		echo "</tr>";
	}	else{
			if($todos != NULL){
			foreach($todos as $projeto){
				echo "<tr>";
				echo "<td>" . $projeto->getCod_projeto() . "</td>";
				echo "<td>" . $projeto->getNome_projeto() . "</td>";
				echo "<td>" . $projeto->getData_incio() . "</td>";
				echo "<td> <a href=projeto_cadastrar.php?cod_projeto=".$projeto->getCod_projeto().">Editar</a> </td>";
			}
		}
	}
?>
</table>
<?php
	Funcoes::criarLink("projeto_cadastrar.php","Cadastrar Projeto");
?>
</body>
</html>
