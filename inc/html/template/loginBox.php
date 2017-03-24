    <div id="loginBox" class="bPopup">
        <span class="button b-close">
            <span>X</span>
        </span>
        <h3>Login to your Affiliate Account</h3>
        <p>Please enter your username and password to login.</p>
        <form name="login" id="loginForm" action="/affiliate/process/user/login.php" method="post">
            <div class="row">
                <label for="username">Username</label>
                <input id="username" type="text" name="username" value=""/>
            </div>
            <div class="row">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" value=""/>
            </div>
            <div class="row">
                <br/><input type="image" src="imgs/btns/login.png" />
            </div>
        </form>
        <script type="text/javascript" src="/js/sha512.js"></script>
        <script type="text/javascript" src="/js/login.js"></script>
    </div>