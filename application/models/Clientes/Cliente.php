<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once "ClientesFinder.php";

class Cliente extends ClientesFinder {

    // CodFuncionario
    public $CodCliente;

    // nome
    public $nome;

    // funcionario
    public $funcionario;
    
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
    public $idCelular;

    // plataforma
    public $plataforma;

    // token
    public $token;

    // atributo segmento
    public $atributoSeg;

    // xp
    public $xp;

    // tokenEmail
    public $tokenEmail;

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
            ],[
                'field' => 'codXP',
                'label' => 'Código XP',
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

        // verifica se a senha foi alterada
        if( $alterar ) {
            
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
    * gerarToken
    *
    * gera o token de login
    * 
    */
    public function gerarToken() {

        // gera o token
        $this->token = md5( uniqid( time() * rand() ) );

        // retorna a instancia
        return $this;
    }

    public function avatar() {

        // verifica se existe uma foto
        if ( $this->foto ) {

            // verifica se o arquivo existe
            if ( file_exists( 'uploads/'.$this->foto ) ) {
                return base_url( 'uploads/'.$this->foto );
            } else return base_url( 'images/no-user-image.gif' );
        } else return base_url( 'images/no-user-image.gif' );
    }
}

/* end of file */