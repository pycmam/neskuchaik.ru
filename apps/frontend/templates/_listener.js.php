<?php
/**
 * Обработчик события клика по маркеру
 *
 * @param array|Point $point
 */
?>
$.ajax({
    url: '<?php echo url_for($point['model'] . '_show', array('id' => $point['id'])) ?>',
    type: 'get',
    dataType: 'html',
    cache: false,
    timeout: 5000,
    beforeSend: function() {
        $('#content .content').hide();
        $('#content .loader').fadeIn(100);
    },
    success: function(data, statusCode) {
        $('#content .loader').hide();
        $('#content .content').html(data).show();
    }
});
