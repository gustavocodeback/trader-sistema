<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="text-center col-md-6 col-md-offset-3 logo-content">
            <img    src="<?php echo site_url( 'images/logo_equipe_trader.png' ); ?>" 
            alt="Logo Equipe Trader">
            <img    src="<?php echo site_url( 'images/logo_xp.png' ); ?>" 
                    alt="Logo XP">
        </div><!-- logo -->
    </div>
    <div class="row">
        <?php echo form_open( 'login/nova_conta', [ 'id'=> 'login-form', 'class' => 'col-md-6 col-md-offset-3 z-depth-2 fade-in' ] )?>
            
            <div class="page-header text-center">
                <h1 style="color: #EB0019">Crie uma conta</h1>

                <h4 style="color: #EB0019">E tenha acesso aos serviços da Equipe Trader</h4>
            </div>

            <?php input_text( 'Nome', 'nome', false,    [ 'class' => 'global', 'display_label' => false, 'placeholder' => 'Nome', 'length' => 12 ] ); ?>
            <?php input_text( 'E-mail', 'email', false, [ 'class' => 'global', 'display_label' => false, 'placeholder' => 'E-mail', 'length' => 12, 'type' => 'email' ] ); ?>
            <?php input_text( 'Senha', 'senha', false,  [ 'class' => 'global', 'display_label' => false, 'placeholder' => 'Senha', 'length' => 12, 'type' => 'password' ] ); ?>
            <?php input_text( 'Confirmação de senha', 'confirma', false, [ 'class' => 'global', 'display_label' => false,'placeholder' => 'Digite a senha novamente', 'length' => 12, 'type' => 'password' ] ); ?>

            <hr>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn pull-right btn-primary btn-lg btn-block">
                        Criar nova conta
                    </button>
                </div>
            </div><!-- boto de login -->
            <br>
            <div class="row hidden">
                <div class="col-md-4">
                    <button class="btn btn-block btn-primary">
                        Facebook
                    </button>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-block btn-danger">
                        Google
                    </button>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-block btn-info">
                        Twitter
                    </button>
                </div>
            </div><!-- login com as redes sociais -->
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
