<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MY_Controller {

    // somente para usuários logados
    public $isFreeToEveryOne = true;
    
   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
        
        // adiciona o json ao post
        $data = json_decode(file_get_contents('php://input'), true);
        if ( $data ) $_POST = $data; 
    
        // carrega as libraries
        $this->load->library( [ 'Request', 'Response' ] );
    }

   /**
    * login
    *
    * faz o login no aplicativo
    *
    */
    public function login() {

        // carrega a model de clientes
        $this->load->model( 'Clientes/Cliente' );

        // pega o email
        $email = $this->input->post( 'email' );
        $senha = $this->input->post( 'senha' );

        // carrega o cliente com o email
        $cliente = $this->Cliente->clean()->email( $email )->get( true );
        if ( !$cliente ) return $this->response->reject( 'E-mail não cadastrado' );

        // verifica a senha
        if ( $cliente->verificarSenha( $senha ) ) {

            // gera o token
            if ( $cliente->gerarToken()->save() ) {
                $cliente = [
                    'email' => $cliente->email,
                    'token' => $cliente->token
                ];
                return $this->response->resolve( $cliente );
            } else return $this->response->reject( 'Não foi possivel logar.' );
        } else return $this->response->reject( 'A senha digitada está incorreta' );
    }
    
   /**
    * obter_mensagens
    *
    * resetar a senha
    *
    */
    public function meu_assessor() {
        
        // verifica se o usuario ta logado
        $this->request->logged();

        // carrega a model de clientes
        $this->load->model( 'Funcionarios/Funcionario' );

        // pega o funcionario do cliente
        $funcionario = $this->Funcionario->clean()->key( $this->request->cliente->funcionario )->get( true );
        if( !$funcionario ) return $this->response->reject( 'Não foi possivel no momento.' );
        $funcionario = [
            'cod'       => $funcionario->CodFuncionario,
            'nome'      => $funcionario->nome,
            'tel'       => $funcionario->tel,
            'email'     => $funcionario->email,
            'foto'      => $funcionario->avatar()
        ];
        return $this->response->resolve( $funcionario );
    }
    
   /**
    * obter_mensagens
    *
    * resetar a senha
    *
    */
    public function obter_novas_mensagens( $codigo ) {

        // verifica se o usuario ta logado
        $this->request->logged();

        // carrega o model
        $this->load->model( [ 'Mensagens/Mensagem' ] );
        $mensagens = $this->Mensagem->clean()
                                    ->cliente( $this->request->cliente->CodCliente )
                                    ->orderByDataNew()
                                    ->lastMsg( $codigo )
                                    ->get();
        if ( count( $mensagens ) == 0 ) {
            return $this->response->resolve( [] );
        }
        
        // faz o mapeamento do array
        $mensagens = array_map( function( $mensagem ) {
            $dataEnvio = date( 'd/m/Y', strtotime( $mensagem->dataEnvio ) );
            if( isset( $mensagem->arquivo ) ) $link = site_url( 'api/download/'.$mensagem->CodMensagem );
            return [
                'cod'           => $mensagem->CodMensagem,
                'texto'         => !isset( $mensagem->arquivo ) ? $mensagem->texto : $mensagem->label,
                'visualizada'   => $mensagem->visualizada,
                'dataEnvio'     => $dataEnvio,
                'autor'         => $mensagem->autor,
                'arquivo'       => isset( $mensagem->arquivo ) ? $link : ''
            ];
        }, $mensagens );
        
        // envia as lojas
        return $this->response->resolve( $mensagens );
    }

   /**
    * obter_mensagens
    *
    * resetar a senha
    *
    */
    public function obter_mensagens( $indice ) {

        $this->load->helper('file');

        // verifica se o usuario ta logado
        $this->request->logged();

        // carrega o model
        $this->load->model( [ 'Mensagens/Mensagem' ] );
        $mensagens = $this->Mensagem->clean()->cliente( $this->request->cliente->CodCliente )->orderByDataNew()->paginate( $indice, 15, true );
        if ( count( $mensagens ) == 0 ) {
            return $this->response->resolve( [] );
        }
        
        // faz o mapeamento do array
        $mensagens = array_map( function( $mensagem ) {
            $msg = $mensagem;
            $dataEnvio = date( 'd/m/Y à\s H:i', strtotime( $mensagem->dataEnvio ) );
            if( isset( $mensagem->arquivo ) ) $link = site_url( 'uploads/'.$mensagem->arquivo.'.'.$mensagem->extensao );
            if( $msg->autor != 'C' && $msg->visualizada == 'N' ) $msg->lerMensagem();
            return [
                'cod'           => $mensagem->CodMensagem,
                'texto'         => !isset( $mensagem->arquivo ) ? $mensagem->texto : $mensagem->label,
                'visualizada'   => $mensagem->visualizada,
                'dataEnvio'     => $dataEnvio,
                'autor'         => $mensagem->autor,
                'arquivo'       => isset( $mensagem->arquivo ) ? $link : '',
                'mime'          => isset( $mensagem->arquivo ) ? get_mime_by_extension( $isset( $mensagem->lebel ) ) : ''
            ];
        }, $mensagens );
        
        // envia as lojas
        return $this->response->resolve( $mensagens );
    }

    /**
    * enviar_mensagem
    *
    * envia uma mensagem
    *
    */
    public function enviar_mensagem() {
        
        // verifica se o usuario ta logado
        $this->request->logged();

        // carrega o model
        $this->load->model( [ 'Mensagens/Mensagem' ] );
        
        // pega a instancia da mensagem
        $mensagem = $this->Mensagem->getEntity();

        // seta as propriedades
        $mensagem->set( 'cliente', $this->request->cliente->CodCliente )
                 ->post( 'texto' )
                 ->set( 'funcionario', $this->request->cliente->funcionario )
                 ->set( 'visualizada', 'N' )
                 ->set( 'autor', 'C' )
                 ->set( 'dataEnvio', date( 'Y-m-d H:i:s', time() ) );
        if( $mensagem->save() ) {
            $dataEnvio = date( 'd/m/Y à\s H:i', strtotime( $mensagem->dataEnvio ) );
            $mensagem  = [
                    'cod'           => $mensagem->CodMensagem,
                    'texto'         => !isset( $mensagem->arquivo ) ? $mensagem->texto : $mensagem->label,
                    'visualizada'   => $mensagem->visualizada,
                    'dataEnvio'     => $dataEnvio,
                    'autor'         => $mensagem->autor,
                    'arquivo'       => isset( $mensagem->arquivo ) ? $link : ''
            ];
            return $this->response->resolve( $mensagem );
        } else return $this->response->reject( 'Não foi possivel no momento.' );
    }

   /**
    * download
    *
    * faz o download de um arquivo
    *
    */
    public function download( $CodMensagem ) {
        
        // verifica se o usuario ta logado
        $this->request->logged();

        // carrega o arquivo
        $arquivo = $this->Mensagem->clean()->key( $CodMensagem )->get( true );
        if ( !$arquivo ) return $this->response->reject( 'Não existe arquivo.' );

        // verifica se foi enviado pelo colaborador
        if ( $mensagem->funcionario == $this->funcionario->CodFuncionario ) {
            return $this->response->resolve( $arquivo->download() );
        } else return $this->response->reject( 'Você não tem permissão para baixar esse arquivo.' );
    }

    public function add_ticket() {
        
        // verifica se o usuario ta logado
        $this->request->logged();

        // carrega a model de clientes
        $this->load->model( 'Tickets/Ticket' );

        // pega a entidade
        $ticket = $this->Ticket->getEntity();
        
        $nome = $this->input->post( 'nome' );
        $descricao = $this->input->post( 'descricao' );
        
        // seta os atributos
        $ticket->set( 'nome', $nome )
               ->set( 'descricao', $descricao )
               ->set( 'status', 'A' )
               ->set( 'dataAbertura', date( 'Y-m-d H:i:s', time() ) )
               ->set( 'cliente', $this->request->cliente->CodCliente )
               ->set( 'funcionario', $this->request->cliente->funcionario );
        
        if( $ticket->save() ) return $this->response->resolve( $ticket->CodTicket );
        else return $this->response->reject( 'Tente mais tarde' );
    }
    
   /**
    * resetar
    *
    * resetar a senha
    *
    */
    public function obter_tickets( $indice ) {

        // verifica se o usuario ta logado
        $this->request->logged();

        // carrega o model
        $this->load->model( [ 'Tickets/Ticket' ] );
        $tickets = $this->Ticket->clean()->cliente( $this->request->cliente->CodCliente )->orderByData()->paginate( $indice, 8, true );
        if ( count( $tickets ) == 0 ) {
            return $this->response->resolve( [] );
        }
        
        
        // faz o mapeamento do array
        $tickets = array_map( function( $ticket ) {
            $dataAbertura = date( 'd/m/Y á\s H:i:s', strtotime( $ticket->dataAbertura ) );
            $dataMovimentacao = $ticket->dataMovimentacao ? date( 'd/m/Y á\s H:i:s', strtotime( $ticket->dataMovimentacao ) ) : false;

            return [
                'cod'               => $ticket->CodTicket,
                'nome'              => $ticket->nome,
                'status'            => $ticket->status,
                'dataAbertura'      => $dataAbertura,
                'dataMovimentacao'  => $dataMovimentacao,
                'descricao'         => $ticket->descricao,
                'avaliacao'         => $ticket->avaliacao
            ];
        }, $tickets );

        
        // envia as lojas
        return $this->response->resolve( $tickets );
    }
    
   /**
    * resetar
    *
    * resetar a senha
    *
    */
    public function obter_posts( $indice ) {

        // verifica se o usuario ta logado
        $this->request->logged();

        // carrega o model
        $this->load->model( [ 'Posts/Post' ] );
        $posts = $this->Post->clean()->orderByData()->paginate( $indice, 3, true );
        if ( count( $posts ) == 0 ) {
            return $this->response->resolve( [] );
        }
        
        
        // faz o mapeamento do array
        $posts = array_map( function( $post ) {
            $data = date( 'd/m/Y à\s H:i', strtotime( $post->data ) );
            return [
                'cod'           => $post->CodPost,
                'textoCurto'    => $post->textoCurto,
                'imagem'        => $post->imagem ? base_url('uploads/' .$post->imagem) : false,
                'data'          => $data,
                'titulo'        => $post->titulo,
                'click'         => $post->post ? true : false
            ];
        }, $posts );

        
        // envia as lojas
        return $this->response->resolve( $posts );
    }
    
   /**
    * resetar
    *
    * resetar a senha
    *
    */
    public function obter_post( $CodPost ) {

        // verifica se o usuario ta logado
        $this->request->logged();

        // carrega o model
        $this->load->model( [ 'Posts/Post' ] );
        $post = $this->Post->clean()->key( $CodPost )->get( true );
        if ( !$post ) {
            return $this->response->reject( 'Post não existe' );
        }
        $post = [
            'cod'   => $post->CodPost,
            'post'  => $post->post
        ];

        
        // envia as lojas
        return $this->response->resolve( $post );
    }

   /**
    * resetar
    *
    * resetar a senha
    *
    */
    public function resetar() {

        // carrega o model
        $this->load->model( [ 'Clientes/Cliente' ] );
        $user = $this->Cliente->clean()->email( $this->input->post( 'email' ) )->get( true );
        if ( !$user ) {
            return $this->response->reject( 'Email inexistente no sistema.' );
        }
        $user->set( 'tokenEmail', md5( uniqid( time() * rand() ) ) );
        $user->save();

        // verifica se o dado foi salvo
        if ( $this->enviarEmailVerificacao( $user->email, $user->tokenEmail ) ) {
            return $this->response->resolve( [ 'mensagem' => "Senha resetada com sucesso." ] );
        } else {
            return $this->response->reject( 'Não foi possivel no momento, tente novamente mais tarde.' );
        }
    }

   /**
    * enviarEmailVerificacao
    *
    * envia o email de verificacao
    *
    */
    private function enviarEmailVerificacao( $email, $token ) {

        // carrega o template
        $this->load->model( 'Templates/Template' );
        $template = $this->Template->template( 'TEMPLATE_RECOVERY_CLIENTE' )->get( true );
        
        // adiciona os parametros customizaveis
        $template->corpo = str_replace( '%_TOKEN_%', site_url( 'recovery/recovery_cliente/'.$token ), $template->corpo );

        // configuracoes do email
        $config = [
            'mailtype' => 'html',
            'charset'  => 'iso-8859-1'
        ];

        // carrega a library
        $this->load->library( 'email', $config );

        // seta os emails
        $this->email->from( 'vihh.fernando@gmail.com', "Suporte" )
        ->to( $email )

        // seta o corpo
        ->subject( 'Recuperacao de Senha Equipe Trader' )
        ->message( $template->corpo )
        ->set_mailtype( 'html' );
        
        // envia o email
        if( $this->email->send() ) {
            return true;
        } else {
            return false;
        }
    }

    public function autenticada() {

        // verifica se o usuario esta logado
        $this->request->logged();

        // mensagem de teste
        $this->response->resolve( $this->request->cliente->nome );
    }
}

/* end of file */
