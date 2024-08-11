const path = require('path');

// css extraction and minification
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

// clean out build dir in-between builds
const {CleanWebpackPlugin} = require('clean-webpack-plugin');

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
      filename: appEnv==='Localhost'?'./themes/' + themeName + '/assets/scripts/[name].min.local.js':'./themes/' + themeName + '/assets/scripts/[name].min.[fullhash].js',
      path: path.resolve(__dirname)
    },
    module: {
      rules: [
        // js babelization
        {
          test: /\.(js|jsx)$/,
          exclude: /node_modules/,
          loader: 'babel-loader'
        },
        // sass compilation
        {
          test: /\.(sass|scss)$/,
          use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader']
        },
        // loader for webfonts (only required if loading custom fonts)
        {
          test: /\.(woff|woff2|eot|ttf|otf)$/,
          type: 'asset/resource',
          generator: {
            filename: './themes/' + themeName + '/assets/fonts/[name][ext]',
          }
        },
        // loader for images and icons (only required if css references image files)
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
      // clear out build directories on each build
      new CleanWebpackPlugin({
        cleanOnceBeforeBuildPatterns: [
          './themes/' + themeName + '/assets/scripts/*',
          './themes/' + themeName + '/assets/styles/*'
        ]
      }),
      // css extraction into dedicated file
      new MiniCssExtractPlugin({
        filename: appEnv==='Localhost'?'./themes/' + themeName + '/assets/styles/main.min.local.css':'./themes/' + themeName + '/assets/styles/main.min.[fullhash].css'
      }),
    ],
    optimization: {
      // minification - only performed when mode = production
      minimizer: [
        // js minification - special syntax enabling webpack 5 default terser-webpack-plugin
        `...`,
        // css minification
        new CssMinimizerPlugin(),
      ]
    },
  }
];
