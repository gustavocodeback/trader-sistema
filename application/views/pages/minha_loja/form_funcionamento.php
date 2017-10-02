<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
    $dias = [
        'Segunda-feira',
        'Terça-feira',
        'Quarta-feira',
        'Quinta-feira',
        'Sexta-feira',
        'Sábado',
        'Domingo'
    ];
?>
<div class="col-md-offset-1 col-md-10">
    <div class="page-header">
        <h4>Horário de funcionamento</h4>
    </div>
    <table class="table table-striped">
        <thead>
            <th>Dia da semana</th>
            <th>Hora de abertura</th>
            <th>Hora de encerramento</th>
            <th>Não abrimos</th>
        </thead>
        <tbody>
            <?php foreach( $dias as $dia ): ?>
            <tr>
                <td><?php echo $dia ?></td>
                <td>
                    <select class="form-control">
                        <?php for( $h = 1; $h <= 24; $h++ ): ?>
                        <option><?php echo $h; ?> hora(s)</option>
                        <?php endfor; ?> 
                    </select>
                </td>
                <td>
                    <select class="form-control">
                        <?php for( $h = 1; $h <= 24; $h++ ): ?>
                        <option><?php echo $h; ?> hora(s)</option>
                        <?php endfor; ?> 
                    </select>
                </td>
                <td>
                <div class="checkbox">
                    <label>
                        <input onchange="habilitarLinha( $( this ) )" type="checkbox"> Não abrimos
                    </label>
                </div>
                </td>   
            </tr>
            <?php endforeach; ?> 
        </tbody>
    </table>
</div>
