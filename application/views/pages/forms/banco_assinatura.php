<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $assinatura = $view->item( 'assinatura' ); ?>
<?php $view->component( 'aside' ); ?>
<div id="wrapper" class="wrapper show">
    <?php $view->component( 'navbar' ); ?>

    <div class='card container fade-in'>
        <?php $view->component( 'breadcrumb' ); ?>        
        <div class="page-header">
            <h2>Configuracoes do banco de dados</h2>
        </div>

        <div class="row">
            <div class="col-md-12">
                <i>Nenhum banco de dados escolhido</i>
                <hr>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#home" aria-controls="home" role="tab" data-toggle="tab">
                            Novo banco
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">
                            Usar banco existente
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content" style="background: white; padding: 20px; border: 1px solid #ccc; border-top: 0px;">
                    
                    <div id="home" role="tabpanel" class="tab-pane active">
                        <?php echo form_open( 'assinaturas/gerar_bd/'.$assinatura->CodAssinatura )?>

                            <?php if( $view->item( 'esquemas' ) ): ?>
                            <?php select( 'Esquema', 'esquema' );?>
                                <?php option(); ?>
                                <?php foreach( $view->item( 'esquemas' ) as $item ): ?>
                                <?php option( $item->CodEsquema, $item->esquema ); ?>
                                <?php endforeach; ?>
                            <?php endselect( 'Esquema', true ); ?><!-- select de estados -->
                            <?php endif; ?>

                            <?php input_checkbox( 'Apagar bancos antigos', 'apagar-pane-1', false, [ 'value' => 'apagar'] ); ?>
                            <button type="submit" class="btn btn-primary">
                                Gerar novo banco de dados
                            </button>
                        <?php echo form_close(); ?>
                    </div><!-- formulario novo banco -->

                    <div id="profile" class="tab-pane">
                        <?php echo form_open( 'assinaturas/salvar' )?>                    
                            <?php if( $view->item( 'bancos' ) ): ?>
                            <?php select( 'Banco', 'banco' );?>
                                <?php option(); ?>
                                <?php foreach( $view->item( 'bancos' ) as $item ): ?>
                                <?php option( $item->CodBanco, $item->nome ); ?>
                                <?php endforeach; ?>
                            <?php endselect( 'Banco', true ); ?><!-- select de estados -->
                            <?php input_checkbox( 'Apagar bancos antigos', 'apagar-pane-2', false, [ 'value' => 'apagar'] ); ?>
                            <a href="<?php echo site_url( 'assinaturas/gerar_bd/'.$assinatura->CodAssinatura ); ?>" class="btn btn-primary">
                                Usar banco de dados
                            </a>
                            <?php else: ?>
                            <i>Esse cliente ainda nao possui nenhum banco</i>
                            <?php endif; ?>  
                        <?php echo form_close(); ?>
                    </div><!-- formulario usar banco -->

                </div>
            </div>
        </div>
        
    </div>

    <?php $view->component( 'footer' ); ?>
</div>