<?php
  use App\Mailer;
  use App\Session;

  Session::init();
  $token = Session::get('token');
  $headers = apache_request_headers();
  $method = $_SERVER['HTTP_X_REQUESTED_WITH'];
  $referer = $_SERVER['HTTP_REFERER'];
  $url = 'http://localhost/bootstrap/contact';

  if(!isset($method) || $method != 'XMLHttpRequest' || $referer != $url || eval('return '.$headers['Token'].';') != $token)
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

  $mailer = new Mailer($config);
  try
  {
    $mailer->setMessage($data);
    $mailer->setTransport();
    $mailer->send();
  }
  catch (\Exception $error)
  {
    echo $error->getMessage();
  }
?>
