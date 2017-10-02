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
                    <h1>Meus dados</h1>
                    <h4 style="color: #999">Configure os seus dados de cadastro</h4>
                </div>

                <ul class="nav nav-tabs">
                    <li role="presentation" class="active">
                        <a href="#pessoais" aria-controls="social" role="tab" data-toggle="tab">
                            Meus dados pessoais
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#acesso" aria-controls="social" role="tab" data-toggle="tab">
                            Meus dados de acesso
                        </a>
                    </li>
                </ul><!-- seleciona o painel -->

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="pessoais">
                        <?php $view->render( 'meus_dados/meus_dados_pessoais' ); ?>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="acesso">
                        <?php $view->render( 'meus_dados/meus_dados_acesso' ); ?>                        
                    </div>
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