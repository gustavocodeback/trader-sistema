<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $itens = $view->item( 'historicos' ); ?>
<?php if ( !$itens || count( $itens ) == 0 ): ?>
<p>Nenhuma interação com o cliente</p>
<?php else: ?>
<ul class="timeline text-center">
    
    <?php foreach( $itens as $item ): ?>
    <li <?php echo $item->sistema == 1 ? 'class="timeline-inverted"' : ''; ?>>
        <div class="timeline-badge danger">
            <!-- <i class="glyphicon glyphicon-pencil"></i> -->
        </div>
        <div class="timeline-panel">
            <div class="timeline-heading">
                <h4 class="timeline-title">
                    <?= $item->titulo ?>
                </h4>
                <p>
                    <small class="text-muted">
                        <i class="glyphicon glyphicon-time"></i> 
                        Em <?= date( 'H:i:s d-m-Y', strtotime( $item->data ) );?>
                    </small>
                </p>
            </div>
            <div class="timeline-body">
                <p>
                    <?= $item->texto ?>
                </p>
            </div>
        </div>
    </li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>