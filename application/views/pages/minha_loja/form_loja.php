<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-offset-2 col-md-8">
    <div class="page-header">
        <h4>Dados da loja</h4>
    </div>
    <?php input_text( false, 'nome', false, [ 'class' => 'global', 'required' => 'required', 'placeholder' => 'Nome da loja', 'length' => 12 ] ); ?>
    <?php input_text( false, 'cnpj', false, [ 'class' => 'global', 'required' => 'required', 'placeholder' => 'CNPJ', 'length' => 12 ] ); ?>
    <div class="page-header">
        <h4>Área de atuação</h4>
    </div>
    <?php input_text( false, 'nome', false, [ 'class' => 'global', 'required' => 'required', 'placeholder' => 'Nome da loja', 'length' => 12 ] ); ?>
    <?php input_text( false, 'cnpj', false, [ 'class' => 'global', 'required' => 'required', 'placeholder' => 'CNPJ', 'length' => 12 ] ); ?>
    <div class="page-header">
        <h4>Sobre a loja</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <textarea class="textarea" placeholder="Breve descrição" rows="10"></textarea>
        </div>
    </div>
</div>