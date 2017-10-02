<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php

/**
 * printItem
 *
 * imprime o item da coluna esquerda
 *
 */
function printItem( $text, $link, $actual, $index ) {

    // seta a classe
    $cl = $index == $actual ? 'active' : '';

    // imprime o item
    echo "<a href='".site_url( $link )."' class='list-group-item $cl'>$text</a>";    
}

// seta o indice selecionado
$index = $view->item( 'aside-index' );

?>
<div class="aside row fade-in">
    <div class="col-md-12">

        <img src="<?php echo $user->foto ? base_url( 'uploads/'.$user->foto ) : 'http://u.o0bc.com/avatars/no-user-image.gif'; ?>"  class="img thumbnail perfil">

    </div>
    <div class="col-md-12" style="margin-top: -20px;">
        <h4><?php echo $user->nome; ?></h4>
        <h6><?php echo $user->email; ?></h6>
    </div>
    <div class="col-md-12">
        <div class="aside-header"></div>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php foreach( $view->getMenu() as $item ): ?>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading<?php echo $item['Nome']; ?>">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $item['Nome']; ?>" aria-expanded="true" aria-controls="collapse<?php echo $item['Nome']; ?>">
            <span class="glyphicon glyphicon-<?php echo $item['Icone']; ?>"></span> &nbsp; <?php echo $item['Nome']; ?>
            </a>
        </h4>
        </div>
        <div id="collapse<?php echo $item['Nome']; ?>" class="panel-collapse collapse <?php echo $item['active'] ? 'in' : ''; ?>" role="tabpanel" aria-labelledby="heading<?php echo $item['Nome']; ?>">
            <ul class="list-group">
                <?php foreach( $item['rotinas'] as $rotina ): ?>
                <a href="<?php echo site_url( $rotina['Link'] ); ?>" class="list-group-item"><?php echo $rotina['Rotina']?></a>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php endforeach; ?>
    </div>
    </div>
    <hr>
</div>