"use strict";


// Load configuration from .env
require('dotenv').config();


const path = require('path');
const root = path.resolve(__dirname, '../../');

const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const IgnoreEmitPlugin = require('ignore-emit-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');


function assets_name(resourcePath, resourceQuery) {
  if (!String(resourcePath).startsWith(root)) {
    throw Error('invalid resource path: ' + resourcePath);
  }
  
  let rel = path.relative(root, resourcePath);
  let dir = path.dirname(rel).replace(/^assets\//, '');
  
  return `${dir}/[name]-[contenthash].[ext]`;
}


module.exports = (_env, argv) => {
  const env = _env || {};
  const Env = process.env;
  const production = (env.hasOwnProperty('production') && env.production === true);
  
  let config = {
    mode: production ? 'production' : 'development',
    context: root,
    
    entry: {
      "index": path.join(root, "assets/javascripts/main.js"),
      
      "main":           path.join(root, "assets/stylesheets/main.css"),
      "blocks-editor":  path.join(root, "assets/stylesheets/blocks-editor.css"),
      "classic-editor": path.join(root, "assets/stylesheets/classic-editor.css")
    },
    
    devtool: 'source-map',
    output: {
      path: path.resolve(root, 'dist'),
      publicPath: `${Env.THEME_PUBLIC_PATH}dist/`,
      filename: `javascripts/[name].js`
    },
    
    plugins: [
      new CleanWebpackPlugin()
    ],
    module: { rules: [] },
    stats: 'minimal',
  };
  
  if (!production) {
    config.devServer = {
      stats: 'errors-only',
      host: Env.WEBPACK_DEV_SERVER__HOST,
      port: Env.WEBPACK_DEV_SERVER__PORT,
      index: '',
      proxy: {}
    };
  
    config.devServer.proxy[`!${config.output.publicPath}**`] = {
      target: Env.WEBPACK_DEV_SERVER__TARGET
    };
  
    config.output.publicPath = `http://${Env.WEBPACK_DEV_SERVER__HOST}:${Env.WEBPACK_DEV_SERVER__PORT}${config.output.publicPath}`;
    config.devServer.publicPath = config.output.publicPath;
  }
  
  if (production) {
    config.devtool = false;
    config.optimization = {
      minimize: true,
      minimizer: [new TerserPlugin()],
    };
  }
  
  /* --- CSS support --- */
  config.plugins.push(new MiniCssExtractPlugin({
    filename: `stylesheets/[name].css`
  }));
  config.plugins.push(new IgnoreEmitPlugin(['main.js', /-editor\.js/]));
  
  let postCssOptions = {
    plugins: [
      'autoprefixer',
      'postcss-custom-media'
    ]
  };
  if (production) {
    postCssOptions.plugins.push('cssnano');
  }
  
  config.module.rules.push({
    test: /\.css$/,
    use: [
      {
        loader: MiniCssExtractPlugin.loader,
        options: {
          esModule: false
        }
      },
      // css-loader will resolve import rules and url()s
      {
        loader: 'css-loader',
        options: {
          modules: false,
          esModule: false,
          // Will apply postcss-loader to imported files
          importLoaders: 1,
        }
      },
      {
        loader: 'postcss-loader',
        options: {
          postcssOptions: postCssOptions
        },
      },
    ]
  });
  
  /* --- Images support --- */
  config.module.rules.push({
    test: /\.(png|svg|jpe?g|gif|ico)$/,
    use: [
      {
        loader: 'file-loader',
        options: {
          esModule: false,
          name: (resourcePath, resourceQuery) => assets_name(resourcePath, resourceQuery)
        }
      },
      // Optimize images
      {
        loader: 'image-webpack-loader'
      }
    ]
  });
  
  /* --- Fonts support --- */
  config.module.rules.push({
    test: /\.(eot|ttf|woff|woff2)$/,
    use: [
      {
        loader: 'file-loader',
        options: {
          esModule: false,
          name: (resourcePath, resourceQuery) => assets_name(resourcePath, resourceQuery)
        }
      }
    ]
  });
  
  return config;
};
