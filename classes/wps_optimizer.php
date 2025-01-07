<?php
class WPS_Optimizer
{

    public function __construct()
    {
        echo 'Hello From ' . self::class;
    }

    public static function optimize()
    {
        //$post_id = (int) $post_id;
        $post_id = 0;

        $revisions = '';
        // Get the revisions
        $revisions = new WP_Query(array(
            'post_status'    => 'inherit',
            'post_type'      => 'revision',
            'showposts'      => -1,
            'posts_per_page' => -1,
            //'post_parent'    => $post_id
        ));

        if (empty($revisions))
            return false;

        // Remove the revisions the non-core-way
        global $wpdb;
        foreach ($revisions->posts as $revision) {
            $query = $wpdb->prepare(
                "
            DELETE FROM $wpdb->posts 
            WHERE ID = %d
            ",
                $revision->ID
            );
            $wpdb->query($query);
        }

        return TRUE;
    }

    public  static  function register()
    {
        if (!wp_next_scheduled('wps_oop_optimize_event')) {
            //Example: 2025-01-07 00:00:00
            wp_schedule_event(strtotime(date('Y-m-d 00:00:00')), 'daily', 'wps_oop_optimize_event');
        }
    }

    public static function unregister()
    {
        wp_clear_scheduled_hook('wps_oop_optimize_event');
    }
}
