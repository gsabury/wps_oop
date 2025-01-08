<div class="wrap">
    <h1><?php _e("WordPress Optemization Settings:", 'wps_oop') ?></h1>
    <h2 class="nav-tab-wrapper">
        <?php foreach ($tabs as $tab_class): ?>
            <?php
            $tab_class_object = new $tab_class();
            $settings_pool[$tab_class_object->get_name()] = $tab_class_object;
            $current_tab_class = $current_tab == $tab_class_object->get_name() ? 'nav-tab-active' : '';
            ?>
            <a href="<?php echo add_query_arg(array('tab' => $tab_class_object->get_name())); ?>" class="nav-tab <?php echo $current_tab_class; ?>"><?php echo $tab_class_object->get_title(); ?></a>
        <?php endforeach; ?>
    </h2>
    <form action="" method="post">
        <?php $settings_pool[$current_tab]->load_body(); ?>
        <?php //wp_nonce_field('wps_oop_save_settings', '_wpnonce'); 
        ?>
        <?php
        if ($current_tab != "general") {
            submit_button(__('Save Settings', 'wps_oop'));
        }
        ?>
    </form>
</div>