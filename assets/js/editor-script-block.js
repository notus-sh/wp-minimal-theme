/* global wp */
wp.domReady(function() {
  /**
   * Remove unused block types
   */
  [
    // Some block types can be used to circumvent further restrictions
    'core/table',
    'core/classic',
    'core/html',
    
    // Some block types are just useless when you don't do full pages editing
    'core/columns',
    'core/text-columns',
    'core/spacer',
    'core/separator',
    // ... as almost all widgets.
    'core/archives',
    'core/calendar',
    'core/categories',
    'core/tag-cloud',
    'core/latest-posts',
    'core/latest-comments',
    'core/search',
    'core/social-links',
    'core/social-link',
    'core/widget-area',
    'core/legacy-widget',
    'core/navigation',
    'core/navigation-link',
    'core/rss',
    
    // Disable some WordPress specifics
    'core/more',    // Use excerpt instead
    'core/nextpage' // Don't paginate content internally
    
  ].forEach(function(type) {
    wp.blocks.unregisterBlockType(type);
  })
  
  wp.blocks.getBlockTypes().forEach(function(type) {
    // Remove support for custom CSS classes and spacings on block container
    type.supports.customClassName = false;
    type.supports.padding = false;
    
    // Remove font-size and line-height UI controls
    type.supports.fontSize = false;
    type.supports.lineHeight = false;
    
    // Accepts anchors only to titles
    type.supports.anchor = (type.name === 'core/heading');
    
    // Remove colors UI controls
    type.supports.color = {
      background: false,
      gradient: false,
      text: false
    };
    
    // Remove all default block styles
    type.styles.forEach(function(style) {
      wp.blocks.unregisterBlockStyle(type.name, style.name);
    });
  });
});
