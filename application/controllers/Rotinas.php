<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rotinas extends MY_Controller {

    // indica se o controller é publico
	protected $loggedUsersOnly = true;

    // seta a rotina
    protected $routine = 'Rotinas';

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
        
        // carrega o finder
        $this->load->model( [ 'Rotinas/Rotina', 'Classificacoes/Classificacao' ] );
        
        // chama o modulo
        $this->view->module( 'navbar' )->module( 'aside' );
    }

   /**
    * _formulariorotinas
    *
    * valida o formulario de rotinas
    *
    */
    private function _formularioRotinas() {

        // seta as regras
        $rules = [
            [
                'field' => 'rotina',
                'label' => 'Rotinas',
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
    * mostra o grid de rotinas
    *
    */
	public function index() {

        // verifica o acesso
        // if ( !$this->checkAccess( [ 'canRead' ] ) ) return;

        // faz a paginacao
		$this->Rotina->clean()->grid()

		// seta os filtros
		->order()
		->paginate( 0, 20 )

		// seta as funcoes nas colunas
		->onApply( 'Ações', function( $row, $key ) {
			echo '<a href="'.site_url( 'rotinas/alterar/'.$row[$key] ).'" class="margin btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></a>';
			echo '<a href="'.site_url( 'rotinas/excluir/'.$row[$key] ).'" class="margin btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>';            
		})

		// renderiza o grid
		->render( site_url( 'rotinas/index' ) );
		
        // seta a url para adiciona
        $this->view->set( 'add_url', site_url( 'rotinas/adicionar' ) );
        
        // seta o titulo
        $this->view->set( 'entity', 'Rotinas' );

		// seta o titulo da pagina
		$this->view->setTitle( 'rotinas - listagem' )->render( 'grid' );
    }

   /**
    * adicionar
    *
    * mostra o formulario de adicao
    *
    */
    public function adicionar() {

        // checa a permissao
        // if ( !$this->checkAccess( [ 'canCreate' ] ) ) return;

        // carrega as classificacoes
        $class = $this->Classificacao->get();

        // seta a view
        $this->view->set( 'class', $class );

        // carrega a view de adicionar
        $this->view->setTitle( 'Conta Ágil - Adicionar rotina' )->render( 'forms/rotina' );
    }

   /**
    * alterar
    *
    * mostra o formulario de edicao
    *
    */
    public function alterar( $key ) {

        // checa a permissao
        // if ( !$this->checkAccess( [ 'canUpdate' ] ) ) return;

        // carrega as classificacoes
        $class = $this->Classificacao->get();

        // seta a view
        $this->view->set( 'class', $class );

        // carrega o cargo
        $rotina = $this->Rotina->key( $key )->get( true );

        // verifica se o mesmo existe
        if ( !$rotina ) {
            redirect( 'rotinas/index' );
            exit();
        }

        // salva na view
        $this->view->set( 'rotina', $rotina );

        // carrega a view de adicionar
        $this->view->setTitle( 'Conta Ágil - Adicionar rotina' )->render( 'forms/rotina' );
    }

   /**
    * excluir
    *
    * exclui um item
    *
    */
    public function excluir( $key ) {

        // checa a permissao
        // if ( !$this->checkAccess( [ 'canDelete' ] ) ) return;

        // carrega a instancia
        $rotina = $this->Rotina->key( $key )->get( true );

        // exclui
        $rotina->delete();

        // carrega a pagina 
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
            $rotina = $this->Rotina->clean()->key( $this->input->post( 'cod' ) )->get( true );
        else
            $rotina = $this->Rotina->getEntity();

        // instancia um novo objeto grupo
        $rotina->post( 'rotina' )
                ->post( 'classificacao' )
                ->post( 'link' );

        // verifica se o formulario é valido
        if ( !$this->_formularioRotinas() ) {

            // seta os erros de validacao            
            $this->view->set( 'rotina', $rotina );
            $this->view->set( 'errors', validation_errors() );
            
            // carrega a view de adicionar
            $this->view->setTitle( 'Conta Ágil - Adicionar cargo' )->render( 'forms/rotina' );
            return;
        }

        // verifica se o dado foi salvo
        if ( $rotina->save() ) {
            redirect( site_url( 'rotinas/index' ) );
        }
    }
}
