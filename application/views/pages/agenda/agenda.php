<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $view->component( 'navbar/navbar' ); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-offset-1 col-md-2">
            <?php $view->component( 'aside/aside' ); ?>            
        </div>
        <div class="col-md-6">
            <div class="calendar-wrapper" style="padding-top: 30px;">
                <div id='calendar'></div>
            </div>       
        </div>
        <div class="col-md-3">
            <div class="page-header">
                <h4>Requisições</h4>
            </div>
            <div class="media">
                <div class="media-left">
                    <a href="#">
                        <img width="50px" class="media-object" src="<?php echo base_url( 'images/avatar_1.jpg' ); ?>" alt="...">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">Agatha Ellen</h4>
                    Queria uma progressiva <br>
                    <i>Terça-feira</i> <br>
                    <i>15h 30m</i>
                    <br>
                    <br>
                    <div class="btn-group" role="group" aria-label="...">
                        <button type="button" class="btn btn-sm btn-default btn-primary">Marcar horário</button>
                        <button type="button" class="btn btn-sm btn-default">Recusar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>