<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if ( is_array( $view->item( 'usuarios') ) && count( $view->item( 'usuarios') > 0 ) ) : ?>
<?php foreach( $view->item( 'usuarios' ) as $usuario ): ?>
<div class="media user-content">
    
    <div class="media-left">
        <a href="#">
            <img class="media-object" src="http://u.o0bc.com/avatars/no-user-image.gif">
        </a>
    </div><!-- avatar -->

    <div class="media-body">
        <div class="row">
            
            <div class="col-sm-4">
                <h5 class="media-heading">
                    <?php echo $usuario->email; ?>
                </h5>
                <?php echo $usuario->nome; ?>
            </div><!-- dados do usuário -->

            <div class="col-sm-8">
                <div class="input-group">
                    <select class="form-control">
                        <option>Atendende</option>
                        <option>Secretária</option>
                        <option>Gerente</option>
                        <option>Administrador</option>
                    </select>
                    <span class="input-group-btn">
                        <button class="btn btn-success" type="button">
                            Enviar convite
                        </button>
                    </span>
                </div>
            </div><!-- niveis de acesso -->

        </div><!-- corpo -->
    </div><!-- corpo -->

</div>
<?php endforeach; ?>
<?php else: ?>
<p>Nenhum resultado encontrado</p>
<?php endif; ?>
<div style="text-align: center; padding-top: 10px;">
    <a onclick="fechar( '#users-loaded', true )" >Fechar busca</a>
</div>