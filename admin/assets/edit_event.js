function attach_trainer(){
    var link = "index.php?option=com_jptp&controller=events&task=add_trainer";
    var post_data = {'event_id': $('id').value, 'trainer_id': $('all_trainers').value };
    new Ajax( link, {
        method: 'post',
        data: post_data,
        onComplete: make_remove_links
        
    }).request();
}

function remove_trainer( trainer_id ){
    var link = "index.php?option=com_jptp&controller=events&task=remove_trainer";
    var post_data = {'event_id': $('id').value, 'trainer_id': trainer_id };
    new Ajax( link, {
        method: 'post',
        data: post_data,
        onComplete: make_remove_links
    }).request();

}

function make_remove_links( response ){
    $('trainers').innerHTML = '';
    if ($('id').value == 0 ){ return; }
    trainers = eval( response );
    output = '<ul style="list-style-type: none;">';
    for(i = 0; i < trainers.length; i++) {
       output += '<li><a href="#" id=' + trainers[i]['id'] + ' style="color: red;" title="Remove">[X]</a> ' + trainers[i]["name"] + "</li>";   
    }
    output += "</ul>";
    $('trainers').innerHTML = output;
    $('trainers').getElements('a').each( function(el){
            el.addEvent('click', function( trainer_id){
                remove_trainer( trainer_id );
            }.pass(el.id));
    });
}

function get_trainers(){
    var link = "index.php?option=com_jptp&controller=events&task=get_trainers&event_id=" + $('id').value;
    new Ajax( link, {
        method: 'get',
        onComplete: make_remove_links
    }).request();
}

window.addEvent('load', function(){
    get_trainers();
    if( $('id').value == 0) {
       $('add_trainer').disabled = true;
    }
})
