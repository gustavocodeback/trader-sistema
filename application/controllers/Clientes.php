<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends MY_Controller {

    // indica se o controller é publico
	protected $loggedUsersOnly = true;

    // seta a rotina
    protected $routine = 'Clientes';

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
        
        // carrega o finder
        $this->load->model( [ 'Clientes/Cliente', 'TagsClientes/TagCliente' ] );
        
        // chama o modulo
        $this->view->module( 'cover' )->set( 'navbar-index', 1 );
    }

   /**
    * _formularioCliente
    *
    * valida o formulario de funcionarios
    *
    */
    private function _formularioClientes() {

        $rules = [
            [
                'field' => 'nome',
                'label' => 'Nome',
                'rules' => 'min_length[2]|max_length[100]|required'
            ],[
                'field' => 'xp',
                'label' => 'Código XP',
                'rules' => 'min_length[2]|max_length[100]|required'
            ]
        ];

        // verifica se eh um edicao
        if ( $this->input->post( 'cod' ) ) {

            // carrega o cliente
            $cliente = $this->Cliente->clean()->key( $this->input->post( 'cod' ) )->get( true );

            // verifica se o email foi alterado
            if ( $cliente->email != $this->input->post( 'email' ) ) {

                $rules[] = [
                    'field' => 'email',
                    'label' => 'E-mail',
                    'rules' => 'is_unique[Clientes.Email]|valid_email|required'
                ];

            } else {

                // nao verifica se eh unico
                $rules[] = [
                    'field' => 'email',
                    'label' => 'E-mail',
                    'rules' => 'valid_email|required'
                ];
            }
            
            // verifica se foi enviado uma senha
            if ( $this->input->post( 'novaSenha' ) ) {

                $rules[] = [
                    'field' => 'confirmaSenha',
                    'label' => 'Confirmar nova senha',
                    'rules' => 'required|min_length[6]|max_length[16]|matches[novaSenha]'
                ];

                $rules[] = [
                    'field' => 'novaSenha',
                    'label' => 'Nova senha',
                    'rules' => 'required|min_length[6]|max_length[16]'
                ];
            }
        } else {

            // adiciona a regra de unico
            $rules[] = [
                'field' => 'email',
                'label' => 'E-mail',
                'rules' => 'is_unique[Clientes.Email]|valid_email|required'
            ];
            $rules[] = [
                'field' => 'senha',
                'label' => 'Senha',
                'rules' => 'matches[confirma]|min_length[6]|max_length[18]|required'
            ];
            $rules[] = [
                'field' => 'confirma',
                'label' => 'Confirmação de senha',
                'rules' => 'matches[senha]|min_length[6]|max_length[18]|required'
            ];
        }

        // valida o formulário
        $this->form_validation->set_rules( $rules );
        return $this->form_validation->run();
    }

   /**
    * index
    *
    * mostra o grid de funcionarios
    *
    */
	public function index() {

        // verifica o acesso
        // if ( !$this->checkAccess( [ 'canRead' ] ) ) return;

        // carrega a model de funcionarios
        $this->load->model( [ 'Funcionarios/Funcionario', 'Segmentos/Segmento' ] );

        // carrega os categorias
        $funcionarios = $this->Funcionario->filtro();
        $segmentos = $this->Segmento->filtro();

        // faz a paginacao
		$this->Cliente->grid()

		// seta os filtros
		->order()
        ->addFilter( 'CodFuncionario', 'select', $funcionarios, 'c' )
        ->addFilter( 'CodSegmento', 'select', $segmentos, 'f' )
        ->filter()
		->paginate( 0, 20 )

		// seta as funcoes nas colunas
		->onApply( 'Ações', function( $row, $key ) {
			echo '<a href="'.site_url( 'clientes/alterar/'.$row['Código'] ).'" class="margin btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></a>';
			echo '<a href="'.site_url( 'clientes/excluir/'.$row['Código'] ).'" class="margin btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>';            
		})
		->onApply( 'AtributoSegmento', function( $row, $key ) {
            if( $row[ $key ] == '' ) echo '';
            elseif( $row[ $key ] == 'T' ) echo 'Trader';
            elseif( $row[ $key ] == 'I' ) echo 'Inativo';
            else echo '';
		})

		// renderiza o grid
		->render( site_url( 'clientes/index' ) );
        $this->view->set( 'entity', 'Clientes' );        

        // seta a url para adiciona
        $this->view->set( 'add_url', site_url( 'clientes/adicionar' ) );

		// seta o titulo da pagina
		$this->view->setTitle( 'Clientes - listagem' )->render( 'grid' );
    }
    
   /**
    * index
    *
    * mostra o grid de funcionarios
    *
    */
	public function index_func() {

        // verifica o acesso
        // if ( !$this->checkAccess( [ 'canRead' ] ) ) return;
        
        // Pega o id do funcionario logado
        $user = $this->guard->currentUser();

        // faz a paginacao
		$this->Cliente->grid_func( $user->CodFuncionario )

		// seta os filtros
		->order()
        ->addFilter( 'Nome', 'text' )
        ->filter()
		->paginate( 0, 20 )

		// seta as funcoes nas colunas
		->onApply( 'Ações', function( $row, $key ) {
			echo '<a href="'.site_url( 'clientes/alterar_func/'.$row['Código'] ).'" class="margin btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></a>';
			echo '<a href="'.site_url( 'mensagens/index/'.$row['Código'] ).'" class="margin btn btn-xs btn-default"><span class="glyphicon glyphicon-envelope"></span></a>';
			// echo '<a href="'.site_url( 'clientes/excluir/'.$row['Código'] ).'" class="margin btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>';            
		})
		->onApply( 'AtributoSegmento', function( $row, $key ) {
            if( $row[ $key ] == '' ) echo '';
            elseif( $row[ $key ] == 'T' ) echo 'Trader';
            elseif( $row[ $key ] == 'I' ) echo 'Inativo';
            else echo '';
		})

		// renderiza o grid
		->render( site_url( 'clientes/index' ) );
        $this->view->set( 'entity', 'Meus Clientes' );

		// seta o titulo da pagina
		$this->view->setTitle( 'Clientes - listagem' )->render( 'grid' );
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

        // carrega a model de grupos
        $this->load->model( 'Segmentos/Segmento' );
        $segmentos = $this->Segmento->clean()->get();
        $this->view->set( 'segmentos', $segmentos );

        // carrega a model de funcionarios
        $this->load->model( 'Tags/Tag' );
        $tags = $this->Tag->clean()->get();
        $this->view->set( 'tags', $tags );

        // carrega a view de adicionar
        $this->view->setTitle( 'Trader - Adicionar cliente' )->render( 'forms/cliente' );
    }

    /**
    * alterar
    *
    * mostra o formulario de edicao
    *
    */
    public function alterar_func( $key ) {

        // verifica o acesso
        // if ( !$this->checkAccess( [ 'canUpdate' ] ) ) return;

        // carrega o cargo
        $cliente = $this->Cliente->clean()->key( $key )->get( true );

        // carrega a model de grupos
        $this->load->model( 'Segmentos/Segmento' );
        $segmentos = $this->Segmento->clean()->get();
        $this->view->set( 'segmentos', $segmentos );

        // carrega a model de funcionarios
        $this->load->model( 'Funcionarios/Funcionario' );
        $funcionario = $this->Funcionario->clean()->key( $cliente->funcionario )->get(true);
        $funcionarios = $this->Funcionario->clean()->key( $funcionario->CodFuncionario )->get();
        $this->view->set( 'assessores', $funcionarios );
        $this->view->set( 'assessor', $funcionario );

        // carrega a model de funcionarios
        $this->load->model( 'Tags/Tag' );
        $tags = $this->Tag->clean()->get();
        $this->view->set( 'tags', $tags );
        
        // verifica se o mesmo existe
        if ( !$cliente ) {
            redirect( 'clientes/index' );
            exit();
        }
        $cliente->set( 'senha', '' );

        // salva na view
        $this->view->set( 'cliente', $cliente );
        $this->view->set( 'edit_func', true );

        // carrega a view de adicionar
        $this->view->setTitle( 'Trader - Adicionar cliente' )->render( 'forms/cliente' );
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
        $cliente = $this->Cliente->clean()->key( $key )->get( true );

        // carrega a model de grupos
        $this->load->model( 'Segmentos/Segmento' );
        $segmentos = $this->Segmento->clean()->get();
        $this->view->set( 'segmentos', $segmentos );

        // carrega a model de funcionarios
        $this->load->model( 'Funcionarios/Funcionario' );
        $funcionario = $this->Funcionario->clean()->key( $cliente->funcionario )->get( true );
        $funcionarios = $this->Funcionario->clean()->segmento( $funcionario->segmento )->get();
        $this->view->set( 'assessores', $funcionarios );
        $this->view->set( 'assessor', $funcionario );

        // carrega a model de funcionarios
        $this->load->model( 'Tags/Tag' );
        $tags = $this->Tag->clean()->get();
        $this->view->set( 'tags', $tags );
        
        // verifica se o mesmo existe
        if ( !$cliente ) {
            redirect( 'clientes/index' );
            exit();
        }
        $cliente->set( 'senha', '' );

        // salva na view
        $this->view->set( 'cliente', $cliente );

        // carrega a view de adicionar
        $this->view->setTitle( 'Trader - Adicionar cliente' )->render( 'forms/cliente' );
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

        // pega o funcionario
        $cliente = $this->Cliente->clean()->key( $key )->get( true );

        // exclui o funcionario
        $cliente->delete();

        // carrega a index
        $this->index();
    }

    /**
    * deleteAllClientesTags
    *
    * remove todos os dados da tabela
    *
    */
    private function deleteAllClientesTags( $CodCliente ) {
        
        // busca as tags do cliente
        $tagsCliente = $this->TagCliente->clean()->cliente( $CodCliente )->get();
        
        // verifica se o cliente tem tag
        if( $tagsCliente ) {

            // percorre todas as tags
            foreach ( $tagsCliente as $tag ) {
                $tag->delete();
            }
        }
    }
    
   /**
    * _salvarPermissao
    *
    * salva a permissao
    *
    */
    private function _salvarTagCliente( $CodCliente, $CodTag ) {

        $tagCliente = $this->TagCliente->getEntity();
        $tagCliente->set( 'cliente', $CodCliente )
                   ->set( 'tag', $CodTag );

        // salva no banco
        return $tagCliente->save();
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
        
        // pega as tags selecionadas
        $tagsSelected = $this->input->post('tagsCliente');

        // instancia um novo objeto funcionario
        if( $this->input->post( 'cod' ) ) {
            $cliente = $this->Cliente->clean()->key( $this->input->post( 'cod' ) )->get( true );

            // carrega a model de funcionarios
            $this->load->model( 'Funcionarios/Funcionario' );
            $funcionario = $this->Funcionario->clean()->key( $cliente->funcionario )->get( true );
            $funcionarios = $this->Funcionario->clean()->segmento( $funcionario->segmento )->get();
            $this->view->set( 'assessores', $funcionarios );
            $this->view->set( 'assessor', $funcionario );

            // deleta as tags relacionadas ao cliente
            $this->deleteAllClientesTags( $cliente->CodCliente );
        } else $cliente = $this->Cliente->getEntity();
            
        // carrega a model de grupos
        $this->load->model( 'Segmentos/Segmento' );
        $segmentos = $this->Segmento->clean()->get();
        $this->view->set( 'segmentos', $segmentos );

        // carrega a model de funcionarios
        $this->load->model( 'Tags/Tag' );
        $tags = $this->Tag->clean()->get();
        $this->view->set( 'tags', $tags );

        // seta dados cliente
        $cliente->post( 'nome' )
                ->post( 'tel' )
                ->post( 'xp' )
                ->post( 'email' )
                ->post( 'funcionario' )
                ->post( 'atributoSeg' );

        // verifica se o formulario é valido
        if ( !$this->_formularioClientes() ) {

            // seta os erros de validacao            
            $this->view->set( 'cliente', $cliente );
            $this->view->set( 'errors', validation_errors() );
            
            // carrega a view de adicionar
            $this->view->setTitle( 'Trader - Adicionar cliente' )->render( 'forms/cliente' );
            return;
        }

        // verifica se existe uma nova senha
        if ( $this->input->post( 'novaSenha') ) {
            $cliente->set( 'senha', $this->input->post( 'novaSenha' ) );
            $cliente->save( true );
        }

        // verifica se existe uma nova senha
        if ( $this->input->post( 'senha') ) {
            $cliente->post( 'senha' );
            $cliente->save( true );
        }

        // verifica se o dado foi salvo
        if ( $cliente->save() ) {

            // Verifica se o usuario selecionou alguma tag
            if( $tagsSelected ) {

                // percorre as tags selecionadas
                foreach ( $tagsSelected as $tag ) {     
                    $this->_salvarTagCliente( $cliente->CodCliente, $tag  );
                }
            }

            // redireciona 
            redirect( site_url( 'clientes/index' ) );
        }
    }
}
