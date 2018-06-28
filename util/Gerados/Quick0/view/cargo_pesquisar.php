<?php
	include_once("../dao/CargoDAO.php");
	include_once("../util/Funcoes.php");
	Funcoes::setarCaracteres();

	$listaCargo = NULL;
	$todos = NULL;

	if(isset($_POST['comando']) and($_POST['comando'] == "Pesquisar")){
		$cod_cargo = $_POST['cod_cargo'];
		$cargoDAO = new CargoDAO();
		$listaCargo = $cargoDAO->obterPorId($cod_cargo);
	}else{
		if(isset($_POST['comando']) and($_POST['comando'] == "Mostrar Todos Registros")){
			$cargoDAO = new CargoDAO();
			$todos = $cargoDAO->obterTodos();
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
<title>Pesquisa De Cargo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<h1>Pesquisa De Cargo</h1>

<form action="cargo_pesquisar.php" method="post">
<input name="cod_cargo" type="text" size="50" placeholder="Informe o código"/>
<label>
	<input type="submit" name="comando" id="button" value="Pesquisar" />
	<input type="submit" name="comando" id="button" value="Mostrar Todos Registros" />
</label>
</form>

<table border="1" cellpadding="1" cellspacing="0">
	<tr>
 		<th> Cod_cargo </th>  <th> nome </th>  <th> Editar </th>
	</tr>
<?php
	if($listaCargo != NULL){
		echo "<tr>";
		echo "<td>" . $listaCargo->getCod_cargo() . "</td>";
		echo "<td>" . $listaCargo->getNome() . "</td>";
		echo "<td> <a href=cargo_cadastrar.php?cod_cargo=".$listaCargo->getCod_cargo().">Editar</a> </td>";
		echo "</tr>";
	}	else{
			if($todos != NULL){
			foreach($todos as $cargo){
				echo "<tr>";
				echo "<td>" . $cargo->getCod_cargo() . "</td>";
				echo "<td>" . $cargo->getNome() . "</td>";
				echo "<td> <a href=cargo_cadastrar.php?cod_cargo=".$cargo->getCod_cargo().">Editar</a> </td>";
			}
		}
	}
?>
</table>
<?php
	Funcoes::criarLink("cargo_cadastrar.php","Cadastrar Cargo");
?>
</body>
</html>
