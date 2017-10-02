<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $rotina = $view->item( 'rotina' ); ?>
<?php $view->component( 'navbar/navbar' ); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php $view->component( 'aside/aside' ); ?>            
        </div>
        <div class="col-md-8">           
        <?php echo form_open( 'rotinas/salvar', [ 'class' => 'card container fade-in' ] )?>
            <div class="page-header">
                <h2>Nova Rotina</h2>
            </div>
            
            <!-- rotina -->
            <?php print_key( $rotina ); ?>
            <?php input_text( 'Rotina', 'rotina', $rotina ); ?>
            <?php input_text( 'Link', 'link', $rotina ); ?>
            <?php select( 'Classificacao', 'classificacao' );?>
                <?php option(); ?>
                <?php foreach( $view->item( 'class' ) as $item ): ?>
                <?php option( $item->CodClassificacao, $item->nome, $rotina, 'classificacao' ); ?>
                <?php endforeach; ?>
            <?php endselect( 'Classificacao' ); ?><!-- select de estados -->

            <hr>
            <button class="btn btn-primary">Salvar</button>
            <a href="<?php echo site_url( 'rotinas' ); ?>" class="btn btn-danger">Cancelar</a>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>