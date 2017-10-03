<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $view->component( 'navbar/navbar' ); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php $view->component( 'aside/aside' ); ?>            
        </div>
        <div class="col-md-8">    
            <div class="container">
                <div class="page-header">
                    <h1>Acesso negado</h1>
                </div>
                <p>Você nāo tem permissāo para executar essa açāo. Contate o administrador do sistema.</p>
            </div>
        </div> 
    </div> 
</div>