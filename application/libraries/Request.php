<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Request {

    // instancia do codeigniter
    public $ci;

   /**
    * __construct
    *
    * método construtor
    *
    */
    public function __construct() {

        // pega a instancia do ci
        $this->ci =& get_instance();

        // verifica o token de primeira instancia
        $this->__checkFirstInstanceToken();
    }

   /**
    * __checkFirstInstanceToken
    *
    * verifica o token de primeira instancia
    *
    */
    private function __checkFirstInstanceToken() {

        // carrega a library de resonse
        $this->ci->load->library( 'Response' );

        // pega o header
        if ( $token = $this->header( 'first_instance_token' ) ) {

            // verifica se o token é o mesmo configurado no sistema
            if ( $token !== $this->ci->config->item( 'first_instance_token' ) ) {

                // exibe acesso negado
                $this->ci->response->denied();
                exit();
            }

        } else {

            // exibe acesso negado
            $this->ci->response->denied();
            exit();
        }
    }

   /**
    * header
    *
    * pega o header da requisicao
    *
    */
    public function header( $name ) {

        // prepara o nome
        $f_name = strtoupper( $name );

        // pega pelo http
        $val = isset( $_SERVER['HTTP_'.$f_name] ) ? $_SERVER['HTTP_'.$f_name] : null;

        // pega pelo ci
        return $this->ci->input->get_request_header( $name ) ? $this->ci->input->get_request_header( $name ) : $val;
    }
}

/* end of file */