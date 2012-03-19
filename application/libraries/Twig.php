<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

/**
 * @author Bennet Matschullat <hello@bennet-matschullat.com>
 * @since 07.03.2011 - 12:00:39
 */


class Twig {
    
    const TWIG_CONFIG_FILE = "twig";
    
    protected $_template_dir;
    protected $_cache_dir;
    
    private $_ci;
    private $_twig_env;
    
    /**
     * constructor of twig ci class
     */
    public function __construct()
    {
        $this->_ci =& get_instance();
        $this->_ci->config->load(self::TWIG_CONFIG_FILE); // load config file
        
        // set include path for twig
        ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . APPPATH . 'third_party/Twig/lib/Twig');
        require_once (string) 'Autoloader.php';
        
        // register autoloader        
        Twig_Autoloader::register();
        log_message('debug', 'twig autoloader loaded');
        
        // init paths
        $this->_template_dir = $this->_ci->config->item('template_dir');
        $this->_cache_dir = $this->_ci->config->item('cache_dir');
                
        // load environment
        $loader = new Twig_Loader_Filesystem($this->_template_dir, $this->_cache_dir);
        $this->_twig_env = new Twig_Environment($loader);
        
        $this->_ciFunctionInit();
    }

    /**
     * render a twig template file
     * @param string $template template name
     * @param array $data contains all varnames
     * @param boolean $return
     */
    public function render($template, $data = array(), $render = true)
    {
        $template = $this->_twig_env->loadTemplate($template);
        log_message('debug', 'twig template loaded');
        return ($render)?$template->render($data):$template;
    }
    
    
    /**
     * @param string $template
     * @param array $data
     */
    public function display($template, $data = array())
    {
    	$obj = $this->_twig_env->loadTemplate($template);
    	$this->_ci->output->set_output($obj->render($data));
    }
    
    
    public function registerFunction($name, Twig_FunctionInterface $function)
    {
    	$this->_twig_env->addFunction($name, $function);
    }
    
    
    public function _ciFunctionInit()
    {
    	$this->_twig_env->addFunction('base_url', new Twig_Function_Function('base_url'));
    	$this->_twig_env->addFunction('site_url', new Twig_Function_Function('site_url'));
    	$this->_twig_env->addFunction('current_url', new Twig_Function_Function('current_url'));    
        
    	// form functions
    	$this->_twig_env->addFunction('form_open', new Twig_Function_Function('form_open'));
    	$this->_twig_env->addFunction('form_hidden', new Twig_Function_Function('form_hidden'));
    	$this->_twig_env->addFunction('form_input', new Twig_Function_Function('form_input'));
    	$this->_twig_env->addFunction('form_password', new Twig_Function_Function('form_password'));
    	$this->_twig_env->addFunction('form_upload', new Twig_Function_Function('form_upload'));
    	$this->_twig_env->addFunction('form_textarea', new Twig_Function_Function('form_textarea'));
    	$this->_twig_env->addFunction('form_dropdown', new Twig_Function_Function('form_dropdown'));
    	$this->_twig_env->addFunction('form_multiselect', new Twig_Function_Function('form_multiselect'));
    	$this->_twig_env->addFunction('form_fieldset', new Twig_Function_Function('form_fieldset'));
    	$this->_twig_env->addFunction('form_fieldset_close', new Twig_Function_Function('form_fieldset_close'));
    	$this->_twig_env->addFunction('form_checkbox', new Twig_Function_Function('form_checkbox'));
    	$this->_twig_env->addFunction('form_radio', new Twig_Function_Function('form_radio'));
    	$this->_twig_env->addFunction('form_submit', new Twig_Function_Function('form_submit'));
    	$this->_twig_env->addFunction('form_label', new Twig_Function_Function('form_label'));
    	$this->_twig_env->addFunction('form_reset', new Twig_Function_Function('form_reset'));
    	$this->_twig_env->addFunction('form_button', new Twig_Function_Function('form_button'));
    	$this->_twig_env->addFunction('form_close', new Twig_Function_Function('form_close'));
    	$this->_twig_env->addFunction('form_prep', new Twig_Function_Function('form_prep'));
    	$this->_twig_env->addFunction('set_value', new Twig_Function_Function('set_value'));
    	$this->_twig_env->addFunction('set_select', new Twig_Function_Function('set_select'));
    	$this->_twig_env->addFunction('set_checkbox', new Twig_Function_Function('set_checkbox'));
    	$this->_twig_env->addFunction('set_radio', new Twig_Function_Function('set_radio'));
    	$this->_twig_env->addFunction('form_open_multipart', new Twig_Function_Function('form_open_multipart'));
    }
}