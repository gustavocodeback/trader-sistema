<?php defined('BASEPATH') OR exit('No direct script access allowed');

class UsuariosFinder extends MY_Model {
    
    // tabela
    public $table = "Usuarios";
    
    // entidade
    public $entity = "Usuario";

    // chave primária
    public $primaryKey = "CodUsuario";
    
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
    * email
    *
    * pesquisa os usuário por email
    *
    */
    public function email( $email ) {

        // pesquisa o email
        $this->where( " Email = '$email' " );
        return $this;
    }

   /**
    * uid
    *
    * filtra por uid
    *
    */
    public function uid( $uid ) {

        // pesquisa o email
        $this->where( " UID = '$uid' " );
        return $this;
    }

   /**
    * ignorarAtual
    *
    * ignora o usuário logado
    *
    */
    public function ignorarAtual() {

        // pega o usuario atual
        $uid = $this->guard->currentUser()->UID;

        // adiciona no where
        $this->clean()->where( " UID <> '$uid' " );
        
        // retorna uma instancia
        return $this;
    }
}

/* end of file */