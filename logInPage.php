<?php
  $pageName = "Log in";
  require_once "Controllers/UserController.php";
  // $pageName = "Log in";
  require "includes/head.php";
?>

  <body class="logIn">
  <?php require "includes/Navigation.php"; ?>
    <div class="login">

    <h1 class = "logIn">Welcome back! </h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"method="post">

    <input type="text" class="logIn" id ="email" placeholder="Enter your email" name="email" value="<?php if(isset($_COOKIE["remember_email"])) {echo decryptcookie($_COOKIE["remember_email"]);} else {echo $data['user_email']; }?>">
    <span class="help-block"><?php echo $data['user_email_err']; ?></span>
    <br>
    <input type="password" class="logIn" id ="password" name="password" placeholder="Enter your password" value="<?php if(isset($_COOKIE["remember_password"])) {echo decryptcookie($_COOKIE["remember_password"]);} else {echo $data['password']; }?>">
    <span class="help-block"><?php echo $data['password_err']; ?></span>
    <br>
    <div class="containerCheckmark">
    <input type="checkbox" class="logIn" id="checkbox" value="Remember me?" name = "remember" <?php if(isset($_COOKIE["remember_email"])) {?> checked <?php } ?>>
    <label for="checkbox">Remember me?</label>
    </div>
    <input type="submit" class="logIn" id ="submit" name="login" value="Submit">
    <div class="forgotPassword">
      <!-- Trigger/Open The Modal -->
      <button type="button" class="logIn" id="openModal">Forgot your password? Click here!</button>
      <!-- The Modal -->
      <div id="LogInModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
          <span class="closemodal">&times;</span>
          <h1 class="logIn">Reset password form</h1>
          <form class="resetPassword" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" class="logIn" id="emailResetPassw" name="emailreset" value="" placeholder="Enter your email">
            <br>
            <button type="submit" class="logIn" id="resetPass" name="resetpassword">Send password</button>
          </form>
        </div>
      </div>
    </div>
    <h3 class="logIn"><a href="signUp.php">Don't have an account? Create one right now!</h3>
    </form>
    </div>
  </body>
</html>
