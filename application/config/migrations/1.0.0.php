<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Tabela de clientes
$config['schema']['Usuarios'] = [
    'CodUsuario' => [
        'type'           => 'int',
        'constraint'     => '11',
        'primary_key'    => TRUE,
        'auto_increment' => TRUE
    ],
    'UID' => [
        'type'       => 'varchar',
        'constraint' => '32'
    ], 
    'Nome' => [
        'type'       => 'varchar',
        'constraint' => '60'
    ],
    'Email' => [
        'type'       => 'varchar',
        'constraint' => '60'
    ],
    'Senha' => [
        'type'       => 'varchar',
        'constraint' => '255'
    ],
    'Sessao' => [
        'type'       => 'varchar',
        'constraint' => '32'
    ],
    'Cadastro' => [
        'type' => 'datetime'
    ],
    'Login' => [
        'type' => 'datetime',
    ],
    'Creditos' => [
        'type'    => 'float',
        'null'    => false,
        'default' => 0
    ]
];

/* end of file */