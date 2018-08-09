const gulp = require('gulp')
const elixir = require('laravel-elixir')
const webpack = require('webpack')
const WebpackDevServer = require('webpack-dev-server')
const webpackConfig = require('./webpack.config')
const webpackDevConfig = require('./webpack.dev.config')

require('laravel-elixir-vue')
require('laravel-elixir-webpack-official')

Elixir.webpack.config.module.loaders = []

Elixir.webpack.mergeConfig(webpackConfig)
Elixir.webpack.mergeConfig(webpackDevConfig)

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

gulp.task('webpack-dev-server', () => {
    var config = Elixir.webpack.config
    var inlineHot = [
        'webpack/hot/dev-server',
        'webpack-dev-server/client?http://0.0.0.0:8080'
    ]

    config.entry.admin = [config.entry.admin].concat(inlineHot)

    new WebpackDevServer(webpack(config),{
        hot: true,
        proxy:{
            '*': 'http://0.0.0.0:8000'
        },
        watchOptions: {
            poll: true,
            aggregateTimeout: 300
        },
        publicPath: config.output.publicPath,
        noInfo: true,
        stats: { colors: true }
    }).listen(8080,"0.0.0.0", () => {
        console.log("Bundling project...")
    })
})

elixir(mix => {
    mix.sass('./resources/assets/admin/sass/admin.scss')
        .copy('./node_modules/materialize-css/fonts/roboto','./public/fonts/roboto')

    gulp.start('webpack-dev-server')

    mix.browserSync({
        host: '0.0.0.0',
        proxy: 'http://0.0.0.0:8080'
    })
       //.webpack('admin.js');
})
