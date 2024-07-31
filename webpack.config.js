// webpack.config.js
const Encore = require('@symfony/webpack-encore');

Encore
    // katalog wyjściowy (output) dla plików budowania
    .setOutputPath('public/build/')
    // ścieżka publiczna używana przez serwer
    .setPublicPath('/build')
    // główny punkt wejściowy dla aplikacji
    .addEntry('app', './assets/app.js')
    // pojedynczy runtime chunk dla optymalizacji
    .enableSingleRuntimeChunk()
    // czyszczenie katalogu wyjściowego przed budowaniem
    .cleanupOutputBeforeBuild()
    // źródła mapy dla debugowania
    .enableSourceMaps(!Encore.isProduction())
    // wersjonowanie plików tylko w trybie produkcyjnym
    .enableVersioning(Encore.isProduction())
    // włączenie wsparcia dla SASS/SCSS
    .enableSassLoader()
;

module.exports = Encore.getWebpackConfig();

