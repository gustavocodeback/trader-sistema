<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $parametro = $view->item( 'parametro' ); ?>
<?php $view->component( 'navbar/navbar' ); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php $view->component( 'aside/aside' ); ?>            
        </div>
        <div class="col-md-8">    
            <?php echo form_open( 'parametros/salvar', [ 'class' => 'card container fade-in' ] )?>
                <div class="page-header">
                    <h2>Novo parametro</h2>
                </div>
                
                <?php print_key( $parametro ); ?>
                <?php input_text( 'Parâmetro', 'descricao', $parametro ); ?>

                <?php print_key( $parametro ); ?>
                <?php input_text( 'Valor', 'valor', $parametro ); ?>

                <hr>
                <button class="btn btn-primary">Salvar</button>
                <a href="<?php echo site_url( 'parametros' ); ?>" class="btn btn-danger">Cancelar</a>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>