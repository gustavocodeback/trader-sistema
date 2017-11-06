<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* View
*
* classe de manipulacao de view
*
*/
class View {

    // titulo da pagina
    public $title = null;

    // instancia do codeigniter
    public $ci;

    // links para arquivos js
    public $js = [];

    // links para arquivos css
    public $css = [];

    // configuracao
    public $config;

    // pagina atual
    public $page;

    // dados da pagina
    public $data = [];

    // usuario logado
    public $user;

    // prefixo no titulo

    public $titlePrefix = 'Force Investor - ';

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {

        // pega a instancia do codeigniter
        $this->ci =& get_instance();

        // carrega a configuracao
        $this->config = $this->ci->config;
        $this->config->load( 'assets' );

        // seta os pacotes padrao
        $this->_loadDefault();
    }

   /**
    * _loadDefault
    *
    * carrega os arquivos padroes
    *
    * @private
    */
    private function _loadDefault() {

        // pega os pacotes padroes
        $defaults = $this->config->item( 'default' );

        // percorre todos
        foreach( $defaults as $pack ) {

            // pega o item
            if ( $item = $this->config->item( $pack ) ) {

                // verifica se existem js
                if ( isset( $item['js'] ) ) {

                    // percorre todos os itens
                    foreach( $item['js'] as $js_file ) $this->js[] = $js_file;
                }

                // verifica se existe css
                if( isset( $item['css'] ) ) {

                    // percorre todos os itens
                    foreach( $item['css'] as $css_file ) $this->css[] = $css_file;
                }
            }
        }
    }

    public function rotinasAcesso() {

        // carrega o usuário
        $funcionario = $this->ci->guard->currentUser();

        // carrega a model
        $this->ci->load->model( 'Rotinas/Rotina' );
        $acessos = [];
        $rotinas = $this->ci->Rotina->clean()->get();
        foreach ( $rotinas as $key => $rotina ) {

            // verifica se tem acesso a rotina
            if( $this->hasAccess( $rotina->rid, $funcionario->gid ) ) $acessos[] = $rotina;
        }
        return $acessos;
    }

   /**
    * setItem
    *
    * seta o valor de um item de dados
    *
    * @param {string} $key a chave do item
    * @param {string} $value o valor do item
    */
    public function set( $key, $value ) {
        
        // seta o valor no array de dados
        $this->data[$key] = $value;
        return $this;
    }

   /**
    * item
    *
    * pega um item de dado
    *
    * @param {string} $key o item a ser recuperado
    */
    public function item( $key ) {

        // verifica se o item existe
        return isset( $this->data[$key] ) ? $this->data[$key] : null;
    }

   /**
    * module
    *
    * carrega o js e css de um modulo
    *
    * @param {string} $module o modulo a ser carregado
    */
    public function module( $module ) {

        // verifica se existe o modulo
        if ( $item = $this->config->item( $module ) ) {
            
            // verifica se existem js
            if ( isset( $item['js'] ) ) {

                // percorre todos os itens
                foreach( $item['js'] as $js_file ) $this->js[] = $js_file;
            }

            // verifica se existe css
            if( isset( $item['css'] ) ) {

                // percorre todos os itens
                foreach( $item['css'] as $css_file ) $this->css[] = $css_file;
            }
        }

        // retira itens repetidos
        $this->css = array_unique( $this->css );
        $this->js = array_unique( $this->js );

        // retorna a instancia
        return $this;
    }

   /**
    * setTitle
    *
    * seta o titulo da pagina
    *
    * @param {string} $title titulo da pagina
    */
    public function setTitle( $title = '' ) {

        // seta o titulo da pagina
        $this->title = $this->titlePrefix.$title;
        return $this;
    }

   /**
    * getTitle
    *
    * pega o titulo da pagina
    *
    */
    public function getTitle() {

        // verifica se existe um titulo a ser retornado
        return ( $this->title ) ? $this->title : 'Página sem título';
    }

   /**
    * component
    *
    * renderiza um componente especifica
    *
    * @param {string} $component pagina a ser carregada
    */
    public function component( $component = '', $html = false ) {

        // carrega o modulo
        $this->module( $component );

        // verifica se o arquivo existe
        if ( file_exists( APPPATH.'views/components/'.$component.'.php' ) ) {
            
            // carrega o usuário logado
            $user = $this->ci->guard->currentUser();

            // carrega sem a view master
            return $this->ci->load->view( 'components/'.$component, [ 'view' => $this, 'user' => $user ], $html );
        } else $this->ci->load->view( 'errors/html/error_404' );
    }

   /**
    * render
    *
    * renderiza uma pagina especifica
    *
    * @param {string} $page pagina a ser carregada
    */
    public function render( $page = '', $master = true, $html = false ) {

        // seta a pagina atual
        $this->page = $page;

        // carrega o modulo
        $this->module( $page );

        // verifica se o arquivo existe
        if ( file_exists( APPPATH.'views/pages/'.$page.'.php' ) ) {

            // carrega o usuário logado
            $user = $this->ci->guard->currentUser();

            // carrega a pagina
            if ( $master ) {

                // carrega a view master
                return $this->ci->load->view( 'master', [ 'view' => $this , 'user' => $user ], $html );
            } else {

                 // carrega sem a view master
                return $this->ci->load->view( 'pages/'.$page, [ 'view' => $this, 'user' => $user ], $html );
            }
        } else $this->ci->load->view( 'errors/html/error_404' );
    }

