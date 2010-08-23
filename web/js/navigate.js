$(function(){
    $('a.ajax').live('click', function() {
        var link = $(this);
        var point = map.getMap().getCenter();
        var glue = link.attr('href').indexOf('?') > 0 ? '&' : '?';
        var target = link.attr('rel') ? link.attr('rel') : '#content';

        $.ajax({
            url: link.attr('href') + glue + 'geo_lat=' + point.lat() + '&geo_lng=' + point.lng(),
            type: link.hasClass('ajax-post') ? 'post' : 'get',
            dataType: 'html',
            cache: false,
            timeout: 5000,
            beforeSend: function() {
                $(target + ' .content').hide();
                $(target + ' .loader').fadeIn(100);
            },
            success: function(data, statusCode) {
                if (link.hasClass('hl')) {
                    $('a.ajax.hl').parent().removeClass('active');
                    link.parent().addClass('active');
                }
                $(target + ' .loader').hide();
                $(target + ' .content').html(data).show();
            }
        });
        return false;
    });

    $("a.overlay[rel]").live('click', function(event){
        event.preventDefault();

        $(this).overlay({
            onBeforeLoad: function() {
                $('#overlay .content').html('');
                $('#overlay .loader').show();
                $('#overlay .content').load(this.getTrigger().attr("href"));
            },
            onLoad: function() {
                $('#overlay .content').show();
                $('#overlay .loader').hide();
            },
            load: true
        });
    });
});