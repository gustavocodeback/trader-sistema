<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $coluna = $view->item( 'coluna' ); ?>
<?php $tabela = $view->item( 'tabela' ); ?>
<?php $view->component( 'aside' ); ?>
<div id="wrapper" class="wrapper show">
    <?php $view->component( 'navbar' ); ?>

    <?php echo form_open( 'colunas/salvar', [ 'class' => 'card container fade-in' ] )?>
        <?php $view->component( 'breadcrumb' ); ?>        
        <div class="page-header">
            <h2>Nova coluna em <?php echo $tabela->nome; ?></h2>
        </div>

        <?php print_key( $coluna ); ?>
        <?php input_text( false, 'tabela', $coluna, [ 'value' => $tabela->CodTabela, 'type' => 'hidden' ] ); ?>
        <?php input_text( 'Nome', 'nome', $coluna ); ?>
        <?php input_text( 'Tamanho', 'tamanho', $coluna, [ 'type' => 'number' ] ); ?>
        <?php input_text( 'Tipo', 'tipo', $coluna ); ?>
        <?php input_checkbox( 'Autoincremento', 'incremento', $coluna, [ 'value' => 'S' ] ); ?>
        <?php input_checkbox( 'Chave primária', 'chave', $coluna, [ 'value' => 'S' ] ); ?>
        <?php input_checkbox( 'Nulo', 'nulo', $coluna, [ 'value' => 'S' ] ); ?>

        <hr>
        <button class="btn btn-primary">Salvar</button>
        <a href="<?php echo site_url( 'colunas' ); ?>" class="btn btn-danger">Cancelar</a>
    <?php echo form_close(); ?> 

    <?php $view->component( 'footer' ); ?>
</div>