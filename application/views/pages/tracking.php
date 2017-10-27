<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $view->component( 'navbar/navbar' ); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php $view->component( 'aside/aside' ); ?>            
        </div>
        <div class="col-md-8">    
            <div class="page-header form-title">
                <h2>Tracking das propostas</h2>
            </div>
            
            <?php select( 'Cliente', 'cliente', [  'onchange' => 'carregar( "tracking/historico/"+$( this ).val(), null, "#container", "#loader" )' ] );?>
                <?php option(); ?>
                <?php foreach( $view->item( 'clientes' ) as $item ): ?>
                <?php option( $item->CodCliente, $item->nome, false, false ); ?>
                <?php endforeach; ?>
            <?php endselect( 'Cliente', false ); ?><!-- select de estados -->

            <div class="row">
                <div id="container" class="col-md-12">
                </div>
            </div>

            <?php $view->component( 'footer' ); ?>
        </div>
    </div>
</div>
<div id="loader" class="hidden">
    <<img src="<?= base_url( 'images/icons/loading.gif' ); ?>" alt="">
</div>