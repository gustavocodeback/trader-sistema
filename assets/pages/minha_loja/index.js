/**
 * habilitarLinha
 * 
 * habilita e desabilita uma linha da tabela baseada
 * no status do checkbox
 * 
 * @param {*} check 
 */
function habilitarLinha( check ) {

    // pega a linha
    var linha = check.parents( 'tr' );

    // verifica se esta desabilitado
    var habilitado = check.is( ':checked' );
    
    // disabilita os selects
    if ( habilitado ) {
        linha.find( 'select' ).attr( 'disabled', 'disabled' );    
    } else {
        linha.find( 'select' ).removeAttr( 'disabled' );            
    }
}

/* end of file */