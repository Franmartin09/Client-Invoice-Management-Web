<form method="post" action="" name="signup-form" style="text-align:center;">
    <div class="form-element" style="margin-bottom:20px;">
        <label>Username</label>
        <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
    </div>

    <div class="form-element" style="margin-bottom:20px;">
        <label>Password</label>
        <input type="password" name="password" required />
    </div>

    <button type="submit" onclick=showLoading() name="enter" value="register" style="margin-bottom:40px; width:80px;height:30px;">Enter</button>
</form>