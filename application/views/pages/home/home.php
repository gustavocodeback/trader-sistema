<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $view->component( 'navbar/navbar' ); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php $view->component( 'aside/aside' ); ?>            
        </div>
        <div class="col-md-9">
            <div class="row"><br></div>
        <div class="row">
            
            <div class="col-md-3">
                <div class="panel panel-default panel-default">
                    <div class="panel-heading">
                        <h1 class="text-center">
                            <span class="glyphicon glyphicon-briefcase"></span>
                        </h1>
                        <h1 class="text-center">
                            <?php echo $view->item( 'num_clientes_geral' ); ?>
                        </h1>
                        <h4 class="text-center">Clientes</h4>
                        <h6 class="text-center">Total de clientes</h6>
                    </div>
                </div>
            </div><!-- num funcionarios -->

            <div class="col-md-3">
                <div class="panel panel-default panel-default">
                    <div class="panel-heading">
                        <h1 class="text-center">
                            <span class="glyphicon glyphicon-briefcase"></span>
                        </h1>
                        <h1 class="text-center">
                            <?php echo $view->item( 'num_clientes_trader' ); ?>
                        </h1>
                        <h4 class="text-center">Clientes</h4>
                        <h6 class="text-center">Total de clientes Trader</h6>
                    </div>
                </div>
            </div><!-- num funcionarios -->
            
            <div class="col-md-3">
                <div class="panel panel-default panel-default">
                    <div class="panel-heading">
                        <h1 class="text-center">
                            <span class="glyphicon glyphicon-user"></span>
                        </h1>
                        <h1 class="text-center">
                            <?php echo $view->item( 'num_clientes_inativo' ); ?>
                        </h1>
                        <h4 class="text-center">Clientes</h4>
                        <h6 class="text-center">Total de clientes Inativos</h6>
                    </div>
                </div>
            </div><!-- num funcionarios -->

            <div class="col-md-3">
                <div class="panel panel-default panel-info">
                    <div class="panel-heading">
                        <h1 class="text-center">
                            <span class="glyphicon glyphicon-user"></span>
                        </h1>
                        <h1 class="text-center">
                            <?php echo $view->item( 'num_mensagens_new' ); ?>
                        </h1>
                        <h4 class="text-center">Mensagens</h4>
                        <h6 class="text-center">Total de mensagens não lidas</h6>
                    </div>
                </div>
            </div><!-- num funcionarios -->
        </div>

        <div class="page-header">
            <h4>Tickets</h4>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default panel-success">
                    <div class="panel-heading">
                        <h1 class="text-center">
                            <span class="glyphicon glyphicon-user"></span>
                        </h1>
                        <h1 class="text-center">
                            <?php echo $view->item( 'num_tickets_abertos' ); ?>
                        </h1>
                        <h4 class="text-center">Tickets</h4>
                        <h6 class="text-center">Tickets abertos</h6>
                    </div>
                </div>
            </div><!-- num funcionarios -->
            <div class="col-md-4">
                <div class="panel panel-default panel-success">
                    <div class="panel-heading">
                        <h1 class="text-center">
                            <span class="glyphicon glyphicon-user"></span>
                        </h1>
                        <h1 class="text-center">
                            <?php echo $view->item( 'num_tickets_resolvendo' ); ?>
                        </h1>
                        <h4 class="text-center">Tickets</h4>
                        <h6 class="text-center">Tickets em resolução</h6>
                    </div>
                </div>
            </div><!-- num funcionarios -->
            <div class="col-md-4">
                <div class="panel panel-default panel-success">
                    <div class="panel-heading">
                        <h1 class="text-center">
                            <span class="glyphicon glyphicon-briefcase"></span>
                        </h1>
                        <h1 class="text-center">
                            <?php echo $view->item( 'num_tickets_resolvidos' ); ?>
                        </h1>
                        <h4 class="text-center">Tickets</h4>
                        <h6 class="text-center">Tickets resolvidos</h6>
                    </div>
                </div>
            </div><!-- num funcionarios -->
        </div>
        
        </div>
    </div>
</div>