# WordPress Minimal Theme

Minimal theme for WordPress 5.0+ with blocks support.

Originally based on the official TwentyTwenty WordPress theme, it's an opinionated base for any new WordPress project where developpers and designers want to keep control over their layout.

* It does not support widgets.
* It does not support theme customizer.
* It does not provide any custom action/filter for child themes to hook into. 
* It does not support `.aligncenter`, `.alignleft` or `.alignright`.
* It may support blocks settings as custom colors, gradients or font sizes but has not been built with them in mind.

## What will I get?

* Clean and modern PHP code: PSR-12 coding standards and PSR-4 classes autoloading.
* Simple templates to edit.
* Minimal but extensible JavaScript and styles, with support for Guttenberg blocks.
* Assets building with webpack, terser and postcss (and a working live preview with webpack-dev-server)

## How can I use it?

1. Copy these sources to your WordPress themes directory.
2. Install dependencies (with `npm` or `yarn`).
3. Copy `.env.example` as `.env` and configure webpack.
4. Happy hacking!
