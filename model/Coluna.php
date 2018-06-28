<?php 

    /**
    * 
*/
class Coluna
{
    private $nome; // Field string
    private $nomeColuna; //nome coluna maíusculo
    private $tipo; // Type string (varchar(45), int(11)...)
    private $null; // string (YES / NO)
    private $chave; // string (PRI / MUL / vazio)
    private $fk_tabela; // tabela para a qual esta coluna está relacionada
    private $fk_chave; // chave da tabela que está relacionada (id, codigo etc...)

    function __construct($nome, $tipo, $null, $chave)
    {
        $this->nome = $nome;
        $this->tipo = $tipo;
        $this->null = $null;
        $this->chave = $chave;

        //cortar string para sabermos qual o tipo da coluna (int, varchar, date)
        //apenas varchar e int apresentam o tamanho, date, double e outras não
        if($posicao = strpos($this->tipo, '(')){
            $this->tipo = substr($this->tipo, 0, $posicao);
        }else{
            $this->tipo = $tipo;
        }
    }

    public function setTabela($relacoes)
    {

            $this->fk_tabela = $relacoes["tabela"];
            $this->fk_chave = $relacoes["pk"];
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getNomeMaiusculo(){
       return $this->nomeColuna = ucfirst($this->nome);
    }

    public function getFkTabelaMaiusculo()
    {
       return ucfirst($this->fk_tabela);
    }

    public function getFkTabela(){
        return $this->fk_tabela;
    }

    public function getFkChave(){
        return $this->fk_chave;
    }

     public function getFkChaveMaiusculo()
    {
       return ucfirst($this->fk_chave);
    }

    public function getChave(){
        return $this->chave;
    }

    public function getTipo(){
        return $this->tipo;
    }
}

 ?>