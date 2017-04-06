<?php
if (!isSet($d)) $d = $this->event->getEmptyEvent();
?>


<div class="calendar-event-box">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 calendar-event-box-time">
            <div class="calendar-event_time">
                <div class="event_start_full_date"><?=$d['event_start_full_date']?></div>
                <div class="event_time_start"><?=$d['event_time_start']?></div>
                <div class="event_time_end"><?=$d['event_time_end']?></div>
                <div class="event_end_full_date"><?=$d['event_end_full_date']?></div>
            </div>
            <div class="calendar-event_start">
                <div class="event_start_day"><?=$d['event_start_day']?></div>
                <div class="event_start_month"><?=$d['event_start_month']?></div>
            </div>
            <div class="calendar-event_end">
                <div class="event_end_day"><?=$d['event_end_day']?></div>
                <div class="event_end_month"><?=$d['event_end_month']?></div>
            </div>
        </div>

        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
            <h4 class="event_tytul"><?=$d['event_tytul']?></h4>
            <p class="calendar-infos">
                <span class="calendar-info">
                    <span class="calendar-organizer">
                        <span class="event_organizer"><?=$d['event_organizer']?></span>
                    </span>
                    <span class="calendar-location">
                        <span class="fa fa-map-marker"></span>
                        <span class="event_location_data"><?=$d['event_location_data']?></span>
                    </span>
                </span>
                <span class="event_tags"><?=$d['event_tags']?></span>
            </p>
        </div>
</div>
