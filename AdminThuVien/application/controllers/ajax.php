<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Ajax extends CI_Controller
{
    private $auth;
    private $messages = '0';

    public function __construct()
    {
        parent::__construct();
        $this->auth = $this->cms_authentication->check();
    }

    public function cms_cruser()
    {
        //echo "<pre>"; print_r($data); echo "</pre>"; 
        $_post = ['display_name', 'mail', 'username', 'password', 'group'];
        foreach ($_post as $item) {
            $data[] = $this->input->post($item);
        }
        $user['display_name'] = $data[0];
        $user['email'] = $data[1];
        $user['username'] = $data[2];
    
        $user['salt'] = $this->cms_common_string->random(69);
        $user['password'] = $this->cms_common_string->password_encode($data[3], $user['salt']);
        $user['group_id'] = $data[4];
        $user['created'] = gmdate("Y:m:d H:i:s", time() + 7 * 3600);
        if ($this->_check_user($user)) {
            $this->db->insert('users', $user);
            echo $this->messages = '1';
        } else {
            echo $this->messages = 'Mã nhân viên hoặc Email đã tồn tại!';
        }
        //echo "<pre>"; print_r($_POST); echo "</pre>";
    }
    public function cms_crusersv()
    {
        echo ('Người dùng đã được thêm thành công!');
        $_post = ['display', 'mail', 'username', 'password'];

        foreach ($_post as $item) {
            $data[] = $this->input->post($item);
        }
        $user['display_name'] = $data[0];
        $user['username'] = $data[2];
        $user['email'] = $data[1];

        $user['salt'] = $this->cms_common_string->random(69);
        $user['password'] = $data[3];
        $user['created'] = gmdate("Y:m:d H:i:s", time() + 7 * 3600);
        if ($this->_check_user($user)) {
            $this->db->insert('users', $user);
            echo $this->messages = '1';
        } else {
            echo $this->messages = 'Mã nhân viên hoặc Email đã tồn tại!';
        }
    }

    private function _check_user($user)
    {

        $count = $this->db->where('username', $user['username'])->or_where('email', $user['email'])->from('users')->count_all_results();
        if ($count == 0) {
            return true;
        }

        return false;
    }

    public function cms_upuser()
    {
        $users = $this->db->select('users.id, username, email, display_name, group_name ')->from('users')->join('users_group', 'users_group.id = users.group_id')->get()->result_array();
        if (!empty($users) && count($users) != 0) {
            $ind = 0;
            $html = '';
            foreach ($users as $user) {
                $ind++;
                $html .= "<tr class='tr-item-{$user['id']}'>";
                $html .= '<td class="text-center">' . $ind . '</td>';
                $html .= '<td>' . $user['username'] . '</td>';
                $html .= '<td>' . $user['email'] . '</td>';
                $html .= '<td>' . $user['display_name'] . '</td>';
                $html .= '<td>' . '<span class="user_group"><i class="fa fa-male"></i> ' . $user['group_name'] . '</span>' . '</td>';
                $html .= '<td class="text-center"><i class="fa fa-pencil-square-o edit-item" title="Sửa" onclick="cms_edit_usitem(' . $user['id'] . ')" style="margin-right: 10px; cursor: pointer;"></i><i onclick="cms_del_usitem(' . $user['id'] . ')" title="Xóa" class="fa fa-trash-o delete-item" style="cursor: pointer;"></i></td>';
                $html .= '</tr>';
                $html .= "<tr class='edit-tr-item-{$user['id']}' style='display: none;'>";
                $html .= "<td class='text-center'>{$ind}</td>";
                $html .= "<td class='itmanv'><input type='text' class='form-control' value='{$user['username']}' disabled /></td>";
                $html .= "<td class='itemail'><input type='text' class='form-control' value='{$user['email']}' /></td>";
                $html .= "<td class='itdisplay_name'><input type='text' class='form-control' value='{$user['display_name']}'/></td>";
                $html .= "<td class='itgroup_name'><div class='group-user'><div class='group-selbox'></div></div></td>";
                $html .= "<td class='text-center'><i class='fa fa-floppy-o' title='Lưu' onclick='cms_save_item_user( {$user['id']} )' style='color: #EC971F; cursor: pointer; margin-right: 10px;'></i><i onclick='cms_undo_item( {$user['id']} )' title='Hủy' class='fa fa-undo' style='color: green; cursor: pointer; margin-right: 5px;'></i></td>";
                $html .= "</tr>";
            }
            echo $this->messages = $html;

        } else {
            echo $this->messages;
        }
    }

    function openFileSelector() {
        echo $this->messages = '1';
        // Hiển thị thông báo
        }

    public function cms_save_item_user()
    {
        $data = $this->input->post('data');
        $id = $data['id'];
        $user = $this->db->where('id', $data['id'])->from('users')->get()->row_array();
        if (!isset($user) && count($user) == 0) {
            echo $this->messages;
        } else {
            if ($data['email'] == $user['email']) {
                $data = $this->cms_common_string->allow_post($data, ['display_name', 'group_id']);
                $data['updated'] = gmdate("Y:m:d H:i:s", time() + 7 * 3600);
                $this->db->where('id', $id)->update('users', $data);
                echo $this->messages = '1';
            } else {
                if ($this->_check_mail($data['email'])) {
                    $data = $this->cms_common_string->allow_post($data, ['display_name', 'email', 'group_id']);
                    $data['updated'] = gmdate("Y:m:d H:i:s", time() + 7 * 3600);
                    $this->db->where('id', $id)->update('users', $data);

                    echo $this->messages = '1';
                } else {
                    echo $this->messages = 'Email đã tồn tại!';
                }
            }
        }

    }


    private function _check_mail($mail)
    {
        $count = $this->db->where('email', $mail)->from('users')->count_all_results();
        if ($count == 0) {
            return true;
        }

        return false;
    }

    public function cms_del_usitem()
    {
        $id = (int)$this->input->post('id');
        $user = $this->db->where('id', $id)->from('users')->get()->row_array();
        if (!isset($user) || count($user) == 0) {
            echo $this->messages;
        } else {
            $this->db->where(['id' => $id])->delete('users');
            echo $this->messages = '1';
        }
    }
    
/*
     * Tạo nhóm người dùng
     /****************************************/
     public function cms_crgroup()
     {
         $group_name = $this->input->post('group_name');
         $count = $this->db->where('group_name', $group_name)->from('users_group')->count_all_results();
         if ($count == 0) {
             $data = ['group_name' => $group_name, 'group_registered' => gmdate("Y:m:d H:i:s", time() + 7 * 3600)];
             $this->db->insert('users_group', $data);
             echo $this->messages = '1';
         } else {
             echo $this->messages = 'Nhóm Chức năng ' . $group_name . ' đã tồn tại trong hệ thống.Vui lòng tạo tên nhóm khác.';
         }
     }
 
     /*
      * Load dánh sách nhóm người dùng
      /****************************************/
     public function cms_upgroup()
     {
         $groups = $this->db->select('id, group_name, group_registered')->from('users_group')->get()->result_array();
         if (!empty($groups) && count($groups) != 0) {
             $ind = 0;
             $html = '';
             foreach ($groups as $group) {
                 $ind++;
                 $date = ($group['group_registered'] != '1970-01-01 07:00:00') ?
                     gmdate("H:i d/m/Y", strtotime(str_replace('-', '/', $group['group_registered'])) + 7 * 3600) :
                     '-';
                 $html .= "<tr class='tr-item-{$group['id']}'>";
                 $html .= '<td class="text-center ind">' . $ind . '</td>';
                 $html .= '<td>' . $group['group_name'] . '</td>';
                 $html .= '<td>' . $date . '</td>';
                 $html .= '<td class="text-center">' . cms_getEmployee($group['id']) . '</td>';
                 $html .= '<td class="text-center"><i class="fa fa-pencil-square-o edit-item" title="Sửa" onclick="cms_edit_gritem(' . $group['id'] . ')" style="margin-right: 10px; cursor: pointer;"></i><i onclick="cms_del_gritem(' . $group['id'] . ' )" title="Xóa" class="fa fa-trash-o delete-item" style="cursor: pointer;"></i></td>';
                 $html .= '</tr>';
 
                 $html .= "<tr class='edit-tr-item-{$group['id']}' style='display: none;'>";
                 $html .= '<td class="text-center ind">' . $ind . '</td>';
                 $html .= '<td class="itgr_name"> <input type="text" class="form-control" value="' . $group['group_name'] . '"/> </td>';
                 $html .= '<td class="itgr_registered"><input type="text" class="form-control" value="' . $date . '" disabled/></td>';
                 $html .= '<td class="itgr_nbuser text-center"><input type="text" class="form-control text-center" value="' . cms_getEmployee($group['id']) . '" disabled/></td>';
                 $html .= "<td class='text-center'><i class='fa fa-floppy-o' title='Lưu' onclick='cms_save_item_group( {$group['id']} )' style='color: #EC971F; cursor: pointer; margin-right: 10px;'></i><i onclick='cms_undo_item( {$group['id']} )' title='Hủy' class='fa fa-undo' style='color: green; cursor: pointer; margin-right: 5px;'></i></td>";
                 $html .= '</tr>';
             }
             echo $this->messages = $html;
 
         } else {
             echo $this->messages;
         }
     }
 
     public function cms_upstore()
     {
         $stores = $this->db->from('stores')->get()->result_array();
         if (!empty($stores) && count($stores) != 0) {
             $ind = 0;
             $html = '';
             foreach ($stores as $store) {
                 $ind++;
                 $html .= "<tr class='tr-item-{$store['ID']}'>";
                 $html .= '<td class="text-center ind">' . $ind . '</td>';
                 $html .= '<td>' . $store['stock_name'] . '</td>';
                 $html .= '<td>' . $store['created'] . '</td>';
                 $html .= '</tr>';
             }
             echo $this->messages = $html;
 
         } else {
             echo $this->messages;
         }
     }
 

    /*
     * Load danh sách người dùng theo radio button
    /*******************************************************/
    public function cms_radiogroup()
    {
        $groups = $this->db->select('id, group_name')->from('users_group')->get()->result_array();
        if (isset($groups) && count($groups)) {
            $html = '';
            foreach ($groups as $group) {
                $html .= '<input type="radio" name="group" value="' . $group['id'] . '" /> <span>' . $group['group_name'] . '</span> &nbsp;&nbsp;';
            }
            $html .= '<button style="color: green; font-size: 16px;" class="btn btn-default btn-sm create-group" data-toggle="modal" data-target="#create-group"><i class="fa fa-plus"></i></button>';
            echo $this->messages = $html;
        } else {
            echo $this->messages;
        }
    }

    public function cms_selboxgroup()
    {
        $groups = $this->db->select('id, group_name')->from('users_group')->get()->result_array();
        if (isset($groups) && count($groups)) {
            $html = '';
            $html .= '<select name="group" id="sel-group" class="form-control">';;
            foreach ($groups as $group) {
                $html .= '<option value="' . $group['id'] . '">' . $group['group_name'] . '</option>';
            }
            $html .= '</select>';
            echo $this->messages = $html;
        } else {
            echo $this->messages;
        }
    }

    public function cms_selboxstock()
    {
        $groups = $this->db->select('ID, stock_name')->from('stores')->get()->result_array();
        if (isset($groups) && count($groups)) {
            $html = '';
            $html .= '<select name="stock" id="sel-stock" class="form-control">';;
            foreach ($groups as $group) {
                $html .= '<option value="' . $group['ID'] . '">' . $group['stock_name'] . '</option>';
            }
            $html .= '</select>';
            echo $this->messages = $html;
        } else {
            echo $this->messages;
        }
    }

}