
(function($){

    // CheckIn CheckOut Datepicker
    $("#theme_rooms_arrival_date, #theme_rooms_departure_date").datepicker({
        dateFormat: 'mm/dd/yy',
        buttonImage: 'images/calendar.gif',
        minDate: '-0d',
        changeMonth: true,
        changeYear: true,
        yearRange: '0:+2',
    });

})(jQuery);