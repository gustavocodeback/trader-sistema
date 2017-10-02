<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $esquema = $view->item( 'esquema' ); ?>
<?php $view->component( 'aside' ); ?>
<div id="wrapper" class="wrapper show">
    <?php $view->component( 'navbar' ); ?>

    <?php echo form_open( 'esquemas/atualizar_tabelas/'.$esquema->CodEsquema, [ 'class' => 'card container fade-in' ] )?>
        <?php $view->component( 'breadcrumb' ); ?>        
        <div class="page-header">
            <h2>Tabelas em <?php echo $esquema->esquema; ?></h2>
        </div>
        
        <table class="table table-bordered z-depth-2" style="background: white">
            <thead>
                <tr>
                    <td>Tabela</td>
                    <td>Usar no esquema</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach( $view->item( 'tabelas' ) as $tabela ): ?>
                    <tr>
                        <td><?php echo $tabela->nome; ?></td>
                        <td>
                            <input  type="checkbox" 
                                    name="tabelas[]"
                                    <?php echo $tabela->checked ? "checked='checked'" : ''; ?>
                                    value="<?php echo $tabela->CodTabela; ?>">
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>

        <hr>
        <button class="btn btn-primary">Salvar</button>
        <a href="<?php echo site_url( 'esquemas' ); ?>" class="btn btn-danger">Cancelar</a>
    <?php echo form_close(); ?> 

    <?php $view->component( 'footer' ); ?>
</div>