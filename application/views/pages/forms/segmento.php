<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $segmento = $view->item( 'segmento' ); ?>

<?php $view->component( 'navbar/navbar' ); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">

            <?php $view->component( 'aside/aside' ); ?>            
        </div>
        <div class="col-md-8">
        <?php echo form_open( 'segmentos/salvar', [ 'class' => 'card container fade-in' ] )?>
            <div class="page-header">
                <h2>Novo segmento</h2>
            </div>
            
            <?php print_key( $segmento ); ?>
            <?php input_text( 'Segmento', 'nome', $segmento ); ?>

            <hr>
            <button class="btn btn-primary">Salvar</button>
            <a href="<?php echo site_url( 'segmentos' ); ?>" class="btn btn-danger">Cancelar</a>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>