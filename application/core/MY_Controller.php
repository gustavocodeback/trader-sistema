<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    // indica se o controller é para usuários logados somente
    protected $loggedUsersOnly = false;

    // indica se o controller é para usuário não logados somnete
    protected $unloggedUsersOnly = false;

    // indica se o controller é livre para qualquer um
    protected $isFreeToEveryOne = false;

    // rota que deve ser redirecionada
    protected $urlGuard;

    // rotina
    protected $routine = false;

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        
        // chama o metodo construtor
        parent::__construct();

        // chama o metodo de migracao
        $this->_migrate();
        
        // seta a url de fuga
        $this->urlGuard = site_url( 'login' );

        // chama o metodo protetor
        $this->_guard();
    }

    /**
    * _migrate
    *
    * faz a migracao do banco de dados
    *
    */
    public function _migrate() {

        // verifica se as migracoes estao ativadas
        if ( !USE_DATABASE_VERSIONS ) return;
         
         // carrega a library de migracao
        $this->load->library( 'Migration' );

        // inicia a migracao
        $this->migration->start();
    }

   /**
    * _guard
    *
    * protege o acesso para acessos remotos
    *
    */
    protected function _guard() {
        
        // carrega o usuário logado
        $user = $this->guard->currentUser();

        // verifica se é livre para todas
        if ( $this->isFreeToEveryOne ) return;

        // verifica se é para usuários logados somente
        if ( $this->loggedUsersOnly && !$user ) {

            // redireciona para o login
            redirect( site_url() );
            exit();
            return;
        }

        // verifica se é para usuários não logados somente
        if ( $this->unloggedUsersOnly && $user ) {

            // redireciona para a home
            redirect( site_url( 'home' ) );
            exit();
            return;
        }
    }

   /**
    * close
    *
    * para a execucao do código
    *
    */
    protected function close( $url = '' ) {
        redirect( site_url( $url ) );
        return false;
    }

   /**
    * valid_cnpj
    *
    * valida o acesso
    *
    */
    function valid_cpf( $cpf ) {
        
        // seta o cpf
        $cpf = preg_replace( '/[^0-9]/', '', (string) $cpf );

        // valores repetidos
        $valores = [
            '00000000',
            '11111111',
            '22222222',
            '333333333',
            '44444444',
            '55555555',
            '66666666',
            '77777777',
            '88888888',
            '99999999',
        ];

        // verifica se esta no array
        if ( in_array( $cpf, $valores ) ) return false;

        // Valida tamanho
        if ( strlen( $cpf ) != 11 ) return false;

        // Calcula e confere primeiro dígito verificador
        for ( $i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j-- )
            $soma += $cpf{$i} * $j; 
        
        $resto = $soma % 11;
        if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto))
            return false;
        // Calcula e confere segundo dígito verificador
        for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
            $soma += $cpf{$i} * $j;
        $resto = $soma % 11;
        return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
    }

   /**
    * valid_cnpj
    *
    * valida o acesso
    *
    */
    function valid_cnpj( $str ) {
        if (strlen($str) > 18 || strlen($str) < 14) {
            $this->form_validation->set_message('valid_cnpj','Cnpj inválido!');
            return false;
        } else {
            $search = array('.','/','-');
            $cnpj = str_replace ( $search , '' , $str );
            if( strlen($cnpj) > 14 || strlen($cnpj) < 14  ) {
                $this->form_validation->set_message('valid_cnpj','Cnpj inválido!');
                return false;
            }
            // Valida primeiro dígito verificador
            for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
            {
                $soma += $cnpj{$i} * $j;
                $j = ($j == 2) ? 9 : $j - 1;
            }
            $resto = $soma % 11;
            if ( $cnpj{12} != ( $resto < 2 ? 0 : 11 - $resto ) ) {
                $this->form_validation->set_message('valid_cnpj','Cnpj inválido!');
                return false;
            }
            // Valida segundo dígito verificador
            for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
            {
                $soma += $cnpj{$i} * $j;
                $j = ($j == 2) ? 9 : $j - 1;
            }
            $resto = $soma % 11;
            if ( $cnpj{13} == ( $resto < 2 ? 0 : 11 - $resto ) ) return true;
            else {
                $this->form_validation->set_message('valid_cnpj','Cnpj inválido!');
                return false;
            }
        }
    }

   /**
    * checkAccess
    *
    * verifica se o usuário atual pode acessar um item
    *
    */
    protected function checkAccess( $actions = [], $msg = true ) {

        // verifica se existe uma rotina
        if ( !$this->routine ) {
            if( $msg ) $this->view->setTitle( 'Acesso negado' )->render( 'denied' );
            return false;
        }

        // carrega o finder
        $this->load->model( 'Rotinas/Rotina' );

        // carrega a rotina
        $rotina = $this->Rotina->clean()->nome( $this->routine )->get( true );
        if ( !$rotina )  {
            if( $msg ) $this->view->setTitle( 'Acesso negado' )->render( 'denied' );
            return false;
        }

        // seta a permissao
        $canActive = true;

        // pega o usuario
        $user = $this->guard->currentUser();

        // percorre as acoes
        foreach( $actions as $acao ) {
            
            // verifica se o usuário pode executar a acao
            if ( !$this->view->$acao( $rotina->rid, $user->gid ) ) $canActive = false;
        }

        // verifica se pode acessar
        if ( !$canActive ) {
            if( $msg ) $this->view->setTitle( 'Acesso negado' )->render( 'denied' );
            return false;
        } else return true;
    }

   /**
    * debug
    *
    * faz o debug de uma variável
    *
    */
    public function debug( $var, $stopable = true ) {

        // imprime a tag de prévisualizacao
        echo '<pre>';
        
        // verifica se deve parar a execução
        if ( $stopable ) {

            // roda com o die
            die( var_dump( $var ) );

        } else var_dump( $var );
    }
}

/* end of file */