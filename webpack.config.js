const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const path = require('path');

const src_path = path.resolve('./assets/js');
const web_path = path.resolve('./public/assets');

const CleanWebpackPlugin = require('clean-webpack-plugin');

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
                    loader: ExtractTextPlugin.extract({
                        fallback: 'style-loader',
                        use: ['css-loader', 'postcss-loader', 'sass-loader']
                    })
                },
            ]
        },

        resolve: {
            extensions: [".ts", ".js", ".scss", ".css"]
        },

        plugins: [
            new CleanWebpackPlugin([web_path], {verbose: true}),
            new webpack.NoEmitOnErrorsPlugin(),
            new webpack.optimize.UglifyJsPlugin({
                comments: false,
                minimize: true,
                compress: {
                    warnings: false,
                    drop_console: true
                }
            }),
            new webpack.ProvidePlugin({
                $: 'jquery',
                jQuery: 'jquery',
                'window.jQuery': 'jquery',
                Popper: ['popper.js', 'default'],
            }),
            new ExtractTextPlugin(
                '../css/[name].css',
                {
                    allChunk: true
                }
            ),
        ]
    }
];
