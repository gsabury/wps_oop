jQuery(document).ready(function ($) {
    $('#wps_oop_active_plugin').on('change', function () {
        var $this = $(this);
        var $result_wrapper = $('#result_message');
        $.ajax({
            url: WPS.ajax_url,
            type: 'post',
            dataType: 'json',
            data: {
                action: 'wps_save_general_settings',
                plugin_is_active: $this.prop('checked')
            },
            success: function (response) { //console.log(response);
                if (response.success) {
                    $result_wrapper.find('p').text(response.message);
                    $result_wrapper.slideDown(1000).delay(1000).slideUp(1000);
                }
            },
            error: function () {
                console.log('error in WPS ajax');
            }
        });
    });
});