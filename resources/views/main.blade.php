<!DOCTYPE html>
<html>
  <head>
    <!-- This stylesheet contains specific styles for displaying the map
         on this page. Replace it with your own styles as described in the
         documentation:
         https://developers.google.com/maps/documentation/javascript/tutorial -->
     <meta name="description" content="Latest updates and statistic charts">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/select2/css/select2.min.css">
    <link rel="stylesheet" href="/css/select2/css/select2-bootstrap.min.css">
    <link rel="stylesheet" href="/css/sweetalert/sweetalert.css">
    <link rel="stylesheet" href="/css/custom.css">
    <style media="screen">
        .form-custom {
            padding: 50px 15px 10px 15px;
            border: 1px solid #ccc8c8;
            margin-top: 30px;
            margin-bottom: 30px;
            border-radius: 10px;
            position: relative;
            box-shadow: inset 0px 0px 10px 0px rgba(130, 127, 127, 0.38), 0px 0px 10px 0px rgba(130, 127, 127, 0.38);
        }
        img {
        	max-width: none !important;
        }
        .gm-style-iw {
            width: 350px !important;
            top: 40px !important;
            left: 15px !important;
            background-color: #fff;
            box-shadow: 0 1px 6px rgba(178, 178, 178, 0.6);
            border: 1px solid rgba(72, 181, 233, 0.6);
            border-radius: 2px 2px 10px 10px;
        }
        #iw-container {
            margin-bottom: 10px;
            width: 350px;
        }
        #iw-container .iw-title {
            font-family: 'Open Sans Condensed', sans-serif;
            font-size: 15px;
            font-weight: 400;
            padding: 10px;
            background-color: #48b5e9;
            color: white;
            margin: 0;
            border-radius: 2px 2px 0 0;
        }
        #iw-container .iw-content {
            font-size: 13px;
            line-height: 18px;
            font-weight: 400;
            margin-right: 1px;
            padding: 15px 5px 20px 15px;
            max-height: 140px;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .iw-content img {
            float: right;
            margin: 0 5px 5px 10px;
        }
        .iw-subTitle {
            font-size: 16px;
            font-weight: 700;
            padding: 5px 0;
        }
        .iw-bottom-gradient {
            position: absolute;
            width: 326px;
            height: 25px;
            bottom: 10px;
            right: 18px;
            background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
            background: -webkit-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
            background: -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
            background: -ms-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
        }
        .view-more-btn {
            padding: 6px 10px;
            border: 1px solid #2abd80;
            border-radius: 20px;
            text-decoration: none;
            background-color: #10b55a;
            color: #fff;
            transition: all .3s ease-out;
        }
        .view-more-btn:hover,
        .view-more-btn:active,
        .view-more-btn:focus,
        .view-more-btn:focus:active {
            border: 1px solid #0c8855;
            text-decoration: none;
            background-color: #0e954b;
            color: #fff;
        }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <div class="search-stuff-container">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                    <form class="form-custom" id="map_search_form" action="/search_data/" method="post">
                        <a href="#" id="form-reset-btn" title="Reset Form"> <i class="fa fa-refresh"></i> </a>
                        <div class="form-title-container">
                            <span>BUSCADOR</span>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="text" name="address" placeholder="Dirección de entrada (opcional)" class="form-control" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <select name="operador" class="form-control select2-operador" style="" title="" tabindex="-1">
                                        <option value=""></option>
                                        <option value="PRODUCTOR">PRODUCTOR</option>
                                        <option value="INDUSTRIA">INDUSTRIA</option>
                                        <option value="PUNTO DE VENTA DIRECTA">PUNTO DE VENTA DIRECTA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <select name="islas" class="form-control select2-islas" style="" title="" tabindex="-1">
                                        <option value=""></option>
                                        @foreach ($total_islas as $single_islas)
                                            <option value="{{$single_islas}}">{{$single_islas}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <select name="productos" class="form-control select2-productos" style="" title="" tabindex="-1">
                                        <option value=""></option>
                                        @foreach ($total_productos as $single_productos)
                                            <option value="{{$single_productos}}">{{$single_productos}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <select name="municipios" class="form-control select2-municipios" style="" title="" tabindex="-1">
                                        <option value=""></option>
                                        @foreach ($total_municipios as $single_minici)
                                            <option value="{{$single_minici}}">{{$single_minici}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <select name="provincia" class="form-control select2-provincia" style="" title="" tabindex="-1">
                                        <option value=""></option>
                                        @foreach ($total_provincia as $single_provincia)
                                            <option value="{{$single_provincia}}">{{$single_provincia}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group" style="text-align:center">
                                    <button type="submit" style="width: 100%;" class="btn btn-primary" id="search-form-submit-btn" name="button" data-loading-text="<i class='fa fa-spinner fa-spin '></i> BUSCANDO"><i class='fa fa-search'></i> BUSCAR</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                    <div class="result-location-container">
                        <div class="form-title-container">
                            <span>RESULTADOS</span>
                        </div>
                        <div id="result-all-container">
                            <div class="sinle-data-container">
                                <p class="title"> <a href="/search-result/{{$real_data->id}}/{{$coordinator['table']}}" target="_blank">{{$real_data->RAZON_SOCIAL}}</a></p>
                                <p class="operator-title">{{$real_data->TIPO_OPERADOR}}</p>
                                <p>{{$real_data->DIRECCION}}, {{$real_data->PROVINCIA}} {{$real_data->CP}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/jquery.min.js"></script>
    <script src="/css/bootstrap/js/bootstrap.min.js"></script>
    <script src="/css/select2/js/select2.full.min.js"></script>
    <script src="/css/sweetalert/sweetalert.min.js"></script>
    <script src="/js/select2.js"></script>
    <script>
        var coor_lng = {{$coordinator['lng']}};
        var coor_lat = {{$coordinator['lat']}};
        var coor_ico = "{{$coordinator['icon']}}";
        var table = "{{$coordinator['table']}}";
        var direction = "{{$coordinator['direction']}}";
        var isla = "{{$coordinator['isla']}}";
        var zip = "{{$coordinator['zip']}}";
        var fax = "{{$coordinator['fax']}}";
        var mobile = "{{$coordinator['mobile']}}";
        var telephone = "{{$coordinator['telephone']}}";
        var email = "{{$coordinator['email']}}";
        var location_id = "{{$coordinator['id']}}";
        // console.log(coor_lng+":"+coor_lat);
        var map, infowindow , marker, i;
        var locations = [
          [direction+', '+isla+' '+zip, coor_lat, coor_lng, coor_ico, fax, mobile, telephone, email, location_id, table]
        ];
      function initMap() {
          map = new google.maps.Map(document.getElementById('map'), {
            zoom: 17,
            center: new google.maps.LatLng(coor_lat, coor_lng),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            draggable: false
          });

          infowindow = new google.maps.InfoWindow();

          for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
              position: new google.maps.LatLng(locations[i][1], locations[i][2]),
              map: map,
              icon: locations[i][3]
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                  var content = '<div id="iw-container">' +
                                '<div class="iw-title">'+locations[i][0]+'</div>' +
                                '<div class="iw-content">' +
                                  '<div class="iw-subTitle">Contacts</div>' +
                                  '<p>Address :'+locations[i][0]+'<br>'+
                                  '<br>Telephone: +34 '+locations[i][6]+'<br>Mobile: +34 '+locations[i][5]+'<br>E-mail: '+locations[i][7]+'</p>'+
                                  '<a href="/search-result/'+locations[i][8]+'/'+locations[i][9]+'" class="view-more-btn" target="_blank">SHOW MORE</a>'
                                '</div>' +
                                '<div class="iw-bottom-gradient"></div>' +
                              '</div>';
                infowindow.setContent(content);
                infowindow.open(map, marker);
              }
            })(marker, i));

            google.maps.event.addListener(map, 'click', function() {
              infowindow.close();
            });

            google.maps.event.addListener(infowindow, 'domready', function() {

               // Reference to the DIV that wraps the bottom of infowindow
               var iwOuter = $('.gm-style-iw');

               /* Since this div is in a position prior to .gm-div style-iw.
                * We use jQuery and create a iwBackground variable,
                * and took advantage of the existing reference .gm-style-iw for the previous div with .prev().
               */
               var iwBackground = iwOuter.prev();
               iwBackground.css({'display' :'none'});
               //
               // // Removes background shadow DIV
               // iwBackground.children(':nth-child(2)').css({'display' : 'none'});
               // //
               // // // Removes white background DIV
               // iwBackground.children(':nth-child(4)').css({'display' : 'none'});
               // //
               // // // Moves the infowindow 115px to the right.
               // // iwOuter.parent().parent().css({left: '115px'});
               // //
               // // // Moves the shadow of the arrow 76px to the left margin.
               // iwBackground.children(':nth-child(1)').attr('style', function(i,s){ return s + 'left: 76px !important;display:none;'});
               // //
               // // // Moves the arrow 76px to the left margin.
               // iwBackground.children(':nth-child(3)').attr('style', function(i,s){ return s + 'left: 76px !important;display:none;'});
               // //
               // // // Changes the desired tail shadow color.
               // iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index' : '1', 'display' :'none'});

               // Reference to the div that groups the close button elements.
               var iwCloseBtn = iwOuter.next();

               // Apply the desired effect to the close button
               iwCloseBtn.css({'box-sizing': 'unset',opacity: '1', right: '27px', top: '27px', border: '7px solid #48b5e9', 'border-radius': '13px', 'box-shadow': '0 0 5px #3990B9'});

               // If the content of infowindow not exceed the set maximum height, then the gradient is removed.
               if($('.iw-content').height() < 140){
                 $('.iw-bottom-gradient').css({display: 'none'});
               }

               // The API automatically applies 0.7 opacity to the button after the mouseout event. This function reverses this event to the desired value.
               iwCloseBtn.mouseout(function(){
                 $(this).css({opacity: '1'});
               });
             });
          }
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWP-4HQ3X1I4lauCjmcUto3xLaXutPbWw&callback=initMap" async defer></script>
    <script src="/js/search.js"></script>
  </body>
</html>
