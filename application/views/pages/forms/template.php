<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $template = $view->item( 'template' ); ?>
<?php $view->component( 'navbar/navbar' ); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php $view->component( 'aside/aside' ); ?>            
        </div>
        <div class="col-md-8">    

        <?php echo form_open( 'templates/salvar', [ 'class' => 'card container fade-in' ] )?>
    
            <div class="page-header">
                <h2>Novo template</h2>
            </div>
            
            <?php print_key( $template ); ?>
            <?php input_text( 'Nome', 'nome', $template ); ?>
            <div class="row">
                <div class="col-md-12">
                    <textarea rows="3" cols="" type="text" 
                            class="form-control" 
                            id="editor" 
                            name="corpo" 
                            placeholder=""><?php echo $template ? $template->corpo : ''; ?></textarea>
                </div>
            </div>

            <hr>
            <button class="btn btn-primary">Salvar</button>
            <a href="<?php echo site_url( 'template' ); ?>" class="btn btn-danger">Cancelar</a>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>