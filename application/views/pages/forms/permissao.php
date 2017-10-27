<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $view->component( 'navbar/navbar' ); ?>
<div class="container-fluid">

    <div class="row">
        <div class="col-md-2">
            <?php $view->component( 'aside/aside' ); ?>            
        </div>
        <div class="col-md-9">            
        <?php echo form_open( 'permissoes/salvar', [ 'class' => 'card container fade-in' ] )?>
            <div class="page-header">
                <h2>Permissōes de acesso</h2>
            </div>
            <table class="table table-bordered" style="background: white">
                <thead>
                    <tr>
                        <td rowspan="2">Rotinas</td>
                        <td colspan="4">
                            <select onchange="atualizarTabelaPermissoes( $( this ) );" class="form-control">
                                <option>-- Selecione --</option>
                                <?php foreach( $view->item( 'cargos' ) as $item ): ?>
                                <option value="<?php echo $item->grupo; ?>">
                                    <?php echo $item->grupo; ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">Adicionar</td>
                        <td class="text-center">Ver</td>
                        <td class="text-center">Editar</td>
                        <td class="text-center">Excluir</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach( $view->item( 'rotinas' ) as $item ): ?>
                        <tr>
                            <td><?php echo $item->rotina; ?></td>
                            <?php foreach( $view->item( 'cargos' ) as $cargo ): ?>
                                <td class="<?php echo $cargo->grupo; ?> hidden-row hidden text-center">
                                    <input  name="permissoes[]" 
                                            type="checkbox"
                                            <?php echo $view->canCreate( $item->rid, $cargo->gid ) ? 'checked="checked"' : ''; ?>                                                
                                            value="<?php echo 'c_'.$item->rid.'_'.$cargo->gid; ?>">
                                </td>
                                <td class="<?php echo $cargo->grupo; ?> hidden-row hidden text-center">
                                    <input  name="permissoes[]" 
                                            type="checkbox"
                                            <?php echo $view->canRead( $item->rid, $cargo->gid ) ? 'checked="checked"' : ''; ?>                                                
                                            value="<?php echo 'r_'.$item->rid.'_'.$cargo->gid; ?>">
                                </td>
                                <td class="<?php echo $cargo->grupo; ?> hidden-row hidden text-center">
                                    <input  name="permissoes[]" 
                                            type="checkbox"
                                            <?php echo $view->canUpdate( $item->rid, $cargo->gid ) ? 'checked="checked"' : ''; ?>                                                
                                            value="<?php echo 'u_'.$item->rid.'_'.$cargo->gid; ?>">
                                </td>
                                <td class="<?php echo $cargo->grupo; ?> hidden-row hidden text-center">
                                    <input  name="permissoes[]" 
                                            type="checkbox"
                                            <?php echo $view->canDelete( $item->rid, $cargo->gid ) ? 'checked="checked"' : ''; ?>
                                            value="<?php echo 'd_'.$item->rid.'_'.$cargo->gid; ?>">
                                </td>
                            <?php endforeach;?>                       
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary">Salvar</button>
                    <button class="btn btn-danger">Cancelar</button>
                </div>
            </div>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>
<br>