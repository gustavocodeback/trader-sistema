<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Propostas extends MY_Controller {

    // indica se o controller é publico
	protected $loggedUsersOnly = true;

    // seta a proposta
    protected $routine = 'Propostas';

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

        //verifica se é assessor
        $aux = ( $user->gid == 2 ) ? true : false;

        // faz a paginacao
		$this->Proposta->clean()->grid( $aux )

		// seta os filtros
		->order()
        ->paginate( 0, 20 )

		// seta as funcoes nas colunas
		->onApply( 'Ações', function( $row, $key ) {
			if ( $this->checkAccess( [ 'canUpdate' ], false ) ) echo '<a href="'.site_url( 'propostas/alterar/'.$row[$key] ).'" class="margin btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></a>';
			if ( $this->checkAccess( [ 'canDelete' ], false ) ) echo '<a href="'.site_url( 'propostas/excluir/'.$row[$key] ).'" class="margin btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>';            
		})

		// renderiza o grid
        ->render( site_url( 'propostas/index' ) );
        
        // seta a url para adiciona
        if ( $this->checkAccess( [ 'canCreate' ], false ) ) $this->view->set( 'add_url', site_url( 'propostas/adicionar/' ) );
        $this->view->set( 'send_url', site_url( 'propostas_func/disparo' ) );
        $this->view->set( 'hist_url', site_url( 'propostas_func/historico' ) );
		 
        // seta o titulo
        $this->view->set( 'entity', 'Propostas' );

		// seta o titulo da pagina
		$this->view->setTitle( 'Propostas - listagem' )->render( 'grid' );
    }

    /**
    * index
    *
    * mostra o grid de propostas
    *
    */
	public function historico( $key ) {

        // verifica o acesso
        if ( !$this->checkAccess( [ 'canRead' ] ) ) return;

        $funcionario = $this->Funcionario->clean()->key( $key )->get( true );

        // faz a paginacao
		$this->PropostaCliente->clean()->grid_assessor( $funcionario->CodFuncionario )

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
		->render( site_url( 'propostas/index' ) );
        
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
        // if ( !$this->checkAccess( [ 'canCreate' ] ) ) return;

        // carrega o finder
        $this->load->model( [ 'Clientes/Cliente', 'PropostasClientes/PropostaCliente' ] );

        // Pega o id do funcionario logado
        $user = $this->guard->currentUser();

        // carrega a proposta
        $proposta = $this->Proposta->clean()->key( $CodProposta )->get( true );

        // verifica se o mesmo existe
        if ( !$proposta ) {
            
            redirect( 'propostas/index' );
            exit();
        } elseif ( $proposta->funcionario != $user->CodFuncionario) {
            
            redirect( 'propostas/index' );
            exit();
        } else {

            // busca os clientes do funcionario
            $clientes = $this->Cliente->clean()->funcionario( $user->CodFuncionario )->get();

            // verifica se existe cliente
            if( !$clientes ) {
                redirect( 'propostas/index' );
                exit();
            }

            // percorre os clientes
            foreach ( $clientes as $cliente ) {
                if( !$this->PropostaCliente->clean()->periodo( $proposta->CodProposta,
                                                            $cliente->CodCliente,
                                                            date('Y-m-d', time() ) )->get() ) {
                    $propostaCliente = $this->PropostaCliente->getEntity();
                    $propostaCliente->set( 'cliente', $cliente->CodCliente )
                            ->set( 'proposta', $proposta->CodProposta )
                            ->set( 'status', "D" )
                            ->set( 'dataDisparo', date('Y-m-d', time() ) )
                            ->set( 'dataVencimento', date('Y-m-d', strtotime( "+$proposta->dias days", time() ) ) );
                    $propostaCliente->save();
                }
            }
        }
        
        // redireciona para o grid
        redirect( site_url( 'propostas/index' ) );
    }

   /**
    * adicionar
    *
    * mostra o formulario de adicao
    *
    */
    public function disparo() {

        // checa a permissao
        // if ( !$this->checkAccess( [ 'canCreate' ] ) ) return;
        
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
        // if ( !$this->checkAccess( [ 'canCreate' ] ) ) return;

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
        // if ( !$this->checkAccess( [ 'canUpdate' ] ) ) return;

        // Pega o id do funcionario logado
        $user = $this->guard->currentUser();

        // carrega a proposta
        $proposta = $this->Proposta->clean()->key( $key )->get( true );

        // verifica se o mesmo existe
        if ( !$proposta ) {
            redirect( 'propostas/index' );
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
        // if ( !$this->checkAccess( [ 'canDelete' ] ) ) return;

        // carrega a instancia
        $proposta = $this->Proposta->key( $key )->get( true );

        // inicia o array de disparos
        $propostasClientes = [];

        // busca os disparos feitos com a proposta
        $propostasClientes = $this->PropostaCliente->buscaDisparoPorPropostaId( $key )->get();

        // verifica se retornou algum disparo
        if ( $propostasClientes ) {

            // seta mensagem de proposta ja disparada
            $this->view->set( 'erro', "Não é possivel apagar esta proposta, pois ela já foi disparada." );

            // seta o titulo da pag
            return $this->index();
        }

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
                 ->post( 'dias' );

        // Guarda o funcionario que criou a proposta
        $proposta->funcionario = $user->CodFuncionario;

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

            // redireciona a pagina
            redirect( site_url( 'propostas/index' ) );
        }
    }

    /**
    * envia_push
    * 
    * envia o push de mensagem para o cliente
    */
    private function envia_push( $dados ) {
        
        // carrega a library de push
        $this->load->library( 'Push' );

        $ret = [];

        // percorre o array de dados
        foreach( $dados as $key => $dado ) {

            // verifica se veio id do celular
            if ( !$dado['idCelular'] ) return false;
    
            // pega a instancia da mensagem
            $this->push->setTitle( 'Você possui '. $dado['qtde'] .' nova(s) proposta(s)!'  )
                    ->setbody( "Clique aqui para visualizar" );

            // verifica se a proposta foi enviada
            $ret[] = ( $this->push->fire( $dado['idCelular'] ) ) ? "sucesso" : "erro";
            
        }
    }
    
    /**
    * propostasSelecionadas
    * 
    * pega as propostas selecionadas pelo usuario
    */
    private function propostasSelecionadas( $key ) {

        // carrega a model
        $this->load->model( 'Propostas/Proposta' );

        // Salva as chaves das propostas
        $propostasKeys = $this->input->post( $key );
        
        // verifica se veio as propostas
        if ( !$propostasKeys ) return [];
        
        // propostas selecionadas
        $propostasSelecionadas = [];

        // busca as propostas
        if ( $propostasKeys[0] == 0 ) {

            // pega a proposta
            $propostasSelecionadas = $this->Proposta->clean()->get();
        } else {

            // percorre as chaves das propostas
            $propostasSelecionadas = $this->Proposta->clean()->in( $propostasKeys )->get();
        }

        // volta as propostas encontradas
        return $propostasSelecionadas;
    }

   /**
    * salvar_disparo
    *
    * salva o disparo
    *
    */
    public function salvar_disparo() {

        // carrega o finder
        $this->load->model( [ 'Segmentos/Segmento' ] );

        // busca todos os segmentos e seta na view
        $segmentos = $this->Segmento->clean()->get();
        $this->view->set( 'segmentos', $segmentos ? $segmentos : [] );

        // busca todas as propostas e seta na view
        $propostas = $this->Proposta->clean()->get();
        $this->view->set( 'propostas', $propostas ? $propostas : [] );

        // busca os cliente
        $segmento = $this->Segmento->clean()->key( $this->input->post( 'segmento' ) )->get( true );
        if ( !$segmento ) {

            // seta os erros
            $this->view->set( 'errors', 'Informe um segmento.' );
            $this->view->render( 'forms/proposta_disparo' );
            return;
        }

        // busca as propostas
        $propostas = $this->propostasSelecionadas( 'propDisparadas' );
        foreach( $propostas as $proposta ) {
            
            // verifica se pode enviar a proposta
            if( $proposta->podeEnviar( $segmento->CodSegmento ) ) {
                
                // envia a proposta
                $segmento->enviarProposta( $proposta );
            }
        }

        // verifica se tem $dados
        if ( isset( $disparos ) ) $this->envia_push( $disparos );

        // verifica se foi enviado o disparo
        $this->view->set( 'success', 'Proposta(s) enviadas com sucesso' );
        $this->view->render( 'forms/proposta_disparo' );
    }
}
