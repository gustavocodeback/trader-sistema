<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-offset-2 col-md-8">
    
    <div class="page-header">
        <h4 style="color: #EB0019">Dados de acesso</h4>
    </div>
    <?php input_text( false, 'nome', false, [ 'class' => 'global', 'required' => 'required', 'placeholder' => 'Email', 'length' => 12 ] ); ?>
    <?php input_text( false, 'cpf', false, [ 'class' => 'global', 'required' => 'required', 'placeholder' => 'Senha atual', 'length' => 12 ] ); ?>
    <?php input_text( false, 'cpf', false, [ 'class' => 'global', 'required' => 'required', 'placeholder' => 'Nova senha', 'length' => 12 ] ); ?>
    <?php input_text( false, 'cpf', false, [ 'class' => 'global', 'required' => 'required', 'placeholder' => 'Confirma nova senha', 'length' => 12 ] ); ?>

    <div class="row">
        <div class="col-md-12 text-right">
            <button class="btn btn-primary btn-lg">
                Salvar alterações
            </button>
        </div>
    </div><!-- botao de salvar -->
    
</div>