<?php defined('BASEPATH') OR exit('No direct script access allowed');

require 'PostsFinder.php';

class Post extends PostsFinder {

    // id do descricao
    public $CodPost;

    // textoCurto
    public $textoCurto;

    // post
    public $post;
    
    // imagem
    public $imagem;
    
    // titulo
    public $titulo;
    
    // data
    public $data;

    // entidade
    public $entity = 'Post';
    
    // tabela
    public $table = 'Posts';

    // chave primaria
    public $primaryKey = 'CodPost';

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
    }

}

/* end of file */
