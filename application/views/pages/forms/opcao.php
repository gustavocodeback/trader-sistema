<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $view->component( 'aside' ); ?>
<div id="wrapper" class="wrapper show">
    <?php $view->component( 'navbar' ); ?>

    <?php echo form_open( 'assinaturas/salvar_opcoes/'.$view->item( 'cod' ), [ 'class' => 'card container fade-in' ] )?>
        <?php $view->component( 'breadcrumb' ); ?>        
        <div class="page-header">
            <h2>Parâmetros da assinatura</h2>
        </div>

        <?php foreach( $view->item( 'opcoes' ) as $item ): ?>
        <?php input_text( $item->chave, $item->chave, false, [ 'value' => $item->value( $view->item( 'cod' ) ) ] ); ?> 
        <?php endforeach; ?>

        <hr>
        <button class="btn btn-primary">Salvar</button>
        <a href="<?php echo site_url( 'assinaturas' ); ?>" class="btn btn-danger">Cancelar</a>
    <?php echo form_close(); ?> 

    <?php $view->component( 'footer' ); ?>
</div>