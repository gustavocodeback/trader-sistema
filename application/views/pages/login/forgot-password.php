<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="text-center col-md-6 col-md-offset-3 logo-content">
        <img    src="<?php echo site_url( 'images/logo_equipe_trader.png' ); ?>" 
                alt="Logo Equipe Trader" class="logo">
        <img    src="<?php echo site_url( 'images/logo_xp.png' ); ?>" 
                alt="Logo XP" class="logo-2">
        </div><!-- logo -->
    </div>
    <div class="row">
        <?php echo form_open( 'login/resetar', [ 'id'=> 'login-form', 'class' => 'col-md-6 col-md-offset-3 z-depth-2 fade-in' ] )?>
            
            <div class="page-header text-center">
                <h1 style="color: #EB0019">Esqueci minha senha</h1>
                <h4 style="color: #EB0019">Informe o e-mail da sua conta para recuperar sua senha</h4>
            </div>

            <?php input_text( false, 'email', false, [ 'class' => 'global', 'placeholder' => 'E-mail', 'length' => 12, 'type' => 'email' ] ); ?>
            
            <?php if ( $view->item( 'error' ) ): ?>
            <div class="alert alert-danger">
                <b>Erro ao logar</b>
                <p><?php echo $view->item( 'error' ); ?></p>
            </div>
            <?php endif; ?>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn pull-right btn-primary btn-lg btn-block">
                        Enviar E-mail de recuperação
                    </button>
                </div>
            </div><!-- boto de login -->
            <br>

            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p>Todos os direitos reservados</p>
                </div>
                <div class="col-md-6 text-right">
                    <a href="<?php echo site_url(); ?>">
                        Voltar para o login
                    </a>
                </div>
            </div>
            <hr>
        <?php echo form_close(); ?><!-- fim do formulario de login -->
    </div>
</div>
