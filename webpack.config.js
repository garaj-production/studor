const ExtractTextPlugin = require('extract-text-webpack-plugin');
const path = require('path');

const src_path = path.resolve('./assets/js');
const web_path = path.resolve('./web/assets');

module.exports = [
    {
        entry: {
            app: src_path + "/app"
        },

        output: {
            path: web_path + '/js/',
            filename: "[name].bundle.js",
            libraryTarget: 'var',
            library: '[name]'
        },

        module: {
            loaders: [
                {
                    test: /\.ts$/,
                    loader: "babel-loader!ts-loader",
                    exclude: /node_modules/
                },
                {
                    test: /\.js$/,
                    loader: 'babel-loader',
                    exclude: /node_modules/,
                },
                {
                    test: /\.scss$/,
                    loader: ExtractTextPlugin.extract('css-loader!sass-loader')
                }
            ]
        },

        resolve: {
            extensions: [".ts", ".js", ".scss", ".css"]
        },

        plugins: [
            new ExtractTextPlugin(
                '../css/style.css',
                {
                    allChunk: true
                }
            )
        ]
    }
];
