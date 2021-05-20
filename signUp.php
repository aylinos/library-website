<?php
$pageName = "Sign up";
 require_once "Controllers/UserController.php";
 require "includes/head.php";
?>
  <body class="logIn">
    <?php require "includes/Navigation.php"; ?>

    <div class="signup">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

    <h1 class="logIn">Create account</h1>
    <input type="text" class="logIn" id ="fname" name="fname" pattern="[a-zA-Z\s]+" placeholder="Enter your first name" value="<?php echo $sign_up_data['first_name']; ?>" required>
    <span class="help-block"><?php echo $sign_up_data['fname_err']; ?></span>

    <input type="text" class="logIn" id ="lname" name="lname" pattern="[a-zA-Z\s]+" placeholder="Enter your second name" value="<?php echo $sign_up_data['last_name']; ?>" required>
    <span class="help-block"><?php echo $sign_up_data['lname_err']; ?></span>

    <input type="text" class="logIn" id ="email" name="email" placeholder="Enter your email"  value="<?php echo $sign_up_data['email']; ?>" required>
    <span class="help-block"><?php echo $sign_up_data['email_err']; ?></span>

    <input type="password" class="logIn" id ="password" name="password"  placeholder="Enter your password" required>
    <span class="help-block"><?php echo $sign_up_data['password_err']; ?></span>

    <input type="password" class="logIn" id ="confirm_password" name="passwordConfirm"  placeholder="Confirm your password" required>
    <span class="help-block"><?php echo $sign_up_data['confirmPass_err']; ?></span>

    <input type="submit" class="logIn" id ="submit" name="signup" value="Create account">
    </form>

    </div>
  </body>
</html>
