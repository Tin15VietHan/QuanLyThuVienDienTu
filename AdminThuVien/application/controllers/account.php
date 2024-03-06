<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// controller control user authentication
class Account extends CI_Controller
{
    private $auth;

    public function __construct()
    {
        parent::__construct();
        $this->auth = $this->cms_authentication->check();
    }

    public function index()
    {
        if ($this->auth == null) $this->cms_common_string->cms_redirect(CMS_BASE_URL . 'backend');
        $data['seo']['title'] = "E-Library";
        $store = $this->db->from('stores')->get()->result_array();
        $data['data']['store'] = $store;
        $store_id = $this->db->select('store_id')->from('users')->where('id', $this->auth['id'])->limit(1)->get()->row_array();
        $data['data']['store_id'] = $store_id['store_id'];
        $data['data']['user'] = $this->auth;
        $data['template'] = 'account/info';
        $this->load->view('layout/index', isset($data) ? $data : null);
    }

    public function _check_password($user_id, $password)
    {
        $user = $this->db->select('username,password,salt')->where('id', $user_id)->from('users')->limit(1)->get()->row_array();
        $password = $this->cms_common_string->password_encode($password, $user['salt']);
        if ($password != $user['password']) {
            return false;
        }
        return true;
    }

    public function cms_change_password()
    {
        $user_id = $this->auth['id'];
        $data = $this->input->post('data');
        $update = [];
        if ($this->_check_password($user_id, $data['oldpass'])) {
            $update['salt'] = $this->cms_common_string->random(69, true);
            $update['password'] = $this->cms_common_string->password_encode($data['newpass'], $update['salt']);
            //$this->db->where('id', $user_id)->update('users', $update);
            echo $this->messages = 1;
        }else
            echo $this->messages = 0;
    }

}