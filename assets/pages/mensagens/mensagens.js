// indica se esta fazendo uma requisicao
var req = false;

/**
 * adicionarArquivoNaLista
 * 
 * adiciona um novo arquivo na lista
 * 
 * @param {Element} $input o elemento html do input
 * @param {function} onProgress callback para o progresso
 * @param {function} onCompleta callback para finalizado
 * 
 */
function adicionarArquivoNaLista( $file, onProgress, onComplete ) {

    // pega o nome do arquivo
    var filename = $file.val().split('\\').pop();
    
    // pega o total de arquivos anexados
    var len = $( '.file-wrapper' ).length;

    // pega o template
    var template = $( '#file-wrapper-template' ).clone();

    // adiciona o nome
    template.addClass( 'loading' ).find( '.file-name' ).html( filename );

    // muda o id
    template.attr( 'id', 'my-file-'+len ).removeClass( 'hidden' );

    // desablita o botao de anexo
    $( '#anexo-label' ).attr( 'disabled', 'disabled' ).attr( 'for', '' );

    // faz o upload
    $( '#input-anexo' ).upload( Site.url+'mensagens/salvar_arquivo', { CodCliente: Cliente }, function( done ) {
        if ( onComplete ) location.reload();
    }, function( progress, val ) {
        if ( onProgress ) onProgress( template, val );
    });

    // adiciona na lista
    template.appendTo( '.files-content' );
}

/**
 * removerArquivo
 * 
 * remove um arquivo adicionado
 * 
 * @param {Element} item link de remocao
 * 
 */
function removerArquivo( item ) {

    // pega o codigo do arquivo
    var cod = item.attr( 'data-cod-arquivo' );

    // verifica se existe o código do arquivo
    if ( cod ) {

        // monta a url de remocao
        var ajaxUrl = Site.url+'mensagens/remover_arquivo/'+cod;

        // remove o input
        removeInput( cod );

        // faz a requisicao
        $.get( ajaxUrl, function ( data ) {
            try {
                
                // transforma em json
                data = JSON.parse( data );
                console.log( data );

            } catch (error) {
                console.log( error );
            }
        });
    }

    // limpa o input
    $( '#input-anexo' ).val( '' );

    // remove o arquivo
    item.parents( '.file-wrapper' ).detach();

    // esconde o erro
    hideError();
}

/**
 * hideError
 * 
 * esconde o alert de erro
 * 
 */
function hideError() {

    // seta a mensagem
    $( '#alert-wrapper' ).find( '.alert' ).html( '' );
    
    // mostra o alert
    $( '#alert-wrapper' ).addClass( 'hidden' );
}

/**
 * removeInput
 * 
 * remove um input do arquivo
 * 
 * @param {string} cod o codigo do arquivo
 * 
 */
function removeInput( cod ) {
    $( '#file-input-'+cod ).detach();
}

/**
 * updateMessagesContainer
 * 
 * faz o update das mensagens no container
 * 
 */
function updateMessagesContainer( loading = true ) {

    // indica que a requisicao esta acontecendo
    req = true;

    // verifica se deve mostrar o loading
    if ( loading ) $( '#loader' ).removeClass( 'hidden' );

    // faz a requisição get
    $.get( Site.url+'mensagens/mensagens_html/'+Cliente, function( data ) {
        
        // pega os dados
        data = JSON.parse( data );

        // pega o html
        inner = data.data;

        // salva o html
        $( '#mensagens' ).html( inner );

        // adiciona para o rodape
        $('#mensagens').animate({
            scrollTop: $('#mensagens').height() + 9999
        }, 0);

    })
    .always( function() {

        // indica que a requisicao terminou
        req = false;
        
        // verifica se deve mostrar o loading
        if ( loading ) $( '#loader' ).addClass( 'hidden' );
    });
}

/**
 * addInput
 * 
 * adiciona um input de arquivo
 * 
 * @param {Object} dados os dados do arquivo recente
 * 
 */
function addInput( dados ) {
    var input = $( '<input>' ).attr( 'name', 'arquivos[]' );
    input.val( dados['cod_arquivo'] );
    input.attr( 'type', 'hidden' );
    input.attr( 'id', 'file-input-'+dados['cod_arquivo'] );
    input.appendTo( '.files-inputs' );
}

/**
 * showError
 * 
 * mostra o alert de erro
 * 
 * @param {string} msg a mensagem de dentro do alert
 * 
 */
function showError( msg ) {

    // seta a mensagem
    $( '#alert-wrapper' ).find( '.alert' ).html( msg );
    
    // mostra o alert
    $( '#alert-wrapper' ).removeClass( 'hidden' );
}

/**
 * finalizarUpload
 * 
 * callback para quando um upload eh finalizado
 * 
 * @param {Element} item elemento do arquivo na lista
 * @param {Object} response resposta do servidor
 * 
 */
function finalizarUpload( item, response ) {

    // retira o loading
    item.removeClass( 'loading' );

    // verifica se existe um erro
    if ( response.error ) {
        item.addClass( 'has-error' );
        showError( response.error );
    }

    // verifica o upload
    if ( response.upload_data ) {

        // adiciona o código do arquivo no item remover
        item.find( '.remover-arquivo' ).attr( 'data-cod-arquivo', response.upload_data['cod_arquivo'] );

        // adiciona o input
        addInput( response.upload_data );
    }

    // habilita o label
    $( '#anexo-label' ).removeAttr( 'disabled' ).attr( 'for', 'input-anexo' );
}

/**
 * atualizarProgresso
 * 
 * atualiza a barra de progresso
 * 
 * @param {Element} item o elemento do arquivo na lista
 * @param {numver} val o progresso percorrido
 */
function atualizarProgresso( item, val ) {

    // preenche o progresso
    item.find( 'progress' ).val( val );
}

function getCaret(el) { 
    if (el.selectionStart) { 
        return el.selectionStart; 
    } else if (document.selection) { 
        el.focus();
        var r = document.selection.createRange(); 
        if (r == null) { 
            return 0;
        }
        var re = el.createTextRange(), rc = re.duplicate();
        re.moveToBookmark(r.getBookmark());
        rc.setEndPoint('EndToStart', re);
        return rc.text.length;
    }  
    return 0; 
}

$('textarea').keyup(function (event) {
    if (event.keyCode == 13) {
        var content = this.value;  
        var caret = getCaret(this);          
        if(event.shiftKey){
            this.value = content.substring(0, caret - 1) + "\n" + content.substring(caret, content.length);
            event.stopPropagation();
        } else {
            this.value = content.substring(0, caret - 1) + content.substring(caret, content.length);
            $('form').submit();
        }
    }
});

$( document ).ready( function() {

    // faz o update das mensagens
    updateMessagesContainer();

    // obtem novas mensagens de 1s em 1s
    setInterval( function() {

        // verifica se ja nao existe uma requisicao
        if ( !req ) updateMessagesContainer( loading = false );
    }, 1000 );

    $( '#input-anexo' ).change( function() {

        // adiciona o arquivo na lista
        adicionarArquivoNaLista( $( this ), atualizarProgresso, finalizarUpload );
    });
});


