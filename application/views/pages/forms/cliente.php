<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $cliente = $view->item( 'cliente' ); ?>
<?php $editFunc = $view->item( 'edit_func' ) ? true : false; ?>
<?php $view->component( 'navbar/navbar' ); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php $view->component( 'aside/aside' ); ?>            
        </div>
        <div class="col-md-8">           
        <?php echo form_open( 'clientes/salvar', [ 'class' => 'card container fade-in' ] )?> 
            <div class="page-header">
                <h2>Novo cliente</h2>
            </div>
            
            <?php print_key( $cliente ); ?>
            <?php input_text( 'Nome', 'nome', $cliente, [ 'type' => 'text', 'onclick' => 'teste()' ] ); ?>
            <?php input_text( 'Telefone', 'tel', $cliente, [ 'type' => 'text' ] ); ?>
            <?php input_text( 'Código XP', 'xp', $cliente, [ 'type' => 'text' ] ); ?>
            <?php input_text( 'E-mail', 'email', $cliente, [ 'type' => 'email' ] ); ?>
            <?php if( !$cliente ) : ?>
                <?php input_text( 'Senha', 'senha', $cliente, [ 'type' => 'password' ] ); ?>
                <?php input_text( 'Confirmação de senha', 'confirma', false, [ 'type' => 'password' ] ); ?>
            <?php endif; ?>
            <?php if( $editFunc ) : $attS = [ 'readonly' => 'readonly' ]; ?>
            <?php else : $attS = [ 'onchange' => 'atualizarSelect( "#funcionario", "funcionarios/obter_funcionarios_segmento", $( this ) )' ]; ?>
            <?php endif; ?>
            <?php select( 'Segmento', 'segmento', $attS );?>
                <?php if( !$editFunc ) option(); ?>
                <?php if ( $view->item( 'segmentos' ) ):?>
                    <?php foreach( $view->item( 'segmentos' ) as $item ): ?>
                        <?php option( $item->CodSegmento, $item->nome, $view->item( 'assessor' ), 'segmento' ); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endselect( 'Segmento' ); ?><!-- seta o status do cadastro -->
            <?php if( $view->item( 'assessores' ) && $editFunc ) : $att = [ 'readonly' => 'readonly' ]; ?>
            <?php elseif( $view->item( 'assessores' ) ) : $att = []; ?>
            <?php else : $att = [ 'disabled' => 'disabled' ]; ?>
            <?php endif; ?>
            <?php select( 'Assessor', 'funcionario', $att );?>
                <?php if( !( $view->item( 'assessores' ) && $editFunc ) ) option(); ?>
                <?php if ( $view->item( 'assessores' ) ):?>
                    <?php foreach( $view->item( 'assessores' ) as $item ): ?>
                        <?php option( $item->CodFuncionario, $item->nome, $cliente, 'funcionario' ); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endselect( 'Assessor' ); ?><!-- seta o status do cadastro -->

            <?php select( 'Atributo de segmento', 'atributoSeg' );?>
                <?php option(); ?>

                <?php option( 'T', 'Trader', $cliente, 'atributoSeg' ); ?>
                <?php option( 'I', 'Inativo', $cliente, 'atributoSeg' ); ?>
            <?php endselect( 'Atributo de segmento' ); ?><!-- seta o status do cadastro -->

            <?php select( 'Tags', 'tag', $view->item( 'tags' ) ? [] : [ 'disabled' => 'disabled' ] );?>
                <?php option(); ?>
                <?php if ( $view->item( 'tags' ) ):?>
                    <?php foreach( $view->item( 'tags' ) as $item ): ?>
                        <?php option( $item->CodTag, $item->descricao, $view->item( 'tag' ), 'CodTag' ); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endselect( 'Tags' ); ?><!-- seta as tags -->

            <?php if( $cliente ) : ?>
            <div class="row">
                <div class="col-xs-12">
                    <button type="button"
                            class="btn btn-warning"
                            id="btnTroca"
                            onclick="exibir('#TrocaSenha', '#btnTroca')" >
                            Trocar Senha
                    </button>
                </div>
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
                    <div class="col-md-6">
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
                
            <button class="btn btn-primary">Salvar</button>
            <a href="<?php echo site_url( 'clientes' ); ?>" class="btn btn-danger">Cancelar</a>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>
<br>