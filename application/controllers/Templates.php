<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Templates extends MY_Controller {

    // indica se o controller é publico
	protected $loggedUsersOnly = true;

    // seta a rotina
    protected $routine = 'Templates';

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
        
        // carrega o finder
        $this->load->model( 'Templates/Template' );
        
        // chama o modulo
        $this->view->module( 'cover' )->set( 'navbar-index', 1 )->module( 'text-editor' );
    }

   /**
    * _formularioTemplates
    *
    * valida o formulario de templates
    *
    */
    private function _formularioTemplates() {

        // seta as regras
        $rules = [
            [
                'field' => 'nome',
                'label' => 'Nome',
                'rules' => 'required|min_length[2]|max_length[30]'
            ],
            [
                'field' => 'corpo',
                'label' => 'Corpo',
                'rules' => 'required|min_length[2]'
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
	public function index() {

        // verifica o acesso
        // if ( !$this->checkAccess( [ 'canRead' ] ) ) return;

        // faz a paginacao
		$this->Template->grid()

		// seta os filtros
		->order()
		->paginate( 0, 20 )

		// seta as funcoes nas colunas
		->onApply( 'Ações', function( $row, $key ) {
			echo '<a href="'.site_url( 'templates/alterar/'.$row['Código'] ).'" class="margin btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></a>';
			echo '<a href="'.site_url( 'templates/excluir/'.$row['Código'] ).'" class="margin btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>';            
		})

		// renderiza o grid
		->render( site_url( 'templates/index' ) );
		
        // seta a url para adiciona
        $this->view->set( 'add_url', site_url( 'templates/adicionar' ) );

		// seta o titulo da pagina
		$this->view->setTitle( 'Templates - listagem' )->render( 'grid' );
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
        $this->view->setTitle( 'Trader - Adicionar template' )->render( 'forms/template' );
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
        $template = $this->Template->clean()->key( $key )->get( true );
        
        // verifica se o mesmo existe
        if ( !$template ) {
            redirect( 'templates/index' );
            exit();
        }

        // salva na view
        $this->view->set( 'template', $template );

        // carrega a view de adicionar
        $this->view->setTitle( 'Trader - Adicionar template' )->render( 'forms/template' );
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

        // pega o tag
        $template = $this->Template->clean()->key( $key )->get( true );

        // exclui o tag
        $template->delete();

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

        // instancia um novo objeto tag
        if( $this->input->post( 'cod' ) ) $template = $this->Template->clean()->key( $this->input->post( 'cod' ) )->get( true );
        else $template = $this->Template->getEntity();
        $template->post( 'nome' );
        $template->post( 'corpo' );

        // verifica se o formulario é valido
        if ( !$this->_formularioTemplates() ) {

            // seta os erros de validacao            
            $this->view->set( 'template', $template );
            $this->view->set( 'errors', validation_errors() );
            
            // carrega a view de adicionar
            $this->view->setTitle( 'Trader - Adicionar template' )->render( 'forms/template' );
            return;
        }

        // verifica se o dado foi salvo
        if ( $template->save() ) {
            redirect( site_url( 'templates/index' ) );
        }
    }
}
