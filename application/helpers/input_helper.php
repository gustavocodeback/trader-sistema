<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * errors_array
 *
 * pega os erros de validacao
 *
 */
if ( ! function_exists( 'errors_array' ) ) {
    function errors_array() {

        // pega os erros
        $err = validation_errors();

        // verifica se existe
        if ( !$err || empty( $err ) ) return [];

        // explode
        $parts = explode( '<p>', $err );
        unset( $parts[0] );

        // percorre todas as partes
        $parts = array_map( function( $value ) {
            return trim( strip_tags( $value ) );
        }, $parts );

        // retorna o array
        return $parts;
    }
}

/**
 * has_error
 *
 * verifica se existe um erro no input
 *
 */
if( ! function_exists( 'has_error' ) ) {
    function has_error( $label ) {

        // pega os erros
        $erros = errors_array();

        // seta os erros
        $linhas = [];

        // percorre os erros
        foreach( $erros as $erro ) {

            // verifica se uma string contem a outra
            if ( strpos( $erro, $label ) !== false ) {
                $linhas[] = $erro;
            }
        }

        // volta os dados
        return ( count( $linhas ) > 0 ) ? $linhas : false;
    }
}

/**
 * input_text
 *
 * imprime um input de texto
 *
 */
if ( ! function_exists( 'input_text' ) ) {
    function input_text( $label, $name, $entity = false, $attr = [] ) {

        // pega a instancia do ci
        $ci = get_instance();

        // verifica se existe um erro
        $erros = has_error( $label );
        $statusClass = $erros ? 'has-error' : '';

        // verifica se foi adicionada alguma classe
        if ( isset( $attr['class'] ) ) {
            $attr['class'] = $attr['class'].' form-control';
        } else {
            $attr['class'] = 'form-control';            
        }

        // seta o tipo
        $type = 'text';
        if ( isset( $attr['type'] ) && $attr['type'] ) {
            $type = $attr['type'];
            unset( $attr['type'] );
        }

        // seta o valor
        $value = '';
        if ( is_object( $entity ) && isset( $entity->$name ) ) {
            $value = $entity->$name;
        } else if ( is_array( $entity ) && isset( $entity[$name] ) ) {
            $value = $entity[$name];
        } else if ( isset( $attr['value'] ) ) {
            $value = $attr['value'];
            unset( $attr['value'] );
        } else if ( $ci->input->post( $name ) ) {
            $value = $ci->input->post( $name );
        }

        // verifica se deve iniciar a linha
        $row = true;
        if ( isset( $attr['row'] ) && !$attr['row'] ) {
            $row = false;
            unset( $attr['row'] );
        }

        // verifica se existe um tamanho
        $len = 6;
        if ( isset( $attr['length'] ) ) {
            $len = $attr['length'];
            unset( $attr['length'] );
        }

        // inicio da lina
        $rowT = "<div class='row'>";

        // comeca o template
        $template = "<div class='col-md-$len'>
                        <div class='form-group $statusClass'>";

        if ( $label && ( !isset( $attr['display_label'] ) || $attr['display_label'] ) ) 
            $template .= "<label class='control-label' for='$name'>$label</label>";
        
        $template .= "<input    type='$type' 
                                id='$name' 
                                name='$name'
                                value='$value'";
        
        if ( $label ) "placeholder='$label'";
        
        // percorre os atributos
        foreach( $attr as $chave => $valor ) $template .= "$chave='$valor'";

        // concatena o template
        $template .= ">";
        

        // verifica se existem erros
        if ( $erros ) {
            foreach( $erros as $erro ) {
                $template .= "<span class='help-block'>$erro</span>";
            }
        }

        // concatena o final
        $template .= "</div></div>";

        // verifica se deve adicionar a lina
        if ( $row )
            $template = "$rowT $template </div>";

        // imprime o template
        echo $template;
    }
}

/**
 * input_checkbox
 *
 * imprime um input de checkbox
 *
 */
if ( ! function_exists( 'input_checkbox' ) ) {
    function input_checkbox( $label, $name, $entity = false, $attr = [] ) {

        // verifica se existe um erro
        $erros = has_error( $label );
        $statusClass = $erros ? 'has-error' : '';

        // verifica se deve iniciar a linha
        $row = true;
        if ( isset( $attr['row'] ) && !$attr['row'] ) {
            $row = false;
            unset( $attr['row'] );
        }

        // verifica se existe um tamanho
        $len = 6;
        if ( isset( $attr['length'] ) ) {
            $len = $attr['length'];
            unset( $attr['length'] );
        }

        // seta o valor
        $value = '';
        if ( is_object( $entity ) && isset( $entity->$name ) ) {
            $value = $entity->$name;
        }
        if ( is_array( $entity ) && isset( $entity[$name] ) ) {
            $value = $entity[$name];
        }
        if ( isset( $attr['value'] ) ) {
            $value = $attr['value'];
            unset( $attr['value'] );
        }

        // inicio da lina
        $rowT = "<div class='row'>";

        // comeca o template
        $template = "<div class='col-md-$len'>
                            <div class='checkbox'>
                            <label class='control-label' for='$name'>
                                <input  type='checkbox' 
                                        id='$name' 
                                        name='$name'
                                        value='$value'
                                        ";

        // verifica se esta checado
        if ( $entity && $entity->$name == $value ) {
            $template .= " checked='checked' ";
        }
        
        // percorre os atributos
        foreach( $attr as $chave => $valor ) $template .= "$chave='$valor'";

        // concatena o template
        $template .= "> &nbsp; $label </label>";
        

        // verifica se existem erros
        if ( $erros ) {
            foreach( $erros as $erro ) {
                $template .= "<span class='help-block'>$erro</span>";
            }
        }

        // concatena o final
        $template .= "</div></div>";

        // verifica se deve adicionar a lina
        if ( $row )
            $template = "$rowT $template </div>";

        // imprime o template
        echo $template;
    }
}

