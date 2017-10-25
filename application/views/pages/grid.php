<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $finder = $view->item( 'finder' ); ?>
<?php $view->component( 'navbar/navbar' ); ?>
<?php $view->item( 'success' ) ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php $view->component( 'aside/aside' ); ?>            
        </div>
        <div class="col-md-8">            

            <div class="container">
                <div class="page-header">
                    <h2><?php echo $this->view->item('entity'); ?></h2>
                </div>     
                <div class="row fade-in">
                    <div class="col-md-12">
                        <?php $view->component( 'filters' ); ?>
                    </div>
                 </div>
                <?php if ( $view->item( 'add_url' ) || $view->item( 'send_url' ) || $view->item( 'hist_url' ) || $view->item( 'import_url' ) ): ?>
                <div class="row margin fade-in">
                    <div class="col-md-12">
                        <?php if( $view->item( 'add_url' ) ) : ?>
                            <div class="inline-block-button">
                                <a href="<?php echo $view->item( 'add_url' ); ?>" class="btn btn-primary z-depth-2">Adicionar</a> 
                            </div>
                        <?php endif; ?>                    
                        <?php if( $view->item( 'import_url' ) ) : ?>
                            <?php echo form_open_multipart( $view->item( 'import_url' ), [  'id' => 'import-form'] ); ?>
                                <input  id="planilha" 
                                        name="planilha" 
                                        onchange="importarPlanilha( $( this ) )" 
                                        class="planilha hidden" 
                                        type="file">
                                <label for="planilha" class="btn btn-primary z-depth-2">
                                    Importar planilha
                                </label> 
                            <?php echo form_close(); ?>
                        <?php endif; ?>
                        <?php if ( $view->item( 'send_url' ) ): ?>
                            <div class="inline-block-button">
                                <a href="<?php echo $view->item( 'send_url' ); ?>" class="btn btn-primary z-depth-2">Disparar</a> 
                            </div>
                        <?php endif; ?>
                    
                        <?php if ( $view->item( 'hist_url' ) ): ?>
                            <div class="inline-block-button">
                                <a href="<?php echo $view->item( 'hist_url' ); ?>" class="btn btn-primary z-depth-2">Histórico</a> 
                            </div>
                        <?php endif; ?>
                        <div class="col-md-12"><hr></div>
                    </div>
                </div>
                <?php endif; ?> 
                
                <div class="row fade-in">
                    <div class="col-md-12">
                        <?php $view->component( 'table' ); ?>            
                    </div>
                </div>  
            </div>     
        </div>
    </div>
</div>

<style>
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
    <?php $cont = 1; ?>
    <?php foreach( $view->getHeader( 'grid' ) as $row ): ?>
    td:nth-of-type(<?php echo $cont; ?>):before { content: "<?php echo $finder->getLabel( $row ); ?>"; }
    <?php $cont++;?>    
    <?php endforeach;?>
}
</style>