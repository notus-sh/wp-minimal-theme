var mt = mt || {};

// Add a class to the body for when touch is enabled for browsers that don't support media queries
// for interaction media features. Adapted from <https://codepen.io/Ferie/pen/vQOMmO>.
mt.touchEnabled = {
  
  init: function() {
    var matchMedia = function() {
      // Include the 'heartz' as a way to have a non-matching MQ to help terminate the join. See <https://git.io/vznFH>.
      var prefixes = ['-webkit-', '-moz-', '-o-', '-ms-'];
      var query = ['(', prefixes.join('touch-enabled),('), 'heartz', ')'].join('');
      return window.matchMedia && window.matchMedia(query).matches;
    };
    
    if (('ontouchstart' in window) || (window.DocumentTouch && document instanceof window.DocumentTouch) || matchMedia()) {
      document.body.classList.add('touch-enabled');
    }
  }
}; // mt.touchEnabled

/*	-----------------------------------------------------------------------------------------------
	Intrinsic Ratio Embeds
--------------------------------------------------------------------------------------------------- */

mt.intrinsicRatioVideos = {
  
  init: function() {
    this.makeFit();
    
    window.addEventListener('resize', function() {
      this.makeFit();
    }.bind(this));
  },
  
  makeFit: function() {
    document.querySelectorAll('iframe, object, video').forEach(function(video) {
      var ratio, iTargetWidth,
        container = video.parentNode;
      
      // Skip videos we want to ignore.
      if (video.classList.contains('intrinsic-ignore') || video.parentNode.classList.contains('intrinsic-ignore')) {
        return true;
      }
      
      if (!video.dataset.origwidth) {
        // Get the video element proportions.
        video.setAttribute('data-origwidth', video.width);
        video.setAttribute('data-origheight', video.height);
      }
      
      iTargetWidth = container.offsetWidth;
      
      // Get ratio from proportions.
      ratio = iTargetWidth / video.dataset.origwidth;
      
      // Scale based on ratio, thus retaining proportions.
      video.style.width = iTargetWidth + 'px';
      video.style.height = (video.dataset.origheight * ratio) + 'px';
    });
  }
  
}; // mt.instrinsicRatioVideos

/**
 * Is the DOM ready?
 *
 * This implementation is coming from https://gomakethings.com/a-native-javascript-equivalent-of-jquerys-ready-method/
 *
 * @param {Function} fn Callback function to run.
 */
function mtDomReady(fn) {
  if (typeof fn !== 'function') {
    return;
  }
  
  if (document.readyState === 'interactive' || document.readyState === 'complete') {
    return fn();
  }
  
  document.addEventListener('DOMContentLoaded', fn, false);
}

mtDomReady(function() {
  mt.intrinsicRatioVideos.init(); // Retain aspect ratio of videos on window resize.
  mt.touchEnabled.init();         // Add class to body if device is touch-enabled.
});
