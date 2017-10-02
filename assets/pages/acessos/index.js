/**
 * carregarUsuarios
 * 
 * carrega os usuários pesquisados
 * 
 * @param {*} e 
 */
function carregarUsuarios( e ) {

    // mostra o loading
    abrir( '#users-loading' );
    abrir( '#users-loaded' );

    // pega o conteudo do email
    var email = $( '#email' ).val();

    // carrega os resultados
    carregar( 'acessos/buscar_usuarios', { email: email }, '#users-loaded', '#users-loading' );

    // retorna false para evitar a submissao do formulário
    return false;
}

/* end of file */