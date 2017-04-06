(function($) {
    $(function() {
        $.datepicker._updateDatepicker_original = $.datepicker._updateDatepicker;
        $.datepicker._updateDatepicker = function(inst) {
            $.datepicker._updateDatepicker_original(inst);
            var afterShow = this._get(inst, 'afterShow');
            if (afterShow)
                afterShow.apply((inst.input ? inst.input[0] : null));  // trigger custom callback
        }
    });

    if ($('.calendar').length > 0)
		{
            var calendarPG = {

                $calendar_date : $('.calendar-date'),
                $calendar_data : $('.calendar-data'),
                currentDate : formatDate(new Date()),
                xhr : false,
                init: function () {
                    var that = this;
                    that.$calendar_data.addClass('loading');
                    $.when( $.ajax({url: "ajax/getInitialDataForCalendar", dataType: 'json' }),
                            $.ajax({url: "ajax/getTemplateForCalendar", dataType: 'html' }) )
                        .done(function( ret, template ) {
                            that.template = template[0];
                            that.showCalendar(ret[0].dates);
                            that.showEvents(ret[0].events);

                    });
                },

                showCalendar: function (dates) {
                    this.availableDates = dates;
                    var that = this;
                    that.$calendar_date.datepicker({
        				beforeShowDay: this.available.bind(this),
                        afterShow: that.showEventsCount.bind(this),
                        onSelect: function (d) {
                            that.showEventsCount.bind(this);
                            if (that.currentDate != d)
                                {
                                    if (that.xhr) that.xhr.abort();
                                    that.$calendar_data.html('');
                                    that.$calendar_data.addClass('loading');
                                    that.getEvents(d);
                                }
                            that.currentDate = d;
                        },
        				changeMonth: true
        		    });
                    this.showEventsCount();
                },

                showEventsCount: function () {
                    $('.ui-datepicker-calendar').find('td.events').each(function(){
                        var events = $(this).attr('title').split(' ')[0];
                        $('<span class="calendar-event-count">'+events+'</span>').appendTo($(this));
                    });
                },

                available: function (date) {
				    var day = date.getDate() < 10 ? '0'+date.getDate() : date.getDate();
    				var month = (date.getMonth()+1) < 10 ? '0'+(date.getMonth()+1) : (date.getMonth()+1);
    				var ymd = date.getFullYear() + "-" + month + "-" + day;
    				if (typeof this.availableDates[ymd] !== "undefined")
                        {
    					    return [true, "events",this.availableDates[ymd] + ' events'];
    				    }
                    else
                        {
    					    return [false,"",""];
    				    }
    			},

                getEvents: function (date) {
                    var that = this;
                    that.xhr = $.ajax({
                        url: "ajax/getOneDayForCalendar",
                        data: {date: date},
                        dataType: 'json',
                        success: that.showEvents.bind(that)});
                },

                showEvents: function (events) {

                    var that = this;
                    var temp;
                    that.$calendar_data.removeClass('loading');
                    $.each(events, function( index, value ) {
                        temp = $(that.template);
                        $.each(value, function( e_i, e_v ) {
                            temp.find('.' + e_i).html(e_v);
                        });

                        if (value.event_location_data == '')
                            {
                                temp.find('.fa-map-marker').hide();
                            }

                        temp.css({
                            'background-image' : 'url(img/flags/'+ value.event_country +'_cut.png)',
                            'background-position' : 'top right',
                            'background-repeat' : 'no-repeat'
                        });

                        temp.appendTo(that.$calendar_data);

                        if (value.event_lat != 0 && value.event_lng != 0)
                        {
                            temp.click(that.showMap(temp, value));
                        }
                        else
                        {
                            temp.unbind('click');
                            temp.find('.event_tytul').append('<a class="calendar-showMore" href="'+value.event_tytul_frd+'">zobacz więcej</a>');
                        }


                    });
                },

                showMap: function (t, v) {
                    return function (e) {
                        var temp = $('<div class="mapka loading"></div>');
                        temp.insertAfter(t);
                        var mapa = new google.maps.Map(temp.get(0), {
                            center: {lat: parseFloat(v.event_lat), lng: parseFloat(v.event_lng)},
                            zoom: 15
                        });

                        var opcjeMarkera =
            			{
            				position: {lat: parseFloat(v.event_lat), lng: parseFloat(v.event_lng)},
                            map: mapa
            			}
            			var marker = new google.maps.Marker(opcjeMarkera);

                        t.unbind('click');
                        t.find('.event_tytul').append('<a class="calendar-showMore" href="'+v.event_tytul_frd+'">zobacz więcej</a>');
                    }
                }


            };

            calendarPG.init();
		}


function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

}(jQuery));
