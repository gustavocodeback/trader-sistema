<?php defined('BASEPATH') OR exit('No direct script access allowed');

require 'PropostasFinder.php';

class Proposta extends PropostasFinder {

    // id da proposta
    public $CodProposta;

    // proposta
    public $proposta;

    // nome
    public $nome;

    // descricao
    public $descricao;

    // funcionario
    public $funcionario;

    // dias
    public $dias;

    // entidade
    public $entity = 'Proposta';
    
    // tabela
    public $table = 'Propostas';

    // chave primaria
    public $primaryKey = 'CodProposta';

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
    * setCodProposta
    *
    * seta o codigo da proposta
    *
    */
    public function setCodProposta( $codProposta ) {
        $this->codProposta = $codProposta;
    }

   /**
    * setProposta
    *
    * seta a proposta
    *
    */
    public function setProposta( $proposta ) {
        $this->proposta = $proposta;
    }

   /**
    * setFuncionario
    *
    * seta a classificacao
    *
    */
    public function setFuncionario( $func ) {
        $this->funcionario = $func;
    }

   /**
    * setDias
    *
    * seta os dias
    *
    */
    public function setDias( $dias ) {
        $this->dias = $dias;
    }

   /**
    * podeEnviar
    *
    * verifica se pode enviar a proposta para um seguimento
    *
    */
    public function podeEnviar( $segmento ) {

        // pega o dia atual
        $hoje = date( 'Y-m-d', time() );

        // faz a busca
        $this->db->from( 'PropostasClientes' )
        ->select( 'CodPropostaCliente' )
        ->where( " '$hoje' < DataVencimento AND CodSegmento = $segmento AND CodProposta = $this->CodProposta "  );

        // faz a busca
        $query = $this->db->get();

        // verifica se existem resultados
        return ( $query->num_rows() > 0 ) ? false: true;
    }
}

/* end of file */