/**
 * select
 *
 * imprime um o inicio do select
 *
 */
if ( ! function_exists( 'select' ) ) {
    function select( $label, $name, $attr = [] ) {

        // verifica se existe um erro
        $erros = has_error( $label );
        $statusClass = $erros ? 'has-error' : '';

        // verifica se foi adicionada alguma classe
        if ( isset( $attr['class'] ) ) {
            $attr['class'] = $attr['class'].' form-control';
        } else {
            $attr['class'] = 'form-control';            
        }

        // seta o tipo
        $type = 'text';
        if ( isset( $attr['type'] ) && !$attr['type'] ) {
            $type = $attr['type'];
            unset( $attr['type'] );
        }

         // verifica se deve iniciar a linha
        $row = true;
        if ( isset( $attr['row'] ) && !$attr['row'] ) {
            $row = false;
            unset( $attr['row'] );
        }

        // verifica se existe um tamanho
        $len = 6;
        if ( isset( $attr['length'] ) ) {
            $len = $attr['length'];
            unset( $attr['length'] );
        }

        // inicio da lina
        $rowT = "<div class='row'>";

        // comeca o template
        $template = "<div class='col-md-$len'>
                        <div class='form-group $statusClass'>
                            <label class='control-label' for='$name'>$label</label>
                                <select id='$name' name='$name'";
        
        // percorre os atributos
        foreach( $attr as $chave => $valor ) $template .= " $chave='$valor'";

        // concatena o template
        $template .= ">";

        // verifica se deve adicionar a lina
        if ( $row ) $template = "$rowT $template";

        // imprime o template
        echo $template;
    }
}

/**
 * endselect
 *
 * imprime um o fim do select
 *
 */
if ( ! function_exists( 'endselect' ) ) {
    function endselect( $label = '', $end = true ) {

        // seta os erros
        $erros = has_error( $label );

        // seta o template
        $template = "</select>";

        // verifica se existem erros
        if ( $erros ) {
            foreach( $erros as $erro ) {
                $template .= "<span class='help-block'>$erro</span>";
            }
        }

        // imprime o final
        $template .= '</div></div>';

        // verifica se é fim de linha
        if ( $end ) $template .= '</div>';

        // imprime
        echo $template;
    }
}

/**
 * option
 *
 * imprime uma opcao do select
 *
 */
if ( !function_exists( 'option' ) ) {
    function option( $value = '', $text = '-- Selecione --', $entity = false, $chave = '', $attr = [] ) {

        // inicio
        $start = "<option value='$value' ";

        // percorre os atributos
        foreach( $attr as $chave => $valor ) $start .= "$chave='$valor'";

        // verifica se existe uma entidade
        if ( $entity ) {
            if ( $entity->$chave == $value )
                $start .= "selected='selected'";
        }

        // finaliza
        $start .= ">$text</option>";

        // da um echo
        echo $start;
    }
}

/**
 * print_alert
 *
 * imprime um alert do bootstrap
 *
 */
if ( ! function_exists( 'print_alert' ) ) {
    function print_alert( $type, $title, $msg, $len = 6 ) {

        // verifica se existe uma mensagem
        if ( !$msg ) return;

        // imprime o alerta
        echo '<div class="row">
            <div class="col-md-'.$len.'">
                <div class="alert alert-danger">
                    <b>'.$title.'</b>
                    <p>'.$msg.'</p>
                </div>
            </div>
        </div>';
    }
}

/**
 * print_key
 *
 * imprime a chave do item
 *
 */
if ( ! function_exists( 'print_key' ) ) {
    function print_key( $entity ) {

        // verifica se existe a entidade
        if ( !$entity ) return;

        // pega a chave primaria
        $pk = $entity->primaryKey;

        // pega o calor
        $val = $entity->$pk;

        // imprime o input
        echo "<input type='hidden' name='cod' value='$val'>";
    }
}

/**
 * print_icon
 *
 * imprime o icone
 *
 */
 if ( ! function_exists( 'print_icon' ) ) {
    function print_icon( $icon, $size = '24px' ) {

        // imprime a tag de imagem
        echo "<img class='flat-icon' width='$size' src='".base_url( 'images/icons/'.$icon.'.png' )."'></img>";
    }
}

/* end of file */