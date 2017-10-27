<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $view->component( 'navbar/navbar' ); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php $view->component( 'aside/aside' ); ?>            
        </div>
        <div class="col-md-8">           
        <?php echo form_open( 'propostas/salvar_disparo', [ 'class' => 'card container fade-in' ] )?> 
            <div class="page-header">
                <h2>Novo disparo</h2>
            </div>

            <?php print_alert( 'danger', 'Erro', $view->item( 'errors' ) ); ?>
            <?php print_alert( 'success', 'Sucesso', $view->item( 'success' ) ); ?>
           
            <?php select( 'Clientes', 'segmento', $view->item( 'segmentos' ) ? [] : [ 'disabled' => 'disabled' ] );?>
                <?php option(); ?>
                <?php if ( $view->item( 'segmentos' ) ):?>
                    <?php foreach( $view->item( 'segmentos' ) as $item ): ?>
                        <?php option( $item->CodSegmento, $item->nome, $view->item( 'segmento' ), 'CodSegmento' ); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php option( 0, 'Todos' ); ?>
            <?php endselect( 'Segmento' ); ?><!-- seta os segmentos -->
            
            <?php if ( $view->item( 'propostas' ) ):?>
                <h4>Propostas:</h4>
                <?php input_checkbox( 'Todas', 'propDisparadas[]', false, [ 'value' => 0 ] ); ?>
                <?php foreach( $view->item( 'propostas' ) as $proposta ) : ?>
                    <?php input_checkbox( $proposta->nome, $proposta->nome, false, [ 'name' => 'propDisparadas[]','value' => $proposta->CodProposta ] ); ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <hr>
            <button class="btn btn-primary">Salvar</button>
            <a href="<?php echo site_url( 'propostas' ); ?>" class="btn btn-danger">Voltar</a>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>