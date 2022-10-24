const path = require('path');

module.exports = {
  entry: './src/dist/js/index.js',
  output: {
    path: path.resolve(__dirname, 'src/dist/app'),
    filename: 'sandbox.js',
  },
   watch:true,
  module: {
    rules: [
      {
        test: /\.m?js$/,
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env']
          }
        }
      }
    ],
  }
};