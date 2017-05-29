<?php
  use App\Mailer;
  use App\Session;

  Session::init();
  $token = Session::get('token');
  $method = $_SERVER['HTTP_X_REQUESTED_WITH'];
  $referer = $_SERVER['HTTP_REFERER'];
  $url = 'http://localhost/bootstrap/contact';

  if(!isset($method) || $method != 'XMLHttpRequest' || $referer != $url || !hash_equals($token, $_POST['token']))
  {
    exit();
  }

  $config = array(
    'email' => 'pawel.assasz678@gmail.com',
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
