<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-offset-2 col-md-8">
    <div class="page-header">
        <h4>Localização</h4>
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
    <?php input_text( false, 'cep', false, [ 'class' => 'global', 'required' => 'required', 'placeholder' => 'CEP', 'length' => 12 ] ); ?>

    <div class="row">
        <?php input_text( false, 'bairro', false, [ 'row' => false, 'class' => 'global', 'required' => 'required', 'placeholder' => 'Bairro', 'length' => 8 ] ); ?>
        <?php input_text( false, 'numero', false, [ 'row' => false, 'class' => 'global', 'required' => 'required', 'placeholder' => 'Número', 'length' => 4 ] ); ?>        
    </div>

    <?php input_text( false, 'complemento', false, [ 'class' => 'global', 'required' => 'required', 'placeholder' => 'Complemento', 'length' => 12 ] ); ?>
    
</div>

<div class="col-md-offset-2 col-md-8">
    <div class="page-header">
        <h4>No mapa</h4>
    </div>
    <img src="http://i0.kym-cdn.com/photos/images/original/001/194/732/19f.jpg" width="100%">
</div>
