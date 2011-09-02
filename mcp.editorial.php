<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editorial_mcp {

	/**
	 * Constructor
	 *
	 * @access	public
	 */
	function Editorial_mcp()
	{
		// Make a local reference to the ExpressionEngine super object
		$this->EE =& get_instance();

		$this->EE->cp->set_right_nav(array(
			    'EEditorial Calendar' => BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=editorial'.AMP.'method=index',
				'Settings' => BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=editorial'.AMP.'method=settings',

			));

	}

	// --------------------------------------------------------------------

	/**
	 * Main Page
	 *
	 * @access	public
	 */
	function index()
	{
		$this->EE->cp->add_to_head('<link rel="stylesheet" type="text/css" href="expressionengine/third_party/editorial/views/calendar/fullcalendar.css" />
			<script type="text/javascript" src="expressionengine/third_party/editorial/views/calendar/fullcalendar.min.js"></script>
			<script type="text/javascript" src="expressionengine/third_party/editorial/libraries/date.js"></script>
		'); 
		$this->EE->load->library('javascript');
		$this->EE->load->helper('date');
		$this->EE->cp->add_js_script(array('ui' => 'core'));
		$this->EE->cp->add_js_script(array('ui' => 'draggable'));
		
		$this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('editorial_module_name'));
		$vars['action_url'] = 'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=editorial'.AMP.'method=update';
		$vars['form_hidden'] = NULL;
		$query = $this->EE->db->get('exp_editorial_config', 1, 0);
		$row1 = $query->row();
		$rowcount = $query->num_rows();
		if ($rowcount > 0){
			$event_id = array($row1->editorial_channels);
			$vars['id'] = $row1->editorial_channels;
			$vars['status_select'] = $row1->editorial_status;
			
			$vars['events'] = array();
			$events = $this->EE->db->order_by('entry_id', "desc");
			$events = $this->EE->db->where_in('channel_id', $event_id);
			$events = $this->EE->db->get('channel_titles');
			foreach($events->result_array() as $row)
			{
				$vars['events'][$row['entry_id']]['title'] = $row['title'];
				$vars['events'][$row['entry_id']]['month'] = $row['month'];
				$vars['events'][$row['entry_id']]['day'] = $row['day'];
				$vars['events'][$row['entry_id']]['year'] = $row['year'];
				$vars['events'][$row['entry_id']]['time'] = $row['entry_date'];
				$vars['events'][$row['entry_id']]['id'] = $row['entry_id'];
				$vars['events'][$row['entry_id']]['channel'] = $row['channel_id'];
				$vars['events'][$row['entry_id']]['status'] = $row['status'];
			}





				$vars['options'] = array(
						'edit'  => lang('edit_selected'),
						'delete'    => lang('delete_selected')
						);
			return $this->EE->load->view('index', $vars, TRUE);
		}//end if for row count
		
		
		
		
		
	}
	function update()
	{
		$month = $_GET['month'];
		$day = $_GET['day'];
		$year = $_GET['year'];
		$entry_id = $_GET['entry_id'];
		$entry_date = $_GET['entry_date'];
		$data = array('month' => $month, 'day' => $day, 'year' => $year, 'entry_date' => $entry_date );
		$sql = $this->EE->db->update_string('channel_titles', $data, "entry_id = $entry_id" );
		$this->EE->db->query($sql);
		die("updated");
	}

	function settings(){
		$this->EE->load->library('javascript');
		$this->EE->load->library('table');
		$this->EE->load->helper('date');
		$this->EE->cp->add_js_script(array('ui' => 'core'));
		$this->EE->cp->add_js_script(array('ui' => 'draggable'));
		$this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('editorial_module_settings'));
		$vars['action_url'] = "&C=addons_modules&M=show_module_cp&module=editorial&method=settings_submit";
		$vars['form_hidden'] = NULL;
		$channels = $this->EE->db->order_by('channel_id', "desc");
		$channels = $this->EE->db->get_where('channels');
		$query = $this->EE->db->get('exp_editorial_config', 1, 0);
		$row1 = $query->row();
		$rowcount = $query->num_rows();
		if ($rowcount > 0){
			$vars['event_id'] = $row1->editorial_channels;
			$vars['event_status'] = $row1->editorial_status;
		}
		
		
		$vars['channels'] = array();
		foreach($channels->result_array() as $row)
		{
			$vars['channels'][$row['channel_id']]['channel'] = $row['channel_id'];
			$vars['channels'][$row['channel_id']]['name'] = $row['channel_name']; 
		}
		if ($rowcount > 0){
		$query = $this->EE->db->get_where('channels', array('channel_id' => $vars['event_id']));
		$status = $query->row(0);
		$status_group = $status->status_group;
		$vars['status_names'] = $this->EE->db->get_where('statuses', array('group_id' => $status_group));
		}
		
		
		return $this->EE->load->view('settings', $vars, TRUE);
		
	}
	function settings_submit(){
		$channels = $_GET['channels'];
		$data = array('editorial_channels' => $channels);
		$table_row_count = $this->EE->db->count_all('exp_editorial_config');
		$query = $this->EE->db->get('exp_editorial_config', 1, 0);
		$row1 = $query->row();
		if($table_row_count == 0){
			$sql = $this->EE->db->insert_string('exp_editorial_config', $data);
		}else{
			$sql = $this->EE->db->update_string('exp_editorial_config', $data, "editorial_id = $row1->editorial_id" );
		}
		$this->EE->db->query($sql);
		die("updated");
	}
	function find_status(){
		$channels = $_GET['channels'];
		$query = $this->EE->db->get_where('channels', array('channel_id' => $channels));
		$status = $query->row(0);
		$status_group = $status->status_group;
		$status_names = $this->EE->db->get_where('statuses', array('group_id' => $status_group));
		foreach ($status_names->result() as $row)
		{
		    echo "<option value=\"".$row->status."\">".$row->status."</option>";
		}
		die();
	}

	function status_update(){
		$editorial_status = $_GET['editorial_status'];
		$data = array('editorial_status' => $editorial_status);
		$table_row_count = $this->EE->db->count_all('exp_editorial_config');
		$query = $this->EE->db->get('exp_editorial_config', 1, 0);
		$row1 = $query->row();
		if($table_row_count == 0){
			$sql = $this->EE->db->insert_string('exp_editorial_config', $data);
		}else{
			$sql = $this->EE->db->update_string('exp_editorial_config', $data, "editorial_id = $row1->editorial_id" );
		}
		$this->EE->db->query($sql);
		die("updated");
	}
}
// END CLASS

/* End of file mcp.download.php */
/* Location: ./system/expressionengine/third_party/modules/download/mcp.download.php */