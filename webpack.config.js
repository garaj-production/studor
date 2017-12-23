var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    .addEntry('app', './assets/js/app.ts')

    .enableSassLoader()
    .enablePostCssLoader()
    .configureBabel(function(babelConfig) {
        babelConfig.presets.push('env');
    })
    .enableTypeScriptLoader()

    .autoProvidejQuery()
    .autoProvideVariables({
        Popper: ['popper.js', 'default'],
    })

    .enableSourceMaps(!Encore.isProduction())
    .cleanupOutputBeforeBuild()

    .enableBuildNotifications()

    // .enableVersioning()
;
module.exports = Encore.getWebpackConfig();
