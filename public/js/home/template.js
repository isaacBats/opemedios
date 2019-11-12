jQuery(document).ready(function($) {

	$(".headroom").headroom({
		"tolerance": 20,
		"offset": 50,
		"classes": {
			"initial": "animated",
			"pinned": "slideDown",
			"unpinned": "slideUp"
		}
	});


	/* Trae las fuentes de un tipo de fuente */
    $( '#tipo_fuente' ).change( function (){
        $( '#tipo_fuente option:selected' ).each( function () {
            var $elegido = parseInt($(this).val());
            if($elegido != 0 || $elegido != '')
            {
            	
                $.get( '/panel/fonts/fonts-by-type/' + $elegido, function (data) {
                    var $sfuente = $('#fuente');
                    $sfuente.removeAttr('disabled');
                    $('option', $sfuente).remove();
                    $sfuente.append('<option value="">Fuente</option>');
                    $sfuente.append('<option value="0">Todas las fuentes</option>');
                    $.each( data, function (i, item){
                        $sfuente.append( $('<option>', {
                            value: item.id_fuente,
                            text : item.nombre
                        } ) );
                    } );
                } );
            }
        });
    });

    /* Obtiene las secciones de una fuente */
    $( '#fuente' ).change( function (){
        $( '#fuente option:selected' ).each( function () {
            var $elegido = parseInt($(this).val());
            if($elegido != 0 || $elegido != '')
            {
                $.get( '/panel/get/seccion/' + $elegido, function (data) {
                    var $sseccion = $('#seccion');
                    $sseccion.removeAttr('disabled');
                    $('option', $sseccion).remove();
                    if(typeof(data) == 'string'){
                        $sseccion.append('<option value="">Sección</option>');
                        $sseccion.append('<option value="">' + data + '</option>');
                    }else{
                        $sseccion.append('<option value="">Sección</option>');
                        $sseccion.append('<option value="0">Todas las secciones</option>');
                        $.each( data, function (i, item){
                            $sseccion.append( $('<option>', {
                                value: item.id_seccion,
                                text : item.nombre
                            } ) );
                        } );
                    }
                } );
            }
        });
    });

    /* Trae las secciones de acuerdo a la fuente seleccionada */
    $( '#selectFuente' ).change( function (){
        $( '#selectFuente option:selected' ).each( function () {
            var $elegido = $(this).val();
            $.get( '/panel/get/seccion/' + $elegido, function (data) {
                var $ssecction = $('#add-new-secction');
                $ssecction.removeAttr('disabled');
                $('option', $ssecction).remove();
                if( typeof(data) == 'string' ){
                    $ssecction.append('<option value="">Sección</option>');
                    $ssecction.append('<option value="">' + data + '</option>');
                }else{
                    $ssecction.append('<option value="">Sección</option>');
                    $.each( data, function (i, item){
                        $ssecction.append( $('<option>', {
                            value: item.id_seccion,
                            text : item.nombre
                        } ) );
                    } );
                }
            } );
        });
    });














});