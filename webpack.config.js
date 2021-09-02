/**
 * As our first step, we'll pull in the user's webpack.mix.js
 * file. Based on what the user requests in that file,
 * a generic config object will be constructed for us.
 */
let mix = require('../src/index');
//const mix = require('laravel-mix');
var dotenv = require('dotenv').config('./.env');
let ComponentFactory = require('../src/components/ComponentFactory');

new ComponentFactory().installAll();

require(Mix.paths.mix());

/**
 * Just in case the user needs to hook into this point
 * in the build process, we'll make an announcement.
 */

Mix.dispatch('init', Mix);
const mix2 = require('laravel-mix');

mix2.js('resources/js/app.js', 'public/js').sourceMaps()
   .sass('resources/sass/app.scss', 'public/css');
/**
 * Now that we know which build tasks are required by the
 * user, we can dynamically create a configuration object
 * for Webpack. And that's all there is to it. Simple!
 */



let WebpackConfig = require('../src/builder/WebpackConfig');

module.exports = {
  port: process.env.PORT,
  mode: 'production',
  entry: 'index',
  output: {
     path: path.join(__dirname, 'scripts'),
     filename: 'bundle.js'
   },

  module: {
    loaders: [
      { test: /\.json$/, loader: 'json-loader' }
    ],
    rules: [
      // ... other rules omitted
      {
        test: /\.css$/,
        use: [
          'vue-style-loader',
          {
            loader: 'css-loader',
            options: {
              // enable CSS Modules
              modules: true,
              // customize generated class names
              localIdentName: '[local]_[hash:base64:8]'
            }
          }
        ]
      }
    ]
  },
  resolve: {
    extensions: ['', '.webpack.js', '.web.js', '.js']
  },
  externals: {
    puppeteer: 'require("puppeteer")',
    fs: 'require("fs")',

  },
  node: {
    console: 'empty',
    fs: 'empty',
    net: 'empty',
    tls: 'empty'
  }
}