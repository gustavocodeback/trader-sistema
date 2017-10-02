<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Funcionarios extends MY_Controller {

    // indica se o controller é publico
	protected $loggedUsersOnly = false;

    // seta a rotina
    protected $routine = 'Funcionarios';

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
        
        // carrega o finder
        $this->load->model( 'Funcionarios/Funcionario' );
        
        // chama o modulo
        $this->view->module( 'cover' )->set( 'navbar-index', 1 );
    }

   /**
    * _formularioFuncionarios
    *
    * valida o formulario de funcionarios
    *
    */
    private function _formularioFuncionarios() {

        // verifica se eh um edicao
        if ( $this->input->post( 'cod' ) ) {

<<<<<<< HEAD
            // carrega o cliente
=======
            // carrega o funcionario
>>>>>>> 6cfe9b2c6f4a521a7558a6d686e35eb035ba8b37
            $funcionario = $this->Funcionario->clean()->key( $this->input->post( 'cod' ) )->get( true );

            // verifica se o email foi alterado
            if ( $funcionario->email != $this->input->post( 'email' ) ) {

                $rules[] = [
                    'field' => 'email',
                    'label' => 'E-mail',
                    'rules' => 'is_unique[Funcionarios.Email]|valid_email|required'
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
                'rules' => 'is_unique[Funcionarios.Email]|valid_email|required'
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

        $rules[] = [
                'field' => 'nome',
                'label' => 'Nome',
                'rules' => 'min_length[2]|max_length[100]|required'
        ];
        $rules[] = [
                'field' => 'gid',
                'label' => 'Grupo',
                'rules' => 'required'
        ];

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
<<<<<<< HEAD
        
=======

>>>>>>> 6cfe9b2c6f4a521a7558a6d686e35eb035ba8b37
        // carrega a model de grupos
        $this->load->model( 'Segmentos/Segmento' );
        $segmentos = $this->Segmento->filtro();

        // faz a paginacao
		$this->Funcionario->clean()->grid()

		// seta os filtros
		->order()
        ->addFilter( 'Nome', 'text' )
        ->addFilter( 'CodSegmento', 'select', $segmentos, 'f' )
        ->filter()
		->paginate( 0, 20 )

		// seta as funcoes nas colunas
		->onApply( 'Ações', function( $row, $key ) {
			echo '<a href="'.site_url( 'funcionarios/alterar/'.$row['Código'] ).'" class="margin btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></a>';
			echo '<a href="'.site_url( 'funcionarios/excluir/'.$row['Código'] ).'" class="margin btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>';            
		})

		// renderiza o grid
		->render( site_url( 'funcionarios/index' ) );
		
        // seta a url para adiciona
        $this->view->set( 'add_url', site_url( 'funcionarios/adicionar' ) );
        
        // seta o titulo
        $this->view->set( 'entity', 'Funcionários' );

		// seta o titulo da pagina
		$this->view->setTitle( 'Funcionarios - listagem' )->render( 'grid' );
    }

<<<<<<< HEAD
    /**
    * obter_funcionarios_segmento
    *
    * obtem os funcionarios do segmento
    *
    */
=======
>>>>>>> 6cfe9b2c6f4a521a7558a6d686e35eb035ba8b37
    public function obter_funcionarios_segmento( $CodSegmento ) {
        $funcionarios = $this->Funcionario->clean()->segmento( $CodSegmento )->get();

        if ( count( $funcionarios ) == 0 ) {
            echo json_encode( [] );
            return;
        }

        // faz o mapeamento das cidades
        $funcionarios = array_map( function( $funcionario ) {
            return  [ 
                        'value' => $funcionario->CodFuncionario, 
                        'label' => $funcionario->nome
                    ];
        }, $funcionarios );
        
        // volta o json
        echo json_encode( $funcionarios );
        return;
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
        $this->load->model( 'Grupos/Grupo' );
        $grupos = $this->Grupo->clean()->get();
        $this->view->set( 'grupos', $grupos );

        // carrega a model de grupos
        $this->load->model( 'Segmentos/Segmento' );
        $segmentos = $this->Segmento->clean()->get();
        $this->view->set( 'segmentos', $segmentos );

        // carrega a view de adicionar
        $this->view->setTitle( 'Conta Ágil - Adicionar funcionario' )->render( 'forms/funcionario' );
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
        $funcionario = $this->Funcionario->clean()->key( $key )->get( true );

        // carrega a model de grupos
        $this->load->model( 'Grupos/Grupo' );
        $grupos = $this->Grupo->clean()->get();
        $this->view->set( 'grupos', $grupos );

        // carrega a model de grupos
        $this->load->model( 'Segmentos/Segmento' );
        $segmentos = $this->Segmento->clean()->get();
        $this->view->set( 'segmentos', $segmentos );
        
        // verifica se o mesmo existe
        if ( !$funcionario ) {
            redirect( 'funcionarios/index' );
            exit();
        }

        // salva na view
        $this->view->set( 'funcionario', $funcionario );

        // carrega a view de adicionar
        $this->view->setTitle( 'Conta Ágil - Adicionar funcionario' )->render( 'forms/funcionario' );
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
        $funcionario = $this->Funcionario->clean()->key( $key )->get( true );

        // exclui o funcionario
        $funcionario->delete();

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

        // instancia um novo objeto funcionario

        if( $this->input->post( 'cod' ) ) $funcionario = $this->Funcionario->clean()->key( $this->input->post( 'cod' ) )->get( true );
        else $funcionario = $this->Funcionario->getEntity();

        $funcionario->post( 'nome' )
                    ->post( 'email' )
                    ->post( 'gid' )
                    ->post( 'segmento' );
        
        // carrega a model de grupos
        $this->load->model( 'Grupos/Grupo' );
        $grupos = $this->Grupo->clean()->get();
        $this->view->set( 'grupos', $grupos );

        // carrega a model de grupos
        $this->load->model( 'Segmentos/Segmento' );
        $segmentos = $this->Segmento->clean()->get();
        $this->view->set( 'segmentos', $segmentos );

        // verifica se o formulario é valido
        if ( !$this->_formularioFuncionarios() ) {

            // seta os erros de validacao            
            $this->view->set( 'funcionario', $funcionario );
            $this->view->set( 'errors', validation_errors() );
            
            // carrega a view de adicionar
            $this->view->setTitle( 'Conta Ágil - Adicionar funcionario' )->render( 'forms/funcionario' );
            return;
        }

        // verifica se existe uma nova senha
        if ( $this->input->post( 'novaSenha') ) {
            $funcionario->set( 'senha', $this->input->post( 'novaSenha' ) );
            $funcionario->save( true );
        }

        // verifica se existe uma nova senha
        if ( $this->input->post( 'senha') ) {
            $funcionario->post( 'senha' );
            $funcionario->save( true );
        }

        // verifica se o dado foi salvo
        if ( $funcionario->save() ) {
            redirect( site_url( 'funcionarios/index' ) );
        }
    }
}
