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
                    <h1>Meus créditos</h1>
                    <h4 style="color: #999">Acompanhe seu consume e adicione novos créditos</h4>
                </div>

                <ul class="nav nav-tabs">
                    <li role="presentation" class="active">
                        <a href="#">Adicionar mais créditos</a>
                    </li>
                    <li role="presentation">
                        <a href="#">Meu consumo</a>
                    </li>
                </ul><!-- seleciona o painel -->

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