/**
 * toggleSideBar
 * 
 * esconde e mostra o sidebar
 * 
 */
function toggleSideBar() {
    $('#aside').toggleClass( 'hide' );
    $('#wrapper').toggleClass( 'hide' );
    return false;
}

/**
 * atualizarTabelaPermissoes
 * 
 * atualiza a tabela de permissoes
 * 
 */
function atualizarTabelaPermissoes( select ) {
    
    // seta o identificador
    var id = select.val();

    // esconde
    $( '.hidden-row' ).addClass( 'hidden' );

    // exibibe
    $( '.'+id ).removeClass( 'hidden' );
}

/**
 * atualizaSecao
 * 
 * atualiza a selecao no formulario do cliente
 * 
 * @param {*} select 
 */
function atualizaSecao( select ) {

    // atualiza o item
    var item = {
        'F': '.pessoa-fisica',
        'J': '.pessoa-juridica',
    };

    // esconde as duas secoes
    $( '.pessoa-fisica' ).addClass( 'hidden' );
    $( '.pessoa-juridica' ).addClass( 'hidden' );

    // pega o item
    if ( item[select.val()] ) {
        $( item[select.val()] ).removeClass( 'hidden' );
    }
}

// exibe o elemento
function exibir( elemento, esconder=false ) {
    $( elemento ).removeClass( 'hidden' );
    if( esconder ) $( esconder ).addClass( 'hidden' );
}

// esconde o elemento
function esconder( elemento, resetaCampos = false, exibir=false ) {
    $( elemento ).addClass( 'hidden' );
    if( resetaCampos ) this.resetCampos( resetaCampos );
    if( exibir ) $( exibir ).removeClass( 'hidden' );
}

// resta o valor dos campos
function resetCampos( campos ) {
    campos.forEach( function( campo ) {
        $( campo ).val( '' );
    }, this );    
}

/**
 * preencherSelect
 * 
 * preenche um select com os dados passados
 * 
 * @param {string} seletor o seletor usado no elemento
 * @param {Array<{label: string, value: string }>} dados os dados que preencherao o select
 */
function preencherSelect( seletor, dados ) {

    // pega o elemento
    var elem = $( seletor );

    // esvazia o mesmo
    elem.html( '' );

    // cria uma option
    var option = $( '<option></option>' );

    // habilita o select
    elem.removeAttr( 'disabled' )

    // adiciona a opcao padrao
    option.val( '' ).html( '-- Selecione --' );
    elem.append( option );
    // verifica se existem dados
    if ( dados.length == 0 ) {

        // desabilita o input
        elem.attr( 'disabled', 'disabled' );
        return;
    }

    // percorre os dados
    for ( var d in dados ) {
        var opt = option.clone();
        // seta a opcao
        opt.val( dados[d].value ).html( dados[d].label );
        elem.append( opt );
    }
}

function teste() {
    console.log('teste');
}

/**
 * atualizarSelect
 * 
 * atualiza um select relacional
 * 
 * @param {string} seletor o seletor do elemento
 * @param {string} url a url onde obter os dados
 * @param {Element} elem o elemento atual
 */
function atualizarSelect( seletor, url, elem ) {

    // pega o valor no elemento
    var value = elem.val();
    
    // verifica se o mesmo eh numerico
    if ( !Number.isInteger( parseInt( value ) ) ) {
        preencherSelect( seletor, [] );
        return;
    }

    // monta a url de requisicao
    var ajaxUrl = Site.url+url+'/'+value;

    // faz a requisicao
    $.get( ajaxUrl, function( data ) {

        try {
            
            // transforma em json
            data = JSON.parse( data );
            preencherSelect( seletor, data );

        } catch (error) {

            // preenche o select com o campo vazio
            preencherSelect( seletor, [] );
        }
    });
}

/**
 * toggleElement
 * 
 * esconde/exibe um elemento
 * 
 * @param {string} seletor o seletor do elemento
 */
function toggleElement( seletor ) {

    // esconde ou mostra o selector
    $( seletor ).toggleClass( 'hidden' );
}

/**
 * abrir
 * 
 * abre um elemento
 * 
 * @param {string} seletor o seletor do elemento
 */
function abrir( seletor ) {
    $( seletor ).removeClass( 'hidden' );
}

/**
 * fechar
 * 
 * fecha um elemento
 * 
 * @param {string} seletor o seletor do elemento
 */
function fechar( seletor, limpar = false ) {

    // esconde o item
    $( seletor ).addClass( 'hidden' );
    
    // verifica se deve limpar a div
    if ( limpar ) {
        $( seletor ).html( '' );
    }
}

/**
 * carregar
 * 
 * carrega um conteudo via ajax
 * 
 * @param {string} url a url do ajax
 * @param {object} dados os dados que serão enviados
 * @param {string} recipiente o recipiente com o conteudo
 * @param {string} loading o loading enquando estiver carregando
 */
function carregar( url, dados, recipiente, loading = false ) {

    // faz a requisicao ajax
    $.post( Site.url+url, dados, function( data ) {

        // seta o html do recipiente
        $( recipiente ).html( data );
    })
    .always( function() {

        // esconde o loading
        if ( loading ) fechar( loading );
    });
}

$( document ).ready( function() {

    // seta a animacao de fade in
    $('.fade-in').animate( { opacity: 1 }, 1000 );

    // habilita o tooltip
    $('[data-toggle="tooltip"]').tooltip();
});
