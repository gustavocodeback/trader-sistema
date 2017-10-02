<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Permissoes extends MY_Controller {

    // indica se o controller é publico
	protected $loggedUsersOnly = false;

    // indica a rotina
    protected $routine = 'Permissões';

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
        
        // carrega o finder
        $this->load->model( [ 'Grupos/Grupo', 'Rotinas/Rotina' ] );
        
        // chama o modulo
        $this->view->module( 'navbar' )->module( 'aside' );
    }

   /**
    * _salvarPermissao
    *
    * salva a permissao
    *
    */
    private function _salvarPermissao( $rid, $gid, $tipo ) {

        // prepara os dados
        $dados = [
            'rid'    => $rid,
            'gid'    => $gid,
            'access' => 'S',
            $tipo    => 'S'
        ];

        // salva no banco
        return $this->db->insert( 'Permissoes', $dados );
    }

   /**
    * index
    *
    * mostra o grid de rotinas
    *
    */
	public function index() {

        // verifica o acesso
        // if ( !$this->checkAccess( [ 'canRead' ] ) ) return;

        // pega os cargos e as rotinas
        $cargos  = $this->Grupo->clean()->get();
        $rotinas = $this->Rotina->clean()->get(); 

        // seta os dados
        $this->view->set( 'cargos', $cargos );
        $this->view->set( 'rotinas', $rotinas );

        // renderiza a pagina
        $this->view->setTitle( 'Níveis de acesso' )->render( 'forms/permissao' );
    }

   /**
    * deleteAll
    *
    * remove todos os dados da tabela
    *
    */
    private function deleteAll() {
        $this->db->empty_table( 'Permissoes' );
    }

   /**
    * salvar
    *
    * salva os dados
    *
    */
    public function salvar() {

        // verifica o acesso
        // if ( !$this->checkAccess( [ 'canCreate', 'canUpdate' ] ) ) return;

        // pega os checkbox
        $check = $this->input->post( 'permissoes' );
        
        // deleta as permissoes atuais
        $this->deleteAll();

        // seta os tipos possiveis
        $tipos = [  'c' => 'create',
                    'r' => 'read',
                    'u' => 'update',
                    'd' => 'delete' ];

        // percorre todas as permissoes
        foreach( $check as $item ) {

            // faz o explode
            $parts = explode( '_', $item );

            // pega o tipo
            $tipo = $tipos[$parts[0]];

            // salva a permissao
            $this->_salvarPermissao( $parts[1], $parts[2], $tipo );
        }

        // mostra o index
        $this->index();
    }
}
