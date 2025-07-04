<?php

class YourChildPluginClass
{

    public function __construct()
    {
        // Add your filter in the constructor or appropriate hook.
        add_filter('weddingdir/meta', array($this, 'modify_weddingdir_listing_setting'), 10, 1);
    }

  
}

// Instantiate your child plugin class.
$child_plugin_instance = new YourChildPluginClass();
