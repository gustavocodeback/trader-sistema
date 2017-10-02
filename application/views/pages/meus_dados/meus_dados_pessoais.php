<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-offset-2 col-md-8">
    
    <div class="page-header">
        <h4 style="color: #EB0019">Dados pessoais</h4>
    </div>
    <?php input_text( false, 'nome', false, [ 'class' => 'global', 'required' => 'required', 'placeholder' => 'Nome', 'length' => 12 ] ); ?>
    <?php input_text( false, 'cpf', false,  [ 'class' => 'global cpf', 'required' => 'required', 'placeholder' => 'CPF', 'length' => 12 ] ); ?>
    
    <label for="" >Aniversário</label>

    <div class="row">
        <?php input_text( false, 'dia', false, [ 'row' => false, 'type' => 'number', 'class' => 'global', 'required' => 'required', 'placeholder' => 'Dia', 'length' => 4 ] ); ?>
        <?php input_text( false, 'mes', false, [ 'row' => false, 'type' => 'number', 'class' => 'global', 'required' => 'required', 'placeholder' => 'Mês', 'length' => 4 ] ); ?>
        <?php input_text( false, 'ano', false, [ 'row' => false, 'type' => 'number', 'class' => 'global', 'required' => 'required', 'placeholder' => 'Ano', 'length' => 4 ] ); ?>
    </div>

    <div class="page-header">
        <h4 style="color: #EB0019">Dados de contato</h4>
    </div>
    <?php input_text( false, 'telefone', false, [ 'class' => 'global telefone', 'required' => 'required', 'placeholder' => 'Telefone fixo', 'length' => 12 ] ); ?>
    <?php input_text( false, 'celular', false,  [ 'class' => 'global telefone', 'required' => 'required', 'placeholder' => 'Celular', 'length' => 12 ] ); ?>
    
    <div class="page-header">
        <h4 style="color: #EB0019">Dados de endereço</h4>
    </div>

    <?php select( 'Estado', 'estado', [ 'class' => 'global', 'required' => 'required', 'placeholder' => 'Nome da loja', 'length' => 12 ] );?>
        <?php option(); ?>
        <?php option( 'SP', 'São Paulo', false, false ); ?>
    <?php endselect( 'Estado' ); ?><!-- select do estado -->

    <?php select( 'Cidade', 'cidade', [ 'class' => 'global', 'required' => 'required', 'placeholder' => 'Nome da loja', 'length' => 12 ] );?>
        <?php option(); ?>
        <?php option( 'SP', 'São Paulo', false, false ); ?>
    <?php endselect( 'Estado' ); ?><!-- select de cidade -->

    <?php input_text( false, 'endereco', false, [ 'class' => 'global', 'required' => 'required', 'placeholder' => 'Endereço', 'length' => 12 ] ); ?>
    <?php input_text( false, 'cep', false, [ 'type' => 'number', 'class' => 'global cep', 'required' => 'required', 'placeholder' => 'CEP', 'length' => 12 ] ); ?>

    <div class="row">
        <?php input_text( false, 'bairro', false, [ 'row' => false, 'class' => 'global', 'required' => 'required', 'placeholder' => 'Bairro', 'length' => 8 ] ); ?>
        <?php input_text( false, 'numero', false, [ 'type' => 'number', 'row' => false, 'class' => 'global', 'required' => 'required', 'placeholder' => 'Número', 'length' => 4 ] ); ?>        
    </div>

    <?php input_text( false, 'complemento', false, [ 'class' => 'global', 'placeholder' => 'Complemento', 'length' => 12 ] ); ?>
    
    <div class="row">
        <div class="col-md-12 text-right">
            <button class="btn btn-primary btn-lg">
                Salvar alterações
            </button>
        </div>
    </div><!-- botao de salvar -->
    
</div>