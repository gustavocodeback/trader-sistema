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
<div class="aside row ">

    <div class="row hide-button">
        <div class="col-xs-12 text-right">
            <span style="font-size: 20px; margin: 5px;" onclick="toggleSidebar()">
                <span class="glyphicon glyphicon-remove"></span>
            </span>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-3">
            <img src="<?php echo $user->avatar() ?>"  class="img perfil">
        </div><!-- foto -->
        <div class="col-xs-9">
            <b><?php echo $user->nome; ?></b>
            <small><?php echo $user->email; ?></small>
        </div><!-- dados do usuario -->
    </div>
    <br>
    <div class="divider"></div>
    <br>
    <div class="row">
        <div class="col-md-12">
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
    </div>
</div><!-- fim do aside -->