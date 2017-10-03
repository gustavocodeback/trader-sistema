<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Segmentos extends MY_Controller {

    // indica se o controller é publico
	protected $loggedUsersOnly = false;

    // seta a rotina
    protected $routine = 'Segmentos';

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
        
        // carrega o finder
        $this->load->model( 'Segmentos/Segmento' );
        
        // chama o modulo
        $this->view->module( 'cover' )->set( 'navbar-index', 1 );
    }

   /**
    * _formularioSegmentos
    *
    * valida o formulario de segmentos
    *
    */
    private function _formularioSegmentos() {

        // seta as regras
        $rules = [
            [
                'field' => 'nome',
                'label' => 'Segmento',
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
    * mostra o grid de segmentos
    *
    */
	public function index() {

        // verifica o acesso
        if ( !$this->checkAccess( [ 'canRead' ] ) ) return;

        // faz a paginacao
		$this->Segmento->grid()

		// seta os filtros
		->order()
		->paginate( 0, 20 )

		// seta as funcoes nas colunas
		->onApply( 'Ações', function( $row, $key ) {
			if ( $this->checkAccess( [ 'canUpdate' ], false ) ) echo '<a href="'.site_url( 'segmentos/alterar/'.$row['Código'] ).'" class="margin btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></a>';
			if ( $this->checkAccess( [ 'canDelete' ], false ) ) echo '<a href="'.site_url( 'segmentos/excluir/'.$row['Código'] ).'" class="margin btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>';            
		})

		// renderiza o grid
		->render( site_url( 'segmentos/index' ) );
		
        // seta a url para adiciona
        if ( $this->checkAccess( [ 'canCreate' ], false ) ) $this->view->set( 'add_url', site_url( 'segmentos/adicionar' ) );

		// seta o titulo da pagina
		$this->view->setTitle( 'Segmentos - lissegmentoem' )->render( 'grid' );
    }

   /**
    * adicionar
    *
    * mostra o formulario de adicao
    *
    */
    public function adicionar() {

        // verifica o acesso
        if ( !$this->checkAccess( [ 'canCreate' ] ) ) return;

        // carrega a view de adicionar
        $this->view->setTitle( 'Conta Ágil - Adicionar segmento' )->render( 'forms/segmento' );
    }

   /**
    * alterar
    *
    * mostra o formulario de edicao
    *
    */
    public function alterar( $key ) {

        // verifica o acesso
        if ( !$this->checkAccess( [ 'canUpdate' ] ) ) return;

        // carrega o cargo
        $segmento = $this->Segmento->clean()->key( $key )->get( true );
        
        // verifica se o mesmo existe
        if ( !$segmento ) {
            redirect( 'segmentos/index' );
            exit();
        }

        // salva na view
        $this->view->set( 'segmento', $segmento );

        // carrega a view de adicionar
        $this->view->setTitle( 'Conta Ágil - Adicionar segmento' )->render( 'forms/segmento' );
    }

   /**
    * excluir
    *
    * exclui um item
    *
    */
    public function excluir( $key ) {

        // verifica o acesso
        if ( !$this->checkAccess( [ 'canDelete' ] ) ) return;

        // pega o segmento
        $segmento = $this->Segmento->clean()->key( $key )->get( true );

        // exclui o segmento
        $segmento->delete();

        // carrega a index
        $this->index();
    }

   /**
    * salvar
    *
    * salva os dados
    *
    */
    public function salvar() {

        // checa a permissao
        // if ( $this->input->post( 'cod' ) )
        //     if ( !$this->checkAccess( [ 'canUpdate' ] ) ) return;
        // else
        //     if ( !$this->checkAccess( [ 'canCreate' ] ) ) return;

        // instancia um novo objeto segmento
        if( $this->input->post( 'cod' ) ) $segmento = $this->Segmento->clean()->key( $this->input->post( 'cod' ) )->get( true );
        else $segmento = $this->Segmento->getEntity();
        $segmento->post( 'nome' );

        // verifica se o formulario é valido
        if ( !$this->_formularioSegmentos() ) {

            // seta os erros de validacao            
            $this->view->set( 'segmento', $segmento );
            $this->view->set( 'errors', validation_errors() );
            
            // carrega a view de adicionar
            $this->view->setTitle( 'Conta Ágil - Adicionar segmento' )->render( 'forms/segmento' );
            return;
        }

        // verifica se o dado foi salvo
        if ( $segmento->save() ) {
            redirect( site_url( 'segmentos/index' ) );
        }
    }
}
