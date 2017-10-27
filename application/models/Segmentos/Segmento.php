<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once "SegmentosFinder.php";

class Segmento extends SegmentosFinder {

    // id do grupo
    public $CodSegmento;

    // nome
    public $nome;

    // entidade
    public $entity = 'Segmento';
    
    // tabela
    public $table = 'Segmentos';

    // chave primaria
    public $primaryKey = 'CodSegmento';

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
    * enviarProposta
    *
    * envia uma proposta a um segmento
    *
    */
    public function enviarProposta( $proposta ) {

        // carrega a model de proposta clietne
        $this->load->model( 'PropostasClientes/PropostaCliente' );

        // preparo os dados
        $propostaCliente = $this->PropostaCliente->getEntity();
        $propostaCliente->set( 'segmento', $this->CodSegmento )
                        ->set( 'proposta', $proposta->CodProposta )
                        ->set( 'status', "D" )
                        ->set( 'dataDisparo', date('Y-m-d', time() ) )
                        ->set( 'dataVencimento', date('Y-m-d', time() + ( 3600 * $proposta->dias ) + 1 ) );
        
        // salva o disparo
        $result = $propostaCliente->save();

        // verifica se salvou a proposta
        if ( $result ) {

            // salva o historico
            $this->salvarHistorico( 'Proposta enviada', $proposta, 'Cliente recebeu a proposta '.$proposta->nome );

            // volta o resultado
            return $result;
        } else return false;
    }

   /**
    * salvarHistorico
    *
    * salva o histórico
    *
    */
    public function salvarHistorico( $titulo, $proposta, $texto = null ) {

        // carrega a model de histórico
        $this->load->model( 'Historicos/Historico' );

        // cria uma entidade
        $entide = $this->Historico->getEntity();

        // seta os atributos
        $entide->set( 'titulo', $titulo )
               ->set( 'texto', $texto )
               ->set( 'sistema', 1 )
               ->set( 'proposta', $proposta->CodProposta )
               ->set( 'segmento', $this->CodSegmento );

        // salva o historico
        return $entide->save();
    }
}

/* end of file */
