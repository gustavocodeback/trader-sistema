<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $funcionario = $view->item( 'funcionario' ); ?>
<?php $view->component( 'navbar/navbar' ); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php $view->component( 'aside/aside' ); ?>            
        </div>
        <div class="col-md-8">           

        <?php echo form_open( 'funcionarios/salvar', [ 'class' => 'card container fade-in' ] )?>      
            <div class="page-header">
                <h2>Novo Funcionário</h2>
            </div>
            
            <?php print_key( $funcionario ); ?>
            <?php input_text( 'Nome', 'nome', $funcionario, [ 'type' => 'text' ] ); ?>
            <?php input_text( 'Telefone', 'tel', $funcionario, [ 'type' => 'tel' ] ); ?>
            <?php input_text( 'E-mail', 'email', $funcionario, [ 'type' => 'email' ] ); ?>
            <?php if( !$funcionario ) : ?>
                <?php input_text( 'Senha', 'senha', $funcionario, [ 'type' => 'password' ] ); ?>
                <?php input_text( 'Confirmação de senha', 'confirma', false, [ 'type' => 'password' ] ); ?>
            <?php endif; ?>
            <?php select( 'Segmento', 'segmento' );?>
                <?php option(); ?>
                <?php if ( $view->item( 'segmentos' ) ):?>
                    <?php foreach( $view->item( 'segmentos' ) as $item ): ?>
                        <?php option( $item->CodSegmento, $item->nome, $funcionario, 'segmento' ); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endselect( 'Segmento' ); ?><!-- select de estados -->

            <?php select( 'Grupo', 'gid' );?>
                <?php option(); ?>
                <?php if ( $view->item( 'grupos' ) ):?>
                    <?php foreach( $view->item( 'grupos' ) as $item ): ?>
                        <?php option( $item->gid, $item->grupo, $funcionario, 'gid' ); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endselect( 'Grupo' ); ?><!-- select de estados -->
             <div class="row">
                <hr>
            </div>
            <?php if( $funcionario ) : ?>
            <div class="row">
                <button type="button"
                        class="btn btn-warning"
                        id="btnTroca"
                        onclick="exibir('#TrocaSenha', '#btnTroca')" >
                        Trocar Senha
                </button>
            </div>
            <br>
            <div id="TrocaSenha" class="hidden"> 
                <div class="row">    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="novaSenha" style="color: #999">Nova senha</label>
                            <input  type="password" 
                                    class="form-control" 
                                    id="novaSenha" 
                                    name="novaSenha" 
                                    placeholder="******">
                        </div>
                    </div><!-- senha -->
            
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="confirmaSenha" style="color: #999">Confirmar nova senha</label>
                            <input  type="password" 
                                    class="form-control" 
                                    id="confirmaSenha" 
                                    name="confirmaSenha" 
                                    placeholder="******">
                        </div>
                    </div><!-- senha -->
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <button type="button"
                                class="btn btn-warning pull-right"
                                onclick="esconder( '#TrocaSenha', [ '#senhaAtual', '#novaSenha', '#confirmaSenha' ], '#btnTroca'  )" >
                                Cancelar
                        </button>
                    </div>
                </div>
                <div class="row">
                    <hr class="col-md-12">
                </div>
            </div>
            <?php endif; ?>
            <br>

            <?php print_alert( 'danger', 'Erro', $view->item( 'errors' ) ); ?>

            <hr>
            <button class="btn btn-primary">Salvar</button>
            <a href="<?php echo site_url( 'funcionarios' ); ?>" class="btn btn-danger">Cancelar</a>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>