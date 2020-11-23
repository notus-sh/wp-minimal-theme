"use strict";

/**
 * Is the DOM ready?
 *
 * This implementation comes from https://gomakethings.com/a-native-javascript-equivalent-of-jquerys-ready-method/
 *
 * @param {Document} document Document
 * @param {Function} fn       Callback function to run
 */
function domReady(document, fn) {
  if (typeof fn !== 'function') {
    return;
  }
  
  if (document.readyState === 'interactive' || document.readyState === 'complete') {
    return fn();
  }
  
  document.addEventListener('DOMContentLoaded', fn, false);
}

export { domReady as default };
