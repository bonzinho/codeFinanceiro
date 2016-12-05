const gulp = require('gulp');
const elixir = require('laravel-elixir');
const webpack = require('webpack');
const WebpackDevServer = require('webpack-dev-server');
const webpackConfig = require('./webpack.config');
const webpackDevConfig = require('./webpack.dev.config');
const mergeWebpack = require('webpack-merge');

const env = require('gulp-env');
const stringifyObject = require('stringify-object');
const file = require('gulp-file');

const HOST = "localhost";  // constante para alterar o nosos host de forma global, alterando aqui tudo é alterado para baixo



//require('laravel-elixir-vue');
//require('laravel-elixir-webpack-official');

//ter apenas os loaders necessarios
//Elixir.webpack.config.module.loaders = [];

//Elixir.webpack.mergeConfig(webpackConfig);
//Elixir.webpack.mergeConfig(webpackDevConfig);




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


// configurar as nossas variaveis de ambiente  do nosso gulp-env, vai criar um ficheiro de configuração em './resources/assets/spa/js'
gulp.task('spa-config', () => {

    env({
        file: '.env',
        type: 'ini' // tipo do ficheiro .env
    });
    let spaConfig = require('./spa.config');
    let string = stringifyObject(spaConfig);

    return file('config.js', `module.exports = ${string};`, {src: true})  //('nome do ficheiro', 'conteudo do ficheiro', 'src')
            .pipe(gulp.dest('./resources/assets/spa/js')); // destino do output nosso ficheiro
    //console.log(string);


});

//configurar webpack-dev-server
gulp.task('webpack-dev-server', () => {
    let config = mergeWebpack(webpackConfig, webpackDevConfig);  // ficheiro de configuraçao
    //console.log(config);
    let inlineHot = [
        'webpack/hot/dev-server',
        `webpack-dev-server/client?http://${HOST}:8080`
    ];
    config.entry.admin = [config.entry.admin].concat(inlineHot);
    config.entry.spa = [config.entry.spa].concat(inlineHot);

    new WebpackDevServer(webpack(config), {
        hot: true,
        proxy: {
            '*': `http://${HOST}:8000`
        },
        watchOptions: {
            poll: true,
            aggregateTimeout: 300
        },
        publicPath: config.output.publicPath, // config que vem do ficheiro
        noInfo: true,
        stats: {colors: true}
    }).listen(8080, HOST, () => {
        console.log("Bundling project...");
    });
});

elixir(mix => {
    mix.sass('./resources/assets/admin/sass/admin.scss')
            .sass('./resources/assets/spa/sass/spa.scss')
            .copy('./node_modules/materialize-css/fonts/roboto', './public/fonts/roboto'); // copias a fonts para a pasta publica de fonts

    gulp.start('spa-config', 'webpack-dev-server'); //roda as tarefas definidas em cona (spa-config e webpack-dev-server)

    mix.browserSync({
        host: HOST,
        proxy: `http://${HOST}:8080`
    });
});
