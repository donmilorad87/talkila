import { defineConfig, devices } from '@playwright/test';

const isCI = Boolean( process.env.CI );
const HOST = 'talkila.local';
// The Docker stack's nginx listens on 127.0.0.8 (docker-compose.yml). Chromium resolves the site name there directly,
// so no hosts-file entry is needed locally or in GitHub Actions.
const STACK_IP = process.env.E2E_STACK_IP || '127.0.0.8';

export default defineConfig( {
	testDir: 'tests/e2e',
	fullyParallel: true,
	forbidOnly: isCI,
	retries: isCI ? 1 : 0,
	reporter: isCI
		? [ [ 'github' ], [ 'list' ], [ 'html', { open: 'never', outputFolder: 'playwright-report' } ] ]
		: [ [ 'list' ] ],
	use: {
		baseURL: `https://${ HOST }`,
		ignoreHTTPSErrors: true, // local self-signed certificate
		launchOptions: { args: [ `--host-resolver-rules=MAP ${ HOST } ${ STACK_IP }` ] },
		trace: 'retain-on-failure',
		screenshot: 'only-on-failure',
	},
	projects: [
		{ name: 'desktop', use: { ...devices[ 'Desktop Chrome' ] } },
		{ name: 'mobile', use: { ...devices[ 'Pixel 7' ] } },
	],
} );
