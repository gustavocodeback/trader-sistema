<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $user = $view->item( 'user' ); ?>
<?php $view->component( 'navbar/navbar' ); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php $view->component( 'aside/aside' ); ?>            
        </div>
        <div class="col-md-10">    
            <?php echo form_open_multipart( 'meus_dados/salvar_meus_dados' )?>
                <div class="page-header">
                    <h2 style="color: #EB0019">Meus dados</h2>
                </div>

                <div class="row">
                    
                    <?php print_key( $user ); ?>
                    <div class="col-md-4">
                        <label for="foto" class="well col-md-offset-1  col-md-9">
                            <center>
                                
                                <?php if( $user && isset( $user->foto ) ): ?>
                                <img src="<?php echo base_url( 'uploads/'.$user->foto )?>" class="img-thumbnail" style="width: 150px; height: 150px;">  
                                <h3 style="color: #999">Alterar foto</h3>
                                <?php else : ?>
                                <h1>
                                    <span class="glyphicon glyphicon-camera"></span>
                                </h1>
                                <h3 style="color: #999">Adicionar foto</h3>
                                <?php endif; ?>
                            </center>
                        </label>
                        <input type="file" id="foto" name="foto">
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="form-group">
                                <label for="nome" style="color: #999">Nome</label>
                                <input  type="text" 
                                        class="form-control" 
                                        id="nome" 
                                        name="nome" 
                                        required
                                        value="<?php echo $user->nome; ?>"
                                        placeholder="Carlos Cliente">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label for="email" style="color: #999">E-mail</label>
                                <input  type="email" 
                                        class="form-control" 
                                        id="email" 
                                        name="email"
                                        required
                                        value="<?php echo $user->email; ?>"                                    
                                        placeholder="email@email.com">
                            </div>
                        </div>
                        <div class="row">
                            <button type="button"
                                    class="btn btn-warning pull-right"
                                    onclick="exibir('#TrocaSenha')" >
                                    Trocar Senha
                            </button>
                        </div>
                    </div>
                </div>
                <hr>

                <div id="TrocaSenha" class="hidden"> 
                    <div class="row">    
                        <div class="col-md-offset-2 col-md-2">
                            <div class="form-group">
                                <label for="senhaAtual" style="color: #999">Senha atual</label>
                                <input  type="password" 
                                        class="form-control" 
                                        id="senhaAtual" 
                                        name="senhaAtual" 
                                        placeholder="******">
                            </div>
                        </div><!-- senha -->

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="novaSenha" style="color: #999">Nova senha</label>
                                <input  type="password" 
                                        class="form-control" 
                                        id="novaSenha" 
                                        name="novaSenha" 
                                        placeholder="******">
                            </div>
                        </div><!-- senha -->
                
                        <div class="col-md-2">
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
                                    onclick="esconder( '#TrocaSenha', [ '#senhaAtual', '#novaSenha', '#confirmaSenha' ] )" >
                                    Cancelar
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <hr class="col-md-12">
                    </div>
                </div>
                
                <?php if ( $view->item( 'errors' ) ): ?>
                <div class="row">
                    <div class="col-md-offset-2 col-md-6">
                        <div class="alert alert-danger">
                            <b>Erro</b>
                            <p><?php echo $view->item( 'errors' );  ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-9">
                        <button class="btn btn-primary pull-right">Salvar</button>                                            
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <br>
                    </div>
                </div>
            <?php echo form_close(); ?> 
        </div>
    </div>  
</div>
