$(function(){
    $('a.ajax').live('click', function() {
        var link = $(this);
        var point = map.getMap().getCenter();
        $.ajax({
            url: link.attr('href') + '?geo_lat=' + point.lat() + '&geo_lng=' + point.lng(),
            type: link.hasClass('ajax-post') ? 'post' : 'get',
            dataType: 'html',
            cache: false,
            timeout: 5000,
            beforeSend: function() {
                $('#content .content').hide();
                $('#content .loader').fadeIn(100);
            },
            success: function(data, statusCode) {
                if (link.hasClass('hl')) {
                    $('a.ajax.hl').parent().removeClass('active');
                    link.parent().addClass('active');
                }
                $('#content .loader').hide();
                $('#content .content').html(data).show();
            }
        });
        return false;
    });

});