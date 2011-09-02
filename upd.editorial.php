<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editorial_upd {

	var $version = '1.0';
	
	function Editorial_upd()
	{
		// Make a local reference to the ExpressionEngine super object
		$this->EE =& get_instance();
	}
	




	// --------------------------------------------------------------------

	/**
	 * Module Installer
	 *
	 * @access	public
	 * @return	bool
	 */	
	function install()
	{
		$this->EE->load->dbforge();

		$data = array(
			'module_name' => 'Editorial' ,
			'module_version' => $this->version,
			'has_cp_backend' => 'y',
			'has_publish_fields' => 'n'
		);

		$this->EE->db->insert('modules', $data);


		$data = array(
			'class'		=> 'Editorial' ,
			'method'	=> 'editorial'
		);

		$this->EE->db->insert('actions', $data);
		
		$fields = array(
				'editorial_id'	=> array('type' => 'int', 'constraint' => '10', 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'editorial_channels'	=> array('type' => 'varchar', 'constraint' => '250', 'null' => TRUE, 'default' => NULL),
				'editorial_status'	=> array('type' => 'varchar', 'constraint' => '250', 'null' => TRUE, 'default' => NULL),

				);

			$this->EE->dbforge->add_field($fields);
			$this->EE->dbforge->add_key('editorial_id', TRUE);
			$this->EE->dbforge->create_table('editorial_config');

			
		
		return TRUE;

	}
	
	
	// --------------------------------------------------------------------

	/**
	 * Module Uninstaller
	 *
	 * @access	public
	 * @return	bool
	 */
	function uninstall()
	{
		$this->EE->load->dbforge();

		$this->EE->db->select('module_id');
		$query = $this->EE->db->get_where('modules', array('module_name' => 'editorial'));



		$this->EE->db->where('module_name', 'editorial');
		$this->EE->db->delete('modules');

		$this->EE->db->where('class', 'editorial');
		$this->EE->db->delete('actions');
		$this->EE->dbforge->drop_table('editorial_config');

		return TRUE;
	}



	// --------------------------------------------------------------------

	/**
	 * Module Updater
	 *
	 * @access	public
	 * @return	bool
	 */	
	
	function update($current='')
	{
		return TRUE;
	}
	
}
/* END Class */

/* End of file upd.download.php */
/* Location: ./system/expressionengine/third_party/modules/download/upd.download.php */