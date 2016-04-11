function handleFrontendDebug(force) {
  if($('#manager-bar').length || force) {
    function is_frontend_debug() {
      var cookie_value = Cookies.get('frontend-debug');

      if(typeof(cookie_value) === 'undefined') {
        return $('body').hasClass('debug');
      } else {
        return cookie_value == 'true';
      }
    }

    function set_frontend_debug(state) {
      if(state) {
        $('.frontend-debug i').addClass('active').text('on');
        $('body').addClass('debug');
      } else {
        $('.frontend-debug i').removeClass('active').text('off');
        $('body').removeClass('debug');
      }

      Cookies.set('frontend-debug', state ? 'true' : 'false');
    }

    $('.frontend-debug').click(function() {
      if(is_frontend_debug()) {
        set_frontend_debug(false);
      } else {
        set_frontend_debug(true);
      }
      return false;
    });

    set_frontend_debug(is_frontend_debug());
  }
}


$(function() {
  handleFrontendDebug(true);
});
