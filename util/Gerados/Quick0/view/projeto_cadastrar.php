<?php
 include_once("../dao/ProjetoDAO.php");

  if(isset($_GET['cod_projeto'])){
    $projeto = new Projeto();
    $cod_projeto = $_GET['cod_projeto'];
    $projetoDAO = new ProjetoDAO();
    $projeto = $projetoDAO->obterPorId($cod_projeto);
  }

?>

<!DOCTYPE html>
<html>
<head>
<title>Cadastro De Projeto</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<h1>Cadastro De Projeto</h1>
<form name="form1" method="POST" action="../controller/ProjetoCTR.php">
<label>Código
<input name="cod_projeto" type="text" readonly="readonly" value="<?php if(isset($projeto)) echo $projeto->getCod_projeto() ?>" /><br />
</label>
<label>nome_projeto
</label>
<input name="nome_projeto" type="text" value="<?php if(isset($projeto)) echo $projeto->getNome_projeto() ?>" /><br />
</label>
<label>data_incio
</label>
<input name="data_incio" type="date" value="<?php if(isset($projeto)) echo $projeto->getData_incio() ?>" /><br />
</label>
<input type="submit" name="comando" id="comando" value="Gravar" />
<input type="submit" name="comando" id="comando" value="Excluir" />
<input type="submit" name="comando" id="comando" value="Pesquisar" />
</form>
<br />
<p align="center"><a href="../index.php"> Voltar para o menu principal </a></p>
</body>
</html
