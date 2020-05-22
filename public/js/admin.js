$(document).ready(function (){
    
    // add new note
    $('#link-add-new').on('click', openNewWindow)

    function openNewWindow (event) {
        event.preventDefault()
        window.open($(this).attr('href'),'','scrollbars=yes,resizable=yes,width=522,height=660')
    }

    // Search function 
    $('#input-search-item').on('keyup', function() {
        var actualUri = window.location 
        var uriSplit = actualUri.toString().split('/')
        var lastElementUri = uriSplit[uriSplit.length - 1].split('?').shift()
        var inputValue = $(this).val()
        var token = $('meta[name=csrf-token]').attr('content')

        if(inputValue.length > 3) {
            $.get(`/panel/global-search?query=${inputValue}&uri=${lastElementUri}&_token=${token}`)
                .error(function (err) {
                    if(lastElementUri == 'fuentes') {
                        var container = $('#panel-body-sources')
                        var htmlError = `<div class="jumbotron">
                                            <div class="container">
                                                Error en la plataforma: No se puede realizar la petición
                                            </div>
                                        </div>`
                        container.empty()
                        container.append(htmlError)
                        console.error(err.responseJSON.message)
                    }
                })
                .success(function (response) {
                    if(lastElementUri == 'fuentes') {
                        var container = $('#panel-body-sources')
                        container.empty()
                        container.append(response)
                    }
                    //TODO: falta poner aqui un else if para cuando se hagan busquedas desde compañias o noticias o usuarios
                })
        }
    })
})