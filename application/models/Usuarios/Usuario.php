<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once "UsuariosFinder.php";

class Usuario extends UsuariosFinder {

    // código na tabela
    public $CodUsuario;

    // id do usuário
    public $UID;

    // nome do usuário
    public $nome;

    // email do usuário
    public $email;

    // senha do usuário
    public $senha;

    // token da sessao
    public $sessao;

    // data de cadastro
    public $cadastro;

    // data do ultimo login
    public $login;

    // créditos do usuário
    public $creditos;

    // cpf
    public $cpf;

    // aniversario
    public $aniversario;

    // telefone
    public $telefone;

    // celular
    public $celular;

    // estado
    public $estado;

    // cidade
    public $cidade;

    // endereco
    public $endereco;

    // cep
    public $cep;

    // bairro
    public $bairro;

    // numero
    public $numero;

    // complemento
    public $complemento;

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
    }

   /**
    * validate
    *
    * valida os dados para o usuário
    * 
    */
    public function validar( $arr = false ) {

        // seta as regras de validação
        $rules = [
            [
                'field' => 'nome',
                'label' => 'Nome',
                'rules' => 'min_length[2]|max_length[100]|required'
            ], [
                'field' => 'email',
                'label' => 'E-mail',
                'rules' => 'is_unique[Usuarios.Email]|valid_email|required'
            ], [
                'field' => 'senha',
                'label' => 'Senha',
                'rules' => 'matches[confirma]|min_length[6]|max_length[18]|required'
            ], [
                'field' => 'confirma',
                'label' => 'Confirmação de senha',
                'rules' => 'matches[senha]|min_length[6]|max_length[18]|required'
            ]
        ];

        // chama a regra da classe pai
        return parent::validate( $rules, $arr );
    }

   /**
    * gerarUID
    *
    * gera um novo uid
    * 
    */
    public function gerarUID( $return = false ) {

        // gera um uid aleatório
        $uid = md5( uniqid( time() * rand() ) );

        // verifica se deve retornar o uid
        if ( $return ) {

            // retorna o uid
            return $uid;
        } else {

            // seta a propriedade e retorna a instância
            $this->UID = $uid;
            return $this;
        }
    }

   /**
    * generate_hash
    *
    * gera um hash de senha
    *
    * @param {string} $cost
    * @param {string} $password
    */
    public function gerarHash( $password, $cost = 11 ) {
        
        // cria o salt
        $salt = substr( base64_encode( openssl_random_pseudo_bytes( 17 ) ), 0, 22 );

        // remove + e .
        $salt = str_replace( "+", ".", $salt );

        // cria a string de enciptacao
        $param = '$'.implode('$', [
                "2y",
                str_pad($cost,2,"0",STR_PAD_LEFT),
                $salt
        ]);

        // volta a has
        return crypt($password,$param);
    }

   /**
    * save
    *
    * salvar o uid
    * 
    */
    public function save() {

        // verifica se existe o código
        if ( !$this->CodUsuario ) {

            // encypta a senha
            $this->senha = $this->gerarHash( $this->senha );

            // seta a data de cadastro
            $this->cadastro = date( 'Y-m-d H:i:s', time() );
        }

        // chama o método de salvamento
        return parent::save();
    }

   /**
    * verificarSenha
    *
    * verifica se a senha digitada é a mesma
    * 
    */
    public function verificarSenha( $senha ) {

        // verifica as senha
        return ( crypt( $senha, $this->senha ) === $this->senha );
    }

   /**
    * login
    *
    * faz o login
    * 
    */
    public function login() {

        // seta o login
        $this->login = date( 'Y-m-d H:i:s', time() );

        // seta o token
        $this->sessao = md5( uniqid( time() * rand() ) );

        // salva os dados
        if ( !$this->save() ) return false;

        // seta os dados na sessao
        $this->session->set_userdata( 'uid',   $this->UID );
        $this->session->set_userdata( 'token', $this->sessao );

        // volta true por padrao
        return true;
    }

   /**
    * logout
    *
    * faz o logout
    * 
    */
    public function logout() {

        // limpa a sessao
        $this->session->sess_destroy();
    }

   /**
    * loggedIn
    *
    * verifica se o usuário esta logado
    * 
    */
    public function loggedIn() {

        // verifica se o token da sessao esta correto
        if ( $this->sessao != $this->session->userdata( 'token' ) ) return false;

        // verifica se o uid estao igual
        if ( $this->UID != $this->session->userdata( 'uid' ) ) return false;

        // retorna true por padrao
        return true;
    }
}

/* end of file */