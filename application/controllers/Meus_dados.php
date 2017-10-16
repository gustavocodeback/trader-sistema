<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Meus_dados extends MY_Controller {

    // indica se o controller é publico
	protected $loggedUsersOnly = true;

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
        
        // carrega o finder
        $this->load->model( [ 'Funcionarios/Funcionario', 'Grupos/Grupo' ] );
        
        // carrega a librarie de fotos
		$this->load->library( 'Picture' );

        // pega os dados do usurio
        
        $user = $this->guard->currentUser();
        $this->view->set( 'user', $user );
        
        // chama o modulo
        $this->view->module( 'navbar' )->module( 'aside' )->module( 'footer' );
    }

   /**
    * __validarFormulario
    *
    * valida o formulario
    *
    */
    private function __validarFormulario() {

        // seta as regras
        $rules = [
            [
                'field' => 'email',
                'label' => 'E-mail',
                'rules' => 'valid_email|required'
            ]
        ];

        // verifica se existe um nome
        if( $this->input->post( 'nome' ) ) {
            $rules[] =  [
                'field' => 'nome',
                'label' => 'Nome',
                'rules' => 'required|trim'
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
                'field' => 'senhaAtual',
                'label' => 'Senha atual',
                'rules' => 'required|min_length[6]|max_length[16]'
            ];

            $rules[] = [
                'field' => 'novaSenha',
                'label' => 'Nova senha',
                'rules' => 'required|min_length[6]|max_length[16]'
            ];
        }

        // valida o formulário
        $this->form_validation->set_rules( $rules );
        return $this->form_validation->run();
    }

   /**
    * meus_dados
    *
    * dados do usuario
    *
    */
    public function index() {

        // carrega a view
        $this->view->setTitle( 'Meus Dados' )->render( 'forms/meus_dados' );
    }

   /**
    * salvar_meus_dados
    *
    * salva os dados editados
    *
    */
    public function salvar_meus_dados() {

        // faz o upload da imagem
        $file_name = $this->picture->upload( 'foto' );

        // valida o formulario
        if ( !$this->__validarFormulario() ) {

            // seta os erros
            $this->view->set( 'errors', validation_errors() );

            // carrega a view de adicionar
            return $this->view->render( 'forms/meus_dados' ); 
        }

        // pega os dados do usuario
        $usuario = $this->Funcionario->clean()->key( $this->input->post('cod') )->get( true );
          
        // verifica se existe uma foto
        if ( $file_name ) {

            // seta a foto
            if ( $usuario->foto ) $this->picture->delete( $usuario->foto );
            $usuario->set( 'foto', $file_name );
            $usuario->save();
        }
        
        // salva o nome do colaborador
        $usuario->post( 'nome' )->post( 'email' )->post( 'tel' );

        // verifica se existe uma nova senha
        if ( $this->input->post( 'novaSenha') ) {

            if( !$usuario->verificarSenha( $this->input->post( 'senhaAtual' ) ) ) {

                // seta os erros
                $this->view->set( 'errors', 'A senha atual informada não está correta.' );

                
                // carrega a view de adicionar
                return $this->view->render( 'forms/meus_dados' ); 
            } else {
                $usuario->set( 'senha',$this->input->post( 'novaSenha' ) );
                $usuario->save( true );
            }
        }
        $usuario->save();

        // redireciona
        return $this->index();
    }
}

/* end of file */
