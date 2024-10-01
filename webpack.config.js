const path                 = require('path');
const webpack              = require('webpack');
const miniCssExtractPlugin = require('mini-css-extract-plugin');
const cssMinimizerPlugin   = require("css-minimizer-webpack-plugin");
const {VueLoaderPlugin}    = require('vue-loader');


module.exports = (env, options) => {
    let src_path  = './src',
        dist_path = './dist',
        plugins   = [
            new VueLoaderPlugin()
        ];

    if ('production' === options.mode) {
        plugins.push(new cssMinimizerPlugin({
            minimizerOptions: {
                preset: [
                    "default",
                    {
                        discardComments: {removeAll: true},
                    },
                ],
            }
        }));
    } else {
        plugins.push(new webpack.SourceMapDevToolPlugin({
            test: /\.css$/
        }));
    }

    plugins.push(new miniCssExtractPlugin({
        filename: '[name].css'
    }));

    return {
        entry: {
            bundle: src_path + '/js/bundle.js'
        },
        output: {
            filename: '[name].js',
            path: path.resolve(__dirname, dist_path)
        },
        module: {
            rules: [
                {
                    test: /\.vue$/,
                    loader: 'vue-loader',
                    options: {
                        reactivityTransform: true
                    }
                },
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env']
                        }
                    }
                },
                {
                    test: /\.scss$/,
                    exclude: /node_modules/,
                    use: [
                        miniCssExtractPlugin.loader,
                        {
                            loader: 'css-loader',
                            options: {sourceMap: true}
                        },
                        {
                            loader: 'postcss-loader',
                            options: {
                                postcssOptions: {
                                    ident: 'postcss',
                                    sourceMap: 'inline'
                                }
                            }
                        },
                        'sass-loader'
                    ]
                },
                {
                    test: /\.(ttf|otf|eot|woff)(\?v=\d+\.\d+\.\d+)?$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'url-loader',
                        options: {
                            limit: 10000,
                            mimetype: 'application/octet-stream'
                        }
                    }
                },
                {
                    test: /\.(png|jpe?g|gif|svg)/i,
                    exclude: /node_modules/,
                    loader: 'url-loader'
                }
            ]
        },
        plugins: plugins,
        watchOptions: {
            ignored: /node_modules/
        }
    };
};