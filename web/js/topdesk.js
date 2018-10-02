//gesloten laten zien
function show_gesloten(){
    var checkbox = document.getElementById("gesloten_checkbox");
    if(checkbox.checked){
        window.location.search = jQuery.query.set("show_closed", "true");
    }else{
        window.location.search = jQuery.query.set("show_closed", "false");
    }
}

//incident niet gevonden popper
var popcount = 1;
$("#searchform").submit(function(e){
    var forminfo = $("#searchform").serialize();
    e.preventDefault();
    $.ajax({
        url: "php/findincident.php?"+forminfo
    })
    .done(function( data ) {
        if ( console && console.log ) {
            if(data == "found"){
                window.location = "?controller=incidents&action=show&"+forminfo;
            }else{
                var newpop = $("#niet-gevonden-popper").clone().prop('id', 'niet-gevonden-popper'+popcount );
                $("#niet-gevonden-popper").parent().append(newpop);


                newpop.show();
                var popperobj = new Popper(zoekbalk, newpop, {
                    placement: 'bottom'
                });
                newpop.css('z-index', 9999);
                setTimeout(
                function() 
                {
                    newpop.remove();
                    popperobj.destroy();
                }, 2000);

                popcount++;
            }
        }
    });
});

var zoekbalk = document.getElementById("zoekbalk");
var popper = document.getElementById("niet-gevonden-popper");

//checken of gebruikers bestaan
function CheckUsers(ele,type){
    //ele   = element
    //type  = behandelaars/alle gebruikers
    $.ajax({
        url: "php/finduser.php?id="+ele.value+"&type="+type
    })
    .done(function( data ) {
        if ( console && console.log ) {
            if(data == "found"){
                $("#"+ele.id).removeClass("is-invalid").addClass('is-valid');
            }else{
                $("#"+ele.id).removeClass("is-valid").addClass('is-invalid');
            }
        }
    });
}