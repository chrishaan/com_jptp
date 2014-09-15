window.addEvent('load', function(){
    if( $('id').value == 0){
        $('registration_time').value = "09:00:00";
        $('start_time').value = "09:30:00";
        $('end_time').value = "16:30:00";
        $('start2_time').value = "09:00:00";
        $('end2_time').value = "16:00:00";        
    }
    time_init();
})

function time_init(){
    $$('input[type=time]').each( function(el){
        el.setAttribute("type", "hidden");
        var parent = el.getParent();
        var base_name = el.id.substring( 0, el.id.length - 4 );
        var hour_select = document.createElement("select");
        hour_select.setAttribute("id", base_name + "hour");
        //var blank_option = document.createElement("option");
        //hour_select.appendChild( blank_option);
        for( i = 1; i < 13; i++) {
            var option = document.createElement("option");
            option.setAttribute("value", (i < 10 ) ? '0' + i.toString() :  i.toString());
            option.innerHTML = (i < 10 ) ? '0' + i.toString() :  i.toString();
            hour_select.appendChild(option)
        }
        var minute_select = document.createElement("select");
        minute_select.setAttribute("id", base_name + "minute");
        //minute_select.appendChild( blank_option.cloneNode(false) );
        for( i = 0; i < 60; i += 15 ) {
            var minute_option = document.createElement("option");
            minute_option.setAttribute("value", (i < 10) ? '0' + i.toString() : i.toString());
            minute_option.innerHTML = (i < 10) ? '0' + i.toString() : i.toString();
            minute_select.appendChild(minute_option);
        }
        var ampm_select = document.createElement("select");
        ampm_select.setAttribute("id", base_name + "ampm");
        //ampm_select.appendChild( blank_option.cloneNode(false) );
        var am_option = document.createElement("option");
        am_option.setAttribute("value", "AM");
        am_option.innerHTML = "AM";
        var pm_option = document.createElement("option");
        pm_option.setAttribute("value", "PM");
        pm_option.innerHTML = "PM";
        ampm_select.appendChild( am_option );
        ampm_select.appendChild( pm_option );
        parent.appendChild(hour_select);
        parent.appendChild( document.createTextNode(" : "));
        parent.appendChild(minute_select);
        parent.appendChild( document.createTextNode(" "));
        parent.appendChild(ampm_select);
        
 // ++++++++++++++++++++  set initial time from hidden input
        var hms = $( base_name + "time").value.split(":");
        hms[0] = hms[0] * 1; // convert hour to an int
	$( base_name + "ampm").value = ( hms[0] > 11) ? "PM" : "AM";
        if( hms[0] > 11 ) { hms[0] = hms[0] - 12; }	
        $( base_name + "hour").value = ( hms[0] < 10) ? "0" + hms[0] : "" + hms[0]; // convert hour to string
	$( base_name + "minute").value = hms[1];
           
        
        hour_select.addEvent('change', function(){
            update_time( base_name );
        })
        minute_select.addEvent('change', function(){
            update_time( base_name );
        })
        ampm_select.addEvent('change', function(){
            update_time( base_name );
        })
        //el.remove();
    })
}

function update_time( base_name ){
    var hour = $(base_name + "hour").value;
    if ($(base_name + 'ampm').value == "PM") {
        if (hour < 12){
            hour = (hour * 1) + 12;
        }
    }
    if ($(base_name + 'ampm').value == "AM") {
        if (hour >= 12){
            hour = (hour * 1) - 12;
        }
    }
    if (parseInt( hour ) == 24 ) {
        hour = "00";
    }
    var time = hour + ":" + $(base_name + "minute").value + ":00";
    $( base_name + "time").value = time;
}
