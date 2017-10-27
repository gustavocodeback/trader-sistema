<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">

    <div class="row teste">
        <?php echo form_open( 'login/logar', [ 'id'=> 'login-form', 'class' => 'col-md-6 col-md-offset-3 z-depth-2 fade-in' ] )?>
            
            <div class="page-header text-center">
                <div class="row">
                    <div class="text-center logo-content">
                        <img    src="<?php echo site_url( 'images/logo_equipe_trader.png' ); ?>" 
                                alt="Logo Equipe Trader" class="logo">
                        <img    src="<?php echo site_url( 'images/logo_xp.png' ); ?>" 
                                alt="Logo XP" class="logo-2">
                    </div><!-- logo -->
                </div>
                <div class="row">
                    <h4>Entre com a sua conta Trader</h4>
                </div>
            </div>

            <?php input_text( false, 'email', false, [ 'class' => 'global', 'required' => 'required', 'placeholder' => 'E-mail', 'length' => 12, 'type' => 'email' ] ); ?>
            <?php input_text( false, 'senha', false, [ 'class' => 'global', 'required' => 'required', 'placeholder' => 'Senha', 'length' => 12, 'type' => 'password' ] ); ?>
            
            <?php if ( $view->item( 'error' ) ): ?>
            <div class="alert alert-danger">
                <b>Erro ao logar</b>
                <p><?php echo $view->item( 'error' ); ?></p>
            </div>
            <?php endif; ?>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <a href="<?php echo site_url( 'login/forgot_password' ); ?>">Esqueci minha senha</a>                   
                </div>
            </div><!-- esqueci minha senha -->
            <hr>            
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn pull-right btn-primary btn-lg btn-block">
                        Entrar
                    </button>
                </div>
            </div><!-- boto de login -->
            <br>
        <?php echo form_close(); ?><!-- fim do formulario de login -->
    </div>
</div>
