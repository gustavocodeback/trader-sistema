<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $view->component( 'navbar/navbar' ); ?>
<div class="container-fluid fade-in">
    <div class="row">
        <div class="col-md-offset-1 col-md-2">
            <?php $view->component( 'aside/aside' ); ?>            
        </div>
        <div class="col-md-8" style="padding-top: 30px;">
            <div class="card-content">
                
                <div class="row">
                    <?php echo form_open( 'acessos/busca', [ 'onsubmit' => 'return carregarUsuarios()', 'class' => 'col-md-12' ] )?>
                        <div class="input-group">
                            <input  type="email" 
                                    class="form-control global" 
                                    required
                                    id="email"
                                    placeholder="Encontrar usuários ...">
                            <span class="input-group-btn">
                                <button class="btn btn-primary btn-lg" type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    <?php echo form_close(); ?>
                </div><!-- input de pesquisa -->

                <div id="users-loading" class="row loading-spinner hidden">
                    <div class="col-md-12">
                        <img src="<?php echo base_url( 'images/icons/loading.gif' ); ?>">
                    </div>
                </div><!-- loading -->

                <div id="users-loaded" class="users-content hidden"></div><!-- usuários encontrados -->

                <div class="page-header">
                    <h4>Usuários com acesso na sua conta</h4>
                </div><!-- dados -->

                <p>Nenhum usuário encontrado</p>

            </div>
        </div>
    </div>
</div>
