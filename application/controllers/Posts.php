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
                'field' => 'titulo',
                'label' => 'Titulo',
                'rules' => 'required|min_length[2]|max_length[30]'
            ],
            [
                'field' => 'textoCurto',
                'label' => 'Texto Curto',
                'rules' => 'required|min_length[2]|max_length[255]'
            ],
            [
                'field' => 'post',
                'label' => 'Post',
                'rules' => 'min_length[2]'
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
        if ( !$this->checkAccess( [ 'canRead' ] ) ) return;

        // faz a paginacao
		$this->Post->clean()->grid()

		// seta os filtros
		->order()
		->paginate( 0, 20 )

		// seta as funcoes nas colunas
		->onApply( 'Ações', function( $row, $key ) {
			if ( $this->checkAccess( [ 'canUpdate' ], false ) ) echo '<a href="'.site_url( 'posts/alterar/'.$row['Código'] ).'" class="margin btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></a>';
			if ( $this->checkAccess( [ 'canDelete' ], false ) ) echo '<a href="'.site_url( 'posts/excluir/'.$row['Código'] ).'" class="margin btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>';            
		})

		// renderiza o grid
		->render( site_url( 'posts/index' ) );
		
        // seta a url para adiciona
        if ( $this->checkAccess( [ 'canCreate' ], false ) ) $this->view->set( 'add_url', site_url( 'posts/adicionar' ) );

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
        if ( !$this->checkAccess( [ 'canCreate' ] ) ) return;

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
        if ( !$this->checkAccess( [ 'canUpdate' ] ) ) return;

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
        if ( !$this->checkAccess( [ 'canDelete' ] ) ) return;

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
        else {
            $post = $this->Post->getEntity();
            $post->set( 'data', date( 'Y-m-d H:i:s', time() ) );
        }

        $post->post( 'titulo' )
             ->post( 'textoCurto' );

        // verifica se tem post
        if( $this->input->post( 'post' ) ) $post->post( 'post' );   
         
        // verifica se existe uma foto
        if ( $file_name ) {

            // seta a foto
            if ( $post->imagem ) $this->picture->delete( $post->imagem );
            $post->set( 'imagem', $file_name );
            $post->save();
        }

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

            // envia push de novo post
            $this->envia_push( $post->titulo );
            // redireciona a pagina
            redirect( site_url( 'posts/index' ) );
        }
    }

    /**
    * envia_push
    * 
    * envia o push de mensagem para o cliente
    */
    private function envia_push( $titulo ) {
        
        // carrega a library de push
        $this->load->library( 'Push' );

        // pega a instancia da mensagem
        $this->push->setTitle( 'Novo post!' )
                    ->setbody( $titulo );

        // verifica se a proposta foi enviada
        return ( $this->push->fire() ) ? "sucesso" : "erro";
    }
}
