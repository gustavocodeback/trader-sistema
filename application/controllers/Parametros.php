<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Parametros extends MY_Controller {

    // indica se o controller é publico
	protected $loggedUsersOnly = false;

    // seta a rotina
    protected $routine = 'Parametros';

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
        
        // carrega o finder
        $this->load->model( 'Parametros/Parametro' );
        
        // chama o modulo
        $this->view->module( 'cover' )->set( 'navbar-index', 1 );
    }

   /**
    * _formularioParametros
    *
    * valida o formulario de parametros
    *
    */
    private function _formularioParametros() {

        // seta as regras
        $rules = [
            [
                'field' => 'descricao',
                'label' => 'Parametro',
                'rules' => 'required|min_length[2]|max_length[30]'
            ],[
                'field' => 'valor',
                'label' => 'Valor',
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
    * mostra o grid de parametros
    *
    */
	public function index() {

        // verifica o acesso
        // if ( !$this->checkAccess( [ 'canRead' ] ) ) return;

        // faz a paginacao
		$this->Parametro->grid()

		// seta os filtros
		->order()
		->paginate( 0, 20 )

		// seta as funcoes nas colunas
		->onApply( 'Ações', function( $row, $key ) {
			echo '<a href="'.site_url( 'parametros/alterar/'.$row['Código'] ).'" class="margin btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></a>';
			echo '<a href="'.site_url( 'parametros/excluir/'.$row['Código'] ).'" class="margin btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>';            
		})

		// renderiza o grid
		->render( site_url( 'parametros/index' ) );
		
        // seta a url para adiciona
        $this->view->set( 'add_url', site_url( 'parametros/adicionar' ) );

		// seta o titulo da pagina
		$this->view->setTitle( 'Parâmetros - listagem' )->render( 'grid' );
    }

   /**
    * adicionar
    *
    * mostra o formulario de adicao
    *
    */
    public function adicionar() {

        // verifica o acesso
        // if ( !$this->checkAccess( [ 'canCreate' ] ) ) return;

        // carrega a view de adicionar
        $this->view->setTitle( 'Trader - Adicionar parâmetro' )->render( 'forms/parametro' );
    }

   /**
    * alterar
    *
    * mostra o formulario de edicao
    *
    */
    public function alterar( $key ) {

        // verifica o acesso
        // if ( !$this->checkAccess( [ 'canUpdate' ] ) ) return;

        // carrega o cargo
        $parametro = $this->Parametro->clean()->key( $key )->get( true );
        
        // verifica se o mesmo existe
        if ( !$parametro ) {
            redirect( 'parametros/index' );
            exit();
        }

        // salva na view
        $this->view->set( 'parametro', $parametro );

        // carrega a view de adicionar
        $this->view->setTitle( 'Trader - Adicionar parâmetro' )->render( 'forms/parametro' );
    }

   /**
    * excluir
    *
    * exclui um item
    *
    */
    public function excluir( $key ) {

        // verifica o acesso
        // if ( !$this->checkAccess( [ 'canDelete' ] ) ) return;

        // pega o parametro
        $parametro = $this->Parametro->clean()->key( $key )->get( true );

        // exclui o parametro
        $parametro->delete();

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

        // instancia um novo objeto parametro
        if( $this->input->post( 'cod' ) ) $parametro = $this->Parametro->clean()->key( $this->input->post( 'cod' ) )->get( true );
        else $parametro = $this->Parametro->getEntity();
        $parametro->post( 'descricao' )
                  ->post( 'valor' );

        // verifica se o formulario é valido
        if ( !$this->_formularioParametros() ) {

            // seta os erros de validacao            
            $this->view->set( 'parametro', $parametro );
            $this->view->set( 'errors', validation_errors() );
            
            // carrega a view de adicionar
            $this->view->setTitle( 'Trader - Adicionar parâmetro' )->render( 'forms/parametro' );
            return;
        }

        // verifica se o dado foi salvo
        if ( $parametro->save() ) {
            redirect( site_url( 'parametros/index' ) );
        }
    }
}
