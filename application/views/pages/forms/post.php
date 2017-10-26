<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $post = $view->item( 'post' ); ?>
<?php $view->component( 'navbar/navbar' ); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php $view->component( 'aside/aside' ); ?>            
        </div>
        <div class="col-md-8">    

        <?php echo form_open_multipart( 'posts/salvar', [ 'class' => 'card container fade-in' ] )?>
     
            <div class="page-header">
                <h2>Novo post</h2>
            </div>
            
            <?php print_key( $post ); ?>
            <?php input_text( 'Titulo', 'titulo', $post ); ?>
            <div class="row">
                <div class="col-md-6">
                    <label for="foto" class="well col-md-12">
                        <center>
                            
                            <?php if( $post && isset( $post->imagem ) ): ?>
                            <img src="<?php echo base_url( 'uploads/'.$post->imagem )?>" class="img-thumbnail" style="width: 200px;">  
                            <h3 style="color: #999">Alterar foto</h3>
                            <?php else : ?>
                            <h1>
                                <span class="glyphicon glyphicon-camera"></span>
                            </h1>
                            <h3 style="color: #999">Adicionar foto</h3>
                            <?php endif; ?>
                        </center>
                    </label>
                    <input type="file" id="foto" name="foto">
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-6">                
                    <label for="descricao">Texto Curto</label>
                    <textarea rows="3" cols="" type="text" 
                            class="form-control" 
                            id="textoCurto" 
                            name="textoCurto" 
                            placeholder=""><?php echo $post ? $post->textoCurto : ''; ?></textarea>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-12">
                    <label for="descricao">Post</label>
                    <textarea rows="3" cols="" type="text" 
                            class="form-control" 
                            id="editor" 
                            name="post" 
                            placeholder=""><?php echo $post ? $post->post : ''; ?></textarea>
                </div>
            </div>

            <hr>
            <button class="btn btn-primary">Salvar</button>
            <a href="<?php echo site_url( 'post' ); ?>" class="btn btn-danger">Cancelar</a>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>