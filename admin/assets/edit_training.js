function attach_approval(){
    var link = "index.php?option=com_jptp&controller=trainings&task=add_approval";
    var post_data = {training_id: $('id').value, lic_id: $('licensing_orgs').value };
    new Ajax( link, {
        method: 'post',
        data: post_data,
        onComplete: make_remove_links
        
    }).request();
}

function remove_approval( lic_id ){
    var link = "index.php?option=com_jptp&controller=trainings&task=remove_approval";
    var post_data = {training_id: $('id').value, lic_id: lic_id };
    new Ajax( link, {
        method: 'post',
        data: post_data,
        onComplete: make_remove_links
    }).request();

}

function make_remove_links( response ){
    $('approvals').innerHTML = '';
    approvals = eval(response);
    output = '<ul style="list-style-type: none;">';
    for(i = 0; i < approvals.length; i++) {
       output += '<li><a href="#" id=' + approvals[i]['id'] + ' style="color: red;" title="Remove">[X]</a> ' + approvals[i]["name"] + "</li>";   
    }
    output += "</ul>";
    $('approvals').innerHTML = output;
    $('approvals').getElements('a').each( function(el){
            el.addEvent('click', function( lic_id){
                remove_approval( lic_id );
            }.pass(el.id));
    });
}

function get_approvals(){
    var link = "index.php?option=com_jptp&controller=trainings&task=get_approvals&training_id=" + $('id').value;
    new Ajax( link, {
        method: 'get',
        onComplete: make_remove_links
    }).request();
}

window.addEvent('load', function(){
    get_approvals();
    if( $('id').value == 0) {
       $('add_approval').disabled = true;
    }    
})