$(document).ready(function (){
    
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
                })
        }
    })
})