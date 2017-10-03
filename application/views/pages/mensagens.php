<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    var Cliente = '<?php echo $view->item( 'cliente' )->CodCliente; ?>';
    var mensagens = '<?php echo count( $view->item( 'mensagens' ) ); ?>';
</script>
<?php $view->component( 'navbar/navbar' ); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php $view->component( 'aside/aside' ); ?>            
        </div>
        <div class="col-md-10">     

            <div class="page-header">
                <h3>
                    Cliente: <?php echo $view->item( 'cliente' )->nome; ?>
                </h3>
            </div><!-- cabecalho -->

            <div id="mensagens" class="mensagens-wrapper col-md-12">

                <?php foreach( $view->item( 'mensagens' ) as $index => $mensagem ):?>
                <div class="media chat-bubble <?php echo $mensagem->funcionario ? 'sent' : ''; ?>">
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
                            <i>Enviado em <?php echo date( 'd/m/Y \à\s H:i' ); ?>
                            <?php if( isset( $mensagem->autor ) && $mensagem->autor == 'F' ) : ?>
                            - por <?php echo $view->item( 'funcionario' )->nome; ?>
                            <?php else : ?>
                            - por <?php echo $view->item( 'cliente' )->nome; ?>
                            <?php endif; ?>
                            </i>
                            <?php if ( $mensagem->visualizada == 'S' ): ?>
                            <span class="pull-right">
                                Visualizado <span class="glyphicon glyphicon-ok"></span>                            
                            </span>  
                            <?php endif; ?>
                        </small>
                    </div>
                </div>            
                <?php if( $mensagem->autor == 'C' && $mensagem->visualizada == 'N' ) $mensagem->lerMensagem(); ?>
                <?php endforeach; ?>
            </div>
        
            <?php echo form_open( 'mensagens/enviar_mensagem', [ 'class' => 'mensagem-footer' ] ); ?>

                <input type="hidden" value="<?php echo $view->item( 'cliente' )->CodCliente; ?>" name="cliente">

                <div class="files-content"></div><!-- arquivos anexados -->
                
                <div class="text-content">
                    <textarea class="form-control" name="texto" rows="3" placeholder="Digite uma mensagem" required></textarea>
                </div><!-- textarea da mensagem -->

                <div id="alert-wrapper" class="col-md-12 hidden">
                    <div class="alert alert-danger"></div>            
                </div><!-- erros no upload -->

                <div class="files-inputs"></div>

                <div class="tools">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="file" class="hidden" id="input-anexo" name="input-anexo">
                            <label id="anexo-label" for="input-anexo" class="btn btn-warning">
                                <span class="glyphicon glyphicon-paperclip"></span> Anexar arquivo
                            </label> 
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </div>
                </div><!-- formulario de nova mensagem -->
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<div id="file-wrapper-template" class="file-wrapper hidden">
    <span class="glyphicon glyphicon-file file-icon"></span>
    <span class="file-name">meu_arqaaaaaaaaaaaauivo.pdf</span>
    <div class="progress-wrapper">
        <progress max="100" value="0"></progress>
    </div>
    <div class="action">
        <span class="remover-arquivo" onclick="removerArquivo( $( this ) )">
            <span class="glyphicon glyphicon-remove"></span> remover
        </span>
    </div>
</div><!-- file wrapper -->