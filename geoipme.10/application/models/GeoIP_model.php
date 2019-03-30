<?php
class GeoIP_model extends CI_Model {

    public function __construct ()
    {
        $this->load->database ();
    }

    public function get_data ($ip = FALSE)
	{
	    if ($ip === FALSE)
	    {
            $query = $this->db->order_by('id',"desc")->limit(10)->get ('IPs');
            return $query->result_array ();
	    }

	    $query = $this->db->get_where ('IPs', array ('IP' => $ip));
	    return $query->row_array ();
	}

	public function set_new_ip ($data)
	{
	    return $this->db->insert ('IPs', $data);
	}

	public function remove_entry ($id)
	{
  		$this->db->where ('id', $id);
  		$this->db->delete ('IPs');
	}
}