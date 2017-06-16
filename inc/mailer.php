<?php
  use App\Mailer;
  use App\Session;
  use App\Validator;

  Session::init();

  if(!Validator::validateAjaxRequest())
  {
    echo 'File is too big!';
    exit();
  }

  $config = array(
    'email' => 'antosiak.pawel@outlook.com',
    'name' => 'Paweł Antosiak',
    'subject' => 'Someone want to contact you',
    'username' => 'pawel.assasz678@gmail.com',
    'password' => 'wrpumvvyhufiaygh',
    'server' => 'smtp.gmail.com',
    'auth' => 'ssl',
    'port' => 465
  );

  $data = array(
    'name' => $_POST['fullname'] ?? null,
    'email' => $_POST['email'] ?? null,
    'message' => $_POST['message'] ?? null,
    'attachment' => $_FILES['attachment'] ?? null,
    'captcha' => $_POST['captcha']
  );

  try
  {
    $mailer = new Mailer($config);
    $mailer->setMessage($data);
    $mailer->send();
  }
  catch (\Exception $error)
  {
    echo $error->getMessage();
  }
?>
