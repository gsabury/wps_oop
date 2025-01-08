<div style="display: none;" id="result_message" class="notice  notice-success">
    <p></p>
</div>

<table class="form-table">
    <tr>
        <th scope="row"><?php _e('Is plugin active : ', 'wps_oop'); ?></th>
        <td>
            <input
                type="checkbox"
                name="wps_oop_active_plugin"
                id="wps_oop_active_plugin"
                <?php checked(1, isset($wps_options['general']['is_plugin_active']) ? intval($wps_options['general']['is_plugin_active']) : 0) ?>>
            <input type="hidden" name="_wpnonce" value="<?php echo esc_attr(wp_create_nonce('wps_oop_save_settings')); ?>" />

        </td>
    </tr>
</table>