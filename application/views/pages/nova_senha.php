<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $funcionario = $view->item( 'funcionario' ); ?>
<?php $cliente = $view->item( 'cliente' ); ?>
<?php if( $funcionario ) $url = 'recovery/salvar_recovery'; ?>
<?php if( $cliente ) $url = 'recovery/salvar_recovery_cliente'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="left-panel col-md-6">
            <?php echo form_open( $url, [ 'class' => 'col-md-9 col-md-offset-1 fade-in' ] )?>
                <input type="hidden" name="funcionario" value="<?php echo $funcionario; ?>">
                <input type="hidden" name="cliente" value="<?php echo $cliente; ?>">

                <div class="page-header">
                    <h2>Recuperar senha!</h2>
                </div>

                <hr>
                
                <?php if ( $view->item( 'success' ) ): ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success">
                            <strong>Sucesso!</strong>
                            <p>
                                <?php echo $view->item( 'success' ); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php else: ?>

                <div class="row">
                    <div class="col-md-12">
                        <p class="p">
                            Digite seu e-mail e uma nova senha
                        </p>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input  type="email" 
                                    class="form-control" 
                                    id="email" 
                                    name="email" 
                                    required
                                    placeholder="seu@email.com">
                        </div>
                    </div>
                </div><!-- email -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="novaSenha">Nova Senha</label>
                            <input  type="password" 
                                    class="form-control" 
                                    id="novaSenha" 
                                    name="novaSenha" 
                                    required
                                    placeholder="******">
                        </div>
                    </div>
                </div><!-- nova senha -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="confirmaSenha">Confirma Nova Senha</label>
                            <input  type="password" 
                                    class="form-control" 
                                    id="confirmaSenha" 
                                    name="confirmaSenha" 
                                    required
                                    placeholder="******">
                        </div>
                    </div>
                </div><!-- confirma nova senha -->

                <?php if( $view->item( 'errors' ) ): ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            <b>Erro ao salvar</b>
                            <p><?php echo $view->item( 'errors' ); ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <hr>
                <button class="btn btn-primary btn-lg btn-block">
                    Salvar Senha
                </button>
                <?php endif; ?>
            <?php echo form_close(); ?> 
        </div>
        <div class="right-panel col-md-6 hidden-xs"></div>
    </div>
</div>