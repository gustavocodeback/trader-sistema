<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends MY_Controller {

    // indica se o controller é publico
	protected $loggedUsersOnly = true;

    // seta a rotina
    protected $routine = 'Posts';

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
        
        // carrega o finder
        $this->load->model( 'Posts/Post' );
        
        // carrega a librarie de fotos
		$this->load->library( 'Picture' );
        
        // chama o modulo
        $this->view->module( 'cover' )->set( 'navbar-index', 1 )->module( 'text-editor' );
    }

   /**
    * _formularioPosts
    *
    * valida o formulario de posts
    *
    */
    private function _formularioPosts() {

        // seta as regras
        $rules = [
            [
                'field' => 'textoCurto',
                'label' => 'Texto Curto',
                'rules' => 'required|min_length[2]|max_length[30]'
            ],
            [
                'field' => 'post',
                'label' => 'Post',
                'rules' => 'required|min_length[2]'
            ],
            [
                'field' => 'imagem',
                'label' => 'Imagem',
                'rules' => 'required'
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
		$this->Post->clean()->grid()

		// seta os filtros
		->order()
		->paginate( 0, 20 )

		// seta as funcoes nas colunas
		->onApply( 'Ações', function( $row, $key ) {
			echo '<a href="'.site_url( 'posts/alterar/'.$row['Código'] ).'" class="margin btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></a>';
			echo '<a href="'.site_url( 'posts/excluir/'.$row['Código'] ).'" class="margin btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>';            
		})

		// renderiza o grid
		->render( site_url( 'posts/index' ) );
		
        // seta a url para adiciona
        $this->view->set( 'add_url', site_url( 'posts/adicionar' ) );

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
        $this->view->setTitle( 'Trader - Adicionar post' )->render( 'forms/post' );
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
        $post = $this->Post->clean()->key( $key )->get( true );
        
        // verifica se o mesmo existe
        if ( !$post ) {
            redirect( 'posts/index' );
            exit();
        }

        // salva na view
        $this->view->set( 'post', $post );

        // carrega a view de adicionar
        $this->view->setTitle( 'Trader - Adicionar post' )->render( 'forms/post' );
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
        $post = $this->Post->clean()->key( $key )->get( true );

        // exclui o tag
        $post->delete();

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
        
        // faz o upload da imagem
        $file_name = $this->picture->upload( 'foto', [] );

        // instancia um novo objeto tag
        if( $this->input->post( 'cod' ) ) $post = $this->Post->clean()->key( $this->input->post( 'cod' ) )->get( true );
        else $post = $this->Post->getEntity();
         
        // verifica se existe uma foto
        if ( $file_name ) {

            // seta a foto
            if ( $post->imagem ) $this->picture->delete( $post->imagem );
            $post->set( 'imagem', $file_name );
            $post->save();
        }

        $post->post( 'post' )
             ->post( 'titulo' )
             ->post( 'textoCurto' );

        // verifica se o formulario é valido
        if ( !$this->_formularioPosts() ) {

            // seta os erros de validacao            
            $this->view->set( 'post', $post );
            $this->view->set( 'errors', validation_errors() );
            
            // carrega a view de adicionar
            $this->view->setTitle( 'Trader - Adicionar post' )->render( 'forms/post' );
            return;
        }

        // verifica se o dado foi salvo
        if ( $post->save() ) {
            redirect( site_url( 'posts/index' ) );
        }
    }
}
