"use strict";

/**
 * Initialize embeds proportionel resizing on resize
 *
 * @param {Window}    window
 * @param {Document}  document
 */
function init(window, document) {
  resize(document);
  
  window.addEventListener('resize', function() {
    resize(document);
  });
}

function resize(document) {
  document.querySelectorAll('iframe, object, video').forEach(function(embed) {
    let container = embed.parentNode;
    
    // Skip videos we want to ignore.
    if (embed.classList.contains('intrinsic-ignore') || container.classList.contains('intrinsic-ignore')) {
      return true;
    }
    
    if (!embed.dataset.origwidth) {
      // Get the embed element proportions.
      embed.setAttribute('data-origwidth', embed.width);
      embed.setAttribute('data-origheight', embed.height);
    }
    
    let width = container.offsetWidth;
    let ratio = width / embed.dataset.origwidth;
    
    embed.style.width = width + 'px';
    embed.style.height = (embed.dataset.origheight * ratio) + 'px';
  });
}

export default { init };
