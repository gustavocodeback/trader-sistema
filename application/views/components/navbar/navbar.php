<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * printItem
 *
 * imprime o item da coluna esquerda
 *
 */
function printItemNavbar( $text, $link, $actual, $index ) {

    // seta a classe
    $cl = $index == $actual ? 'active' : '';

    // imprime o item
    echo "<a href='".site_url( $link )."' class='nav-link $cl'>$text</a>";    
}

// seta o indice selecionado
$index = $view->item( 'navbar-index' );

?>
<div id="navbar" class="z-depth-1">
  <div class="line container">
    <div class="row">

      <div class="right-content pull-right">
        
        <a href='<?php echo site_url(); ?>' class="btn" role="button">          
          <span class="glyphicon glyphicon-home"></span>
        </a>


        <button class="btn" data-toggle="tooltip" data-placement="bottom" title="Notificações Equipe Trader">

          <span class="glyphicon glyphicon-globe"></span>
        </button><!-- botao de notificacoes -->

        <div class="dropdown pull-right">
          <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <img src="<?php echo $user->foto ? base_url( 'uploads/'.$user->foto ) : base_url( 'images/no-user-image.gif' ); ?>" width="30px">
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li>
              <a href="<?php echo site_url( 'meus_dados' ); ?>">Meus dados</a>
            </li>
            <li role="separator" class="divider"></li>
            <li>
              <a href="<?php echo site_url( 'home/logout' ); ?>">
                Sair
              </a>
            </li>
          </ul>
        </div><!-- botao de ações do usuário -->

      </div>

      <div class="clearfix"></div>
    </div>
  </div><!-- linha superior -->
</div>