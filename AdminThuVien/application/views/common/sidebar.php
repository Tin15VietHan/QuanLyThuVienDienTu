<div class="sidebar sidebar-fixed hidden-xs hidden-sm hidden-md" id="sidebar">
    <ul class="nav nav-pills nav-list nav-stacked">
        <li id="dashboard"><a href="pos" style=" color: white;background-color: #33CB82!important;"><i class="fa fa-pied-piper-alt"></i><b>POS Mượn Sách</b></a></li>
        <?php if (in_array(1, $user['group_permission'])) : ?>
            <li id="dashboard"><a href="dashboard"><i class="fa fa-gg-circle"></i><b>Trang Chủ</b></a></li>
        <?php endif; ?>
        <?php if (in_array(2, $user['group_permission'])) : ?>
            <li id="orders"><a href="orders"><i class="fa fa-shopping-cart"></i><b>Tạo đơn hàng</b></a></li>
        <?php endif; ?>
        <?php if (in_array(3, $user['group_permission'])) : ?>
            <li id="product"><a href="product"><i class="fa fa-product-hunt"></i><b>Kho Sách</b></a></li>
        <?php endif; ?>
        <?php if (in_array(4, $user['group_permission'])) : ?>
            <li id="customer"><a href="customer"><i class="fa fa-users"></i><b>Độc Giả</b></a></li>
        <?php endif; ?>
        <?php if (in_array(7, $user['group_permission'])) : ?>
            <li id="revenue"><a href="revenue"><i class="fa fa-connectdevelop"></i><b>Thống Kê</b></a></li>
        <?php endif; ?>
        <?php if (in_array(6, $user['group_permission'])) : ?>
            <li id="inventory"><a href="inventory"><i class="fa fa-list-alt"></i><b>Tài Khoản E-Library</b></a></li>
        <?php endif; ?>
        <?php if (in_array(10, $user['group_permission'])) : ?>            
            <li id="config"><a href="setting"><i class="fa fa-empire"></i><b>Quản Lý Tài Khoản</b></a></li>
        <?php endif; ?>
    </ul>
</div>