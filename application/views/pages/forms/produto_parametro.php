<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $parametro = $view->item( 'parametro' ); ?>
<?php $view->component( 'aside' ); ?>
<div id="wrapper" class="wrapper show">
    <?php $view->component( 'navbar' ); ?>

    <?php echo form_open( 'produtos_parametros/salvar', [ 'class' => 'card container fade-in' ] )?>
        <?php $view->component( 'breadcrumb' ); ?>        
        <div class="page-header">
            <h2>Novo parâmetro</h2>
        </div>
        
        <?php print_key( $parametro ); ?>
        <?php select( 'Produtos', 'produto' );?>
            <?php option(); ?>
            <?php foreach( $view->item( 'produtos' ) as $item ): ?>
            <?php option( $item->CodProduto, $item->nome, $parametro, 'produto' ); ?>
            <?php endforeach; ?>
        <?php endselect( 'Produtos' ); ?><!-- select de produtos -->

        <!-- imprime o input da chave -->
        <?php input_text( 'Chave', 'chave', $parametro ); ?>

        <hr>
        <button class="btn btn-primary">Salvar</button>
        <a href="<?php echo site_url( 'produtos' ); ?>" class="btn btn-danger">Cancelar</a>
    <?php echo form_close(); ?>

    <?php $view->component( 'footer' ); ?>
</div>