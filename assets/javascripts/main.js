/** global window, document */
"use strict";

import domReady from "./lib/dom-ready";
import embeds from "./lib/blocks/embeds";

domReady(document, function() {
  
  // Retain aspect ratio of videos on window resize.
  embeds.init(window, document);
  
});
