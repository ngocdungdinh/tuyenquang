$(document).ready(function(){  
  $("#ticker-answers").ticker({ effect: "slideUp", interval: 5000});
  window.setInterval(function() {
      $(".alert-message").fadeOut(1000);
  }, 4000);

  $('.hoverIntent').each(function(e){
    $(this).hoverIntent({
      over: function() {
        $(this).children('.dropdown-menu').css('display', 'block');
      },
      out: function() {
        $(this).children('.dropdown-menu').css('display', 'none');
      }
    })
  });


  $('.pover').on('click', function (e) {
      if($(this).hasClass('active')) {
        $(this).removeClass('active');
      } else {
        $(this).addClass('active');
      }
      $('.pover').not(this).removeClass('active');
      $('.pover').not(this).popover('hide');
  });

  $('a.play').click(function(e) {
    var yId = $(this).data('youtubeid');
    // console.log(yId);
    $(this).parent().html('<iframe width="298" height="230" src="http://www.youtube.com/embed/'+yId+'?showinfo=0&ps=docs&autoplay=1&iv_load_policy=3&vq=large&modestbranding=1&nologo=1&autohide=1&theme=light&color=red" frameborder="0" allowfullscreen="1"></iframe>');
  });
  
  /* ====== Search box toggle ===== */

  $('#nav-search').on('click', function() {
    $(this).toggleClass('show hidden');
    $(this).removeClass('animated flipInX');
    $("#nav-search-close").toggleClass('show hidden');
    $("#nav-search-form").toggleClass('show hidden animated flipInX');
    return false;
  });

  $('#nav-search-close').on('click', function() {
    $(this).toggleClass('show hidden');
    $("#nav-search").toggleClass('show hidden animated flipInX');
    $("#nav-search-form").toggleClass('show hidden animated flipInX');
    return false;
  });

  /* Navbar dropdown link bug fix */

  $('.navbar-nav > li > a').hover (function() {
    $(this).toggleClass("nav-hover-fix");
    return false;
  });

  var menu_head = $('ul.side-menu h2.title').height();
  var item_height = $('ul.side-menu li a').height();
  // Untoggle menu on click outside of it
  $(document).mouseup(function (e) {
    var container = $('ul.side-menu');
    if ((!container.is(e.target) && container.has(e.target).length === 0) && 
       (!($('a#menu-icon').is(e.target)) && $('a#menu-icon').has(e.target).length === 0)) {
      container.removeClass("in");
      $('body, ul.side-menu').removeClass("open");
      $('ul.side-menu li').css("top", "100%");
      $('ul.side-menu h2').css("top", "-60px");
    }
  });
   
  $("a#menu-icon").click(function(e) {
    $('#sideMenu').html($('#mainMenu').html());
    $('#sideMenu li').each(function(index, e){
      $(e).removeClass('main-menu').addClass('side-menu-item');
    });
    e.preventDefault();
    if ($('ul.side-menu, body').hasClass('open')) {
      $('ul.side-menu').removeClass('open');
      $('body').removeClass('open');
   
      // Reset menu on close
      $('ul.side-menu li').css("top", "100%");
      $('ul.side-menu h2').css("top", "-60px");
    }
    else {
      $('ul.side-menu').addClass('open');
      $('body').addClass('open');
   
      $('ul.side-menu h2').css("top", 0);
      $('ul.side-menu li').each(function() {
          // Traditional Effect
          if ($(this).hasClass('link')) {
              var i = ($(this).index() - 1)
          var fromTop = menu_head + (i * item_height);
          var delayTime = 100 * i;
          $(this).delay(delayTime).queue(function(){
              $(this).css("top", fromTop);
              $(this).dequeue();
              });
          }
          // Metro Effect
          else if ($(this).hasClass('metro')) {
              var row_i = ($(this).parent().parent().index() - 1); // Vertical Index
              var col_i = $(this).index(); // Horizontal Index
              var fromTop = menu_head + (row_i * 125);
                  var fromLeft = col_i * 125;
                  var delayTime = (row_i * 200) + Math.floor((Math.random() * 200) + 1);
                  console.log(delayTime);
            $(this).css("left", fromLeft);
                  $(this).delay(delayTime).queue(function(){
              $(this).css("top", fromTop);
              $(this).dequeue();
              });
          }
      });
    }
   
  });
});

/* ===== Sticky Navbar ===== */

$(window).load(function(){
  $(".navbar").sticky({ topSpacing: 0 });
  $(".sidestick-container").sticky({ topSpacing: 50, bottomSpacing: 550 });

  var time = moment($("#currentDate").attr('datetime'));
  $("#currentDate").html(time.format('dddd, DD/MM/YYYY | HH:mm Z'));
  
  BB.resizeFacebookComments();
});



var BB = BB || {};

