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
    <link rel="stylesheet" href="/css/custom.css">
  </head>
  <body>
      <?php
        $island_class = "tenerife";
        if ($real_data->ISLA == "GRAN CANARIA") {
            $island_class = "gran_canaria";
        } elseif ($real_data->ISLA == "LA GOMERA") {
            $island_class = "la_gomera";
        } elseif ($real_data->ISLA == "LA PALMA") {
            $island_class = "la_palma";
        } elseif ($real_data->ISLA == "EL HIERRO") {
            $island_class = "el_hierro";
        } elseif ($real_data->ISLA == "LANZAROTE") {
            $island_class = "lanzarote";
        } elseif ($real_data->ISLA == "FUERTEVENTURA") {
            $island_class = "fuerteventura";
        }
      ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                <div class="total-result-container-div">
                    <div class="row">
                        <div class="header-img-container {{$island_class}}">
                            <p class="result-isla-title">{{$real_data->ISLA}}</p>
                        </div>
                        <div class="col-sm-12">
                            <p class="result-social-title">{{$real_data->RAZON_SOCIAL}}</p>
                        </div>
                    </div>
                    <div class="info-container" style="padding-top: 30px;">
                        <p class="result-map-title-text">Información general</p>
                        <div class="row">
                            <div class="col-sm-12">
                                <label>DIRECCION :</lavel>
                            </div>
                            <div class="col-md-12">
                                <label>{{$real_data->DIRECCION}} , {{$real_data->PROVINCIA}} {{$real_data->CP}}</label>
                            </div>
                        </div>
                        @if ($real_data->FAX != null || $real_data->FAX != "")
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Fax :</lavel>
                                </div>
                                <div class="col-sm-12">
                                    <label>{{$real_data->FAX}}</label>
                                </div>
                            </div>
                        @endif
                        @if ($real_data->MOVIL != null || $real_data->MOVIL != "")
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>MOVIL :</lavel>
                                </div>
                                <div class="col-sm-12">
                                    <label> <a href="tel:{{$real_data->MOVIL}}">{{$real_data->MOVIL}}</a></label>
                                </div>
                            </div>
                        @endif
                        @if ($real_data->TELEFONO != null || $real_data->TELEFONO != "")
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>TELEFONO :</lavel>
                                </div>
                                <div class="col-sm-12">
                                    <label> <a href="tel:{{$real_data->TELEFONO}}">{{$real_data->TELEFONO}}</a></label>
                                </div>
                            </div>
                        @endif
                        @if ($real_data->EMAIL != null || $real_data->EMAIL != "")
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>EMAIL :</lavel>
                                </div>
                                <div class="col-sm-12">
                                    <label> <a href="mailto:{{$real_data->EMAIL}}">{{$real_data->EMAIL}}</a></label>
                                </div>
                            </div>
                        @endif
                        @if ($real_data->WEB != null || $real_data->WEB != "")
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>WEB :</lavel>
                                </div>
                                <div class="col-sm-12">
                                    <label> <a href="{{$real_data->WEB}}">{{$real_data->WEB}}</a></label>
                                </div>
                            </div>
                        @endif
                        @if ($real_data->PRODUCTOS)
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="produtos-title-container">
                                        <p class="result-map-title-text">Productos</p>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label>{{$real_data->PRODUCTOS}}</label>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="map-title">
                                    <p class="result-map-title-text">
                                        Ubicación
                                        @if ($real_data->COORDENADA_X == null || $real_data->COORDENADA_X == "")
                                            <label class="result-page-map-location-incorrect">(esta no es la ubicación correcta)</label>
                                        @endif
                                    </p>
                                </div>
                                <div id="map" style="height:450px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/jquery.min.js"></script>
    <script src="/css/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(window).ready(function(){
            setheader_height();
        });
        $(window).resize(function(){
            setheader_height();
        })

        function setheader_height() {
            var header_img_con = $('.header-img-container');
            var current_width = header_img_con.width();
            header_img_con.css({'height' : current_width/6.7});
        }
    </script>
    <script type="text/javascript">
        var coor_lng = {{$coordinator['lng']}};
        var coor_lat = {{$coordinator['lat']}};
        var coor_ico = "{{$coordinator['icon']}}";
        function initMap() {
            var uluru = {lat: coor_lat, lng: coor_lng};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 17,
                center: uluru
            });
            var marker = new google.maps.Marker({
                position: uluru,
                map: map,
                icon: coor_ico
            });
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWP-4HQ3X1I4lauCjmcUto3xLaXutPbWw&callback=initMap" async defer></script>
  </body>
</html>
