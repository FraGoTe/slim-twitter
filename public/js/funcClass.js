// Declare Global vars
var map;

var func = {};

func.loadScript = function() {
    var script = document.createElement("script");
    script.src = "http://maps.googleapis.com/maps/api/js?callback=initialize";
    document.body.appendChild(script);
};

func.searchData = function() {
    $.ajax({
        url: '/search-twitter.php',
        data: $('#frm-search').serialize(),
        method: 'POST',
        success: function (data, textStatus, jqXHR) {
            initialize();
            $('#tweetTable').html('');
            
            var i = 0;
            var marker;
            var dataJson = JSON.parse(data);
            
            var bounds = new google.maps.LatLngBounds();
            $.each(dataJson, function(index, value){
                if (typeof(value.user.profile_image_url) !== 'undefined') {
                    var imgData;
                    if (value.retweeted === true) {
                        imgData = '<img src="' + value.retweeted_status.user.profile_image_url + '"/>';
                    } else {
                        imgData = '<img src="' + value.user.profile_image_url + '"/>';
                    }

                    var rowData = '<tr><td class="rmBorRight">' + imgData + '</td><td>' +  
                                    value.text + '<br/><small>' + 
                                    'ssadsasdasd</small></td>' +
                                    '</tr>';

                    //point to map
                    if (typeof(value.geo) !== 'undefined' && value.geo !== null) {
                        marker = new google.maps.Marker({
                            position: new google.maps.LatLng(value.geo.coordinates[0], value.geo.coordinates[1]),
                            map: map
                        });
                        var infowindow = new google.maps.InfoWindow();
                        bounds.extend(marker.position);
                        google.maps.event.addListener(marker, 'click', (function(marker, i) {
                          return function() {
                            infowindow.setContent(rowData);
                            infowindow.open(map, marker);
                          };
                        })(marker, i));

                        i++;
                    }

                    $('#tweetTable').append(rowData);
                }
                map.fitBounds(bounds);
            });
            
            if (i === 0) {
                alert('We didn\'t find geolocalizations in the following 10 tweets');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
             alert('We have detected some problems, please try it again.' + textStatus);
            console.log(errorThrown);
        }
    });
};