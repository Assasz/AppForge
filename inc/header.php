<?php
use App\Router;
?>

<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="company, web development, studio">
    <meta name="description" content="Web development company">
    <title><?= Router::getTitle(); ?></title>

    <link rel="shortcut icon" href="css/images/logo.jpg">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/konpa/devicon/4f6a4b08efdad6bb29f9cc801f5c07e263b39907/devicon.min.css">
    <link href="https://fonts.googleapis.com/css?family=Pacifico|Varela+Round" rel="stylesheet">
  </head>

  <body>
  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
          <span class="fa fa-fw fa-bars" aria-label="Toggle menu"></span>
        </button>
        <span class="navbar-brand">AppForge</span>
      </div>
      <div class="collapse navbar-collapse" id="navbar-ex-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li id="home"><a href="home">About</a></li>
          <li id="services"><a href="services">Services</a></li>
          <li id="portfolio"><a href="portfolio">Portfolio</a></li>
          <li id="team"><a href="team">Team</a></li>
          <li id="contact"><a href="contact">Contact</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div id="preloader">
    <img src="css/images/ring-alt.gif" class="center-block img-responsive" alt="">
    <span id="preloader-progress">0%</span>
  </div>

  <div class="chatbox col-md-3">
    <div class="chatbox-header">
      <h3>Guide</h3>
      <span class="fa fa-fw fa-close" aria-label="Close chatbox"></span>
    </div>
    <div class="chatbox-wrapper">
      <div class="chatbox-container">
        <ul class="chatbox-list">
        </ul>
      </div>
    </div>
    <textarea class="form-control" name="message" rows="5" id="message" placeholder="Type something..."></textarea>
  </div>

  <div class="toogle-chatbox">
    <span class="icon-big glyphicon glyphicon-comment" aria-label="Toogle chatbox"></span>
  </div>
