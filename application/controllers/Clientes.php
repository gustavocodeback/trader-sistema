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
        if ( !$this->checkAccess( [ 'canRead' ] ) ) return;

        // carrega a model de funcionarios
        $this->load->model( [ 'Funcionarios/Funcionario', 'Segmentos/Segmento' ] );

        // carrega os categorias
        $funcionarios = $this->Funcionario->filtro();
        $segmentos = $this->Segmento->filtro();

        // faz a paginacao
		$this->Cliente->clean()->grid()

		// seta os filtros
		->order()
        ->addFilter( 'Email', 'text', false, 'c' )        
        ->addFilter( 'CodFuncionario', 'select', $funcionarios, 'c' )
        ->addFilter( 'CodSegmento', 'select', $segmentos, 'f' )
        ->filter()
		->paginate( 0, 20 )

		// seta as funcoes nas colunas
		->onApply( 'Ações', function( $row, $key ) {
			if ( $this->checkAccess( [ 'canUpdate' ], false ) ) echo '<a href="'.site_url( 'clientes/alterar/'.$row['Código'] ).'" class="margin btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></a>';
			if ( $this->checkAccess( [ 'canDelete' ], false ) ) echo '<a href="'.site_url( 'clientes/excluir/'.$row['Código'] ).'" class="margin btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>';            
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
        if ( $this->checkAccess( [ 'canCreate' ], false ) ) {
            $this->view->set( 'add_url', site_url( 'clientes/adicionar' ) );
            $this->view->set( 'import_url', site_url( 'clientes/importar_planilha' ) );
        }

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
        if ( !$this->checkAccess( [ 'canCreate' ] ) ) return;

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
    public function alterar( $key ) {

        // verifica o acesso
        if ( !$this->checkAccess( [ 'canUpdate' ] ) ) return;

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
        if ( !$this->checkAccess( [ 'canDelete' ] ) ) return;

        // pega o funcionario
        $cliente = $this->Cliente->clean()->key( $key )->get( true );
        if ( !$cliente ) return $this->close();

        // exclui o funcionario
        $cliente->delete();

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
        if ( $this->input->post( 'cod' ) )
             if ( !$this->checkAccess( [ 'canUpdate' ] ) ) return;
        else
             if ( !$this->checkAccess( [ 'canCreate' ] ) ) return;

        // instancia um novo objeto funcionario
        if( $this->input->post( 'cod' ) ) {
            $cliente = $this->Cliente->clean()->key( $this->input->post( 'cod' ) )->get( true );

            // carrega a model de funcionarios
            $this->load->model( 'Funcionarios/Funcionario' );
            $funcionario = $this->Funcionario->clean()->key( $cliente->funcionario )->get( true );
            $funcionarios = $this->Funcionario->clean()->segmento( $funcionario->segmento )->get();
            $this->view->set( 'assessores', $funcionarios );
            $this->view->set( 'assessor', $funcionario );

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
                ->post( 'tag' )
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

            // envia a mensagem para o cliente
            $this->enviar_mensagem( $cliente );

            // redireciona 
            redirect( site_url( 'clientes/index' ) );
        }
    }

    /**
    * enviar_mensagem
    *
    * envia uma mensagem
    *
    */
    public function enviar_mensagem( $cliente ) {
        
        // carrega o model de clientes
        $this->load->model( [ 'Mensagens/Mensagem' ] );
        
        // gera o texto que vai ser enviado para o cliente
        $text = "Bem vindo(a), ".$cliente->nome." eu sou o seu assessor, sempre que precisar falar comigo estarei a disposição aqui no chat!";
        
        // pega a instancia da mensagem
        $mensagem = $this->Mensagem->getEntity();

        // seta as propriedades
        $mensagem->set( 'cliente', $cliente->CodCliente )
                 ->set( 'texto', $text )
                 ->set( 'funcionario', $cliente->funcionario )
                 ->set( 'visualizada', 'N' )
                 ->set( 'autor', 'C' )
                 ->set( 'dataEnvio', date( 'Y-m-d H:i:s', time() ) );
        $mensagem->save();
    }
    
   /**
    * verificaEntidade
    *
    * verifica se um entidade existe no banco
    *
    */
    public function verificaEntidade( $model, $method, $dado, $nome, $planilha, $linha, $attr, $status ) {

        // carrega o finder de logs
        $this->load->model( 'Logs/Log' );

        // verifica se nao esta vazio
        if ( in_cell( $dado ) ) {

            // carrega o finder
            $this->load->model( $model );

            // pega a entidade
            if ( $entidade = $this->$nome->clean()->$method( $dado )->get( true ) ) {
                return $entidade->$attr;
            } else {

                // grava o log
                $log = $this->Log->getEntity();
                $log->set( 'entidade', $planilha )
                    ->set( 'funcionario', $this->guard->currentUser()->CodFuncionario )
                    ->set( 'mensagem', 'O campo '.$nome.' com valor '.$dado.' nao esta gravado no banco - linha '.$linha )
                    ->set( 'status', $status )
                    ->set( 'data', date( 'Y-m-d H:i:s', time() ) )
                    ->set( 'acao', 'importação de planilha de Clientes' )
                    ->save();

                // retorna falso
                return null;
            }
        } else {

            // grava o log
            $log = $this->Log->getEntity();
            $log->set( 'entidade', $planilha )
                ->set( 'funcionario', $this->guard->currentUser()->CodFuncionario )
                ->set( 'mensagem', 'Nenhum '.$nome.' encontrado - linha '.$linha )
                ->set( 'status', $status )
                ->set( 'data', date( 'Y-m-d H:i:s', time() ) )
                ->set( 'acao', 'importação de planilha de Clientes' )
                ->save();

            // retorna falso
            return null;
        }
    }
    
   /**
    * importar_linha
    *
    * importa a linha
    *
    */
    public function importar_linha( $linha, $num ) {
        
        // percorre todos os campos
        foreach( $linha as $chave => $coluna ) {
            $linha[$chave] = in_cell( $linha[$chave] ) ? $linha[$chave] : null;
        }

        // pega as entidades relacionaveis
        $linha['CodFuncionario'] = $this->verificaEntidade( 'Funcionarios/Funcionario', 'email', $linha['FUNCIONARIO'], 'Funcionario', 'Clientes', $num, 'CodFuncionario', 'I' );

        // verifica se existe os campos
        if ( !in_cell( $linha['CodFuncionario'] ) ||
             !in_cell( $linha['EMAIL'] ) || 
             !in_cell( $linha['CODXP'] ) || 
             !in_cell( $linha['TELEFONE'] ) ||
             !in_cell( $linha['NOME'] ) ) {
            
            if ( !in_cell( $linha['EMAIL'] ) ) $erro = 'EMAIL';
            if ( !in_cell( $linha['CODXP'] ) ) {
                if( $erro ) $erro .= ', CODXP';
                else $erro = 'CODXP';
            }
            if ( !in_cell( $linha['TELEFONE'] ) ) {
                if( $erro ) $erro .= ', TELEFONE';
                else $erro = 'TELEFONE';
            }
            if ( !in_cell( $linha['NOME'] ) ) {
                if( $erro ) $erro .= ', NOME';
                else $erro = 'NOME';
            }
            if ( !in_cell( $linha['CodFuncionario'] ) ) {
                if( $erro ) $erro .= ', FUNCIONARIO';
                else $erro = 'FUNCIONARIO';
            }

            // grava o log
            $log = $this->Log->getEntity();
            $log->set( 'entidade', 'Clientes' )
                ->set( 'funcionario', $this->guard->currentUser()->CodFuncionario )
                ->set( 'mensagem', 'Não foi possivel inserir o cliente pois nenhum '. $erro .' foi informado - linha '.$num  )
                ->set( 'status', 'B' )
                ->set( 'data', date( 'Y-m-d H:i:s', time() ) )
                ->set( 'acao', 'importação de planilha de Clientes' )
                ->save();

        } else {

            // tenta carregar a loja pelo nome
            $cliente = $this->Cliente->clean()->codXp( $linha['CODXP'] )->get( true );

            // verifica se carregou
            if ( !$cliente ) {
                $cliente = $this->Cliente->getEntity();
                $cliente->set( 'xp', $linha['CODXP'] );
            }

            // preenche os dados
            
            $cliente->set( 'nome', $linha['NOME'] )
                    ->set( 'tel', $linha['TELEFONE'] )
                    ->set( 'funcionario', $linha['CodFuncionario'] )
                    ->set( 'email', $linha['EMAIL'] );

            if ( !in_cell( $linha['ATRIBUTO'] ) ) $cliente->set( 'atributoSeg', '' );
            elseif ( $linha['ATRIBUTO'] == 'TRADER' ) $cliente->set( 'atributoSeg', 'T' );
            elseif ( $linha['ATRIBUTO'] == 'INATIVO' ) $cliente->set( 'atributoSeg', 'I' );
            else $cliente->set( 'atributoSeg', '' );
            
            // tenta salvar a loja
            if ( $cliente->save() ) {

                // grava o log
                $log = $this->Log->getEntity();
                $log->set( 'entidade', 'Clientes' )
                    ->set( 'funcionario', $this->guard->currentUser()->CodFuncionario )
                    ->set( 'mensagem', 'Cliente criado com sucesso - '.$num  )
                    ->set( 'status', 'S' )
                    ->set( 'data', date( 'Y-m-d H:i:s', time() ) )
                    ->set( 'acao', 'importação de planilha de Clientes' )
                    ->save();

            } else {

                // grava o log
                $log = $this->Log->getEntity();
                $log->set( 'entidade', 'Clientes' )
                    ->set( 'funcionario', $this->guard->currentUser()->CodFuncionario )
                    ->set( 'mensagem', 'Não foi possivel inserir o cliente - linha '.$num )
                    ->set( 'status', 'B' )
                    ->set( 'data', date( 'Y-m-d H:i:s', time() ) )
                    ->set( 'acao', 'importação de planilha de Clientes' )
                    ->save();
            }
        }
    }
    
   /**
    * importar_planilha
    *
    * importa os dados de uma planilha
    *
    */
    public function importar_planilha() {

        // importa a planilha
        $this->load->library( 'Planilhas' );

        // faz o upload da planilha
        $planilha = $this->planilhas->upload();

        // tenta fazer o upload
        if ( !$planilha ) {

            // seta os erros
            $this->view->set( 'errors', $this->planilhas->errors );
        } else {
            $planilha->apply( function( $linha, $num ) {
                $this->importar_linha( $linha, $num );
            });
            $planilha->excluir();
        }

        // redireciona 
        redirect( site_url( 'clientes/index' ) );
    }
}
