// import moment from 'moment';
// // import * as _ from 'underscore';
// import clndr from 'clndr';

(function ($, root, undefined) {

	$(function () {

		'use strict';

    $('a#prenav-toggle').on('click', function(){
      $('.mobile-nav').slideToggle();
    });

		$('.front-page_slider').bxSlider({
    mode: 'fade',
    captions: false,
		controls: false,
		pager:false,
		speed: 1000,
		auto: true
  });


	});

})(jQuery, this);
