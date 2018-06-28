<?php
 include_once("../dao/FuncionarioDAO.php");

 include_once("../dao/CargoDAO.php");


$cargoDAO = new CargoDAO();
$listaCargo = $cargoDAO->obterTodos();

  if(isset($_GET['cod_funcionario'])){
    $funcionario = new Funcionario();
    $cod_funcionario = $_GET['cod_funcionario'];
    $funcionarioDAO = new FuncionarioDAO();
    $funcionario = $funcionarioDAO->obterPorId($cod_funcionario);
  }

?>

<!DOCTYPE html>
<html>
<head>
<title>Cadastro De Funcionario</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<h1>Cadastro De Funcionario</h1>
<form name="form1" method="POST" action="../controller/FuncionarioCTR.php">
<label>Código
<input name="cod_funcionario" type="text" readonly="readonly" value="<?php if(isset($funcionario)) echo $funcionario->getCod_funcionario() ?>" /><br />
</label>
<label>nome
</label>
<input name="nome" type="text" value="<?php if(isset($funcionario)) echo $funcionario->getNome() ?>" /><br />
</label>
<label>cpf
</label>
<input name="cpf" type="text" value="<?php if(isset($funcionario)) echo $funcionario->getCpf() ?>" /><br />
</label>
<label>ddd
</label>
<input name="ddd" type="text" value="<?php if(isset($funcionario)) echo $funcionario->getDdd() ?>" /><br />
</label>
<label>telefone
</label>
<input name="telefone" type="text" value="<?php if(isset($funcionario)) echo $funcionario->getTelefone() ?>" /><br />
</label>
<label>salario
</label>
<input name="salario" type="number" value="<?php if(isset($funcionario)) echo $funcionario->getSalario() ?>" /><br />
</label>
<label>cargo
</label>
<select name="cargo">
<?php
   if(isset($funcionario))
   		echo "<option value=".$funcionario->getCargo()->getCod_cargo() . "/>" .$funcionario->getCargo()->getCod_cargo() . "</option>";
    foreach($listaCargo as $cargo){
			echo "<option value=".$cargo->getCod_cargo()."/>";
			echo $cargo->getCod_cargo();
			echo "</option>";
	  }
?>
</select><br />
</label>
<input type="submit" name="comando" id="comando" value="Gravar" />
<input type="submit" name="comando" id="comando" value="Excluir" />
<input type="submit" name="comando" id="comando" value="Pesquisar" />
</form>
<br />
<p align="center"><a href="../index.php"> Voltar para o menu principal </a></p>
</body>
</html
