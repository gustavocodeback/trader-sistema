<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cidades extends MY_Controller {

    // indica se o controller é publico
	protected $loggedUsersOnly = true;

    // rotina
    protected $routine = 'Cidades';

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
    * _formularioEstados
    *
    * valida o formulario de estados
    *
    */
    private function _formularioCidade() {

        // seta as regras
        $rules = [
            [
                'field' => 'nome',
                'label' => 'Nome',
                'rules' => 'required|min_length[3]|max_length[32]|trim'
            ],[
                'field' => 'estado',
                'label' => 'Estado',
                'rules' => 'required|min_length[1]|max_length[2]|trim'
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
		$this->Cidade->grid()

		// seta os filtros
        ->addFilter( 'nome', 'text', false, 'c' )
		->filter()
		->order()
		->paginate( 0, 20 )

		// seta as funcoes nas colunas
		->onApply( 'Ações', function( $row, $key ) {
			if ( $this->checkAccess( [ 'canUpdate' ], false ) ) echo '<a href="'.site_url( 'cidades/alterar/'.$row['Código'] ).'" class="margin btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></a>';
			if ( $this->checkAccess( [ 'canDelete' ], false ) ) echo '<a href="'.site_url( 'cidades/excluir/'.$row['Código'] ).'" class="margin btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>';            
		})

		// renderiza o grid
		->render( site_url( 'cidades/index' ) );
		
        // seta a url para adiciona
        if ( $this->checkAccess( [ 'canCreate' ], false ) ) $this->view->set( 'add_url', site_url( 'cidades/adicionar' ) );

		// seta o titulo da pagina
		$this->view->setTitle( 'Cidades - listagem' )->render( 'grid' );
    }

   /**
    * obter_cidades_estado
    *
    * obtem as cidades de um estado
    *
    */
    public function obter_cidades_estado( $CodEstado ) {

        // carrega o estado
        $estado = $this->Estado->key( $CodEstado )->get( true );
        if ( !$estado ) return $this->close();

        // carrega as cidades do estado
        $cidades = $this->Cidade->porEstado( $estado )->get();
        if ( count( $cidades ) == 0 ) {
            echo json_encode( [] );
            return;
        }

        // faz o mapeamento das cidades
        $cidades = array_map( function( $cidade ) {
            return  [ 
                        'value' => $cidade->CodCidade, 
                        'label' => $cidade->nome
                    ];
        }, $cidades );
        // volta o json
        echo json_encode( $cidades );
        return;
    }

   /**
    * adicionar
    *
    * mostra o formulario de adicao
    *
    */
    public function adicionar() {

        // verifica a permissao
        if ( !$this->checkAccess( [ 'canCreate' ] ) ) return;

        // carrega os estados
        $estados = $this->Estado->get();
        $this->view->set( 'estados', $estados );

        // carrega a view de adicionar
        $this->view->setTitle( 'Conta Ágil - Adicionar cidade' )->render( 'forms/cidade' );
    }

   /**
    * alterar
    *
    * mostra o formulario de edicao
    *
    */
    public function alterar( $key ) {

        // verifica a permissao
        if ( !$this->checkAccess( [ 'canUpdate' ] ) ) return;

        // carrega os estados
        $estados = $this->Estado->get();
        $this->view->set( 'estados', $estados );

        // carrega o cargo
        $cidade = $this->Cidade->key( $key )->get( true );

        // verifica se o mesmo existe
        if ( !$cidade ) {
            redirect( 'estados/index' );
            exit();
        }

        // salva na view
        $this->view->set( 'cidade', $cidade );

        // carrega a view de adicionar
        $this->view->setTitle( 'Conta Ágil - Alterar cidade' )->render( 'forms/cidade' );
    }

   /**
    * excluir
    *
    * exclui um item
    *
    */
    public function excluir( $key ) {

        // verifica a permissao
        if ( !$this->checkAccess( [ 'canDelete' ] ) ) return;

        // seta as cidades
        $cidade = $this->Cidade->clean()->key( $key )->get( true );

        // deleta
        $cidade->delete();

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

        // // checa a permissao
        // if ( $this->input->post( 'cod' ) )
        //     if ( !$this->checkAccess( [ 'canUpdate' ] ) ) return;
        // else
        //     if ( !$this->checkAccess( [ 'canCreate' ] ) ) return;
        
        // verifica se ja existe o codigo
        if ( $this->input->post( 'cod' ) )
            $cidade = $this->Cidade->clean()->key( $this->input->post( 'cod' ) )->get( true );
        else
            $cidade = $this->Cidade->getEntity();

        // instancia um novo objeto grupo
        $cidade->post( 'nome' )
                ->post( 'estado' );

        // verifica se o formulario é valido
        if ( !$this->_formularioCidade() ) {

            // seta os erros de validacao            
            $this->view->set( 'cidade', $cidade );
            $this->view->set( 'errors', validation_errors() );
            
            // carrega a view de adicionar
            $this->view->setTitle( 'Conta Ágil - Adicionar cidade' )->render( 'forms/cidade' );
            return;
        }

        // verifica se o dado foi salvo
        if ( $cidade->save() ) {
            redirect( site_url( 'cidades/index' ) );
        }
    }
}
