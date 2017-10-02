<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once "MensagensFinder.php";

class Mensagem extends MensagensFinder {

    // id da mensagem
    public $CodMensagem;

    // entidade
    public $entity = 'Mensagem';
    
    // cliente
    public $cliente;

    // funcionario
    public $funcionario;

    // texto
    public $texto;

    // visualizada
    public $visualizada;

    // autor
    public $autor;

    // dataEnvio
    public $dataEnvio;

    // arquivo
    public $arquivo;

    // label
    public $label;

    // extensao
    public $extensao;

    // tabela
    public $table = 'Mensagens';

    // chave primaria
    public $primaryKey = 'CodMensagem';

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
    }
    
    // le a mensagem
    public function lerMensagem() {
        $this->visualizada = 'S';
        $this->save();
    }

    
    // faz o download do arquivo
    public function download() {

        // carrega o helper de download
        $this->load->helper('download');

        // monta o caminho do arquivo
        $path = './uploads/'.$this->arquivo.'.'.$this->extensao;

        // verifica se o arquivo existe
        if ( file_exists( $path ) ) {
            return force_download( $path, null );
        } else return false;
    }

}

/* end of file */
