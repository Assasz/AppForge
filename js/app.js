$(document).ready(function()
{
  var path = location.pathname;
  var page = path.substring(11);

  if(path=='/bootstrap/')
  {
    $('#home').addClass('active');
  }
  else
  {
    $('#'+page).addClass('active');
  }

  $(window).on('scroll load', function()
  {
      if($(this).scrollTop() > 50)
      {
          $('.navbar-fixed-top').css('background', '#272B30');
      }
      else
      {
          $('.navbar-fixed-top').css('background', 'transparent');
      }
  });

  $('#fullname-input').on('change', function()
  {
    var pattern = new RegExp(/[\^<,"@\/\{\}\(\)\0123456789\*\$%\?=>:\|;#]+/i);

    if($(this).val().length>100 || pattern.test($(this).val()))
    {
      $(this).css("border-color", "#ff4444");
    }
    else
    {
      $(this).css("border-color", "#00C851");
    }
  });

  $('#email-input').on('change', function()
  {
    var regex = new RegExp(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/);
    if(!regex.test($(this).val()))
    {
      $(this).css("border-color", "#ff4444");
    }
    else
    {
      $(this).css("border-color", "#00C851");
    }
  });

  $('#message').on('change', function()
  {
    if($(this).val().length<1)
    {
      $(this).css("border-color", "#ff4444");
    }
    else
    {
      $(this).css("border-color", "#00C851");
    }
  });

  $('#attachment').on('change', function()
  {
    if (this.files[0].size > $(this).data('max-size'))
    {
      $('.message-box').fadeIn('slow').html('<div class="alert alert-danger" role="alert">File is too big! Maximal size of attachment is 10MB</div>');
      $("label[for='attachment']").css('background-color', '#ff4444');
    }
    else
    {
      $('.message-box').fadeOut('slow');
      $("label[for='attachment']").css('background-color', '#00C851');
    }
  });

  $('.toogle-chatbox').click(function()
  {
      $(this).css('opacity', '0');
      $('.chatbox').css('bottom', '25px');
  });

  $('.fa-close').click(function()
  {
      $('.toogle-chatbox').css('opacity', '1');
      $('.chatbox').css('bottom', '-400px');
  });

  var host = "ws://localhost:8888/bootstrap/vendor/websockets/echoserver.php";
  var socket = new WebSocket(host);

  socket.onopen = function()
  {
    console.log("Connection established");
  };

  socket.onerror = function()
  {
    console.log("Connection failed");
  };

  socket.onmessage = function(msg)
  {
    $('<img src="css/images/ellipsis.gif">').addClass('chatbox-loader').appendTo($('.chatbox-list')).delay(300).fadeOut(100);

    var showReply = function()
    {
      $('<li>').fadeIn().addClass('received').html(msg.data).appendTo($('.chatbox-list'));
      $('.chatbox-loader').remove();
    }

    setTimeout(showReply, 400);
    $('.chatbox-wrapper').animate({ scrollTop: 10000 }, 'normal');
  };

  $('#message').keypress(function(event)
  {
    if (event.keyCode == '13')
    {
   		socket.send($(this).val());
      $('<li>').addClass('sent').html($(this).val()).appendTo($('.chatbox-list'));
      event.preventDefault();
      event.currentTarget.value = "";
    }
  });

  $(window).scroll(function()
  {
    if($('#charts').length)
    {
      var chartsPosition = $('#charts').offset().top-300;
    }
    var scrollPosition = $(this).scrollTop();

    if(scrollPosition>chartsPosition && $('.chart span').html()=='0')
    {
      var chart1 = parseFloat($('#chart1 span').html());
      var chart2 = parseFloat($('#chart2 span').html());
      var chart3 = parseFloat($('#chart3 span').html());

      var increaseFirstChart = function()
      {
        if(chart1<86)
        {
          chart1++;
          $('#chart1 span').html(chart1);
        }
      }

      var increaseSecondChart = function()
      {
        if(chart2<152)
        {
          chart2++;
          $('#chart2 span').html(chart2);
        }
      }

      var increaseThirdChart = function()
      {
        if(chart3<6)
        {
          chart3++;
          $('#chart3 span').html(chart3);
        }
      }

      setInterval(increaseFirstChart, 9);
      setInterval(increaseSecondChart, 5);
      setInterval(increaseThirdChart, 133);

      $('#chart1').css('height', '150px');
      $('#chart2').css('height', '220px');
      $('#chart3').css('height', '100px');
    }
  });

  $('#preloader').delay(500).fadeOut();
  $('.header, .cover').parallax();
  $(".lazy").lazyload({effect : "fadeIn"});

  var progressPreloader = function()
  {
    var progress = $('#preloader-progress').html();
    progress = parseFloat(progress.substring(0, progress.length-1));

    if(progress<100)
    {
      progress+=5;
      $('#preloader-progress').html(progress+'%');
    }
  }

  setInterval(progressPreloader, 25);

  if(page=='contact')
  {
    initMap();
  }

  $('#portfolio-btn').click(function()
  {
    $('#full-portfolio').removeClass('hidden');
    $('html, body').animate({
        scrollTop: $( $.attr(this, 'href') ).offset().top-50
    }, 500);
  });

});

function initMap()
{
    var location = {lat: 54.386994, lng: 18.617413};
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: {lat: 54.405994, lng: 18.617413},
        disableDefaultUI: false,
        scrollwheel: false
      });

      var contentString = '<div class="iw-content">'+
            '<h3><span class="fa fa-fw fa-phone" aria-label="Phone number"></span>+48 518 300 079</h3>'+
            '<h3><span class="fa fa-fw fa-home" aria-label="Company adress"></span>Lilli Wenedy 18D/6 <bdi>Gdansk 80-419</bdi></h3>'+
            '</div>';

      var infowindow = new google.maps.InfoWindow({
        content: contentString
      });

      var styles = [
      {
          "featureType": "administrative",
          "elementType": "labels.text.fill",
          "stylers": [
              {
                  "color": "#272B30"
              }
          ]
      },
      {
          "featureType": "landscape",
          "elementType": "all",
          "stylers": [
              {
                  "color": "#e5e5e5"
              }
          ]
      },
      {
          "featureType": "poi",
          "elementType": "all",
          "stylers": [
              {
                  "visibility": "off"
              }
          ]
      },
      {
          "featureType": "road",
          "elementType": "all",
          "stylers": [
              {
                  "saturation": -100
              },
              {
                  "lightness": 45
              }
          ]
      },
      {
          "featureType": "road.highway",
          "elementType": "all",
          "stylers": [
              {
                  "visibility": "simplified"
              }
          ]
      },
      {
          "featureType": "road.arterial",
          "elementType": "labels.icon",
          "stylers": [
              {
                  "visibility": "off"
              }
          ]
      },
      {
          "featureType": "transit",
          "elementType": "all",
          "stylers": [
              {
                  "visibility": "off"
              }
          ]
      },
      {
          "featureType": "water",
          "elementType": "all",
          "stylers": [
              {
                  "color": "#00aeee"
              },
              {
                  "visibility": "on"
              }
          ]
      }
    ]

    map.set('styles', styles);

    var marker = new google.maps.Marker({
      position: location,
      map: map
    });

    infowindow.open(map, marker);

    marker.addListener('click', function()
    {
      infowindow.open(map, marker);
    });
}

