<?php

/**
 * @author Bennet Matschullat <bennet.matschullat@giantmedia.de>
 * @since 25.03.2011 - 11:50:07
 */


class Util {
    
    private $_ci;
    
    
    public function __construct()
    {
        $this->_ci =& get_instance();
    }
    
    
    public function base_url()
    {
        return base_url();
    }
    
    
    public function site_url($uri = "")
    {
        return site_url($uri);
    }
    
}
