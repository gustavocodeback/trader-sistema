<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Recovery extends MY_Controller {

    // somente para usuários não logados
    public $unloggedUsersOnly = true;

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
    * resetar
    *
    * resetar a senha
    *
    */
    public function resetar() {

        // carrega o model
        $this->load->model( [ 'Funcionarios/Funcionario' ] );
        $user = $this->Funcionario->clean()->email( $this->input->post( 'email' ) )->get( true );
        if ( !$user ) {
            
            // seta os erros
            $this->view->set( 'errors', 'Email não consta no sistema' );
            
            // carrega a view de adicionar
            $this->view->setTitle( 'Equipe Trader - Recuperar Senha' )->render( 'login/forgot_password' );
            return;
        }
        $user->set( 'tokenEmail', md5( uniqid( time() * rand() ) ) );
        $user->save();

        // verifica se o dado foi salvo
        if ( $this->enviarEmailVerificacao( $user->email, $user->tokenEmail ) ) {
            
            // seta os erros
            $this->view->set( 'success', 'Formulário enviado com sucesso' );

            // carrega a view de adicionar
            $this->view->setTitle( 'Equipe Trader - Recuperar Senha' )->render( 'login/forgot_password' );
            return;
        } else {

            // seta os erros
            $this->view->set( 'errors', 'Erro ao recuperar a senha' );

            // carrega a view de adicionar
            $this->view->setTitle( 'Equipe Trader - Recuperar Senha' )->render( 'login/forgot_password' );
            return;
        }
    }

    /**
    * recovery
    *
    * faz a confirmacao de um email
    *
    */
    public function recovery( $token ) {

        // carrega o finder
        $this->load->model( [ 'Funcionarios/Funcionario' ] );

        // carrega o lead
        $user = $this->Funcionario->clean()->tokenEmail( $token )->get( true );
        if ( !$user ) {
            redirect( site_url() );
            exit();
        }

        // salva o lead
        if( $user ) {

            $this->view->set( 'funcionario', $user->CodFuncionario );

            // carrega a view de email confirmado
            $this->view->setTitle( 'Equipe Trader - Resetar Senha' )->render( 'nova_senha' );
            return;
        } die( 'Erro ao validar o e-mail' );
    }
    
   /**
    * salvar
    *
    * salva os dados
    *
    */
    public function salvar_recovery() {

        // carrega o finder
        $this->load->model( [ 'Funcionarios/Funcionario' ] );
        $senha   = $this->input->post( 'novaSenha' );
        $c_senha = $this->input->post( 'confirmaSenha' );
        
        // carrega o usuario
        $user = $this->Funcionario->clean()->key( $this->input->post( 'funcionario' ) )->get( true );
        if ( !$user ) {
            
            // seta os erros
            $this->view->set( 'errors', 'Usuario não consta no sistema' );
            
            // carrega a view de adicionar
            $this->view->setTitle( 'Equipe Trader - Recuperar Senha' )->render( 'nova_senha' );
            return;
        }

        // verifica se o email digitado é o mesmo
        if ( $user->email != $this->input->post( 'email' ) ) {
            // seta os erros
            $this->view->set( 'errors', 'E-mail incorreto' );
            
            // carrega a view de adicionar
            $this->view->setTitle( 'Equipe Trader - Recuperar Senha' )->render( 'nova_senha' );
            return;
        }

        // verifica se sao iguais
        if ( $senha != $c_senha ) {

            // seta os erros
            $this->view->set( 'errors', 'As senhas sao diferentes' );
            
            // carrega a view de adicionar
            $this->view->setTitle( 'Equipe Trader - Recuperar Senha' )->render( 'nova_senha' );
            return;
        } else {

            // seta a nova senha
            $user->set( 'senha', $senha )->save( true );

            // seta os erros
            $this->view->set( 'success', 'Senha alterada com sucesso.' );
            
            // carrega a view de adicionar
            $this->view->setTitle( 'Equipe Trader - Recuperar Senha' )->render( 'nova_senha' );
            return;
        }        
        return;
    }

   /**
    * enviarEmailVerificacao
    *
    * envia o email de verificacao
    *
    */
    private function enviarEmailVerificacao( $email, $token ) {

        // carrega o template
        $this->load->model( 'Templates/Template' );
        $template = $this->Template->template( 'TEMPLATE_RECOVERY' )->get( true );
        
        // adiciona os parametros customizaveis
        $template->corpo = str_replace( '%_TOKEN_%', site_url( 'recovery/recovery/'.$token ), $template->corpo );

        // configuracoes do email
        $config = [
            'mailtype' => 'html',
            'charset'  => 'iso-8859-1'
        ];

        // carrega a library
        $this->load->library( 'email', $config );

        // seta os emails
        $this->email->from( 'vihh.fernando@gmail.com', "Suporte" )
        ->to( $email )

        // seta o corpo
        ->subject( 'Recuperacao de Senha Equipe Trader' )
        ->message( $template->corpo )
        ->set_mailtype( 'html' );
        
        // envia o email
        if( $this->email->send() ) {
            return true;
        } else {
            return false;
        }
    }
    

    /**
    * recovery
    *
    * faz a confirmacao de um email
    *
    */
    public function recovery_cliente( $token ) {

        // carrega o finder
        $this->load->model( [ 'Clientes/Cliente' ] );

        // carrega o lead
        $user = $this->Cliente->clean()->tokenEmail( $token )->get( true );
        if ( !$user ) {
            redirect( site_url() );
            exit();
        }

        // salva o lead
        if( $user ) {

            $this->view->set( 'cliente', $user->CodCliente );

            // carrega a view de email confirmado
            $this->view->setTitle( 'Equipe Trader - Resetar Senha' )->render( 'nova_senha' );
            return;
        } die( 'Erro ao validar o e-mail' );
    }
    
   /**
    * salvar
    *
    * salva os dados
    *
    */
    public function salvar_recovery_cliente() {

        // carrega o finder
        $this->load->model( [ 'Clientes/Cliente' ] );
        $senha   = $this->input->post( 'novaSenha' );
        $c_senha = $this->input->post( 'confirmaSenha' );
        
        // carrega o usuario
        $user = $this->Cliente->clean()->key( $this->input->post( 'cliente' ) )->get( true );
        if ( !$user ) {
            
            // seta os erros
            $this->view->set( 'errors', 'Usuario não consta no sistema' );
            
            // carrega a view de adicionar
            $this->view->setTitle( 'Equipe Trader - Recuperar Senha' )->render( 'nova_senha' );
            return;
        }

        // verifica se o email digitado é o mesmo
        if ( $user->email != $this->input->post( 'email' ) ) {
            // seta os erros
            $this->view->set( 'errors', 'E-mail incorreto' );
            
            // carrega a view de adicionar
            $this->view->setTitle( 'Equipe Trader - Recuperar Senha' )->render( 'nova_senha' );
            return;
        }

        // verifica se sao iguais
        if ( $senha != $c_senha ) {

            // seta os erros
            $this->view->set( 'errors', 'As senhas sao diferentes' );
            
            // carrega a view de adicionar
            $this->view->setTitle( 'Equipe Trader - Recuperar Senha' )->render( 'nova_senha' );
            return;
        } else {

            // seta a nova senha
            $user->set( 'senha', $senha )->save( true );

            // seta os erros
            $this->view->set( 'success', 'Senha alterada com sucesso.' );
            
            // carrega a view de adicionar
            $this->view->setTitle( 'Equipe Trader - Recuperar Senha' )->render( 'nova_senha' );
            return;
        }        
        return;
    }

}

/* end of file */
