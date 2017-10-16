<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Propostas_func extends MY_Controller {

    // indica se o controller é publico
	protected $loggedUsersOnly = true;

    // seta a proposta
    protected $routine = 'Minhas Propostas';

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
        
        // carrega o finder
        $this->load->model( [ 'Propostas/Proposta', 'Funcionarios/Funcionario', 'PropostasClientes/PropostaCliente' ] );
        
        // chama o modulo
        $this->view->module( 'navbar' )->module( 'aside' )->module( 'text-editor' );
    }

   /**
    * _formularioPropostas
    *
    * valida o formulario de Propostas
    *
    */
    private function _formularioPropostas() {

        // seta as regras
        $rules = [
            [
                'field' => 'proposta',
                'label' => 'Proposta',
                'rules' => 'required|min_length[2]'
            ], [
                'field' => 'descricao',
                'label' => 'Descrição',
                'rules' => 'required|min_length[2]|max_length[250]'
            ], [
                'field' => 'nome',
                'label' => 'Nome',
                'rules' => 'required|min_length[2]|max_length[50]'
            ], [
                'field' => 'dias',
                'label' => 'Dias',
                'rules' => 'required|min_length[1]|max_length[30]'
            ]
        ];

        // valida o formulário
        $this->form_validation->set_rules( $rules );
        return $this->form_validation->run();
    }

    /**
    * index
    *
    * mostra o grid de propostas
    *
    */
	public function index() {

        // verifica o acesso
        if ( !$this->checkAccess( [ 'canRead' ] ) ) return;

        // Pega o id do funcionario logado
        $user = $this->guard->currentUser();

        // faz a paginacao
		$this->Proposta->clean()->grid_assessor( $user->CodFuncionario )

		// seta os filtros
		->order()
		->paginate( 0, 20 )

		// seta as funcoes nas colunas
		->onApply( 'Ações', function( $row, $key ) {
			if ( $this->checkAccess( [ 'canUpdate' ], false ) ) echo '<a href="'.site_url( 'propostas/alterar/'.$row[$key] ).'" class="margin btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></a>';
			echo '<a href="'.site_url( 'propostas_func/disparar_proposta/'.$row[$key] ).'" class="margin btn btn-xs btn-default"><span class="glyphicon glyphicon-send"></span></a>';            
			if ( $this->checkAccess( [ 'canDelete' ], false ) ) echo '<a href="'.site_url( 'propostas/excluir/'.$row[$key] ).'" class="margin btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>';            
		})

		// renderiza o grid
		->render( site_url( 'propostas_func/index' ) );
		
        // seta a url para adiciona
        if ( $this->checkAccess( [ 'canCreate' ], false ) ) $this->view->set( 'add_url', site_url( 'propostas/adicionar' ) );
        if ( $this->Proposta->clean()->funcionario( $user->CodFuncionario )->get() ) $this->view->set( 'send_url', site_url( 'propostas_func/disparo' ) );
        $this->view->set( 'hist_url', site_url( 'propostas_func/historico' ) );        
        
        // seta o titulo
        $this->view->set( 'entity', 'Minhas Propostas' );

		// seta o titulo da pagina
		$this->view->setTitle( 'Propostas - listagem' )->render( 'grid' );
    }

    /**
    * index
    *
    * mostra o grid de propostas
    *
    */
	public function historico() {

        // verifica o acesso
        if ( !$this->checkAccess( [ 'canRead' ] ) ) return;

        // Pega o id do funcionario logado
        $user = $this->guard->currentUser();

        // faz a paginacao
		$this->PropostaCliente->clean()->grid_assessor( $user->CodFuncionario )

		// seta os filtros
		->order()
		->paginate( 0, 20 )

        // seta as funcoes nas colunas
		->onApply( 'Status', function( $row, $key ) {
            if( $row[ $key ] == 'D' ) echo 'Disparada';
            if( $row[ $key ] == 'V' ) echo 'Visualizada';
            if( $row[ $key ] == 'A' ) echo 'Aceita';
            if( $row[ $key ] == 'R' ) echo 'Recusada';
        })

        ->onApply( 'Vencimento', function( $row, $key ) {
            echo date( 'd/m/Y', strtotime( $row[ $key ] ) );
        })

		// renderiza o grid
		->render( site_url( 'propostas_func/index' ) );
        
        // seta o titulo
        $this->view->set( 'entity', 'Histórico' );

		// seta o titulo da pagina
		$this->view->setTitle( 'Propostas - listagem' )->render( 'grid' );
    }

    /**
    * disparar_proposta
    *
    * dispara a proposta para os clientes do usuario logado
    *
    */
    public function disparar_proposta( $CodProposta ) {

        // checa a permissao
        if ( !$this->checkAccess( [ 'canRead' ] ) ) return;

        // carrega o finder
        $this->load->model( [ 'Clientes/Cliente', 'PropostasClientes/PropostaCliente' ] );

        // Pega o id do funcionario logado
        $user = $this->guard->currentUser();

        // carrega a proposta
        $proposta = $this->Proposta->clean()->key( $CodProposta )->get( true );

        // verifica se o mesmo existe
        if ( !$proposta ) {
            
            redirect( 'propostas_func/index' );
            exit();
        } elseif ( $proposta->funcionario != $user->CodFuncionario) {
            
            redirect( 'propostas_func/index' );
            exit();
        } else {

            // busca os clientes do funcionario
            $clientes = $this->Cliente->clean()->funcionario( $user->CodFuncionario )->get();

            // verifica se existe cliente
            if( !$clientes ) {
                redirect( 'propostas_func/index' );
                exit();
            }

            // percorre os clientes
            foreach ( $clientes as $cliente ) {
                if( !$this->PropostaCliente->clean()->periodo( $proposta->CodProposta,
                                                            $cliente->CodCliente,
                                                            date('Y-m-d H:i:s', time() ) )->get() ) {
                    $propostaCliente = $this->PropostaCliente->getEntity();
                    $propostaCliente->set( 'cliente', $cliente->CodCliente )
                            ->set( 'proposta', $proposta->CodProposta )
                            ->set( 'status', "D" )
                            ->set( 'dataDisparo', date('Y-m-d H:i:s', time() ) )
                            ->set( 'dataVencimento', date('Y-m-d H:i:s', strtotime( "+$proposta->dias days", time() ) ) );
                    $propostaCliente->save();
                }
            }
        }
        
        // redireciona para o grid
        redirect( site_url( 'propostas_func/index' ) );
    }

   /**
    * adicionar
    *
    * mostra o formulario de adicao
    *
    */
    public function disparo() {

        // checa a permissao
        if ( !$this->checkAccess( [ 'canRead' ] ) ) return;
        
        // Pega o id do funcionario logado
        $user = $this->guard->currentUser();

        // carrega a model
        $this->load->model( [ 'Clientes/Cliente' ] );
        
        // busca os clientes
        $clientes = $this->Cliente->clean()->funcionario( $user->CodFuncionario )->get();
        $clientes = $clientes ? $clientes : [];
        $this->view->set( 'clientes', $clientes );

        // busca as propostas
        $propostas = $this->Proposta->clean()->funcionario( $user->CodFuncionario )->get();
        $propostas = $propostas ? $propostas : [];
        $this->view->set( 'propostas', $propostas );

        // carrega a view de adicionar
        $this->view->setTitle( 'Trader - Disparar proposta' )->render( 'forms/proposta_disparo' );
    }

   /**
    * adicionar
    *
    * mostra o formulario de adicao
    *
    */
    public function adicionar() {

        // checa a permissao
        if ( !$this->checkAccess( [ 'canCreate' ] ) ) return;

        // carrega a view de adicionar
        $this->view->setTitle( 'Trader - Adicionar proposta' )->render( 'forms/proposta' );
    }

   /**
    * alterar
    *
    * mostra o formulario de edicao
    *
    */
    public function alterar( $key ) {

        // checa a permissao
        if ( !$this->checkAccess( [ 'canUpdate' ] ) ) return;

        // Pega o id do funcionario logado
        $user = $this->guard->currentUser();

        // carrega a proposta
        $proposta = $this->Proposta->clean()->key( $key )->get( true );

        // verifica se o mesmo existe
        if ( !$proposta ) {
            redirect( 'propostas_func/index' );
            exit();
        }

        // salva na view
        $this->view->set( 'proposta', $proposta );

        // carrega a view de adicionar
        $this->view->setTitle( 'Trader - Adicionar proposta' )->render( 'forms/proposta' );
    }

   /**
    * excluir
    *
    * exclui um item
    *
    */
    public function excluir( $key ) {

        // checa a permissao
        if ( !$this->checkAccess( [ 'canDelete' ] ) ) return;

        // carrega a instancia
        $proposta = $this->Proposta->key( $key )->get( true );

        // exclui
        $proposta->delete();

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
            $proposta = $this->Proposta->clean()->key( $this->input->post( 'cod' ) )->get( true );
        else
            $proposta = $this->Proposta->getEntity();
        
        // Pega o id do funcionario logado
        $user = $this->guard->currentUser();

        // instancia um novo objeto grupo
        $proposta->post( 'proposta' )
                 ->post( 'descricao' )
                 ->post( 'nome' )
                 ->post( 'dias' )
                 ->set( 'funcionario', $user->CodFuncionario );

        // verifica se o formulario é valido
        if ( !$this->_formularioPropostas() ) {

            // seta os erros de validacao            
            $this->view->set( 'proposta', $proposta );
            $this->view->set( 'errors', validation_errors() );
            
            // carrega a view de adicionar
            $this->view->setTitle( 'Trader - Adicionar proposta' )->render( 'forms/proposta' );
            return;
        }

        // verifica se o dado foi salvo
        if ( $proposta->save() ) {
            redirect( site_url( 'propostas_func/index' ) );
        }
    }

    
   /**
    * salvar
    *
    * salva os dados
    *
    */
    public function salvar_disparo() {

        // checa a permissao
        if ( !$this->checkAccess( [ 'canUpdate' ] ) ) return;

        // carrega o finder
        $this->load->model( [ 'Clientes/Cliente' ] );

        // Pega o id do funcionario logado
        $user = $this->guard->currentUser();

        // carrega a proposta
        $proposta = $this->Proposta->clean()->key( $this->input->post('proposta') )->get( true );
        
        $cliente = $this->Cliente->clean()->key( $this->input->post('cliente') )->get( true );
        
        // busca os clientes
        $clientes = $this->Cliente->clean()->funcionario( $user->CodFuncionario )->get();
        $clientes = $clientes ? $clientes : [];
        $this->view->set( 'clientes', $clientes );

        // busca as propostas
        $propostas = $this->Proposta->clean()->funcionario( $user->CodFuncionario )->get();
        $propostas = $propostas ? $propostas : [];
        $this->view->set( 'propostas', $propostas );

        // verifica se o mesmo existe
        if ( !$proposta || !$cliente ) {
            
            redirect( 'propostas_func/index' );
            exit();
        } elseif( !$proposta->funcionario == $user->CodFuncionario 
            || !$cliente->funcionario == $user->CodFuncionario ) {

            // seta o erro
            $this->view->set( 'errors', 'Não foi possivel enviar a proposta selecionada.' );

            // carrega a view de adicionar
            $this->view->setTitle( 'Trader - Disparar proposta' )->render( 'forms/proposta_disparo' );

        } elseif( $this->PropostaCliente->clean()->periodo( $proposta->CodProposta,
                                                            $cliente->CodCliente,
                                                            date('Y-m-d H:i:s', time() ) )->get() ) {
            
            // seta o erro
            $this->view->set( 'errors', 'Cliente selecionado já possui a proposta aberta, aguarde a resposta.' );

            // carrega a view de adicionar
            $this->view->setTitle( 'Trader - Disparar proposta' )->render( 'forms/proposta_disparo' );
        } else {

            // seta a entidade
            $propostaCliente = $this->PropostaCliente->getEntity();
            $propostaCliente->set( 'cliente', $cliente->CodCliente )
                        ->set( 'proposta', $proposta->CodProposta )
                        ->set( 'status', "D" )
                        ->set( 'dataDisparo', date('Y-m-d H:i:s', time() ) )
                        ->set( 'dataVencimento', date('Y-m-d H:i:s', strtotime( "+$proposta->dias days", time() ) ) );
            $propostaCliente->save();

            // redireciona para o grid
            redirect( site_url( 'propostas_func/index' ) );
        }
        
    }
}
