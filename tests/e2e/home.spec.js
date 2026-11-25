import { test, expect } from '@playwright/test';

test( 'home page loads without server errors', async ( { page } ) => {
	const serverErrors = [];
	page.on( 'response', ( response ) => {
		if ( response.status() >= 500 ) {
			serverErrors.push( `${ response.status() } ${ response.url() }` );
		}
	} );

	const response = await page.goto( '/' );

	expect( response.status() ).toBe( 200 );
	await expect( page ).toHaveTitle( /Talkila/i );
	expect( serverErrors ).toEqual( [] );
} );

// Through the browser (not the `request` fixture): only Chromium uses the talkila.local → stack IP mapping.
test( 'health endpoint reports app and database ok', async ( { page } ) => {
	const response = await page.goto( '/v1/health' );

	expect( response.status() ).toBe( 200 );
	expect( await response.json() ).toEqual( { status: 'ok', database: 'ok' } );
} );
