<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $view->component( 'navbar/navbar' ); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-offset-1 col-md-2">
            <?php $view->component( 'aside/aside' ); ?>            
        </div>
        <div class="col-md-8" style="padding-top: 30px;">
            <div class="card-content">
                <div class="page-header text-center">
                    <?php print_icon( 'store', '100px' ); ?>
                    <h1>Minha loja</h1>
                    <h4 style="color: #999">Cadastre sua loja no nosso sistema</h4>
                </div>

                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#home" aria-controls="home" role="tab" data-toggle="tab">
                            Dados da loja
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">
                            Dados de endereço
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">
                            Dados de funcionamento
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#social" aria-controls="social" role="tab" data-toggle="tab">
                            Contatos e Social
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">
                            Fotos e vídeos
                        </a>
                    </li>
                </ul><!-- tabs de navegação -->

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <?php $view->render( 'minha_loja/form_loja' ); ?>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">
                        <?php $view->render( 'minha_loja/form_endereco' ); ?>                        
                    </div>
                    <div role="tabpanel" class="tab-pane" id="messages">
                        <?php $view->render( 'minha_loja/form_funcionamento' ); ?>  
                    </div>
                    <div role="tabpanel" class="tab-pane" id="social">...</div>
                    <div role="tabpanel" class="tab-pane" id="settings">...</div>
                </div><!-- conteudo das tabs -->

                <div class="clearfix"></div>
                <hr>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <i class="text-muted">Todos os direitos reservados</i>                        
                    </div>
                </div><!-- termos e condicoes -->
            </div>
        </div>
    </div>
</div>

<div id="footer">
    <div class="container">
        <button class="btn btn-success btn-lg">
            Salvar minha loja
        </button>
    </div>
</div>