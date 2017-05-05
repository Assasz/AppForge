<?php
  use App\Session;

  Session::init();
  Session::set('token', md5(uniqid(rand(), true)));
  $num1=rand(1,9);
  $num2=rand(1,9);
  Session::set('captcha', $num1+$num2);
?>

<header class="header" data-image-src="css/images/contact.jpeg">
  <div class="container-fluid container-header">
      <div class="col-md-12 text-center">
        <h1>Get in touch!<br>
        <small>Lorem ipsum dolor sit amet</small></h1>
      </div>
  </div>
</header>

<section class="section">
  <div class="col-md-6 centered">
    <form enctype="multipart/form-data" id="contact-form">
      <input class="form-control" id="fullname-input" name="fullname" placeholder="Fullname" type="text">
      <input class="form-control" id="email-input" name="email" placeholder="E-mail address" type="email">
      <textarea class="form-control" name="message" rows="8" id="message" placeholder="How can we help you?"></textarea>
      <button type="button" id="send" class="btn btn-form btn-blue pull-left">
        <span class="fa fa-fw fa-paper-plane" aria-hidden="true"></span>
        <span class="span">Send message</span>
      </button>
      <input id="attachment" name="attachment" type="file" class="file-input pull-left" data-max-size="10485760">
      <label for="attachment">
        <span class="fa fa-fw fa-paperclip" aria-label="Add attachment"></span>
      </label>
      <div class="captcha">
        <label for="captcha"><?= $num1.' + '.$num2.' =' ?></label>
        <input type="text" id="captcha" name="captcha" class="form-control" placeholder="?">
      </div>
      <output>
        <div class="progress-bar"></div>
        <div class="message-box"></div>
      </output>
    </form>
  </div>
</section>

<div id="map"></div>
