const path = require( 'path' );
const webpack = require( 'webpack' );
const ExtractTextPlugin = require( 'extract-text-webpack-plugin' );
const OptimizeCssAssetsPlugin = require( 'optimize-css-assets-webpack-plugin' );
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');

let webpackConfig = {
    module: {
		rules: [
            {
                test: /\.js$/,
                use: ["source-map-loader"],
                enforce: "pre"
            },
			{
				test: /\.(js|jsx)$/,
                exclude: /node_modules/,
                loaders: [ 'babel-loader' ]
            },
            {
				test: /\.css$/i,
				use: ExtractTextPlugin.extract( {
					fallback: 'style-loader',
					use: 'css-loader'
				} ),
			},
            {
				test: /\.scss$/i,
				exclude: /node_modules/,
				use: ExtractTextPlugin.extract( {
					use: [ 'css-loader', 'sass-loader' ]
				} )
            },
            {
                test: /\.(png|jpg|gif|svg|eot|ttf|woff|woff2|mp3)$/,
                loader: 'url-loader',
                options: {
                    limit: 10000,
                    name: "assets/[hash].[ext]",
                }
            },
		],
    },
    plugins: [
		new ExtractTextPlugin({
			disable: false,
			filename: '[name].css',
			allChunks: true
		}),
        new OptimizeCssAssetsPlugin({
          assetNameRegExp: /\.min\.css$/,
          cssProcessor: require('cssnano'),
          cssProcessorOptions: { discardComments: { removeAll: true } }
        }),
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery"
        }),
    ],
    externals: {
        jquery: 'window.jQuery'
    },
};

if ( process.env.NODE_ENV === 'production' || process.env.NODE_ENV === 'test' ) {
	webpackConfig.plugins.push(
        new UglifyJsPlugin({
            uglifyOptions: {
                compress: {
                    conditionals: false, // Fixes problem with react-quill.   
                }
            }
        })
    );
}

let freeConfig = {
    ...webpackConfig,
    plugins: [...webpackConfig.plugins],
    entry: {
        blocks: './core/assets/js/blocks.js',
    },
    output: {
        filename: '[name].js',
        path: path.resolve( __dirname, 'core/dist' ),
        // libraryTarget: 'var',
        // library: [config.pluginVar, "[name]"],
    }
}

module.exports = freeConfig;