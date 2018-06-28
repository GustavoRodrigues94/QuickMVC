
<?php

require_once 'Tabela.php';
require_once 'Coluna.php';

  class Banco
{
    private $tabelas; // um array de objetos Tabela
    private $mysqli;
    private $nomeBanco;
    private $servidor;
    private $usuario;
    private $senha;

    function __construct($nomeBanco, $servidor, $usuario, $senha)
    {
        $this->tabelas = array();
        $this->nomeBanco = $nomeBanco;
        $this->servidor = $servidor;
        $this->usuario = $usuario;
        $this->senha = $senha;
        $this->mysqli = new mysqli($this->servidor, $this->usuario, $this->senha, $this->nomeBanco);
    }

    function __destruct(){
    	$this->mysqli->close();
    }

    public function leTabelas()
    {
        $sql = "SHOW TABLES FROM $this->nomeBanco";
        $query = $this->mysqli->query($sql); // or trigger....

        while ($res = $query->fetch_array()) {
            
            $tab = new Tabela($this->mysqli, $res[0], $this->nomeBanco);
            $this->tabelas[] = $tab;
        }
    }

    public function getTabelas()
    {
        return $this->tabelas;
    }

    public function getNome(){
        return $this->nomeBanco;
    }

    public function getServidor(){
        return $this->servidor;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function getSenha(){
        return $this->senha;
    }

}

?>