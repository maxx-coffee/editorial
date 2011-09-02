<?
$data = array('month' => $month, 'day' => $day, 'year' => $year);
$sql = $this->EE->db->update_string('channel_titles', $data);
$this->EE->db->query($sql);
?>


