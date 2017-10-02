<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $usuario = $view->item( 'usuario' ); ?>
<?php $view->component( 'aside' ); ?>
<div id="wrapper" class="wrapper show">
    <?php $view->component( 'navbar' ); ?>

    <?php echo form_open( 'usuarios/salvar', [ 'class' => 'card container fade-in' ] )?>
        <?php $view->component( 'breadcrumb' ); ?>        
        <div class="page-header">
            <h2>Novo usuário</h2>
        </div>
        
        <?php print_key( $usuario ); ?>
        <?php input_text( 'E-mail', 'email', $usuario, [ 'type' => 'email' ] ); ?>
        <?php input_text( 'Senha', 'senha', $usuario, [ 'type' => 'password' ] ); ?>
        <?php select( 'Grupo', 'grupo' );?>
            <?php option(); ?>
            <?php if ( $view->item( 'grupos' ) ):?>
                <?php foreach( $view->item( 'grupos' ) as $item ): ?>
                    <?php option( $item->gid, $item->grupo, $usuario, 'gid' ); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endselect( 'Grupo' ); ?><!-- select de estados -->

        <?php print_alert( 'danger', 'Erro', $view->item( 'errors' ) ); ?>

        <hr>
        <button class="btn btn-primary">Salvar</button>
        <a href="<?php echo site_url( 'usuarios' ); ?>" class="btn btn-danger">Cancelar</a>
    <?php echo form_close(); ?>

    <?php $view->component( 'footer' ); ?>
</div>