<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Estados extends MY_Controller {

    // indica se o controller é publico
	protected $loggedUsersOnly = false;

    // seta a rotina
    protected $routine = 'Estados';

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
        
        // carrega o finder
        $this->load->model( [ 'Estados/Estado' ] );
        
        // chama o modulo
        $this->view->module( 'navbar' )->module( 'aside' );
    }

   /**
    * _formularioEstados
    *
    * valida o formulario de estados
    *
    */
    private function _formularioEstados() {

        // seta as regras
        $rules = [
            [
                'field' => 'nome',
                'label' => 'Nome',
                'rules' => 'required|min_length[3]|max_length[32]|trim'
            ],[
                'field' => 'uf',
                'label' => 'UF',
                'rules' => 'required|min_length[2]|max_length[2]|trim'
            ]
        ];

        // valida o formulário
        $this->form_validation->set_rules( $rules );
        return $this->form_validation->run();
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

        // faz a paginacao
		$this->Estado->grid()

		// seta os filtros
        ->addFilter( 'nome', 'text' )
		->filter()
		->order()
		->paginate( 0, 20 )

		// seta as funcoes nas colunas
		->onApply( 'Ações', function( $row, $key ) {
			if ( $this->checkAccess( [ 'canUpdate' ], false ) ) echo '<a href="'.site_url( 'estados/alterar/'.$row['Código'] ).'" class="margin btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></a>';
			if ( $this->checkAccess( [ 'canDelete' ], false ) ) echo '<a href="'.site_url( 'estados/excluir/'.$row['Código'] ).'" class="margin btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>';            
		})

		// renderiza o grid
		->render( site_url( 'estados/index' ) );
		
        // seta a url para adiciona
        if ( $this->checkAccess( [ 'canCreate' ], false ) ) $this->view->set( 'add_url', site_url( 'estados/adicionar' ) );

		// seta o titulo da pagina
		$this->view->setTitle( 'Estados - listagem' )->render( 'grid' );
    }

   /**
    * adicionar
    *
    * mostra o formulario de adicao
    *
    */
    public function adicionar() {

        // verifica a permissao
        // if ( !$this->checkAccess( [ 'canCreate' ] ) ) return;

        // carrega a view de adicionar
        $this->view->setTitle( 'Conta Ágil - Adicionar estado' )->render( 'forms/estado' );
    }

   /**
    * alterar
    *
    * mostra o formulario de edicao
    *
    */
    public function alterar( $key ) {

        // verifica a permissao
        // if ( !$this->checkAccess( [ 'canUpdate' ] ) ) return;

        // carrega o cargo
        $estado = $this->Estado->key( $key )->get( true );

        // verifica se o mesmo existe
        if ( !$estado ) {
            redirect( 'estados/index' );
            exit();
        }

        // salva na view
        $this->view->set( 'estado', $estado );

        // carrega a view de adicionar
        $this->view->setTitle( 'Conta Ágil - Alterar estado' )->render( 'forms/estado' );
    }

   /**
    * excluir
    *
    * exclui um item
    *
    */
    public function excluir( $key ) {

        // verifica a permissao
        // if ( !$this->checkAccess( [ 'canDelete' ] ) ) return;

        // seta o grupo
        $estado = $this->Estado->key( $key )->get( true );

        // seta o delete
        $estado->delete();

        // carrega o index
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
        
        // verifica se ja existe o codigo
        if ( $this->input->post( 'cod' ) )
            $estado = $this->Estado->clean()->key( $this->input->post( 'cod' ) )->get( true );
        else
            $estado = $this->Estado->getEntity();

        // instancia um novo objeto grupo
        $estado->post( 'nome' )
                ->post( 'uf' );

        // verifica se o formulario é valido
        if ( !$this->_formularioEstados() ) {

            // seta os erros de validacao            
            $this->view->set( 'estado', $estado );
            $this->view->set( 'errors', validation_errors() );
            
            // carrega a view de adicionar
            $this->view->setTitle( 'Conta Ágil - Adicionar estado' )->render( 'forms/estado' );
            return;
        }

        // verifica se o dado foi salvo
        if ( $estado->save() ) {
            redirect( site_url( 'estados/index' ) );
        }
    }
}
