<div class="setting">
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="user">
            <div class="panel panel-primary" style="margin-top: 20px">
                <div class="panel-heading">
                    <i class="fa fa-user"></i> Quản Lý Tài Khoản E-Library
                    <div class="action pull-right">
                        <button class="btn btn-default btn-sm create-nv btn-in-panel blue" data-toggle="modal"
                                data-target="#create-nv"><i class="fa fa-pencil blue"></i> Tạo tài khoản
                        </button>
                        | <i class="fa fa-refresh" style="font-size: 17px; cursor: pointer;" onclick="cms_upuser()"></i>
                    </div>

                </div>
                <div class="panel-body">
                    <div class="table-responsive ">
                        <table class="table table-hover table-user table-striped">
                            <thead>
                            <th class="text-center">STT</th>
                            <th>Họ Và Tên</th>
                            <th>Tài khoản</th>
                            <th>Mật Khẩu</th>
                            <th>Email</th>
                            <th>Số Điện Thoại</th>
                            <th></th>
                            </thead>
                            <tbody>
                            <?php
                            if (isset($_user) && count($_user)) :
                                $ind = 0;
                                foreach ($_user as $key => $val) : $ind++; ?>
                                    <tr class="tr-item-<?php echo $val['id']; ?>">
                                        <td class="text-center"><?php echo $ind; ?></td>
                                        <td><?php echo $val['username']; ?></td>
                                        <td><?php echo $val['email']; ?></td>
                                        <td><?php echo ($val['display_name'] != '') ? $val['display_name'] : '-'; ?></td>
                                        <td><?php echo '<span class="user_group"><i class="fa fa-male"></i> ' . $val['group_name'] . '</span>'; ?></td>
                                        <td class="text-center"><i class="fa fa-pencil-square-o edit-item" title="Sửa"
                                                                   onclick="cms_edit_usitem(<?php echo $val['id']; ?>)"
                                                                   style="margin-right: 10px; cursor: pointer;"></i><i
                                                onclick="cms_del_usitem(<?php echo $val['id']; ?>)" title="Xóa"
                                                class="fa fa-trash-o delete-item" style="cursor: pointer;"></i></td>
                                    </tr>
                                    <tr class="edit-tr-item-<?php echo $val['id']; ?>" style="display: none;">
                                        <td class="text-center"><?php echo $ind; ?></td>
                                        <td class="itmanv"><input type="text" class="form-control"
                                                                  value="<?php echo $val['username']; ?>" disabled/>
                                        </td>
                                        <td class="itdisplay_name"><input type="text" class="form-control"
                                                                          value="<?php echo $val['display_name']; ?>"/>
                                        </td>
                                        <td class="itemail">
                                            <input type="text" class="form-control"
                                                                   value="<?php echo $val['email']; ?>"/>
                                        </td>
                                        <td class="itgroup_name">
                                            <div class="group-user">
                                                <div class="group-selbox">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center"><i class="fa fa-floppy-o" title="Lưu"
                                                                   onclick="cms_save_item_user( <?php echo $val['id']; ?> )"
                                                                   style="color: #EC971F; cursor: pointer; margin-right: 10px;"></i><i
                                                onclick="cms_undo_item( <?php echo $val['id']; ?> )" title="Hủy"
                                                class="fa fa-undo"
                                                style="color: green; cursor: pointer; margin-right: 5px;"></i></td>
                                    </tr>
                                <?php endforeach;
                            else: ?>
                                <tr>
                                    <td class="text-center" colspan="7">Không có Người dùng trong danh sách</td>
                                </tr>
                            <?php endif;
                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>