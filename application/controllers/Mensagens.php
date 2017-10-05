<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mensagens extends MY_Controller {

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
        $this->load->model( [ 'Clientes/Cliente', 'Funcionarios/Funcionario', 'Mensagens/Mensagem' ] );

        // chama o modulo
        $this->view->module( 'navbar' )->module( 'aside' );
    }

   /**
    * carregarEntidades
    *
    * carrega as entidades relacionadas a esse evento
    *
    */
    private function carregarEntidades( $CodCliente, $CodFuncionario ) {

        // pega o evento
        $cliente = $this->Cliente->clean()->key( $CodCliente )->get( true );
        if ( !$cliente ) return false;

        // verifica se o colaborador atual eh o mesmo que criou a solicitacao
        if ( $cliente->funcionario != $CodFuncionario ) return false;   

        // seta na view
        $this->view->set( 'cliente', $cliente );

        // retorna true por padrao
        return true;
    }

   /**
    * index
    *
    * mostra o grid de cargos
    *
    */
	public function index( $CodCliente ) {        

        // Pega o id do funcionario logado
        $user = $this->guard->currentUser();
        $this->view->set( 'funcionario', $user );

        // checa o cliente
        if ( !$this->carregarEntidades( $CodCliente, $user->CodFuncionario ) ) return $this->close(); 
        
        // seta as mensagens
        $mensagens = $this->Mensagem->clean()->cliente( $CodCliente )->orderByData()->get();
        $mensagens = $mensagens ? $mensagens : [];
        $this->view->set( 'mensagens', $mensagens );
        
        // renderiza a view
        $this->view->setTitle( 'Mensagem' )->render( 'mensagens' );
    }

   /**
    * enviar_mensagem
    *
    * envia uma mensagem
    *
    */
    public function enviar_mensagem() {
        
        // pega o usuario logado
        $user = $this->guard->currentUser();
        $this->view->item( 'funcionario', $user );
        
        // pega a instancia da mensagem
        $mensagem = $this->Mensagem->getEntity();

        // seta as propriedades
        $mensagem->post( 'cliente' )
                 ->post( 'texto' )
                 ->set( 'funcionario', $user->CodFuncionario )
                 ->set( 'visualizada', 'N' )
                 ->set( 'autor', 'F' )
                 ->set( 'dataEnvio', date( 'Y-m-d H:i:s', time() ) );
        $mensagem->save();

        // recarrega a index
        redirect( site_url( 'mensagens/index/'.$this->input->post( 'cliente' ) ) );
    }

    
   /**
    * enviarEmailEvento
    *
    * envia o email de notificacao de evento
    *
    */
    private function enviarEmailEvento( $cliente, $evento ) {

        // carrega o template
        $this->load->finder( 'EmailsFinder' );
        $template = $this->EmailsFinder->clean()->template( 'TEMPLATE_NEWS' )->get( true );
        
        // adiciona os parametros customizaveis
        $template->corpo = str_replace( '%_EVENTO_%', $evento, $template->corpo );
        $template->corpo = str_replace( '%_CLIENTE_%', $cliente->razao, $template->corpo );

        // seta o email que esta enviando
        $emailEnvio   = $this->settings->item( 'EMAIL_SUPORTE' );
        $usuarioEnvio = $this->settings->item( 'DESTINATARIO_EMAIL' );

        // configuracoes do email
        $config = [
            'mailtype' => 'html'
        ];

        // carrega a library
        $this->load->library( 'email', $config );

        // seta os emails
        $this->email->from( $emailEnvio, $usuarioEnvio )
        ->to( $cliente->emailCobranca )

        // seta o corpo
        ->subject( 'Notificação do Evento' )
        ->message( $template->corpo )
        ->set_mailtype( 'html' );
        
        // envia o email
        $this->email->send();
    }

   /**
    * download
    *
    * faz o download de um arquivo
    *
    */
    public function download( $CodMensagem ) {

        // carrega o arquivo
        $arquivo = $this->Mensagem->clean()->key( $CodMensagem )->get( true );
        if ( !$arquivo ) return;

        // verifica se foi enviado pelo colaborador
        if ( $mensagem->funcionario == $this->funcionario->CodFuncionario ) {
            $arquivo->download();
        } else echo 'Você não tem permissão para baixar esse arquivo.';
    }

   /**
    * remover_arquivo
    *
    * remove um arquivo por id
    *
    */
    public function remover_arquivo( $CodArquivo ) {

        // carrega o arquivo
        $arquivo = $this->ArquivosFinder->key( $CodArquivo )->get( true );
        if ( !$arquivo ) {
            echo json_encode( [ 'error' => 'Arquivo inexistente' ] );
            return;
        }

        // verifica se o arquivo possui uma mensagem
        if ( $arquivo->mensagem ) {
            echo json_encode( [ 'error' => 'Arquivo anexado em uma mensagem' ] );
            return;
        }

        // exclui o arquivo
        if ( $arquivo->apagar() ) {

            // deleta o registro
            $arquivo->delete();

            // exibe a mensagem de sucesso
            echo json_encode( [ 'success' => 'arquivo excluido com sucesso' ] );
        } else echo json_encode( [ 'error' => 'Erro ao apagar o arquivo' ] );

        // return por padrao
        return;
    }

   /**
    * salvar_arquivo
    *
    * salva um arquivo no sistema
    *
    */
    public function salvar_arquivo() {

        // pega o usuario logado
        $user = $this->guard->currentUser();
        $this->view->item( 'funcionario', $user );

        // pega o codigo do cliente
        $cliente = $this->input->post( 'CodCliente' );

        // configuracao para o upload
        $config['upload_path'] = './uploads/';
        $config['file_name'] = md5( uniqid( rand() * time() ) );
        $config['allowed_types'] = 'pdf|docx|doc|odt|odf|png|jpg|jpeg|zip|html|xml|xls|xlsx|pptx|ppt|ofx|txt';
        
        // pega a instancia da mensagem
        $mensagem = $this->Mensagem->getEntity();

        // carrega a library de upload
        $this->load->library('upload', $config);

        // tenta fazer o upload
        if ( ! $this->upload->do_upload( 'input-anexo' ) ) {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode( $error );
        } else {

            // pega os dados do upload
            $data = array('upload_data' => $this->upload->data());

            $extensao = str_replace( '.', '', $data['upload_data']['file_ext'] );

            $caminho = site_url( "mensagens/download/".$data['upload_data']['raw_name'] );

            $label = $data['upload_data']['client_name'];
            
            // seta as propriedades
            $mensagem->set( 'cliente', $cliente )
                    ->set( 'texto', $label )
                    ->set( 'arquivo', $data['upload_data']['raw_name'] )
                    ->set( 'label', $label )
                    ->set( 'extensao', $extensao )
                    ->set( 'funcionario', $user->CodFuncionario )
                    ->set( 'visualizada', 'N' )
                    ->set( 'autor', 'F' )
                    ->set( 'dataEnvio', date( 'Y-m-d H:i:s', time() ) );

            // seta o id
            $data['upload_data']['cod_arquivo'] = $arquivo->CodArquivo;

            if( $mensagem->save() ) {

                // recarrega a index
                return site_url( 'mensagens/index/'.$this->input->post( 'CodCliente' ) );
            }
        }
    }

   /**
    * fecharEvento
    *
    * fecha um evento
    *
    */
    public function fechar_evento( $CodEvento ) {
        
        // busca o evento
        $evento = $this->EventosFinder->clean()->key( $CodEvento )->get( true );
        
        // verifica se o evento existe
        if( !$evento ) {
            redirect( 'dashboard' );
            return;
        }

        // seta o evento como fechado
        $evento->setStatus( 'F' );
        $evento->save();

        redirect( "mensagens/index/$evento->CodEvento" );
        return;
    }
}
/* end of file */