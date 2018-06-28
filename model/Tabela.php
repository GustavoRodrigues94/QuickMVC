<?php 

require_once 'Coluna.php';

/**
* Representa UMA tabela do banco
*/
class Tabela
{
    private $nome;
    private $nomeClasse; //nome da tabela maíusculo
    private $colunas; // um array de objetos Coluna
    private $mysqli;
    // private $tabelaEstrangeira; //array nome da tabela estrangeira
    // private $chaveEstrangeira; //array chave primária da tabela estrangeira
    private $nomeBanco;
    private $verificaEstrangeira;//variável para verificar se existe tabela estrangeira

    function __construct($mysqli, $nome, $nomeBanco)
    {
        $this->colunas = array();
        $this->mysqli = $mysqli;
        $this->nome = $nome;
        $this->nomeClasse = ucfirst($nome);
        $this->nomeBanco = $nomeBanco;

        $relacoes = array(); // vai ser descartado
        $this->verificaEstrangeira = 0; //iniciada em 0, caso entrar no laço da query abaixo, significa que existe tabela estrangeira

        //setando a tabela estrangeira
        $sql = "SELECT * FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = '$this->nomeBanco' AND TABLE_NAME = '$this->nome' AND REFERENCED_TABLE_NAME IS NOT NULL";
        $query = $this->mysqli->query($sql);

        while($estrangeira = $query->fetch_assoc()){
            $this->verificaEstrangeira = 1;
            $result = $estrangeira["REFERENCED_TABLE_NAME"];
            $result1 = $estrangeira["REFERENCED_COLUMN_NAME"];
            $result2 = $estrangeira["COLUMN_NAME"];
            // $this->tabelaEstrangeira[] = $result; //array pois uma tabela poderá ter mais de uma tabela estrangeira
            // $this->chaveEstrangeira[] = $result1;   //array pois uma tabela pode ter mais de uma chave estrangeira
            //nome da coluna estrangeira que está nessa tabela que estamos tratando
            $relacoes[$result2] = array('tabela' => $result, 'pk' => $result1);
         }


        // buscar as colunas
        $sql2 = "SHOW COLUMNS FROM $this->nome";
        $query = $this->mysqli->query($sql2);

        while ($res = $query->fetch_assoc()) {

            $col = new Coluna($res['Field'], $res['Type'], $res['Null'], $res['Key'], $this->nome, $this->mysqli);
            if ( isset($relacoes[$res['Field']] )){
                    $col->setTabela($relacoes[ $res['Field'] ]);
            }

            $this->colunas[] = $col;
        }

        
    }


    public function getColunas()
    {
        return $this->colunas;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getNomeMaiusculo(){
        return $this->nomeClasse;
    }

    public function getNomeEstrangeira(){
        if(count($this->tabelaEstrangeira) > 1){
            foreach($this->tabelaEstrangeira as $valor){
                $estrangeira[] = $valor;
            }
        }else{
            $maiusculo = $this->tabelaEstrangeira[0];
            $estrangeira = ucfirst($maiusculo);
        }
       return $estrangeira;
    }

    /*public function getNomeEstrangeiraMaiusculo(){
        //verificando se existe mais de uma tabela estrangeira em uma mesma tabela
        if(count($this->tabelaEstrangeira) > 1){
            foreach($this->tabelaEstrangeira as $valor){
                $estrangeiraMaisculo[] = ucfirst($valor);
            }
        }else{
            $maiusculo = $this->tabelaEstrangeira[0];
            $estrangeiraMaisculo = ucfirst($maiusculo);
        }
       return $estrangeiraMaisculo;
    }*/

    public function verificaTabEstrangeira(){
        if ($this->verificaEstrangeira == 1){
            return true;
        } else{
            return false;
        }
    }

  /*  public function getChaveEstrangeira(){
        if(count($this->chaveEstrangeira) > 1){
            foreach($chaveEstrangeira as $valor){
                $chaveE[] = $valor;
            }
        } else{
            //recebe a única chave estrangeira existente
            $chaveE = $this->chaveEstrangeira[0];
        }

        return $chaveE;
    }

    // só irá retornar um array, se tiver mais de uma chave estrangeira
    public function getChaveEstrangeiraMaiusculo(){

        if(count($this->chaveEstrangeira) > 1){
            foreach($this->chaveEstrangeira as $valor){
                $estrangeiraMaisculo[] = ucfirst($valor);
            }
        }else{
            $maiusculo = $this->chaveEstrangeira[0];
            $estrangeiraMaisculo = ucfirst($maiusculo);
        }
       return $estrangeiraMaisculo;
    }*/
}


 ?>