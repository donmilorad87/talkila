import js from '@eslint/js';
import globals from 'globals';

// Lints our own browser code in talkila.backend/public. Vendored libraries and compiled bundles are skipped:
// they are not edited by hand, and their sources (frontend/src) are linted instead.
// CI runs this report-only for now (see .github/workflows/ci-cd.yml); the rules are the target standard.
const PUBLIC = 'talkila.backend/public';

export default [
	{
		ignores: [
			'node_modules/',
			'playwright-report/',
			'test-results/',
			'talkila.backend/vendor/',
			'talkila.backend/node_modules/',
			'talkila.backend/storage/',
			`${ PUBLIC }/**/node_modules/`,
			`${ PUBLIC }/ckeditor/`,
			`${ PUBLIC }/vendor/`,
			`${ PUBLIC }/build/`,
			`${ PUBLIC }/**/*.min.js`,
			`${ PUBLIC }/**/lib/`,
			`${ PUBLIC }/**/libs/`,
			`${ PUBLIC }/assets/js/tinymce/`,
			`${ PUBLIC }/assets/js/moment-with-locales.js`,
			`${ PUBLIC }/frontend/assets/js/jquery.dataTables.js`,
			`${ PUBLIC }/frontend/assets/js/drum.js`,
			`${ PUBLIC }/frontend/src/assets/js/jquery.mousewheel.js`,
			`${ PUBLIC }/frontend/src/assets/js/owlCarousel.js`,
			// Compiled bundles (webpack / Laravel Mix output)
			`${ PUBLIC }/js/app.js`,
			`${ PUBLIC }/sockeBundle.js`,
			`${ PUBLIC }/frontend/assets/js/app.js`,
			`${ PUBLIC }/frontend/assets/js/talk/socketBundle.js`,
		],
	},
	js.configs.recommended,
	{
		files: [ `${ PUBLIC }/**/*.js` ],
		languageOptions: {
			ecmaVersion: 'latest',
			sourceType: 'script',
			globals: { ...globals.browser, ...globals.jquery },
		},
		rules: {
			eqeqeq: 'error',
			'prefer-const': 'error',
			'no-var': 'error',
		},
	},
	{
		// webpack entry sources use ES modules
		files: [ `${ PUBLIC }/frontend/src/**/*.js`, `${ PUBLIC }/frontend/socket.js` ],
		languageOptions: { sourceType: 'module' },
	},
	{
		files: [ `${ PUBLIC }/frontend/webpack.config.*.js`, 'tests/**', 'scripts/**', '*.config.js' ],
		languageOptions: { sourceType: 'module', globals: { ...globals.node } },
	},
];
