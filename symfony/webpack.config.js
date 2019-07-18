const webpack = require('webpack');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const path = require('path');

const plugins = [
  new webpack.ProvidePlugin({
    $: 'jquery',
    jQuery: 'jquery',
  }),
];

module.exports = {
  entry: [
    './www/src/index.js',
  ],
  module: {
    loaders: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        loaders: ['babel'],
      }
    ],
  },
  resolve: {
    extensions: ['', '.js', '.es6'],
  },
  output: {
    path: path.join(__dirname, 'build'),
    filename: 'js/index.min.js',
  },
  externals: {
    foundation: 'Foundation'
  },
  plugins,
};
