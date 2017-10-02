<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $proposta = $view->item( 'proposta' ); ?>
<?php $view->component( 'navbar/navbar' ); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php $view->component( 'aside/aside' ); ?>            
        </div>
        <div class="col-md-8">           
        <?php echo form_open( 'propostas/salvar', [ 'class' => 'card container fade-in' ] )?>
            <div class="page-header">
                <h2>Nova Proposta</h2>
            </div>
            
            <!-- proposta -->
            <?php print_key( $proposta ); ?>
            <?php input_text( 'Nome', 'nome', $proposta ); ?>
            <div class="row">
                <div class="col-md-6">                
                    <label for="descricao">Descrição</label>
                    <textarea rows="3" cols="" type="text" 
                            class="form-control" 
                            id="descricao" 
                            name="descricao" 
                            placeholder=""><?php echo $proposta ? $proposta->descricao : ''; ?></textarea>
                </div>
            </div>
            <?php input_text( 'Dias', 'dias', $proposta ); ?>
            <div class="row">
                <div class="col-md-12">
                    <textarea rows="3" cols="" type="text" 
                            class="form-control" 
                            id="editor" 
                            name="proposta" 
                            placeholder=""><?php echo $proposta ? $proposta->proposta : ''; ?></textarea>
                </div>
            </div>

            <?php print_alert( 'danger', 'Erro', $view->item( 'errors' ) ); ?>

            <hr>
            <button class="btn btn-primary">Salvar</button>
            <a href="<?php echo site_url( 'propostas' ); ?>" class="btn btn-danger">Cancelar</a>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>