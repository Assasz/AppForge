<?php
namespace App;

class Mailer
{
  private $name;
  private $email;
  private $msg;
  private $attachment;

  public function __construct()
  {
    Session::init();
    $headers = apache_request_headers();
    $token = Session::get('token');

    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest' || $_SERVER['HTTP_REFERER']!='http://localhost/bootstrap/contact' || eval('return '.$headers['Token'].';')!=$token)
    {
      header('location: contact');
      exit();
    }

    $this->name = $_POST['fullname'] ?? null;
    $this->email = $_POST['email'] ?? null;
    $this->msg = $_POST['message'] ?? null;
    $this->attachment = $_FILES['attachment'] ?? null;
  }

  private function validate()
  {
    $regex = '/^[\p{Latin}\s]+$/u';

    if(strlen($this->name)>100 || !preg_match($regex, $this->name) || str_word_count($this->name)!=2)
    {
      return false;
    }

    if(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
    {
      return false;
    }

    if(strlen($this->msg)<1 || strlen($this->msg)>500)
    {
      return false;
    }

    if($this->attachment['size']!=0 && $this->attachment['size']>10485760)
    {
      return false;
    }

    return true;
  }

  public function send()
  {
    try
    {
      if($this->validate() && $_POST['captcha']==Session::get('captcha'))
      {
        if($this->attachment['size']!=0)
        {
          $message = \Swift_Message::newInstance()
          ->setSubject('Message from client')
          ->setFrom(array($this->email => $this->name))
          ->setTo(array('pawel.assasz678@gmail.com' => 'Paweł Antosiak'))
          ->setBody($this->msg."<br><br>E-mail address: ".$this->email, 'text/html')
          ->attach(\Swift_Attachment::fromPath($this->attachment['tmp_name'])
          ->setFilename($this->attachment['name']));
        }
        else
        {
          $message = \Swift_Message::newInstance()
          ->setSubject('Message from client')
          ->setFrom(array($this->email => $this->name))
          ->setTo(array('pawel.assasz678@gmail.com' => 'Paweł Antosiak'))
          ->setBody($this->msg."<br><br>E-mail address: ".$this->email, 'text/html');
        }

        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
        ->setUsername('pawel.assasz678@gmail.com')
        ->setPassword('wrpumvvyhufiaygh');
        $mailer = \Swift_Mailer::newInstance($transport);

        if($mailer->send($message))
        {
          echo '<div class="alert alert-success" role="alert">Thank you for message! We\'ll contact you back soon!</div>';
        }
        else
        {
          throw new \Exception("Sending message failed");
        }
      }
      else
      {
        throw new \Exception("Something went wrong! Make sure you entered correctly your name and surname, e-mail address and message");
      }
    }
    catch (\Exception $error)
    {
      echo '<div class="alert alert-danger" role="alert">'.$error->getMessage().'</div>';
    }
  }
}
?>
