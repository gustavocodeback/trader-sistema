<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once "FuncionariosFinder.php";

class Funcionario extends FuncionariosFinder {

    // CodFuncionario
    public $CodFuncionario;

    // nome
    public $nome;
    
    // cpf
    public $cpf;
    
    // nascimento
    public $nascimento;
    
    // tel
    public $tel;
    
    // cidade
    public $cidade;
    
    // logradouro
    public $logradouro;
    
    // num
    public $num;
    
    // cep
    public $cep;

    // email
    public $email;

    // senha
    public $senha;

    // idCelular
    public $segmento;

    // gid
    public $gid;

    // token
    public $token;

    // foto
    public $foto;

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
                'rules' => 'is_unique[Funcionarios.Email]|valid_email|required'
            ], [
                'field' => 'senha',
                'label' => 'Senha',
                'rules' => 'matches[confirma]|min_length[6]|max_length[18]|required'
            ], [
                'field' => 'confirma',
                'label' => 'Confirmação de senha',
                'rules' => 'matches[senha]|min_length[6]|max_length[18]|required'
            ], [
                'field' => 'gid',
                'label' => 'Cargo',
                'rules' => 'required'
            ]
        ];

        // chama a regra da classe pai
        return parent::validate( $rules, $arr );
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
    public function save( $alterar = false) {

        // verifica se existe o código
        if ( !$this->CodFuncionario || $alterar ) {

            // encypta a senha
            $this->senha = $this->gerarHash( $this->senha );
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
        // $this->login = date( 'Y-m-d H:i:s', time() );

        // seta o token
        $this->token = md5( uniqid( time() * rand() ) );

        // salva os dados
        if ( !$this->save() ) return false;

        // seta os dados na sessao
        $this->session->set_userdata( 'funcionario',   $this->CodFuncionario );
        $this->session->set_userdata( 'token', $this->token );

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
        if ( $this->CodFuncionario != $this->session->userdata( 'funcionario' ) ) return false;

        // retorna true por padrao
        return true;
    }
}

/* end of file */