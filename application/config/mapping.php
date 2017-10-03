<?php defined('BASEPATH') OR exit('No direct script access allowed');

// tabela de grupo
$config['Grupo'] = [
    'grupo'  => 'grupo'
];

// tabela de rotina
$config['Rotina'] = [
    'link' => 'Link',
    'rotina' => 'Rotina',
    'classificacao' => 'CodClassificacao',
];

// tabela de classificacao
$config['Classificacao'] = [
    'nome'   => 'Nome',
    'icone'  => 'Icone',
    'ordem'  => 'Ordem'
];

// tabela de estado
$config['Estado'] = [
    'nome'   => 'Nome',
    'uf' => 'Uf',
];

// tabela de cidade
$config['Cidade'] = [
    'nome'   => 'Nome',
    'estado' => 'CodEstado',
];

// tabela de usuario
$config['Usuario'] = [
    'uid'   => 'uid',
    'email' => 'email',
    'senha' => 'password',
    'gid' => 'gid',
];

// Tabela de clientes
$config['Cliente'] = [
    'nome'              => 'Nome',
    'cpf'               => 'CPF',
    'nascimento'        => 'Nascimento',
    'tel'               => 'Telefone',
    'cidade'            => 'CodCidade',    
    'logradouro'        => 'Logradouro',
    'num'               => 'Numero',
    'cep'               => 'Cep',    
    'xp'                => 'CodXP',
    'email'             => 'Email',     
    'senha'             => 'Senha',
    'idCelular'         => 'IdCelular',
    'plataforma'        => 'Plataforma',
    'token'             => 'Token',
    'atributoSeg'       => 'AtributoSegmento',
    'funcionario'       => 'CodFuncionario',
    'tokenEmail'        => 'TokenEmail'
];

// Tabela de clientes
$config['Funcionario'] = [
    'nome'        => 'Nome',
    'cpf'         => 'CPF',
    'nascimento'  => 'Nascimento',
    'tel'         => 'Telefone',
    'cidade'      => 'CodCidade',    
    'logradouro'  => 'Logradouro',
    'num'         => 'Numero',
    'cep'         => 'Cep',    
    'email'       => 'Email',     
    'senha'       => 'Senha',
    'segmento'    => 'CodSegmento',
    'gid'         => 'GID',
    'token'       => 'Token',
    'foto'        => 'Foto',
    'tokenEmail'  => 'TokenEmail'
];


// Tabela de Mensagem
$config['Mensagem'] = [
    'cliente'       => 'CodCliente',
    'funcionario'   => 'CodFuncionario',
    'texto'         => 'Texto',
    'visualizada'   => 'Visualizada',
    'autor'         => 'Autor',
    'dataEnvio'     => 'DataEnvio',
    'arquivo'       => 'NomeArquivo',
    'label'         => 'Label',
    'extensao'      => 'Extensao'
];

// Tabela de Parametro
$config['Parametro'] = [
    'descricao' => 'Descricao',
    'valor'     => 'Valor'
];

// Tabela de Parametro
$config['Proposta'] = [
    'funcionario' => 'CodFuncionario',
    'proposta'    => 'Proposta',
    'dias'        => 'Dias',
    'nome'      => 'Nome',
    'descricao'   => 'Descricao'
];

// Tabela de colunas
$config['PropostaCliente'] = [
    'proposta'          => 'CodProposta',
    'cliente'           => 'CodCliente',
    'status'            => 'Status',
    'dataDisparo'       => 'DataDisparo',
    'dataVencimento'    => 'DataVencimento',
    'dataResposta'      => 'DataResposta'
];

// Tabela de Segmento
$config['Segmento'] = [
    'nome' => 'Nome'
];

// Tabela de Tag
$config['Tag'] = [
    'descricao' => 'Descricao'
];

// Tabela de TagCliente
$config['TagCliente'] = [
    'tag' => 'CodTag',
    'cliente' => 'CodCliente'
];

// Tabela de Template
$config['Template'] = [
    'nome'  => 'Nome',
    'corpo' => 'Corpo'
];

// Tabela de Template
$config['Post'] = [
    'titulo'        => 'Titulo',
    'textoCurto'    => 'TextoCurto',
    'post'          => 'Post',
    'imagem'        => 'Imagem'
];

// Tabela de Ticket
$config['Ticket'] = [
    'cliente'           => 'CodCliente',
    'funcionario'       => 'CodFuncionario',
    'nome'              => 'Nome',
    'status'            => 'Status',
    'avaliacao'         => 'Avaliacao',
    'elogio'            => 'Elogio',
    'reclamacao'        => 'Reclamacao',
    'sugestao'          => 'Sugestao',
    'dataAbertura'      => 'DataAbertura',
    'dataMovimentacao'  => 'DataMovimentacao'
];

/* end of file */