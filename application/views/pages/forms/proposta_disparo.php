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
           
            <?php select( 'Cliente', 'cliente', $view->item( 'clientes' ) ? [] : [ 'disabled' => 'disabled' ] );?>
                <?php option(); ?>
                <?php if ( $view->item( 'clientes' ) ):?>
                    <?php foreach( $view->item( 'clientes' ) as $item ): ?>
                        <?php option( $item->CodCliente, $item->nome, $view->item( 'cliente' ), 'CodCliente' ); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endselect( 'Cliente' ); ?><!-- seta o status do cadastro -->
            
            <?php select( 'Proposta', 'proposta', $view->item( 'propostas' ) ? [] : [ 'disabled' => 'disabled' ] );?>
                <?php option(); ?>
                <?php if ( $view->item( 'propostas' ) ):?>
                    <?php foreach( $view->item( 'propostas' ) as $item ): ?>
                        <?php option( $item->CodProposta, $item->nome ); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endselect( 'Proposta' ); ?><!-- seta o status do cadastro -->

            <?php print_alert( 'danger', 'Erro', $view->item( 'errors' ) ); ?>

            <hr>
            <button class="btn btn-primary">Salvar</button>
            <a href="<?php echo site_url( 'clientes' ); ?>" class="btn btn-danger">Cancelar</a>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>