/*********************************************************************************************************************/
/**********                                              Vite                                               **********/
/*********************************************************************************************************************/

import { defineConfig, UserConfig } from 'vite';
import { svelte } from '@sveltejs/vite-plugin-svelte';
import path from 'path';
import sveltePreprocess from 'svelte-preprocess';
import legacy from '@vitejs/plugin-legacy';
import autoprefixer from 'autoprefixer';
import pkg from './package.json';

const PATHS = {
    src: path.join(__dirname, './resources'),
    dist: path.join(__dirname, './public/assets'),
}

const isProduction = process.env.NODE_ENV === 'production' && !process.argv.includes('--watch');
console.log(path.resolve(__dirname, '/node_modules/') + '/');
const config = <UserConfig> defineConfig({
	plugins: [
		svelte({
			emitCss: isProduction,
			preprocess: sveltePreprocess(),
			compilerOptions: {
				dev: !isProduction,
			},

			hot: !isProduction ? {
				injectCss: true,
				partialAccept: true
			} : false
		}),
	],
	build: {
		sourcemap: !isProduction,
        minify: isProduction,
        rollupOptions: {
            input: {
              'application': PATHS.src  + '/application.js',
              'page-index': PATHS.src  + '/pages/index.js',
            },
            output: {
                dir:  PATHS.dist,
                entryFileNames: 'js/[name].js',
                assetFileNames: 'css/[name].[ext]',
            },
          }
	},
	css: {
		postcss: {
			plugins: [
				autoprefixer()
			]
		}
	},
    resolve: {
        alias: {
          '~' : path.resolve(__dirname, '/node_modules/'),
        },
        extensions: ['.scss', '.css', '.js'],
    },

}); 

// Babel
if (isProduction) {
	config.plugins?.unshift(
		legacy({
			targets: pkg.browserslist
		})
	);
}


export default config;