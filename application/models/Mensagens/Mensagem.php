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

    public function colocarFoto( $newFoto ) {

            // cria um id para a foto
            $this->arquivo = md5( uniqid( time() * rand() ) ) .'.jpeg';

            // label
            $this->label = 'imagem-' .date( 'd-m-y-H-i-s' ) .'.jpeg';            
            
            // extensao
            $this->extensao = 'png';
            
            // separa o base64
            $exploded = explode(',', $newFoto, 2);

            // decodifica
            $decoded = base64_decode($exploded[1]);

            // atualiza a imagem
            file_put_contents( $_SERVER['DOCUMENT_ROOT']."/uploads/" .$this->arquivo .'.' .$this->extensao, $decoded );
            return $this;
    }
}

/* end of file */
