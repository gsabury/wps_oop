<table class="form-table">
    <tr>
        <th scope="row">Active / Inactive: </th>
        <td>
            <input
                type="checkbox"
                name="wps_oop_active_plugin"
                <?php checked(1,isset($wps_options[ 'general' ][ 'is_plugin_active' ]) ? intval($wps_options[ 'general' ][ 'is_plugin_active' ]) : 0) ?>
            >
        </td>
    </tr>
</table>