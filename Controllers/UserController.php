<?php
//Remember me cookies
//When php pages go into views ->wrong path
include "models/User.php";

function encryptCookie( $value ) {
  $key = hex2bin(openssl_random_pseudo_bytes(4));

   $cipher = "aes-256-cbc";
   $ivlen = openssl_cipher_iv_length($cipher);
   $iv = openssl_random_pseudo_bytes($ivlen);

   $ciphertext = openssl_encrypt($value, $cipher, $key, 0, $iv);

   return( base64_encode($ciphertext . '::' . $iv. '::' .$key) );
 }

 function decryptCookie( $ciphertext ) {
  $cipher = "aes-256-cbc";

   list($encrypted_data, $iv,$key) = explode('::', base64_decode($ciphertext));
   return openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);
 }

 // Define variables and initialize with empty values
  $newPassword = "";
  $person_email_err = "";
 // Define variables and initialize with empty values
 $data =  [
     'user_email' => '',
     'password' => '',
     'user_email_err' => '',
     'password_err' => ''
 ];
 $sign_up_data = [
       'first_name' => '',
       'fname_err' => '',
       'last_name' => '',
       'lname_err' => '',
       'email' => '',
       'email_err' => '',
       'password' => '',
       'password_err' => '',
       'confirmPass' => '',
       'confirmPass_err' => ''
   ];
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
 if (isset($_POST['login']))
  {
    $data = login();
  }else if(isset($_POST['resetpassword']))
  {
    forgotPassword();
  }else if(isset($_POST['signup']))
  {
    $sign_up_data = signup();
  }else if(isset($_POST['user']))
  {
    updateuser();
  }else if (isset($_POST['savePicture'])) {
    updateprofilepicture();
  }
}

else if($pageName === "Profile page")
{
  $user = new User();
  $readBooks = [];
  $readBooks = $user->getUserBookHistory($readBooks);
}

function getuserinfo()
{
  $user = new User();
  $useri = $user->getuser();
  return $useri;
}

