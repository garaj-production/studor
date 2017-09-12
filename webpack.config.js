const webpack = require('webpack');
// const ExtractTextPlugin = require('extract-text-webpack-plugin');
const path = require('path');

const src_path = path.resolve('./assets/js');
const web_path = path.resolve('./web/assets');

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
                // {
                //     test: /\.scss$/,
                //     loader: ExtractTextPlugin.extract('css-loader!sass-loader')
                // },
                {
                    test: /\.(scss)$/,
                    use: [
                        {
                            loader: 'style-loader', // inject CSS to page
                        },
                        {
                            loader: 'css-loader', // translates CSS into CommonJS modules
                        },
                        {
                            loader: 'postcss-loader', // Run post css actions
                            options: {
                                plugins: function () { // post css plugins, can be exported to postcss.config.js
                                    return [
                                        require('precss'),
                                        require('autoprefixer')
                                    ];
                                }
                            }
                        },
                        {
                            loader: 'sass-loader' // compiles SASS to CSS
                        }
                    ]
                },
            ]
        },

        resolve: {
            extensions: [".ts", ".js", ".scss", ".css"]
        },

        plugins: [
            // new ExtractTextPlugin(
            //     '../css/style.css',
            //     {
            //         allChunk: true
            //     }
            // ),
            new CleanWebpackPlugin([web_path], {verbose: true}),
            new webpack.NoEmitOnErrorsPlugin(),
            new webpack.ProvidePlugin({
                $: 'jquery',
                jQuery: 'jquery',
                'window.jQuery': 'jquery',
            }),
        ]
    }
];
