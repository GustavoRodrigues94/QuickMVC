<?php
 include_once("../dao/CargoDAO.php");

  if(isset($_GET['cod_cargo'])){
    $cargo = new Cargo();
    $cod_cargo = $_GET['cod_cargo'];
    $cargoDAO = new CargoDAO();
    $cargo = $cargoDAO->obterPorId($cod_cargo);
  }

?>

<!DOCTYPE html>
<html>
<head>
<title>Cadastro De Cargo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<h1>Cadastro De Cargo</h1>
<form name="form1" method="POST" action="../controller/CargoCTR.php">
<label>Código
<input name="cod_cargo" type="text" readonly="readonly" value="<?php if(isset($cargo)) echo $cargo->getCod_cargo() ?>" /><br />
</label>
<label>nome
</label>
<input name="nome" type="text" value="<?php if(isset($cargo)) echo $cargo->getNome() ?>" /><br />
</label>
<input type="submit" name="comando" id="comando" value="Gravar" />
<input type="submit" name="comando" id="comando" value="Excluir" />
<input type="submit" name="comando" id="comando" value="Pesquisar" />
</form>
<br />
<p align="center"><a href="../index.php"> Voltar para o menu principal </a></p>
</body>
</html
