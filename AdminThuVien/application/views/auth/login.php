<div class="login-container col-md-4 col-md-offset-4" id="login-form">
    <div class="login-frame clearfix">
        <center><h3 class="heading col-md-10 col-md-offset-1 padd-0"><i class="fa fa-lock"></i>Đăng nhập</h3></center>
        <ul class="validation-summary-errors col-md-10 col-md-offset-1">
            <?php echo validation_errors(); ?>
        </ul>
        <div class="col-md-10 col-md-offset-1">
            <form class="form-horizontal login-form frm-sm" method="post" action="">
                <div class="form-group input-icon">
                    <label for="inputEmail3" class="sr-only control-label">Email</label>
                    <input type="text" name="data[username]"
                           value="<?php echo cms_common_input(isset($_post) ? $_post : [], 'username'); ?>"
                           class="form-control" id="inputEmail3" placeholder="Email/Mã Đăng nhập">
                    <i class="fa fa-user icon-right"></i>
                </div>
                <div class="form-group input-icon">
                    <label for="inputPassword3" class="sr-only control-label">Password</label>
                    <input type="password" name="data[password]"
                           value="<?php echo cms_common_input(isset($_post) ? $_post : [], 'password'); ?>"
                           class="form-control" id="inputPassword3" placeholder="Mật khẩu">
                           
                    <i class="fa fa-lock icon-right"></i>
                    <div style="margin: 10px; margin-left: 0px; color: rgb(41, 122, 207, 0.9);">
                <input type="checkbox" onclick="myFunction()"> Hiển thị mật khẩu
                    <script>
                    function myFunction() 
                    {
                        var x = document.getElementById("inputPassword3");
                        if (x.type === "text") {
                            x.type = "password"; 
                        } else {
                            x.type = "text";
                        }
                    }
                    </script>
                    <span style="color: #000;">admin - pass: 12345678</span>
                </div>    
                    
                </div>

                <div class="form-group">

                    <input type="submit" name="login" value="Đăng nhập" class="btn btn-primary btn-sm"/>
                </div>
            </form>
        </div>
    </div>
</div>