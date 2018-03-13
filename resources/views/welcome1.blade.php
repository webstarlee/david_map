<!DOCTYPE html>
<html>
  <head>
    <!-- This stylesheet contains specific styles for displaying the map
         on this page. Replace it with your own styles as described in the
         documentation:
         https://developers.google.com/maps/documentation/javascript/tutorial -->
    <link rel="stylesheet" href="https://developers.google.com/maps/documentation/javascript/demos/demos.css">
    <style media="screen">
    img {
    	max-width: none !important;
    }
        .gm-style-iw {
            width: 350px !important;
            top: 15px !important;
            left: 0px !important;
            background-color: #fff;
            box-shadow: 0 1px 6px rgba(178, 178, 178, 0.6);
            border: 1px solid rgba(72, 181, 233, 0.6);
            border-radius: 2px 2px 10px 10px;
        }
        #iw-container {
            margin-bottom: 10px;
        }
        #iw-container .iw-title {
            font-family: 'Open Sans Condensed', sans-serif;
            font-size: 22px;
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
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyCWP-4HQ3X1I4lauCjmcUto3xLaXutPbWw"></script>
    <script type="text/javascript">
      var delay = 100;
      var infowindow = new google.maps.InfoWindow();
      var latlng = new google.maps.LatLng(51.0000, 78.0000);
      var mapOptions = {
        zoom: 15,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      }
      var geocoder = new google.maps.Geocoder();
      var map = new google.maps.Map(document.getElementById("map"), mapOptions);
      var bounds = new google.maps.LatLngBounds();

      function geocodeAddress(address) {
          console.log(address);
          console.log(address[1]);
          var real_address = address[1];
        geocoder.geocode({address:real_address}, function (results,status) {
             if (status == google.maps.GeocoderStatus.OK) {
              var p = results[0].geometry.location;
              var lat=p.lat();
              var lng=p.lng();
              createMarker(address,lat,lng);
            }
            else {
               if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
                nextAddress--;
                delay++;
              } else {
                            }
            }
            theNext();
          }
        );
      }

      var content = '<div id="iw-container">' +
                    '<div class="iw-title">Porcelain Factory of Vista Alegre</div>' +
                    '<div class="iw-content">' +
                      '<div class="iw-subTitle">History</div>' +
                      '<img src="http://maps.marnoto.com/en/5wayscustomizeinfowindow/images/vistalegre.jpg" alt="Porcelain Factory of Vista Alegre" height="115" width="83">' +
                      '<p>Founded in 1824, the Porcelain Factory of Vista Alegre was the first industrial unit dedicated to porcelain production in Portugal. For the foundation and success of this risky industrial development was crucial the spirit of persistence of its founder, José Ferreira Pinto Basto. Leading figure in Portuguese society of the nineteenth century farm owner, daring dealer, wisely incorporated the liberal ideas of the century, having become "the first example of free enterprise" in Portugal.</p>' +
                      '<div class="iw-subTitle">Contacts</div>' +
                      '<p>VISTA ALEGRE ATLANTIS, SA<br>3830-292 Ílhavo - Portugal<br>'+
                      '<br>Phone. +351 234 320 600<br>e-mail: geral@vaa.pt<br>www: www.myvistaalegre.com</p>'+
                    '</div>' +
                    '<div class="iw-bottom-gradient"></div>' +
                  '</div>';

     function createMarker(add,lat,lng) {
       var contentString = add[0];
       var marker = new google.maps.Marker({
         position: new google.maps.LatLng(lat,lng),
         map: map,
         icon: add[2]
               });

       var infowindow = new google.maps.InfoWindow({
           content: content,
           maxWidth: 350
         });

         google.maps.event.addListener(marker, 'click', function() {
             infowindow.close();
           infowindow.open(map,marker);
         });

         // Event that closes the Info Window with a click on the map
         google.maps.event.addListener(map, 'click', function() {
           infowindow.close();
         });

         google.maps.event.addListener(map, 'idle', function() {
          var bounds = map.getBounds();

          console.log('North East: ' +
                      bounds.getNorthEast().lat() + ' ' +
                      bounds.getNorthEast().lng());

          console.log('South West: ' +
                      bounds.getSouthWest().lat() + ' ' +
                      bounds.getSouthWest().lng());

          // Your AJAX code in here ...
        });

         google.maps.event.addListener(infowindow, 'domready', function() {

            // Reference to the DIV that wraps the bottom of infowindow
            var iwOuter = $('.gm-style-iw');

            /* Since this div is in a position prior to .gm-div style-iw.
             * We use jQuery and create a iwBackground variable,
             * and took advantage of the existing reference .gm-style-iw for the previous div with .prev().
            */
            var iwBackground = iwOuter.prev();

            // Removes background shadow DIV
            iwBackground.children(':nth-child(2)').css({'display' : 'none'});
            //
            // // Removes white background DIV
            iwBackground.children(':nth-child(4)').css({'display' : 'none'});
            //
            // // Moves the infowindow 115px to the right.
            // iwOuter.parent().parent().css({left: '115px'});
            //
            // // Moves the shadow of the arrow 76px to the left margin.
            // iwBackground.children(':nth-child(1)').attr('style', function(i,s){ return s + 'left: 76px !important;'});
            //
            // // Moves the arrow 76px to the left margin.
            // iwBackground.children(':nth-child(3)').attr('style', function(i,s){ return s + 'left: 76px !important;'});
            //
            // // Changes the desired tail shadow color.
            // iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index' : '1'});

            // Reference to the div that groups the close button elements.
            var iwCloseBtn = iwOuter.next();

            // Apply the desired effect to the close button
            iwCloseBtn.css({opacity: '1', right: '38px', top: '3px', border: '7px solid #48b5e9', 'border-radius': '13px', 'box-shadow': '0 0 5px #3990B9'});

            // If the content of infowindow not exceed the set maximum height, then the gradient is removed.
            if($('.iw-content').height() < 140){
              $('.iw-bottom-gradient').css({display: 'none'});
            }

            // The API automatically applies 0.7 opacity to the button after the mouseout event. This function reverses this event to the desired value.
            iwCloseBtn.mouseout(function(){
              $(this).css({opacity: '1'});
            });
          });

       bounds.extend(marker.position);
       map.initialZoom = true;

     }
     var locations = [
         ['San Francisco: Power Outage', 'New Delhi, India','http://local.director.com/images/2.png'],
           ['Sausalito', 'Bangaluru, Karnataka, India','http://local.director.com/images/2.png'],
           ['Sacramento', 'Cannaught Place, New Delhi, India','http://local.director.com/images/2.png'],
           ['Soledad', 'Jammu, India','http://local.director.com/images/2.png'],
           ['Shingletown', 'Shillong, India','http://local.director.com/images/2.png']
     ];
      var nextAddress = 0;
      function theNext() {
        if (nextAddress < locations.length) {
          setTimeout( function(){
              geocodeAddress(locations[nextAddress]);
              nextAddress++;
          }, delay);
        } else {
          map.fitBounds(bounds);
        }
      }

      theNext();

    </script>
  </body>
</html>