BB.getPopularPosts = function(typeTab) {
    $.ajax({
        type: 'GET',
        url: "/news/" + typeTab,
        data: {
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'html',
        ifModify: true,
        success: function(data){
          $('#'+typeTab).html(data);
        }
    });
}

BB.updateViewCount = function(postId) {
  setTimeout(function() {
    $.ajax({
        type: 'POST',
        url: "/statistic/"+postId+"/updatepostview",
        data: {
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        ifModify: false,
        success: function(data){
        }
    });
  }, 500);
}

BB.resizeFacebookComments = function() {
  var src = $('.fb-comments iframe').attr('src');
  if(src) {
    var src = $('.fb-comments iframe').attr('src').split('width='),
      width = $(".fb-comments").parent().width();

    $('.fb-comments iframe').attr('src', src[0] + 'width=' + width);
  }
}

BB.addCommentVote = function() {
  $(".comment-date").each(function(e) {
    var cmttime = moment.unix($(this).data('datetime'));
    $(this).html(cmttime.fromNow());
  });

  var currPostId = $("#currPostId").val();

  if(currPostId) {
    $('.btn-comment-vote').each(function(key) {
      var e = $(this);
      var cmtId = e.data('cmtid');

      if(localStorage.getItem('votedComment' + cmtId) == 1) {
        e.addClass('disabled');
      } else {
        localStorage.setItem('votedComment' + cmtId, 0);

        e.click(function() {
          $.ajax({
              type: 'POST',
              url: "/comments/"+currPostId+"/addvote",
              data: {
                cmtId: cmtId,
                existVote: localStorage.getItem('votedComment' + cmtId),
                _token: $('meta[name="csrf-token"]').attr('content')
              },
              dataType: 'json',
              ifModify: true,
              success: function(data){
                $('#cmt-vote-' + cmtId).html(data.vote);
                localStorage.setItem('votedComment' + cmtId, 1);
                e.addClass('disabled');
              }
          });
        });
      }
    });
  }
}

BB.moreComment = function(postId, page, order) {
  if(postId && page) {
    $.ajax({
        type: 'GET',
        url: "/comments/"+postId+"/list",
        data: {
          postId: postId,
          page: page,
          order: order,
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'html',
        ifModify: true,
        success: function(data){
          $("#moreComment").html(data);
          $("#moreComment").attr('id', 'moreComment' + page);
          BB.addCommentVote();
        }
    });
  }
}

BB.commentList = function(order) {
  var postId = $("#currPostId").val();
  if(postId) {
    $.ajax({
        type: 'GET',
        url: "/comments/"+postId+"/list",
        data: {
          order: order,
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'html',
        ifModify: true,
        success: function(data){
          $("#commentList").html(data);
          BB.addCommentVote();
          $('.btn-comment-sort').each(function(key){
            $(this).click(function(){
              BB.commentList($(this).data("type"));
            })
          });
          $('.btn-comment-sort').removeClass('active');
          $('.btn-comment-sort[data-type="'+order+'"]').addClass('active');
        }
    });
  }
}

BB.submitComment2 = function() {
    var options = {
        beforeSubmit:  function(arr, $form, options) 
        {
            if(arr[0]['value']=="") {
                alert("Bạn cần nhập họ tên!");
                return false;
            }
            if(arr[1]['value']=="") {
                alert("Bạn cần nhập địa chỉ email!");
                return false;
            } else {
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if(!regex.test(arr[1]['value'])) {
                  alert("Địa chỉ email không hợp lệ!");
                  return false;
                }
            }
        },  // pre-submit callback
        success: function(data){
          var targetId = '#modal_displayInfo';
          $(targetId).html(data);
        },  // post-submit callback

        type:      'post',        // 'get' or 'post', override for form's 'method' attribute
        dataType:  'html',        // 'xml', 'script', or 'json' (expected server response type)
        clearForm: false        // clear all form fields after successful submit
        //resetForm: true        // reset the form after successful submit

        // $.ajax options can be used here too, for example:
        //timeout:   3000
    };
    $('#submitComment2').ajaxForm(options);
}

BB.submitComment = function() {
    var options = {
        beforeSubmit:  function(arr, $form, options) 
        {
            if(arr[0]['value']=="") {
                alert("Bạn cần nhập nội dung cho phản hồi!");
                return false;
            }
        },  // pre-submit callback
        success: function(data){
          var targetId = '#modal_displayInfo';
          $(targetId).modal("show"); 
          $(targetId).html(data); 
          BB.submitComment2();
        },  // post-submit callback

        type:      'post',        // 'get' or 'post', override for form's 'method' attribute
        dataType:  'html',        // 'xml', 'script', or 'json' (expected server response type)
        clearForm: false        // clear all form fields after successful submit
        //resetForm: true        // reset the form after successful submit

        // $.ajax options can be used here too, for example:
        //timeout:   3000
    };
    $('#submitComment').ajaxForm(options);
}

BB.extractVideoId = function() {
  var video_url = $('#video_url').val();
  if(video_url.length > 0) {
    var video_id = video_url.split('v=')[1];
    var ampersandPosition = video_id.indexOf('&');
    if(ampersandPosition != -1) {
      video_id = video_id.substring(0, ampersandPosition);
      $('#video-preview').html('<iframe width="182" height="130" src="http://www.youtube.com/embed/'+video_id+'?showinfo=0&amp;ps=docs&amp;autoplay=1&amp;iv_load_policy=3&amp;vq=large&amp;modestbranding=1&amp;nologo=1" frameborder="0" allowfullscreen="1"></iframe>');
      $('#video_id').val(video_id);
    }
  }
}

BB.confirmDelete = function(e) {
    if(confirm("bạn có chắc muốn thực hiện thao tác này?")) {
        window.location.href = $(e).attr("href");
    }
}


BB.FeaturedCarousel = function(id) {
  var _id = id;
  var _$root = $('#' + _id);

  if (!_$root.length) {
    return;
  }
  var _$carousel = _$root.find('.js-carousel');
  var _$animationStopper = _$root.find('.js-animation-stopper');

  var CLASS_HOVERED = 'hovered';

  var _swipe = null;
  if (BB.support.csstransforms) {
    _swipe = new Swipe(_$carousel[0], { callback : swipeCallback });
  }

  _$root.on('click', '.js-control', function(ev) {
    var $el = $(this);
    var t = $el.data('type');
    loadImages();
    goDirection(t);
    return false;
  });

  _$root.on('click', '.js-indicator', function(ev) {
    var $el = $(this);
    var index = $el.data('index');
    loadImages();
    goToIndex(index);
    return false;
  });

  setInterval(function() {
    if (!_$carousel.hasClass(CLASS_HOVERED)) {
      loadImages();
      _swipe.next();
    }
  }, 8000);

  _$animationStopper.hover(
    function() {
      _$carousel.addClass(CLASS_HOVERED);
      $('.carousel-controls .control').show();
    },
    function() {
      _$carousel.removeClass(CLASS_HOVERED);
      $('.carousel-controls .control').hide();
    }
  );

  function loadImages() {
    _$root.find('img[data-src]').each(function(i, e) {
      var $img = $(this);
      $img.one('load', function(e) {
        $(this).animate('opacity', 1);
      });
      $img.attr('src', $img.data('src')).removeAttr('data-src');
    });
  }

  function goDirection(direction) {
    if (_swipe) {
      if (direction === 'next') {
        _swipe.next();
      }
      if (direction === 'prev') {
        _swipe.prev();
      }
    } else {
      var activeImage = _$root.find('.js-active-image');
      var currentIndex = activeImage.data('index');
      var carouselLength = activeImage.data('length');
      var nextIndex = 0;
      if (direction === 'next') {
        nextIndex = currentIndex + 1;
        if (currentIndex + 1 == carouselLength) {
          nextIndex = 0;
        }
      }
      if (direction === 'prev') {
        nextIndex = currentIndex - 1;
        if (nextIndex < 0) {
          nextIndex = 0;
        }
      }
      var nextImageSelector = '.js-image[data-index="' + nextIndex + '"]';
      var nextImage = $(nextImageSelector, _$root);
      swapActiveImages(activeImage, nextImage);
      swipeCallback(null, nextIndex, null);
    }
  }

  function goToIndex(index) {
    if (_swipe) {
      _swipe.slide(index);
    } else {
      var nextIndex = index;
      var activeImage = _$root.find('.js-active-image');
      var currentIndex = activeImage.data('index');
      var nextImageSelector = '.js-image[data-index="' + nextIndex + '"]';
      var nextImage = $(nextImageSelector, _$root);
      swapActiveImages(activeImage, nextImage);
      swipeCallback(null, nextIndex, null);
    }
  }

  function swapActiveImages(activeImage, nextImage) {
    activeImage.hide();
    nextImage.show();
    activeImage.removeClass('js-active-image');
    nextImage.addClass('js-active-image');
  }

  function swipeCallback(ev, index, el) {
    var CLASS_ACTIVE_META = 'js-active-meta';
    var CLASS_ACTIVE_IND = 'js-active-ind';
    var currentMetaCard = _$carousel.find('.' + CLASS_ACTIVE_META);
    var currentIndicator = _$root.find('.' + CLASS_ACTIVE_IND);

    var nextMetaCard = _$carousel.find(
      '.js-single-meta[data-index="' + index + '"]');
    var nextIndicator = _$root.find(
      '.js-indicator[data-index="' + index + '"]');

    currentMetaCard.hide();
    nextMetaCard.show();

    currentMetaCard.removeClass(CLASS_ACTIVE_META);
    nextMetaCard.addClass(CLASS_ACTIVE_META);

    currentIndicator.removeClass(CLASS_ACTIVE_IND);
    nextIndicator.addClass(CLASS_ACTIVE_IND);
  }
};

$(function() {
  // BB.facebook_signin.init();
});

BB.facebook_signin = (function() {
  var init_access_token = null;
  function submit_login(access_token, failure_callback) {

    var data  = {access_token: access_token, _token: $('meta[name="csrf-token"]').attr('content')};
    if (BB.delayed.action && BB.delayed.identifier) {
      data.delayed_action = BB.delayed.action;
      data.delayed_identifier = BB.delayed.identifier;
    }
    $.ajax({
      type: 'GET',
      url: BB.facebook_signin_url,
      data: data,
      success: function(data) {

        if (data.success) {
          if (data.next) {
            window.location.href = data.next;
          } else {
            // If this login was completed from an authenticated
            // referral, we need to trim off the hash so the next page
            // load does not attempt to log in again.
            var hash = window.location.hash;
            if (hash && hash.indexOf('#access_token') === 0) {
              window.location.href = window.location.href.split('#')[0];
            } else {
              window.location.reload();
            }
          }
        } else {
          if (data.failure_reason === 'other-account') {
            // if (data.has_twitter && data.has_email) {
            //   BB.notification.show('It appears that you might already have a ' +
            //                        'Snapguide account linked to Twitter. ' +
            //                        'You may have also linked your account to ' +
            //                        'your email address. Try signing in with ' +
            //                        'one of them.');
            // }
            // else if (data.has_twitter) {
            //   BB.notification.show('It appears that you might already have a ' +
            //                        'Snapguide account linked to another ' +
            //                        'service. Try signing in with Twitter.');
            // }
            // else if (data.has_email) {
            //   BB.notification.show('It appears that you might already have a ' +
            //                        'Snapguide account. Try signing in with ' +
            //                        'your email address.');
            // }
          } else if (failure_callback) {
            failure_callback();
          } else {
            alert('Facebook sign in failed.');
          }
        }
      },
      error: function(xhr, status) {
        // BB.notification.show('Sign in failed (' + status + ').');
      }
    });
  }

  function submit_connect(access_token, failure_callback) {
    $.ajax({
      type: 'POST',
      url: BB.facebook_connect_url,
      data: {
        access_token: access_token
      },
      success: function(data) {
        if (data.success) {
          window.location.reload();
        } else if (data.error === 'exists') {
          alert('This Facebook account is already connected' +
                               ' to another Snapguide account.');
        } else {
          if (failure_callback) {
            failure_callback();
          } else {
            alert('Đăng nhập bằng Facebook không thành công.');
          }
        }
      },
      error: function(xhr, status) {
        alert('Connect failed (' + status + ').');
      }
    });
  }

  function login(success_callback) {
    FB.login(function(response) {
      var access_token = ((response || {}).authResponse || {}).accessToken;
      if (access_token) {
        success_callback(access_token);
      } else {
        alert('Đăng nhập bằng Facebook không thành công.');
      }
    }, {scope: 'email,user_birthday,user_about_me,user_friends,user_hometown,user_location,user_website'});
  }

  return {
    init: function() {
      // Log the user in automatically if an access_token is passed in
      // the hash.  This is to support authenticated referrals.
      var hash = window.location.hash;
      if (hash) {
        var a = hash.match(/^#access_token=([^&]*)/);
        if (a) {
          var access_token = a[1];
          submit_login(access_token);
        }
      }
      return true;
    },
    attach: function() {
      FB.getLoginStatus(function(response) {
        init_access_token = ((response || {}).authResponse || {}).accessToken;
      });
    },
    signin: function() {
      if (init_access_token) {
        submit_login(init_access_token, function() {
          login(submit_login);
        });
      } else {
        login(submit_login);
      }
      return false;
    },
    connect: function() {
      if (init_access_token) {
        submit_connect(init_access_token, function() {
          login(submit_connect);
        });
      } else {
        login(submit_connect);
      }
      return false;
    }
  };
})();


/*
 * Swipe 1.0
 *
 * Brad Birdsall, Prime
 * Copyright 2011, Licensed GPL & MIT
 *
*/

window.Swipe = function(element, options) {
  // return immediately if element doesn't exist
  if (!element) return null;

  var _this = this;

  // retreive options
  this.options = options || {};
  this.index = this.options.startSlide || 0;
  this.speed = this.options.speed || 300;
  this.callback = this.options.callback || function() {};
  this.delay = this.options.auto || 0;

  // reference dom elements
  this.container = element;
  this.element = this.container.children[0]; // the slide pane

  // static css
  this.container.style.overflow = 'hidden';
  this.element.style.listStyle = 'none';

  // trigger slider initialization
  this.setup();

  // begin auto slideshow
  this.begin();

  // add event listeners
  if (this.element.addEventListener) {
    this.element.addEventListener('touchstart', this, false);
    this.element.addEventListener('touchmove', this, false);
    this.element.addEventListener('touchend', this, false);
    this.element.addEventListener('webkitTransitionEnd', this, false);
    this.element.addEventListener('msTransitionEnd', this, false);
    this.element.addEventListener('oTransitionEnd', this, false);
    this.element.addEventListener('transitionend', this, false);
    window.addEventListener('resize', this, false);
  }

};

Swipe.prototype = {

  setup: function() {

    // get and measure amt of slides
    this.slides = this.element.children;
    this.length = this.slides.length;

    // return immediately if their are less than two slides
    if (this.length < 2) return null;

    // determine width of each slide
    this.width = this.container.getBoundingClientRect().width;

    // return immediately if measurement fails
    if (!this.width) return null;

    // hide slider element but keep positioning during setup
    this.container.style.visibility = 'hidden';

    // dynamic css
    this.element.style.width = (this.slides.length * this.width) + 'px';
    var index = this.slides.length;
    while (index--) {
      var el = this.slides[index];
      el.style.width = this.width + 'px';
      el.style.display = 'table-cell';
      el.style.verticalAlign = 'top';
    }

    // set start position and force translate to remove initial flickering
    this.slide(this.index, 0);

    // show slider element
    this.container.style.visibility = 'visible';

  },

  slide: function(index, duration) {

    var style = this.element.style;

    // fallback to default speed
    if (duration == undefined) {
        duration = this.speed;
    }

    // set duration speed (0 represents 1-to-1 scrolling)
    style.webkitTransitionDuration = style.MozTransitionDuration = style.msTransitionDuration = style.OTransitionDuration = style.transitionDuration = duration + 'ms';

    // translate to given index position
    style.MozTransform = style.webkitTransform = 'translate3d(' + -(index * this.width) + 'px,0,0)';
    style.msTransform = style.OTransform = 'translateX(' + -(index * this.width) + 'px)';

    // set new index to allow for expression arguments
    this.index = index;

  },

  getPos: function() {

    // return current index position
    return this.index;

  },

  prev: function(delay) {

    // cancel next scheduled automatic transition, if any
    this.delay = delay || 0;
    clearTimeout(this.interval);

    // if not at first slide
    if (this.index) this.slide(this.index-1, this.speed);

  },

  next: function(delay) {

    // cancel next scheduled automatic transition, if any
    this.delay = delay || 0;
    clearTimeout(this.interval);

    if (this.index < this.length - 1) this.slide(this.index+1, this.speed); // if not last slide
    else this.slide(0, this.speed); //if last slide return to start

  },

  begin: function() {

    var _this = this;

    this.interval = (this.delay)
      ? setTimeout(function() {
        _this.next(_this.delay);
      }, this.delay)
      : 0;

  },

  stop: function() {
    this.delay = 0;
    clearTimeout(this.interval);
  },

  resume: function() {
    this.delay = this.options.auto || 0;
    this.begin();
  },

  handleEvent: function(e) {
    switch (e.type) {
      case 'touchstart': this.onTouchStart(e); break;
      case 'touchmove': this.onTouchMove(e); break;
      case 'touchend': this.onTouchEnd(e); break;
      case 'webkitTransitionEnd':
      case 'msTransitionEnd':
      case 'oTransitionEnd':
      case 'transitionend': this.transitionEnd(e); break;
      case 'resize': this.setup(); break;
    }
  },

  transitionEnd: function(e) {
    if (this.delay) this.begin();

    this.callback(e, this.index, this.slides[this.index]);

  },

  onTouchStart: function(e) {

    this.start = {

      // get touch coordinates for delta calculations in onTouchMove
      pageX: e.touches[0].pageX,
      pageY: e.touches[0].pageY,

      // set initial timestamp of touch sequence
      time: Number( new Date() )

    };

    // used for testing first onTouchMove event
    this.isScrolling = undefined;

    // reset deltaX
    this.deltaX = 0;

    // set transition time to 0 for 1-to-1 touch movement
    this.element.style.MozTransitionDuration = this.element.style.webkitTransitionDuration = 0;

  },

  onTouchMove: function(e) {

    // ensure swiping with one touch and not pinching
    if(e.touches.length > 1 || e.scale && e.scale !== 1) return;

    this.deltaX = e.touches[0].pageX - this.start.pageX;

    // determine if scrolling test has run - one time test
    if ( typeof this.isScrolling == 'undefined') {
      this.isScrolling = !!( this.isScrolling || Math.abs(this.deltaX) < Math.abs(e.touches[0].pageY - this.start.pageY) );
    }

    // if user is not trying to scroll vertically
    if (!this.isScrolling) {

      // prevent native scrolling
      e.preventDefault();

      // cancel slideshow
      clearTimeout(this.interval);

      // increase resistance if first or last slide
      this.deltaX =
        this.deltaX /
          ( (!this.index && this.deltaX > 0               // if first slide and sliding left
            || this.index == this.length - 1              // or if last slide and sliding right
            && this.deltaX < 0                            // and if sliding at all
          ) ?
          ( Math.abs(this.deltaX) / this.width + 1 )      // determine resistance level
          : 1 );                                          // no resistance if false

      // translate immediately 1-to-1
      this.element.style.MozTransform = this.element.style.webkitTransform = 'translate3d(' + (this.deltaX - this.index * this.width) + 'px,0,0)';

    }

  },

  onTouchEnd: function(e) {

    // determine if slide attempt triggers next/prev slide
    var isValidSlide =
          Number(new Date()) - this.start.time < 250      // if slide duration is less than 250ms
          && Math.abs(this.deltaX) > 20                   // and if slide amt is greater than 20px
          || Math.abs(this.deltaX) > this.width/2,        // or if slide amt is greater than half the width

    // determine if slide attempt is past start and end
        isPastBounds =
          !this.index && this.deltaX > 0                          // if first slide and slide amt is greater than 0
          || this.index == this.length - 1 && this.deltaX < 0;    // or if last slide and slide amt is less than 0

    // if not scrolling vertically
    if (!this.isScrolling) {

      // call slide function with slide end value based on isValidSlide and isPastBounds tests
      this.slide( this.index + ( isValidSlide && !isPastBounds ? (this.deltaX < 0 ? 1 : -1) : 0 ), this.speed );

    }

  }

};
/*!
 * jQuery ticker - v0.1 - 7/9/2011
 *
 * Version: 0.1, Last updated: 7/9/2011
 * Requires: jQuery v1.3.2+
 *
 * Copyright (c) 2011 Radek Pleskac www.radekpleskac.com
 * Dual licensed under the MIT and GPL licenses.
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * Examples http://www.radekpleskac.com.com/projects/jquery-ticker/
 * jQuery plugin to turn an unordered list <ul> into a simple ticker, displaying one list item at a time.
 *
*/

(function($){

  $.fn.ticker = function(options) {

    $.fn.ticker.defaults =  {
      controls: false, //show controls, to be implemented
      interval: 3000, //interval to show next item
      effect: "fadeIn", // available effects: fadeIn, slideUp, slideDown
      duration: 400 //duration of the change to the next item
    };

    var o = $.extend({}, $.fn.ticker.defaults, options);

    if (!this.length)
      return;

    return this.each(function() {

      var $ul = $(this),
        $items = $ul.find("li"),
        index = 0,
        paused = false,
        time;

      function start() {
        time = setInterval(function() {
          if (!paused)
            changeItem();
        }, o.interval);
      }

      function changeItem() {

        var $current = $items.eq(index);
        index++;
        if (index == $items.length)
          index = 0;
        var $next =  $items.eq(index);

        if (o.effect == "fadeIn") {
          $current.fadeOut(function() {
            $next.fadeIn();
          });
        }
        else if (o.effect == "slideUp" || o.effect == "slideDown") {
          var h = $ul.height();
          var d = (o.effect == "slideUp") ? 1 : -1;
          $current.animate({
            top: -h * d + "px"
          }, o.duration, function() { $(this).hide(); });
          $next.css({
            "display": "block",
            "top": h * d + "px"
          });
          $next.animate({
            top: 0
          }, o.duration);
        }

      }

      function bindEvents() {
        $ul.hover(function() {
          paused = true;
        },function() {
          paused = false;
        });
      }

      function init() {
        $items.not(":first").hide();
        if (o.effect == "slideUp" || o.effect == "slideDown") {
          $ul.css("position", "relative");
          $items.css("position", "absolute");
        }

        bindEvents();
        start();
      }

      init();

    });

  };

})(jQuery);

//** jQuery Scroll to Top Control script- (c) Dynamic Drive DHTML code library: http://www.dynamicdrive.com.
//** Available/ usage terms at http://www.dynamicdrive.com (March 30th, 09')
//** v1.1 (April 7th, 09'):
//** 1) Adds ability to scroll to an absolute position (from top of page) or specific element on the page instead.
//** 2) Fixes scroll animation not working in Opera. 


var scrolltotop={
  //startline: Integer. Number of pixels from top of doc scrollbar is scrolled before showing control
  //scrollto: Keyword (Integer, or "Scroll_to_Element_ID"). How far to scroll document up when control is clicked on (0=top).
  setting: {startline:100, scrollto: 0, scrollduration:1000, fadeduration:[500, 100]},
  controlHTML: '<i class="fa fa-angle-up backtotop"></i>', //HTML for control, which is auto wrapped in DIV w/ ID="topcontrol"
  controlattrs: {offsetx:5, offsety:5}, //offset of control relative to right/ bottom of window corner
  anchorkeyword: '#top', //Enter href value of HTML anchors on the page that should also act as "Scroll Up" links

  state: {isvisible:false, shouldvisible:false},

  scrollup:function(){
    if (!this.cssfixedsupport) //if control is positioned using JavaScript
      this.$control.css({opacity:0}) //hide control immediately after clicking it
    var dest=isNaN(this.setting.scrollto)? this.setting.scrollto : parseInt(this.setting.scrollto)
    if (typeof dest=="string" && jQuery('#'+dest).length==1) //check element set by string exists
      dest=jQuery('#'+dest).offset().top
    else
      dest=0
    this.$body.animate({scrollTop: dest}, this.setting.scrollduration);
  },

  keepfixed:function(){
    var $window=jQuery(window)
    var controlx=$window.scrollLeft() + $window.width() - this.$control.width() - this.controlattrs.offsetx
    var controly=$window.scrollTop() + $window.height() - this.$control.height() - this.controlattrs.offsety
    this.$control.css({left:controlx+'px', top:controly+'px'})
  },

  togglecontrol:function(){
    var scrolltop=jQuery(window).scrollTop()
    if (!this.cssfixedsupport)
      this.keepfixed()
    this.state.shouldvisible=(scrolltop>=this.setting.startline)? true : false
    if (this.state.shouldvisible && !this.state.isvisible){
      this.$control.stop().animate({opacity:1}, this.setting.fadeduration[0])
      this.state.isvisible=true
    }
    else if (this.state.shouldvisible==false && this.state.isvisible){
      this.$control.stop().animate({opacity:0}, this.setting.fadeduration[1])
      this.state.isvisible=false
    }
  },
  
  init:function(){
    jQuery(document).ready(function($){
      var mainobj=scrolltotop
      var iebrws=document.all
      mainobj.cssfixedsupport=!iebrws || iebrws && document.compatMode=="CSS1Compat" && window.XMLHttpRequest //not IE or IE7+ browsers in standards mode
      mainobj.$body=(window.opera)? (document.compatMode=="CSS1Compat"? $('html') : $('body')) : $('html,body')
      mainobj.$control=$('<div id="topcontrol">'+mainobj.controlHTML+'</div>')
        .css({position:mainobj.cssfixedsupport? 'fixed' : 'absolute', bottom:mainobj.controlattrs.offsety, right:mainobj.controlattrs.offsetx, opacity:0, cursor:'pointer'})
        .attr({title:''})
        .click(function(){mainobj.scrollup(); return false})
        .appendTo('body')
      if (document.all && !window.XMLHttpRequest && mainobj.$control.text()!='') //loose check for IE6 and below, plus whether control contains any text
        mainobj.$control.css({width:mainobj.$control.width()}) //IE6- seems to require an explicit width on a DIV containing text
      mainobj.togglecontrol()
      $('a[href="' + mainobj.anchorkeyword +'"]').click(function(){
        mainobj.scrollup()
        return false
      })
      $(window).bind('scroll resize', function(e){
        mainobj.togglecontrol()
      })
    })
  }
}

scrolltotop.init();
// Sticky Plugin v1.0.0 for jQuery
// =============
// Author: Anthony Garand
// Improvements by German M. Bravo (Kronuz) and Ruud Kamphuis (ruudk)
// Improvements by Leonardo C. Daronco (daronco)
// Created: 2/14/2011
// Date: 2/12/2012
// Website: http://labs.anthonygarand.com/sticky
// Description: Makes an element on the page stick on the screen as you scroll
//       It will only set the 'top' and 'position' of your element, you
//       might need to adjust the width in some cases.

(function($) {
  var defaults = {
      topSpacing: 0,
      bottomSpacing: 0,
      className: 'is-sticky',
      wrapperClassName: 'sticky-wrapper',
      center: false,
      getWidthFrom: ''
    },
    $window = $(window),
    $document = $(document),
    sticked = [],
    windowHeight = $window.height(),
    scroller = function() {
      var scrollTop = $window.scrollTop(),
        documentHeight = $document.height(),
        dwh = documentHeight - windowHeight,
        extra = (scrollTop > dwh) ? dwh - scrollTop : 0;

      for (var i = 0; i < sticked.length; i++) {
        var s = sticked[i],
          elementTop = s.stickyWrapper.offset().top,
          etse = elementTop - s.topSpacing - extra;

        if (scrollTop <= etse) {
          if (s.currentTop !== null) {
            s.stickyElement
              .css('position', '')
              .css('top', '');
            s.stickyElement.parent().removeClass(s.className);
            s.currentTop = null;
          }
        }
        else {
          var newTop = documentHeight - s.stickyElement.outerHeight()
            - s.topSpacing - s.bottomSpacing - scrollTop - extra;
          if (newTop < 0) {
            newTop = newTop + s.topSpacing;
          } else {
            newTop = s.topSpacing;
          }
          if (s.currentTop != newTop) {

            var widthRelative = s.stickyElement.parent().width();

            s.stickyElement
              .css('position', 'fixed')
              .css('width', widthRelative)
              .css('top', newTop);

            if (typeof s.getWidthFrom !== 'undefined') {
              s.stickyElement.css('width', $(s.getWidthFrom).width());
            }

            s.stickyElement.parent().addClass(s.className);
            s.currentTop = newTop;
          }
        }
      }
    },
    resizer = function() {
      windowHeight = $window.height();
    },
    methods = {
      init: function(options) {
        var o = $.extend(defaults, options);
        return this.each(function() {
          var stickyElement = $(this);

          var stickyId = stickyElement.attr('id');
          var wrapper = $('<div></div>')
            .attr('id', stickyId + '-sticky-wrapper')
            .addClass(o.wrapperClassName);
          stickyElement.wrapAll(wrapper);

          if (o.center) {
            stickyElement.parent().css({width:stickyElement.outerWidth(),marginLeft:"auto",marginRight:"auto"});
          }

          if (stickyElement.css("float") == "right") {
            stickyElement.css({"float":"none"}).parent().css({"float":"right"});
          }

          var stickyWrapper = stickyElement.parent();
          stickyWrapper.css('height', stickyElement.outerHeight());
          sticked.push({
            topSpacing: o.topSpacing,
            bottomSpacing: o.bottomSpacing,
            stickyElement: stickyElement,
            currentTop: null,
            stickyWrapper: stickyWrapper,
            className: o.className,
            getWidthFrom: o.getWidthFrom
          });
        });
      },
      update: scroller
    };

  // should be more efficient than using $window.scroll(scroller) and $window.resize(resizer):
  if (window.addEventListener) {
    window.addEventListener('scroll', scroller, false);
    window.addEventListener('resize', resizer, false);
  } else if (window.attachEvent) {
    window.attachEvent('onscroll', scroller);
    window.attachEvent('onresize', resizer);
  }

  $.fn.sticky = function(method) {
    if (methods[method]) {
      return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
    } else if (typeof method === 'object' || !method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error('Method ' + method + ' does not exist on jQuery.sticky');
    }
  };
  $(function() {
    setTimeout(scroller, 0);
  });
})(jQuery);

/**
 * @name jQuery Stick 'em
 * @author Trevor Davis
 * @version 1.4.1
 *
 *  $('.container').stickem({
 *    item: '.stickem',
 *    container: '.stickem-container',
 *    stickClass: 'stickit',
 *    endStickClass: 'stickit-end',
 *    offset: 0,
 *    onStick: null,
 *    onUnstick: null
 *  });
 */

;(function($, window, document, undefined) {

  var Stickem = function(elem, options) {
    this.elem = elem;
    this.$elem = $(elem);
    this.options = options;
    this.metadata = this.$elem.data("stickem-options");
    this.$win = $(window);
  };

  Stickem.prototype = {
    defaults: {
      item: '.stickem',
      container: '.stickem-container',
      stickClass: 'stickit',
      endStickClass: 'stickit-end',
      offset: 0,
      start: 0,
      onStick: null,
      onUnstick: null
    },

    init: function() {
      var _self = this;

      //Merge options
      _self.config = $.extend({}, _self.defaults, _self.options, _self.metadata);

      _self.setWindowHeight();
      _self.getItems();
      _self.bindEvents();

      return _self;
    },

    bindEvents: function() {
      var _self = this;

      _self.$win.on('scroll.stickem', $.proxy(_self.handleScroll, _self));
      _self.$win.on('resize.stickem', $.proxy(_self.handleResize, _self));
    },

    destroy: function() {
      var _self = this;

      _self.$win.off('scroll.stickem');
      _self.$win.off('resize.stickem');
    },

    getItem: function(index, element) {
      var _self = this;
      var $this = $(element);
      var item = {
        $elem: $this,
        elemHeight: $this.height(),
        $container: $this.parents(_self.config.container),
        isStuck: false
      };

      //If the element is smaller than the window
      if(_self.windowHeight > item.elemHeight) {
        item.containerHeight = item.$container.outerHeight();
        item.containerInner = {
          border: {
            bottom: parseInt(item.$container.css('border-bottom'), 10) || 0,
            top: parseInt(item.$container.css('border-top'), 10) || 0
          },
          padding: {
            bottom: parseInt(item.$container.css('padding-bottom'), 10) || 0,
            top: parseInt(item.$container.css('padding-top'), 10) || 0
          }
        };

        item.containerInnerHeight = item.$container.height();
        item.containerStart = item.$container.offset().top - _self.config.offset + _self.config.start + item.containerInner.padding.top + item.containerInner.border.top;
        item.scrollFinish = item.containerStart - _self.config.start + (item.containerInnerHeight - item.elemHeight);

        //If the element is smaller than the container
        if(item.containerInnerHeight > item.elemHeight) {
          _self.items.push(item);
        }
      } else {
        item.$elem.removeClass(_self.config.stickClass + ' ' + _self.config.endStickClass);
      }
    },

    getItems: function() {
      var _self = this;

      _self.items = [];

      _self.$elem.find(_self.config.item).each($.proxy(_self.getItem, _self));
    },

    handleResize: function() {
      var _self = this;

      _self.getItems();
      _self.setWindowHeight();
    },

    handleScroll: function() {
      var _self = this;

      if(_self.items.length > 0) {
        var pos = _self.$win.scrollTop();

        for(var i = 0, len = _self.items.length; i < len; i++) {
          var item = _self.items[i];

          //If it's stuck, and we need to unstick it, or if the page loads below it
          if((item.isStuck && (pos < item.containerStart || pos > item.scrollFinish)) || pos > item.scrollFinish) {
            item.$elem.removeClass(_self.config.stickClass);

            //only at the bottom
            if(pos > item.scrollFinish) {
              item.$elem.addClass(_self.config.endStickClass);
            }

            item.isStuck = false;

            //if supplied fire the onUnstick callback
            if(_self.config.onUnstick) {
              _self.config.onUnstick(item);
            }

          //If we need to stick it
          } else if(item.isStuck === false && pos > item.containerStart && pos < item.scrollFinish) {
              var widthRelative = item.$elem.parent().width();
              item.$elem.removeClass(_self.config.endStickClass).addClass(_self.config.stickClass).css('width', widthRelative);
              item.isStuck = true;

              //if supplied fire the onStick callback
              if(_self.config.onStick) {
                _self.config.onStick(item);
              }
          }
        }
      }
    },

    setWindowHeight: function() {
      var _self = this;

      _self.windowHeight = _self.$win.height() - _self.config.offset;
    }
  };

  Stickem.defaults = Stickem.prototype.defaults;

  $.fn.stickem = function(options) {
    //Create a destroy method so that you can kill it and call it again.
    this.destroy = function() {
      this.each(function() {
        new Stickem(this, options).destroy();
      });
    };

    return this.each(function() {
      new Stickem(this, options).init();
    });
  };

})(jQuery, window , document);

/*!
 * hoverIntent r7 // 2013.03.11 // jQuery 1.9.1+
 * http://cherne.net/brian/resources/jquery.hoverIntent.html
 *
 * You may use hoverIntent under the terms of the MIT license.
 * Copyright 2007, 2013 Brian Cherne
 */
(function(e){e.fn.hoverIntent=function(t,n,r){var i={interval:100,sensitivity:7,timeout:0};if(typeof t==="object"){i=e.extend(i,t)}else if(e.isFunction(n)){i=e.extend(i,{over:t,out:n,selector:r})}else{i=e.extend(i,{over:t,out:t,selector:n})}var s,o,u,a;var f=function(e){s=e.pageX;o=e.pageY};var l=function(t,n){n.hoverIntent_t=clearTimeout(n.hoverIntent_t);if(Math.abs(u-s)+Math.abs(a-o)<i.sensitivity){e(n).off("mousemove.hoverIntent",f);n.hoverIntent_s=1;return i.over.apply(n,[t])}else{u=s;a=o;n.hoverIntent_t=setTimeout(function(){l(t,n)},i.interval)}};var c=function(e,t){t.hoverIntent_t=clearTimeout(t.hoverIntent_t);t.hoverIntent_s=0;return i.out.apply(t,[e])};var h=function(t){var n=jQuery.extend({},t);var r=this;if(r.hoverIntent_t){r.hoverIntent_t=clearTimeout(r.hoverIntent_t)}if(t.type=="mouseenter"){u=n.pageX;a=n.pageY;e(r).on("mousemove.hoverIntent",f);if(r.hoverIntent_s!=1){r.hoverIntent_t=setTimeout(function(){l(n,r)},i.interval)}}else{e(r).off("mousemove.hoverIntent",f);if(r.hoverIntent_s==1){r.hoverIntent_t=setTimeout(function(){c(n,r)},i.timeout)}}};return this.on({"mouseenter.hoverIntent":h,"mouseleave.hoverIntent":h},i.selector)}})(jQuery)

// moment.js
// version : 2.1.0
// author : Tim Wood
// license : MIT
// momentjs.com
!function(t){function e(t,e){return function(n){return u(t.call(this,n),e)}}function n(t,e){return function(n){return this.lang().ordinal(t.call(this,n),e)}}function s(){}function i(t){a(this,t)}function r(t){var e=t.years||t.year||t.y||0,n=t.months||t.month||t.M||0,s=t.weeks||t.week||t.w||0,i=t.days||t.day||t.d||0,r=t.hours||t.hour||t.h||0,a=t.minutes||t.minute||t.m||0,o=t.seconds||t.second||t.s||0,u=t.milliseconds||t.millisecond||t.ms||0;this._input=t,this._milliseconds=u+1e3*o+6e4*a+36e5*r,this._days=i+7*s,this._months=n+12*e,this._data={},this._bubble()}function a(t,e){for(var n in e)e.hasOwnProperty(n)&&(t[n]=e[n]);return t}function o(t){return 0>t?Math.ceil(t):Math.floor(t)}function u(t,e){for(var n=t+"";n.length<e;)n="0"+n;return n}function h(t,e,n,s){var i,r,a=e._milliseconds,o=e._days,u=e._months;a&&t._d.setTime(+t._d+a*n),(o||u)&&(i=t.minute(),r=t.hour()),o&&t.date(t.date()+o*n),u&&t.month(t.month()+u*n),a&&!s&&H.updateOffset(t),(o||u)&&(t.minute(i),t.hour(r))}function d(t){return"[object Array]"===Object.prototype.toString.call(t)}function c(t,e){var n,s=Math.min(t.length,e.length),i=Math.abs(t.length-e.length),r=0;for(n=0;s>n;n++)~~t[n]!==~~e[n]&&r++;return r+i}function f(t){return t?ie[t]||t.toLowerCase().replace(/(.)s$/,"$1"):t}function l(t,e){return e.abbr=t,x[t]||(x[t]=new s),x[t].set(e),x[t]}function _(t){if(!t)return H.fn._lang;if(!x[t]&&A)try{require("./lang/"+t)}catch(e){return H.fn._lang}return x[t]}function m(t){return t.match(/\[.*\]/)?t.replace(/^\[|\]$/g,""):t.replace(/\\/g,"")}function y(t){var e,n,s=t.match(E);for(e=0,n=s.length;n>e;e++)s[e]=ue[s[e]]?ue[s[e]]:m(s[e]);return function(i){var r="";for(e=0;n>e;e++)r+=s[e]instanceof Function?s[e].call(i,t):s[e];return r}}function M(t,e){function n(e){return t.lang().longDateFormat(e)||e}for(var s=5;s--&&N.test(e);)e=e.replace(N,n);return re[e]||(re[e]=y(e)),re[e](t)}function g(t,e){switch(t){case"DDDD":return V;case"YYYY":return X;case"YYYYY":return $;case"S":case"SS":case"SSS":case"DDD":return I;case"MMM":case"MMMM":case"dd":case"ddd":case"dddd":return R;case"a":case"A":return _(e._l)._meridiemParse;case"X":return B;case"Z":case"ZZ":return j;case"T":return q;case"MM":case"DD":case"YY":case"HH":case"hh":case"mm":case"ss":case"M":case"D":case"d":case"H":case"h":case"m":case"s":return J;default:return new RegExp(t.replace("\\",""))}}function p(t){var e=(j.exec(t)||[])[0],n=(e+"").match(ee)||["-",0,0],s=+(60*n[1])+~~n[2];return"+"===n[0]?-s:s}function D(t,e,n){var s,i=n._a;switch(t){case"M":case"MM":i[1]=null==e?0:~~e-1;break;case"MMM":case"MMMM":s=_(n._l).monthsParse(e),null!=s?i[1]=s:n._isValid=!1;break;case"D":case"DD":case"DDD":case"DDDD":null!=e&&(i[2]=~~e);break;case"YY":i[0]=~~e+(~~e>68?1900:2e3);break;case"YYYY":case"YYYYY":i[0]=~~e;break;case"a":case"A":n._isPm=_(n._l).isPM(e);break;case"H":case"HH":case"h":case"hh":i[3]=~~e;break;case"m":case"mm":i[4]=~~e;break;case"s":case"ss":i[5]=~~e;break;case"S":case"SS":case"SSS":i[6]=~~(1e3*("0."+e));break;case"X":n._d=new Date(1e3*parseFloat(e));break;case"Z":case"ZZ":n._useUTC=!0,n._tzm=p(e)}null==e&&(n._isValid=!1)}function Y(t){var e,n,s=[];if(!t._d){for(e=0;7>e;e++)t._a[e]=s[e]=null==t._a[e]?2===e?1:0:t._a[e];s[3]+=~~((t._tzm||0)/60),s[4]+=~~((t._tzm||0)%60),n=new Date(0),t._useUTC?(n.setUTCFullYear(s[0],s[1],s[2]),n.setUTCHours(s[3],s[4],s[5],s[6])):(n.setFullYear(s[0],s[1],s[2]),n.setHours(s[3],s[4],s[5],s[6])),t._d=n}}function w(t){var e,n,s=t._f.match(E),i=t._i;for(t._a=[],e=0;e<s.length;e++)n=(g(s[e],t).exec(i)||[])[0],n&&(i=i.slice(i.indexOf(n)+n.length)),ue[s[e]]&&D(s[e],n,t);i&&(t._il=i),t._isPm&&t._a[3]<12&&(t._a[3]+=12),t._isPm===!1&&12===t._a[3]&&(t._a[3]=0),Y(t)}function k(t){var e,n,s,r,o,u=99;for(r=0;r<t._f.length;r++)e=a({},t),e._f=t._f[r],w(e),n=new i(e),o=c(e._a,n.toArray()),n._il&&(o+=n._il.length),u>o&&(u=o,s=n);a(t,s)}function v(t){var e,n=t._i,s=K.exec(n);if(s){for(t._f="YYYY-MM-DD"+(s[2]||" "),e=0;4>e;e++)if(te[e][1].exec(n)){t._f+=te[e][0];break}j.exec(n)&&(t._f+=" Z"),w(t)}else t._d=new Date(n)}function T(e){var n=e._i,s=G.exec(n);n===t?e._d=new Date:s?e._d=new Date(+s[1]):"string"==typeof n?v(e):d(n)?(e._a=n.slice(0),Y(e)):e._d=n instanceof Date?new Date(+n):new Date(n)}function b(t,e,n,s,i){return i.relativeTime(e||1,!!n,t,s)}function S(t,e,n){var s=W(Math.abs(t)/1e3),i=W(s/60),r=W(i/60),a=W(r/24),o=W(a/365),u=45>s&&["s",s]||1===i&&["m"]||45>i&&["mm",i]||1===r&&["h"]||22>r&&["hh",r]||1===a&&["d"]||25>=a&&["dd",a]||45>=a&&["M"]||345>a&&["MM",W(a/30)]||1===o&&["y"]||["yy",o];return u[2]=e,u[3]=t>0,u[4]=n,b.apply({},u)}function F(t,e,n){var s,i=n-e,r=n-t.day();return r>i&&(r-=7),i-7>r&&(r+=7),s=H(t).add("d",r),{week:Math.ceil(s.dayOfYear()/7),year:s.year()}}function O(t){var e=t._i,n=t._f;return null===e||""===e?null:("string"==typeof e&&(t._i=e=_().preparse(e)),H.isMoment(e)?(t=a({},e),t._d=new Date(+e._d)):n?d(n)?k(t):w(t):T(t),new i(t))}function z(t,e){H.fn[t]=H.fn[t+"s"]=function(t){var n=this._isUTC?"UTC":"";return null!=t?(this._d["set"+n+e](t),H.updateOffset(this),this):this._d["get"+n+e]()}}function C(t){H.duration.fn[t]=function(){return this._data[t]}}function L(t,e){H.duration.fn["as"+t]=function(){return+this/e}}for(var H,P,U="2.1.0",W=Math.round,x={},A="undefined"!=typeof module&&module.exports,G=/^\/?Date\((\-?\d+)/i,Z=/(\-)?(\d*)?\.?(\d+)\:(\d+)\:(\d+)\.?(\d{3})?/,E=/(\[[^\[]*\])|(\\)?(Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|W[o|W]?|YYYYY|YYYY|YY|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|mm?|ss?|SS?S?|X|zz?|ZZ?|.)/g,N=/(\[[^\[]*\])|(\\)?(LT|LL?L?L?|l{1,4})/g,J=/\d\d?/,I=/\d{1,3}/,V=/\d{3}/,X=/\d{1,4}/,$=/[+\-]?\d{1,6}/,R=/[0-9]*['a-z\u00A0-\u05FF\u0700-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+|[\u0600-\u06FF\/]+(\s*?[\u0600-\u06FF]+){1,2}/i,j=/Z|[\+\-]\d\d:?\d\d/i,q=/T/i,B=/[\+\-]?\d+(\.\d{1,3})?/,K=/^\s*\d{4}-\d\d-\d\d((T| )(\d\d(:\d\d(:\d\d(\.\d\d?\d?)?)?)?)?([\+\-]\d\d:?\d\d)?)?/,Q="YYYY-MM-DDTHH:mm:ssZ",te=[["HH:mm:ss.S",/(T| )\d\d:\d\d:\d\d\.\d{1,3}/],["HH:mm:ss",/(T| )\d\d:\d\d:\d\d/],["HH:mm",/(T| )\d\d:\d\d/],["HH",/(T| )\d\d/]],ee=/([\+\-]|\d\d)/gi,ne="Date|Hours|Minutes|Seconds|Milliseconds".split("|"),se={Milliseconds:1,Seconds:1e3,Minutes:6e4,Hours:36e5,Days:864e5,Months:2592e6,Years:31536e6},ie={ms:"millisecond",s:"second",m:"minute",h:"hour",d:"day",w:"week",M:"month",y:"year"},re={},ae="DDD w W M D d".split(" "),oe="M D H h m s w W".split(" "),ue={M:function(){return this.month()+1},MMM:function(t){return this.lang().monthsShort(this,t)},MMMM:function(t){return this.lang().months(this,t)},D:function(){return this.date()},DDD:function(){return this.dayOfYear()},d:function(){return this.day()},dd:function(t){return this.lang().weekdaysMin(this,t)},ddd:function(t){return this.lang().weekdaysShort(this,t)},dddd:function(t){return this.lang().weekdays(this,t)},w:function(){return this.week()},W:function(){return this.isoWeek()},YY:function(){return u(this.year()%100,2)},YYYY:function(){return u(this.year(),4)},YYYYY:function(){return u(this.year(),5)},gg:function(){return u(this.weekYear()%100,2)},gggg:function(){return this.weekYear()},ggggg:function(){return u(this.weekYear(),5)},GG:function(){return u(this.isoWeekYear()%100,2)},GGGG:function(){return this.isoWeekYear()},GGGGG:function(){return u(this.isoWeekYear(),5)},e:function(){return this.weekday()},E:function(){return this.isoWeekday()},a:function(){return this.lang().meridiem(this.hours(),this.minutes(),!0)},A:function(){return this.lang().meridiem(this.hours(),this.minutes(),!1)},H:function(){return this.hours()},h:function(){return this.hours()%12||12},m:function(){return this.minutes()},s:function(){return this.seconds()},S:function(){return~~(this.milliseconds()/100)},SS:function(){return u(~~(this.milliseconds()/10),2)},SSS:function(){return u(this.milliseconds(),3)},Z:function(){var t=-this.zone(),e="+";return 0>t&&(t=-t,e="-"),e+u(~~(t/60),2)+":"+u(~~t%60,2)},ZZ:function(){var t=-this.zone(),e="+";return 0>t&&(t=-t,e="-"),e+u(~~(10*t/6),4)},z:function(){return this.zoneAbbr()},zz:function(){return this.zoneName()},X:function(){return this.unix()}};ae.length;)P=ae.pop(),ue[P+"o"]=n(ue[P],P);for(;oe.length;)P=oe.pop(),ue[P+P]=e(ue[P],2);for(ue.DDDD=e(ue.DDD,3),s.prototype={set:function(t){var e,n;for(n in t)e=t[n],"function"==typeof e?this[n]=e:this["_"+n]=e},_months:"January_February_March_April_May_June_July_August_September_October_November_December".split("_"),months:function(t){return this._months[t.month()]},_monthsShort:"Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec".split("_"),monthsShort:function(t){return this._monthsShort[t.month()]},monthsParse:function(t){var e,n,s;for(this._monthsParse||(this._monthsParse=[]),e=0;12>e;e++)if(this._monthsParse[e]||(n=H([2e3,e]),s="^"+this.months(n,"")+"|^"+this.monthsShort(n,""),this._monthsParse[e]=new RegExp(s.replace(".",""),"i")),this._monthsParse[e].test(t))return e},_weekdays:"Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday".split("_"),weekdays:function(t){return this._weekdays[t.day()]},_weekdaysShort:"Sun_Mon_Tue_Wed_Thu_Fri_Sat".split("_"),weekdaysShort:function(t){return this._weekdaysShort[t.day()]},_weekdaysMin:"Su_Mo_Tu_We_Th_Fr_Sa".split("_"),weekdaysMin:function(t){return this._weekdaysMin[t.day()]},weekdaysParse:function(t){var e,n,s;for(this._weekdaysParse||(this._weekdaysParse=[]),e=0;7>e;e++)if(this._weekdaysParse[e]||(n=H([2e3,1]).day(e),s="^"+this.weekdays(n,"")+"|^"+this.weekdaysShort(n,"")+"|^"+this.weekdaysMin(n,""),this._weekdaysParse[e]=new RegExp(s.replace(".",""),"i")),this._weekdaysParse[e].test(t))return e},_longDateFormat:{LT:"h:mm A",L:"MM/DD/YYYY",LL:"MMMM D YYYY",LLL:"MMMM D YYYY LT",LLLL:"dddd, MMMM D YYYY LT"},longDateFormat:function(t){var e=this._longDateFormat[t];return!e&&this._longDateFormat[t.toUpperCase()]&&(e=this._longDateFormat[t.toUpperCase()].replace(/MMMM|MM|DD|dddd/g,function(t){return t.slice(1)}),this._longDateFormat[t]=e),e},isPM:function(t){return"p"===(t+"").toLowerCase()[0]},_meridiemParse:/[ap]\.?m?\.?/i,meridiem:function(t,e,n){return t>11?n?"pm":"PM":n?"am":"AM"},_calendar:{sameDay:"[Today at] LT",nextDay:"[Tomorrow at] LT",nextWeek:"dddd [at] LT",lastDay:"[Yesterday at] LT",lastWeek:"[Last] dddd [at] LT",sameElse:"L"},calendar:function(t,e){var n=this._calendar[t];return"function"==typeof n?n.apply(e):n},_relativeTime:{future:"in %s",past:"%s ago",s:"a few seconds",m:"a minute",mm:"%d minutes",h:"an hour",hh:"%d hours",d:"a day",dd:"%d days",M:"a month",MM:"%d months",y:"a year",yy:"%d years"},relativeTime:function(t,e,n,s){var i=this._relativeTime[n];return"function"==typeof i?i(t,e,n,s):i.replace(/%d/i,t)},pastFuture:function(t,e){var n=this._relativeTime[t>0?"future":"past"];return"function"==typeof n?n(e):n.replace(/%s/i,e)},ordinal:function(t){return this._ordinal.replace("%d",t)},_ordinal:"%d",preparse:function(t){return t},postformat:function(t){return t},week:function(t){return F(t,this._week.dow,this._week.doy).week},_week:{dow:0,doy:6}},H=function(t,e,n){return O({_i:t,_f:e,_l:n,_isUTC:!1})},H.utc=function(t,e,n){return O({_useUTC:!0,_isUTC:!0,_l:n,_i:t,_f:e})},H.unix=function(t){return H(1e3*t)},H.duration=function(t,e){var n,s,i=H.isDuration(t),a="number"==typeof t,o=i?t._input:a?{}:t,u=Z.exec(t);return a?e?o[e]=t:o.milliseconds=t:u&&(n="-"===u[1]?-1:1,o={y:0,d:~~u[2]*n,h:~~u[3]*n,m:~~u[4]*n,s:~~u[5]*n,ms:~~u[6]*n}),s=new r(o),i&&t.hasOwnProperty("_lang")&&(s._lang=t._lang),s},H.version=U,H.defaultFormat=Q,H.updateOffset=function(){},H.lang=function(t,e){return t?(e?l(t,e):x[t]||_(t),H.duration.fn._lang=H.fn._lang=_(t),void 0):H.fn._lang._abbr},H.langData=function(t){return t&&t._lang&&t._lang._abbr&&(t=t._lang._abbr),_(t)},H.isMoment=function(t){return t instanceof i},H.isDuration=function(t){return t instanceof r},H.fn=i.prototype={clone:function(){return H(this)},valueOf:function(){return+this._d+6e4*(this._offset||0)},unix:function(){return Math.floor(+this/1e3)},toString:function(){return this.format("ddd MMM DD YYYY HH:mm:ss [GMT]ZZ")},toDate:function(){return this._offset?new Date(+this):this._d},toISOString:function(){return M(H(this).utc(),"YYYY-MM-DD[T]HH:mm:ss.SSS[Z]")},toArray:function(){var t=this;return[t.year(),t.month(),t.date(),t.hours(),t.minutes(),t.seconds(),t.milliseconds()]},isValid:function(){return null==this._isValid&&(this._isValid=this._a?!c(this._a,(this._isUTC?H.utc(this._a):H(this._a)).toArray()):!isNaN(this._d.getTime())),!!this._isValid},utc:function(){return this.zone(0)},local:function(){return this.zone(0),this._isUTC=!1,this},format:function(t){var e=M(this,t||H.defaultFormat);return this.lang().postformat(e)},add:function(t,e){var n;return n="string"==typeof t?H.duration(+e,t):H.duration(t,e),h(this,n,1),this},subtract:function(t,e){var n;return n="string"==typeof t?H.duration(+e,t):H.duration(t,e),h(this,n,-1),this},diff:function(t,e,n){var s,i,r=this._isUTC?H(t).zone(this._offset||0):H(t).local(),a=6e4*(this.zone()-r.zone());return e=f(e),"year"===e||"month"===e?(s=432e5*(this.daysInMonth()+r.daysInMonth()),i=12*(this.year()-r.year())+(this.month()-r.month()),i+=(this-H(this).startOf("month")-(r-H(r).startOf("month")))/s,i-=6e4*(this.zone()-H(this).startOf("month").zone()-(r.zone()-H(r).startOf("month").zone()))/s,"year"===e&&(i/=12)):(s=this-r,i="second"===e?s/1e3:"minute"===e?s/6e4:"hour"===e?s/36e5:"day"===e?(s-a)/864e5:"week"===e?(s-a)/6048e5:s),n?i:o(i)},from:function(t,e){return H.duration(this.diff(t)).lang(this.lang()._abbr).humanize(!e)},fromNow:function(t){return this.from(H(),t)},calendar:function(){var t=this.diff(H().startOf("day"),"days",!0),e=-6>t?"sameElse":-1>t?"lastWeek":0>t?"lastDay":1>t?"sameDay":2>t?"nextDay":7>t?"nextWeek":"sameElse";return this.format(this.lang().calendar(e,this))},isLeapYear:function(){var t=this.year();return 0===t%4&&0!==t%100||0===t%400},isDST:function(){return this.zone()<this.clone().month(0).zone()||this.zone()<this.clone().month(5).zone()},day:function(t){var e=this._isUTC?this._d.getUTCDay():this._d.getDay();return null!=t?"string"==typeof t&&(t=this.lang().weekdaysParse(t),"number"!=typeof t)?this:this.add({d:t-e}):e},month:function(t){var e,n=this._isUTC?"UTC":"";return null!=t?"string"==typeof t&&(t=this.lang().monthsParse(t),"number"!=typeof t)?this:(e=this.date(),this.date(1),this._d["set"+n+"Month"](t),this.date(Math.min(e,this.daysInMonth())),H.updateOffset(this),this):this._d["get"+n+"Month"]()},startOf:function(t){switch(t=f(t)){case"year":this.month(0);case"month":this.date(1);case"week":case"day":this.hours(0);case"hour":this.minutes(0);case"minute":this.seconds(0);case"second":this.milliseconds(0)}return"week"===t&&this.weekday(0),this},endOf:function(t){return this.startOf(t).add(t,1).subtract("ms",1)},isAfter:function(t,e){return e="undefined"!=typeof e?e:"millisecond",+this.clone().startOf(e)>+H(t).startOf(e)},isBefore:function(t,e){return e="undefined"!=typeof e?e:"millisecond",+this.clone().startOf(e)<+H(t).startOf(e)},isSame:function(t,e){return e="undefined"!=typeof e?e:"millisecond",+this.clone().startOf(e)===+H(t).startOf(e)},min:function(t){return t=H.apply(null,arguments),this>t?this:t},max:function(t){return t=H.apply(null,arguments),t>this?this:t},zone:function(t){var e=this._offset||0;return null==t?this._isUTC?e:this._d.getTimezoneOffset():("string"==typeof t&&(t=p(t)),Math.abs(t)<16&&(t=60*t),this._offset=t,this._isUTC=!0,e!==t&&h(this,H.duration(e-t,"m"),1,!0),this)},zoneAbbr:function(){return this._isUTC?"UTC":""},zoneName:function(){return this._isUTC?"Coordinated Universal Time":""},daysInMonth:function(){return H.utc([this.year(),this.month()+1,0]).date()},dayOfYear:function(t){var e=W((H(this).startOf("day")-H(this).startOf("year"))/864e5)+1;return null==t?e:this.add("d",t-e)},weekYear:function(t){var e=F(this,this.lang()._week.dow,this.lang()._week.doy).year;return null==t?e:this.add("y",t-e)},isoWeekYear:function(t){var e=F(this,1,4).year;return null==t?e:this.add("y",t-e)},week:function(t){var e=this.lang().week(this);return null==t?e:this.add("d",7*(t-e))},isoWeek:function(t){var e=F(this,1,4).week;return null==t?e:this.add("d",7*(t-e))},weekday:function(t){var e=(this._d.getDay()+7-this.lang()._week.dow)%7;return null==t?e:this.add("d",t-e)},isoWeekday:function(t){return null==t?this.day()||7:this.day(this.day()%7?t:t-7)},lang:function(e){return e===t?this._lang:(this._lang=_(e),this)}},P=0;P<ne.length;P++)z(ne[P].toLowerCase().replace(/s$/,""),ne[P]);z("year","FullYear"),H.fn.days=H.fn.day,H.fn.months=H.fn.month,H.fn.weeks=H.fn.week,H.fn.isoWeeks=H.fn.isoWeek,H.fn.toJSON=H.fn.toISOString,H.duration.fn=r.prototype={_bubble:function(){var t,e,n,s,i=this._milliseconds,r=this._days,a=this._months,u=this._data;u.milliseconds=i%1e3,t=o(i/1e3),u.seconds=t%60,e=o(t/60),u.minutes=e%60,n=o(e/60),u.hours=n%24,r+=o(n/24),u.days=r%30,a+=o(r/30),u.months=a%12,s=o(a/12),u.years=s},weeks:function(){return o(this.days()/7)},valueOf:function(){return this._milliseconds+864e5*this._days+2592e6*(this._months%12)+31536e6*~~(this._months/12)},humanize:function(t){var e=+this,n=S(e,!t,this.lang());return t&&(n=this.lang().pastFuture(e,n)),this.lang().postformat(n)},add:function(t,e){var n=H.duration(t,e);return this._milliseconds+=n._milliseconds,this._days+=n._days,this._months+=n._months,this._bubble(),this},subtract:function(t,e){var n=H.duration(t,e);return this._milliseconds-=n._milliseconds,this._days-=n._days,this._months-=n._months,this._bubble(),this},get:function(t){return t=f(t),this[t.toLowerCase()+"s"]()},as:function(t){return t=f(t),this["as"+t.charAt(0).toUpperCase()+t.slice(1)+"s"]()},lang:H.fn.lang};for(P in se)se.hasOwnProperty(P)&&(L(P,se[P]),C(P.toLowerCase()));L("Weeks",6048e5),H.duration.fn.asMonths=function(){return(+this-31536e6*this.years())/2592e6+12*this.years()},H.lang("en",{ordinal:function(t){var e=t%10,n=1===~~(t%100/10)?"th":1===e?"st":2===e?"nd":3===e?"rd":"th";return t+n}}),A&&(module.exports=H),"undefined"==typeof ender&&(this.moment=H),"function"==typeof define&&define.amd&&define("moment",[],function(){return H})}.call(this);


// moment.js language configuration
// language : vietnamese (vn)
// author : Bang Nguyen : https://github.com/bangnk

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define(['moment'], factory); // AMD
    } else if (typeof exports === 'object') {
        module.exports = factory(require('../moment')); // Node
    } else {
        factory(window.moment); // Browser global
    }
}(function (moment) {
    return moment.lang('vn', {
        months : "tháng 1_tháng 2_tháng 3_tháng 4_tháng 5_tháng 6_tháng 7_tháng 8_tháng 9_tháng 10_tháng 11_tháng 12".split("_"),
        monthsShort : "Th01_Th02_Th03_Th04_Th05_Th06_Th07_Th08_Th09_Th10_Th11_Th12".split("_"),
        weekdays : "chủ nhật_thứ hai_thứ ba_thứ tư_thứ năm_thứ sáu_thứ bảy".split("_"),
        weekdaysShort : "CN_T2_T3_T4_T5_T6_T7".split("_"),
        weekdaysMin : "CN_T2_T3_T4_T5_T6_T7".split("_"),
        longDateFormat : {
            LT : "HH:mm",
            L : "DD/MM/YYYY",
            LL : "D MMMM [năm] YYYY",
            LLL : "D MMMM [năm] YYYY LT",
            LLLL : "dddd, D MMMM [năm] YYYY LT",
            l : "DD/M/YYYY",
            ll : "D MMM YYYY",
            lll : "D MMM YYYY LT",
            llll : "ddd, D MMM YYYY LT"
        },
        calendar : {
            sameDay: "[Hôm nay lúc] LT",
            nextDay: '[Ngày mai lúc] LT',
            nextWeek: 'dddd [tuần tới lúc] LT',
            lastDay: '[Hôm qua lúc] LT',
            lastWeek: 'dddd [tuần rồi lúc] LT',
            sameElse: 'L'
        },
        relativeTime : {
            future : "%s tới",
            past : "%s trước",
            s : "vài giây",
            m : "một phút",
            mm : "%d phút",
            h : "một giờ",
            hh : "%d giờ",
            d : "một ngày",
            dd : "%d ngày",
            M : "một tháng",
            MM : "%d tháng",
            y : "một năm",
            yy : "%d năm"
        },
        ordinal : function (number) {
            return number;
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));