$('.carousel[data-type="multi"] .item').each(function()
{
  var next = $(this).next();
  if(!next.length)
  {
    next = $(this).siblings(':first');
  }
  next.children(':first-child').clone().appendTo($(this));

  if(next.next().length>0)
  {
    next.next().children(':first-child').clone().appendTo($(this));
  }
  else
  {
  	$(this).siblings(':first').children(':first-child').clone().appendTo($(this));
  }
});

$('#send').click(function()
{
  $.ajax(
  {
    method: "POST",
    url: "mailer",
    cache: false,
    contentType: false,
    processData: false,
    data: new FormData($('#contact-form')[0]),
    xhr: function()
    {
       var xhr = new window.XMLHttpRequest();
       xhr.upload.addEventListener("progress", function(e)
       {
         if (e.lengthComputable)
         {
           var percentComplete = e.loaded/e.total*100+"%";
           $('.progress-bar').css('width', percentComplete);
         }
       }, false);
       return xhr;
     },
    beforeSend: function()
    {
      $('.progress-bar').removeAttr('style');
    },
    complete: function()
    {
      $('.progress-bar').delay(800).fadeOut('slow');
    },
    success: function(msg)
    {
      $('.progress-bar').css('background-color', '#00C851')
      $('.message-box div').remove();

      if(msg.indexOf('Thank') != -1)
      {
        $('#send').prop("disabled",true);
        $('.message-box').append('<div class="alert alert-success" role="alert"></div>');
      }
      else
      {
        $('.message-box').append('<div class="alert alert-danger" role="alert"></div>');
      }

      $('.message-box').delay(400).fadeIn('slow');
      $('.message-box div').html(msg);
    },
    error: function(error)
    {
      $('.progress-bar').css('background-color', '#CC0000')
      $('.message-box').delay(400).fadeIn('slow').html('<div class="alert alert-danger" role="alert">'+error+'</div>');
    }
  });
});
