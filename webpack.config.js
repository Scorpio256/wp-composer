const path = require('path');

// CSS extraction and minification
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

// Clean out build dir in-between builds
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

require('dotenv').config();
const themeName = process.env.WP_DEFAULT_THEME;
const appEnv = process.env.WP_ENVIRONMENT_TYPE;

console.log(themeName);
module.exports = [
  {
    entry: {
      'main': [
        './themes/' + themeName + '/src/js/main.js',
        './themes/' + themeName + '/src/css/main.scss'
      ]
    },
    output: {
      filename: './themes/' + themeName + '/assets/scripts/[name].min.js',
      path: path.resolve(__dirname)
    },
    module: {
      rules: [
        // JS babelization
        {
          test: /\.(js|jsx)$/,
          exclude: /node_modules/,
          loader: 'babel-loader'
        },
        // Sass compilation with CSS source maps enabled
        {
          test: /\.(sass|scss)$/,
          use: [
            MiniCssExtractPlugin.loader,
            {
              loader: 'css-loader',
              options: {
                sourceMap: true
              }
            },
            {
              loader: 'sass-loader',
              options: {
                sourceMap: true,
                sassOptions: {
                  includePaths: [path.resolve(__dirname, 'node_modules')]
                },
              }
            }
          ]
        },
        // Loader for webfonts (only required if loading custom fonts)
        {
          test: /\.(woff|woff2|eot|ttf|otf)$/,
          type: 'asset/resource',
          generator: {
            filename: './themes/' + themeName + '/assets/fonts/[name][ext]',
          }
        },
        // Loader for images and icons (only required if CSS references image files)
        {
          test: /\.(png|jpg|gif)$/,
          type: 'asset/resource',
          generator: {
            filename: './themes/' + themeName + '/assets/images/[name][ext]',
          }
        },
      ]
    },
    plugins: [
      // Clear out build directories on each build
      new CleanWebpackPlugin({
        cleanOnceBeforeBuildPatterns: [
          './themes/' + themeName + '/assets/scripts/*',
          './themes/' + themeName + '/assets/styles/*'
        ]
      }),
      // CSS extraction into a dedicated file
      new MiniCssExtractPlugin({
        filename: './themes/' + themeName + '/assets/styles/main.min.css'
      }),
    ],
    optimization: {
      // Minification - only performed when mode = production
      minimizer: [
        // JS minification - special syntax enabling Webpack 5 default terser-webpack-plugin
        `...`,
        // CSS minification
        new CssMinimizerPlugin(),
      ]
    },
    devtool: 'source-map', // Enable source maps for easier debugging
  }
];
