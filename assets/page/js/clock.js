(function($) {

    var defaults = {
        text         : 'Hello, World!',
        color        : null,
        fontStyle    : null,
        before       : function () {$('body').css('background', 'yellow')},
        complete     : null
    };

    $.fn.simpleClock = function() {

        function currentTimeString ()
        {
            var currentTime = new Date ( );
          	var currentHours = currentTime.getHours ( );
          	var currentMinutes = currentTime.getMinutes ( );
          	var currentSeconds = currentTime.getSeconds ( );

          	currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
          	currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;
          	currentHours = ( currentHours == 0 ) ? 12 : currentHours;

          	// Compose the string for display
          	var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds;
            return currentTimeString;
        }

        this.each( function () {
            _this = $(this);
            setInterval(function(){
                _this.text(currentTimeString());
            },1000);

        });

        return this;
    }

}(jQuery));
