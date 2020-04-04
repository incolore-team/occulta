<?php $v->layout('admin/layout/login.layout.php', ['title' => '登录']) ?>
<div class="container">
    <form id="login-form" class="card col col-login mx-auto" action="" method="post">
        <div class="card-body p-6">
            <div class="card-title">登录到你的 Occulta</div>
            <div class="form-group">
                <label class="form-label">用户名</label>
                <input value="<?= isset($username) ? $username : ""; ?>" type="username" name="username" class="form-control" id="username" placeholder="Enter username">
            </div>
            <div class="form-group">
                <label class="form-label">
                    密码
                    <a href="./forgot-password.html" class="float-right small">忘记密码？</a>
                </label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
            </div>
            <div class="form-group">
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input">
                    <span class="custom-control-label">保持登录</span>
                </label>
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary btn-block">登录</button>
            </div>
        </div>
    </form>
</div>


<?php if (isset($error)) : ?>
    <script>
        new Toast({
            message: '<?= $error; ?>',
            type: 'danger'
        });
    </script>
<?php endif; ?>