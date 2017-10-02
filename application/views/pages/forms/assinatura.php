<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $assinatura = $view->item( 'assinatura' ); ?>
<?php $view->component( 'aside' ); ?>
<div id="wrapper" class="wrapper show">
    <?php $view->component( 'navbar' ); ?>

    <?php echo form_open( 'assinaturas/salvar', [ 'class' => 'card container fade-in' ] )?>
        <?php $view->component( 'breadcrumb' ); ?>        
        <div class="page-header">
            <h2>Nova assinatura</h2>
        </div>

        <?php print_key( $assinatura ); ?>
        <?php select( 'Produto', 'produto' );?>
            <?php option(); ?>
            <?php foreach( $view->item( 'produtos' ) as $item ): ?>
            <?php option( $item->CodProduto, $item->nome, $assinatura, 'produto' ); ?>
            <?php endforeach; ?>
        <?php endselect( 'Produto' ); ?><!-- select de estados -->
        
        <?php select( 'Cliente', 'cliente' );?>
            <?php option(); ?>
            <?php foreach( $view->item( 'clientes' ) as $item ): ?>
            <?php option( $item->CodCliente, $item->nome, $assinatura, 'cliente' ); ?>
            <?php endforeach; ?>
        <?php endselect( 'Cliente' ); ?><!-- select de estados -->

        <?php input_text( 'Taxa inicial', 'taxaInicial', $assinatura, [ 'type' => 'number', 'step' => '0.01' ] ); ?>
        
        <div class="row">
            <?php input_text( 'Parcelas Inicial', 'numParcelasInicial', $assinatura, [ 'type' => 'number', 'row' => false, 'length' => '3' ] ); ?>
            <?php input_text( 'Valor Parcelas', 'valorParcelasInicial', $assinatura, [ 'type' => 'number', 'row' => false, 'length' => '3', 'step' => '0.01' ] ); ?>
        </div>

        <?php input_text( 'Taxa mensal', 'taxaMensal', $assinatura, [ 'type' => 'number', 'step' => '0.01' ] ); ?>
        
        <?php input_text( 'Data Cadastro', 'contrato', $assinatura, [ 'type' => 'date' ] ); ?>

        <hr>
        <button class="btn btn-primary">Salvar</button>
        <a href="<?php echo site_url( 'cidades' ); ?>" class="btn btn-danger">Cancelar</a>
    <?php echo form_close(); ?>

    <?php $view->component( 'footer' ); ?>
</div>