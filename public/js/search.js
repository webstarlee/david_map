$('#map_search_form').on('submit', function(e) {
    e.preventDefault();
    var $this = $(this);
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
        }
    });
    var form = $this[0];
    var url = $(form).attr( 'action' );
    var send_button = $(form).find('#search-form-submit-btn');

    var formData = new FormData($(form)[0]);
    var address = $(form).find('input[name=address]').val();
    var operador = $(form).find('select[name=operador]').val();
    var islas = $(form).find('select[name=islas]').val();
    var productos = $(form).find('select[name=productos]').val();
    var municipios = $(form).find('select[name=municipios]').val();
    var provincia = $(form).find('select[name=provincia]').val();
    var check_null = 0;
    if (address != "" || operador != "" || islas != "" || productos != "" || municipios != "" || provincia != "") {
        check_null = 1;
    }
    if (check_null == 0) {
        swal({
            title: "Alerta!",
            text: "Elija un campo al menos.",
            type: "warning",
            showCancelButton: false,
            showConfirmButton: true,
            confirmButtonText: "De acuerdo",
        });
        return false;
    }
    send_button.button('loading');
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        success: function (data) {
            console.log(data);
            send_button.button('reset');
            if (data == "fail") {
                swal({
                    title: "Ha fallado!",
                    text: "No se pudieron encontrar los datos.",
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: true,
                    confirmButtonText: "Inténtalo de nuevo",
                });
            } else {
                if (data.map_data != "invalid") {
                    locations = [];
                    var final_lat, final_lng;
                    data.map_data.forEach(function(single) {
                        var new_Data = [single.direction+","+single.isla+" "+single.zip, single.lat, single.lng, single.icon, single.fax, single.mobile, single.telephone, single.email, single.id, single.table,];
                        locations.push(new_Data);
                        final_lat = single.lat;
                        final_lng = single.lng;
                    });
                    initMap();
                    map.setCenter(new google.maps.LatLng(final_lat, final_lng));
                    map.setZoom(12);
                    map.setOptions({draggable: true});
                }

                $('#result-all-container').html(data.html);
            }
        },
        processData: false,
        contentType: false,
        error: function(data)
       {
           console.log(data);
       }
    });
})

$('#form-reset-btn').on('click', function(e) {
    e.preventDefault();
    var $this = $(this);
    $this.addClass('fa-spin');
    var form = $('#map_search_form')[0];
    setTimeout(function(){
        form.reset();
        $this.removeClass('fa-spin');
        $.fn.select2.defaults.set("theme", "bootstrap");
        $(".select2-provincia").select2("val","");
        $(".select2-municipios").select2("val","");
        $(".select2-productos").select2("val","");
        $(".select2-provincia").select2("val","");
        $(".select2-provincia").select2("val","");
        $(".select2-islas").select2("val","");
        $(".select2-operador").select2("val","");
    }, 1000)
})
