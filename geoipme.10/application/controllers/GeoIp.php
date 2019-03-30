<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GeoIp extends CI_Controller {

	public function __construct ()
    {
        parent::__construct ();
        $this->load->helper ('url_helper');

        $this->load->helper('url');
    	$this->load->library('xmlrpc');
    	$this->load->library('xmlrpcs');
    }

    public function index ()
    {
        $this->load->view ('start');
    }

    public function geoip ()
    {
        $this->load->view ('geoip');
    }

    public function getLastEntries ()
    {
        $this->load->model ('GeoIP_model');
        $data = $this->GeoIP_model->get_data ();

        echo json_encode ($data);
    }

    public function remove ($id)
	{
        $this->load->model ('GeoIP_model');
        $this->GeoIP_model->remove_entry ($id);
       	$data['data'] = $this->GeoIP_model->get_data ();
        $this->load->view ('geoip', $data);
	}

	public function search_IP ()
	{
        $this->load->model ('GeoIP_model');
		$ip = $this->uri->segment(3);

		$url = 'http://api.geoiplookup.net/?query='.$ip;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		$data = curl_exec($ch);

		if (curl_errno($ch))
		{
			print "Error: " . curl_error($ch);
		}
		else
		{
			//show the resultas JSON
			curl_close ($ch);

        	$oXML = new SimpleXMLElement ($data);

			$json = new stdClass ();
		    $json->ip = $oXML->results->result->ip;
			$json->countrycode = $oXML->results->result->countrycode;
			$json->country = $oXML->results->result->countryname;

			echo json_encode ($json);

			//save data to DB
			$data = array(
		        'IP' => $json->ip,
		        'countryCode' => $json->countrycode,
		        'country' => $json->country,
		        'date' => date ('Y-m-d H:i:s', time ())
		    );
		    $this->GeoIP_model->set_new_ip ($data);
      	}
    }
}
