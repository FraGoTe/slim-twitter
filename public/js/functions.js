$(document).ready(function () {
    func.loadScript();
    
    $('#searchTweet').on('click', function(){
        func.searchData();
    });
    
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            func.searchData();
            event.preventDefault();
            return false;
        }
    });
    
    func.searchData();
    
    setInterval(function(){ alert("Hello"); }, 30000);
});

function initialize() {
    var mapProp = {
        center: new google.maps.LatLng(-12.0553442, -77.0451853),
        zoom: 5,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
}