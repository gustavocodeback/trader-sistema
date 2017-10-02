<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Classificacoes extends MY_Controller {

    // indica se o controller é publico
	protected $loggedUsersOnly = false;

    // seta a rotina
    protected $routine = 'Classificaçōes';

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
        
        // carrega o finder
        $this->load->model( 'Classificacoes/Classificacao' );
        
        // chama o modulo
        $this->view->module( 'navbar' )->module( 'aside' );
    }

   /**
    * _formularioClassificacoes
    *
    * valida o formulario de classificacoes
    *
    */
    private function _formularioClassificacoes() {

        // seta as regras
        $rules = [
            [
                'field' => 'nome',
                'label' => 'Nome',
                'rules' => 'required|min_length[2]|max_length[30]'
            ], [
                'field' => 'icone',
                'label' => 'Icone',
                'rules' => 'required|min_length[2]|max_length[30]'
            ], [
                'field' => 'ordem',
                'label' => 'Ordem',
                'rules' => 'required|numeric|max_length[30]'
            ]
        ];

        // valida o formulário
        $this->form_validation->set_rules( $rules );
        return $this->form_validation->run();
    }

   /**
    * index
    *
    * mostra o grid de classificacoes
    *
    */
	public function index() {

        // verifica o acesso
        // if ( !$this->checkAccess( [ 'canRead' ] ) ) return;

        // faz a paginacao
		$this->Classificacao->clean()->grid()

		// seta os filtros
		->order()
		->paginate( 0, 20 )

		// seta as funcoes nas colunas
		->onApply( 'Ações', function( $row, $key ) {
			echo '<a href="'.site_url( 'classificacoes/alterar/'.$row['Código'] ).'" class="margin btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></a>';
			echo '<a href="'.site_url( 'classificacoes/excluir/'.$row['Código'] ).'" class="margin btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>';            
		})
        ->onApply( 'Icone', function( $row, $key ) {
            echo '<span class="glyphicon glyphicon-'.$row['Icone'].'"></span>';
        })

		// renderiza o grid
		->render( site_url( 'classificacoes/index' ) );
		
        // seta a url para adiciona
        $this->view->set( 'add_url', site_url( 'classificacoes/adicionar' ) );

		// seta o titulo da pagina
		$this->view->setTitle( 'classificacoes - listagem' )->render( 'grid' );
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
        $this->view->setTitle( 'Conta Ágil - Adicionar classificacao' )->render( 'forms/classificacao' );
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

        // carrega o classificacao
        $classificacao = $this->Classificacao->clean()->key( $key )->get( true );

        // verifica se o mesmo existe
        if ( !$classificacao ) {
            redirect( 'classificacoes/index' );
            exit();
        }

        // salva na view
        $this->view->set( 'classificacao', $classificacao );

        // carrega a view de adicionar
        $this->view->setTitle( 'Conta Ágil - Adicionar classificacao' )->render( 'forms/classificacao' );
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

        // pega o item
        $classificacao = $this->Classificacao->clean()->key( $key )->get( true );

        // deleta o item
        $classificacao->delete();

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

        // verifica se ja existe o codigo
        if ( $this->input->post( 'cod' ) )
            $classificacao = $this->Classificacao->clean()->key( $this->input->post( 'cod' ) )->get( true );
        else
            $classificacao = $this->Classificacao->getEntity();

        $classificacao->post( 'nome' )
                      ->post( 'icone' )
                      ->post( 'ordem' );

        // verifica se o formulario é valido
        if ( !$this->_formularioClassificacoes() ) {

            // seta os erros de validacao            
            $this->view->set( 'classificacao', $classificacao );
            $this->view->set( 'errors', validation_errors() );
            
            // carrega a view de adicionar
            $this->view->setTitle( 'Conta Ágil - Adicionar classificacao' )->render( 'forms/classificacao' );
            return;
        }

        // verifica se o dado foi salvo
        if ( $classificacao->save() ) {
            redirect( site_url( 'classificacoes/index' ) );
        }
    }
}
