<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $tag = $view->item( 'tag' ); ?>
<?php $view->component( 'navbar/navbar' ); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php $view->component( 'aside/aside' ); ?>            
        </div>
        <div class="col-md-8">    
            <?php echo form_open( 'tags/salvar', [ 'class' => 'card container fade-in' ] )?>
                <div class="page-header">
                    <h2>Nova tag</h2>
                </div>
                
                <?php print_key( $tag ); ?>
                <?php input_text( 'Tag', 'descricao', $tag ); ?>

                <hr>
                <button class="btn btn-primary">Salvar</button>
                <a href="<?php echo site_url( 'tags' ); ?>" class="btn btn-danger">Cancelar</a>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>