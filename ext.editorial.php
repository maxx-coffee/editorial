<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editorial_ext
{
	public $settings = array();
	public $name = 'Editorial Calendar';
	public $version = '1.0';
	public $description = 'Adds the JavaScript to allow the date to pass';
	public $settings_exist = 'n';
	public $docs_url = 'http://www.thecreatatory.com';
	
	/**
	 * __construct
	 * 
	 * @access	public
	 * @param	mixed $settings = ''
	 * @return	void
	 */
	public function __construct($settings = '')
	{
		$this->EE =& get_instance();
		
		$this->settings = $settings;
	}
	
	/**
	 * activate_extension
	 * 
	 * @access	public
	 * @return	void
	 */
	public function activate_extension()
	{
		$hook_defaults = array(
			'class' => __CLASS__,
			'settings' => '',
			'version' => $this->version,
			'enabled' => 'y',
			'priority' => 10
		);
		
		$hooks[] = array(
			'method' => 'cp_js_end',
			'hook' => 'cp_js_end'
		);
		
		foreach ($hooks as $hook)
		{
			$this->EE->db->insert('extensions', array_merge($hook_defaults, $hook));
		}
		
		return TRUE;
	}
	
	/**
	 * update_extension
	 * 
	 * @access	public
	 * @param	mixed $current = ''
	 * @return	void
	 */
	public function update_extension($current = '')
	{
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}
		
		$this->EE->db->update('extensions', array('version' => $this->version), array('class' => __CLASS__));
		
		return TRUE;
	}
	
	/**
	 * disable_extension
	 * 
	 * @access	public
	 * @return	void
	 */
	public function disable_extension()
	{
		$this->EE->db->delete('extensions', array('class' => __CLASS__));
		
		return TRUE;
	}
	
	/**
	 * settings
	 * 
	 * @access	public
	 * @return	array
	 */
	public function settings()
	{
		$settings = array();
		
		return $settings;
	}
	
	/**
	 * cp_js_end
	 * 
	 * @access	public
	 * @return	string
	 */
	public function cp_js_end()
	{
		//thx for ie help from stephen sweetland
		return $this->EE->extensions->last_call.'

			function getUrlVars()
			{
			    var vars = [], hash;
			    var hashes = window.location.href.slice(window.location.href.indexOf(\'?\') + 1).split(\'&\');
			    for(var i = 0; i < hashes.length; i++)
			    {
			        hash = hashes[i].split(\'=\');
			        vars.push(hash[0]);
			        vars[hash[0]] = hash[1];
			    }
			    return vars;
			}
			var date = getUrlVars()["date"];
			var time = getUrlVars()["time"];
			var new_time = time.replace(\'-\',\':\');
			var new_time2 = new_time.replace(\'#\',\'\');
			if (date == undefined){
			}else{
			$(\'#entry_date\').val(date+" "+new_time);
			}'."\r\n";
	}
}

/* End of file ext.bn_edit_menu.php */
/* Location: ./system/expressionengine/third_party/bn_edit_menu/ext.bn_edit_menu.php */