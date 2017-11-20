const path          = require('path');
const webpack       = require('webpack');
const BASE_DIR      = path.resolve('./');
const APP_DIR       = path.resolve('./assets/');
const MODULE_DIR    = path.resolve('./src/Modules');

const CommonsChunkPlugin = webpack.optimize.CommonsChunkPlugin;
const ExtractTextPlugin = require("extract-text-webpack-plugin");

let config = {
    entry: {
        "dist/vc-page-builder-content": APP_DIR + '/scripts/content.js',
        "src/Modules/ACF/dist/module-build-submenu-blocks": MODULE_DIR + '/ACF/assets/scripts/index.js',
    },
    output: {
        path: BASE_DIR,
        filename: '[name].js'
    },
    resolve: {
        extensions: ['.js']
    },
    module : {
        loaders: [
            {
                test: /\.js/,
                exclude: /(node_modules|build)/,
                loader: 'eslint-loader',
            },{
                test : /\.js/,
                exclude: /(node_modules|bower_components)/,
                loader : 'babel-loader',
                query: {
                    plugins: ['transform-class-properties', 'transform-runtime'],
                    presets: ['stage-2', 'es2015'],
                }
            },{
                test: /\.s?css$/,
                use: ExtractTextPlugin.extract({
                    fallback: "style-loader",
                    use: ["css-loader", "sass-loader"]
                })
            }
        ]
    },
    devtool: 'source-map',
    plugins: [
        new CommonsChunkPlugin('dist/vc-page-builder-bundle'),
        new ExtractTextPlugin({
            filename: '[name].css'
        })
    ]
};

module.exports = config;