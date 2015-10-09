$(document).ready(function(){

    $(".active").click(function(){
		var self = $(this);
		self.parent().children("dd").slideToggle();
	});
    $(".qx").click(function(){
        //var self = $(this);
        //self.parent().parent().children("dd").slideUp();
    });

    $('dd.dd-product').each(function (i) {
        if($(this).attr('featured')==1){
            $(this).find('p').css({color:'#ff3300',weight:'bold'});
        }
    });

    $('dd.dd-product').click(function () {
        var dd = $(this);
        var dt = dd.parent().find('dt');
        var featured = dd.attr('featured');
        var featuredMsg = '';
        if(featured==1){
            featuredMsg = '<i>推荐</i>';
        }

        var p_name = dd.find('p').html();
        var p_price = dd.find('span').html();
        var p_value = dd.find('input').val();

        var temp_name = dt.find('.s-title').html();
        var temp_featured =  dt.find('.s-title').attr('featured');
        var temp_price =  dt.find('.s-title-price').html();

        dt.find('.s-title').html(p_name + featuredMsg);
        dt.find('.s-title').attr('featured' ,featured);
        dt.find('.s-title-price').html(p_price);
        dt.find('input').val(p_value);

        dd.parent().find('dd').slideUp();
        ChePre();
        //dd.find('p').html(temp_name);
        //dd.attr('featured' ,temp_featured);
        //dd.find('span').html(temp_price);

    });



    $('dd.dd-cancel').click(function () {
        var dd = $(this);
        var dt = dd.parent().find('dt');

        var temp_name = dt.find('.s-title').html();
        var temp_featured =  dt.find('.s-title').attr('featured');
        var temp_price =  dt.find('.s-title-price').html();
        json={featured:temp_featured,name:temp_name,price:temp_price};

        //var html = buildDd(json);
        //clearActive(dt);
        $.each(dt.find('span'), function () {
            $(this).html($(this).attr('data-content'));
        });
        $.each(dt.find('input'), function () {
            $(this).val($(this).attr('data-content'));
        });

        dd.parent().find('dd').slideUp();
        ChePre();
        //dt.find('p').html(dt.find('p'));
        //dt.attr('featured' ,'0');
        //dt.find('span').html('');
        //
        //dd.before(html);
    });

    function clearActive(dt){
        dt.find('p').html();
        dt.attr('featured' ,'0');
        dt.find('span').html();
    }
    function buildDd(json){

        var dd = '<dd class="dd-product"  featured="'+json.featured+'" style="display:block;">'+
            '<p>'+json.name +'</p>'+
            '<span>'+json.price+'</span>'+
            '</dd>';
       return dd;
    }

    $("#qita").click(function(){
        $.each($('dt').find('span'), function () {
            $(this).html($(this).attr('data-content'));
        });
        $.each($('dt').find('input'), function () {
            $(this).val($(this).attr('data-content'));
        });
        ChePre();
    });


    function initializeDefault(){
        $.each($('dd.dd-product'),function(k,v){
            if($(this).attr('featured')=='1'){
                $(this).trigger('click');
            }  
        }); 
    }
    initializeDefault();

});
$.fn.toggle = function( fn ) {
                // Save reference to arguments for access in closure
                var args = arguments,
                        guid = fn.guid || jQuery.guid++,
                        i = 0,
                        toggler = function( event ) {
                            // Figure out which function to execute
                            var lastToggle = ( jQuery._data( this, "lastToggle" + fn.guid ) || 0 ) % i;
                            jQuery._data( this, "lastToggle" + fn.guid, lastToggle + 1 );

                            // Make sure that clicks stop
                            event.preventDefault();

                            // and execute the function
                            return args[ lastToggle ].apply( this, arguments ) || false;
                        };

                // link all the functions, so any of them can unbind this click handler
                toggler.guid = guid;
                while ( i < args.length ) {
                    args[ i++ ].guid = guid;
                }

                return this.click( toggler );
            }
