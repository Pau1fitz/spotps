(function() {
  function getHashParams() {
    var hashParams = {};
    var e, r = /([^&;=]+)=?([^&;]*)/g,
    q = window.location.hash.substring(1);
    while ( e = r.exec(q)) {
      hashParams[e[1]] = decodeURIComponent(e[2]);
    }
    return hashParams;
  }

  $("#newsletter_notification").change(function() {
    if(this.checked) {
      $('#terms_check').fadeIn('slow');
      $('#terms_notification').prop('checked', false);
    } else {
      $('#terms_check').css('display', 'none');
      $('#terms_notification').prop('checked', false);
    }
  });

  var params = getHashParams();
  var access_token = params.access_token,
      refresh_token = params.refresh_token,
      error = params.error,
      url = 'http://presave.ragnbonemanmusic.com/',
      email;

  if (error) {
    alert('There was an error during the authentication');
  } else {

    if (access_token) {

      if (typeof $.cookie('presaved') === 'undefined'){
        $('#presave-form').css('display', 'block');
        $('.thank-you-message').css('display', 'none');
      } else {
        $('#presave-form').css('display', 'none');
        $('.thank-you-message, #copyCol #thanks').css('display', 'block');
        $('.guide').css('display', 'block');
      }

      $('#login').hide();
      $('#loggedin').show();

      $.ajax({
          type: 'GET',
          url: url + 'user-playlists',
          contentType: 'application/json',
          success: function(data) {
              var options = $(".options");
              email = data[0];
              $.each(data, function(index) {
                if(index != 0){
                  options.append($("<option class='playlist' />").val(this.id).text(this.name));
                }
              });
          },
          error: function (err) {
            console.log(err);
            window.location.href = url;
          }
      });

      $('#submit-btn').click(function (e) {

        e.preventDefault();

        $.ajax({
          type: 'POST',
          url: url + 'create-playlist',
          contentType: 'application/json',
          data: JSON.stringify(data),
          success: function(data) {
            $.cookie('presaved', 100);
            $('.playlist-error-message').fadeOut('slow');
            $('#presave-form').css('display', 'none');
            $('.thank-you-message, #copyCol #thanks').css('display', 'block');
            $('.guide').css('display', 'block');
            addEmailtoDataBase();
          },
          error: function (err) {
            $('#center .pad').empty();
            $('#center .pad').append('<div class="ajax-error-message"><p>Apologies, something went wrong</p></div>');
          }
        });
      })
    } else {
      $('#login').show();
      $('#loggedin').hide();
    }
  }
})();
