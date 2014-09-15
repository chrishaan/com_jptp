    var Site = {

        vertical: function(){
            var list = $$('#trainer_bio');
            var headings = $$('#bio_toggle');

            var collapsibles = new Array();

            headings.each( function(heading, i) {
                var input = $E('input', heading);

                var collapsible = new Fx.Slide(list[i], {
                    duration: 250,
                    transition: Fx.Transitions.linear,
                    onComplete: function(request){
                        var open = request.getStyle('margin-top').toInt();
                        //input.checked = !input.checked;
                    }
                });

                collapsibles[i] = collapsible;

                heading.onclick = function(){
                    collapsible.toggle();
                    return false;
                }


                collapsible.hide();


            });
        }

    };

    window.addEvent('domready', Site.vertical);