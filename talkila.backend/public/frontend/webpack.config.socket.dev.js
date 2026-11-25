const path = require('path')

const BundleAnalyzerPlugin =
  require('webpack-bundle-analyzer').BundleAnalyzerPlugin



module.exports = {

  mode: 'development',
  entry: {
    bundle: path.resolve(__dirname, './socket.js'),
  },
  output: {
    path: path.resolve(__dirname, './assets/js/talk'),
    filename: 'socketBundle.js'
  },
  devtool: 'source-map',

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
