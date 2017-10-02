<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Forge {

    // instancia do codeingniter
    public $ci;
   
   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {

        // pega a instancia do codeigniter
        $this->ci =& get_instance();
    }

   /**
    * create_database
    *
    * cria o banco de dados
    *
    */
    public function create_database( $databse ) {

        // cria o banco
        $strSQL = "CREATE DATABASE IF NOT EXISTS $databse";
        $query = $this->ci->db->query($strSQL);
        
        // verifica se rodou
        if ( !$query ) {
            throw new Exception($this->ci->db->_error_message(),
            $this->ci->db->_error_number());
            return FALSE;
        } else {
            return TRUE;
        }
    }

   /**
    * drop_database
    *
    * apaga o banco de dados
    *
    */
    public function drop_database( $databse ) {

        // cria o banco
        $strSQL = "DROP DATABASE IF EXISTS $databse";
        $query = $this->ci->db->query($strSQL);
        
        // verifica se rodou
        if ( !$query ) {
            throw new Exception($this->ci->db->_error_message(),
            $this->ci->db->_error_number());
            return FALSE;
        } else {
            return TRUE;
        }
    }
}

/* end of file */