<?php
    // echo '<pre>';
    // print_r($errors);
    // echo '</pre>';
?>
<form method="post" action="<?php echo _WEB_ROOT; ?>/home/post_user">
    <input type="text" name="fullname" placeholder="Họ tên..."><br/>
    <input type="text" name="email" placeholder="Email"><br/>
    <input type="password" name="password" placeholder="Mật khẩu..."><br/>
    <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu..."><br/>
    <button type="submit">Submit</button>
</form>