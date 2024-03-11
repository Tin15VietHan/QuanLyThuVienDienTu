<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class setting extends CI_Controller
{
    private $auth;

    public function __construct()
    {
        parent::__construct();
        $this->auth = $this->cms_authentication->check();
    }

    /*
     * Cấu hình hệ thống
    /****************************************/
    public function index()
    {
        if ($this->auth == null || !in_array(10, $this->auth['group_permission']))
            $this->cms_common_string->cms_redirect(CMS_BASE_URL . 'backend');

        $data['seo']['title'] = "E-Library";
        $user = $this->db->select('users.id, username, email, display_name, user_status, group_name ')->from('users')->join('users_group', 'users_group.id = users.group_id')->get()->result_array();
        $data['data']['template'] = $this->db->select('content')->from('templates')->where('id', 1)->limit(1)->get()->row_array();
        $data['data']['list_template'] = $this->db->from('templates')->get()->result_array();
        $data['data']['_user'] = $user;
        $data['data']['user'] = $this->auth;

        $data['template'] = 'setting/setting';
        $this->load->view('layout/index', isset($data) ? $data : null);
    }

    public function cms_save_template($id)
    {
        $id = (int)$id;
        $data = $this->input->post('data');
        $template = $this->db->from('templates')->where('id', $id)->get()->row_array();
        if (empty($prd_group) && count($template) == 0) {
            echo $this->messages = '0';
            return;
        }

        $data['updated'] = gmdate("Y:m:d H:i:s", time() + 7 * 3600);
        $data['user_upd'] = $this->auth['id'];
        $this->db->where('id', $id)->update('templates', $data);
        echo $this->messages = '1';
    }

    public function cms_load_template($id)
    {
        $template = $this->db->from('templates')->where('id', $id)->get()->row_array();
        if (empty($prd_group) && count($template) == 0) {
            echo $this->messages = '0';
            return;
        }
       echo $this->message = $template['content'];
    }

}

