<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once "HistoricosFinder.php";

class Historico extends HistoricosFinder {

    // CodHistorico
    public $CodHistorico;

    // cliente
    public $cliente;
    
    // segmento
    public $segmento;
    
    // titulo
    public $titulo;
    
    // sistema
    public $sistema;
    
    // texto
    public $texto;
    
    // data
    public $data;

    // flag de ação
    public $flag;

    // proposta da ação
    public $proposta;
 
   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
    }

    /**
    * save
    *
    * salva o histórico
    *
    */
    public function save() {

        // verifica se existe uma data
        $this->data = $this->data ? $this->data : date( 'Y-m-d H:i:s', time() );
    
        // chama o método pai
        parent::save();
    }
}

/* end of file */