const path = require('path')

const BundleAnalyzerPlugin =
  require('webpack-bundle-analyzer').BundleAnalyzerPlugin
  const TerserPlugin = require("terser-webpack-plugin");


module.exports = {

  mode: 'production',
  entry: {
    bundle: path.resolve(__dirname, './socket.js'),
  },
  optimization: {
    minimize: true,
    minimizer: [new TerserPlugin()],
  },
  output: {
    path: path.resolve(__dirname, './assets/js/talk'),
    filename: 'socketBundle.js'
  },
  /* devtool: 'source-map', */

  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/
      }
    ],
  },
  plugins: [
    new BundleAnalyzerPlugin(),
  ],
}