function login(){
  $user = new User();
  $data =  [
      'user_email' => '',
      'password' => '',
      'user_email_err' => '',
      'password_err' => ''
  ];
    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $data['user_email_err'] = "Please enter your email.";
    } else{
        $data['user_email'] = trim($_POST["email"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $data['password_err'] = "Please enter your password.";
    } else{
        $data['password'] = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($data['user_email_err']) && empty($data['password_err'])){
            $data = $user->login($data);
         }

    return $data;
  }

  function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  use PHPMailer\PHPMailer\SMTP;

  function forgotPassword()
  {
    require 'lib\composer\vendor\autoload.php';
    $userclass = new User();
    if(empty(trim($_POST["emailreset"]))){
        $person_email_err = "Please enter email.";
    } else{
        $personEmail = trim($_POST["emailreset"]);
    }

    if(empty($person_email_err)){

                if($userclass->findemail($_POST['emailreset'])){
                    $newPassword = generateRandomString();
                    $userclass->resetpassword(trim($_POST["emailreset"]), $newPassword);
                    $mail = new PHPMailer(TRUE);
                    /* Open the try/catch block. */
                    try {
                        //Server settings
                        $mail->isSMTP();                                            // Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                        $mail->SMTPAuth   = true;
                        $mail->Username  = 'pfontys@gmail.com';
                        $mail->Password  = 'projectsfontys';
                        $mail->SMTPSecure = 'tls';
                        $mail->Port       = 587;

                        /* Set the mail sender. */
                        $mail->setFrom('pfontys@gmail.com');

                        /* Add a recipient. */
                        $mail->addAddress($personEmail);

                        /* Set the subject. */
                        $mail->Subject = 'Book library: Reset password';

                        /* Set the mail message body. */
                        $mail->Body = 'Hello! You have made a request to reset your password. Your new password is: ' . $newPassword . " . You can now login with it.";

                        /* Finally send the mail. */
                        $mail->send();
                      }
                      catch (Exception $e)
                      {
                        /* PHPMailer exception. */
                        echo $e->errorMessage();
                      }
                      catch (\Exception $e)
                      {
                        /* PHP exception (note the backslash to select the global namespace Exception class). */
                        echo $e->getMessage();
                      }
            }
        }
  }


function updateuser()
{
    require "../models/Profile.php";
    $profile = new Profile();
    // header('Content-Type: text/plain');
    $user = utf8_encode($_POST['user']); // encoding
    $data = json_decode($user);
    $profile->updateprofile($data);
}

function signup()
{
  $user = new User();
  $sign_up_data = [
        'first_name' => '',
        'fname_err' => '',
        'last_name' => '',
        'lname_err' => '',
        'email' => '',
        'email_err' => '',
        'password' => '',
        'password_err' => '',
        'confirmPass' => '',
        'confirmPass_err' => ''
    ];

      // Validate  first name
      if(empty(trim($_POST["fname"]))){
            $sign_up_data['fname_err'] = "Please enter your first name!.";
          }else{
            $sign_up_data['first_name'] = $_POST['fname'];
          }
      // Validate last name
      if(empty(trim($_POST["lname"]))){
          $sign_up_data['lname_err'] = "Please enter your last name!.";
        }else {
          $sign_up_data['last_name'] = $_POST['lname'];
        }
      //Validate email
      if(empty(trim($_POST["email"]))){
            $sign_up_data['email_err'] = "Please enter your email!.";
          } else{
            $sign_up_data['email'] = trim($_POST['email']);
            // check if e-mail address is well-formed
            if (!filter_var($sign_up_data['email'], FILTER_VALIDATE_EMAIL)) {
            $sign_up_data['email_err'] = "Invalid email format";
            }
          }

      // Validate password
      $first = strtok($sign_up_data['email'], '@');
      if(empty(trim($_POST["password"]))){
          $sign_up_data['password_err'] = "Please enter a password.";
      } elseif(strlen(trim($_POST["password"])) < 6){
          $sign_up_data['password_err'] = "Password must have at least 6 characters.";
      } else if (stripos($_POST['password'], $_POST['fname']) !== false){
          //password contains first name
          $sign_up_data['password_err'] = "Password should not contain your name";
      } else if (stripos($_POST['password'], $first) !== false){
          //password contains first name
          $sign_up_data['password_err'] = "Password should not contain your email";
      } else{
          $sign_up_data['password'] = trim($_POST['password']);
      }

      // Validate confirm password
      if(empty(trim($_POST["passwordConfirm"]))){
          $sign_up_data['confirmPass_err'] = "Please confirm password.";
      } else{
          $sign_up_data['confirmPass'] = trim($_POST["passwordConfirm"]);
          if(empty($sign_up_data['password_err']) && ($sign_up_data['password'] !== $sign_up_data['confirmPass'])){
              $sign_up_data['confirmPass_err'] = "Password did not match.";
          }
      }
        // Validation and field insertion
        if(empty($sign_up_data['password_err']) && empty($sign_up_data['confirmPass_err']) &&
         empty($sign_up_data['email_err']) && empty($sign_up_data['lname_err']) && empty($sign_up_data['fname_err'])){

          if($user->findemail($sign_up_data['email'])){
              $sign_up_data['email_err'] = "This email already exists!";
          }else{
              $user->signup($sign_up_data);
              // Redirect to login page
              header("location: logInPage.php");
            }
          }
      return $sign_up_data;
}

function updateprofilepicture()
{
  $usr = new User();
  //Get image name
  $picture['userId'] = $_SESSION["id"];
  $picture['profileimage'] = $_FILES['fileid']['name'];
  //image file directory
  $target = "images/".basename($picture['profileimage']);
  // execute query
  if($usr->updateprofilepict($picture))
  {
   if (move_uploaded_file($_FILES['fileid']['tmp_name'], $target)) {
   }
  }
}

 ?>
