<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $esquema = $view->item( 'esquema' ); ?>
<?php $view->component( 'aside' ); ?>
<div id="wrapper" class="wrapper show">
    <?php $view->component( 'navbar' ); ?>

    <?php echo form_open( 'esquemas/salvar', [ 'class' => 'card container fade-in' ] )?>
        <?php $view->component( 'breadcrumb' ); ?>        
        <div class="page-header">
            <h2>Novo esquema</h2>
        </div>

        <?php print_key( $esquema ); ?>
        <?php input_text( 'Esquema', 'esquema', $esquema ); ?>

        <hr>
        <button class="btn btn-primary">Salvar</button>
        <a href="<?php echo site_url( 'esquemas' ); ?>" class="btn btn-danger">Cancelar</a>
    <?php echo form_close(); ?> 

    <?php $view->component( 'footer' ); ?>
</div>