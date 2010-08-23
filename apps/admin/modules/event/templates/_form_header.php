<script type="text/javascript">
$(function(){
    $('.datepicker').datetimepicker({
        showButtonPanel: false,
        minDate: '<?php echo date('d.m.Y') ?>',
        timeFormat: 'hh:mm'
    });
});
</script>