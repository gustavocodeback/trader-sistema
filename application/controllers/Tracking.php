<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking extends MY_Controller {

    // indica se o controller é publico
	protected $loggedUsersOnly = true;

    // rotina
    protected $routine = 'Tracking';

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
        
        // carrega o finder
        $this->load->model( [ 'Cidades/Cidade', 'Estados/Estado' ] );
        
        // chama o modulo
        $this->view->module( 'navbar' )->module( 'aside' );
    }

   /**
    * index
    *
    * mostra o grid de contadores
    *
    */
	public function index() {

        // verifica a permissao
        if ( !$this->checkAccess( [ 'canRead' ] ) ) return;

        // carrega as models
        $this->load->model( 'Clientes/Cliente' );

        // carrega todos os clientes
        $clientes = $this->Cliente->clean()->meusClientes()->get();
        $clientes = $clientes ? $clientes : [];
        $this->view->set( 'clientes', $clientes );

		// seta o titulo da pagina
		$this->view->setTitle( 'Propostas - tracking' )->render( 'tracking' );
    }

    public function historico( $CodCliente = false ) {

        // carrega as models
        $this->load->model( [ 'Clientes/Cliente',
                              'Segmentos/Segmento',
                              'Historicos/Historico' ] );

        // carrega os itens
        $cliente = $this->Cliente->clean()->key( $CodCliente )->get( true );
        if ( !$cliente ) {
            echo '<h1>Nenhum resultado encontrado</h1>';
            return;
        }

        // carrega o segmento
        $segmento = $this->Segmento->clean()->key( $this->guard->currentUser()->segmento )->get( true );
        if ( !$segmento ) {
            echo '<h1>Nenhum resultado encontrado</h1>';
            return;
        }

        // obtem os historicos
        $historicos = $this->Historico->clean()->timeline( $segmento, $cliente )->get();
        $this->view->set( 'historicos', $historicos );

        // carrega a view
        $this->view->render( 'timeline', false );
    }
}
/* end of file */
