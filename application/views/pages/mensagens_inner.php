<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php foreach( $view->item( 'mensagens' ) as $index => $mensagem ):?>
<div class="media chat-bubble <?php echo $mensagem->autor == 'F' ? 'sent' : ''; ?>">
    <div class="media-body">
        <?php if( isset( $mensagem->arquivo ) ) : ?>
        <a class="anexo" target="blank" href="<?php echo site_url( 'mensagens/download/'.$mensagem->CodMensagem ); ?>">
            <span class="glyphicon glyphicon-paperclip"></span> 
            <?php echo $mensagem->label;?>
        </a>
        <?php else : ?>
            <?php echo $mensagem->visualizada == 'N' && $mensagem->autor != 'F' ? '<b>' .$mensagem->texto .'</b>' : $mensagem->texto; ?>
        <?php endif; ?>
        <small style="display: block; margin-top: 10px;">
            <i>Enviado em <?php echo date( 'd/m/Y \à\s H:i', strtotime( $mensagem->dataEnvio ) ); ?>
            <?php if( isset( $mensagem->autor ) && $mensagem->autor == 'F' ) : ?>
            - por <?php echo $view->item( 'funcionario' )->nome; ?>
            <?php else : ?>
            - por <?php echo $view->item( 'cliente' )->nome; ?>
            <?php endif; ?>
            </i>
            <?php if ( $mensagem->visualizada == 'S' && $mensagem->autor == 'F' ): ?>
            <span class="pull-right">
                Visualizado <span class="glyphicon glyphicon-ok"></span>                            
            </span>  
            <?php endif; ?>
        </small>
    </div>
</div>            
<?php if( $mensagem->autor == 'C' && $mensagem->visualizada == 'N' ) $mensagem->lerMensagem(); ?>
<?php endforeach; ?>
          