   /**
    * getHeader
    *
    * volta o cabecalho do grid
    *
    */
    public function getHeader( $data ) {

        // pega o item
        $data = $this->item( $data );

        // verifica se algum dado foi enviado
        if ( !is_array( $data ) && count( $data ) == 0 ) return false;

        // pega a primeira linha
        $row = $data[0];

        // volta as chaves
        return array_keys( $row );
    }

    /**
    * hasAccess
    *
    * verifica se um usuario tem acesso a uma rotina
    *
    */
    public function hasAccess( $rid, $gid ) {

        // prepara a busca
        $this->ci->db->from( 'Permissoes' )
        ->select( '*' )
        ->where( " rid = $rid AND gid = $gid " );

        // faz a busca
        $busca = $this->ci->db->get();

        // volta o resultado
        return $busca->num_rows() > 0 ? true : false;
    }
    
    /**
    * canCreate
    *
    * verifica se um usuario tem acesso a uma rotina
    *
    */
    public function canCreate( $rid, $gid ) {

        // prepara a busca
        $this->ci->db->from( 'Permissoes' )
        ->select( '*' )
        ->where( " rid = $rid AND gid = $gid AND create = 'S' " );

        // faz a busca
        $busca = $this->ci->db->get();

        // volta o resultado
        return $busca->num_rows() > 0 ? true : false;
    }

   /**
    * hasAccess
    *
    * verifica se um usuario tem acesso a uma rotina
    *
    */
    public function canRead( $rid, $gid ) {
        
        // prepara a busca
        $this->ci->db->from( 'Permissoes' )
        ->select( '*' )
        ->where( " rid = $rid AND gid = $gid AND read = 'S' " );

        // faz a busca
        $busca = $this->ci->db->get();

        // volta o resultado
        return $busca->num_rows() > 0 ? true : false;
    }

   /**
    * hasAccess
    *
    * verifica se um usuario tem acesso a uma rotina
    *
    */
    public function canUpdate( $rid, $gid ) {

        // prepara a busca
        $this->ci->db->from( 'Permissoes' )
        ->select( '*' )
        ->where( " rid = $rid AND gid = $gid AND update = 'S' " );

        // faz a busca
        $busca = $this->ci->db->get();

        // volta o resultado
        return $busca->num_rows() > 0 ? true : false;
    }

   /**
    * hasAccess
    *
    * verifica se um usuario tem acesso a uma rotina
    *
    */
    public function canDelete( $rid, $gid ) {

        // prepara a busca
        $this->ci->db->from( 'Permissoes' )
        ->select( '*' )
        ->where( " rid = $rid AND gid = $gid AND delete = 'S' " );

        // faz a busca
        $busca = $this->ci->db->get();

        // volta o resultado
        return $busca->num_rows() > 0 ? true : false;
    }
    
   /**
    * getMenu
    *
    * volta o menu formatado
    *
    */
    public function getMenu() {

        // carrega o usuário logado
        $user = $this->ci->guard->currentUser();

        // pega as classificacoes
        $class = $this->obterClassificacoes();

        // pega as partes da url
        $part = $this->ci->uri->segment( 1 );

        // percorre as classificacao
        foreach( $class as $key => $item ) {

            // pega as rotinas
            $rotinas = $this->obterRotinasClassificacao( $item['CodClassificacao'] );
            $class[$key]['active'] = false;

            // verifica se existe rotina
            if ( count( $rotinas ) > 0 ) {

                // percorre as rotinas
                foreach( $rotinas as $ch => $rotina ) {

                    // verifica se o usuario atual tem permissao
                    if ( !$this->hasAccess( $rotina['rid'], $user->gid ) ) {
                        unset( $rotinas[$ch] );
                    }
                }
            }

            if ( count( $rotinas ) > 0 ) {
                $class[$key]['rotinas'] = $rotinas;
                foreach( $class[$key]['rotinas'] as $ch => $rotina ) {
                    if ( $rotina['Link'] == $part || $rotina['Link'] == $part.'/index' ) {
                        // $class[$key]['rotinas'][$ch]['active'] = true;
                        $class[$key]['active'] = true;
                    } else {
                        $class[$key]['rotinas'][$ch]['active'] = false;
                    }
                }
            }
            else 
                unset( $class[$key] );
        }

        // volta as classificacoes
        return $class;
    }

    /**
    * obterRotinasClassificacao
    *
    * obtem as rotinas de uma classificacao
    *
    */
    private function obterRotinasClassificacao( $cod ) {
        
        // prepara a busca
        $this->ci->db->from( 'Rotinas' )
        ->select( '*' )
        ->where( "CodClassificacao = $cod" );

        // faz a busca
        $busca = $this->ci->db->get();

        // retorna os resultados
        return $busca->num_rows() > 0 ? $busca->result_array() : [];
    }

   /**
    * obterClassificacoes
    *
    * pega as classificacoes registradas
    *
    */
    private function obterClassificacoes() {

        // prepara a busca
        $this->ci->db->from( 'Classificacoes' )
        ->order_by( 'Ordem', 'ASC' )        
        ->select( '*' );

        // faz a busca
        $busca = $this->ci->db->get();

        // retorna os resultados
        return $busca->num_rows() > 0 ? $busca->result_array() : [];
    }

    public function hasTag( $tag, $cliente) {
        
        // carrega a model
        $this->ci->load->model( 'TagsClientes/TagCliente' );
        return $this->ci->TagCliente->clean()->tag( $tag )->cliente( $cliente )->get( true );
    }

}

/* end of file */
