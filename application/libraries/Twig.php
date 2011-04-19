<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

/**
 * @author Bennet Matschullat <bennet.matschullat@giantmedia.de>
 * @since 07.03.2011 - 12:00:39
 */


class Twig {
    
    const TWIG_CONFIG_FILE = "twig";
    
    protected $_template_dir;
    protected $_cache_dir;
    
    private $ci;
    private $_twig_env;
    
    /**
     * constructor of twig ci class
     */
    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->config->load(self::TWIG_CONFIG_FILE); // load config file
        
        // set include path for twig
        ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . APPPATH . 'third_party/Twig');
        require_once (string) 'Autoloader.php';
        
        // register autoloader        
        Twig_Autoloader::register();
        log_message('debug', 'twig autoloader loaded');
        
        // init paths
        $this->_template_dir = $this->ci->config->item('template_dir');
        $this->_cache_dir = $this->ci->config->item('cache_dir');
                
        // load environment
        $loader = new Twig_Loader_Filesystem($this->_template_dir, $this->_cache_dir);
        $this->_twig_env = new Twig_Environment($loader);
    }

    /**
     * render a twig template file
     * @param string $template template name
     * @param array $data contains all varnames'
     * @param boolean $return
     */
    public function render($template, $data = array(), $render = true)
    {
        $template = $this->_twig_env->loadTemplate($template);
        log_message('debug', 'twig template loaded');
        return ($render)?$template->render($data):$template;
    }
    
}