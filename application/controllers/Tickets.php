<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends MY_Controller {

    // indica se o controller é publico
	protected $loggedUsersOnly = false;

    // seta a rotina
    protected $routine = 'Meus Clientes';

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
        
        // carrega o finder
        $this->load->model( 'Tickets/Ticket' );
        
        // chama o modulo
        $this->view->module( 'cover' )->set( 'navbar-index', 1 );
    }

   /**
    * _formularioTickets
    *
    * valida o formulario de tags
    *
    */
    private function _formularioTickets() {

        // seta as regras
        $rules = [
            [
                'field' => 'descricao',
                'label' => 'Ticket',
                'rules' => 'required|min_length[2]|max_length[30]'
            ]
        ];

        // valida o formulário
        $this->form_validation->set_rules( $rules );
        return $this->form_validation->run();
    }

   /**
    * index
    *
    * mostra o grid de tags
    *
    */
	public function index( $CodCliente ) {

        // verifica o acesso
        if ( !$this->checkAccess( [ 'canRead' ] ) ) return;

        // carrega o finder
        $this->load->model( 'Clientes/Cliente' );
        $cliente = $this->Cliente->clean()->key( $CodCliente )->get( true );
        if( !$cliente ) redirect( 'clientes_func/index' );

        // faz a paginacao
		$this->Ticket->clean()->grid( $CodCliente )

		// seta os filtros
		->order()
		->paginate( 0, 10 )
        
		// seta as funcoes nas colunas
		->onApply( 'Data Abertura', function( $row, $key ) {
		    echo date( 'd/m/Y á\s H:i:s', strtotime( $row[$key] ) );
		})

        // seta as funcoes nas colunas
		->onApply( 'Avaliação', function( $row, $key ) {
		    echo $row[$key] ? $row[$key] .'  de 5' : 'Ainda não avaliado';
		})

		// seta as funcoes nas colunas
		->onApply( 'Status', function( $row, $key ) {
		    if ( $row['Status'] == 'A' ) echo 'Aberto';
		    elseif ( $row['Status'] == 'R' ) echo 'Em Resolução';
            else echo 'Ticket Resolvido';
		})

		// seta as funcoes nas colunas
		->onApply( 'Andamento', function( $row, $key ) {
		    if ( $row['Status'] == 'A' ) echo '<a href="'.site_url( 'tickets/resolucao/'.$row[$key] ).'" class="margin btn btn-xs btn-info">Resolver</a>';
		    elseif ( $row['Status'] == 'R' ) echo '<a href="'.site_url( 'tickets/finalizar/'.$row[$key] ).'" class="margin btn btn-xs btn-info">Resolvido?</a>';
            else echo 'Ticket Resolvido';
		})

		// renderiza o grid
		->render( site_url( 'tickets/index' ) );
        $this->view->set( 'entity', "Tickets - $cliente->nome" );

		// seta o titulo da pagina
		$this->view->setTitle( 'Tickets - listagem' )->render( 'grid' );
    }

   /**
    * alterar
    *
    * mostra o formulario de edicao
    *
    */
    public function resolucao( $key ) {

        // verifica o acesso
        if ( !$this->checkAccess( [ 'canUpdate' ] ) ) return;

        // carrega o cargo
        $ticket = $this->Ticket->clean()->key( $key )->get( true );
        
        // verifica se o mesmo existe
        if ( !$ticket ) {
            redirect( 'tickets/index' );
            exit();
        }

        // salva na view
        $ticket->set( 'status', 'R' )
        ->set( 'dataMovimentacao', date( 'Y-m-d H:i:s', time() ) )
        ->save();

        // carrega a view de adicionar
        redirect( site_url( 'tickets/index/' .$ticket->cliente ) );
    }
    
   /**
    * alterar
    *
    * mostra o formulario de edicao
    *
    */
    public function finalizar( $key ) {

        // verifica o acesso
        if ( !$this->checkAccess( [ 'canUpdate' ] ) ) return;

        // carrega o cargo
        $ticket = $this->Ticket->clean()->key( $key )->get( true );
        
        // verifica se o mesmo existe
        if ( !$ticket ) {
            redirect( 'tickets/index' );
            exit();
        }

        // salva na view
        $ticket->set( 'status', 'F' )
        ->set( 'dataMovimentacao', date( 'Y-m-d H:i:s', time() ) )
        ->save();

        // carrega a view de adicionar
        redirect( site_url( 'tickets/index/' .$ticket->cliente) );
    }

}
