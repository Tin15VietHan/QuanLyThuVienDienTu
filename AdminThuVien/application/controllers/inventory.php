<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// controller control user authentication
class Inventory extends CI_Controller
{
    private $auth;

    public function __construct()
    {
        parent::__construct();
        $this->auth = $this->cms_authentication->check();
    }

    /* default login when acess manager system */
    public function index()
    {
        if ($this->auth == null || !in_array(6, $this->auth['group_permission']))
            $this->cms_common_string->cms_redirect(CMS_BASE_URL . 'backend');

        $data['seo']['title'] = "E-Library";
        $sls_group = $this->cms_nestedset->dropdown('products_group', NULL, 'manufacture');
        $sls_manufacture = $this->db->from('products_manufacture')->get()->result_array();
        $data['data']['_prd_group'] = $sls_group;
        $data['data']['_prd_manufacture'] = $sls_manufacture;
        $data['data']['user'] = $this->auth;

        $store = $this->db->from('stores')->get()->result_array();
        $data['data']['store'] = $store;
        $store_id = $this->db->select('store_id')->from('users')->where('id',$this->auth['id'])->limit(1)->get()->row_array();

        $data['data']['store_id'] = $store_id['store_id'];
        $data['template'] = 'inventory/index';
        $this->load->view('layout/index', isset($data) ? $data : null);
    }

    

    
}

