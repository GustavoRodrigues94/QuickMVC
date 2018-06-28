<?php
 include_once("../dao/ProjetofuncionarioDAO.php");

 include_once("../dao/ProjetoDAO.php");


$projetoDAO = new ProjetoDAO();
$listaProjeto = $projetoDAO->obterTodos();

 include_once("../dao/FuncionarioDAO.php");


$funcionarioDAO = new FuncionarioDAO();
$listaFuncionario = $funcionarioDAO->obterTodos();

  if(isset($_GET['cod_projetofuncionario'])){
    $projetofuncionario = new Projetofuncionario();
    $cod_projetofuncionario = $_GET['cod_projetofuncionario'];
    $projetofuncionarioDAO = new ProjetofuncionarioDAO();
    $projetofuncionario = $projetofuncionarioDAO->obterPorId($cod_projetofuncionario);
  }

?>

<!DOCTYPE html>
<html>
<head>
<title>Cadastro De Projetofuncionario</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<h1>Cadastro De Projetofuncionario</h1>
<form name="form1" method="POST" action="../controller/ProjetofuncionarioCTR.php">
<label>Código
<input name="cod_projetofuncionario" type="text" readonly="readonly" value="<?php if(isset($projetofuncionario)) echo $projetofuncionario->getCod_projetofuncionario() ?>" /><br />
</label>
<label>projeto
</label>
<select name="projeto">
<?php
   if(isset($projetofuncionario))
   		echo "<option value=".$projetofuncionario->getProjeto()->getCod_projeto() . "/>" .$projetofuncionario->getProjeto()->getCod_projeto() . "</option>";
    foreach($listaProjeto as $projeto){
			echo "<option value=".$projeto->getCod_projeto()."/>";
			echo $projeto->getCod_projeto();
			echo "</option>";
	  }
?>
</select><br />
</label>
<label>funcionario
</label>
<select name="funcionario">
<?php
   if(isset($projetofuncionario))
   		echo "<option value=".$projetofuncionario->getFuncionario()->getCod_funcionario() . "/>" .$projetofuncionario->getFuncionario()->getCod_funcionario() . "</option>";
    foreach($listaFuncionario as $funcionario){
			echo "<option value=".$funcionario->getCod_funcionario()."/>";
			echo $funcionario->getCod_funcionario();
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
