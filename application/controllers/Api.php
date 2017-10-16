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
    * obter perfil
    *
    * faz o login no aplicativo
    *
    */
    public function obter_perfil() {

        // carrega a model de clientes
        $this->load->model( [ 'Funcionarios/Funcionario', 'Segmentos/Segmento' ] );

        // verifica se o usuario ta logado
        $this->request->logged();

        // seta o cliente
        $cliente = $this->request->cliente;

        // pega o funcionario do cliente
        $funcionario = $this->Funcionario->clean()->key( $cliente->funcionario )->get( true );
        if( !$funcionario ) return $this->response->reject( 'Não foi possivel no momento.' );

        // pega o segmento
        $segmento = $this->Funcionario->clean()->key( $funcionario->segmento )->get( true );
        if( !$segmento ) return $this->response->reject( 'Não foi possivel no momento.' );
        
        // mapeia a resposta
        $cliente = [
            'nome'              => $cliente->nome,
            'tel'               => $cliente->tel,
            'email'             => $cliente->email,
            'segmento'          => $segmento->nome,
            'foto'              => $cliente->avatar()
        ];
        return $this->response->resolve( $cliente );

    }

    /**
    * atualizar_perfil
    *
    * atualiza o perfil do cliente
    *
    */
    public function atualizar_perfil() {

        // carrega o model
        $this->load->model( [ 'Clientes/Cliente' ] );
        
        // verifica se o usuario ta logado
        $this->request->logged();

        // seta o cliente
        $cliente = $this->request->cliente;

        // pega o email do post
        $email = $this->input->post( 'email' );

        // verifica se alterou o email
        if( $cliente->email != $email ) {

            // busca um cliente com o email informado
            $clienteVerifica = $this->Cliente->clean()->email( $email )->get( true );

            // verifica se ja existe
            if( $clienteVerifica ) return $this->response->reject( 'Já existe um cliente com o email informado.' );
            else $cliente->set( 'email', $email );
        }

        // seta o nome e o telefone
        $cliente->set( 'nome', $this->input->post( 'nome' ) )
                ->set( 'tel', $this->input->post( 'tel' ) )->save();

        // verifica se alterou a senha
        if( $this->input->post( 'novaSenha' ) ) {
            $cliente->set( 'senha', $this->input->post( 'novaSenha' ) )->save( true );
        }
        
        // verifica se alterou a senha
        if( $this->input->post( 'foto' ) ) {
            $cliente->changeAvatar( $this->input->post( 'foto' ) )->save();
        }
        $cliente = [
            'email' => $cliente->email,
            'token' => $cliente->token
        ];
        return $this->response->resolve( $cliente );
    }

   /**
    * meu_assessor
    *
    * obtem os dados do assessor
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
                'timestamp'     => strtotime( $mensagem->dataEnvio ),
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
                'timestamp'     => strtotime( $mensagem->dataEnvio ),
                'arquivo'       => isset( $mensagem->arquivo ) ? $link : '',
                'mime'          => isset( $mensagem->arquivo ) ? get_mime_by_extension( $mensagem->label ) : ''
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
            
            $msg = $mensagem;
            $dataEnvio = date( 'd/m/Y à\s H:i', strtotime( $mensagem->dataEnvio ) );
            if( $mensagem->arquivo ) $link = site_url( 'uploads/'.$mensagem->arquivo.'.'.$mensagem->extensao );
            $mensagem  = [
                    'cod'           => $mensagem->CodMensagem,
                    'texto'         => !isset( $mensagem->arquivo ) ? $mensagem->texto : $mensagem->label,
                    'visualizada'   => $mensagem->visualizada,
                    'dataEnvio'     => $dataEnvio,
                    'autor'         => $mensagem->autor,
                    'timestamp'     => strtotime( $mensagem->dataEnvio ),
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

   /**
    * add_ticket
    *
    * adiciona um novo ticket
    *
    */
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

        // verifica se o usuario ta logado
        $this->request->logged();

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

   /**
    * long_polling
    *
    * deixa o chat em tempo real
    *
    */
    public function long_polling( $timestamp ) {

        // verifica se o usuario ta logado
        $this->request->logged();

        // carrega o helpper
        $this->load->helper('file');

        // deixa o long polling não bloqueante
        session_write_close();

        // carega as models necessárias
        $this->load->model( [ 'Mensagens/Mensagem' ] );

        // variavel de controle
        $controle  = 0;
        
        // faz o loop
        while( true ) {

            // carrega as mensagens
            $mensagens = $this->Mensagem->clean()
                                        ->cliente( $this->request->cliente->CodCliente )
                                        ->newerThan( $timestamp )
                                        ->autor( 'F' )
                                        ->orderByDataNew()
                                        ->get();

            // verifica se existem novas mensagens
            if (  count( $mensagens ) > 0 ) {
                
                // faz o mapeamento do array
                $mensagens = array_map( function( $mensagem ) {
                    $msg = $mensagem;
                    $dataEnvio = date( 'd/m/Y à\s H:i', strtotime( $mensagem->dataEnvio ) );
                    if( $mensagem->arquivo ) $link = site_url( 'uploads/'.$mensagem->arquivo.'.'.$mensagem->extensao );
                    if( $msg->visualizada == 'N' ) $msg->lerMensagem();
                    return [
                        'cod'           => $mensagem->CodMensagem,
                        'texto'         => !isset( $mensagem->arquivo ) ? $mensagem->texto : $mensagem->label,
                        'visualizada'   => $mensagem->visualizada,
                        'dataEnvio'     => $dataEnvio,
                        'autor'         => $mensagem->autor,
                        'timestamp'     => strtotime( $mensagem->dataEnvio ),
                        'arquivo'       => isset( $mensagem->arquivo ) ? $link : '',
                        'mime'          => isset( $mensagem->arquivo ) ? get_mime_by_extension( $mensagem->label ) : ''
                    ];
                }, $mensagens );

                // envia as mensagens
                return $this->response->resolve( $mensagens );

            } else {

                // verifica a variavel de controle
                if ( $controle < 15 ) {

                    // incrementa e aguarda 2s
                    sleep( 2 );
                    $controle++;                
                    continue;

                } else {

                    // envia as mensagens
                    return $this->response->resolve( [ 'time' => time() ] );
                    break;
                }
            }
        }
    }

    public function upload_arquivo() {
        
        // verifica se o usuario ta logado
        $this->request->logged();

        // carrega o model
        $this->load->model( [ 'Mensagens/Mensagem' ] );
        
        // pega a instancia da mensagem
        $mensagem = $this->Mensagem->getEntity();

        // seta as propriedades
        $mensagem->set( 'cliente', $this->request->cliente->CodCliente )
                 ->set( 'funcionario', $this->request->cliente->funcionario )
                 ->set( 'visualizada', 'N' )
                 ->set( 'autor', 'C' )
                 ->set( 'dataEnvio', date( 'Y-m-d H:i:s', time() ) );
        $mensagem->colocarFoto( $this->input->post( 'imagem' ) );
        if( $mensagem->save() ) {
            
            $msg = $mensagem;
            $dataEnvio = date( 'd/m/Y à\s H:i', strtotime( $mensagem->dataEnvio ) );
            if( $mensagem->arquivo ) $link = site_url( 'uploads/'.$mensagem->arquivo.'.'.$mensagem->extensao );
            $mensagem  = [
                    'cod'           => $mensagem->CodMensagem,
                    'texto'         => !isset( $mensagem->arquivo ) ? $mensagem->texto : $mensagem->label,
                    'visualizada'   => $mensagem->visualizada,
                    'dataEnvio'     => $dataEnvio,
                    'autor'         => $mensagem->autor,
                    'timestamp'     => strtotime( $mensagem->dataEnvio ),
                    'arquivo'       => isset( $mensagem->arquivo ) ? $link : ''
            ];
            return $this->response->resolve( $mensagem );
        } else return $this->response->reject( 'Não foi possivel no momento.' );        
    }

    public function verifica_token() {
        
        // verifica se o usuario ta logado
        $this->request->logged();

        return $this->response->resolve( $this->request->cliente );
    }
    
   /**
    * obter_mensagens
    *
    * resetar a senha
    *
    */
    public function obter_propostas( $indice ) {

        // verifica se o usuario ta logado
        $this->request->logged();

        // carrega o model
        $this->load->model( [ 'PropostasClientes/PropostaCliente' ] );
        $propostas = $this->PropostaCliente->clean()->cliente( $this->request->cliente->CodCliente )->orderByDataNew()->paginate( $indice, 15, true );
        if ( count( $propostas ) == 0 ) {
            return $this->response->resolve( [] );
        }
        
        // envia as lojas
        return $this->response->resolve( $propostas );
    }
}

/* end of file */
