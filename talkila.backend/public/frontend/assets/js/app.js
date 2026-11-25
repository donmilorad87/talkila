/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/jquery/dist/jquery.js":
/*!********************************************!*\
  !*** ./node_modules/jquery/dist/jquery.js ***!
  \********************************************/
/***/ (function(module, exports) {

var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
 * jQuery JavaScript Library v3.6.3
 * https://jquery.com/
 *
 * Includes Sizzle.js
 * https://sizzlejs.com/
 *
 * Copyright OpenJS Foundation and other contributors
 * Released under the MIT license
 * https://jquery.org/license
 *
 * Date: 2022-12-20T21:28Z
 */
( function( global, factory ) {

	"use strict";

	if (  true && typeof module.exports === "object" ) {

		// For CommonJS and CommonJS-like environments where a proper `window`
		// is present, execute the factory and get jQuery.
		// For environments that do not have a `window` with a `document`
		// (such as Node.js), expose a factory as module.exports.
		// This accentuates the need for the creation of a real `window`.
		// e.g. var jQuery = require("jquery")(window);
		// See ticket trac-14549 for more info.
		module.exports = global.document ?
			factory( global, true ) :
			function( w ) {
				if ( !w.document ) {
					throw new Error( "jQuery requires a window with a document" );
				}
				return factory( w );
			};
	} else {
		factory( global );
	}

// Pass this if window is not defined yet
} )( typeof window !== "undefined" ? window : this, function( window, noGlobal ) {

// Edge <= 12 - 13+, Firefox <=18 - 45+, IE 10 - 11, Safari 5.1 - 9+, iOS 6 - 9.1
// throw exceptions when non-strict code (e.g., ASP.NET 4.5) accesses strict mode
// arguments.callee.caller (trac-13335). But as of jQuery 3.0 (2016), strict mode should be common
// enough that all such attempts are guarded in a try block.
"use strict";

var arr = [];

var getProto = Object.getPrototypeOf;

var slice = arr.slice;

var flat = arr.flat ? function( array ) {
	return arr.flat.call( array );
} : function( array ) {
	return arr.concat.apply( [], array );
};


var push = arr.push;

var indexOf = arr.indexOf;

var class2type = {};

var toString = class2type.toString;

var hasOwn = class2type.hasOwnProperty;

var fnToString = hasOwn.toString;

var ObjectFunctionString = fnToString.call( Object );

var support = {};

var isFunction = function isFunction( obj ) {

		// Support: Chrome <=57, Firefox <=52
		// In some browsers, typeof returns "function" for HTML <object> elements
		// (i.e., `typeof document.createElement( "object" ) === "function"`).
		// We don't want to classify *any* DOM node as a function.
		// Support: QtWeb <=3.8.5, WebKit <=534.34, wkhtmltopdf tool <=0.12.5
		// Plus for old WebKit, typeof returns "function" for HTML collections
		// (e.g., `typeof document.getElementsByTagName("div") === "function"`). (gh-4756)
		return typeof obj === "function" && typeof obj.nodeType !== "number" &&
			typeof obj.item !== "function";
	};


var isWindow = function isWindow( obj ) {
		return obj != null && obj === obj.window;
	};


var document = window.document;



	var preservedScriptAttributes = {
		type: true,
		src: true,
		nonce: true,
		noModule: true
	};

	function DOMEval( code, node, doc ) {
		doc = doc || document;

		var i, val,
			script = doc.createElement( "script" );

		script.text = code;
		if ( node ) {
			for ( i in preservedScriptAttributes ) {

				// Support: Firefox 64+, Edge 18+
				// Some browsers don't support the "nonce" property on scripts.
				// On the other hand, just using `getAttribute` is not enough as
				// the `nonce` attribute is reset to an empty string whenever it
				// becomes browsing-context connected.
				// See https://github.com/whatwg/html/issues/2369
				// See https://html.spec.whatwg.org/#nonce-attributes
				// The `node.getAttribute` check was added for the sake of
				// `jQuery.globalEval` so that it can fake a nonce-containing node
				// via an object.
				val = node[ i ] || node.getAttribute && node.getAttribute( i );
				if ( val ) {
					script.setAttribute( i, val );
				}
			}
		}
		doc.head.appendChild( script ).parentNode.removeChild( script );
	}


function toType( obj ) {
	if ( obj == null ) {
		return obj + "";
	}

	// Support: Android <=2.3 only (functionish RegExp)
	return typeof obj === "object" || typeof obj === "function" ?
		class2type[ toString.call( obj ) ] || "object" :
		typeof obj;
}
/* global Symbol */
// Defining this global in .eslintrc.json would create a danger of using the global
// unguarded in another place, it seems safer to define global only for this module



var
	version = "3.6.3",

	// Define a local copy of jQuery
	jQuery = function( selector, context ) {

		// The jQuery object is actually just the init constructor 'enhanced'
		// Need init if jQuery is called (just allow error to be thrown if not included)
		return new jQuery.fn.init( selector, context );
	};

jQuery.fn = jQuery.prototype = {

	// The current version of jQuery being used
	jquery: version,

	constructor: jQuery,

	// The default length of a jQuery object is 0
	length: 0,

	toArray: function() {
		return slice.call( this );
	},

	// Get the Nth element in the matched element set OR
	// Get the whole matched element set as a clean array
	get: function( num ) {

		// Return all the elements in a clean array
		if ( num == null ) {
			return slice.call( this );
		}

		// Return just the one element from the set
		return num < 0 ? this[ num + this.length ] : this[ num ];
	},

	// Take an array of elements and push it onto the stack
	// (returning the new matched element set)
	pushStack: function( elems ) {

		// Build a new jQuery matched element set
		var ret = jQuery.merge( this.constructor(), elems );

		// Add the old object onto the stack (as a reference)
		ret.prevObject = this;

		// Return the newly-formed element set
		return ret;
	},

	// Execute a callback for every element in the matched set.
	each: function( callback ) {
		return jQuery.each( this, callback );
	},

	map: function( callback ) {
		return this.pushStack( jQuery.map( this, function( elem, i ) {
			return callback.call( elem, i, elem );
		} ) );
	},

	slice: function() {
		return this.pushStack( slice.apply( this, arguments ) );
	},

	first: function() {
		return this.eq( 0 );
	},

	last: function() {
		return this.eq( -1 );
	},

	even: function() {
		return this.pushStack( jQuery.grep( this, function( _elem, i ) {
			return ( i + 1 ) % 2;
		} ) );
	},

	odd: function() {
		return this.pushStack( jQuery.grep( this, function( _elem, i ) {
			return i % 2;
		} ) );
	},

	eq: function( i ) {
		var len = this.length,
			j = +i + ( i < 0 ? len : 0 );
		return this.pushStack( j >= 0 && j < len ? [ this[ j ] ] : [] );
	},

	end: function() {
		return this.prevObject || this.constructor();
	},

	// For internal use only.
	// Behaves like an Array's method, not like a jQuery method.
	push: push,
	sort: arr.sort,
	splice: arr.splice
};

jQuery.extend = jQuery.fn.extend = function() {
	var options, name, src, copy, copyIsArray, clone,
		target = arguments[ 0 ] || {},
		i = 1,
		length = arguments.length,
		deep = false;

	// Handle a deep copy situation
	if ( typeof target === "boolean" ) {
		deep = target;

		// Skip the boolean and the target
		target = arguments[ i ] || {};
		i++;
	}

	// Handle case when target is a string or something (possible in deep copy)
	if ( typeof target !== "object" && !isFunction( target ) ) {
		target = {};
	}

	// Extend jQuery itself if only one argument is passed
	if ( i === length ) {
		target = this;
		i--;
	}

	for ( ; i < length; i++ ) {

		// Only deal with non-null/undefined values
		if ( ( options = arguments[ i ] ) != null ) {

			// Extend the base object
			for ( name in options ) {
				copy = options[ name ];

				// Prevent Object.prototype pollution
				// Prevent never-ending loop
				if ( name === "__proto__" || target === copy ) {
					continue;
				}

				// Recurse if we're merging plain objects or arrays
				if ( deep && copy && ( jQuery.isPlainObject( copy ) ||
					( copyIsArray = Array.isArray( copy ) ) ) ) {
					src = target[ name ];

					// Ensure proper type for the source value
					if ( copyIsArray && !Array.isArray( src ) ) {
						clone = [];
					} else if ( !copyIsArray && !jQuery.isPlainObject( src ) ) {
						clone = {};
					} else {
						clone = src;
					}
					copyIsArray = false;

					// Never move original objects, clone them
					target[ name ] = jQuery.extend( deep, clone, copy );

				// Don't bring in undefined values
				} else if ( copy !== undefined ) {
					target[ name ] = copy;
				}
			}
		}
	}

	// Return the modified object
	return target;
};

jQuery.extend( {

	// Unique for each copy of jQuery on the page
	expando: "jQuery" + ( version + Math.random() ).replace( /\D/g, "" ),

	// Assume jQuery is ready without the ready module
	isReady: true,

	error: function( msg ) {
		throw new Error( msg );
	},

	noop: function() {},

	isPlainObject: function( obj ) {
		var proto, Ctor;

		// Detect obvious negatives
		// Use toString instead of jQuery.type to catch host objects
		if ( !obj || toString.call( obj ) !== "[object Object]" ) {
			return false;
		}

		proto = getProto( obj );

		// Objects with no prototype (e.g., `Object.create( null )`) are plain
		if ( !proto ) {
			return true;
		}

		// Objects with prototype are plain iff they were constructed by a global Object function
		Ctor = hasOwn.call( proto, "constructor" ) && proto.constructor;
		return typeof Ctor === "function" && fnToString.call( Ctor ) === ObjectFunctionString;
	},

	isEmptyObject: function( obj ) {
		var name;

		for ( name in obj ) {
			return false;
		}
		return true;
	},

	// Evaluates a script in a provided context; falls back to the global one
	// if not specified.
	globalEval: function( code, options, doc ) {
		DOMEval( code, { nonce: options && options.nonce }, doc );
	},

	each: function( obj, callback ) {
		var length, i = 0;

		if ( isArrayLike( obj ) ) {
			length = obj.length;
			for ( ; i < length; i++ ) {
				if ( callback.call( obj[ i ], i, obj[ i ] ) === false ) {
					break;
				}
			}
		} else {
			for ( i in obj ) {
				if ( callback.call( obj[ i ], i, obj[ i ] ) === false ) {
					break;
				}
			}
		}

		return obj;
	},

	// results is for internal usage only
	makeArray: function( arr, results ) {
		var ret = results || [];

		if ( arr != null ) {
			if ( isArrayLike( Object( arr ) ) ) {
				jQuery.merge( ret,
					typeof arr === "string" ?
						[ arr ] : arr
				);
			} else {
				push.call( ret, arr );
			}
		}

		return ret;
	},

	inArray: function( elem, arr, i ) {
		return arr == null ? -1 : indexOf.call( arr, elem, i );
	},

	// Support: Android <=4.0 only, PhantomJS 1 only
	// push.apply(_, arraylike) throws on ancient WebKit
	merge: function( first, second ) {
		var len = +second.length,
			j = 0,
			i = first.length;

		for ( ; j < len; j++ ) {
			first[ i++ ] = second[ j ];
		}

		first.length = i;

		return first;
	},

	grep: function( elems, callback, invert ) {
		var callbackInverse,
			matches = [],
			i = 0,
			length = elems.length,
			callbackExpect = !invert;

		// Go through the array, only saving the items
		// that pass the validator function
		for ( ; i < length; i++ ) {
			callbackInverse = !callback( elems[ i ], i );
			if ( callbackInverse !== callbackExpect ) {
				matches.push( elems[ i ] );
			}
		}

		return matches;
	},

	// arg is for internal usage only
	map: function( elems, callback, arg ) {
		var length, value,
			i = 0,
			ret = [];

		// Go through the array, translating each of the items to their new values
		if ( isArrayLike( elems ) ) {
			length = elems.length;
			for ( ; i < length; i++ ) {
				value = callback( elems[ i ], i, arg );

				if ( value != null ) {
					ret.push( value );
				}
			}

		// Go through every key on the object,
		} else {
			for ( i in elems ) {
				value = callback( elems[ i ], i, arg );

				if ( value != null ) {
					ret.push( value );
				}
			}
		}

		// Flatten any nested arrays
		return flat( ret );
	},

	// A global GUID counter for objects
	guid: 1,

	// jQuery.support is not used in Core but other projects attach their
	// properties to it so it needs to exist.
	support: support
} );

if ( typeof Symbol === "function" ) {
	jQuery.fn[ Symbol.iterator ] = arr[ Symbol.iterator ];
}

// Populate the class2type map
jQuery.each( "Boolean Number String Function Array Date RegExp Object Error Symbol".split( " " ),
	function( _i, name ) {
		class2type[ "[object " + name + "]" ] = name.toLowerCase();
	} );

function isArrayLike( obj ) {

	// Support: real iOS 8.2 only (not reproducible in simulator)
	// `in` check used to prevent JIT error (gh-2145)
	// hasOwn isn't used here due to false negatives
	// regarding Nodelist length in IE
	var length = !!obj && "length" in obj && obj.length,
		type = toType( obj );

	if ( isFunction( obj ) || isWindow( obj ) ) {
		return false;
	}

	return type === "array" || length === 0 ||
		typeof length === "number" && length > 0 && ( length - 1 ) in obj;
}
var Sizzle =
/*!
 * Sizzle CSS Selector Engine v2.3.9
 * https://sizzlejs.com/
 *
 * Copyright JS Foundation and other contributors
 * Released under the MIT license
 * https://js.foundation/
 *
 * Date: 2022-12-19
 */
( function( window ) {
var i,
	support,
	Expr,
	getText,
	isXML,
	tokenize,
	compile,
	select,
	outermostContext,
	sortInput,
	hasDuplicate,

	// Local document vars
	setDocument,
	document,
	docElem,
	documentIsHTML,
	rbuggyQSA,
	rbuggyMatches,
	matches,
	contains,

	// Instance-specific data
	expando = "sizzle" + 1 * new Date(),
	preferredDoc = window.document,
	dirruns = 0,
	done = 0,
	classCache = createCache(),
	tokenCache = createCache(),
	compilerCache = createCache(),
	nonnativeSelectorCache = createCache(),
	sortOrder = function( a, b ) {
		if ( a === b ) {
			hasDuplicate = true;
		}
		return 0;
	},

	// Instance methods
	hasOwn = ( {} ).hasOwnProperty,
	arr = [],
	pop = arr.pop,
	pushNative = arr.push,
	push = arr.push,
	slice = arr.slice,

	// Use a stripped-down indexOf as it's faster than native
	// https://jsperf.com/thor-indexof-vs-for/5
	indexOf = function( list, elem ) {
		var i = 0,
			len = list.length;
		for ( ; i < len; i++ ) {
			if ( list[ i ] === elem ) {
				return i;
			}
		}
		return -1;
	},

	booleans = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|" +
		"ismap|loop|multiple|open|readonly|required|scoped",

	// Regular expressions

	// http://www.w3.org/TR/css3-selectors/#whitespace
	whitespace = "[\\x20\\t\\r\\n\\f]",

	// https://www.w3.org/TR/css-syntax-3/#ident-token-diagram
	identifier = "(?:\\\\[\\da-fA-F]{1,6}" + whitespace +
		"?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+",

	// Attribute selectors: http://www.w3.org/TR/selectors/#attribute-selectors
	attributes = "\\[" + whitespace + "*(" + identifier + ")(?:" + whitespace +

		// Operator (capture 2)
		"*([*^$|!~]?=)" + whitespace +

		// "Attribute values must be CSS identifiers [capture 5]
		// or strings [capture 3 or capture 4]"
		"*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + identifier + "))|)" +
		whitespace + "*\\]",

	pseudos = ":(" + identifier + ")(?:\\((" +

		// To reduce the number of selectors needing tokenize in the preFilter, prefer arguments:
		// 1. quoted (capture 3; capture 4 or capture 5)
		"('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|" +

		// 2. simple (capture 6)
		"((?:\\\\.|[^\\\\()[\\]]|" + attributes + ")*)|" +

		// 3. anything else (capture 2)
		".*" +
		")\\)|)",

	// Leading and non-escaped trailing whitespace, capturing some non-whitespace characters preceding the latter
	rwhitespace = new RegExp( whitespace + "+", "g" ),
	rtrim = new RegExp( "^" + whitespace + "+|((?:^|[^\\\\])(?:\\\\.)*)" +
		whitespace + "+$", "g" ),

	rcomma = new RegExp( "^" + whitespace + "*," + whitespace + "*" ),
	rcombinators = new RegExp( "^" + whitespace + "*([>+~]|" + whitespace + ")" + whitespace +
		"*" ),
	rdescend = new RegExp( whitespace + "|>" ),

	rpseudo = new RegExp( pseudos ),
	ridentifier = new RegExp( "^" + identifier + "$" ),

	matchExpr = {
		"ID": new RegExp( "^#(" + identifier + ")" ),
		"CLASS": new RegExp( "^\\.(" + identifier + ")" ),
		"TAG": new RegExp( "^(" + identifier + "|[*])" ),
		"ATTR": new RegExp( "^" + attributes ),
		"PSEUDO": new RegExp( "^" + pseudos ),
		"CHILD": new RegExp( "^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" +
			whitespace + "*(even|odd|(([+-]|)(\\d*)n|)" + whitespace + "*(?:([+-]|)" +
			whitespace + "*(\\d+)|))" + whitespace + "*\\)|)", "i" ),
		"bool": new RegExp( "^(?:" + booleans + ")$", "i" ),

		// For use in libraries implementing .is()
		// We use this for POS matching in `select`
		"needsContext": new RegExp( "^" + whitespace +
			"*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + whitespace +
			"*((?:-\\d)?\\d*)" + whitespace + "*\\)|)(?=[^-]|$)", "i" )
	},

	rhtml = /HTML$/i,
	rinputs = /^(?:input|select|textarea|button)$/i,
	rheader = /^h\d$/i,

	rnative = /^[^{]+\{\s*\[native \w/,

	// Easily-parseable/retrievable ID or TAG or CLASS selectors
	rquickExpr = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,

	rsibling = /[+~]/,

	// CSS escapes
	// http://www.w3.org/TR/CSS21/syndata.html#escaped-characters
	runescape = new RegExp( "\\\\[\\da-fA-F]{1,6}" + whitespace + "?|\\\\([^\\r\\n\\f])", "g" ),
	funescape = function( escape, nonHex ) {
		var high = "0x" + escape.slice( 1 ) - 0x10000;

		return nonHex ?

			// Strip the backslash prefix from a non-hex escape sequence
			nonHex :

			// Replace a hexadecimal escape sequence with the encoded Unicode code point
			// Support: IE <=11+
			// For values outside the Basic Multilingual Plane (BMP), manually construct a
			// surrogate pair
			high < 0 ?
				String.fromCharCode( high + 0x10000 ) :
				String.fromCharCode( high >> 10 | 0xD800, high & 0x3FF | 0xDC00 );
	},

	// CSS string/identifier serialization
	// https://drafts.csswg.org/cssom/#common-serializing-idioms
	rcssescape = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g,
	fcssescape = function( ch, asCodePoint ) {
		if ( asCodePoint ) {

			// U+0000 NULL becomes U+FFFD REPLACEMENT CHARACTER
			if ( ch === "\0" ) {
				return "\uFFFD";
			}

			// Control characters and (dependent upon position) numbers get escaped as code points
			return ch.slice( 0, -1 ) + "\\" +
				ch.charCodeAt( ch.length - 1 ).toString( 16 ) + " ";
		}

		// Other potentially-special ASCII characters get backslash-escaped
		return "\\" + ch;
	},

	// Used for iframes
	// See setDocument()
	// Removing the function wrapper causes a "Permission Denied"
	// error in IE
	unloadHandler = function() {
		setDocument();
	},

	inDisabledFieldset = addCombinator(
		function( elem ) {
			return elem.disabled === true && elem.nodeName.toLowerCase() === "fieldset";
		},
		{ dir: "parentNode", next: "legend" }
	);

// Optimize for push.apply( _, NodeList )
try {
	push.apply(
		( arr = slice.call( preferredDoc.childNodes ) ),
		preferredDoc.childNodes
	);

	// Support: Android<4.0
	// Detect silently failing push.apply
	// eslint-disable-next-line no-unused-expressions
	arr[ preferredDoc.childNodes.length ].nodeType;
} catch ( e ) {
	push = { apply: arr.length ?

		// Leverage slice if possible
		function( target, els ) {
			pushNative.apply( target, slice.call( els ) );
		} :

		// Support: IE<9
		// Otherwise append directly
		function( target, els ) {
			var j = target.length,
				i = 0;

			// Can't trust NodeList.length
			while ( ( target[ j++ ] = els[ i++ ] ) ) {}
			target.length = j - 1;
		}
	};
}

function Sizzle( selector, context, results, seed ) {
	var m, i, elem, nid, match, groups, newSelector,
		newContext = context && context.ownerDocument,

		// nodeType defaults to 9, since context defaults to document
		nodeType = context ? context.nodeType : 9;

	results = results || [];

	// Return early from calls with invalid selector or context
	if ( typeof selector !== "string" || !selector ||
		nodeType !== 1 && nodeType !== 9 && nodeType !== 11 ) {

		return results;
	}

	// Try to shortcut find operations (as opposed to filters) in HTML documents
	if ( !seed ) {
		setDocument( context );
		context = context || document;

		if ( documentIsHTML ) {

			// If the selector is sufficiently simple, try using a "get*By*" DOM method
			// (excepting DocumentFragment context, where the methods don't exist)
			if ( nodeType !== 11 && ( match = rquickExpr.exec( selector ) ) ) {

				// ID selector
				if ( ( m = match[ 1 ] ) ) {

					// Document context
					if ( nodeType === 9 ) {
						if ( ( elem = context.getElementById( m ) ) ) {

							// Support: IE, Opera, Webkit
							// TODO: identify versions
							// getElementById can match elements by name instead of ID
							if ( elem.id === m ) {
								results.push( elem );
								return results;
							}
						} else {
							return results;
						}

					// Element context
					} else {

						// Support: IE, Opera, Webkit
						// TODO: identify versions
						// getElementById can match elements by name instead of ID
						if ( newContext && ( elem = newContext.getElementById( m ) ) &&
							contains( context, elem ) &&
							elem.id === m ) {

							results.push( elem );
							return results;
						}
					}

				// Type selector
				} else if ( match[ 2 ] ) {
					push.apply( results, context.getElementsByTagName( selector ) );
					return results;

				// Class selector
				} else if ( ( m = match[ 3 ] ) && support.getElementsByClassName &&
					context.getElementsByClassName ) {

					push.apply( results, context.getElementsByClassName( m ) );
					return results;
				}
			}

			// Take advantage of querySelectorAll
			if ( support.qsa &&
				!nonnativeSelectorCache[ selector + " " ] &&
				( !rbuggyQSA || !rbuggyQSA.test( selector ) ) &&

				// Support: IE 8 only
				// Exclude object elements
				( nodeType !== 1 || context.nodeName.toLowerCase() !== "object" ) ) {

				newSelector = selector;
				newContext = context;

				// qSA considers elements outside a scoping root when evaluating child or
				// descendant combinators, which is not what we want.
				// In such cases, we work around the behavior by prefixing every selector in the
				// list with an ID selector referencing the scope context.
				// The technique has to be used as well when a leading combinator is used
				// as such selectors are not recognized by querySelectorAll.
				// Thanks to Andrew Dupont for this technique.
				if ( nodeType === 1 &&
					( rdescend.test( selector ) || rcombinators.test( selector ) ) ) {

					// Expand context for sibling selectors
					newContext = rsibling.test( selector ) && testContext( context.parentNode ) ||
						context;

					// We can use :scope instead of the ID hack if the browser
					// supports it & if we're not changing the context.
					if ( newContext !== context || !support.scope ) {

						// Capture the context ID, setting it first if necessary
						if ( ( nid = context.getAttribute( "id" ) ) ) {
							nid = nid.replace( rcssescape, fcssescape );
						} else {
							context.setAttribute( "id", ( nid = expando ) );
						}
					}

					// Prefix every selector in the list
					groups = tokenize( selector );
					i = groups.length;
					while ( i-- ) {
						groups[ i ] = ( nid ? "#" + nid : ":scope" ) + " " +
							toSelector( groups[ i ] );
					}
					newSelector = groups.join( "," );
				}

				try {

					// `qSA` may not throw for unrecognized parts using forgiving parsing:
					// https://drafts.csswg.org/selectors/#forgiving-selector
					// like the `:has()` pseudo-class:
					// https://drafts.csswg.org/selectors/#relational
					// `CSS.supports` is still expected to return `false` then:
					// https://drafts.csswg.org/css-conditional-4/#typedef-supports-selector-fn
					// https://drafts.csswg.org/css-conditional-4/#dfn-support-selector
					if ( support.cssSupportsSelector &&

						// eslint-disable-next-line no-undef
						!CSS.supports( "selector(:is(" + newSelector + "))" ) ) {

						// Support: IE 11+
						// Throw to get to the same code path as an error directly in qSA.
						// Note: once we only support browser supporting
						// `CSS.supports('selector(...)')`, we can most likely drop
						// the `try-catch`. IE doesn't implement the API.
						throw new Error();
					}

					push.apply( results,
						newContext.querySelectorAll( newSelector )
					);
					return results;
				} catch ( qsaError ) {
					nonnativeSelectorCache( selector, true );
				} finally {
					if ( nid === expando ) {
						context.removeAttribute( "id" );
					}
				}
			}
		}
	}

	// All others
	return select( selector.replace( rtrim, "$1" ), context, results, seed );
}

/**
 * Create key-value caches of limited size
 * @returns {function(string, object)} Returns the Object data after storing it on itself with
 *	property name the (space-suffixed) string and (if the cache is larger than Expr.cacheLength)
 *	deleting the oldest entry
 */
function createCache() {
	var keys = [];

	function cache( key, value ) {

		// Use (key + " ") to avoid collision with native prototype properties (see Issue #157)
		if ( keys.push( key + " " ) > Expr.cacheLength ) {

			// Only keep the most recent entries
			delete cache[ keys.shift() ];
		}
		return ( cache[ key + " " ] = value );
	}
	return cache;
}

/**
 * Mark a function for special use by Sizzle
 * @param {Function} fn The function to mark
 */
function markFunction( fn ) {
	fn[ expando ] = true;
	return fn;
}

/**
 * Support testing using an element
 * @param {Function} fn Passed the created element and returns a boolean result
 */
function assert( fn ) {
	var el = document.createElement( "fieldset" );

	try {
		return !!fn( el );
	} catch ( e ) {
		return false;
	} finally {

		// Remove from its parent by default
		if ( el.parentNode ) {
			el.parentNode.removeChild( el );
		}

		// release memory in IE
		el = null;
	}
}

/**
 * Adds the same handler for all of the specified attrs
 * @param {String} attrs Pipe-separated list of attributes
 * @param {Function} handler The method that will be applied
 */
function addHandle( attrs, handler ) {
	var arr = attrs.split( "|" ),
		i = arr.length;

	while ( i-- ) {
		Expr.attrHandle[ arr[ i ] ] = handler;
	}
}

/**
 * Checks document order of two siblings
 * @param {Element} a
 * @param {Element} b
 * @returns {Number} Returns less than 0 if a precedes b, greater than 0 if a follows b
 */
function siblingCheck( a, b ) {
	var cur = b && a,
		diff = cur && a.nodeType === 1 && b.nodeType === 1 &&
			a.sourceIndex - b.sourceIndex;

	// Use IE sourceIndex if available on both nodes
	if ( diff ) {
		return diff;
	}

	// Check if b follows a
	if ( cur ) {
		while ( ( cur = cur.nextSibling ) ) {
			if ( cur === b ) {
				return -1;
			}
		}
	}

	return a ? 1 : -1;
}

/**
 * Returns a function to use in pseudos for input types
 * @param {String} type
 */
function createInputPseudo( type ) {
	return function( elem ) {
		var name = elem.nodeName.toLowerCase();
		return name === "input" && elem.type === type;
	};
}

/**
 * Returns a function to use in pseudos for buttons
 * @param {String} type
 */
function createButtonPseudo( type ) {
	return function( elem ) {
		var name = elem.nodeName.toLowerCase();
		return ( name === "input" || name === "button" ) && elem.type === type;
	};
}

/**
 * Returns a function to use in pseudos for :enabled/:disabled
 * @param {Boolean} disabled true for :disabled; false for :enabled
 */
function createDisabledPseudo( disabled ) {

	// Known :disabled false positives: fieldset[disabled] > legend:nth-of-type(n+2) :can-disable
	return function( elem ) {

		// Only certain elements can match :enabled or :disabled
		// https://html.spec.whatwg.org/multipage/scripting.html#selector-enabled
		// https://html.spec.whatwg.org/multipage/scripting.html#selector-disabled
		if ( "form" in elem ) {

			// Check for inherited disabledness on relevant non-disabled elements:
			// * listed form-associated elements in a disabled fieldset
			//   https://html.spec.whatwg.org/multipage/forms.html#category-listed
			//   https://html.spec.whatwg.org/multipage/forms.html#concept-fe-disabled
			// * option elements in a disabled optgroup
			//   https://html.spec.whatwg.org/multipage/forms.html#concept-option-disabled
			// All such elements have a "form" property.
			if ( elem.parentNode && elem.disabled === false ) {

				// Option elements defer to a parent optgroup if present
				if ( "label" in elem ) {
					if ( "label" in elem.parentNode ) {
						return elem.parentNode.disabled === disabled;
					} else {
						return elem.disabled === disabled;
					}
				}

				// Support: IE 6 - 11
				// Use the isDisabled shortcut property to check for disabled fieldset ancestors
				return elem.isDisabled === disabled ||

					// Where there is no isDisabled, check manually
					/* jshint -W018 */
					elem.isDisabled !== !disabled &&
					inDisabledFieldset( elem ) === disabled;
			}

			return elem.disabled === disabled;

		// Try to winnow out elements that can't be disabled before trusting the disabled property.
		// Some victims get caught in our net (label, legend, menu, track), but it shouldn't
		// even exist on them, let alone have a boolean value.
		} else if ( "label" in elem ) {
			return elem.disabled === disabled;
		}

		// Remaining elements are neither :enabled nor :disabled
		return false;
	};
}

/**
 * Returns a function to use in pseudos for positionals
 * @param {Function} fn
 */
function createPositionalPseudo( fn ) {
	return markFunction( function( argument ) {
		argument = +argument;
		return markFunction( function( seed, matches ) {
			var j,
				matchIndexes = fn( [], seed.length, argument ),
				i = matchIndexes.length;

			// Match elements found at the specified indexes
			while ( i-- ) {
				if ( seed[ ( j = matchIndexes[ i ] ) ] ) {
					seed[ j ] = !( matches[ j ] = seed[ j ] );
				}
			}
		} );
	} );
}

/**
 * Checks a node for validity as a Sizzle context
 * @param {Element|Object=} context
 * @returns {Element|Object|Boolean} The input node if acceptable, otherwise a falsy value
 */
function testContext( context ) {
	return context && typeof context.getElementsByTagName !== "undefined" && context;
}

// Expose support vars for convenience
support = Sizzle.support = {};

/**
 * Detects XML nodes
 * @param {Element|Object} elem An element or a document
 * @returns {Boolean} True iff elem is a non-HTML XML node
 */
isXML = Sizzle.isXML = function( elem ) {
	var namespace = elem && elem.namespaceURI,
		docElem = elem && ( elem.ownerDocument || elem ).documentElement;

	// Support: IE <=8
	// Assume HTML when documentElement doesn't yet exist, such as inside loading iframes
	// https://bugs.jquery.com/ticket/4833
	return !rhtml.test( namespace || docElem && docElem.nodeName || "HTML" );
};

/**
 * Sets document-related variables once based on the current document
 * @param {Element|Object} [doc] An element or document object to use to set the document
 * @returns {Object} Returns the current document
 */
setDocument = Sizzle.setDocument = function( node ) {
	var hasCompare, subWindow,
		doc = node ? node.ownerDocument || node : preferredDoc;

	// Return early if doc is invalid or already selected
	// Support: IE 11+, Edge 17 - 18+
	// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
	// two documents; shallow comparisons work.
	// eslint-disable-next-line eqeqeq
	if ( doc == document || doc.nodeType !== 9 || !doc.documentElement ) {
		return document;
	}

	// Update global variables
	document = doc;
	docElem = document.documentElement;
	documentIsHTML = !isXML( document );

	// Support: IE 9 - 11+, Edge 12 - 18+
	// Accessing iframe documents after unload throws "permission denied" errors (jQuery #13936)
	// Support: IE 11+, Edge 17 - 18+
	// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
	// two documents; shallow comparisons work.
	// eslint-disable-next-line eqeqeq
	if ( preferredDoc != document &&
		( subWindow = document.defaultView ) && subWindow.top !== subWindow ) {

		// Support: IE 11, Edge
		if ( subWindow.addEventListener ) {
			subWindow.addEventListener( "unload", unloadHandler, false );

		// Support: IE 9 - 10 only
		} else if ( subWindow.attachEvent ) {
			subWindow.attachEvent( "onunload", unloadHandler );
		}
	}

	// Support: IE 8 - 11+, Edge 12 - 18+, Chrome <=16 - 25 only, Firefox <=3.6 - 31 only,
	// Safari 4 - 5 only, Opera <=11.6 - 12.x only
	// IE/Edge & older browsers don't support the :scope pseudo-class.
	// Support: Safari 6.0 only
	// Safari 6.0 supports :scope but it's an alias of :root there.
	support.scope = assert( function( el ) {
		docElem.appendChild( el ).appendChild( document.createElement( "div" ) );
		return typeof el.querySelectorAll !== "undefined" &&
			!el.querySelectorAll( ":scope fieldset div" ).length;
	} );

	// Support: Chrome 105+, Firefox 104+, Safari 15.4+
	// Make sure forgiving mode is not used in `CSS.supports( "selector(...)" )`.
	//
	// `:is()` uses a forgiving selector list as an argument and is widely
	// implemented, so it's a good one to test against.
	support.cssSupportsSelector = assert( function() {
		/* eslint-disable no-undef */

		return CSS.supports( "selector(*)" ) &&

			// Support: Firefox 78-81 only
			// In old Firefox, `:is()` didn't use forgiving parsing. In that case,
			// fail this test as there's no selector to test against that.
			// `CSS.supports` uses unforgiving parsing
			document.querySelectorAll( ":is(:jqfake)" ) &&

			// `*` is needed as Safari & newer Chrome implemented something in between
			// for `:has()` - it throws in `qSA` if it only contains an unsupported
			// argument but multiple ones, one of which is supported, are fine.
			// We want to play safe in case `:is()` gets the same treatment.
			!CSS.supports( "selector(:is(*,:jqfake))" );

		/* eslint-enable */
	} );

	/* Attributes
	---------------------------------------------------------------------- */

	// Support: IE<8
	// Verify that getAttribute really returns attributes and not properties
	// (excepting IE8 booleans)
	support.attributes = assert( function( el ) {
		el.className = "i";
		return !el.getAttribute( "className" );
	} );

	/* getElement(s)By*
	---------------------------------------------------------------------- */

	// Check if getElementsByTagName("*") returns only elements
	support.getElementsByTagName = assert( function( el ) {
		el.appendChild( document.createComment( "" ) );
		return !el.getElementsByTagName( "*" ).length;
	} );

	// Support: IE<9
	support.getElementsByClassName = rnative.test( document.getElementsByClassName );

	// Support: IE<10
	// Check if getElementById returns elements by name
	// The broken getElementById methods don't pick up programmatically-set names,
	// so use a roundabout getElementsByName test
	support.getById = assert( function( el ) {
		docElem.appendChild( el ).id = expando;
		return !document.getElementsByName || !document.getElementsByName( expando ).length;
	} );

	// ID filter and find
	if ( support.getById ) {
		Expr.filter[ "ID" ] = function( id ) {
			var attrId = id.replace( runescape, funescape );
			return function( elem ) {
				return elem.getAttribute( "id" ) === attrId;
			};
		};
		Expr.find[ "ID" ] = function( id, context ) {
			if ( typeof context.getElementById !== "undefined" && documentIsHTML ) {
				var elem = context.getElementById( id );
				return elem ? [ elem ] : [];
			}
		};
	} else {
		Expr.filter[ "ID" ] =  function( id ) {
			var attrId = id.replace( runescape, funescape );
			return function( elem ) {
				var node = typeof elem.getAttributeNode !== "undefined" &&
					elem.getAttributeNode( "id" );
				return node && node.value === attrId;
			};
		};

		// Support: IE 6 - 7 only
		// getElementById is not reliable as a find shortcut
		Expr.find[ "ID" ] = function( id, context ) {
			if ( typeof context.getElementById !== "undefined" && documentIsHTML ) {
				var node, i, elems,
					elem = context.getElementById( id );

				if ( elem ) {

					// Verify the id attribute
					node = elem.getAttributeNode( "id" );
					if ( node && node.value === id ) {
						return [ elem ];
					}

					// Fall back on getElementsByName
					elems = context.getElementsByName( id );
					i = 0;
					while ( ( elem = elems[ i++ ] ) ) {
						node = elem.getAttributeNode( "id" );
						if ( node && node.value === id ) {
							return [ elem ];
						}
					}
				}

				return [];
			}
		};
	}

	// Tag
	Expr.find[ "TAG" ] = support.getElementsByTagName ?
		function( tag, context ) {
			if ( typeof context.getElementsByTagName !== "undefined" ) {
				return context.getElementsByTagName( tag );

			// DocumentFragment nodes don't have gEBTN
			} else if ( support.qsa ) {
				return context.querySelectorAll( tag );
			}
		} :

		function( tag, context ) {
			var elem,
				tmp = [],
				i = 0,

				// By happy coincidence, a (broken) gEBTN appears on DocumentFragment nodes too
				results = context.getElementsByTagName( tag );

			// Filter out possible comments
			if ( tag === "*" ) {
				while ( ( elem = results[ i++ ] ) ) {
					if ( elem.nodeType === 1 ) {
						tmp.push( elem );
					}
				}

				return tmp;
			}
			return results;
		};

	// Class
	Expr.find[ "CLASS" ] = support.getElementsByClassName && function( className, context ) {
		if ( typeof context.getElementsByClassName !== "undefined" && documentIsHTML ) {
			return context.getElementsByClassName( className );
		}
	};

	/* QSA/matchesSelector
	---------------------------------------------------------------------- */

	// QSA and matchesSelector support

	// matchesSelector(:active) reports false when true (IE9/Opera 11.5)
	rbuggyMatches = [];

	// qSa(:focus) reports false when true (Chrome 21)
	// We allow this because of a bug in IE8/9 that throws an error
	// whenever `document.activeElement` is accessed on an iframe
	// So, we allow :focus to pass through QSA all the time to avoid the IE error
	// See https://bugs.jquery.com/ticket/13378
	rbuggyQSA = [];

	if ( ( support.qsa = rnative.test( document.querySelectorAll ) ) ) {

		// Build QSA regex
		// Regex strategy adopted from Diego Perini
		assert( function( el ) {

			var input;

			// Select is set to empty string on purpose
			// This is to test IE's treatment of not explicitly
			// setting a boolean content attribute,
			// since its presence should be enough
			// https://bugs.jquery.com/ticket/12359
			docElem.appendChild( el ).innerHTML = "<a id='" + expando + "'></a>" +
				"<select id='" + expando + "-\r\\' msallowcapture=''>" +
				"<option selected=''></option></select>";

			// Support: IE8, Opera 11-12.16
			// Nothing should be selected when empty strings follow ^= or $= or *=
			// The test attribute must be unknown in Opera but "safe" for WinRT
			// https://msdn.microsoft.com/en-us/library/ie/hh465388.aspx#attribute_section
			if ( el.querySelectorAll( "[msallowcapture^='']" ).length ) {
				rbuggyQSA.push( "[*^$]=" + whitespace + "*(?:''|\"\")" );
			}

			// Support: IE8
			// Boolean attributes and "value" are not treated correctly
			if ( !el.querySelectorAll( "[selected]" ).length ) {
				rbuggyQSA.push( "\\[" + whitespace + "*(?:value|" + booleans + ")" );
			}

			// Support: Chrome<29, Android<4.4, Safari<7.0+, iOS<7.0+, PhantomJS<1.9.8+
			if ( !el.querySelectorAll( "[id~=" + expando + "-]" ).length ) {
				rbuggyQSA.push( "~=" );
			}

			// Support: IE 11+, Edge 15 - 18+
			// IE 11/Edge don't find elements on a `[name='']` query in some cases.
			// Adding a temporary attribute to the document before the selection works
			// around the issue.
			// Interestingly, IE 10 & older don't seem to have the issue.
			input = document.createElement( "input" );
			input.setAttribute( "name", "" );
			el.appendChild( input );
			if ( !el.querySelectorAll( "[name='']" ).length ) {
				rbuggyQSA.push( "\\[" + whitespace + "*name" + whitespace + "*=" +
					whitespace + "*(?:''|\"\")" );
			}

			// Webkit/Opera - :checked should return selected option elements
			// http://www.w3.org/TR/2011/REC-css3-selectors-20110929/#checked
			// IE8 throws error here and will not see later tests
			if ( !el.querySelectorAll( ":checked" ).length ) {
				rbuggyQSA.push( ":checked" );
			}

			// Support: Safari 8+, iOS 8+
			// https://bugs.webkit.org/show_bug.cgi?id=136851
			// In-page `selector#id sibling-combinator selector` fails
			if ( !el.querySelectorAll( "a#" + expando + "+*" ).length ) {
				rbuggyQSA.push( ".#.+[+~]" );
			}

			// Support: Firefox <=3.6 - 5 only
			// Old Firefox doesn't throw on a badly-escaped identifier.
			el.querySelectorAll( "\\\f" );
			rbuggyQSA.push( "[\\r\\n\\f]" );
		} );

		assert( function( el ) {
			el.innerHTML = "<a href='' disabled='disabled'></a>" +
				"<select disabled='disabled'><option/></select>";

			// Support: Windows 8 Native Apps
			// The type and name attributes are restricted during .innerHTML assignment
			var input = document.createElement( "input" );
			input.setAttribute( "type", "hidden" );
			el.appendChild( input ).setAttribute( "name", "D" );

			// Support: IE8
			// Enforce case-sensitivity of name attribute
			if ( el.querySelectorAll( "[name=d]" ).length ) {
				rbuggyQSA.push( "name" + whitespace + "*[*^$|!~]?=" );
			}

			// FF 3.5 - :enabled/:disabled and hidden elements (hidden elements are still enabled)
			// IE8 throws error here and will not see later tests
			if ( el.querySelectorAll( ":enabled" ).length !== 2 ) {
				rbuggyQSA.push( ":enabled", ":disabled" );
			}

			// Support: IE9-11+
			// IE's :disabled selector does not pick up the children of disabled fieldsets
			docElem.appendChild( el ).disabled = true;
			if ( el.querySelectorAll( ":disabled" ).length !== 2 ) {
				rbuggyQSA.push( ":enabled", ":disabled" );
			}

			// Support: Opera 10 - 11 only
			// Opera 10-11 does not throw on post-comma invalid pseudos
			el.querySelectorAll( "*,:x" );
			rbuggyQSA.push( ",.*:" );
		} );
	}

	if ( ( support.matchesSelector = rnative.test( ( matches = docElem.matches ||
		docElem.webkitMatchesSelector ||
		docElem.mozMatchesSelector ||
		docElem.oMatchesSelector ||
		docElem.msMatchesSelector ) ) ) ) {

		assert( function( el ) {

			// Check to see if it's possible to do matchesSelector
			// on a disconnected node (IE 9)
			support.disconnectedMatch = matches.call( el, "*" );

			// This should fail with an exception
			// Gecko does not error, returns false instead
			matches.call( el, "[s!='']:x" );
			rbuggyMatches.push( "!=", pseudos );
		} );
	}

	if ( !support.cssSupportsSelector ) {

		// Support: Chrome 105+, Safari 15.4+
		// `:has()` uses a forgiving selector list as an argument so our regular
		// `try-catch` mechanism fails to catch `:has()` with arguments not supported
		// natively like `:has(:contains("Foo"))`. Where supported & spec-compliant,
		// we now use `CSS.supports("selector(:is(SELECTOR_TO_BE_TESTED))")`, but
		// outside that we mark `:has` as buggy.
		rbuggyQSA.push( ":has" );
	}

	rbuggyQSA = rbuggyQSA.length && new RegExp( rbuggyQSA.join( "|" ) );
	rbuggyMatches = rbuggyMatches.length && new RegExp( rbuggyMatches.join( "|" ) );

	/* Contains
	---------------------------------------------------------------------- */
	hasCompare = rnative.test( docElem.compareDocumentPosition );

	// Element contains another
	// Purposefully self-exclusive
	// As in, an element does not contain itself
	contains = hasCompare || rnative.test( docElem.contains ) ?
		function( a, b ) {

			// Support: IE <9 only
			// IE doesn't have `contains` on `document` so we need to check for
			// `documentElement` presence.
			// We need to fall back to `a` when `documentElement` is missing
			// as `ownerDocument` of elements within `<template/>` may have
			// a null one - a default behavior of all modern browsers.
			var adown = a.nodeType === 9 && a.documentElement || a,
				bup = b && b.parentNode;
			return a === bup || !!( bup && bup.nodeType === 1 && (
				adown.contains ?
					adown.contains( bup ) :
					a.compareDocumentPosition && a.compareDocumentPosition( bup ) & 16
			) );
		} :
		function( a, b ) {
			if ( b ) {
				while ( ( b = b.parentNode ) ) {
					if ( b === a ) {
						return true;
					}
				}
			}
			return false;
		};

	/* Sorting
	---------------------------------------------------------------------- */

	// Document order sorting
	sortOrder = hasCompare ?
	function( a, b ) {

		// Flag for duplicate removal
		if ( a === b ) {
			hasDuplicate = true;
			return 0;
		}

		// Sort on method existence if only one input has compareDocumentPosition
		var compare = !a.compareDocumentPosition - !b.compareDocumentPosition;
		if ( compare ) {
			return compare;
		}

		// Calculate position if both inputs belong to the same document
		// Support: IE 11+, Edge 17 - 18+
		// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
		// two documents; shallow comparisons work.
		// eslint-disable-next-line eqeqeq
		compare = ( a.ownerDocument || a ) == ( b.ownerDocument || b ) ?
			a.compareDocumentPosition( b ) :

			// Otherwise we know they are disconnected
			1;

		// Disconnected nodes
		if ( compare & 1 ||
			( !support.sortDetached && b.compareDocumentPosition( a ) === compare ) ) {

			// Choose the first element that is related to our preferred document
			// Support: IE 11+, Edge 17 - 18+
			// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
			// two documents; shallow comparisons work.
			// eslint-disable-next-line eqeqeq
			if ( a == document || a.ownerDocument == preferredDoc &&
				contains( preferredDoc, a ) ) {
				return -1;
			}

			// Support: IE 11+, Edge 17 - 18+
			// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
			// two documents; shallow comparisons work.
			// eslint-disable-next-line eqeqeq
			if ( b == document || b.ownerDocument == preferredDoc &&
				contains( preferredDoc, b ) ) {
				return 1;
			}

			// Maintain original order
			return sortInput ?
				( indexOf( sortInput, a ) - indexOf( sortInput, b ) ) :
				0;
		}

		return compare & 4 ? -1 : 1;
	} :
	function( a, b ) {

		// Exit early if the nodes are identical
		if ( a === b ) {
			hasDuplicate = true;
			return 0;
		}

		var cur,
			i = 0,
			aup = a.parentNode,
			bup = b.parentNode,
			ap = [ a ],
			bp = [ b ];

		// Parentless nodes are either documents or disconnected
		if ( !aup || !bup ) {

			// Support: IE 11+, Edge 17 - 18+
			// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
			// two documents; shallow comparisons work.
			/* eslint-disable eqeqeq */
			return a == document ? -1 :
				b == document ? 1 :
				/* eslint-enable eqeqeq */
				aup ? -1 :
				bup ? 1 :
				sortInput ?
				( indexOf( sortInput, a ) - indexOf( sortInput, b ) ) :
				0;

		// If the nodes are siblings, we can do a quick check
		} else if ( aup === bup ) {
			return siblingCheck( a, b );
		}

		// Otherwise we need full lists of their ancestors for comparison
		cur = a;
		while ( ( cur = cur.parentNode ) ) {
			ap.unshift( cur );
		}
		cur = b;
		while ( ( cur = cur.parentNode ) ) {
			bp.unshift( cur );
		}

		// Walk down the tree looking for a discrepancy
		while ( ap[ i ] === bp[ i ] ) {
			i++;
		}

		return i ?

			// Do a sibling check if the nodes have a common ancestor
			siblingCheck( ap[ i ], bp[ i ] ) :

			// Otherwise nodes in our document sort first
			// Support: IE 11+, Edge 17 - 18+
			// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
			// two documents; shallow comparisons work.
			/* eslint-disable eqeqeq */
			ap[ i ] == preferredDoc ? -1 :
			bp[ i ] == preferredDoc ? 1 :
			/* eslint-enable eqeqeq */
			0;
	};

	return document;
};

Sizzle.matches = function( expr, elements ) {
	return Sizzle( expr, null, null, elements );
};

Sizzle.matchesSelector = function( elem, expr ) {
	setDocument( elem );

	if ( support.matchesSelector && documentIsHTML &&
		!nonnativeSelectorCache[ expr + " " ] &&
		( !rbuggyMatches || !rbuggyMatches.test( expr ) ) &&
		( !rbuggyQSA     || !rbuggyQSA.test( expr ) ) ) {

		try {
			var ret = matches.call( elem, expr );

			// IE 9's matchesSelector returns false on disconnected nodes
			if ( ret || support.disconnectedMatch ||

				// As well, disconnected nodes are said to be in a document
				// fragment in IE 9
				elem.document && elem.document.nodeType !== 11 ) {
				return ret;
			}
		} catch ( e ) {
			nonnativeSelectorCache( expr, true );
		}
	}

	return Sizzle( expr, document, null, [ elem ] ).length > 0;
};

Sizzle.contains = function( context, elem ) {

	// Set document vars if needed
	// Support: IE 11+, Edge 17 - 18+
	// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
	// two documents; shallow comparisons work.
	// eslint-disable-next-line eqeqeq
	if ( ( context.ownerDocument || context ) != document ) {
		setDocument( context );
	}
	return contains( context, elem );
};

Sizzle.attr = function( elem, name ) {

	// Set document vars if needed
	// Support: IE 11+, Edge 17 - 18+
	// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
	// two documents; shallow comparisons work.
	// eslint-disable-next-line eqeqeq
	if ( ( elem.ownerDocument || elem ) != document ) {
		setDocument( elem );
	}

	var fn = Expr.attrHandle[ name.toLowerCase() ],

		// Don't get fooled by Object.prototype properties (jQuery #13807)
		val = fn && hasOwn.call( Expr.attrHandle, name.toLowerCase() ) ?
			fn( elem, name, !documentIsHTML ) :
			undefined;

	return val !== undefined ?
		val :
		support.attributes || !documentIsHTML ?
			elem.getAttribute( name ) :
			( val = elem.getAttributeNode( name ) ) && val.specified ?
				val.value :
				null;
};

Sizzle.escape = function( sel ) {
	return ( sel + "" ).replace( rcssescape, fcssescape );
};

Sizzle.error = function( msg ) {
	throw new Error( "Syntax error, unrecognized expression: " + msg );
};

/**
 * Document sorting and removing duplicates
 * @param {ArrayLike} results
 */
Sizzle.uniqueSort = function( results ) {
	var elem,
		duplicates = [],
		j = 0,
		i = 0;

	// Unless we *know* we can detect duplicates, assume their presence
	hasDuplicate = !support.detectDuplicates;
	sortInput = !support.sortStable && results.slice( 0 );
	results.sort( sortOrder );

	if ( hasDuplicate ) {
		while ( ( elem = results[ i++ ] ) ) {
			if ( elem === results[ i ] ) {
				j = duplicates.push( i );
			}
		}
		while ( j-- ) {
			results.splice( duplicates[ j ], 1 );
		}
	}

	// Clear input after sorting to release objects
	// See https://github.com/jquery/sizzle/pull/225
	sortInput = null;

	return results;
};

/**
 * Utility function for retrieving the text value of an array of DOM nodes
 * @param {Array|Element} elem
 */
getText = Sizzle.getText = function( elem ) {
	var node,
		ret = "",
		i = 0,
		nodeType = elem.nodeType;

	if ( !nodeType ) {

		// If no nodeType, this is expected to be an array
		while ( ( node = elem[ i++ ] ) ) {

			// Do not traverse comment nodes
			ret += getText( node );
		}
	} else if ( nodeType === 1 || nodeType === 9 || nodeType === 11 ) {

		// Use textContent for elements
		// innerText usage removed for consistency of new lines (jQuery #11153)
		if ( typeof elem.textContent === "string" ) {
			return elem.textContent;
		} else {

			// Traverse its children
			for ( elem = elem.firstChild; elem; elem = elem.nextSibling ) {
				ret += getText( elem );
			}
		}
	} else if ( nodeType === 3 || nodeType === 4 ) {
		return elem.nodeValue;
	}

	// Do not include comment or processing instruction nodes

	return ret;
};

Expr = Sizzle.selectors = {

	// Can be adjusted by the user
	cacheLength: 50,

	createPseudo: markFunction,

	match: matchExpr,

	attrHandle: {},

	find: {},

	relative: {
		">": { dir: "parentNode", first: true },
		" ": { dir: "parentNode" },
		"+": { dir: "previousSibling", first: true },
		"~": { dir: "previousSibling" }
	},

	preFilter: {
		"ATTR": function( match ) {
			match[ 1 ] = match[ 1 ].replace( runescape, funescape );

			// Move the given value to match[3] whether quoted or unquoted
			match[ 3 ] = ( match[ 3 ] || match[ 4 ] ||
				match[ 5 ] || "" ).replace( runescape, funescape );

			if ( match[ 2 ] === "~=" ) {
				match[ 3 ] = " " + match[ 3 ] + " ";
			}

			return match.slice( 0, 4 );
		},

		"CHILD": function( match ) {

			/* matches from matchExpr["CHILD"]
				1 type (only|nth|...)
				2 what (child|of-type)
				3 argument (even|odd|\d*|\d*n([+-]\d+)?|...)
				4 xn-component of xn+y argument ([+-]?\d*n|)
				5 sign of xn-component
				6 x of xn-component
				7 sign of y-component
				8 y of y-component
			*/
			match[ 1 ] = match[ 1 ].toLowerCase();

			if ( match[ 1 ].slice( 0, 3 ) === "nth" ) {

				// nth-* requires argument
				if ( !match[ 3 ] ) {
					Sizzle.error( match[ 0 ] );
				}

				// numeric x and y parameters for Expr.filter.CHILD
				// remember that false/true cast respectively to 0/1
				match[ 4 ] = +( match[ 4 ] ?
					match[ 5 ] + ( match[ 6 ] || 1 ) :
					2 * ( match[ 3 ] === "even" || match[ 3 ] === "odd" ) );
				match[ 5 ] = +( ( match[ 7 ] + match[ 8 ] ) || match[ 3 ] === "odd" );

				// other types prohibit arguments
			} else if ( match[ 3 ] ) {
				Sizzle.error( match[ 0 ] );
			}

			return match;
		},

		"PSEUDO": function( match ) {
			var excess,
				unquoted = !match[ 6 ] && match[ 2 ];

			if ( matchExpr[ "CHILD" ].test( match[ 0 ] ) ) {
				return null;
			}

			// Accept quoted arguments as-is
			if ( match[ 3 ] ) {
				match[ 2 ] = match[ 4 ] || match[ 5 ] || "";

			// Strip excess characters from unquoted arguments
			} else if ( unquoted && rpseudo.test( unquoted ) &&

				// Get excess from tokenize (recursively)
				( excess = tokenize( unquoted, true ) ) &&

				// advance to the next closing parenthesis
				( excess = unquoted.indexOf( ")", unquoted.length - excess ) - unquoted.length ) ) {

				// excess is a negative index
				match[ 0 ] = match[ 0 ].slice( 0, excess );
				match[ 2 ] = unquoted.slice( 0, excess );
			}

			// Return only captures needed by the pseudo filter method (type and argument)
			return match.slice( 0, 3 );
		}
	},

	filter: {

		"TAG": function( nodeNameSelector ) {
			var nodeName = nodeNameSelector.replace( runescape, funescape ).toLowerCase();
			return nodeNameSelector === "*" ?
				function() {
					return true;
				} :
				function( elem ) {
					return elem.nodeName && elem.nodeName.toLowerCase() === nodeName;
				};
		},

		"CLASS": function( className ) {
			var pattern = classCache[ className + " " ];

			return pattern ||
				( pattern = new RegExp( "(^|" + whitespace +
					")" + className + "(" + whitespace + "|$)" ) ) && classCache(
						className, function( elem ) {
							return pattern.test(
								typeof elem.className === "string" && elem.className ||
								typeof elem.getAttribute !== "undefined" &&
									elem.getAttribute( "class" ) ||
								""
							);
				} );
		},

		"ATTR": function( name, operator, check ) {
			return function( elem ) {
				var result = Sizzle.attr( elem, name );

				if ( result == null ) {
					return operator === "!=";
				}
				if ( !operator ) {
					return true;
				}

				result += "";

				/* eslint-disable max-len */

				return operator === "=" ? result === check :
					operator === "!=" ? result !== check :
					operator === "^=" ? check && result.indexOf( check ) === 0 :
					operator === "*=" ? check && result.indexOf( check ) > -1 :
					operator === "$=" ? check && result.slice( -check.length ) === check :
					operator === "~=" ? ( " " + result.replace( rwhitespace, " " ) + " " ).indexOf( check ) > -1 :
					operator === "|=" ? result === check || result.slice( 0, check.length + 1 ) === check + "-" :
					false;
				/* eslint-enable max-len */

			};
		},

		"CHILD": function( type, what, _argument, first, last ) {
			var simple = type.slice( 0, 3 ) !== "nth",
				forward = type.slice( -4 ) !== "last",
				ofType = what === "of-type";

			return first === 1 && last === 0 ?

				// Shortcut for :nth-*(n)
				function( elem ) {
					return !!elem.parentNode;
				} :

				function( elem, _context, xml ) {
					var cache, uniqueCache, outerCache, node, nodeIndex, start,
						dir = simple !== forward ? "nextSibling" : "previousSibling",
						parent = elem.parentNode,
						name = ofType && elem.nodeName.toLowerCase(),
						useCache = !xml && !ofType,
						diff = false;

					if ( parent ) {

						// :(first|last|only)-(child|of-type)
						if ( simple ) {
							while ( dir ) {
								node = elem;
								while ( ( node = node[ dir ] ) ) {
									if ( ofType ?
										node.nodeName.toLowerCase() === name :
										node.nodeType === 1 ) {

										return false;
									}
								}

								// Reverse direction for :only-* (if we haven't yet done so)
								start = dir = type === "only" && !start && "nextSibling";
							}
							return true;
						}

						start = [ forward ? parent.firstChild : parent.lastChild ];

						// non-xml :nth-child(...) stores cache data on `parent`
						if ( forward && useCache ) {

							// Seek `elem` from a previously-cached index

							// ...in a gzip-friendly way
							node = parent;
							outerCache = node[ expando ] || ( node[ expando ] = {} );

							// Support: IE <9 only
							// Defend against cloned attroperties (jQuery gh-1709)
							uniqueCache = outerCache[ node.uniqueID ] ||
								( outerCache[ node.uniqueID ] = {} );

							cache = uniqueCache[ type ] || [];
							nodeIndex = cache[ 0 ] === dirruns && cache[ 1 ];
							diff = nodeIndex && cache[ 2 ];
							node = nodeIndex && parent.childNodes[ nodeIndex ];

							while ( ( node = ++nodeIndex && node && node[ dir ] ||

								// Fallback to seeking `elem` from the start
								( diff = nodeIndex = 0 ) || start.pop() ) ) {

								// When found, cache indexes on `parent` and break
								if ( node.nodeType === 1 && ++diff && node === elem ) {
									uniqueCache[ type ] = [ dirruns, nodeIndex, diff ];
									break;
								}
							}

						} else {

							// Use previously-cached element index if available
							if ( useCache ) {

								// ...in a gzip-friendly way
								node = elem;
								outerCache = node[ expando ] || ( node[ expando ] = {} );

								// Support: IE <9 only
								// Defend against cloned attroperties (jQuery gh-1709)
								uniqueCache = outerCache[ node.uniqueID ] ||
									( outerCache[ node.uniqueID ] = {} );

								cache = uniqueCache[ type ] || [];
								nodeIndex = cache[ 0 ] === dirruns && cache[ 1 ];
								diff = nodeIndex;
							}

							// xml :nth-child(...)
							// or :nth-last-child(...) or :nth(-last)?-of-type(...)
							if ( diff === false ) {

								// Use the same loop as above to seek `elem` from the start
								while ( ( node = ++nodeIndex && node && node[ dir ] ||
									( diff = nodeIndex = 0 ) || start.pop() ) ) {

									if ( ( ofType ?
										node.nodeName.toLowerCase() === name :
										node.nodeType === 1 ) &&
										++diff ) {

										// Cache the index of each encountered element
										if ( useCache ) {
											outerCache = node[ expando ] ||
												( node[ expando ] = {} );

											// Support: IE <9 only
											// Defend against cloned attroperties (jQuery gh-1709)
											uniqueCache = outerCache[ node.uniqueID ] ||
												( outerCache[ node.uniqueID ] = {} );

											uniqueCache[ type ] = [ dirruns, diff ];
										}

										if ( node === elem ) {
											break;
										}
									}
								}
							}
						}

						// Incorporate the offset, then check against cycle size
						diff -= last;
						return diff === first || ( diff % first === 0 && diff / first >= 0 );
					}
				};
		},

		"PSEUDO": function( pseudo, argument ) {

			// pseudo-class names are case-insensitive
			// http://www.w3.org/TR/selectors/#pseudo-classes
			// Prioritize by case sensitivity in case custom pseudos are added with uppercase letters
			// Remember that setFilters inherits from pseudos
			var args,
				fn = Expr.pseudos[ pseudo ] || Expr.setFilters[ pseudo.toLowerCase() ] ||
					Sizzle.error( "unsupported pseudo: " + pseudo );

			// The user may use createPseudo to indicate that
			// arguments are needed to create the filter function
			// just as Sizzle does
			if ( fn[ expando ] ) {
				return fn( argument );
			}

			// But maintain support for old signatures
			if ( fn.length > 1 ) {
				args = [ pseudo, pseudo, "", argument ];
				return Expr.setFilters.hasOwnProperty( pseudo.toLowerCase() ) ?
					markFunction( function( seed, matches ) {
						var idx,
							matched = fn( seed, argument ),
							i = matched.length;
						while ( i-- ) {
							idx = indexOf( seed, matched[ i ] );
							seed[ idx ] = !( matches[ idx ] = matched[ i ] );
						}
					} ) :
					function( elem ) {
						return fn( elem, 0, args );
					};
			}

			return fn;
		}
	},

	pseudos: {

		// Potentially complex pseudos
		"not": markFunction( function( selector ) {

			// Trim the selector passed to compile
			// to avoid treating leading and trailing
			// spaces as combinators
			var input = [],
				results = [],
				matcher = compile( selector.replace( rtrim, "$1" ) );

			return matcher[ expando ] ?
				markFunction( function( seed, matches, _context, xml ) {
					var elem,
						unmatched = matcher( seed, null, xml, [] ),
						i = seed.length;

					// Match elements unmatched by `matcher`
					while ( i-- ) {
						if ( ( elem = unmatched[ i ] ) ) {
							seed[ i ] = !( matches[ i ] = elem );
						}
					}
				} ) :
				function( elem, _context, xml ) {
					input[ 0 ] = elem;
					matcher( input, null, xml, results );

					// Don't keep the element (issue #299)
					input[ 0 ] = null;
					return !results.pop();
				};
		} ),

		"has": markFunction( function( selector ) {
			return function( elem ) {
				return Sizzle( selector, elem ).length > 0;
			};
		} ),

		"contains": markFunction( function( text ) {
			text = text.replace( runescape, funescape );
			return function( elem ) {
				return ( elem.textContent || getText( elem ) ).indexOf( text ) > -1;
			};
		} ),

		// "Whether an element is represented by a :lang() selector
		// is based solely on the element's language value
		// being equal to the identifier C,
		// or beginning with the identifier C immediately followed by "-".
		// The matching of C against the element's language value is performed case-insensitively.
		// The identifier C does not have to be a valid language name."
		// http://www.w3.org/TR/selectors/#lang-pseudo
		"lang": markFunction( function( lang ) {

			// lang value must be a valid identifier
			if ( !ridentifier.test( lang || "" ) ) {
				Sizzle.error( "unsupported lang: " + lang );
			}
			lang = lang.replace( runescape, funescape ).toLowerCase();
			return function( elem ) {
				var elemLang;
				do {
					if ( ( elemLang = documentIsHTML ?
						elem.lang :
						elem.getAttribute( "xml:lang" ) || elem.getAttribute( "lang" ) ) ) {

						elemLang = elemLang.toLowerCase();
						return elemLang === lang || elemLang.indexOf( lang + "-" ) === 0;
					}
				} while ( ( elem = elem.parentNode ) && elem.nodeType === 1 );
				return false;
			};
		} ),

		// Miscellaneous
		"target": function( elem ) {
			var hash = window.location && window.location.hash;
			return hash && hash.slice( 1 ) === elem.id;
		},

		"root": function( elem ) {
			return elem === docElem;
		},

		"focus": function( elem ) {
			return elem === document.activeElement &&
				( !document.hasFocus || document.hasFocus() ) &&
				!!( elem.type || elem.href || ~elem.tabIndex );
		},

		// Boolean properties
		"enabled": createDisabledPseudo( false ),
		"disabled": createDisabledPseudo( true ),

		"checked": function( elem ) {

			// In CSS3, :checked should return both checked and selected elements
			// http://www.w3.org/TR/2011/REC-css3-selectors-20110929/#checked
			var nodeName = elem.nodeName.toLowerCase();
			return ( nodeName === "input" && !!elem.checked ) ||
				( nodeName === "option" && !!elem.selected );
		},

		"selected": function( elem ) {

			// Accessing this property makes selected-by-default
			// options in Safari work properly
			if ( elem.parentNode ) {
				// eslint-disable-next-line no-unused-expressions
				elem.parentNode.selectedIndex;
			}

			return elem.selected === true;
		},

		// Contents
		"empty": function( elem ) {

			// http://www.w3.org/TR/selectors/#empty-pseudo
			// :empty is negated by element (1) or content nodes (text: 3; cdata: 4; entity ref: 5),
			//   but not by others (comment: 8; processing instruction: 7; etc.)
			// nodeType < 6 works because attributes (2) do not appear as children
			for ( elem = elem.firstChild; elem; elem = elem.nextSibling ) {
				if ( elem.nodeType < 6 ) {
					return false;
				}
			}
			return true;
		},

		"parent": function( elem ) {
			return !Expr.pseudos[ "empty" ]( elem );
		},

		// Element/input types
		"header": function( elem ) {
			return rheader.test( elem.nodeName );
		},

		"input": function( elem ) {
			return rinputs.test( elem.nodeName );
		},

		"button": function( elem ) {
			var name = elem.nodeName.toLowerCase();
			return name === "input" && elem.type === "button" || name === "button";
		},

		"text": function( elem ) {
			var attr;
			return elem.nodeName.toLowerCase() === "input" &&
				elem.type === "text" &&

				// Support: IE <10 only
				// New HTML5 attribute values (e.g., "search") appear with elem.type === "text"
				( ( attr = elem.getAttribute( "type" ) ) == null ||
					attr.toLowerCase() === "text" );
		},

		// Position-in-collection
		"first": createPositionalPseudo( function() {
			return [ 0 ];
		} ),

		"last": createPositionalPseudo( function( _matchIndexes, length ) {
			return [ length - 1 ];
		} ),

		"eq": createPositionalPseudo( function( _matchIndexes, length, argument ) {
			return [ argument < 0 ? argument + length : argument ];
		} ),

		"even": createPositionalPseudo( function( matchIndexes, length ) {
			var i = 0;
			for ( ; i < length; i += 2 ) {
				matchIndexes.push( i );
			}
			return matchIndexes;
		} ),

		"odd": createPositionalPseudo( function( matchIndexes, length ) {
			var i = 1;
			for ( ; i < length; i += 2 ) {
				matchIndexes.push( i );
			}
			return matchIndexes;
		} ),

		"lt": createPositionalPseudo( function( matchIndexes, length, argument ) {
			var i = argument < 0 ?
				argument + length :
				argument > length ?
					length :
					argument;
			for ( ; --i >= 0; ) {
				matchIndexes.push( i );
			}
			return matchIndexes;
		} ),

		"gt": createPositionalPseudo( function( matchIndexes, length, argument ) {
			var i = argument < 0 ? argument + length : argument;
			for ( ; ++i < length; ) {
				matchIndexes.push( i );
			}
			return matchIndexes;
		} )
	}
};

Expr.pseudos[ "nth" ] = Expr.pseudos[ "eq" ];

// Add button/input type pseudos
for ( i in { radio: true, checkbox: true, file: true, password: true, image: true } ) {
	Expr.pseudos[ i ] = createInputPseudo( i );
}
for ( i in { submit: true, reset: true } ) {
	Expr.pseudos[ i ] = createButtonPseudo( i );
}

// Easy API for creating new setFilters
function setFilters() {}
setFilters.prototype = Expr.filters = Expr.pseudos;
Expr.setFilters = new setFilters();

tokenize = Sizzle.tokenize = function( selector, parseOnly ) {
	var matched, match, tokens, type,
		soFar, groups, preFilters,
		cached = tokenCache[ selector + " " ];

	if ( cached ) {
		return parseOnly ? 0 : cached.slice( 0 );
	}

	soFar = selector;
	groups = [];
	preFilters = Expr.preFilter;

	while ( soFar ) {

		// Comma and first run
		if ( !matched || ( match = rcomma.exec( soFar ) ) ) {
			if ( match ) {

				// Don't consume trailing commas as valid
				soFar = soFar.slice( match[ 0 ].length ) || soFar;
			}
			groups.push( ( tokens = [] ) );
		}

		matched = false;

		// Combinators
		if ( ( match = rcombinators.exec( soFar ) ) ) {
			matched = match.shift();
			tokens.push( {
				value: matched,

				// Cast descendant combinators to space
				type: match[ 0 ].replace( rtrim, " " )
			} );
			soFar = soFar.slice( matched.length );
		}

		// Filters
		for ( type in Expr.filter ) {
			if ( ( match = matchExpr[ type ].exec( soFar ) ) && ( !preFilters[ type ] ||
				( match = preFilters[ type ]( match ) ) ) ) {
				matched = match.shift();
				tokens.push( {
					value: matched,
					type: type,
					matches: match
				} );
				soFar = soFar.slice( matched.length );
			}
		}

		if ( !matched ) {
			break;
		}
	}

	// Return the length of the invalid excess
	// if we're just parsing
	// Otherwise, throw an error or return tokens
	return parseOnly ?
		soFar.length :
		soFar ?
			Sizzle.error( selector ) :

			// Cache the tokens
			tokenCache( selector, groups ).slice( 0 );
};

function toSelector( tokens ) {
	var i = 0,
		len = tokens.length,
		selector = "";
	for ( ; i < len; i++ ) {
		selector += tokens[ i ].value;
	}
	return selector;
}

function addCombinator( matcher, combinator, base ) {
	var dir = combinator.dir,
		skip = combinator.next,
		key = skip || dir,
		checkNonElements = base && key === "parentNode",
		doneName = done++;

	return combinator.first ?

		// Check against closest ancestor/preceding element
		function( elem, context, xml ) {
			while ( ( elem = elem[ dir ] ) ) {
				if ( elem.nodeType === 1 || checkNonElements ) {
					return matcher( elem, context, xml );
				}
			}
			return false;
		} :

		// Check against all ancestor/preceding elements
		function( elem, context, xml ) {
			var oldCache, uniqueCache, outerCache,
				newCache = [ dirruns, doneName ];

			// We can't set arbitrary data on XML nodes, so they don't benefit from combinator caching
			if ( xml ) {
				while ( ( elem = elem[ dir ] ) ) {
					if ( elem.nodeType === 1 || checkNonElements ) {
						if ( matcher( elem, context, xml ) ) {
							return true;
						}
					}
				}
			} else {
				while ( ( elem = elem[ dir ] ) ) {
					if ( elem.nodeType === 1 || checkNonElements ) {
						outerCache = elem[ expando ] || ( elem[ expando ] = {} );

						// Support: IE <9 only
						// Defend against cloned attroperties (jQuery gh-1709)
						uniqueCache = outerCache[ elem.uniqueID ] ||
							( outerCache[ elem.uniqueID ] = {} );

						if ( skip && skip === elem.nodeName.toLowerCase() ) {
							elem = elem[ dir ] || elem;
						} else if ( ( oldCache = uniqueCache[ key ] ) &&
							oldCache[ 0 ] === dirruns && oldCache[ 1 ] === doneName ) {

							// Assign to newCache so results back-propagate to previous elements
							return ( newCache[ 2 ] = oldCache[ 2 ] );
						} else {

							// Reuse newcache so results back-propagate to previous elements
							uniqueCache[ key ] = newCache;

							// A match means we're done; a fail means we have to keep checking
							if ( ( newCache[ 2 ] = matcher( elem, context, xml ) ) ) {
								return true;
							}
						}
					}
				}
			}
			return false;
		};
}

function elementMatcher( matchers ) {
	return matchers.length > 1 ?
		function( elem, context, xml ) {
			var i = matchers.length;
			while ( i-- ) {
				if ( !matchers[ i ]( elem, context, xml ) ) {
					return false;
				}
			}
			return true;
		} :
		matchers[ 0 ];
}

function multipleContexts( selector, contexts, results ) {
	var i = 0,
		len = contexts.length;
	for ( ; i < len; i++ ) {
		Sizzle( selector, contexts[ i ], results );
	}
	return results;
}

function condense( unmatched, map, filter, context, xml ) {
	var elem,
		newUnmatched = [],
		i = 0,
		len = unmatched.length,
		mapped = map != null;

	for ( ; i < len; i++ ) {
		if ( ( elem = unmatched[ i ] ) ) {
			if ( !filter || filter( elem, context, xml ) ) {
				newUnmatched.push( elem );
				if ( mapped ) {
					map.push( i );
				}
			}
		}
	}

	return newUnmatched;
}

function setMatcher( preFilter, selector, matcher, postFilter, postFinder, postSelector ) {
	if ( postFilter && !postFilter[ expando ] ) {
		postFilter = setMatcher( postFilter );
	}
	if ( postFinder && !postFinder[ expando ] ) {
		postFinder = setMatcher( postFinder, postSelector );
	}
	return markFunction( function( seed, results, context, xml ) {
		var temp, i, elem,
			preMap = [],
			postMap = [],
			preexisting = results.length,

			// Get initial elements from seed or context
			elems = seed || multipleContexts(
				selector || "*",
				context.nodeType ? [ context ] : context,
				[]
			),

			// Prefilter to get matcher input, preserving a map for seed-results synchronization
			matcherIn = preFilter && ( seed || !selector ) ?
				condense( elems, preMap, preFilter, context, xml ) :
				elems,

			matcherOut = matcher ?

				// If we have a postFinder, or filtered seed, or non-seed postFilter or preexisting results,
				postFinder || ( seed ? preFilter : preexisting || postFilter ) ?

					// ...intermediate processing is necessary
					[] :

					// ...otherwise use results directly
					results :
				matcherIn;

		// Find primary matches
		if ( matcher ) {
			matcher( matcherIn, matcherOut, context, xml );
		}

		// Apply postFilter
		if ( postFilter ) {
			temp = condense( matcherOut, postMap );
			postFilter( temp, [], context, xml );

			// Un-match failing elements by moving them back to matcherIn
			i = temp.length;
			while ( i-- ) {
				if ( ( elem = temp[ i ] ) ) {
					matcherOut[ postMap[ i ] ] = !( matcherIn[ postMap[ i ] ] = elem );
				}
			}
		}

		if ( seed ) {
			if ( postFinder || preFilter ) {
				if ( postFinder ) {

					// Get the final matcherOut by condensing this intermediate into postFinder contexts
					temp = [];
					i = matcherOut.length;
					while ( i-- ) {
						if ( ( elem = matcherOut[ i ] ) ) {

							// Restore matcherIn since elem is not yet a final match
							temp.push( ( matcherIn[ i ] = elem ) );
						}
					}
					postFinder( null, ( matcherOut = [] ), temp, xml );
				}

				// Move matched elements from seed to results to keep them synchronized
				i = matcherOut.length;
				while ( i-- ) {
					if ( ( elem = matcherOut[ i ] ) &&
						( temp = postFinder ? indexOf( seed, elem ) : preMap[ i ] ) > -1 ) {

						seed[ temp ] = !( results[ temp ] = elem );
					}
				}
			}

		// Add elements to results, through postFinder if defined
		} else {
			matcherOut = condense(
				matcherOut === results ?
					matcherOut.splice( preexisting, matcherOut.length ) :
					matcherOut
			);
			if ( postFinder ) {
				postFinder( null, results, matcherOut, xml );
			} else {
				push.apply( results, matcherOut );
			}
		}
	} );
}

function matcherFromTokens( tokens ) {
	var checkContext, matcher, j,
		len = tokens.length,
		leadingRelative = Expr.relative[ tokens[ 0 ].type ],
		implicitRelative = leadingRelative || Expr.relative[ " " ],
		i = leadingRelative ? 1 : 0,

		// The foundational matcher ensures that elements are reachable from top-level context(s)
		matchContext = addCombinator( function( elem ) {
			return elem === checkContext;
		}, implicitRelative, true ),
		matchAnyContext = addCombinator( function( elem ) {
			return indexOf( checkContext, elem ) > -1;
		}, implicitRelative, true ),
		matchers = [ function( elem, context, xml ) {
			var ret = ( !leadingRelative && ( xml || context !== outermostContext ) ) || (
				( checkContext = context ).nodeType ?
					matchContext( elem, context, xml ) :
					matchAnyContext( elem, context, xml ) );

			// Avoid hanging onto element (issue #299)
			checkContext = null;
			return ret;
		} ];

	for ( ; i < len; i++ ) {
		if ( ( matcher = Expr.relative[ tokens[ i ].type ] ) ) {
			matchers = [ addCombinator( elementMatcher( matchers ), matcher ) ];
		} else {
			matcher = Expr.filter[ tokens[ i ].type ].apply( null, tokens[ i ].matches );

			// Return special upon seeing a positional matcher
			if ( matcher[ expando ] ) {

				// Find the next relative operator (if any) for proper handling
				j = ++i;
				for ( ; j < len; j++ ) {
					if ( Expr.relative[ tokens[ j ].type ] ) {
						break;
					}
				}
				return setMatcher(
					i > 1 && elementMatcher( matchers ),
					i > 1 && toSelector(

					// If the preceding token was a descendant combinator, insert an implicit any-element `*`
					tokens
						.slice( 0, i - 1 )
						.concat( { value: tokens[ i - 2 ].type === " " ? "*" : "" } )
					).replace( rtrim, "$1" ),
					matcher,
					i < j && matcherFromTokens( tokens.slice( i, j ) ),
					j < len && matcherFromTokens( ( tokens = tokens.slice( j ) ) ),
					j < len && toSelector( tokens )
				);
			}
			matchers.push( matcher );
		}
	}

	return elementMatcher( matchers );
}

function matcherFromGroupMatchers( elementMatchers, setMatchers ) {
	var bySet = setMatchers.length > 0,
		byElement = elementMatchers.length > 0,
		superMatcher = function( seed, context, xml, results, outermost ) {
			var elem, j, matcher,
				matchedCount = 0,
				i = "0",
				unmatched = seed && [],
				setMatched = [],
				contextBackup = outermostContext,

				// We must always have either seed elements or outermost context
				elems = seed || byElement && Expr.find[ "TAG" ]( "*", outermost ),

				// Use integer dirruns iff this is the outermost matcher
				dirrunsUnique = ( dirruns += contextBackup == null ? 1 : Math.random() || 0.1 ),
				len = elems.length;

			if ( outermost ) {

				// Support: IE 11+, Edge 17 - 18+
				// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
				// two documents; shallow comparisons work.
				// eslint-disable-next-line eqeqeq
				outermostContext = context == document || context || outermost;
			}

			// Add elements passing elementMatchers directly to results
			// Support: IE<9, Safari
			// Tolerate NodeList properties (IE: "length"; Safari: <number>) matching elements by id
			for ( ; i !== len && ( elem = elems[ i ] ) != null; i++ ) {
				if ( byElement && elem ) {
					j = 0;

					// Support: IE 11+, Edge 17 - 18+
					// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
					// two documents; shallow comparisons work.
					// eslint-disable-next-line eqeqeq
					if ( !context && elem.ownerDocument != document ) {
						setDocument( elem );
						xml = !documentIsHTML;
					}
					while ( ( matcher = elementMatchers[ j++ ] ) ) {
						if ( matcher( elem, context || document, xml ) ) {
							results.push( elem );
							break;
						}
					}
					if ( outermost ) {
						dirruns = dirrunsUnique;
					}
				}

				// Track unmatched elements for set filters
				if ( bySet ) {

					// They will have gone through all possible matchers
					if ( ( elem = !matcher && elem ) ) {
						matchedCount--;
					}

					// Lengthen the array for every element, matched or not
					if ( seed ) {
						unmatched.push( elem );
					}
				}
			}

			// `i` is now the count of elements visited above, and adding it to `matchedCount`
			// makes the latter nonnegative.
			matchedCount += i;

			// Apply set filters to unmatched elements
			// NOTE: This can be skipped if there are no unmatched elements (i.e., `matchedCount`
			// equals `i`), unless we didn't visit _any_ elements in the above loop because we have
			// no element matchers and no seed.
			// Incrementing an initially-string "0" `i` allows `i` to remain a string only in that
			// case, which will result in a "00" `matchedCount` that differs from `i` but is also
			// numerically zero.
			if ( bySet && i !== matchedCount ) {
				j = 0;
				while ( ( matcher = setMatchers[ j++ ] ) ) {
					matcher( unmatched, setMatched, context, xml );
				}

				if ( seed ) {

					// Reintegrate element matches to eliminate the need for sorting
					if ( matchedCount > 0 ) {
						while ( i-- ) {
							if ( !( unmatched[ i ] || setMatched[ i ] ) ) {
								setMatched[ i ] = pop.call( results );
							}
						}
					}

					// Discard index placeholder values to get only actual matches
					setMatched = condense( setMatched );
				}

				// Add matches to results
				push.apply( results, setMatched );

				// Seedless set matches succeeding multiple successful matchers stipulate sorting
				if ( outermost && !seed && setMatched.length > 0 &&
					( matchedCount + setMatchers.length ) > 1 ) {

					Sizzle.uniqueSort( results );
				}
			}

			// Override manipulation of globals by nested matchers
			if ( outermost ) {
				dirruns = dirrunsUnique;
				outermostContext = contextBackup;
			}

			return unmatched;
		};

	return bySet ?
		markFunction( superMatcher ) :
		superMatcher;
}

compile = Sizzle.compile = function( selector, match /* Internal Use Only */ ) {
	var i,
		setMatchers = [],
		elementMatchers = [],
		cached = compilerCache[ selector + " " ];

	if ( !cached ) {

		// Generate a function of recursive functions that can be used to check each element
		if ( !match ) {
			match = tokenize( selector );
		}
		i = match.length;
		while ( i-- ) {
			cached = matcherFromTokens( match[ i ] );
			if ( cached[ expando ] ) {
				setMatchers.push( cached );
			} else {
				elementMatchers.push( cached );
			}
		}

		// Cache the compiled function
		cached = compilerCache(
			selector,
			matcherFromGroupMatchers( elementMatchers, setMatchers )
		);

		// Save selector and tokenization
		cached.selector = selector;
	}
	return cached;
};

/**
 * A low-level selection function that works with Sizzle's compiled
 *  selector functions
 * @param {String|Function} selector A selector or a pre-compiled
 *  selector function built with Sizzle.compile
 * @param {Element} context
 * @param {Array} [results]
 * @param {Array} [seed] A set of elements to match against
 */
select = Sizzle.select = function( selector, context, results, seed ) {
	var i, tokens, token, type, find,
		compiled = typeof selector === "function" && selector,
		match = !seed && tokenize( ( selector = compiled.selector || selector ) );

	results = results || [];

	// Try to minimize operations if there is only one selector in the list and no seed
	// (the latter of which guarantees us context)
	if ( match.length === 1 ) {

		// Reduce context if the leading compound selector is an ID
		tokens = match[ 0 ] = match[ 0 ].slice( 0 );
		if ( tokens.length > 2 && ( token = tokens[ 0 ] ).type === "ID" &&
			context.nodeType === 9 && documentIsHTML && Expr.relative[ tokens[ 1 ].type ] ) {

			context = ( Expr.find[ "ID" ]( token.matches[ 0 ]
				.replace( runescape, funescape ), context ) || [] )[ 0 ];
			if ( !context ) {
				return results;

			// Precompiled matchers will still verify ancestry, so step up a level
			} else if ( compiled ) {
				context = context.parentNode;
			}

			selector = selector.slice( tokens.shift().value.length );
		}

		// Fetch a seed set for right-to-left matching
		i = matchExpr[ "needsContext" ].test( selector ) ? 0 : tokens.length;
		while ( i-- ) {
			token = tokens[ i ];

			// Abort if we hit a combinator
			if ( Expr.relative[ ( type = token.type ) ] ) {
				break;
			}
			if ( ( find = Expr.find[ type ] ) ) {

				// Search, expanding context for leading sibling combinators
				if ( ( seed = find(
					token.matches[ 0 ].replace( runescape, funescape ),
					rsibling.test( tokens[ 0 ].type ) && testContext( context.parentNode ) ||
						context
				) ) ) {

					// If seed is empty or no tokens remain, we can return early
					tokens.splice( i, 1 );
					selector = seed.length && toSelector( tokens );
					if ( !selector ) {
						push.apply( results, seed );
						return results;
					}

					break;
				}
			}
		}
	}

	// Compile and execute a filtering function if one is not provided
	// Provide `match` to avoid retokenization if we modified the selector above
	( compiled || compile( selector, match ) )(
		seed,
		context,
		!documentIsHTML,
		results,
		!context || rsibling.test( selector ) && testContext( context.parentNode ) || context
	);
	return results;
};

// One-time assignments

// Sort stability
support.sortStable = expando.split( "" ).sort( sortOrder ).join( "" ) === expando;

// Support: Chrome 14-35+
// Always assume duplicates if they aren't passed to the comparison function
support.detectDuplicates = !!hasDuplicate;

// Initialize against the default document
setDocument();

// Support: Webkit<537.32 - Safari 6.0.3/Chrome 25 (fixed in Chrome 27)
// Detached nodes confoundingly follow *each other*
support.sortDetached = assert( function( el ) {

	// Should return 1, but returns 4 (following)
	return el.compareDocumentPosition( document.createElement( "fieldset" ) ) & 1;
} );

// Support: IE<8
// Prevent attribute/property "interpolation"
// https://msdn.microsoft.com/en-us/library/ms536429%28VS.85%29.aspx
if ( !assert( function( el ) {
	el.innerHTML = "<a href='#'></a>";
	return el.firstChild.getAttribute( "href" ) === "#";
} ) ) {
	addHandle( "type|href|height|width", function( elem, name, isXML ) {
		if ( !isXML ) {
			return elem.getAttribute( name, name.toLowerCase() === "type" ? 1 : 2 );
		}
	} );
}

// Support: IE<9
// Use defaultValue in place of getAttribute("value")
if ( !support.attributes || !assert( function( el ) {
	el.innerHTML = "<input/>";
	el.firstChild.setAttribute( "value", "" );
	return el.firstChild.getAttribute( "value" ) === "";
} ) ) {
	addHandle( "value", function( elem, _name, isXML ) {
		if ( !isXML && elem.nodeName.toLowerCase() === "input" ) {
			return elem.defaultValue;
		}
	} );
}

// Support: IE<9
// Use getAttributeNode to fetch booleans when getAttribute lies
if ( !assert( function( el ) {
	return el.getAttribute( "disabled" ) == null;
} ) ) {
	addHandle( booleans, function( elem, name, isXML ) {
		var val;
		if ( !isXML ) {
			return elem[ name ] === true ? name.toLowerCase() :
				( val = elem.getAttributeNode( name ) ) && val.specified ?
					val.value :
					null;
		}
	} );
}

return Sizzle;

} )( window );



jQuery.find = Sizzle;
jQuery.expr = Sizzle.selectors;

// Deprecated
jQuery.expr[ ":" ] = jQuery.expr.pseudos;
jQuery.uniqueSort = jQuery.unique = Sizzle.uniqueSort;
jQuery.text = Sizzle.getText;
jQuery.isXMLDoc = Sizzle.isXML;
jQuery.contains = Sizzle.contains;
jQuery.escapeSelector = Sizzle.escape;




var dir = function( elem, dir, until ) {
	var matched = [],
		truncate = until !== undefined;

	while ( ( elem = elem[ dir ] ) && elem.nodeType !== 9 ) {
		if ( elem.nodeType === 1 ) {
			if ( truncate && jQuery( elem ).is( until ) ) {
				break;
			}
			matched.push( elem );
		}
	}
	return matched;
};


var siblings = function( n, elem ) {
	var matched = [];

	for ( ; n; n = n.nextSibling ) {
		if ( n.nodeType === 1 && n !== elem ) {
			matched.push( n );
		}
	}

	return matched;
};


var rneedsContext = jQuery.expr.match.needsContext;



function nodeName( elem, name ) {

	return elem.nodeName && elem.nodeName.toLowerCase() === name.toLowerCase();

}
var rsingleTag = ( /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i );



// Implement the identical functionality for filter and not
function winnow( elements, qualifier, not ) {
	if ( isFunction( qualifier ) ) {
		return jQuery.grep( elements, function( elem, i ) {
			return !!qualifier.call( elem, i, elem ) !== not;
		} );
	}

	// Single element
	if ( qualifier.nodeType ) {
		return jQuery.grep( elements, function( elem ) {
			return ( elem === qualifier ) !== not;
		} );
	}

	// Arraylike of elements (jQuery, arguments, Array)
	if ( typeof qualifier !== "string" ) {
		return jQuery.grep( elements, function( elem ) {
			return ( indexOf.call( qualifier, elem ) > -1 ) !== not;
		} );
	}

	// Filtered directly for both simple and complex selectors
	return jQuery.filter( qualifier, elements, not );
}

jQuery.filter = function( expr, elems, not ) {
	var elem = elems[ 0 ];

	if ( not ) {
		expr = ":not(" + expr + ")";
	}

	if ( elems.length === 1 && elem.nodeType === 1 ) {
		return jQuery.find.matchesSelector( elem, expr ) ? [ elem ] : [];
	}

	return jQuery.find.matches( expr, jQuery.grep( elems, function( elem ) {
		return elem.nodeType === 1;
	} ) );
};

jQuery.fn.extend( {
	find: function( selector ) {
		var i, ret,
			len = this.length,
			self = this;

		if ( typeof selector !== "string" ) {
			return this.pushStack( jQuery( selector ).filter( function() {
				for ( i = 0; i < len; i++ ) {
					if ( jQuery.contains( self[ i ], this ) ) {
						return true;
					}
				}
			} ) );
		}

		ret = this.pushStack( [] );

		for ( i = 0; i < len; i++ ) {
			jQuery.find( selector, self[ i ], ret );
		}

		return len > 1 ? jQuery.uniqueSort( ret ) : ret;
	},
	filter: function( selector ) {
		return this.pushStack( winnow( this, selector || [], false ) );
	},
	not: function( selector ) {
		return this.pushStack( winnow( this, selector || [], true ) );
	},
	is: function( selector ) {
		return !!winnow(
			this,

			// If this is a positional/relative selector, check membership in the returned set
			// so $("p:first").is("p:last") won't return true for a doc with two "p".
			typeof selector === "string" && rneedsContext.test( selector ) ?
				jQuery( selector ) :
				selector || [],
			false
		).length;
	}
} );


// Initialize a jQuery object


// A central reference to the root jQuery(document)
var rootjQuery,

	// A simple way to check for HTML strings
	// Prioritize #id over <tag> to avoid XSS via location.hash (trac-9521)
	// Strict HTML recognition (trac-11290: must start with <)
	// Shortcut simple #id case for speed
	rquickExpr = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/,

	init = jQuery.fn.init = function( selector, context, root ) {
		var match, elem;

		// HANDLE: $(""), $(null), $(undefined), $(false)
		if ( !selector ) {
			return this;
		}

		// Method init() accepts an alternate rootjQuery
		// so migrate can support jQuery.sub (gh-2101)
		root = root || rootjQuery;

		// Handle HTML strings
		if ( typeof selector === "string" ) {
			if ( selector[ 0 ] === "<" &&
				selector[ selector.length - 1 ] === ">" &&
				selector.length >= 3 ) {

				// Assume that strings that start and end with <> are HTML and skip the regex check
				match = [ null, selector, null ];

			} else {
				match = rquickExpr.exec( selector );
			}

			// Match html or make sure no context is specified for #id
			if ( match && ( match[ 1 ] || !context ) ) {

				// HANDLE: $(html) -> $(array)
				if ( match[ 1 ] ) {
					context = context instanceof jQuery ? context[ 0 ] : context;

					// Option to run scripts is true for back-compat
					// Intentionally let the error be thrown if parseHTML is not present
					jQuery.merge( this, jQuery.parseHTML(
						match[ 1 ],
						context && context.nodeType ? context.ownerDocument || context : document,
						true
					) );

					// HANDLE: $(html, props)
					if ( rsingleTag.test( match[ 1 ] ) && jQuery.isPlainObject( context ) ) {
						for ( match in context ) {

							// Properties of context are called as methods if possible
							if ( isFunction( this[ match ] ) ) {
								this[ match ]( context[ match ] );

							// ...and otherwise set as attributes
							} else {
								this.attr( match, context[ match ] );
							}
						}
					}

					return this;

				// HANDLE: $(#id)
				} else {
					elem = document.getElementById( match[ 2 ] );

					if ( elem ) {

						// Inject the element directly into the jQuery object
						this[ 0 ] = elem;
						this.length = 1;
					}
					return this;
				}

			// HANDLE: $(expr, $(...))
			} else if ( !context || context.jquery ) {
				return ( context || root ).find( selector );

			// HANDLE: $(expr, context)
			// (which is just equivalent to: $(context).find(expr)
			} else {
				return this.constructor( context ).find( selector );
			}

		// HANDLE: $(DOMElement)
		} else if ( selector.nodeType ) {
			this[ 0 ] = selector;
			this.length = 1;
			return this;

		// HANDLE: $(function)
		// Shortcut for document ready
		} else if ( isFunction( selector ) ) {
			return root.ready !== undefined ?
				root.ready( selector ) :

				// Execute immediately if ready is not present
				selector( jQuery );
		}

		return jQuery.makeArray( selector, this );
	};

// Give the init function the jQuery prototype for later instantiation
init.prototype = jQuery.fn;

// Initialize central reference
rootjQuery = jQuery( document );


var rparentsprev = /^(?:parents|prev(?:Until|All))/,

	// Methods guaranteed to produce a unique set when starting from a unique set
	guaranteedUnique = {
		children: true,
		contents: true,
		next: true,
		prev: true
	};

jQuery.fn.extend( {
	has: function( target ) {
		var targets = jQuery( target, this ),
			l = targets.length;

		return this.filter( function() {
			var i = 0;
			for ( ; i < l; i++ ) {
				if ( jQuery.contains( this, targets[ i ] ) ) {
					return true;
				}
			}
		} );
	},

	closest: function( selectors, context ) {
		var cur,
			i = 0,
			l = this.length,
			matched = [],
			targets = typeof selectors !== "string" && jQuery( selectors );

		// Positional selectors never match, since there's no _selection_ context
		if ( !rneedsContext.test( selectors ) ) {
			for ( ; i < l; i++ ) {
				for ( cur = this[ i ]; cur && cur !== context; cur = cur.parentNode ) {

					// Always skip document fragments
					if ( cur.nodeType < 11 && ( targets ?
						targets.index( cur ) > -1 :

						// Don't pass non-elements to Sizzle
						cur.nodeType === 1 &&
							jQuery.find.matchesSelector( cur, selectors ) ) ) {

						matched.push( cur );
						break;
					}
				}
			}
		}

		return this.pushStack( matched.length > 1 ? jQuery.uniqueSort( matched ) : matched );
	},

	// Determine the position of an element within the set
	index: function( elem ) {

		// No argument, return index in parent
		if ( !elem ) {
			return ( this[ 0 ] && this[ 0 ].parentNode ) ? this.first().prevAll().length : -1;
		}

		// Index in selector
		if ( typeof elem === "string" ) {
			return indexOf.call( jQuery( elem ), this[ 0 ] );
		}

		// Locate the position of the desired element
		return indexOf.call( this,

			// If it receives a jQuery object, the first element is used
			elem.jquery ? elem[ 0 ] : elem
		);
	},

	add: function( selector, context ) {
		return this.pushStack(
			jQuery.uniqueSort(
				jQuery.merge( this.get(), jQuery( selector, context ) )
			)
		);
	},

	addBack: function( selector ) {
		return this.add( selector == null ?
			this.prevObject : this.prevObject.filter( selector )
		);
	}
} );

function sibling( cur, dir ) {
	while ( ( cur = cur[ dir ] ) && cur.nodeType !== 1 ) {}
	return cur;
}

jQuery.each( {
	parent: function( elem ) {
		var parent = elem.parentNode;
		return parent && parent.nodeType !== 11 ? parent : null;
	},
	parents: function( elem ) {
		return dir( elem, "parentNode" );
	},
	parentsUntil: function( elem, _i, until ) {
		return dir( elem, "parentNode", until );
	},
	next: function( elem ) {
		return sibling( elem, "nextSibling" );
	},
	prev: function( elem ) {
		return sibling( elem, "previousSibling" );
	},
	nextAll: function( elem ) {
		return dir( elem, "nextSibling" );
	},
	prevAll: function( elem ) {
		return dir( elem, "previousSibling" );
	},
	nextUntil: function( elem, _i, until ) {
		return dir( elem, "nextSibling", until );
	},
	prevUntil: function( elem, _i, until ) {
		return dir( elem, "previousSibling", until );
	},
	siblings: function( elem ) {
		return siblings( ( elem.parentNode || {} ).firstChild, elem );
	},
	children: function( elem ) {
		return siblings( elem.firstChild );
	},
	contents: function( elem ) {
		if ( elem.contentDocument != null &&

			// Support: IE 11+
			// <object> elements with no `data` attribute has an object
			// `contentDocument` with a `null` prototype.
			getProto( elem.contentDocument ) ) {

			return elem.contentDocument;
		}

		// Support: IE 9 - 11 only, iOS 7 only, Android Browser <=4.3 only
		// Treat the template element as a regular one in browsers that
		// don't support it.
		if ( nodeName( elem, "template" ) ) {
			elem = elem.content || elem;
		}

		return jQuery.merge( [], elem.childNodes );
	}
}, function( name, fn ) {
	jQuery.fn[ name ] = function( until, selector ) {
		var matched = jQuery.map( this, fn, until );

		if ( name.slice( -5 ) !== "Until" ) {
			selector = until;
		}

		if ( selector && typeof selector === "string" ) {
			matched = jQuery.filter( selector, matched );
		}

		if ( this.length > 1 ) {

			// Remove duplicates
			if ( !guaranteedUnique[ name ] ) {
				jQuery.uniqueSort( matched );
			}

			// Reverse order for parents* and prev-derivatives
			if ( rparentsprev.test( name ) ) {
				matched.reverse();
			}
		}

		return this.pushStack( matched );
	};
} );
var rnothtmlwhite = ( /[^\x20\t\r\n\f]+/g );



// Convert String-formatted options into Object-formatted ones
function createOptions( options ) {
	var object = {};
	jQuery.each( options.match( rnothtmlwhite ) || [], function( _, flag ) {
		object[ flag ] = true;
	} );
	return object;
}

/*
 * Create a callback list using the following parameters:
 *
 *	options: an optional list of space-separated options that will change how
 *			the callback list behaves or a more traditional option object
 *
 * By default a callback list will act like an event callback list and can be
 * "fired" multiple times.
 *
 * Possible options:
 *
 *	once:			will ensure the callback list can only be fired once (like a Deferred)
 *
 *	memory:			will keep track of previous values and will call any callback added
 *					after the list has been fired right away with the latest "memorized"
 *					values (like a Deferred)
 *
 *	unique:			will ensure a callback can only be added once (no duplicate in the list)
 *
 *	stopOnFalse:	interrupt callings when a callback returns false
 *
 */
jQuery.Callbacks = function( options ) {

	// Convert options from String-formatted to Object-formatted if needed
	// (we check in cache first)
	options = typeof options === "string" ?
		createOptions( options ) :
		jQuery.extend( {}, options );

	var // Flag to know if list is currently firing
		firing,

		// Last fire value for non-forgettable lists
		memory,

		// Flag to know if list was already fired
		fired,

		// Flag to prevent firing
		locked,

		// Actual callback list
		list = [],

		// Queue of execution data for repeatable lists
		queue = [],

		// Index of currently firing callback (modified by add/remove as needed)
		firingIndex = -1,

		// Fire callbacks
		fire = function() {

			// Enforce single-firing
			locked = locked || options.once;

			// Execute callbacks for all pending executions,
			// respecting firingIndex overrides and runtime changes
			fired = firing = true;
			for ( ; queue.length; firingIndex = -1 ) {
				memory = queue.shift();
				while ( ++firingIndex < list.length ) {

					// Run callback and check for early termination
					if ( list[ firingIndex ].apply( memory[ 0 ], memory[ 1 ] ) === false &&
						options.stopOnFalse ) {

						// Jump to end and forget the data so .add doesn't re-fire
						firingIndex = list.length;
						memory = false;
					}
				}
			}

			// Forget the data if we're done with it
			if ( !options.memory ) {
				memory = false;
			}

			firing = false;

			// Clean up if we're done firing for good
			if ( locked ) {

				// Keep an empty list if we have data for future add calls
				if ( memory ) {
					list = [];

				// Otherwise, this object is spent
				} else {
					list = "";
				}
			}
		},

		// Actual Callbacks object
		self = {

			// Add a callback or a collection of callbacks to the list
			add: function() {
				if ( list ) {

					// If we have memory from a past run, we should fire after adding
					if ( memory && !firing ) {
						firingIndex = list.length - 1;
						queue.push( memory );
					}

					( function add( args ) {
						jQuery.each( args, function( _, arg ) {
							if ( isFunction( arg ) ) {
								if ( !options.unique || !self.has( arg ) ) {
									list.push( arg );
								}
							} else if ( arg && arg.length && toType( arg ) !== "string" ) {

								// Inspect recursively
								add( arg );
							}
						} );
					} )( arguments );

					if ( memory && !firing ) {
						fire();
					}
				}
				return this;
			},

			// Remove a callback from the list
			remove: function() {
				jQuery.each( arguments, function( _, arg ) {
					var index;
					while ( ( index = jQuery.inArray( arg, list, index ) ) > -1 ) {
						list.splice( index, 1 );

						// Handle firing indexes
						if ( index <= firingIndex ) {
							firingIndex--;
						}
					}
				} );
				return this;
			},

			// Check if a given callback is in the list.
			// If no argument is given, return whether or not list has callbacks attached.
			has: function( fn ) {
				return fn ?
					jQuery.inArray( fn, list ) > -1 :
					list.length > 0;
			},

			// Remove all callbacks from the list
			empty: function() {
				if ( list ) {
					list = [];
				}
				return this;
			},

			// Disable .fire and .add
			// Abort any current/pending executions
			// Clear all callbacks and values
			disable: function() {
				locked = queue = [];
				list = memory = "";
				return this;
			},
			disabled: function() {
				return !list;
			},

			// Disable .fire
			// Also disable .add unless we have memory (since it would have no effect)
			// Abort any pending executions
			lock: function() {
				locked = queue = [];
				if ( !memory && !firing ) {
					list = memory = "";
				}
				return this;
			},
			locked: function() {
				return !!locked;
			},

			// Call all callbacks with the given context and arguments
			fireWith: function( context, args ) {
				if ( !locked ) {
					args = args || [];
					args = [ context, args.slice ? args.slice() : args ];
					queue.push( args );
					if ( !firing ) {
						fire();
					}
				}
				return this;
			},

			// Call all the callbacks with the given arguments
			fire: function() {
				self.fireWith( this, arguments );
				return this;
			},

			// To know if the callbacks have already been called at least once
			fired: function() {
				return !!fired;
			}
		};

	return self;
};


function Identity( v ) {
	return v;
}
function Thrower( ex ) {
	throw ex;
}

function adoptValue( value, resolve, reject, noValue ) {
	var method;

	try {

		// Check for promise aspect first to privilege synchronous behavior
		if ( value && isFunction( ( method = value.promise ) ) ) {
			method.call( value ).done( resolve ).fail( reject );

		// Other thenables
		} else if ( value && isFunction( ( method = value.then ) ) ) {
			method.call( value, resolve, reject );

		// Other non-thenables
		} else {

			// Control `resolve` arguments by letting Array#slice cast boolean `noValue` to integer:
			// * false: [ value ].slice( 0 ) => resolve( value )
			// * true: [ value ].slice( 1 ) => resolve()
			resolve.apply( undefined, [ value ].slice( noValue ) );
		}

	// For Promises/A+, convert exceptions into rejections
	// Since jQuery.when doesn't unwrap thenables, we can skip the extra checks appearing in
	// Deferred#then to conditionally suppress rejection.
	} catch ( value ) {

		// Support: Android 4.0 only
		// Strict mode functions invoked without .call/.apply get global-object context
		reject.apply( undefined, [ value ] );
	}
}

jQuery.extend( {

	Deferred: function( func ) {
		var tuples = [

				// action, add listener, callbacks,
				// ... .then handlers, argument index, [final state]
				[ "notify", "progress", jQuery.Callbacks( "memory" ),
					jQuery.Callbacks( "memory" ), 2 ],
				[ "resolve", "done", jQuery.Callbacks( "once memory" ),
					jQuery.Callbacks( "once memory" ), 0, "resolved" ],
				[ "reject", "fail", jQuery.Callbacks( "once memory" ),
					jQuery.Callbacks( "once memory" ), 1, "rejected" ]
			],
			state = "pending",
			promise = {
				state: function() {
					return state;
				},
				always: function() {
					deferred.done( arguments ).fail( arguments );
					return this;
				},
				"catch": function( fn ) {
					return promise.then( null, fn );
				},

				// Keep pipe for back-compat
				pipe: function( /* fnDone, fnFail, fnProgress */ ) {
					var fns = arguments;

					return jQuery.Deferred( function( newDefer ) {
						jQuery.each( tuples, function( _i, tuple ) {

							// Map tuples (progress, done, fail) to arguments (done, fail, progress)
							var fn = isFunction( fns[ tuple[ 4 ] ] ) && fns[ tuple[ 4 ] ];

							// deferred.progress(function() { bind to newDefer or newDefer.notify })
							// deferred.done(function() { bind to newDefer or newDefer.resolve })
							// deferred.fail(function() { bind to newDefer or newDefer.reject })
							deferred[ tuple[ 1 ] ]( function() {
								var returned = fn && fn.apply( this, arguments );
								if ( returned && isFunction( returned.promise ) ) {
									returned.promise()
										.progress( newDefer.notify )
										.done( newDefer.resolve )
										.fail( newDefer.reject );
								} else {
									newDefer[ tuple[ 0 ] + "With" ](
										this,
										fn ? [ returned ] : arguments
									);
								}
							} );
						} );
						fns = null;
					} ).promise();
				},
				then: function( onFulfilled, onRejected, onProgress ) {
					var maxDepth = 0;
					function resolve( depth, deferred, handler, special ) {
						return function() {
							var that = this,
								args = arguments,
								mightThrow = function() {
									var returned, then;

									// Support: Promises/A+ section 2.3.3.3.3
									// https://promisesaplus.com/#point-59
									// Ignore double-resolution attempts
									if ( depth < maxDepth ) {
										return;
									}

									returned = handler.apply( that, args );

									// Support: Promises/A+ section 2.3.1
									// https://promisesaplus.com/#point-48
									if ( returned === deferred.promise() ) {
										throw new TypeError( "Thenable self-resolution" );
									}

									// Support: Promises/A+ sections 2.3.3.1, 3.5
									// https://promisesaplus.com/#point-54
									// https://promisesaplus.com/#point-75
									// Retrieve `then` only once
									then = returned &&

										// Support: Promises/A+ section 2.3.4
										// https://promisesaplus.com/#point-64
										// Only check objects and functions for thenability
										( typeof returned === "object" ||
											typeof returned === "function" ) &&
										returned.then;

									// Handle a returned thenable
									if ( isFunction( then ) ) {

										// Special processors (notify) just wait for resolution
										if ( special ) {
											then.call(
												returned,
												resolve( maxDepth, deferred, Identity, special ),
												resolve( maxDepth, deferred, Thrower, special )
											);

										// Normal processors (resolve) also hook into progress
										} else {

											// ...and disregard older resolution values
											maxDepth++;

											then.call(
												returned,
												resolve( maxDepth, deferred, Identity, special ),
												resolve( maxDepth, deferred, Thrower, special ),
												resolve( maxDepth, deferred, Identity,
													deferred.notifyWith )
											);
										}

									// Handle all other returned values
									} else {

										// Only substitute handlers pass on context
										// and multiple values (non-spec behavior)
										if ( handler !== Identity ) {
											that = undefined;
											args = [ returned ];
										}

										// Process the value(s)
										// Default process is resolve
										( special || deferred.resolveWith )( that, args );
									}
								},

								// Only normal processors (resolve) catch and reject exceptions
								process = special ?
									mightThrow :
									function() {
										try {
											mightThrow();
										} catch ( e ) {

											if ( jQuery.Deferred.exceptionHook ) {
												jQuery.Deferred.exceptionHook( e,
													process.stackTrace );
											}

											// Support: Promises/A+ section 2.3.3.3.4.1
											// https://promisesaplus.com/#point-61
											// Ignore post-resolution exceptions
											if ( depth + 1 >= maxDepth ) {

												// Only substitute handlers pass on context
												// and multiple values (non-spec behavior)
												if ( handler !== Thrower ) {
													that = undefined;
													args = [ e ];
												}

												deferred.rejectWith( that, args );
											}
										}
									};

							// Support: Promises/A+ section 2.3.3.3.1
							// https://promisesaplus.com/#point-57
							// Re-resolve promises immediately to dodge false rejection from
							// subsequent errors
							if ( depth ) {
								process();
							} else {

								// Call an optional hook to record the stack, in case of exception
								// since it's otherwise lost when execution goes async
								if ( jQuery.Deferred.getStackHook ) {
									process.stackTrace = jQuery.Deferred.getStackHook();
								}
								window.setTimeout( process );
							}
						};
					}

					return jQuery.Deferred( function( newDefer ) {

						// progress_handlers.add( ... )
						tuples[ 0 ][ 3 ].add(
							resolve(
								0,
								newDefer,
								isFunction( onProgress ) ?
									onProgress :
									Identity,
								newDefer.notifyWith
							)
						);

						// fulfilled_handlers.add( ... )
						tuples[ 1 ][ 3 ].add(
							resolve(
								0,
								newDefer,
								isFunction( onFulfilled ) ?
									onFulfilled :
									Identity
							)
						);

						// rejected_handlers.add( ... )
						tuples[ 2 ][ 3 ].add(
							resolve(
								0,
								newDefer,
								isFunction( onRejected ) ?
									onRejected :
									Thrower
							)
						);
					} ).promise();
				},

				// Get a promise for this deferred
				// If obj is provided, the promise aspect is added to the object
				promise: function( obj ) {
					return obj != null ? jQuery.extend( obj, promise ) : promise;
				}
			},
			deferred = {};

		// Add list-specific methods
		jQuery.each( tuples, function( i, tuple ) {
			var list = tuple[ 2 ],
				stateString = tuple[ 5 ];

			// promise.progress = list.add
			// promise.done = list.add
			// promise.fail = list.add
			promise[ tuple[ 1 ] ] = list.add;

			// Handle state
			if ( stateString ) {
				list.add(
					function() {

						// state = "resolved" (i.e., fulfilled)
						// state = "rejected"
						state = stateString;
					},

					// rejected_callbacks.disable
					// fulfilled_callbacks.disable
					tuples[ 3 - i ][ 2 ].disable,

					// rejected_handlers.disable
					// fulfilled_handlers.disable
					tuples[ 3 - i ][ 3 ].disable,

					// progress_callbacks.lock
					tuples[ 0 ][ 2 ].lock,

					// progress_handlers.lock
					tuples[ 0 ][ 3 ].lock
				);
			}

			// progress_handlers.fire
			// fulfilled_handlers.fire
			// rejected_handlers.fire
			list.add( tuple[ 3 ].fire );

			// deferred.notify = function() { deferred.notifyWith(...) }
			// deferred.resolve = function() { deferred.resolveWith(...) }
			// deferred.reject = function() { deferred.rejectWith(...) }
			deferred[ tuple[ 0 ] ] = function() {
				deferred[ tuple[ 0 ] + "With" ]( this === deferred ? undefined : this, arguments );
				return this;
			};

			// deferred.notifyWith = list.fireWith
			// deferred.resolveWith = list.fireWith
			// deferred.rejectWith = list.fireWith
			deferred[ tuple[ 0 ] + "With" ] = list.fireWith;
		} );

		// Make the deferred a promise
		promise.promise( deferred );

		// Call given func if any
		if ( func ) {
			func.call( deferred, deferred );
		}

		// All done!
		return deferred;
	},

	// Deferred helper
	when: function( singleValue ) {
		var

			// count of uncompleted subordinates
			remaining = arguments.length,

			// count of unprocessed arguments
			i = remaining,

			// subordinate fulfillment data
			resolveContexts = Array( i ),
			resolveValues = slice.call( arguments ),

			// the primary Deferred
			primary = jQuery.Deferred(),

			// subordinate callback factory
			updateFunc = function( i ) {
				return function( value ) {
					resolveContexts[ i ] = this;
					resolveValues[ i ] = arguments.length > 1 ? slice.call( arguments ) : value;
					if ( !( --remaining ) ) {
						primary.resolveWith( resolveContexts, resolveValues );
					}
				};
			};

		// Single- and empty arguments are adopted like Promise.resolve
		if ( remaining <= 1 ) {
			adoptValue( singleValue, primary.done( updateFunc( i ) ).resolve, primary.reject,
				!remaining );

			// Use .then() to unwrap secondary thenables (cf. gh-3000)
			if ( primary.state() === "pending" ||
				isFunction( resolveValues[ i ] && resolveValues[ i ].then ) ) {

				return primary.then();
			}
		}

		// Multiple arguments are aggregated like Promise.all array elements
		while ( i-- ) {
			adoptValue( resolveValues[ i ], updateFunc( i ), primary.reject );
		}

		return primary.promise();
	}
} );


// These usually indicate a programmer mistake during development,
// warn about them ASAP rather than swallowing them by default.
var rerrorNames = /^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;

jQuery.Deferred.exceptionHook = function( error, stack ) {

	// Support: IE 8 - 9 only
	// Console exists when dev tools are open, which can happen at any time
	if ( window.console && window.console.warn && error && rerrorNames.test( error.name ) ) {
		window.console.warn( "jQuery.Deferred exception: " + error.message, error.stack, stack );
	}
};




jQuery.readyException = function( error ) {
	window.setTimeout( function() {
		throw error;
	} );
};




// The deferred used on DOM ready
var readyList = jQuery.Deferred();

jQuery.fn.ready = function( fn ) {

	readyList
		.then( fn )

		// Wrap jQuery.readyException in a function so that the lookup
		// happens at the time of error handling instead of callback
		// registration.
		.catch( function( error ) {
			jQuery.readyException( error );
		} );

	return this;
};

jQuery.extend( {

	// Is the DOM ready to be used? Set to true once it occurs.
	isReady: false,

	// A counter to track how many items to wait for before
	// the ready event fires. See trac-6781
	readyWait: 1,

	// Handle when the DOM is ready
	ready: function( wait ) {

		// Abort if there are pending holds or we're already ready
		if ( wait === true ? --jQuery.readyWait : jQuery.isReady ) {
			return;
		}

		// Remember that the DOM is ready
		jQuery.isReady = true;

		// If a normal DOM Ready event fired, decrement, and wait if need be
		if ( wait !== true && --jQuery.readyWait > 0 ) {
			return;
		}

		// If there are functions bound, to execute
		readyList.resolveWith( document, [ jQuery ] );
	}
} );

jQuery.ready.then = readyList.then;

// The ready event handler and self cleanup method
function completed() {
	document.removeEventListener( "DOMContentLoaded", completed );
	window.removeEventListener( "load", completed );
	jQuery.ready();
}

// Catch cases where $(document).ready() is called
// after the browser event has already occurred.
// Support: IE <=9 - 10 only
// Older IE sometimes signals "interactive" too soon
if ( document.readyState === "complete" ||
	( document.readyState !== "loading" && !document.documentElement.doScroll ) ) {

	// Handle it asynchronously to allow scripts the opportunity to delay ready
	window.setTimeout( jQuery.ready );

} else {

	// Use the handy event callback
	document.addEventListener( "DOMContentLoaded", completed );

	// A fallback to window.onload, that will always work
	window.addEventListener( "load", completed );
}




// Multifunctional method to get and set values of a collection
// The value/s can optionally be executed if it's a function
var access = function( elems, fn, key, value, chainable, emptyGet, raw ) {
	var i = 0,
		len = elems.length,
		bulk = key == null;

	// Sets many values
	if ( toType( key ) === "object" ) {
		chainable = true;
		for ( i in key ) {
			access( elems, fn, i, key[ i ], true, emptyGet, raw );
		}

	// Sets one value
	} else if ( value !== undefined ) {
		chainable = true;

		if ( !isFunction( value ) ) {
			raw = true;
		}

		if ( bulk ) {

			// Bulk operations run against the entire set
			if ( raw ) {
				fn.call( elems, value );
				fn = null;

			// ...except when executing function values
			} else {
				bulk = fn;
				fn = function( elem, _key, value ) {
					return bulk.call( jQuery( elem ), value );
				};
			}
		}

		if ( fn ) {
			for ( ; i < len; i++ ) {
				fn(
					elems[ i ], key, raw ?
						value :
						value.call( elems[ i ], i, fn( elems[ i ], key ) )
				);
			}
		}
	}

	if ( chainable ) {
		return elems;
	}

	// Gets
	if ( bulk ) {
		return fn.call( elems );
	}

	return len ? fn( elems[ 0 ], key ) : emptyGet;
};


// Matches dashed string for camelizing
var rmsPrefix = /^-ms-/,
	rdashAlpha = /-([a-z])/g;

// Used by camelCase as callback to replace()
function fcamelCase( _all, letter ) {
	return letter.toUpperCase();
}

// Convert dashed to camelCase; used by the css and data modules
// Support: IE <=9 - 11, Edge 12 - 15
// Microsoft forgot to hump their vendor prefix (trac-9572)
function camelCase( string ) {
	return string.replace( rmsPrefix, "ms-" ).replace( rdashAlpha, fcamelCase );
}
var acceptData = function( owner ) {

	// Accepts only:
	//  - Node
	//    - Node.ELEMENT_NODE
	//    - Node.DOCUMENT_NODE
	//  - Object
	//    - Any
	return owner.nodeType === 1 || owner.nodeType === 9 || !( +owner.nodeType );
};




function Data() {
	this.expando = jQuery.expando + Data.uid++;
}

Data.uid = 1;

Data.prototype = {

	cache: function( owner ) {

		// Check if the owner object already has a cache
		var value = owner[ this.expando ];

		// If not, create one
		if ( !value ) {
			value = {};

			// We can accept data for non-element nodes in modern browsers,
			// but we should not, see trac-8335.
			// Always return an empty object.
			if ( acceptData( owner ) ) {

				// If it is a node unlikely to be stringify-ed or looped over
				// use plain assignment
				if ( owner.nodeType ) {
					owner[ this.expando ] = value;

				// Otherwise secure it in a non-enumerable property
				// configurable must be true to allow the property to be
				// deleted when data is removed
				} else {
					Object.defineProperty( owner, this.expando, {
						value: value,
						configurable: true
					} );
				}
			}
		}

		return value;
	},
	set: function( owner, data, value ) {
		var prop,
			cache = this.cache( owner );

		// Handle: [ owner, key, value ] args
		// Always use camelCase key (gh-2257)
		if ( typeof data === "string" ) {
			cache[ camelCase( data ) ] = value;

		// Handle: [ owner, { properties } ] args
		} else {

			// Copy the properties one-by-one to the cache object
			for ( prop in data ) {
				cache[ camelCase( prop ) ] = data[ prop ];
			}
		}
		return cache;
	},
	get: function( owner, key ) {
		return key === undefined ?
			this.cache( owner ) :

			// Always use camelCase key (gh-2257)
			owner[ this.expando ] && owner[ this.expando ][ camelCase( key ) ];
	},
	access: function( owner, key, value ) {

		// In cases where either:
		//
		//   1. No key was specified
		//   2. A string key was specified, but no value provided
		//
		// Take the "read" path and allow the get method to determine
		// which value to return, respectively either:
		//
		//   1. The entire cache object
		//   2. The data stored at the key
		//
		if ( key === undefined ||
				( ( key && typeof key === "string" ) && value === undefined ) ) {

			return this.get( owner, key );
		}

		// When the key is not a string, or both a key and value
		// are specified, set or extend (existing objects) with either:
		//
		//   1. An object of properties
		//   2. A key and value
		//
		this.set( owner, key, value );

		// Since the "set" path can have two possible entry points
		// return the expected data based on which path was taken[*]
		return value !== undefined ? value : key;
	},
	remove: function( owner, key ) {
		var i,
			cache = owner[ this.expando ];

		if ( cache === undefined ) {
			return;
		}

		if ( key !== undefined ) {

			// Support array or space separated string of keys
			if ( Array.isArray( key ) ) {

				// If key is an array of keys...
				// We always set camelCase keys, so remove that.
				key = key.map( camelCase );
			} else {
				key = camelCase( key );

				// If a key with the spaces exists, use it.
				// Otherwise, create an array by matching non-whitespace
				key = key in cache ?
					[ key ] :
					( key.match( rnothtmlwhite ) || [] );
			}

			i = key.length;

			while ( i-- ) {
				delete cache[ key[ i ] ];
			}
		}

		// Remove the expando if there's no more data
		if ( key === undefined || jQuery.isEmptyObject( cache ) ) {

			// Support: Chrome <=35 - 45
			// Webkit & Blink performance suffers when deleting properties
			// from DOM nodes, so set to undefined instead
			// https://bugs.chromium.org/p/chromium/issues/detail?id=378607 (bug restricted)
			if ( owner.nodeType ) {
				owner[ this.expando ] = undefined;
			} else {
				delete owner[ this.expando ];
			}
		}
	},
	hasData: function( owner ) {
		var cache = owner[ this.expando ];
		return cache !== undefined && !jQuery.isEmptyObject( cache );
	}
};
var dataPriv = new Data();

var dataUser = new Data();



//	Implementation Summary
//
//	1. Enforce API surface and semantic compatibility with 1.9.x branch
//	2. Improve the module's maintainability by reducing the storage
//		paths to a single mechanism.
//	3. Use the same single mechanism to support "private" and "user" data.
//	4. _Never_ expose "private" data to user code (TODO: Drop _data, _removeData)
//	5. Avoid exposing implementation details on user objects (eg. expando properties)
//	6. Provide a clear path for implementation upgrade to WeakMap in 2014

var rbrace = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
	rmultiDash = /[A-Z]/g;

function getData( data ) {
	if ( data === "true" ) {
		return true;
	}

	if ( data === "false" ) {
		return false;
	}

	if ( data === "null" ) {
		return null;
	}

	// Only convert to a number if it doesn't change the string
	if ( data === +data + "" ) {
		return +data;
	}

	if ( rbrace.test( data ) ) {
		return JSON.parse( data );
	}

	return data;
}

function dataAttr( elem, key, data ) {
	var name;

	// If nothing was found internally, try to fetch any
	// data from the HTML5 data-* attribute
	if ( data === undefined && elem.nodeType === 1 ) {
		name = "data-" + key.replace( rmultiDash, "-$&" ).toLowerCase();
		data = elem.getAttribute( name );

		if ( typeof data === "string" ) {
			try {
				data = getData( data );
			} catch ( e ) {}

			// Make sure we set the data so it isn't changed later
			dataUser.set( elem, key, data );
		} else {
			data = undefined;
		}
	}
	return data;
}

jQuery.extend( {
	hasData: function( elem ) {
		return dataUser.hasData( elem ) || dataPriv.hasData( elem );
	},

	data: function( elem, name, data ) {
		return dataUser.access( elem, name, data );
	},

	removeData: function( elem, name ) {
		dataUser.remove( elem, name );
	},

	// TODO: Now that all calls to _data and _removeData have been replaced
	// with direct calls to dataPriv methods, these can be deprecated.
	_data: function( elem, name, data ) {
		return dataPriv.access( elem, name, data );
	},

	_removeData: function( elem, name ) {
		dataPriv.remove( elem, name );
	}
} );

jQuery.fn.extend( {
	data: function( key, value ) {
		var i, name, data,
			elem = this[ 0 ],
			attrs = elem && elem.attributes;

		// Gets all values
		if ( key === undefined ) {
			if ( this.length ) {
				data = dataUser.get( elem );

				if ( elem.nodeType === 1 && !dataPriv.get( elem, "hasDataAttrs" ) ) {
					i = attrs.length;
					while ( i-- ) {

						// Support: IE 11 only
						// The attrs elements can be null (trac-14894)
						if ( attrs[ i ] ) {
							name = attrs[ i ].name;
							if ( name.indexOf( "data-" ) === 0 ) {
								name = camelCase( name.slice( 5 ) );
								dataAttr( elem, name, data[ name ] );
							}
						}
					}
					dataPriv.set( elem, "hasDataAttrs", true );
				}
			}

			return data;
		}

		// Sets multiple values
		if ( typeof key === "object" ) {
			return this.each( function() {
				dataUser.set( this, key );
			} );
		}

		return access( this, function( value ) {
			var data;

			// The calling jQuery object (element matches) is not empty
			// (and therefore has an element appears at this[ 0 ]) and the
			// `value` parameter was not undefined. An empty jQuery object
			// will result in `undefined` for elem = this[ 0 ] which will
			// throw an exception if an attempt to read a data cache is made.
			if ( elem && value === undefined ) {

				// Attempt to get data from the cache
				// The key will always be camelCased in Data
				data = dataUser.get( elem, key );
				if ( data !== undefined ) {
					return data;
				}

				// Attempt to "discover" the data in
				// HTML5 custom data-* attrs
				data = dataAttr( elem, key );
				if ( data !== undefined ) {
					return data;
				}

				// We tried really hard, but the data doesn't exist.
				return;
			}

			// Set the data...
			this.each( function() {

				// We always store the camelCased key
				dataUser.set( this, key, value );
			} );
		}, null, value, arguments.length > 1, null, true );
	},

	removeData: function( key ) {
		return this.each( function() {
			dataUser.remove( this, key );
		} );
	}
} );


jQuery.extend( {
	queue: function( elem, type, data ) {
		var queue;

		if ( elem ) {
			type = ( type || "fx" ) + "queue";
			queue = dataPriv.get( elem, type );

			// Speed up dequeue by getting out quickly if this is just a lookup
			if ( data ) {
				if ( !queue || Array.isArray( data ) ) {
					queue = dataPriv.access( elem, type, jQuery.makeArray( data ) );
				} else {
					queue.push( data );
				}
			}
			return queue || [];
		}
	},

	dequeue: function( elem, type ) {
		type = type || "fx";

		var queue = jQuery.queue( elem, type ),
			startLength = queue.length,
			fn = queue.shift(),
			hooks = jQuery._queueHooks( elem, type ),
			next = function() {
				jQuery.dequeue( elem, type );
			};

		// If the fx queue is dequeued, always remove the progress sentinel
		if ( fn === "inprogress" ) {
			fn = queue.shift();
			startLength--;
		}

		if ( fn ) {

			// Add a progress sentinel to prevent the fx queue from being
			// automatically dequeued
			if ( type === "fx" ) {
				queue.unshift( "inprogress" );
			}

			// Clear up the last queue stop function
			delete hooks.stop;
			fn.call( elem, next, hooks );
		}

		if ( !startLength && hooks ) {
			hooks.empty.fire();
		}
	},

	// Not public - generate a queueHooks object, or return the current one
	_queueHooks: function( elem, type ) {
		var key = type + "queueHooks";
		return dataPriv.get( elem, key ) || dataPriv.access( elem, key, {
			empty: jQuery.Callbacks( "once memory" ).add( function() {
				dataPriv.remove( elem, [ type + "queue", key ] );
			} )
		} );
	}
} );

jQuery.fn.extend( {
	queue: function( type, data ) {
		var setter = 2;

		if ( typeof type !== "string" ) {
			data = type;
			type = "fx";
			setter--;
		}

		if ( arguments.length < setter ) {
			return jQuery.queue( this[ 0 ], type );
		}

		return data === undefined ?
			this :
			this.each( function() {
				var queue = jQuery.queue( this, type, data );

				// Ensure a hooks for this queue
				jQuery._queueHooks( this, type );

				if ( type === "fx" && queue[ 0 ] !== "inprogress" ) {
					jQuery.dequeue( this, type );
				}
			} );
	},
	dequeue: function( type ) {
		return this.each( function() {
			jQuery.dequeue( this, type );
		} );
	},
	clearQueue: function( type ) {
		return this.queue( type || "fx", [] );
	},

	// Get a promise resolved when queues of a certain type
	// are emptied (fx is the type by default)
	promise: function( type, obj ) {
		var tmp,
			count = 1,
			defer = jQuery.Deferred(),
			elements = this,
			i = this.length,
			resolve = function() {
				if ( !( --count ) ) {
					defer.resolveWith( elements, [ elements ] );
				}
			};

		if ( typeof type !== "string" ) {
			obj = type;
			type = undefined;
		}
		type = type || "fx";

		while ( i-- ) {
			tmp = dataPriv.get( elements[ i ], type + "queueHooks" );
			if ( tmp && tmp.empty ) {
				count++;
				tmp.empty.add( resolve );
			}
		}
		resolve();
		return defer.promise( obj );
	}
} );
var pnum = ( /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/ ).source;

var rcssNum = new RegExp( "^(?:([+-])=|)(" + pnum + ")([a-z%]*)$", "i" );


var cssExpand = [ "Top", "Right", "Bottom", "Left" ];

var documentElement = document.documentElement;



	var isAttached = function( elem ) {
			return jQuery.contains( elem.ownerDocument, elem );
		},
		composed = { composed: true };

	// Support: IE 9 - 11+, Edge 12 - 18+, iOS 10.0 - 10.2 only
	// Check attachment across shadow DOM boundaries when possible (gh-3504)
	// Support: iOS 10.0-10.2 only
	// Early iOS 10 versions support `attachShadow` but not `getRootNode`,
	// leading to errors. We need to check for `getRootNode`.
	if ( documentElement.getRootNode ) {
		isAttached = function( elem ) {
			return jQuery.contains( elem.ownerDocument, elem ) ||
				elem.getRootNode( composed ) === elem.ownerDocument;
		};
	}
var isHiddenWithinTree = function( elem, el ) {

		// isHiddenWithinTree might be called from jQuery#filter function;
		// in that case, element will be second argument
		elem = el || elem;

		// Inline style trumps all
		return elem.style.display === "none" ||
			elem.style.display === "" &&

			// Otherwise, check computed style
			// Support: Firefox <=43 - 45
			// Disconnected elements can have computed display: none, so first confirm that elem is
			// in the document.
			isAttached( elem ) &&

			jQuery.css( elem, "display" ) === "none";
	};



function adjustCSS( elem, prop, valueParts, tween ) {
	var adjusted, scale,
		maxIterations = 20,
		currentValue = tween ?
			function() {
				return tween.cur();
			} :
			function() {
				return jQuery.css( elem, prop, "" );
			},
		initial = currentValue(),
		unit = valueParts && valueParts[ 3 ] || ( jQuery.cssNumber[ prop ] ? "" : "px" ),

		// Starting value computation is required for potential unit mismatches
		initialInUnit = elem.nodeType &&
			( jQuery.cssNumber[ prop ] || unit !== "px" && +initial ) &&
			rcssNum.exec( jQuery.css( elem, prop ) );

	if ( initialInUnit && initialInUnit[ 3 ] !== unit ) {

		// Support: Firefox <=54
		// Halve the iteration target value to prevent interference from CSS upper bounds (gh-2144)
		initial = initial / 2;

		// Trust units reported by jQuery.css
		unit = unit || initialInUnit[ 3 ];

		// Iteratively approximate from a nonzero starting point
		initialInUnit = +initial || 1;

		while ( maxIterations-- ) {

			// Evaluate and update our best guess (doubling guesses that zero out).
			// Finish if the scale equals or crosses 1 (making the old*new product non-positive).
			jQuery.style( elem, prop, initialInUnit + unit );
			if ( ( 1 - scale ) * ( 1 - ( scale = currentValue() / initial || 0.5 ) ) <= 0 ) {
				maxIterations = 0;
			}
			initialInUnit = initialInUnit / scale;

		}

		initialInUnit = initialInUnit * 2;
		jQuery.style( elem, prop, initialInUnit + unit );

		// Make sure we update the tween properties later on
		valueParts = valueParts || [];
	}

	if ( valueParts ) {
		initialInUnit = +initialInUnit || +initial || 0;

		// Apply relative offset (+=/-=) if specified
		adjusted = valueParts[ 1 ] ?
			initialInUnit + ( valueParts[ 1 ] + 1 ) * valueParts[ 2 ] :
			+valueParts[ 2 ];
		if ( tween ) {
			tween.unit = unit;
			tween.start = initialInUnit;
			tween.end = adjusted;
		}
	}
	return adjusted;
}


var defaultDisplayMap = {};

function getDefaultDisplay( elem ) {
	var temp,
		doc = elem.ownerDocument,
		nodeName = elem.nodeName,
		display = defaultDisplayMap[ nodeName ];

	if ( display ) {
		return display;
	}

	temp = doc.body.appendChild( doc.createElement( nodeName ) );
	display = jQuery.css( temp, "display" );

	temp.parentNode.removeChild( temp );

	if ( display === "none" ) {
		display = "block";
	}
	defaultDisplayMap[ nodeName ] = display;

	return display;
}

function showHide( elements, show ) {
	var display, elem,
		values = [],
		index = 0,
		length = elements.length;

	// Determine new display value for elements that need to change
	for ( ; index < length; index++ ) {
		elem = elements[ index ];
		if ( !elem.style ) {
			continue;
		}

		display = elem.style.display;
		if ( show ) {

			// Since we force visibility upon cascade-hidden elements, an immediate (and slow)
			// check is required in this first loop unless we have a nonempty display value (either
			// inline or about-to-be-restored)
			if ( display === "none" ) {
				values[ index ] = dataPriv.get( elem, "display" ) || null;
				if ( !values[ index ] ) {
					elem.style.display = "";
				}
			}
			if ( elem.style.display === "" && isHiddenWithinTree( elem ) ) {
				values[ index ] = getDefaultDisplay( elem );
			}
		} else {
			if ( display !== "none" ) {
				values[ index ] = "none";

				// Remember what we're overwriting
				dataPriv.set( elem, "display", display );
			}
		}
	}

	// Set the display of the elements in a second loop to avoid constant reflow
	for ( index = 0; index < length; index++ ) {
		if ( values[ index ] != null ) {
			elements[ index ].style.display = values[ index ];
		}
	}

	return elements;
}

jQuery.fn.extend( {
	show: function() {
		return showHide( this, true );
	},
	hide: function() {
		return showHide( this );
	},
	toggle: function( state ) {
		if ( typeof state === "boolean" ) {
			return state ? this.show() : this.hide();
		}

		return this.each( function() {
			if ( isHiddenWithinTree( this ) ) {
				jQuery( this ).show();
			} else {
				jQuery( this ).hide();
			}
		} );
	}
} );
var rcheckableType = ( /^(?:checkbox|radio)$/i );

var rtagName = ( /<([a-z][^\/\0>\x20\t\r\n\f]*)/i );

var rscriptType = ( /^$|^module$|\/(?:java|ecma)script/i );



( function() {
	var fragment = document.createDocumentFragment(),
		div = fragment.appendChild( document.createElement( "div" ) ),
		input = document.createElement( "input" );

	// Support: Android 4.0 - 4.3 only
	// Check state lost if the name is set (trac-11217)
	// Support: Windows Web Apps (WWA)
	// `name` and `type` must use .setAttribute for WWA (trac-14901)
	input.setAttribute( "type", "radio" );
	input.setAttribute( "checked", "checked" );
	input.setAttribute( "name", "t" );

	div.appendChild( input );

	// Support: Android <=4.1 only
	// Older WebKit doesn't clone checked state correctly in fragments
	support.checkClone = div.cloneNode( true ).cloneNode( true ).lastChild.checked;

	// Support: IE <=11 only
	// Make sure textarea (and checkbox) defaultValue is properly cloned
	div.innerHTML = "<textarea>x</textarea>";
	support.noCloneChecked = !!div.cloneNode( true ).lastChild.defaultValue;

	// Support: IE <=9 only
	// IE <=9 replaces <option> tags with their contents when inserted outside of
	// the select element.
	div.innerHTML = "<option></option>";
	support.option = !!div.lastChild;
} )();


// We have to close these tags to support XHTML (trac-13200)
var wrapMap = {

	// XHTML parsers do not magically insert elements in the
	// same way that tag soup parsers do. So we cannot shorten
	// this by omitting <tbody> or other required elements.
	thead: [ 1, "<table>", "</table>" ],
	col: [ 2, "<table><colgroup>", "</colgroup></table>" ],
	tr: [ 2, "<table><tbody>", "</tbody></table>" ],
	td: [ 3, "<table><tbody><tr>", "</tr></tbody></table>" ],

	_default: [ 0, "", "" ]
};

wrapMap.tbody = wrapMap.tfoot = wrapMap.colgroup = wrapMap.caption = wrapMap.thead;
wrapMap.th = wrapMap.td;

// Support: IE <=9 only
if ( !support.option ) {
	wrapMap.optgroup = wrapMap.option = [ 1, "<select multiple='multiple'>", "</select>" ];
}


function getAll( context, tag ) {

	// Support: IE <=9 - 11 only
	// Use typeof to avoid zero-argument method invocation on host objects (trac-15151)
	var ret;

	if ( typeof context.getElementsByTagName !== "undefined" ) {
		ret = context.getElementsByTagName( tag || "*" );

	} else if ( typeof context.querySelectorAll !== "undefined" ) {
		ret = context.querySelectorAll( tag || "*" );

	} else {
		ret = [];
	}

	if ( tag === undefined || tag && nodeName( context, tag ) ) {
		return jQuery.merge( [ context ], ret );
	}

	return ret;
}


// Mark scripts as having already been evaluated
function setGlobalEval( elems, refElements ) {
	var i = 0,
		l = elems.length;

	for ( ; i < l; i++ ) {
		dataPriv.set(
			elems[ i ],
			"globalEval",
			!refElements || dataPriv.get( refElements[ i ], "globalEval" )
		);
	}
}


var rhtml = /<|&#?\w+;/;

function buildFragment( elems, context, scripts, selection, ignored ) {
	var elem, tmp, tag, wrap, attached, j,
		fragment = context.createDocumentFragment(),
		nodes = [],
		i = 0,
		l = elems.length;

	for ( ; i < l; i++ ) {
		elem = elems[ i ];

		if ( elem || elem === 0 ) {

			// Add nodes directly
			if ( toType( elem ) === "object" ) {

				// Support: Android <=4.0 only, PhantomJS 1 only
				// push.apply(_, arraylike) throws on ancient WebKit
				jQuery.merge( nodes, elem.nodeType ? [ elem ] : elem );

			// Convert non-html into a text node
			} else if ( !rhtml.test( elem ) ) {
				nodes.push( context.createTextNode( elem ) );

			// Convert html into DOM nodes
			} else {
				tmp = tmp || fragment.appendChild( context.createElement( "div" ) );

				// Deserialize a standard representation
				tag = ( rtagName.exec( elem ) || [ "", "" ] )[ 1 ].toLowerCase();
				wrap = wrapMap[ tag ] || wrapMap._default;
				tmp.innerHTML = wrap[ 1 ] + jQuery.htmlPrefilter( elem ) + wrap[ 2 ];

				// Descend through wrappers to the right content
				j = wrap[ 0 ];
				while ( j-- ) {
					tmp = tmp.lastChild;
				}

				// Support: Android <=4.0 only, PhantomJS 1 only
				// push.apply(_, arraylike) throws on ancient WebKit
				jQuery.merge( nodes, tmp.childNodes );

				// Remember the top-level container
				tmp = fragment.firstChild;

				// Ensure the created nodes are orphaned (trac-12392)
				tmp.textContent = "";
			}
		}
	}

	// Remove wrapper from fragment
	fragment.textContent = "";

	i = 0;
	while ( ( elem = nodes[ i++ ] ) ) {

		// Skip elements already in the context collection (trac-4087)
		if ( selection && jQuery.inArray( elem, selection ) > -1 ) {
			if ( ignored ) {
				ignored.push( elem );
			}
			continue;
		}

		attached = isAttached( elem );

		// Append to fragment
		tmp = getAll( fragment.appendChild( elem ), "script" );

		// Preserve script evaluation history
		if ( attached ) {
			setGlobalEval( tmp );
		}

		// Capture executables
		if ( scripts ) {
			j = 0;
			while ( ( elem = tmp[ j++ ] ) ) {
				if ( rscriptType.test( elem.type || "" ) ) {
					scripts.push( elem );
				}
			}
		}
	}

	return fragment;
}


var rtypenamespace = /^([^.]*)(?:\.(.+)|)/;

function returnTrue() {
	return true;
}

function returnFalse() {
	return false;
}

// Support: IE <=9 - 11+
// focus() and blur() are asynchronous, except when they are no-op.
// So expect focus to be synchronous when the element is already active,
// and blur to be synchronous when the element is not already active.
// (focus and blur are always synchronous in other supported browsers,
// this just defines when we can count on it).
function expectSync( elem, type ) {
	return ( elem === safeActiveElement() ) === ( type === "focus" );
}

// Support: IE <=9 only
// Accessing document.activeElement can throw unexpectedly
// https://bugs.jquery.com/ticket/13393
function safeActiveElement() {
	try {
		return document.activeElement;
	} catch ( err ) { }
}

function on( elem, types, selector, data, fn, one ) {
	var origFn, type;

	// Types can be a map of types/handlers
	if ( typeof types === "object" ) {

		// ( types-Object, selector, data )
		if ( typeof selector !== "string" ) {

			// ( types-Object, data )
			data = data || selector;
			selector = undefined;
		}
		for ( type in types ) {
			on( elem, type, selector, data, types[ type ], one );
		}
		return elem;
	}

	if ( data == null && fn == null ) {

		// ( types, fn )
		fn = selector;
		data = selector = undefined;
	} else if ( fn == null ) {
		if ( typeof selector === "string" ) {

			// ( types, selector, fn )
			fn = data;
			data = undefined;
		} else {

			// ( types, data, fn )
			fn = data;
			data = selector;
			selector = undefined;
		}
	}
	if ( fn === false ) {
		fn = returnFalse;
	} else if ( !fn ) {
		return elem;
	}

	if ( one === 1 ) {
		origFn = fn;
		fn = function( event ) {

			// Can use an empty set, since event contains the info
			jQuery().off( event );
			return origFn.apply( this, arguments );
		};

		// Use same guid so caller can remove using origFn
		fn.guid = origFn.guid || ( origFn.guid = jQuery.guid++ );
	}
	return elem.each( function() {
		jQuery.event.add( this, types, fn, data, selector );
	} );
}

/*
 * Helper functions for managing events -- not part of the public interface.
 * Props to Dean Edwards' addEvent library for many of the ideas.
 */
jQuery.event = {

	global: {},

	add: function( elem, types, handler, data, selector ) {

		var handleObjIn, eventHandle, tmp,
			events, t, handleObj,
			special, handlers, type, namespaces, origType,
			elemData = dataPriv.get( elem );

		// Only attach events to objects that accept data
		if ( !acceptData( elem ) ) {
			return;
		}

		// Caller can pass in an object of custom data in lieu of the handler
		if ( handler.handler ) {
			handleObjIn = handler;
			handler = handleObjIn.handler;
			selector = handleObjIn.selector;
		}

		// Ensure that invalid selectors throw exceptions at attach time
		// Evaluate against documentElement in case elem is a non-element node (e.g., document)
		if ( selector ) {
			jQuery.find.matchesSelector( documentElement, selector );
		}

		// Make sure that the handler has a unique ID, used to find/remove it later
		if ( !handler.guid ) {
			handler.guid = jQuery.guid++;
		}

		// Init the element's event structure and main handler, if this is the first
		if ( !( events = elemData.events ) ) {
			events = elemData.events = Object.create( null );
		}
		if ( !( eventHandle = elemData.handle ) ) {
			eventHandle = elemData.handle = function( e ) {

				// Discard the second event of a jQuery.event.trigger() and
				// when an event is called after a page has unloaded
				return typeof jQuery !== "undefined" && jQuery.event.triggered !== e.type ?
					jQuery.event.dispatch.apply( elem, arguments ) : undefined;
			};
		}

		// Handle multiple events separated by a space
		types = ( types || "" ).match( rnothtmlwhite ) || [ "" ];
		t = types.length;
		while ( t-- ) {
			tmp = rtypenamespace.exec( types[ t ] ) || [];
			type = origType = tmp[ 1 ];
			namespaces = ( tmp[ 2 ] || "" ).split( "." ).sort();

			// There *must* be a type, no attaching namespace-only handlers
			if ( !type ) {
				continue;
			}

			// If event changes its type, use the special event handlers for the changed type
			special = jQuery.event.special[ type ] || {};

			// If selector defined, determine special event api type, otherwise given type
			type = ( selector ? special.delegateType : special.bindType ) || type;

			// Update special based on newly reset type
			special = jQuery.event.special[ type ] || {};

			// handleObj is passed to all event handlers
			handleObj = jQuery.extend( {
				type: type,
				origType: origType,
				data: data,
				handler: handler,
				guid: handler.guid,
				selector: selector,
				needsContext: selector && jQuery.expr.match.needsContext.test( selector ),
				namespace: namespaces.join( "." )
			}, handleObjIn );

			// Init the event handler queue if we're the first
			if ( !( handlers = events[ type ] ) ) {
				handlers = events[ type ] = [];
				handlers.delegateCount = 0;

				// Only use addEventListener if the special events handler returns false
				if ( !special.setup ||
					special.setup.call( elem, data, namespaces, eventHandle ) === false ) {

					if ( elem.addEventListener ) {
						elem.addEventListener( type, eventHandle );
					}
				}
			}

			if ( special.add ) {
				special.add.call( elem, handleObj );

				if ( !handleObj.handler.guid ) {
					handleObj.handler.guid = handler.guid;
				}
			}

			// Add to the element's handler list, delegates in front
			if ( selector ) {
				handlers.splice( handlers.delegateCount++, 0, handleObj );
			} else {
				handlers.push( handleObj );
			}

			// Keep track of which events have ever been used, for event optimization
			jQuery.event.global[ type ] = true;
		}

	},

	// Detach an event or set of events from an element
	remove: function( elem, types, handler, selector, mappedTypes ) {

		var j, origCount, tmp,
			events, t, handleObj,
			special, handlers, type, namespaces, origType,
			elemData = dataPriv.hasData( elem ) && dataPriv.get( elem );

		if ( !elemData || !( events = elemData.events ) ) {
			return;
		}

		// Once for each type.namespace in types; type may be omitted
		types = ( types || "" ).match( rnothtmlwhite ) || [ "" ];
		t = types.length;
		while ( t-- ) {
			tmp = rtypenamespace.exec( types[ t ] ) || [];
			type = origType = tmp[ 1 ];
			namespaces = ( tmp[ 2 ] || "" ).split( "." ).sort();

			// Unbind all events (on this namespace, if provided) for the element
			if ( !type ) {
				for ( type in events ) {
					jQuery.event.remove( elem, type + types[ t ], handler, selector, true );
				}
				continue;
			}

			special = jQuery.event.special[ type ] || {};
			type = ( selector ? special.delegateType : special.bindType ) || type;
			handlers = events[ type ] || [];
			tmp = tmp[ 2 ] &&
				new RegExp( "(^|\\.)" + namespaces.join( "\\.(?:.*\\.|)" ) + "(\\.|$)" );

			// Remove matching events
			origCount = j = handlers.length;
			while ( j-- ) {
				handleObj = handlers[ j ];

				if ( ( mappedTypes || origType === handleObj.origType ) &&
					( !handler || handler.guid === handleObj.guid ) &&
					( !tmp || tmp.test( handleObj.namespace ) ) &&
					( !selector || selector === handleObj.selector ||
						selector === "**" && handleObj.selector ) ) {
					handlers.splice( j, 1 );

					if ( handleObj.selector ) {
						handlers.delegateCount--;
					}
					if ( special.remove ) {
						special.remove.call( elem, handleObj );
					}
				}
			}

			// Remove generic event handler if we removed something and no more handlers exist
			// (avoids potential for endless recursion during removal of special event handlers)
			if ( origCount && !handlers.length ) {
				if ( !special.teardown ||
					special.teardown.call( elem, namespaces, elemData.handle ) === false ) {

					jQuery.removeEvent( elem, type, elemData.handle );
				}

				delete events[ type ];
			}
		}

		// Remove data and the expando if it's no longer used
		if ( jQuery.isEmptyObject( events ) ) {
			dataPriv.remove( elem, "handle events" );
		}
	},

	dispatch: function( nativeEvent ) {

		var i, j, ret, matched, handleObj, handlerQueue,
			args = new Array( arguments.length ),

			// Make a writable jQuery.Event from the native event object
			event = jQuery.event.fix( nativeEvent ),

			handlers = (
				dataPriv.get( this, "events" ) || Object.create( null )
			)[ event.type ] || [],
			special = jQuery.event.special[ event.type ] || {};

		// Use the fix-ed jQuery.Event rather than the (read-only) native event
		args[ 0 ] = event;

		for ( i = 1; i < arguments.length; i++ ) {
			args[ i ] = arguments[ i ];
		}

		event.delegateTarget = this;

		// Call the preDispatch hook for the mapped type, and let it bail if desired
		if ( special.preDispatch && special.preDispatch.call( this, event ) === false ) {
			return;
		}

		// Determine handlers
		handlerQueue = jQuery.event.handlers.call( this, event, handlers );

		// Run delegates first; they may want to stop propagation beneath us
		i = 0;
		while ( ( matched = handlerQueue[ i++ ] ) && !event.isPropagationStopped() ) {
			event.currentTarget = matched.elem;

			j = 0;
			while ( ( handleObj = matched.handlers[ j++ ] ) &&
				!event.isImmediatePropagationStopped() ) {

				// If the event is namespaced, then each handler is only invoked if it is
				// specially universal or its namespaces are a superset of the event's.
				if ( !event.rnamespace || handleObj.namespace === false ||
					event.rnamespace.test( handleObj.namespace ) ) {

					event.handleObj = handleObj;
					event.data = handleObj.data;

					ret = ( ( jQuery.event.special[ handleObj.origType ] || {} ).handle ||
						handleObj.handler ).apply( matched.elem, args );

					if ( ret !== undefined ) {
						if ( ( event.result = ret ) === false ) {
							event.preventDefault();
							event.stopPropagation();
						}
					}
				}
			}
		}

		// Call the postDispatch hook for the mapped type
		if ( special.postDispatch ) {
			special.postDispatch.call( this, event );
		}

		return event.result;
	},

	handlers: function( event, handlers ) {
		var i, handleObj, sel, matchedHandlers, matchedSelectors,
			handlerQueue = [],
			delegateCount = handlers.delegateCount,
			cur = event.target;

		// Find delegate handlers
		if ( delegateCount &&

			// Support: IE <=9
			// Black-hole SVG <use> instance trees (trac-13180)
			cur.nodeType &&

			// Support: Firefox <=42
			// Suppress spec-violating clicks indicating a non-primary pointer button (trac-3861)
			// https://www.w3.org/TR/DOM-Level-3-Events/#event-type-click
			// Support: IE 11 only
			// ...but not arrow key "clicks" of radio inputs, which can have `button` -1 (gh-2343)
			!( event.type === "click" && event.button >= 1 ) ) {

			for ( ; cur !== this; cur = cur.parentNode || this ) {

				// Don't check non-elements (trac-13208)
				// Don't process clicks on disabled elements (trac-6911, trac-8165, trac-11382, trac-11764)
				if ( cur.nodeType === 1 && !( event.type === "click" && cur.disabled === true ) ) {
					matchedHandlers = [];
					matchedSelectors = {};
					for ( i = 0; i < delegateCount; i++ ) {
						handleObj = handlers[ i ];

						// Don't conflict with Object.prototype properties (trac-13203)
						sel = handleObj.selector + " ";

						if ( matchedSelectors[ sel ] === undefined ) {
							matchedSelectors[ sel ] = handleObj.needsContext ?
								jQuery( sel, this ).index( cur ) > -1 :
								jQuery.find( sel, this, null, [ cur ] ).length;
						}
						if ( matchedSelectors[ sel ] ) {
							matchedHandlers.push( handleObj );
						}
					}
					if ( matchedHandlers.length ) {
						handlerQueue.push( { elem: cur, handlers: matchedHandlers } );
					}
				}
			}
		}

		// Add the remaining (directly-bound) handlers
		cur = this;
		if ( delegateCount < handlers.length ) {
			handlerQueue.push( { elem: cur, handlers: handlers.slice( delegateCount ) } );
		}

		return handlerQueue;
	},

	addProp: function( name, hook ) {
		Object.defineProperty( jQuery.Event.prototype, name, {
			enumerable: true,
			configurable: true,

			get: isFunction( hook ) ?
				function() {
					if ( this.originalEvent ) {
						return hook( this.originalEvent );
					}
				} :
				function() {
					if ( this.originalEvent ) {
						return this.originalEvent[ name ];
					}
				},

			set: function( value ) {
				Object.defineProperty( this, name, {
					enumerable: true,
					configurable: true,
					writable: true,
					value: value
				} );
			}
		} );
	},

	fix: function( originalEvent ) {
		return originalEvent[ jQuery.expando ] ?
			originalEvent :
			new jQuery.Event( originalEvent );
	},

	special: {
		load: {

			// Prevent triggered image.load events from bubbling to window.load
			noBubble: true
		},
		click: {

			// Utilize native event to ensure correct state for checkable inputs
			setup: function( data ) {

				// For mutual compressibility with _default, replace `this` access with a local var.
				// `|| data` is dead code meant only to preserve the variable through minification.
				var el = this || data;

				// Claim the first handler
				if ( rcheckableType.test( el.type ) &&
					el.click && nodeName( el, "input" ) ) {

					// dataPriv.set( el, "click", ... )
					leverageNative( el, "click", returnTrue );
				}

				// Return false to allow normal processing in the caller
				return false;
			},
			trigger: function( data ) {

				// For mutual compressibility with _default, replace `this` access with a local var.
				// `|| data` is dead code meant only to preserve the variable through minification.
				var el = this || data;

				// Force setup before triggering a click
				if ( rcheckableType.test( el.type ) &&
					el.click && nodeName( el, "input" ) ) {

					leverageNative( el, "click" );
				}

				// Return non-false to allow normal event-path propagation
				return true;
			},

			// For cross-browser consistency, suppress native .click() on links
			// Also prevent it if we're currently inside a leveraged native-event stack
			_default: function( event ) {
				var target = event.target;
				return rcheckableType.test( target.type ) &&
					target.click && nodeName( target, "input" ) &&
					dataPriv.get( target, "click" ) ||
					nodeName( target, "a" );
			}
		},

		beforeunload: {
			postDispatch: function( event ) {

				// Support: Firefox 20+
				// Firefox doesn't alert if the returnValue field is not set.
				if ( event.result !== undefined && event.originalEvent ) {
					event.originalEvent.returnValue = event.result;
				}
			}
		}
	}
};

// Ensure the presence of an event listener that handles manually-triggered
// synthetic events by interrupting progress until reinvoked in response to
// *native* events that it fires directly, ensuring that state changes have
// already occurred before other listeners are invoked.
function leverageNative( el, type, expectSync ) {

	// Missing expectSync indicates a trigger call, which must force setup through jQuery.event.add
	if ( !expectSync ) {
		if ( dataPriv.get( el, type ) === undefined ) {
			jQuery.event.add( el, type, returnTrue );
		}
		return;
	}

	// Register the controller as a special universal handler for all event namespaces
	dataPriv.set( el, type, false );
	jQuery.event.add( el, type, {
		namespace: false,
		handler: function( event ) {
			var notAsync, result,
				saved = dataPriv.get( this, type );

			if ( ( event.isTrigger & 1 ) && this[ type ] ) {

				// Interrupt processing of the outer synthetic .trigger()ed event
				// Saved data should be false in such cases, but might be a leftover capture object
				// from an async native handler (gh-4350)
				if ( !saved.length ) {

					// Store arguments for use when handling the inner native event
					// There will always be at least one argument (an event object), so this array
					// will not be confused with a leftover capture object.
					saved = slice.call( arguments );
					dataPriv.set( this, type, saved );

					// Trigger the native event and capture its result
					// Support: IE <=9 - 11+
					// focus() and blur() are asynchronous
					notAsync = expectSync( this, type );
					this[ type ]();
					result = dataPriv.get( this, type );
					if ( saved !== result || notAsync ) {
						dataPriv.set( this, type, false );
					} else {
						result = {};
					}
					if ( saved !== result ) {

						// Cancel the outer synthetic event
						event.stopImmediatePropagation();
						event.preventDefault();

						// Support: Chrome 86+
						// In Chrome, if an element having a focusout handler is blurred by
						// clicking outside of it, it invokes the handler synchronously. If
						// that handler calls `.remove()` on the element, the data is cleared,
						// leaving `result` undefined. We need to guard against this.
						return result && result.value;
					}

				// If this is an inner synthetic event for an event with a bubbling surrogate
				// (focus or blur), assume that the surrogate already propagated from triggering the
				// native event and prevent that from happening again here.
				// This technically gets the ordering wrong w.r.t. to `.trigger()` (in which the
				// bubbling surrogate propagates *after* the non-bubbling base), but that seems
				// less bad than duplication.
				} else if ( ( jQuery.event.special[ type ] || {} ).delegateType ) {
					event.stopPropagation();
				}

			// If this is a native event triggered above, everything is now in order
			// Fire an inner synthetic event with the original arguments
			} else if ( saved.length ) {

				// ...and capture the result
				dataPriv.set( this, type, {
					value: jQuery.event.trigger(

						// Support: IE <=9 - 11+
						// Extend with the prototype to reset the above stopImmediatePropagation()
						jQuery.extend( saved[ 0 ], jQuery.Event.prototype ),
						saved.slice( 1 ),
						this
					)
				} );

				// Abort handling of the native event
				event.stopImmediatePropagation();
			}
		}
	} );
}

jQuery.removeEvent = function( elem, type, handle ) {

	// This "if" is needed for plain objects
	if ( elem.removeEventListener ) {
		elem.removeEventListener( type, handle );
	}
};

jQuery.Event = function( src, props ) {

	// Allow instantiation without the 'new' keyword
	if ( !( this instanceof jQuery.Event ) ) {
		return new jQuery.Event( src, props );
	}

	// Event object
	if ( src && src.type ) {
		this.originalEvent = src;
		this.type = src.type;

		// Events bubbling up the document may have been marked as prevented
		// by a handler lower down the tree; reflect the correct value.
		this.isDefaultPrevented = src.defaultPrevented ||
				src.defaultPrevented === undefined &&

				// Support: Android <=2.3 only
				src.returnValue === false ?
			returnTrue :
			returnFalse;

		// Create target properties
		// Support: Safari <=6 - 7 only
		// Target should not be a text node (trac-504, trac-13143)
		this.target = ( src.target && src.target.nodeType === 3 ) ?
			src.target.parentNode :
			src.target;

		this.currentTarget = src.currentTarget;
		this.relatedTarget = src.relatedTarget;

	// Event type
	} else {
		this.type = src;
	}

	// Put explicitly provided properties onto the event object
	if ( props ) {
		jQuery.extend( this, props );
	}

	// Create a timestamp if incoming event doesn't have one
	this.timeStamp = src && src.timeStamp || Date.now();

	// Mark it as fixed
	this[ jQuery.expando ] = true;
};

// jQuery.Event is based on DOM3 Events as specified by the ECMAScript Language Binding
// https://www.w3.org/TR/2003/WD-DOM-Level-3-Events-20030331/ecma-script-binding.html
jQuery.Event.prototype = {
	constructor: jQuery.Event,
	isDefaultPrevented: returnFalse,
	isPropagationStopped: returnFalse,
	isImmediatePropagationStopped: returnFalse,
	isSimulated: false,

	preventDefault: function() {
		var e = this.originalEvent;

		this.isDefaultPrevented = returnTrue;

		if ( e && !this.isSimulated ) {
			e.preventDefault();
		}
	},
	stopPropagation: function() {
		var e = this.originalEvent;

		this.isPropagationStopped = returnTrue;

		if ( e && !this.isSimulated ) {
			e.stopPropagation();
		}
	},
	stopImmediatePropagation: function() {
		var e = this.originalEvent;

		this.isImmediatePropagationStopped = returnTrue;

		if ( e && !this.isSimulated ) {
			e.stopImmediatePropagation();
		}

		this.stopPropagation();
	}
};

// Includes all common event props including KeyEvent and MouseEvent specific props
jQuery.each( {
	altKey: true,
	bubbles: true,
	cancelable: true,
	changedTouches: true,
	ctrlKey: true,
	detail: true,
	eventPhase: true,
	metaKey: true,
	pageX: true,
	pageY: true,
	shiftKey: true,
	view: true,
	"char": true,
	code: true,
	charCode: true,
	key: true,
	keyCode: true,
	button: true,
	buttons: true,
	clientX: true,
	clientY: true,
	offsetX: true,
	offsetY: true,
	pointerId: true,
	pointerType: true,
	screenX: true,
	screenY: true,
	targetTouches: true,
	toElement: true,
	touches: true,
	which: true
}, jQuery.event.addProp );

jQuery.each( { focus: "focusin", blur: "focusout" }, function( type, delegateType ) {
	jQuery.event.special[ type ] = {

		// Utilize native event if possible so blur/focus sequence is correct
		setup: function() {

			// Claim the first handler
			// dataPriv.set( this, "focus", ... )
			// dataPriv.set( this, "blur", ... )
			leverageNative( this, type, expectSync );

			// Return false to allow normal processing in the caller
			return false;
		},
		trigger: function() {

			// Force setup before trigger
			leverageNative( this, type );

			// Return non-false to allow normal event-path propagation
			return true;
		},

		// Suppress native focus or blur if we're currently inside
		// a leveraged native-event stack
		_default: function( event ) {
			return dataPriv.get( event.target, type );
		},

		delegateType: delegateType
	};
} );

// Create mouseenter/leave events using mouseover/out and event-time checks
// so that event delegation works in jQuery.
// Do the same for pointerenter/pointerleave and pointerover/pointerout
//
// Support: Safari 7 only
// Safari sends mouseenter too often; see:
// https://bugs.chromium.org/p/chromium/issues/detail?id=470258
// for the description of the bug (it existed in older Chrome versions as well).
jQuery.each( {
	mouseenter: "mouseover",
	mouseleave: "mouseout",
	pointerenter: "pointerover",
	pointerleave: "pointerout"
}, function( orig, fix ) {
	jQuery.event.special[ orig ] = {
		delegateType: fix,
		bindType: fix,

		handle: function( event ) {
			var ret,
				target = this,
				related = event.relatedTarget,
				handleObj = event.handleObj;

			// For mouseenter/leave call the handler if related is outside the target.
			// NB: No relatedTarget if the mouse left/entered the browser window
			if ( !related || ( related !== target && !jQuery.contains( target, related ) ) ) {
				event.type = handleObj.origType;
				ret = handleObj.handler.apply( this, arguments );
				event.type = fix;
			}
			return ret;
		}
	};
} );

jQuery.fn.extend( {

	on: function( types, selector, data, fn ) {
		return on( this, types, selector, data, fn );
	},
	one: function( types, selector, data, fn ) {
		return on( this, types, selector, data, fn, 1 );
	},
	off: function( types, selector, fn ) {
		var handleObj, type;
		if ( types && types.preventDefault && types.handleObj ) {

			// ( event )  dispatched jQuery.Event
			handleObj = types.handleObj;
			jQuery( types.delegateTarget ).off(
				handleObj.namespace ?
					handleObj.origType + "." + handleObj.namespace :
					handleObj.origType,
				handleObj.selector,
				handleObj.handler
			);
			return this;
		}
		if ( typeof types === "object" ) {

			// ( types-object [, selector] )
			for ( type in types ) {
				this.off( type, selector, types[ type ] );
			}
			return this;
		}
		if ( selector === false || typeof selector === "function" ) {

			// ( types [, fn] )
			fn = selector;
			selector = undefined;
		}
		if ( fn === false ) {
			fn = returnFalse;
		}
		return this.each( function() {
			jQuery.event.remove( this, types, fn, selector );
		} );
	}
} );


var

	// Support: IE <=10 - 11, Edge 12 - 13 only
	// In IE/Edge using regex groups here causes severe slowdowns.
	// See https://connect.microsoft.com/IE/feedback/details/1736512/
	rnoInnerhtml = /<script|<style|<link/i,

	// checked="checked" or checked
	rchecked = /checked\s*(?:[^=]|=\s*.checked.)/i,

	rcleanScript = /^\s*<!\[CDATA\[|\]\]>\s*$/g;

// Prefer a tbody over its parent table for containing new rows
function manipulationTarget( elem, content ) {
	if ( nodeName( elem, "table" ) &&
		nodeName( content.nodeType !== 11 ? content : content.firstChild, "tr" ) ) {

		return jQuery( elem ).children( "tbody" )[ 0 ] || elem;
	}

	return elem;
}

// Replace/restore the type attribute of script elements for safe DOM manipulation
function disableScript( elem ) {
	elem.type = ( elem.getAttribute( "type" ) !== null ) + "/" + elem.type;
	return elem;
}
function restoreScript( elem ) {
	if ( ( elem.type || "" ).slice( 0, 5 ) === "true/" ) {
		elem.type = elem.type.slice( 5 );
	} else {
		elem.removeAttribute( "type" );
	}

	return elem;
}

function cloneCopyEvent( src, dest ) {
	var i, l, type, pdataOld, udataOld, udataCur, events;

	if ( dest.nodeType !== 1 ) {
		return;
	}

	// 1. Copy private data: events, handlers, etc.
	if ( dataPriv.hasData( src ) ) {
		pdataOld = dataPriv.get( src );
		events = pdataOld.events;

		if ( events ) {
			dataPriv.remove( dest, "handle events" );

			for ( type in events ) {
				for ( i = 0, l = events[ type ].length; i < l; i++ ) {
					jQuery.event.add( dest, type, events[ type ][ i ] );
				}
			}
		}
	}

	// 2. Copy user data
	if ( dataUser.hasData( src ) ) {
		udataOld = dataUser.access( src );
		udataCur = jQuery.extend( {}, udataOld );

		dataUser.set( dest, udataCur );
	}
}

// Fix IE bugs, see support tests
function fixInput( src, dest ) {
	var nodeName = dest.nodeName.toLowerCase();

	// Fails to persist the checked state of a cloned checkbox or radio button.
	if ( nodeName === "input" && rcheckableType.test( src.type ) ) {
		dest.checked = src.checked;

	// Fails to return the selected option to the default selected state when cloning options
	} else if ( nodeName === "input" || nodeName === "textarea" ) {
		dest.defaultValue = src.defaultValue;
	}
}

function domManip( collection, args, callback, ignored ) {

	// Flatten any nested arrays
	args = flat( args );

	var fragment, first, scripts, hasScripts, node, doc,
		i = 0,
		l = collection.length,
		iNoClone = l - 1,
		value = args[ 0 ],
		valueIsFunction = isFunction( value );

	// We can't cloneNode fragments that contain checked, in WebKit
	if ( valueIsFunction ||
			( l > 1 && typeof value === "string" &&
				!support.checkClone && rchecked.test( value ) ) ) {
		return collection.each( function( index ) {
			var self = collection.eq( index );
			if ( valueIsFunction ) {
				args[ 0 ] = value.call( this, index, self.html() );
			}
			domManip( self, args, callback, ignored );
		} );
	}

	if ( l ) {
		fragment = buildFragment( args, collection[ 0 ].ownerDocument, false, collection, ignored );
		first = fragment.firstChild;

		if ( fragment.childNodes.length === 1 ) {
			fragment = first;
		}

		// Require either new content or an interest in ignored elements to invoke the callback
		if ( first || ignored ) {
			scripts = jQuery.map( getAll( fragment, "script" ), disableScript );
			hasScripts = scripts.length;

			// Use the original fragment for the last item
			// instead of the first because it can end up
			// being emptied incorrectly in certain situations (trac-8070).
			for ( ; i < l; i++ ) {
				node = fragment;

				if ( i !== iNoClone ) {
					node = jQuery.clone( node, true, true );

					// Keep references to cloned scripts for later restoration
					if ( hasScripts ) {

						// Support: Android <=4.0 only, PhantomJS 1 only
						// push.apply(_, arraylike) throws on ancient WebKit
						jQuery.merge( scripts, getAll( node, "script" ) );
					}
				}

				callback.call( collection[ i ], node, i );
			}

			if ( hasScripts ) {
				doc = scripts[ scripts.length - 1 ].ownerDocument;

				// Reenable scripts
				jQuery.map( scripts, restoreScript );

				// Evaluate executable scripts on first document insertion
				for ( i = 0; i < hasScripts; i++ ) {
					node = scripts[ i ];
					if ( rscriptType.test( node.type || "" ) &&
						!dataPriv.access( node, "globalEval" ) &&
						jQuery.contains( doc, node ) ) {

						if ( node.src && ( node.type || "" ).toLowerCase()  !== "module" ) {

							// Optional AJAX dependency, but won't run scripts if not present
							if ( jQuery._evalUrl && !node.noModule ) {
								jQuery._evalUrl( node.src, {
									nonce: node.nonce || node.getAttribute( "nonce" )
								}, doc );
							}
						} else {

							// Unwrap a CDATA section containing script contents. This shouldn't be
							// needed as in XML documents they're already not visible when
							// inspecting element contents and in HTML documents they have no
							// meaning but we're preserving that logic for backwards compatibility.
							// This will be removed completely in 4.0. See gh-4904.
							DOMEval( node.textContent.replace( rcleanScript, "" ), node, doc );
						}
					}
				}
			}
		}
	}

	return collection;
}

function remove( elem, selector, keepData ) {
	var node,
		nodes = selector ? jQuery.filter( selector, elem ) : elem,
		i = 0;

	for ( ; ( node = nodes[ i ] ) != null; i++ ) {
		if ( !keepData && node.nodeType === 1 ) {
			jQuery.cleanData( getAll( node ) );
		}

		if ( node.parentNode ) {
			if ( keepData && isAttached( node ) ) {
				setGlobalEval( getAll( node, "script" ) );
			}
			node.parentNode.removeChild( node );
		}
	}

	return elem;
}

jQuery.extend( {
	htmlPrefilter: function( html ) {
		return html;
	},

	clone: function( elem, dataAndEvents, deepDataAndEvents ) {
		var i, l, srcElements, destElements,
			clone = elem.cloneNode( true ),
			inPage = isAttached( elem );

		// Fix IE cloning issues
		if ( !support.noCloneChecked && ( elem.nodeType === 1 || elem.nodeType === 11 ) &&
				!jQuery.isXMLDoc( elem ) ) {

			// We eschew Sizzle here for performance reasons: https://jsperf.com/getall-vs-sizzle/2
			destElements = getAll( clone );
			srcElements = getAll( elem );

			for ( i = 0, l = srcElements.length; i < l; i++ ) {
				fixInput( srcElements[ i ], destElements[ i ] );
			}
		}

		// Copy the events from the original to the clone
		if ( dataAndEvents ) {
			if ( deepDataAndEvents ) {
				srcElements = srcElements || getAll( elem );
				destElements = destElements || getAll( clone );

				for ( i = 0, l = srcElements.length; i < l; i++ ) {
					cloneCopyEvent( srcElements[ i ], destElements[ i ] );
				}
			} else {
				cloneCopyEvent( elem, clone );
			}
		}

		// Preserve script evaluation history
		destElements = getAll( clone, "script" );
		if ( destElements.length > 0 ) {
			setGlobalEval( destElements, !inPage && getAll( elem, "script" ) );
		}

		// Return the cloned set
		return clone;
	},

	cleanData: function( elems ) {
		var data, elem, type,
			special = jQuery.event.special,
			i = 0;

		for ( ; ( elem = elems[ i ] ) !== undefined; i++ ) {
			if ( acceptData( elem ) ) {
				if ( ( data = elem[ dataPriv.expando ] ) ) {
					if ( data.events ) {
						for ( type in data.events ) {
							if ( special[ type ] ) {
								jQuery.event.remove( elem, type );

							// This is a shortcut to avoid jQuery.event.remove's overhead
							} else {
								jQuery.removeEvent( elem, type, data.handle );
							}
						}
					}

					// Support: Chrome <=35 - 45+
					// Assign undefined instead of using delete, see Data#remove
					elem[ dataPriv.expando ] = undefined;
				}
				if ( elem[ dataUser.expando ] ) {

					// Support: Chrome <=35 - 45+
					// Assign undefined instead of using delete, see Data#remove
					elem[ dataUser.expando ] = undefined;
				}
			}
		}
	}
} );

jQuery.fn.extend( {
	detach: function( selector ) {
		return remove( this, selector, true );
	},

	remove: function( selector ) {
		return remove( this, selector );
	},

	text: function( value ) {
		return access( this, function( value ) {
			return value === undefined ?
				jQuery.text( this ) :
				this.empty().each( function() {
					if ( this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9 ) {
						this.textContent = value;
					}
				} );
		}, null, value, arguments.length );
	},

	append: function() {
		return domManip( this, arguments, function( elem ) {
			if ( this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9 ) {
				var target = manipulationTarget( this, elem );
				target.appendChild( elem );
			}
		} );
	},

	prepend: function() {
		return domManip( this, arguments, function( elem ) {
			if ( this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9 ) {
				var target = manipulationTarget( this, elem );
				target.insertBefore( elem, target.firstChild );
			}
		} );
	},

	before: function() {
		return domManip( this, arguments, function( elem ) {
			if ( this.parentNode ) {
				this.parentNode.insertBefore( elem, this );
			}
		} );
	},

	after: function() {
		return domManip( this, arguments, function( elem ) {
			if ( this.parentNode ) {
				this.parentNode.insertBefore( elem, this.nextSibling );
			}
		} );
	},

	empty: function() {
		var elem,
			i = 0;

		for ( ; ( elem = this[ i ] ) != null; i++ ) {
			if ( elem.nodeType === 1 ) {

				// Prevent memory leaks
				jQuery.cleanData( getAll( elem, false ) );

				// Remove any remaining nodes
				elem.textContent = "";
			}
		}

		return this;
	},

	clone: function( dataAndEvents, deepDataAndEvents ) {
		dataAndEvents = dataAndEvents == null ? false : dataAndEvents;
		deepDataAndEvents = deepDataAndEvents == null ? dataAndEvents : deepDataAndEvents;

		return this.map( function() {
			return jQuery.clone( this, dataAndEvents, deepDataAndEvents );
		} );
	},

	html: function( value ) {
		return access( this, function( value ) {
			var elem = this[ 0 ] || {},
				i = 0,
				l = this.length;

			if ( value === undefined && elem.nodeType === 1 ) {
				return elem.innerHTML;
			}

			// See if we can take a shortcut and just use innerHTML
			if ( typeof value === "string" && !rnoInnerhtml.test( value ) &&
				!wrapMap[ ( rtagName.exec( value ) || [ "", "" ] )[ 1 ].toLowerCase() ] ) {

				value = jQuery.htmlPrefilter( value );

				try {
					for ( ; i < l; i++ ) {
						elem = this[ i ] || {};

						// Remove element nodes and prevent memory leaks
						if ( elem.nodeType === 1 ) {
							jQuery.cleanData( getAll( elem, false ) );
							elem.innerHTML = value;
						}
					}

					elem = 0;

				// If using innerHTML throws an exception, use the fallback method
				} catch ( e ) {}
			}

			if ( elem ) {
				this.empty().append( value );
			}
		}, null, value, arguments.length );
	},

	replaceWith: function() {
		var ignored = [];

		// Make the changes, replacing each non-ignored context element with the new content
		return domManip( this, arguments, function( elem ) {
			var parent = this.parentNode;

			if ( jQuery.inArray( this, ignored ) < 0 ) {
				jQuery.cleanData( getAll( this ) );
				if ( parent ) {
					parent.replaceChild( elem, this );
				}
			}

		// Force callback invocation
		}, ignored );
	}
} );

jQuery.each( {
	appendTo: "append",
	prependTo: "prepend",
	insertBefore: "before",
	insertAfter: "after",
	replaceAll: "replaceWith"
}, function( name, original ) {
	jQuery.fn[ name ] = function( selector ) {
		var elems,
			ret = [],
			insert = jQuery( selector ),
			last = insert.length - 1,
			i = 0;

		for ( ; i <= last; i++ ) {
			elems = i === last ? this : this.clone( true );
			jQuery( insert[ i ] )[ original ]( elems );

			// Support: Android <=4.0 only, PhantomJS 1 only
			// .get() because push.apply(_, arraylike) throws on ancient WebKit
			push.apply( ret, elems.get() );
		}

		return this.pushStack( ret );
	};
} );
var rnumnonpx = new RegExp( "^(" + pnum + ")(?!px)[a-z%]+$", "i" );

var rcustomProp = /^--/;


var getStyles = function( elem ) {

		// Support: IE <=11 only, Firefox <=30 (trac-15098, trac-14150)
		// IE throws on elements created in popups
		// FF meanwhile throws on frame elements through "defaultView.getComputedStyle"
		var view = elem.ownerDocument.defaultView;

		if ( !view || !view.opener ) {
			view = window;
		}

		return view.getComputedStyle( elem );
	};

var swap = function( elem, options, callback ) {
	var ret, name,
		old = {};

	// Remember the old values, and insert the new ones
	for ( name in options ) {
		old[ name ] = elem.style[ name ];
		elem.style[ name ] = options[ name ];
	}

	ret = callback.call( elem );

	// Revert the old values
	for ( name in options ) {
		elem.style[ name ] = old[ name ];
	}

	return ret;
};


var rboxStyle = new RegExp( cssExpand.join( "|" ), "i" );

var whitespace = "[\\x20\\t\\r\\n\\f]";


var rtrimCSS = new RegExp(
	"^" + whitespace + "+|((?:^|[^\\\\])(?:\\\\.)*)" + whitespace + "+$",
	"g"
);




( function() {

	// Executing both pixelPosition & boxSizingReliable tests require only one layout
	// so they're executed at the same time to save the second computation.
	function computeStyleTests() {

		// This is a singleton, we need to execute it only once
		if ( !div ) {
			return;
		}

		container.style.cssText = "position:absolute;left:-11111px;width:60px;" +
			"margin-top:1px;padding:0;border:0";
		div.style.cssText =
			"position:relative;display:block;box-sizing:border-box;overflow:scroll;" +
			"margin:auto;border:1px;padding:1px;" +
			"width:60%;top:1%";
		documentElement.appendChild( container ).appendChild( div );

		var divStyle = window.getComputedStyle( div );
		pixelPositionVal = divStyle.top !== "1%";

		// Support: Android 4.0 - 4.3 only, Firefox <=3 - 44
		reliableMarginLeftVal = roundPixelMeasures( divStyle.marginLeft ) === 12;

		// Support: Android 4.0 - 4.3 only, Safari <=9.1 - 10.1, iOS <=7.0 - 9.3
		// Some styles come back with percentage values, even though they shouldn't
		div.style.right = "60%";
		pixelBoxStylesVal = roundPixelMeasures( divStyle.right ) === 36;

		// Support: IE 9 - 11 only
		// Detect misreporting of content dimensions for box-sizing:border-box elements
		boxSizingReliableVal = roundPixelMeasures( divStyle.width ) === 36;

		// Support: IE 9 only
		// Detect overflow:scroll screwiness (gh-3699)
		// Support: Chrome <=64
		// Don't get tricked when zoom affects offsetWidth (gh-4029)
		div.style.position = "absolute";
		scrollboxSizeVal = roundPixelMeasures( div.offsetWidth / 3 ) === 12;

		documentElement.removeChild( container );

		// Nullify the div so it wouldn't be stored in the memory and
		// it will also be a sign that checks already performed
		div = null;
	}

	function roundPixelMeasures( measure ) {
		return Math.round( parseFloat( measure ) );
	}

	var pixelPositionVal, boxSizingReliableVal, scrollboxSizeVal, pixelBoxStylesVal,
		reliableTrDimensionsVal, reliableMarginLeftVal,
		container = document.createElement( "div" ),
		div = document.createElement( "div" );

	// Finish early in limited (non-browser) environments
	if ( !div.style ) {
		return;
	}

	// Support: IE <=9 - 11 only
	// Style of cloned element affects source element cloned (trac-8908)
	div.style.backgroundClip = "content-box";
	div.cloneNode( true ).style.backgroundClip = "";
	support.clearCloneStyle = div.style.backgroundClip === "content-box";

	jQuery.extend( support, {
		boxSizingReliable: function() {
			computeStyleTests();
			return boxSizingReliableVal;
		},
		pixelBoxStyles: function() {
			computeStyleTests();
			return pixelBoxStylesVal;
		},
		pixelPosition: function() {
			computeStyleTests();
			return pixelPositionVal;
		},
		reliableMarginLeft: function() {
			computeStyleTests();
			return reliableMarginLeftVal;
		},
		scrollboxSize: function() {
			computeStyleTests();
			return scrollboxSizeVal;
		},

		// Support: IE 9 - 11+, Edge 15 - 18+
		// IE/Edge misreport `getComputedStyle` of table rows with width/height
		// set in CSS while `offset*` properties report correct values.
		// Behavior in IE 9 is more subtle than in newer versions & it passes
		// some versions of this test; make sure not to make it pass there!
		//
		// Support: Firefox 70+
		// Only Firefox includes border widths
		// in computed dimensions. (gh-4529)
		reliableTrDimensions: function() {
			var table, tr, trChild, trStyle;
			if ( reliableTrDimensionsVal == null ) {
				table = document.createElement( "table" );
				tr = document.createElement( "tr" );
				trChild = document.createElement( "div" );

				table.style.cssText = "position:absolute;left:-11111px;border-collapse:separate";
				tr.style.cssText = "border:1px solid";

				// Support: Chrome 86+
				// Height set through cssText does not get applied.
				// Computed height then comes back as 0.
				tr.style.height = "1px";
				trChild.style.height = "9px";

				// Support: Android 8 Chrome 86+
				// In our bodyBackground.html iframe,
				// display for all div elements is set to "inline",
				// which causes a problem only in Android 8 Chrome 86.
				// Ensuring the div is display: block
				// gets around this issue.
				trChild.style.display = "block";

				documentElement
					.appendChild( table )
					.appendChild( tr )
					.appendChild( trChild );

				trStyle = window.getComputedStyle( tr );
				reliableTrDimensionsVal = ( parseInt( trStyle.height, 10 ) +
					parseInt( trStyle.borderTopWidth, 10 ) +
					parseInt( trStyle.borderBottomWidth, 10 ) ) === tr.offsetHeight;

				documentElement.removeChild( table );
			}
			return reliableTrDimensionsVal;
		}
	} );
} )();


function curCSS( elem, name, computed ) {
	var width, minWidth, maxWidth, ret,
		isCustomProp = rcustomProp.test( name ),

		// Support: Firefox 51+
		// Retrieving style before computed somehow
		// fixes an issue with getting wrong values
		// on detached elements
		style = elem.style;

	computed = computed || getStyles( elem );

	// getPropertyValue is needed for:
	//   .css('filter') (IE 9 only, trac-12537)
	//   .css('--customProperty) (gh-3144)
	if ( computed ) {

		// Support: IE <=9 - 11+
		// IE only supports `"float"` in `getPropertyValue`; in computed styles
		// it's only available as `"cssFloat"`. We no longer modify properties
		// sent to `.css()` apart from camelCasing, so we need to check both.
		// Normally, this would create difference in behavior: if
		// `getPropertyValue` returns an empty string, the value returned
		// by `.css()` would be `undefined`. This is usually the case for
		// disconnected elements. However, in IE even disconnected elements
		// with no styles return `"none"` for `getPropertyValue( "float" )`
		ret = computed.getPropertyValue( name ) || computed[ name ];

		if ( isCustomProp && ret ) {

			// Support: Firefox 105+, Chrome <=105+
			// Spec requires trimming whitespace for custom properties (gh-4926).
			// Firefox only trims leading whitespace. Chrome just collapses
			// both leading & trailing whitespace to a single space.
			//
			// Fall back to `undefined` if empty string returned.
			// This collapses a missing definition with property defined
			// and set to an empty string but there's no standard API
			// allowing us to differentiate them without a performance penalty
			// and returning `undefined` aligns with older jQuery.
			//
			// rtrimCSS treats U+000D CARRIAGE RETURN and U+000C FORM FEED
			// as whitespace while CSS does not, but this is not a problem
			// because CSS preprocessing replaces them with U+000A LINE FEED
			// (which *is* CSS whitespace)
			// https://www.w3.org/TR/css-syntax-3/#input-preprocessing
			ret = ret.replace( rtrimCSS, "$1" ) || undefined;
		}

		if ( ret === "" && !isAttached( elem ) ) {
			ret = jQuery.style( elem, name );
		}

		// A tribute to the "awesome hack by Dean Edwards"
		// Android Browser returns percentage for some values,
		// but width seems to be reliably pixels.
		// This is against the CSSOM draft spec:
		// https://drafts.csswg.org/cssom/#resolved-values
		if ( !support.pixelBoxStyles() && rnumnonpx.test( ret ) && rboxStyle.test( name ) ) {

			// Remember the original values
			width = style.width;
			minWidth = style.minWidth;
			maxWidth = style.maxWidth;

			// Put in the new values to get a computed value out
			style.minWidth = style.maxWidth = style.width = ret;
			ret = computed.width;

			// Revert the changed values
			style.width = width;
			style.minWidth = minWidth;
			style.maxWidth = maxWidth;
		}
	}

	return ret !== undefined ?

		// Support: IE <=9 - 11 only
		// IE returns zIndex value as an integer.
		ret + "" :
		ret;
}


function addGetHookIf( conditionFn, hookFn ) {

	// Define the hook, we'll check on the first run if it's really needed.
	return {
		get: function() {
			if ( conditionFn() ) {

				// Hook not needed (or it's not possible to use it due
				// to missing dependency), remove it.
				delete this.get;
				return;
			}

			// Hook needed; redefine it so that the support test is not executed again.
			return ( this.get = hookFn ).apply( this, arguments );
		}
	};
}


var cssPrefixes = [ "Webkit", "Moz", "ms" ],
	emptyStyle = document.createElement( "div" ).style,
	vendorProps = {};

// Return a vendor-prefixed property or undefined
function vendorPropName( name ) {

	// Check for vendor prefixed names
	var capName = name[ 0 ].toUpperCase() + name.slice( 1 ),
		i = cssPrefixes.length;

	while ( i-- ) {
		name = cssPrefixes[ i ] + capName;
		if ( name in emptyStyle ) {
			return name;
		}
	}
}

// Return a potentially-mapped jQuery.cssProps or vendor prefixed property
function finalPropName( name ) {
	var final = jQuery.cssProps[ name ] || vendorProps[ name ];

	if ( final ) {
		return final;
	}
	if ( name in emptyStyle ) {
		return name;
	}
	return vendorProps[ name ] = vendorPropName( name ) || name;
}


var

	// Swappable if display is none or starts with table
	// except "table", "table-cell", or "table-caption"
	// See here for display values: https://developer.mozilla.org/en-US/docs/CSS/display
	rdisplayswap = /^(none|table(?!-c[ea]).+)/,
	cssShow = { position: "absolute", visibility: "hidden", display: "block" },
	cssNormalTransform = {
		letterSpacing: "0",
		fontWeight: "400"
	};

function setPositiveNumber( _elem, value, subtract ) {

	// Any relative (+/-) values have already been
	// normalized at this point
	var matches = rcssNum.exec( value );
	return matches ?

		// Guard against undefined "subtract", e.g., when used as in cssHooks
		Math.max( 0, matches[ 2 ] - ( subtract || 0 ) ) + ( matches[ 3 ] || "px" ) :
		value;
}

function boxModelAdjustment( elem, dimension, box, isBorderBox, styles, computedVal ) {
	var i = dimension === "width" ? 1 : 0,
		extra = 0,
		delta = 0;

	// Adjustment may not be necessary
	if ( box === ( isBorderBox ? "border" : "content" ) ) {
		return 0;
	}

	for ( ; i < 4; i += 2 ) {

		// Both box models exclude margin
		if ( box === "margin" ) {
			delta += jQuery.css( elem, box + cssExpand[ i ], true, styles );
		}

		// If we get here with a content-box, we're seeking "padding" or "border" or "margin"
		if ( !isBorderBox ) {

			// Add padding
			delta += jQuery.css( elem, "padding" + cssExpand[ i ], true, styles );

			// For "border" or "margin", add border
			if ( box !== "padding" ) {
				delta += jQuery.css( elem, "border" + cssExpand[ i ] + "Width", true, styles );

			// But still keep track of it otherwise
			} else {
				extra += jQuery.css( elem, "border" + cssExpand[ i ] + "Width", true, styles );
			}

		// If we get here with a border-box (content + padding + border), we're seeking "content" or
		// "padding" or "margin"
		} else {

			// For "content", subtract padding
			if ( box === "content" ) {
				delta -= jQuery.css( elem, "padding" + cssExpand[ i ], true, styles );
			}

			// For "content" or "padding", subtract border
			if ( box !== "margin" ) {
				delta -= jQuery.css( elem, "border" + cssExpand[ i ] + "Width", true, styles );
			}
		}
	}

	// Account for positive content-box scroll gutter when requested by providing computedVal
	if ( !isBorderBox && computedVal >= 0 ) {

		// offsetWidth/offsetHeight is a rounded sum of content, padding, scroll gutter, and border
		// Assuming integer scroll gutter, subtract the rest and round down
		delta += Math.max( 0, Math.ceil(
			elem[ "offset" + dimension[ 0 ].toUpperCase() + dimension.slice( 1 ) ] -
			computedVal -
			delta -
			extra -
			0.5

		// If offsetWidth/offsetHeight is unknown, then we can't determine content-box scroll gutter
		// Use an explicit zero to avoid NaN (gh-3964)
		) ) || 0;
	}

	return delta;
}

function getWidthOrHeight( elem, dimension, extra ) {

	// Start with computed style
	var styles = getStyles( elem ),

		// To avoid forcing a reflow, only fetch boxSizing if we need it (gh-4322).
		// Fake content-box until we know it's needed to know the true value.
		boxSizingNeeded = !support.boxSizingReliable() || extra,
		isBorderBox = boxSizingNeeded &&
			jQuery.css( elem, "boxSizing", false, styles ) === "border-box",
		valueIsBorderBox = isBorderBox,

		val = curCSS( elem, dimension, styles ),
		offsetProp = "offset" + dimension[ 0 ].toUpperCase() + dimension.slice( 1 );

	// Support: Firefox <=54
	// Return a confounding non-pixel value or feign ignorance, as appropriate.
	if ( rnumnonpx.test( val ) ) {
		if ( !extra ) {
			return val;
		}
		val = "auto";
	}


	// Support: IE 9 - 11 only
	// Use offsetWidth/offsetHeight for when box sizing is unreliable.
	// In those cases, the computed value can be trusted to be border-box.
	if ( ( !support.boxSizingReliable() && isBorderBox ||

		// Support: IE 10 - 11+, Edge 15 - 18+
		// IE/Edge misreport `getComputedStyle` of table rows with width/height
		// set in CSS while `offset*` properties report correct values.
		// Interestingly, in some cases IE 9 doesn't suffer from this issue.
		!support.reliableTrDimensions() && nodeName( elem, "tr" ) ||

		// Fall back to offsetWidth/offsetHeight when value is "auto"
		// This happens for inline elements with no explicit setting (gh-3571)
		val === "auto" ||

		// Support: Android <=4.1 - 4.3 only
		// Also use offsetWidth/offsetHeight for misreported inline dimensions (gh-3602)
		!parseFloat( val ) && jQuery.css( elem, "display", false, styles ) === "inline" ) &&

		// Make sure the element is visible & connected
		elem.getClientRects().length ) {

		isBorderBox = jQuery.css( elem, "boxSizing", false, styles ) === "border-box";

		// Where available, offsetWidth/offsetHeight approximate border box dimensions.
		// Where not available (e.g., SVG), assume unreliable box-sizing and interpret the
		// retrieved value as a content box dimension.
		valueIsBorderBox = offsetProp in elem;
		if ( valueIsBorderBox ) {
			val = elem[ offsetProp ];
		}
	}

	// Normalize "" and auto
	val = parseFloat( val ) || 0;

	// Adjust for the element's box model
	return ( val +
		boxModelAdjustment(
			elem,
			dimension,
			extra || ( isBorderBox ? "border" : "content" ),
			valueIsBorderBox,
			styles,

			// Provide the current computed size to request scroll gutter calculation (gh-3589)
			val
		)
	) + "px";
}

jQuery.extend( {

	// Add in style property hooks for overriding the default
	// behavior of getting and setting a style property
	cssHooks: {
		opacity: {
			get: function( elem, computed ) {
				if ( computed ) {

					// We should always get a number back from opacity
					var ret = curCSS( elem, "opacity" );
					return ret === "" ? "1" : ret;
				}
			}
		}
	},

	// Don't automatically add "px" to these possibly-unitless properties
	cssNumber: {
		"animationIterationCount": true,
		"columnCount": true,
		"fillOpacity": true,
		"flexGrow": true,
		"flexShrink": true,
		"fontWeight": true,
		"gridArea": true,
		"gridColumn": true,
		"gridColumnEnd": true,
		"gridColumnStart": true,
		"gridRow": true,
		"gridRowEnd": true,
		"gridRowStart": true,
		"lineHeight": true,
		"opacity": true,
		"order": true,
		"orphans": true,
		"widows": true,
		"zIndex": true,
		"zoom": true
	},

	// Add in properties whose names you wish to fix before
	// setting or getting the value
	cssProps: {},

	// Get and set the style property on a DOM Node
	style: function( elem, name, value, extra ) {

		// Don't set styles on text and comment nodes
		if ( !elem || elem.nodeType === 3 || elem.nodeType === 8 || !elem.style ) {
			return;
		}

		// Make sure that we're working with the right name
		var ret, type, hooks,
			origName = camelCase( name ),
			isCustomProp = rcustomProp.test( name ),
			style = elem.style;

		// Make sure that we're working with the right name. We don't
		// want to query the value if it is a CSS custom property
		// since they are user-defined.
		if ( !isCustomProp ) {
			name = finalPropName( origName );
		}

		// Gets hook for the prefixed version, then unprefixed version
		hooks = jQuery.cssHooks[ name ] || jQuery.cssHooks[ origName ];

		// Check if we're setting a value
		if ( value !== undefined ) {
			type = typeof value;

			// Convert "+=" or "-=" to relative numbers (trac-7345)
			if ( type === "string" && ( ret = rcssNum.exec( value ) ) && ret[ 1 ] ) {
				value = adjustCSS( elem, name, ret );

				// Fixes bug trac-9237
				type = "number";
			}

			// Make sure that null and NaN values aren't set (trac-7116)
			if ( value == null || value !== value ) {
				return;
			}

			// If a number was passed in, add the unit (except for certain CSS properties)
			// The isCustomProp check can be removed in jQuery 4.0 when we only auto-append
			// "px" to a few hardcoded values.
			if ( type === "number" && !isCustomProp ) {
				value += ret && ret[ 3 ] || ( jQuery.cssNumber[ origName ] ? "" : "px" );
			}

			// background-* props affect original clone's values
			if ( !support.clearCloneStyle && value === "" && name.indexOf( "background" ) === 0 ) {
				style[ name ] = "inherit";
			}

			// If a hook was provided, use that value, otherwise just set the specified value
			if ( !hooks || !( "set" in hooks ) ||
				( value = hooks.set( elem, value, extra ) ) !== undefined ) {

				if ( isCustomProp ) {
					style.setProperty( name, value );
				} else {
					style[ name ] = value;
				}
			}

		} else {

			// If a hook was provided get the non-computed value from there
			if ( hooks && "get" in hooks &&
				( ret = hooks.get( elem, false, extra ) ) !== undefined ) {

				return ret;
			}

			// Otherwise just get the value from the style object
			return style[ name ];
		}
	},

	css: function( elem, name, extra, styles ) {
		var val, num, hooks,
			origName = camelCase( name ),
			isCustomProp = rcustomProp.test( name );

		// Make sure that we're working with the right name. We don't
		// want to modify the value if it is a CSS custom property
		// since they are user-defined.
		if ( !isCustomProp ) {
			name = finalPropName( origName );
		}

		// Try prefixed name followed by the unprefixed name
		hooks = jQuery.cssHooks[ name ] || jQuery.cssHooks[ origName ];

		// If a hook was provided get the computed value from there
		if ( hooks && "get" in hooks ) {
			val = hooks.get( elem, true, extra );
		}

		// Otherwise, if a way to get the computed value exists, use that
		if ( val === undefined ) {
			val = curCSS( elem, name, styles );
		}

		// Convert "normal" to computed value
		if ( val === "normal" && name in cssNormalTransform ) {
			val = cssNormalTransform[ name ];
		}

		// Make numeric if forced or a qualifier was provided and val looks numeric
		if ( extra === "" || extra ) {
			num = parseFloat( val );
			return extra === true || isFinite( num ) ? num || 0 : val;
		}

		return val;
	}
} );

jQuery.each( [ "height", "width" ], function( _i, dimension ) {
	jQuery.cssHooks[ dimension ] = {
		get: function( elem, computed, extra ) {
			if ( computed ) {

				// Certain elements can have dimension info if we invisibly show them
				// but it must have a current display style that would benefit
				return rdisplayswap.test( jQuery.css( elem, "display" ) ) &&

					// Support: Safari 8+
					// Table columns in Safari have non-zero offsetWidth & zero
					// getBoundingClientRect().width unless display is changed.
					// Support: IE <=11 only
					// Running getBoundingClientRect on a disconnected node
					// in IE throws an error.
					( !elem.getClientRects().length || !elem.getBoundingClientRect().width ) ?
					swap( elem, cssShow, function() {
						return getWidthOrHeight( elem, dimension, extra );
					} ) :
					getWidthOrHeight( elem, dimension, extra );
			}
		},

		set: function( elem, value, extra ) {
			var matches,
				styles = getStyles( elem ),

				// Only read styles.position if the test has a chance to fail
				// to avoid forcing a reflow.
				scrollboxSizeBuggy = !support.scrollboxSize() &&
					styles.position === "absolute",

				// To avoid forcing a reflow, only fetch boxSizing if we need it (gh-3991)
				boxSizingNeeded = scrollboxSizeBuggy || extra,
				isBorderBox = boxSizingNeeded &&
					jQuery.css( elem, "boxSizing", false, styles ) === "border-box",
				subtract = extra ?
					boxModelAdjustment(
						elem,
						dimension,
						extra,
						isBorderBox,
						styles
					) :
					0;

			// Account for unreliable border-box dimensions by comparing offset* to computed and
			// faking a content-box to get border and padding (gh-3699)
			if ( isBorderBox && scrollboxSizeBuggy ) {
				subtract -= Math.ceil(
					elem[ "offset" + dimension[ 0 ].toUpperCase() + dimension.slice( 1 ) ] -
					parseFloat( styles[ dimension ] ) -
					boxModelAdjustment( elem, dimension, "border", false, styles ) -
					0.5
				);
			}

			// Convert to pixels if value adjustment is needed
			if ( subtract && ( matches = rcssNum.exec( value ) ) &&
				( matches[ 3 ] || "px" ) !== "px" ) {

				elem.style[ dimension ] = value;
				value = jQuery.css( elem, dimension );
			}

			return setPositiveNumber( elem, value, subtract );
		}
	};
} );

jQuery.cssHooks.marginLeft = addGetHookIf( support.reliableMarginLeft,
	function( elem, computed ) {
		if ( computed ) {
			return ( parseFloat( curCSS( elem, "marginLeft" ) ) ||
				elem.getBoundingClientRect().left -
					swap( elem, { marginLeft: 0 }, function() {
						return elem.getBoundingClientRect().left;
					} )
			) + "px";
		}
	}
);

// These hooks are used by animate to expand properties
jQuery.each( {
	margin: "",
	padding: "",
	border: "Width"
}, function( prefix, suffix ) {
	jQuery.cssHooks[ prefix + suffix ] = {
		expand: function( value ) {
			var i = 0,
				expanded = {},

				// Assumes a single number if not a string
				parts = typeof value === "string" ? value.split( " " ) : [ value ];

			for ( ; i < 4; i++ ) {
				expanded[ prefix + cssExpand[ i ] + suffix ] =
					parts[ i ] || parts[ i - 2 ] || parts[ 0 ];
			}

			return expanded;
		}
	};

	if ( prefix !== "margin" ) {
		jQuery.cssHooks[ prefix + suffix ].set = setPositiveNumber;
	}
} );

jQuery.fn.extend( {
	css: function( name, value ) {
		return access( this, function( elem, name, value ) {
			var styles, len,
				map = {},
				i = 0;

			if ( Array.isArray( name ) ) {
				styles = getStyles( elem );
				len = name.length;

				for ( ; i < len; i++ ) {
					map[ name[ i ] ] = jQuery.css( elem, name[ i ], false, styles );
				}

				return map;
			}

			return value !== undefined ?
				jQuery.style( elem, name, value ) :
				jQuery.css( elem, name );
		}, name, value, arguments.length > 1 );
	}
} );


function Tween( elem, options, prop, end, easing ) {
	return new Tween.prototype.init( elem, options, prop, end, easing );
}
jQuery.Tween = Tween;

Tween.prototype = {
	constructor: Tween,
	init: function( elem, options, prop, end, easing, unit ) {
		this.elem = elem;
		this.prop = prop;
		this.easing = easing || jQuery.easing._default;
		this.options = options;
		this.start = this.now = this.cur();
		this.end = end;
		this.unit = unit || ( jQuery.cssNumber[ prop ] ? "" : "px" );
	},
	cur: function() {
		var hooks = Tween.propHooks[ this.prop ];

		return hooks && hooks.get ?
			hooks.get( this ) :
			Tween.propHooks._default.get( this );
	},
	run: function( percent ) {
		var eased,
			hooks = Tween.propHooks[ this.prop ];

		if ( this.options.duration ) {
			this.pos = eased = jQuery.easing[ this.easing ](
				percent, this.options.duration * percent, 0, 1, this.options.duration
			);
		} else {
			this.pos = eased = percent;
		}
		this.now = ( this.end - this.start ) * eased + this.start;

		if ( this.options.step ) {
			this.options.step.call( this.elem, this.now, this );
		}

		if ( hooks && hooks.set ) {
			hooks.set( this );
		} else {
			Tween.propHooks._default.set( this );
		}
		return this;
	}
};

Tween.prototype.init.prototype = Tween.prototype;

Tween.propHooks = {
	_default: {
		get: function( tween ) {
			var result;

			// Use a property on the element directly when it is not a DOM element,
			// or when there is no matching style property that exists.
			if ( tween.elem.nodeType !== 1 ||
				tween.elem[ tween.prop ] != null && tween.elem.style[ tween.prop ] == null ) {
				return tween.elem[ tween.prop ];
			}

			// Passing an empty string as a 3rd parameter to .css will automatically
			// attempt a parseFloat and fallback to a string if the parse fails.
			// Simple values such as "10px" are parsed to Float;
			// complex values such as "rotate(1rad)" are returned as-is.
			result = jQuery.css( tween.elem, tween.prop, "" );

			// Empty strings, null, undefined and "auto" are converted to 0.
			return !result || result === "auto" ? 0 : result;
		},
		set: function( tween ) {

			// Use step hook for back compat.
			// Use cssHook if its there.
			// Use .style if available and use plain properties where available.
			if ( jQuery.fx.step[ tween.prop ] ) {
				jQuery.fx.step[ tween.prop ]( tween );
			} else if ( tween.elem.nodeType === 1 && (
				jQuery.cssHooks[ tween.prop ] ||
					tween.elem.style[ finalPropName( tween.prop ) ] != null ) ) {
				jQuery.style( tween.elem, tween.prop, tween.now + tween.unit );
			} else {
				tween.elem[ tween.prop ] = tween.now;
			}
		}
	}
};

// Support: IE <=9 only
// Panic based approach to setting things on disconnected nodes
Tween.propHooks.scrollTop = Tween.propHooks.scrollLeft = {
	set: function( tween ) {
		if ( tween.elem.nodeType && tween.elem.parentNode ) {
			tween.elem[ tween.prop ] = tween.now;
		}
	}
};

jQuery.easing = {
	linear: function( p ) {
		return p;
	},
	swing: function( p ) {
		return 0.5 - Math.cos( p * Math.PI ) / 2;
	},
	_default: "swing"
};

jQuery.fx = Tween.prototype.init;

// Back compat <1.8 extension point
jQuery.fx.step = {};




var
	fxNow, inProgress,
	rfxtypes = /^(?:toggle|show|hide)$/,
	rrun = /queueHooks$/;

function schedule() {
	if ( inProgress ) {
		if ( document.hidden === false && window.requestAnimationFrame ) {
			window.requestAnimationFrame( schedule );
		} else {
			window.setTimeout( schedule, jQuery.fx.interval );
		}

		jQuery.fx.tick();
	}
}

// Animations created synchronously will run synchronously
function createFxNow() {
	window.setTimeout( function() {
		fxNow = undefined;
	} );
	return ( fxNow = Date.now() );
}

// Generate parameters to create a standard animation
function genFx( type, includeWidth ) {
	var which,
		i = 0,
		attrs = { height: type };

	// If we include width, step value is 1 to do all cssExpand values,
	// otherwise step value is 2 to skip over Left and Right
	includeWidth = includeWidth ? 1 : 0;
	for ( ; i < 4; i += 2 - includeWidth ) {
		which = cssExpand[ i ];
		attrs[ "margin" + which ] = attrs[ "padding" + which ] = type;
	}

	if ( includeWidth ) {
		attrs.opacity = attrs.width = type;
	}

	return attrs;
}

function createTween( value, prop, animation ) {
	var tween,
		collection = ( Animation.tweeners[ prop ] || [] ).concat( Animation.tweeners[ "*" ] ),
		index = 0,
		length = collection.length;
	for ( ; index < length; index++ ) {
		if ( ( tween = collection[ index ].call( animation, prop, value ) ) ) {

			// We're done with this property
			return tween;
		}
	}
}

function defaultPrefilter( elem, props, opts ) {
	var prop, value, toggle, hooks, oldfire, propTween, restoreDisplay, display,
		isBox = "width" in props || "height" in props,
		anim = this,
		orig = {},
		style = elem.style,
		hidden = elem.nodeType && isHiddenWithinTree( elem ),
		dataShow = dataPriv.get( elem, "fxshow" );

	// Queue-skipping animations hijack the fx hooks
	if ( !opts.queue ) {
		hooks = jQuery._queueHooks( elem, "fx" );
		if ( hooks.unqueued == null ) {
			hooks.unqueued = 0;
			oldfire = hooks.empty.fire;
			hooks.empty.fire = function() {
				if ( !hooks.unqueued ) {
					oldfire();
				}
			};
		}
		hooks.unqueued++;

		anim.always( function() {

			// Ensure the complete handler is called before this completes
			anim.always( function() {
				hooks.unqueued--;
				if ( !jQuery.queue( elem, "fx" ).length ) {
					hooks.empty.fire();
				}
			} );
		} );
	}

	// Detect show/hide animations
	for ( prop in props ) {
		value = props[ prop ];
		if ( rfxtypes.test( value ) ) {
			delete props[ prop ];
			toggle = toggle || value === "toggle";
			if ( value === ( hidden ? "hide" : "show" ) ) {

				// Pretend to be hidden if this is a "show" and
				// there is still data from a stopped show/hide
				if ( value === "show" && dataShow && dataShow[ prop ] !== undefined ) {
					hidden = true;

				// Ignore all other no-op show/hide data
				} else {
					continue;
				}
			}
			orig[ prop ] = dataShow && dataShow[ prop ] || jQuery.style( elem, prop );
		}
	}

	// Bail out if this is a no-op like .hide().hide()
	propTween = !jQuery.isEmptyObject( props );
	if ( !propTween && jQuery.isEmptyObject( orig ) ) {
		return;
	}

	// Restrict "overflow" and "display" styles during box animations
	if ( isBox && elem.nodeType === 1 ) {

		// Support: IE <=9 - 11, Edge 12 - 15
		// Record all 3 overflow attributes because IE does not infer the shorthand
		// from identically-valued overflowX and overflowY and Edge just mirrors
		// the overflowX value there.
		opts.overflow = [ style.overflow, style.overflowX, style.overflowY ];

		// Identify a display type, preferring old show/hide data over the CSS cascade
		restoreDisplay = dataShow && dataShow.display;
		if ( restoreDisplay == null ) {
			restoreDisplay = dataPriv.get( elem, "display" );
		}
		display = jQuery.css( elem, "display" );
		if ( display === "none" ) {
			if ( restoreDisplay ) {
				display = restoreDisplay;
			} else {

				// Get nonempty value(s) by temporarily forcing visibility
				showHide( [ elem ], true );
				restoreDisplay = elem.style.display || restoreDisplay;
				display = jQuery.css( elem, "display" );
				showHide( [ elem ] );
			}
		}

		// Animate inline elements as inline-block
		if ( display === "inline" || display === "inline-block" && restoreDisplay != null ) {
			if ( jQuery.css( elem, "float" ) === "none" ) {

				// Restore the original display value at the end of pure show/hide animations
				if ( !propTween ) {
					anim.done( function() {
						style.display = restoreDisplay;
					} );
					if ( restoreDisplay == null ) {
						display = style.display;
						restoreDisplay = display === "none" ? "" : display;
					}
				}
				style.display = "inline-block";
			}
		}
	}

	if ( opts.overflow ) {
		style.overflow = "hidden";
		anim.always( function() {
			style.overflow = opts.overflow[ 0 ];
			style.overflowX = opts.overflow[ 1 ];
			style.overflowY = opts.overflow[ 2 ];
		} );
	}

	// Implement show/hide animations
	propTween = false;
	for ( prop in orig ) {

		// General show/hide setup for this element animation
		if ( !propTween ) {
			if ( dataShow ) {
				if ( "hidden" in dataShow ) {
					hidden = dataShow.hidden;
				}
			} else {
				dataShow = dataPriv.access( elem, "fxshow", { display: restoreDisplay } );
			}

			// Store hidden/visible for toggle so `.stop().toggle()` "reverses"
			if ( toggle ) {
				dataShow.hidden = !hidden;
			}

			// Show elements before animating them
			if ( hidden ) {
				showHide( [ elem ], true );
			}

			/* eslint-disable no-loop-func */

			anim.done( function() {

				/* eslint-enable no-loop-func */

				// The final step of a "hide" animation is actually hiding the element
				if ( !hidden ) {
					showHide( [ elem ] );
				}
				dataPriv.remove( elem, "fxshow" );
				for ( prop in orig ) {
					jQuery.style( elem, prop, orig[ prop ] );
				}
			} );
		}

		// Per-property setup
		propTween = createTween( hidden ? dataShow[ prop ] : 0, prop, anim );
		if ( !( prop in dataShow ) ) {
			dataShow[ prop ] = propTween.start;
			if ( hidden ) {
				propTween.end = propTween.start;
				propTween.start = 0;
			}
		}
	}
}

function propFilter( props, specialEasing ) {
	var index, name, easing, value, hooks;

	// camelCase, specialEasing and expand cssHook pass
	for ( index in props ) {
		name = camelCase( index );
		easing = specialEasing[ name ];
		value = props[ index ];
		if ( Array.isArray( value ) ) {
			easing = value[ 1 ];
			value = props[ index ] = value[ 0 ];
		}

		if ( index !== name ) {
			props[ name ] = value;
			delete props[ index ];
		}

		hooks = jQuery.cssHooks[ name ];
		if ( hooks && "expand" in hooks ) {
			value = hooks.expand( value );
			delete props[ name ];

			// Not quite $.extend, this won't overwrite existing keys.
			// Reusing 'index' because we have the correct "name"
			for ( index in value ) {
				if ( !( index in props ) ) {
					props[ index ] = value[ index ];
					specialEasing[ index ] = easing;
				}
			}
		} else {
			specialEasing[ name ] = easing;
		}
	}
}

function Animation( elem, properties, options ) {
	var result,
		stopped,
		index = 0,
		length = Animation.prefilters.length,
		deferred = jQuery.Deferred().always( function() {

			// Don't match elem in the :animated selector
			delete tick.elem;
		} ),
		tick = function() {
			if ( stopped ) {
				return false;
			}
			var currentTime = fxNow || createFxNow(),
				remaining = Math.max( 0, animation.startTime + animation.duration - currentTime ),

				// Support: Android 2.3 only
				// Archaic crash bug won't allow us to use `1 - ( 0.5 || 0 )` (trac-12497)
				temp = remaining / animation.duration || 0,
				percent = 1 - temp,
				index = 0,
				length = animation.tweens.length;

			for ( ; index < length; index++ ) {
				animation.tweens[ index ].run( percent );
			}

			deferred.notifyWith( elem, [ animation, percent, remaining ] );

			// If there's more to do, yield
			if ( percent < 1 && length ) {
				return remaining;
			}

			// If this was an empty animation, synthesize a final progress notification
			if ( !length ) {
				deferred.notifyWith( elem, [ animation, 1, 0 ] );
			}

			// Resolve the animation and report its conclusion
			deferred.resolveWith( elem, [ animation ] );
			return false;
		},
		animation = deferred.promise( {
			elem: elem,
			props: jQuery.extend( {}, properties ),
			opts: jQuery.extend( true, {
				specialEasing: {},
				easing: jQuery.easing._default
			}, options ),
			originalProperties: properties,
			originalOptions: options,
			startTime: fxNow || createFxNow(),
			duration: options.duration,
			tweens: [],
			createTween: function( prop, end ) {
				var tween = jQuery.Tween( elem, animation.opts, prop, end,
					animation.opts.specialEasing[ prop ] || animation.opts.easing );
				animation.tweens.push( tween );
				return tween;
			},
			stop: function( gotoEnd ) {
				var index = 0,

					// If we are going to the end, we want to run all the tweens
					// otherwise we skip this part
					length = gotoEnd ? animation.tweens.length : 0;
				if ( stopped ) {
					return this;
				}
				stopped = true;
				for ( ; index < length; index++ ) {
					animation.tweens[ index ].run( 1 );
				}

				// Resolve when we played the last frame; otherwise, reject
				if ( gotoEnd ) {
					deferred.notifyWith( elem, [ animation, 1, 0 ] );
					deferred.resolveWith( elem, [ animation, gotoEnd ] );
				} else {
					deferred.rejectWith( elem, [ animation, gotoEnd ] );
				}
				return this;
			}
		} ),
		props = animation.props;

	propFilter( props, animation.opts.specialEasing );

	for ( ; index < length; index++ ) {
		result = Animation.prefilters[ index ].call( animation, elem, props, animation.opts );
		if ( result ) {
			if ( isFunction( result.stop ) ) {
				jQuery._queueHooks( animation.elem, animation.opts.queue ).stop =
					result.stop.bind( result );
			}
			return result;
		}
	}

	jQuery.map( props, createTween, animation );

	if ( isFunction( animation.opts.start ) ) {
		animation.opts.start.call( elem, animation );
	}

	// Attach callbacks from options
	animation
		.progress( animation.opts.progress )
		.done( animation.opts.done, animation.opts.complete )
		.fail( animation.opts.fail )
		.always( animation.opts.always );

	jQuery.fx.timer(
		jQuery.extend( tick, {
			elem: elem,
			anim: animation,
			queue: animation.opts.queue
		} )
	);

	return animation;
}

jQuery.Animation = jQuery.extend( Animation, {

	tweeners: {
		"*": [ function( prop, value ) {
			var tween = this.createTween( prop, value );
			adjustCSS( tween.elem, prop, rcssNum.exec( value ), tween );
			return tween;
		} ]
	},

	tweener: function( props, callback ) {
		if ( isFunction( props ) ) {
			callback = props;
			props = [ "*" ];
		} else {
			props = props.match( rnothtmlwhite );
		}

		var prop,
			index = 0,
			length = props.length;

		for ( ; index < length; index++ ) {
			prop = props[ index ];
			Animation.tweeners[ prop ] = Animation.tweeners[ prop ] || [];
			Animation.tweeners[ prop ].unshift( callback );
		}
	},

	prefilters: [ defaultPrefilter ],

	prefilter: function( callback, prepend ) {
		if ( prepend ) {
			Animation.prefilters.unshift( callback );
		} else {
			Animation.prefilters.push( callback );
		}
	}
} );

jQuery.speed = function( speed, easing, fn ) {
	var opt = speed && typeof speed === "object" ? jQuery.extend( {}, speed ) : {
		complete: fn || !fn && easing ||
			isFunction( speed ) && speed,
		duration: speed,
		easing: fn && easing || easing && !isFunction( easing ) && easing
	};

	// Go to the end state if fx are off
	if ( jQuery.fx.off ) {
		opt.duration = 0;

	} else {
		if ( typeof opt.duration !== "number" ) {
			if ( opt.duration in jQuery.fx.speeds ) {
				opt.duration = jQuery.fx.speeds[ opt.duration ];

			} else {
				opt.duration = jQuery.fx.speeds._default;
			}
		}
	}

	// Normalize opt.queue - true/undefined/null -> "fx"
	if ( opt.queue == null || opt.queue === true ) {
		opt.queue = "fx";
	}

	// Queueing
	opt.old = opt.complete;

	opt.complete = function() {
		if ( isFunction( opt.old ) ) {
			opt.old.call( this );
		}

		if ( opt.queue ) {
			jQuery.dequeue( this, opt.queue );
		}
	};

	return opt;
};

jQuery.fn.extend( {
	fadeTo: function( speed, to, easing, callback ) {

		// Show any hidden elements after setting opacity to 0
		return this.filter( isHiddenWithinTree ).css( "opacity", 0 ).show()

			// Animate to the value specified
			.end().animate( { opacity: to }, speed, easing, callback );
	},
	animate: function( prop, speed, easing, callback ) {
		var empty = jQuery.isEmptyObject( prop ),
			optall = jQuery.speed( speed, easing, callback ),
			doAnimation = function() {

				// Operate on a copy of prop so per-property easing won't be lost
				var anim = Animation( this, jQuery.extend( {}, prop ), optall );

				// Empty animations, or finishing resolves immediately
				if ( empty || dataPriv.get( this, "finish" ) ) {
					anim.stop( true );
				}
			};

		doAnimation.finish = doAnimation;

		return empty || optall.queue === false ?
			this.each( doAnimation ) :
			this.queue( optall.queue, doAnimation );
	},
	stop: function( type, clearQueue, gotoEnd ) {
		var stopQueue = function( hooks ) {
			var stop = hooks.stop;
			delete hooks.stop;
			stop( gotoEnd );
		};

		if ( typeof type !== "string" ) {
			gotoEnd = clearQueue;
			clearQueue = type;
			type = undefined;
		}
		if ( clearQueue ) {
			this.queue( type || "fx", [] );
		}

		return this.each( function() {
			var dequeue = true,
				index = type != null && type + "queueHooks",
				timers = jQuery.timers,
				data = dataPriv.get( this );

			if ( index ) {
				if ( data[ index ] && data[ index ].stop ) {
					stopQueue( data[ index ] );
				}
			} else {
				for ( index in data ) {
					if ( data[ index ] && data[ index ].stop && rrun.test( index ) ) {
						stopQueue( data[ index ] );
					}
				}
			}

			for ( index = timers.length; index--; ) {
				if ( timers[ index ].elem === this &&
					( type == null || timers[ index ].queue === type ) ) {

					timers[ index ].anim.stop( gotoEnd );
					dequeue = false;
					timers.splice( index, 1 );
				}
			}

			// Start the next in the queue if the last step wasn't forced.
			// Timers currently will call their complete callbacks, which
			// will dequeue but only if they were gotoEnd.
			if ( dequeue || !gotoEnd ) {
				jQuery.dequeue( this, type );
			}
		} );
	},
	finish: function( type ) {
		if ( type !== false ) {
			type = type || "fx";
		}
		return this.each( function() {
			var index,
				data = dataPriv.get( this ),
				queue = data[ type + "queue" ],
				hooks = data[ type + "queueHooks" ],
				timers = jQuery.timers,
				length = queue ? queue.length : 0;

			// Enable finishing flag on private data
			data.finish = true;

			// Empty the queue first
			jQuery.queue( this, type, [] );

			if ( hooks && hooks.stop ) {
				hooks.stop.call( this, true );
			}

			// Look for any active animations, and finish them
			for ( index = timers.length; index--; ) {
				if ( timers[ index ].elem === this && timers[ index ].queue === type ) {
					timers[ index ].anim.stop( true );
					timers.splice( index, 1 );
				}
			}

			// Look for any animations in the old queue and finish them
			for ( index = 0; index < length; index++ ) {
				if ( queue[ index ] && queue[ index ].finish ) {
					queue[ index ].finish.call( this );
				}
			}

			// Turn off finishing flag
			delete data.finish;
		} );
	}
} );

jQuery.each( [ "toggle", "show", "hide" ], function( _i, name ) {
	var cssFn = jQuery.fn[ name ];
	jQuery.fn[ name ] = function( speed, easing, callback ) {
		return speed == null || typeof speed === "boolean" ?
			cssFn.apply( this, arguments ) :
			this.animate( genFx( name, true ), speed, easing, callback );
	};
} );

// Generate shortcuts for custom animations
jQuery.each( {
	slideDown: genFx( "show" ),
	slideUp: genFx( "hide" ),
	slideToggle: genFx( "toggle" ),
	fadeIn: { opacity: "show" },
	fadeOut: { opacity: "hide" },
	fadeToggle: { opacity: "toggle" }
}, function( name, props ) {
	jQuery.fn[ name ] = function( speed, easing, callback ) {
		return this.animate( props, speed, easing, callback );
	};
} );

jQuery.timers = [];
jQuery.fx.tick = function() {
	var timer,
		i = 0,
		timers = jQuery.timers;

	fxNow = Date.now();

	for ( ; i < timers.length; i++ ) {
		timer = timers[ i ];

		// Run the timer and safely remove it when done (allowing for external removal)
		if ( !timer() && timers[ i ] === timer ) {
			timers.splice( i--, 1 );
		}
	}

	if ( !timers.length ) {
		jQuery.fx.stop();
	}
	fxNow = undefined;
};

jQuery.fx.timer = function( timer ) {
	jQuery.timers.push( timer );
	jQuery.fx.start();
};

jQuery.fx.interval = 13;
jQuery.fx.start = function() {
	if ( inProgress ) {
		return;
	}

	inProgress = true;
	schedule();
};

jQuery.fx.stop = function() {
	inProgress = null;
};

jQuery.fx.speeds = {
	slow: 600,
	fast: 200,

	// Default speed
	_default: 400
};


// Based off of the plugin by Clint Helfers, with permission.
jQuery.fn.delay = function( time, type ) {
	time = jQuery.fx ? jQuery.fx.speeds[ time ] || time : time;
	type = type || "fx";

	return this.queue( type, function( next, hooks ) {
		var timeout = window.setTimeout( next, time );
		hooks.stop = function() {
			window.clearTimeout( timeout );
		};
	} );
};


( function() {
	var input = document.createElement( "input" ),
		select = document.createElement( "select" ),
		opt = select.appendChild( document.createElement( "option" ) );

	input.type = "checkbox";

	// Support: Android <=4.3 only
	// Default value for a checkbox should be "on"
	support.checkOn = input.value !== "";

	// Support: IE <=11 only
	// Must access selectedIndex to make default options select
	support.optSelected = opt.selected;

	// Support: IE <=11 only
	// An input loses its value after becoming a radio
	input = document.createElement( "input" );
	input.value = "t";
	input.type = "radio";
	support.radioValue = input.value === "t";
} )();


var boolHook,
	attrHandle = jQuery.expr.attrHandle;

jQuery.fn.extend( {
	attr: function( name, value ) {
		return access( this, jQuery.attr, name, value, arguments.length > 1 );
	},

	removeAttr: function( name ) {
		return this.each( function() {
			jQuery.removeAttr( this, name );
		} );
	}
} );

jQuery.extend( {
	attr: function( elem, name, value ) {
		var ret, hooks,
			nType = elem.nodeType;

		// Don't get/set attributes on text, comment and attribute nodes
		if ( nType === 3 || nType === 8 || nType === 2 ) {
			return;
		}

		// Fallback to prop when attributes are not supported
		if ( typeof elem.getAttribute === "undefined" ) {
			return jQuery.prop( elem, name, value );
		}

		// Attribute hooks are determined by the lowercase version
		// Grab necessary hook if one is defined
		if ( nType !== 1 || !jQuery.isXMLDoc( elem ) ) {
			hooks = jQuery.attrHooks[ name.toLowerCase() ] ||
				( jQuery.expr.match.bool.test( name ) ? boolHook : undefined );
		}

		if ( value !== undefined ) {
			if ( value === null ) {
				jQuery.removeAttr( elem, name );
				return;
			}

			if ( hooks && "set" in hooks &&
				( ret = hooks.set( elem, value, name ) ) !== undefined ) {
				return ret;
			}

			elem.setAttribute( name, value + "" );
			return value;
		}

		if ( hooks && "get" in hooks && ( ret = hooks.get( elem, name ) ) !== null ) {
			return ret;
		}

		ret = jQuery.find.attr( elem, name );

		// Non-existent attributes return null, we normalize to undefined
		return ret == null ? undefined : ret;
	},

	attrHooks: {
		type: {
			set: function( elem, value ) {
				if ( !support.radioValue && value === "radio" &&
					nodeName( elem, "input" ) ) {
					var val = elem.value;
					elem.setAttribute( "type", value );
					if ( val ) {
						elem.value = val;
					}
					return value;
				}
			}
		}
	},

	removeAttr: function( elem, value ) {
		var name,
			i = 0,

			// Attribute names can contain non-HTML whitespace characters
			// https://html.spec.whatwg.org/multipage/syntax.html#attributes-2
			attrNames = value && value.match( rnothtmlwhite );

		if ( attrNames && elem.nodeType === 1 ) {
			while ( ( name = attrNames[ i++ ] ) ) {
				elem.removeAttribute( name );
			}
		}
	}
} );

// Hooks for boolean attributes
boolHook = {
	set: function( elem, value, name ) {
		if ( value === false ) {

			// Remove boolean attributes when set to false
			jQuery.removeAttr( elem, name );
		} else {
			elem.setAttribute( name, name );
		}
		return name;
	}
};

jQuery.each( jQuery.expr.match.bool.source.match( /\w+/g ), function( _i, name ) {
	var getter = attrHandle[ name ] || jQuery.find.attr;

	attrHandle[ name ] = function( elem, name, isXML ) {
		var ret, handle,
			lowercaseName = name.toLowerCase();

		if ( !isXML ) {

			// Avoid an infinite loop by temporarily removing this function from the getter
			handle = attrHandle[ lowercaseName ];
			attrHandle[ lowercaseName ] = ret;
			ret = getter( elem, name, isXML ) != null ?
				lowercaseName :
				null;
			attrHandle[ lowercaseName ] = handle;
		}
		return ret;
	};
} );




var rfocusable = /^(?:input|select|textarea|button)$/i,
	rclickable = /^(?:a|area)$/i;

jQuery.fn.extend( {
	prop: function( name, value ) {
		return access( this, jQuery.prop, name, value, arguments.length > 1 );
	},

	removeProp: function( name ) {
		return this.each( function() {
			delete this[ jQuery.propFix[ name ] || name ];
		} );
	}
} );

jQuery.extend( {
	prop: function( elem, name, value ) {
		var ret, hooks,
			nType = elem.nodeType;

		// Don't get/set properties on text, comment and attribute nodes
		if ( nType === 3 || nType === 8 || nType === 2 ) {
			return;
		}

		if ( nType !== 1 || !jQuery.isXMLDoc( elem ) ) {

			// Fix name and attach hooks
			name = jQuery.propFix[ name ] || name;
			hooks = jQuery.propHooks[ name ];
		}

		if ( value !== undefined ) {
			if ( hooks && "set" in hooks &&
				( ret = hooks.set( elem, value, name ) ) !== undefined ) {
				return ret;
			}

			return ( elem[ name ] = value );
		}

		if ( hooks && "get" in hooks && ( ret = hooks.get( elem, name ) ) !== null ) {
			return ret;
		}

		return elem[ name ];
	},

	propHooks: {
		tabIndex: {
			get: function( elem ) {

				// Support: IE <=9 - 11 only
				// elem.tabIndex doesn't always return the
				// correct value when it hasn't been explicitly set
				// Use proper attribute retrieval (trac-12072)
				var tabindex = jQuery.find.attr( elem, "tabindex" );

				if ( tabindex ) {
					return parseInt( tabindex, 10 );
				}

				if (
					rfocusable.test( elem.nodeName ) ||
					rclickable.test( elem.nodeName ) &&
					elem.href
				) {
					return 0;
				}

				return -1;
			}
		}
	},

	propFix: {
		"for": "htmlFor",
		"class": "className"
	}
} );

// Support: IE <=11 only
// Accessing the selectedIndex property
// forces the browser to respect setting selected
// on the option
// The getter ensures a default option is selected
// when in an optgroup
// eslint rule "no-unused-expressions" is disabled for this code
// since it considers such accessions noop
if ( !support.optSelected ) {
	jQuery.propHooks.selected = {
		get: function( elem ) {

			/* eslint no-unused-expressions: "off" */

			var parent = elem.parentNode;
			if ( parent && parent.parentNode ) {
				parent.parentNode.selectedIndex;
			}
			return null;
		},
		set: function( elem ) {

			/* eslint no-unused-expressions: "off" */

			var parent = elem.parentNode;
			if ( parent ) {
				parent.selectedIndex;

				if ( parent.parentNode ) {
					parent.parentNode.selectedIndex;
				}
			}
		}
	};
}

jQuery.each( [
	"tabIndex",
	"readOnly",
	"maxLength",
	"cellSpacing",
	"cellPadding",
	"rowSpan",
	"colSpan",
	"useMap",
	"frameBorder",
	"contentEditable"
], function() {
	jQuery.propFix[ this.toLowerCase() ] = this;
} );




	// Strip and collapse whitespace according to HTML spec
	// https://infra.spec.whatwg.org/#strip-and-collapse-ascii-whitespace
	function stripAndCollapse( value ) {
		var tokens = value.match( rnothtmlwhite ) || [];
		return tokens.join( " " );
	}


function getClass( elem ) {
	return elem.getAttribute && elem.getAttribute( "class" ) || "";
}

function classesToArray( value ) {
	if ( Array.isArray( value ) ) {
		return value;
	}
	if ( typeof value === "string" ) {
		return value.match( rnothtmlwhite ) || [];
	}
	return [];
}

jQuery.fn.extend( {
	addClass: function( value ) {
		var classNames, cur, curValue, className, i, finalValue;

		if ( isFunction( value ) ) {
			return this.each( function( j ) {
				jQuery( this ).addClass( value.call( this, j, getClass( this ) ) );
			} );
		}

		classNames = classesToArray( value );

		if ( classNames.length ) {
			return this.each( function() {
				curValue = getClass( this );
				cur = this.nodeType === 1 && ( " " + stripAndCollapse( curValue ) + " " );

				if ( cur ) {
					for ( i = 0; i < classNames.length; i++ ) {
						className = classNames[ i ];
						if ( cur.indexOf( " " + className + " " ) < 0 ) {
							cur += className + " ";
						}
					}

					// Only assign if different to avoid unneeded rendering.
					finalValue = stripAndCollapse( cur );
					if ( curValue !== finalValue ) {
						this.setAttribute( "class", finalValue );
					}
				}
			} );
		}

		return this;
	},

	removeClass: function( value ) {
		var classNames, cur, curValue, className, i, finalValue;

		if ( isFunction( value ) ) {
			return this.each( function( j ) {
				jQuery( this ).removeClass( value.call( this, j, getClass( this ) ) );
			} );
		}

		if ( !arguments.length ) {
			return this.attr( "class", "" );
		}

		classNames = classesToArray( value );

		if ( classNames.length ) {
			return this.each( function() {
				curValue = getClass( this );

				// This expression is here for better compressibility (see addClass)
				cur = this.nodeType === 1 && ( " " + stripAndCollapse( curValue ) + " " );

				if ( cur ) {
					for ( i = 0; i < classNames.length; i++ ) {
						className = classNames[ i ];

						// Remove *all* instances
						while ( cur.indexOf( " " + className + " " ) > -1 ) {
							cur = cur.replace( " " + className + " ", " " );
						}
					}

					// Only assign if different to avoid unneeded rendering.
					finalValue = stripAndCollapse( cur );
					if ( curValue !== finalValue ) {
						this.setAttribute( "class", finalValue );
					}
				}
			} );
		}

		return this;
	},

	toggleClass: function( value, stateVal ) {
		var classNames, className, i, self,
			type = typeof value,
			isValidValue = type === "string" || Array.isArray( value );

		if ( isFunction( value ) ) {
			return this.each( function( i ) {
				jQuery( this ).toggleClass(
					value.call( this, i, getClass( this ), stateVal ),
					stateVal
				);
			} );
		}

		if ( typeof stateVal === "boolean" && isValidValue ) {
			return stateVal ? this.addClass( value ) : this.removeClass( value );
		}

		classNames = classesToArray( value );

		return this.each( function() {
			if ( isValidValue ) {

				// Toggle individual class names
				self = jQuery( this );

				for ( i = 0; i < classNames.length; i++ ) {
					className = classNames[ i ];

					// Check each className given, space separated list
					if ( self.hasClass( className ) ) {
						self.removeClass( className );
					} else {
						self.addClass( className );
					}
				}

			// Toggle whole class name
			} else if ( value === undefined || type === "boolean" ) {
				className = getClass( this );
				if ( className ) {

					// Store className if set
					dataPriv.set( this, "__className__", className );
				}

				// If the element has a class name or if we're passed `false`,
				// then remove the whole classname (if there was one, the above saved it).
				// Otherwise bring back whatever was previously saved (if anything),
				// falling back to the empty string if nothing was stored.
				if ( this.setAttribute ) {
					this.setAttribute( "class",
						className || value === false ?
							"" :
							dataPriv.get( this, "__className__" ) || ""
					);
				}
			}
		} );
	},

	hasClass: function( selector ) {
		var className, elem,
			i = 0;

		className = " " + selector + " ";
		while ( ( elem = this[ i++ ] ) ) {
			if ( elem.nodeType === 1 &&
				( " " + stripAndCollapse( getClass( elem ) ) + " " ).indexOf( className ) > -1 ) {
				return true;
			}
		}

		return false;
	}
} );




var rreturn = /\r/g;

jQuery.fn.extend( {
	val: function( value ) {
		var hooks, ret, valueIsFunction,
			elem = this[ 0 ];

		if ( !arguments.length ) {
			if ( elem ) {
				hooks = jQuery.valHooks[ elem.type ] ||
					jQuery.valHooks[ elem.nodeName.toLowerCase() ];

				if ( hooks &&
					"get" in hooks &&
					( ret = hooks.get( elem, "value" ) ) !== undefined
				) {
					return ret;
				}

				ret = elem.value;

				// Handle most common string cases
				if ( typeof ret === "string" ) {
					return ret.replace( rreturn, "" );
				}

				// Handle cases where value is null/undef or number
				return ret == null ? "" : ret;
			}

			return;
		}

		valueIsFunction = isFunction( value );

		return this.each( function( i ) {
			var val;

			if ( this.nodeType !== 1 ) {
				return;
			}

			if ( valueIsFunction ) {
				val = value.call( this, i, jQuery( this ).val() );
			} else {
				val = value;
			}

			// Treat null/undefined as ""; convert numbers to string
			if ( val == null ) {
				val = "";

			} else if ( typeof val === "number" ) {
				val += "";

			} else if ( Array.isArray( val ) ) {
				val = jQuery.map( val, function( value ) {
					return value == null ? "" : value + "";
				} );
			}

			hooks = jQuery.valHooks[ this.type ] || jQuery.valHooks[ this.nodeName.toLowerCase() ];

			// If set returns undefined, fall back to normal setting
			if ( !hooks || !( "set" in hooks ) || hooks.set( this, val, "value" ) === undefined ) {
				this.value = val;
			}
		} );
	}
} );

jQuery.extend( {
	valHooks: {
		option: {
			get: function( elem ) {

				var val = jQuery.find.attr( elem, "value" );
				return val != null ?
					val :

					// Support: IE <=10 - 11 only
					// option.text throws exceptions (trac-14686, trac-14858)
					// Strip and collapse whitespace
					// https://html.spec.whatwg.org/#strip-and-collapse-whitespace
					stripAndCollapse( jQuery.text( elem ) );
			}
		},
		select: {
			get: function( elem ) {
				var value, option, i,
					options = elem.options,
					index = elem.selectedIndex,
					one = elem.type === "select-one",
					values = one ? null : [],
					max = one ? index + 1 : options.length;

				if ( index < 0 ) {
					i = max;

				} else {
					i = one ? index : 0;
				}

				// Loop through all the selected options
				for ( ; i < max; i++ ) {
					option = options[ i ];

					// Support: IE <=9 only
					// IE8-9 doesn't update selected after form reset (trac-2551)
					if ( ( option.selected || i === index ) &&

							// Don't return options that are disabled or in a disabled optgroup
							!option.disabled &&
							( !option.parentNode.disabled ||
								!nodeName( option.parentNode, "optgroup" ) ) ) {

						// Get the specific value for the option
						value = jQuery( option ).val();

						// We don't need an array for one selects
						if ( one ) {
							return value;
						}

						// Multi-Selects return an array
						values.push( value );
					}
				}

				return values;
			},

			set: function( elem, value ) {
				var optionSet, option,
					options = elem.options,
					values = jQuery.makeArray( value ),
					i = options.length;

				while ( i-- ) {
					option = options[ i ];

					/* eslint-disable no-cond-assign */

					if ( option.selected =
						jQuery.inArray( jQuery.valHooks.option.get( option ), values ) > -1
					) {
						optionSet = true;
					}

					/* eslint-enable no-cond-assign */
				}

				// Force browsers to behave consistently when non-matching value is set
				if ( !optionSet ) {
					elem.selectedIndex = -1;
				}
				return values;
			}
		}
	}
} );

// Radios and checkboxes getter/setter
jQuery.each( [ "radio", "checkbox" ], function() {
	jQuery.valHooks[ this ] = {
		set: function( elem, value ) {
			if ( Array.isArray( value ) ) {
				return ( elem.checked = jQuery.inArray( jQuery( elem ).val(), value ) > -1 );
			}
		}
	};
	if ( !support.checkOn ) {
		jQuery.valHooks[ this ].get = function( elem ) {
			return elem.getAttribute( "value" ) === null ? "on" : elem.value;
		};
	}
} );




// Return jQuery for attributes-only inclusion


support.focusin = "onfocusin" in window;


var rfocusMorph = /^(?:focusinfocus|focusoutblur)$/,
	stopPropagationCallback = function( e ) {
		e.stopPropagation();
	};

jQuery.extend( jQuery.event, {

	trigger: function( event, data, elem, onlyHandlers ) {

		var i, cur, tmp, bubbleType, ontype, handle, special, lastElement,
			eventPath = [ elem || document ],
			type = hasOwn.call( event, "type" ) ? event.type : event,
			namespaces = hasOwn.call( event, "namespace" ) ? event.namespace.split( "." ) : [];

		cur = lastElement = tmp = elem = elem || document;

		// Don't do events on text and comment nodes
		if ( elem.nodeType === 3 || elem.nodeType === 8 ) {
			return;
		}

		// focus/blur morphs to focusin/out; ensure we're not firing them right now
		if ( rfocusMorph.test( type + jQuery.event.triggered ) ) {
			return;
		}

		if ( type.indexOf( "." ) > -1 ) {

			// Namespaced trigger; create a regexp to match event type in handle()
			namespaces = type.split( "." );
			type = namespaces.shift();
			namespaces.sort();
		}
		ontype = type.indexOf( ":" ) < 0 && "on" + type;

		// Caller can pass in a jQuery.Event object, Object, or just an event type string
		event = event[ jQuery.expando ] ?
			event :
			new jQuery.Event( type, typeof event === "object" && event );

		// Trigger bitmask: & 1 for native handlers; & 2 for jQuery (always true)
		event.isTrigger = onlyHandlers ? 2 : 3;
		event.namespace = namespaces.join( "." );
		event.rnamespace = event.namespace ?
			new RegExp( "(^|\\.)" + namespaces.join( "\\.(?:.*\\.|)" ) + "(\\.|$)" ) :
			null;

		// Clean up the event in case it is being reused
		event.result = undefined;
		if ( !event.target ) {
			event.target = elem;
		}

		// Clone any incoming data and prepend the event, creating the handler arg list
		data = data == null ?
			[ event ] :
			jQuery.makeArray( data, [ event ] );

		// Allow special events to draw outside the lines
		special = jQuery.event.special[ type ] || {};
		if ( !onlyHandlers && special.trigger && special.trigger.apply( elem, data ) === false ) {
			return;
		}

		// Determine event propagation path in advance, per W3C events spec (trac-9951)
		// Bubble up to document, then to window; watch for a global ownerDocument var (trac-9724)
		if ( !onlyHandlers && !special.noBubble && !isWindow( elem ) ) {

			bubbleType = special.delegateType || type;
			if ( !rfocusMorph.test( bubbleType + type ) ) {
				cur = cur.parentNode;
			}
			for ( ; cur; cur = cur.parentNode ) {
				eventPath.push( cur );
				tmp = cur;
			}

			// Only add window if we got to document (e.g., not plain obj or detached DOM)
			if ( tmp === ( elem.ownerDocument || document ) ) {
				eventPath.push( tmp.defaultView || tmp.parentWindow || window );
			}
		}

		// Fire handlers on the event path
		i = 0;
		while ( ( cur = eventPath[ i++ ] ) && !event.isPropagationStopped() ) {
			lastElement = cur;
			event.type = i > 1 ?
				bubbleType :
				special.bindType || type;

			// jQuery handler
			handle = ( dataPriv.get( cur, "events" ) || Object.create( null ) )[ event.type ] &&
				dataPriv.get( cur, "handle" );
			if ( handle ) {
				handle.apply( cur, data );
			}

			// Native handler
			handle = ontype && cur[ ontype ];
			if ( handle && handle.apply && acceptData( cur ) ) {
				event.result = handle.apply( cur, data );
				if ( event.result === false ) {
					event.preventDefault();
				}
			}
		}
		event.type = type;

		// If nobody prevented the default action, do it now
		if ( !onlyHandlers && !event.isDefaultPrevented() ) {

			if ( ( !special._default ||
				special._default.apply( eventPath.pop(), data ) === false ) &&
				acceptData( elem ) ) {

				// Call a native DOM method on the target with the same name as the event.
				// Don't do default actions on window, that's where global variables be (trac-6170)
				if ( ontype && isFunction( elem[ type ] ) && !isWindow( elem ) ) {

					// Don't re-trigger an onFOO event when we call its FOO() method
					tmp = elem[ ontype ];

					if ( tmp ) {
						elem[ ontype ] = null;
					}

					// Prevent re-triggering of the same event, since we already bubbled it above
					jQuery.event.triggered = type;

					if ( event.isPropagationStopped() ) {
						lastElement.addEventListener( type, stopPropagationCallback );
					}

					elem[ type ]();

					if ( event.isPropagationStopped() ) {
						lastElement.removeEventListener( type, stopPropagationCallback );
					}

					jQuery.event.triggered = undefined;

					if ( tmp ) {
						elem[ ontype ] = tmp;
					}
				}
			}
		}

		return event.result;
	},

	// Piggyback on a donor event to simulate a different one
	// Used only for `focus(in | out)` events
	simulate: function( type, elem, event ) {
		var e = jQuery.extend(
			new jQuery.Event(),
			event,
			{
				type: type,
				isSimulated: true
			}
		);

		jQuery.event.trigger( e, null, elem );
	}

} );

jQuery.fn.extend( {

	trigger: function( type, data ) {
		return this.each( function() {
			jQuery.event.trigger( type, data, this );
		} );
	},
	triggerHandler: function( type, data ) {
		var elem = this[ 0 ];
		if ( elem ) {
			return jQuery.event.trigger( type, data, elem, true );
		}
	}
} );


// Support: Firefox <=44
// Firefox doesn't have focus(in | out) events
// Related ticket - https://bugzilla.mozilla.org/show_bug.cgi?id=687787
//
// Support: Chrome <=48 - 49, Safari <=9.0 - 9.1
// focus(in | out) events fire after focus & blur events,
// which is spec violation - http://www.w3.org/TR/DOM-Level-3-Events/#events-focusevent-event-order
// Related ticket - https://bugs.chromium.org/p/chromium/issues/detail?id=449857
if ( !support.focusin ) {
	jQuery.each( { focus: "focusin", blur: "focusout" }, function( orig, fix ) {

		// Attach a single capturing handler on the document while someone wants focusin/focusout
		var handler = function( event ) {
			jQuery.event.simulate( fix, event.target, jQuery.event.fix( event ) );
		};

		jQuery.event.special[ fix ] = {
			setup: function() {

				// Handle: regular nodes (via `this.ownerDocument`), window
				// (via `this.document`) & document (via `this`).
				var doc = this.ownerDocument || this.document || this,
					attaches = dataPriv.access( doc, fix );

				if ( !attaches ) {
					doc.addEventListener( orig, handler, true );
				}
				dataPriv.access( doc, fix, ( attaches || 0 ) + 1 );
			},
			teardown: function() {
				var doc = this.ownerDocument || this.document || this,
					attaches = dataPriv.access( doc, fix ) - 1;

				if ( !attaches ) {
					doc.removeEventListener( orig, handler, true );
					dataPriv.remove( doc, fix );

				} else {
					dataPriv.access( doc, fix, attaches );
				}
			}
		};
	} );
}
var location = window.location;

var nonce = { guid: Date.now() };

var rquery = ( /\?/ );



// Cross-browser xml parsing
jQuery.parseXML = function( data ) {
	var xml, parserErrorElem;
	if ( !data || typeof data !== "string" ) {
		return null;
	}

	// Support: IE 9 - 11 only
	// IE throws on parseFromString with invalid input.
	try {
		xml = ( new window.DOMParser() ).parseFromString( data, "text/xml" );
	} catch ( e ) {}

	parserErrorElem = xml && xml.getElementsByTagName( "parsererror" )[ 0 ];
	if ( !xml || parserErrorElem ) {
		jQuery.error( "Invalid XML: " + (
			parserErrorElem ?
				jQuery.map( parserErrorElem.childNodes, function( el ) {
					return el.textContent;
				} ).join( "\n" ) :
				data
		) );
	}
	return xml;
};


var
	rbracket = /\[\]$/,
	rCRLF = /\r?\n/g,
	rsubmitterTypes = /^(?:submit|button|image|reset|file)$/i,
	rsubmittable = /^(?:input|select|textarea|keygen)/i;

function buildParams( prefix, obj, traditional, add ) {
	var name;

	if ( Array.isArray( obj ) ) {

		// Serialize array item.
		jQuery.each( obj, function( i, v ) {
			if ( traditional || rbracket.test( prefix ) ) {

				// Treat each array item as a scalar.
				add( prefix, v );

			} else {

				// Item is non-scalar (array or object), encode its numeric index.
				buildParams(
					prefix + "[" + ( typeof v === "object" && v != null ? i : "" ) + "]",
					v,
					traditional,
					add
				);
			}
		} );

	} else if ( !traditional && toType( obj ) === "object" ) {

		// Serialize object item.
		for ( name in obj ) {
			buildParams( prefix + "[" + name + "]", obj[ name ], traditional, add );
		}

	} else {

		// Serialize scalar item.
		add( prefix, obj );
	}
}

// Serialize an array of form elements or a set of
// key/values into a query string
jQuery.param = function( a, traditional ) {
	var prefix,
		s = [],
		add = function( key, valueOrFunction ) {

			// If value is a function, invoke it and use its return value
			var value = isFunction( valueOrFunction ) ?
				valueOrFunction() :
				valueOrFunction;

			s[ s.length ] = encodeURIComponent( key ) + "=" +
				encodeURIComponent( value == null ? "" : value );
		};

	if ( a == null ) {
		return "";
	}

	// If an array was passed in, assume that it is an array of form elements.
	if ( Array.isArray( a ) || ( a.jquery && !jQuery.isPlainObject( a ) ) ) {

		// Serialize the form elements
		jQuery.each( a, function() {
			add( this.name, this.value );
		} );

	} else {

		// If traditional, encode the "old" way (the way 1.3.2 or older
		// did it), otherwise encode params recursively.
		for ( prefix in a ) {
			buildParams( prefix, a[ prefix ], traditional, add );
		}
	}

	// Return the resulting serialization
	return s.join( "&" );
};

jQuery.fn.extend( {
	serialize: function() {
		return jQuery.param( this.serializeArray() );
	},
	serializeArray: function() {
		return this.map( function() {

			// Can add propHook for "elements" to filter or add form elements
			var elements = jQuery.prop( this, "elements" );
			return elements ? jQuery.makeArray( elements ) : this;
		} ).filter( function() {
			var type = this.type;

			// Use .is( ":disabled" ) so that fieldset[disabled] works
			return this.name && !jQuery( this ).is( ":disabled" ) &&
				rsubmittable.test( this.nodeName ) && !rsubmitterTypes.test( type ) &&
				( this.checked || !rcheckableType.test( type ) );
		} ).map( function( _i, elem ) {
			var val = jQuery( this ).val();

			if ( val == null ) {
				return null;
			}

			if ( Array.isArray( val ) ) {
				return jQuery.map( val, function( val ) {
					return { name: elem.name, value: val.replace( rCRLF, "\r\n" ) };
				} );
			}

			return { name: elem.name, value: val.replace( rCRLF, "\r\n" ) };
		} ).get();
	}
} );


var
	r20 = /%20/g,
	rhash = /#.*$/,
	rantiCache = /([?&])_=[^&]*/,
	rheaders = /^(.*?):[ \t]*([^\r\n]*)$/mg,

	// trac-7653, trac-8125, trac-8152: local protocol detection
	rlocalProtocol = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/,
	rnoContent = /^(?:GET|HEAD)$/,
	rprotocol = /^\/\//,

	/* Prefilters
	 * 1) They are useful to introduce custom dataTypes (see ajax/jsonp.js for an example)
	 * 2) These are called:
	 *    - BEFORE asking for a transport
	 *    - AFTER param serialization (s.data is a string if s.processData is true)
	 * 3) key is the dataType
	 * 4) the catchall symbol "*" can be used
	 * 5) execution will start with transport dataType and THEN continue down to "*" if needed
	 */
	prefilters = {},

	/* Transports bindings
	 * 1) key is the dataType
	 * 2) the catchall symbol "*" can be used
	 * 3) selection will start with transport dataType and THEN go to "*" if needed
	 */
	transports = {},

	// Avoid comment-prolog char sequence (trac-10098); must appease lint and evade compression
	allTypes = "*/".concat( "*" ),

	// Anchor tag for parsing the document origin
	originAnchor = document.createElement( "a" );

originAnchor.href = location.href;

// Base "constructor" for jQuery.ajaxPrefilter and jQuery.ajaxTransport
function addToPrefiltersOrTransports( structure ) {

	// dataTypeExpression is optional and defaults to "*"
	return function( dataTypeExpression, func ) {

		if ( typeof dataTypeExpression !== "string" ) {
			func = dataTypeExpression;
			dataTypeExpression = "*";
		}

		var dataType,
			i = 0,
			dataTypes = dataTypeExpression.toLowerCase().match( rnothtmlwhite ) || [];

		if ( isFunction( func ) ) {

			// For each dataType in the dataTypeExpression
			while ( ( dataType = dataTypes[ i++ ] ) ) {

				// Prepend if requested
				if ( dataType[ 0 ] === "+" ) {
					dataType = dataType.slice( 1 ) || "*";
					( structure[ dataType ] = structure[ dataType ] || [] ).unshift( func );

				// Otherwise append
				} else {
					( structure[ dataType ] = structure[ dataType ] || [] ).push( func );
				}
			}
		}
	};
}

// Base inspection function for prefilters and transports
function inspectPrefiltersOrTransports( structure, options, originalOptions, jqXHR ) {

	var inspected = {},
		seekingTransport = ( structure === transports );

	function inspect( dataType ) {
		var selected;
		inspected[ dataType ] = true;
		jQuery.each( structure[ dataType ] || [], function( _, prefilterOrFactory ) {
			var dataTypeOrTransport = prefilterOrFactory( options, originalOptions, jqXHR );
			if ( typeof dataTypeOrTransport === "string" &&
				!seekingTransport && !inspected[ dataTypeOrTransport ] ) {

				options.dataTypes.unshift( dataTypeOrTransport );
				inspect( dataTypeOrTransport );
				return false;
			} else if ( seekingTransport ) {
				return !( selected = dataTypeOrTransport );
			}
		} );
		return selected;
	}

	return inspect( options.dataTypes[ 0 ] ) || !inspected[ "*" ] && inspect( "*" );
}

// A special extend for ajax options
// that takes "flat" options (not to be deep extended)
// Fixes trac-9887
function ajaxExtend( target, src ) {
	var key, deep,
		flatOptions = jQuery.ajaxSettings.flatOptions || {};

	for ( key in src ) {
		if ( src[ key ] !== undefined ) {
			( flatOptions[ key ] ? target : ( deep || ( deep = {} ) ) )[ key ] = src[ key ];
		}
	}
	if ( deep ) {
		jQuery.extend( true, target, deep );
	}

	return target;
}

/* Handles responses to an ajax request:
 * - finds the right dataType (mediates between content-type and expected dataType)
 * - returns the corresponding response
 */
function ajaxHandleResponses( s, jqXHR, responses ) {

	var ct, type, finalDataType, firstDataType,
		contents = s.contents,
		dataTypes = s.dataTypes;

	// Remove auto dataType and get content-type in the process
	while ( dataTypes[ 0 ] === "*" ) {
		dataTypes.shift();
		if ( ct === undefined ) {
			ct = s.mimeType || jqXHR.getResponseHeader( "Content-Type" );
		}
	}

	// Check if we're dealing with a known content-type
	if ( ct ) {
		for ( type in contents ) {
			if ( contents[ type ] && contents[ type ].test( ct ) ) {
				dataTypes.unshift( type );
				break;
			}
		}
	}

	// Check to see if we have a response for the expected dataType
	if ( dataTypes[ 0 ] in responses ) {
		finalDataType = dataTypes[ 0 ];
	} else {

		// Try convertible dataTypes
		for ( type in responses ) {
			if ( !dataTypes[ 0 ] || s.converters[ type + " " + dataTypes[ 0 ] ] ) {
				finalDataType = type;
				break;
			}
			if ( !firstDataType ) {
				firstDataType = type;
			}
		}

		// Or just use first one
		finalDataType = finalDataType || firstDataType;
	}

	// If we found a dataType
	// We add the dataType to the list if needed
	// and return the corresponding response
	if ( finalDataType ) {
		if ( finalDataType !== dataTypes[ 0 ] ) {
			dataTypes.unshift( finalDataType );
		}
		return responses[ finalDataType ];
	}
}

/* Chain conversions given the request and the original response
 * Also sets the responseXXX fields on the jqXHR instance
 */
function ajaxConvert( s, response, jqXHR, isSuccess ) {
	var conv2, current, conv, tmp, prev,
		converters = {},

		// Work with a copy of dataTypes in case we need to modify it for conversion
		dataTypes = s.dataTypes.slice();

	// Create converters map with lowercased keys
	if ( dataTypes[ 1 ] ) {
		for ( conv in s.converters ) {
			converters[ conv.toLowerCase() ] = s.converters[ conv ];
		}
	}

	current = dataTypes.shift();

	// Convert to each sequential dataType
	while ( current ) {

		if ( s.responseFields[ current ] ) {
			jqXHR[ s.responseFields[ current ] ] = response;
		}

		// Apply the dataFilter if provided
		if ( !prev && isSuccess && s.dataFilter ) {
			response = s.dataFilter( response, s.dataType );
		}

		prev = current;
		current = dataTypes.shift();

		if ( current ) {

			// There's only work to do if current dataType is non-auto
			if ( current === "*" ) {

				current = prev;

			// Convert response if prev dataType is non-auto and differs from current
			} else if ( prev !== "*" && prev !== current ) {

				// Seek a direct converter
				conv = converters[ prev + " " + current ] || converters[ "* " + current ];

				// If none found, seek a pair
				if ( !conv ) {
					for ( conv2 in converters ) {

						// If conv2 outputs current
						tmp = conv2.split( " " );
						if ( tmp[ 1 ] === current ) {

							// If prev can be converted to accepted input
							conv = converters[ prev + " " + tmp[ 0 ] ] ||
								converters[ "* " + tmp[ 0 ] ];
							if ( conv ) {

								// Condense equivalence converters
								if ( conv === true ) {
									conv = converters[ conv2 ];

								// Otherwise, insert the intermediate dataType
								} else if ( converters[ conv2 ] !== true ) {
									current = tmp[ 0 ];
									dataTypes.unshift( tmp[ 1 ] );
								}
								break;
							}
						}
					}
				}

				// Apply converter (if not an equivalence)
				if ( conv !== true ) {

					// Unless errors are allowed to bubble, catch and return them
					if ( conv && s.throws ) {
						response = conv( response );
					} else {
						try {
							response = conv( response );
						} catch ( e ) {
							return {
								state: "parsererror",
								error: conv ? e : "No conversion from " + prev + " to " + current
							};
						}
					}
				}
			}
		}
	}

	return { state: "success", data: response };
}

jQuery.extend( {

	// Counter for holding the number of active queries
	active: 0,

	// Last-Modified header cache for next request
	lastModified: {},
	etag: {},

	ajaxSettings: {
		url: location.href,
		type: "GET",
		isLocal: rlocalProtocol.test( location.protocol ),
		global: true,
		processData: true,
		async: true,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",

		/*
		timeout: 0,
		data: null,
		dataType: null,
		username: null,
		password: null,
		cache: null,
		throws: false,
		traditional: false,
		headers: {},
		*/

		accepts: {
			"*": allTypes,
			text: "text/plain",
			html: "text/html",
			xml: "application/xml, text/xml",
			json: "application/json, text/javascript"
		},

		contents: {
			xml: /\bxml\b/,
			html: /\bhtml/,
			json: /\bjson\b/
		},

		responseFields: {
			xml: "responseXML",
			text: "responseText",
			json: "responseJSON"
		},

		// Data converters
		// Keys separate source (or catchall "*") and destination types with a single space
		converters: {

			// Convert anything to text
			"* text": String,

			// Text to html (true = no transformation)
			"text html": true,

			// Evaluate text as a json expression
			"text json": JSON.parse,

			// Parse text as xml
			"text xml": jQuery.parseXML
		},

		// For options that shouldn't be deep extended:
		// you can add your own custom options here if
		// and when you create one that shouldn't be
		// deep extended (see ajaxExtend)
		flatOptions: {
			url: true,
			context: true
		}
	},

	// Creates a full fledged settings object into target
	// with both ajaxSettings and settings fields.
	// If target is omitted, writes into ajaxSettings.
	ajaxSetup: function( target, settings ) {
		return settings ?

			// Building a settings object
			ajaxExtend( ajaxExtend( target, jQuery.ajaxSettings ), settings ) :

			// Extending ajaxSettings
			ajaxExtend( jQuery.ajaxSettings, target );
	},

	ajaxPrefilter: addToPrefiltersOrTransports( prefilters ),
	ajaxTransport: addToPrefiltersOrTransports( transports ),

	// Main method
	ajax: function( url, options ) {

		// If url is an object, simulate pre-1.5 signature
		if ( typeof url === "object" ) {
			options = url;
			url = undefined;
		}

		// Force options to be an object
		options = options || {};

		var transport,

			// URL without anti-cache param
			cacheURL,

			// Response headers
			responseHeadersString,
			responseHeaders,

			// timeout handle
			timeoutTimer,

			// Url cleanup var
			urlAnchor,

			// Request state (becomes false upon send and true upon completion)
			completed,

			// To know if global events are to be dispatched
			fireGlobals,

			// Loop variable
			i,

			// uncached part of the url
			uncached,

			// Create the final options object
			s = jQuery.ajaxSetup( {}, options ),

			// Callbacks context
			callbackContext = s.context || s,

			// Context for global events is callbackContext if it is a DOM node or jQuery collection
			globalEventContext = s.context &&
				( callbackContext.nodeType || callbackContext.jquery ) ?
				jQuery( callbackContext ) :
				jQuery.event,

			// Deferreds
			deferred = jQuery.Deferred(),
			completeDeferred = jQuery.Callbacks( "once memory" ),

			// Status-dependent callbacks
			statusCode = s.statusCode || {},

			// Headers (they are sent all at once)
			requestHeaders = {},
			requestHeadersNames = {},

			// Default abort message
			strAbort = "canceled",

			// Fake xhr
			jqXHR = {
				readyState: 0,

				// Builds headers hashtable if needed
				getResponseHeader: function( key ) {
					var match;
					if ( completed ) {
						if ( !responseHeaders ) {
							responseHeaders = {};
							while ( ( match = rheaders.exec( responseHeadersString ) ) ) {
								responseHeaders[ match[ 1 ].toLowerCase() + " " ] =
									( responseHeaders[ match[ 1 ].toLowerCase() + " " ] || [] )
										.concat( match[ 2 ] );
							}
						}
						match = responseHeaders[ key.toLowerCase() + " " ];
					}
					return match == null ? null : match.join( ", " );
				},

				// Raw string
				getAllResponseHeaders: function() {
					return completed ? responseHeadersString : null;
				},

				// Caches the header
				setRequestHeader: function( name, value ) {
					if ( completed == null ) {
						name = requestHeadersNames[ name.toLowerCase() ] =
							requestHeadersNames[ name.toLowerCase() ] || name;
						requestHeaders[ name ] = value;
					}
					return this;
				},

				// Overrides response content-type header
				overrideMimeType: function( type ) {
					if ( completed == null ) {
						s.mimeType = type;
					}
					return this;
				},

				// Status-dependent callbacks
				statusCode: function( map ) {
					var code;
					if ( map ) {
						if ( completed ) {

							// Execute the appropriate callbacks
							jqXHR.always( map[ jqXHR.status ] );
						} else {

							// Lazy-add the new callbacks in a way that preserves old ones
							for ( code in map ) {
								statusCode[ code ] = [ statusCode[ code ], map[ code ] ];
							}
						}
					}
					return this;
				},

				// Cancel the request
				abort: function( statusText ) {
					var finalText = statusText || strAbort;
					if ( transport ) {
						transport.abort( finalText );
					}
					done( 0, finalText );
					return this;
				}
			};

		// Attach deferreds
		deferred.promise( jqXHR );

		// Add protocol if not provided (prefilters might expect it)
		// Handle falsy url in the settings object (trac-10093: consistency with old signature)
		// We also use the url parameter if available
		s.url = ( ( url || s.url || location.href ) + "" )
			.replace( rprotocol, location.protocol + "//" );

		// Alias method option to type as per ticket trac-12004
		s.type = options.method || options.type || s.method || s.type;

		// Extract dataTypes list
		s.dataTypes = ( s.dataType || "*" ).toLowerCase().match( rnothtmlwhite ) || [ "" ];

		// A cross-domain request is in order when the origin doesn't match the current origin.
		if ( s.crossDomain == null ) {
			urlAnchor = document.createElement( "a" );

			// Support: IE <=8 - 11, Edge 12 - 15
			// IE throws exception on accessing the href property if url is malformed,
			// e.g. http://example.com:80x/
			try {
				urlAnchor.href = s.url;

				// Support: IE <=8 - 11 only
				// Anchor's host property isn't correctly set when s.url is relative
				urlAnchor.href = urlAnchor.href;
				s.crossDomain = originAnchor.protocol + "//" + originAnchor.host !==
					urlAnchor.protocol + "//" + urlAnchor.host;
			} catch ( e ) {

				// If there is an error parsing the URL, assume it is crossDomain,
				// it can be rejected by the transport if it is invalid
				s.crossDomain = true;
			}
		}

		// Convert data if not already a string
		if ( s.data && s.processData && typeof s.data !== "string" ) {
			s.data = jQuery.param( s.data, s.traditional );
		}

		// Apply prefilters
		inspectPrefiltersOrTransports( prefilters, s, options, jqXHR );

		// If request was aborted inside a prefilter, stop there
		if ( completed ) {
			return jqXHR;
		}

		// We can fire global events as of now if asked to
		// Don't fire events if jQuery.event is undefined in an AMD-usage scenario (trac-15118)
		fireGlobals = jQuery.event && s.global;

		// Watch for a new set of requests
		if ( fireGlobals && jQuery.active++ === 0 ) {
			jQuery.event.trigger( "ajaxStart" );
		}

		// Uppercase the type
		s.type = s.type.toUpperCase();

		// Determine if request has content
		s.hasContent = !rnoContent.test( s.type );

		// Save the URL in case we're toying with the If-Modified-Since
		// and/or If-None-Match header later on
		// Remove hash to simplify url manipulation
		cacheURL = s.url.replace( rhash, "" );

		// More options handling for requests with no content
		if ( !s.hasContent ) {

			// Remember the hash so we can put it back
			uncached = s.url.slice( cacheURL.length );

			// If data is available and should be processed, append data to url
			if ( s.data && ( s.processData || typeof s.data === "string" ) ) {
				cacheURL += ( rquery.test( cacheURL ) ? "&" : "?" ) + s.data;

				// trac-9682: remove data so that it's not used in an eventual retry
				delete s.data;
			}

			// Add or update anti-cache param if needed
			if ( s.cache === false ) {
				cacheURL = cacheURL.replace( rantiCache, "$1" );
				uncached = ( rquery.test( cacheURL ) ? "&" : "?" ) + "_=" + ( nonce.guid++ ) +
					uncached;
			}

			// Put hash and anti-cache on the URL that will be requested (gh-1732)
			s.url = cacheURL + uncached;

		// Change '%20' to '+' if this is encoded form body content (gh-2658)
		} else if ( s.data && s.processData &&
			( s.contentType || "" ).indexOf( "application/x-www-form-urlencoded" ) === 0 ) {
			s.data = s.data.replace( r20, "+" );
		}

		// Set the If-Modified-Since and/or If-None-Match header, if in ifModified mode.
		if ( s.ifModified ) {
			if ( jQuery.lastModified[ cacheURL ] ) {
				jqXHR.setRequestHeader( "If-Modified-Since", jQuery.lastModified[ cacheURL ] );
			}
			if ( jQuery.etag[ cacheURL ] ) {
				jqXHR.setRequestHeader( "If-None-Match", jQuery.etag[ cacheURL ] );
			}
		}

		// Set the correct header, if data is being sent
		if ( s.data && s.hasContent && s.contentType !== false || options.contentType ) {
			jqXHR.setRequestHeader( "Content-Type", s.contentType );
		}

		// Set the Accepts header for the server, depending on the dataType
		jqXHR.setRequestHeader(
			"Accept",
			s.dataTypes[ 0 ] && s.accepts[ s.dataTypes[ 0 ] ] ?
				s.accepts[ s.dataTypes[ 0 ] ] +
					( s.dataTypes[ 0 ] !== "*" ? ", " + allTypes + "; q=0.01" : "" ) :
				s.accepts[ "*" ]
		);

		// Check for headers option
		for ( i in s.headers ) {
			jqXHR.setRequestHeader( i, s.headers[ i ] );
		}

		// Allow custom headers/mimetypes and early abort
		if ( s.beforeSend &&
			( s.beforeSend.call( callbackContext, jqXHR, s ) === false || completed ) ) {

			// Abort if not done already and return
			return jqXHR.abort();
		}

		// Aborting is no longer a cancellation
		strAbort = "abort";

		// Install callbacks on deferreds
		completeDeferred.add( s.complete );
		jqXHR.done( s.success );
		jqXHR.fail( s.error );

		// Get transport
		transport = inspectPrefiltersOrTransports( transports, s, options, jqXHR );

		// If no transport, we auto-abort
		if ( !transport ) {
			done( -1, "No Transport" );
		} else {
			jqXHR.readyState = 1;

			// Send global event
			if ( fireGlobals ) {
				globalEventContext.trigger( "ajaxSend", [ jqXHR, s ] );
			}

			// If request was aborted inside ajaxSend, stop there
			if ( completed ) {
				return jqXHR;
			}

			// Timeout
			if ( s.async && s.timeout > 0 ) {
				timeoutTimer = window.setTimeout( function() {
					jqXHR.abort( "timeout" );
				}, s.timeout );
			}

			try {
				completed = false;
				transport.send( requestHeaders, done );
			} catch ( e ) {

				// Rethrow post-completion exceptions
				if ( completed ) {
					throw e;
				}

				// Propagate others as results
				done( -1, e );
			}
		}

		// Callback for when everything is done
		function done( status, nativeStatusText, responses, headers ) {
			var isSuccess, success, error, response, modified,
				statusText = nativeStatusText;

			// Ignore repeat invocations
			if ( completed ) {
				return;
			}

			completed = true;

			// Clear timeout if it exists
			if ( timeoutTimer ) {
				window.clearTimeout( timeoutTimer );
			}

			// Dereference transport for early garbage collection
			// (no matter how long the jqXHR object will be used)
			transport = undefined;

			// Cache response headers
			responseHeadersString = headers || "";

			// Set readyState
			jqXHR.readyState = status > 0 ? 4 : 0;

			// Determine if successful
			isSuccess = status >= 200 && status < 300 || status === 304;

			// Get response data
			if ( responses ) {
				response = ajaxHandleResponses( s, jqXHR, responses );
			}

			// Use a noop converter for missing script but not if jsonp
			if ( !isSuccess &&
				jQuery.inArray( "script", s.dataTypes ) > -1 &&
				jQuery.inArray( "json", s.dataTypes ) < 0 ) {
				s.converters[ "text script" ] = function() {};
			}

			// Convert no matter what (that way responseXXX fields are always set)
			response = ajaxConvert( s, response, jqXHR, isSuccess );

			// If successful, handle type chaining
			if ( isSuccess ) {

				// Set the If-Modified-Since and/or If-None-Match header, if in ifModified mode.
				if ( s.ifModified ) {
					modified = jqXHR.getResponseHeader( "Last-Modified" );
					if ( modified ) {
						jQuery.lastModified[ cacheURL ] = modified;
					}
					modified = jqXHR.getResponseHeader( "etag" );
					if ( modified ) {
						jQuery.etag[ cacheURL ] = modified;
					}
				}

				// if no content
				if ( status === 204 || s.type === "HEAD" ) {
					statusText = "nocontent";

				// if not modified
				} else if ( status === 304 ) {
					statusText = "notmodified";

				// If we have data, let's convert it
				} else {
					statusText = response.state;
					success = response.data;
					error = response.error;
					isSuccess = !error;
				}
			} else {

				// Extract error from statusText and normalize for non-aborts
				error = statusText;
				if ( status || !statusText ) {
					statusText = "error";
					if ( status < 0 ) {
						status = 0;
					}
				}
			}

			// Set data for the fake xhr object
			jqXHR.status = status;
			jqXHR.statusText = ( nativeStatusText || statusText ) + "";

			// Success/Error
			if ( isSuccess ) {
				deferred.resolveWith( callbackContext, [ success, statusText, jqXHR ] );
			} else {
				deferred.rejectWith( callbackContext, [ jqXHR, statusText, error ] );
			}

			// Status-dependent callbacks
			jqXHR.statusCode( statusCode );
			statusCode = undefined;

			if ( fireGlobals ) {
				globalEventContext.trigger( isSuccess ? "ajaxSuccess" : "ajaxError",
					[ jqXHR, s, isSuccess ? success : error ] );
			}

			// Complete
			completeDeferred.fireWith( callbackContext, [ jqXHR, statusText ] );

			if ( fireGlobals ) {
				globalEventContext.trigger( "ajaxComplete", [ jqXHR, s ] );

				// Handle the global AJAX counter
				if ( !( --jQuery.active ) ) {
					jQuery.event.trigger( "ajaxStop" );
				}
			}
		}

		return jqXHR;
	},

	getJSON: function( url, data, callback ) {
		return jQuery.get( url, data, callback, "json" );
	},

	getScript: function( url, callback ) {
		return jQuery.get( url, undefined, callback, "script" );
	}
} );

jQuery.each( [ "get", "post" ], function( _i, method ) {
	jQuery[ method ] = function( url, data, callback, type ) {

		// Shift arguments if data argument was omitted
		if ( isFunction( data ) ) {
			type = type || callback;
			callback = data;
			data = undefined;
		}

		// The url can be an options object (which then must have .url)
		return jQuery.ajax( jQuery.extend( {
			url: url,
			type: method,
			dataType: type,
			data: data,
			success: callback
		}, jQuery.isPlainObject( url ) && url ) );
	};
} );

jQuery.ajaxPrefilter( function( s ) {
	var i;
	for ( i in s.headers ) {
		if ( i.toLowerCase() === "content-type" ) {
			s.contentType = s.headers[ i ] || "";
		}
	}
} );


jQuery._evalUrl = function( url, options, doc ) {
	return jQuery.ajax( {
		url: url,

		// Make this explicit, since user can override this through ajaxSetup (trac-11264)
		type: "GET",
		dataType: "script",
		cache: true,
		async: false,
		global: false,

		// Only evaluate the response if it is successful (gh-4126)
		// dataFilter is not invoked for failure responses, so using it instead
		// of the default converter is kludgy but it works.
		converters: {
			"text script": function() {}
		},
		dataFilter: function( response ) {
			jQuery.globalEval( response, options, doc );
		}
	} );
};


jQuery.fn.extend( {
	wrapAll: function( html ) {
		var wrap;

		if ( this[ 0 ] ) {
			if ( isFunction( html ) ) {
				html = html.call( this[ 0 ] );
			}

			// The elements to wrap the target around
			wrap = jQuery( html, this[ 0 ].ownerDocument ).eq( 0 ).clone( true );

			if ( this[ 0 ].parentNode ) {
				wrap.insertBefore( this[ 0 ] );
			}

			wrap.map( function() {
				var elem = this;

				while ( elem.firstElementChild ) {
					elem = elem.firstElementChild;
				}

				return elem;
			} ).append( this );
		}

		return this;
	},

	wrapInner: function( html ) {
		if ( isFunction( html ) ) {
			return this.each( function( i ) {
				jQuery( this ).wrapInner( html.call( this, i ) );
			} );
		}

		return this.each( function() {
			var self = jQuery( this ),
				contents = self.contents();

			if ( contents.length ) {
				contents.wrapAll( html );

			} else {
				self.append( html );
			}
		} );
	},

	wrap: function( html ) {
		var htmlIsFunction = isFunction( html );

		return this.each( function( i ) {
			jQuery( this ).wrapAll( htmlIsFunction ? html.call( this, i ) : html );
		} );
	},

	unwrap: function( selector ) {
		this.parent( selector ).not( "body" ).each( function() {
			jQuery( this ).replaceWith( this.childNodes );
		} );
		return this;
	}
} );


jQuery.expr.pseudos.hidden = function( elem ) {
	return !jQuery.expr.pseudos.visible( elem );
};
jQuery.expr.pseudos.visible = function( elem ) {
	return !!( elem.offsetWidth || elem.offsetHeight || elem.getClientRects().length );
};




jQuery.ajaxSettings.xhr = function() {
	try {
		return new window.XMLHttpRequest();
	} catch ( e ) {}
};

var xhrSuccessStatus = {

		// File protocol always yields status code 0, assume 200
		0: 200,

		// Support: IE <=9 only
		// trac-1450: sometimes IE returns 1223 when it should be 204
		1223: 204
	},
	xhrSupported = jQuery.ajaxSettings.xhr();

support.cors = !!xhrSupported && ( "withCredentials" in xhrSupported );
support.ajax = xhrSupported = !!xhrSupported;

jQuery.ajaxTransport( function( options ) {
	var callback, errorCallback;

	// Cross domain only allowed if supported through XMLHttpRequest
	if ( support.cors || xhrSupported && !options.crossDomain ) {
		return {
			send: function( headers, complete ) {
				var i,
					xhr = options.xhr();

				xhr.open(
					options.type,
					options.url,
					options.async,
					options.username,
					options.password
				);

				// Apply custom fields if provided
				if ( options.xhrFields ) {
					for ( i in options.xhrFields ) {
						xhr[ i ] = options.xhrFields[ i ];
					}
				}

				// Override mime type if needed
				if ( options.mimeType && xhr.overrideMimeType ) {
					xhr.overrideMimeType( options.mimeType );
				}

				// X-Requested-With header
				// For cross-domain requests, seeing as conditions for a preflight are
				// akin to a jigsaw puzzle, we simply never set it to be sure.
				// (it can always be set on a per-request basis or even using ajaxSetup)
				// For same-domain requests, won't change header if already provided.
				if ( !options.crossDomain && !headers[ "X-Requested-With" ] ) {
					headers[ "X-Requested-With" ] = "XMLHttpRequest";
				}

				// Set headers
				for ( i in headers ) {
					xhr.setRequestHeader( i, headers[ i ] );
				}

				// Callback
				callback = function( type ) {
					return function() {
						if ( callback ) {
							callback = errorCallback = xhr.onload =
								xhr.onerror = xhr.onabort = xhr.ontimeout =
									xhr.onreadystatechange = null;

							if ( type === "abort" ) {
								xhr.abort();
							} else if ( type === "error" ) {

								// Support: IE <=9 only
								// On a manual native abort, IE9 throws
								// errors on any property access that is not readyState
								if ( typeof xhr.status !== "number" ) {
									complete( 0, "error" );
								} else {
									complete(

										// File: protocol always yields status 0; see trac-8605, trac-14207
										xhr.status,
										xhr.statusText
									);
								}
							} else {
								complete(
									xhrSuccessStatus[ xhr.status ] || xhr.status,
									xhr.statusText,

									// Support: IE <=9 only
									// IE9 has no XHR2 but throws on binary (trac-11426)
									// For XHR2 non-text, let the caller handle it (gh-2498)
									( xhr.responseType || "text" ) !== "text"  ||
									typeof xhr.responseText !== "string" ?
										{ binary: xhr.response } :
										{ text: xhr.responseText },
									xhr.getAllResponseHeaders()
								);
							}
						}
					};
				};

				// Listen to events
				xhr.onload = callback();
				errorCallback = xhr.onerror = xhr.ontimeout = callback( "error" );

				// Support: IE 9 only
				// Use onreadystatechange to replace onabort
				// to handle uncaught aborts
				if ( xhr.onabort !== undefined ) {
					xhr.onabort = errorCallback;
				} else {
					xhr.onreadystatechange = function() {

						// Check readyState before timeout as it changes
						if ( xhr.readyState === 4 ) {

							// Allow onerror to be called first,
							// but that will not handle a native abort
							// Also, save errorCallback to a variable
							// as xhr.onerror cannot be accessed
							window.setTimeout( function() {
								if ( callback ) {
									errorCallback();
								}
							} );
						}
					};
				}

				// Create the abort callback
				callback = callback( "abort" );

				try {

					// Do send the request (this may raise an exception)
					xhr.send( options.hasContent && options.data || null );
				} catch ( e ) {

					// trac-14683: Only rethrow if this hasn't been notified as an error yet
					if ( callback ) {
						throw e;
					}
				}
			},

			abort: function() {
				if ( callback ) {
					callback();
				}
			}
		};
	}
} );




// Prevent auto-execution of scripts when no explicit dataType was provided (See gh-2432)
jQuery.ajaxPrefilter( function( s ) {
	if ( s.crossDomain ) {
		s.contents.script = false;
	}
} );

// Install script dataType
jQuery.ajaxSetup( {
	accepts: {
		script: "text/javascript, application/javascript, " +
			"application/ecmascript, application/x-ecmascript"
	},
	contents: {
		script: /\b(?:java|ecma)script\b/
	},
	converters: {
		"text script": function( text ) {
			jQuery.globalEval( text );
			return text;
		}
	}
} );

// Handle cache's special case and crossDomain
jQuery.ajaxPrefilter( "script", function( s ) {
	if ( s.cache === undefined ) {
		s.cache = false;
	}
	if ( s.crossDomain ) {
		s.type = "GET";
	}
} );

// Bind script tag hack transport
jQuery.ajaxTransport( "script", function( s ) {

	// This transport only deals with cross domain or forced-by-attrs requests
	if ( s.crossDomain || s.scriptAttrs ) {
		var script, callback;
		return {
			send: function( _, complete ) {
				script = jQuery( "<script>" )
					.attr( s.scriptAttrs || {} )
					.prop( { charset: s.scriptCharset, src: s.url } )
					.on( "load error", callback = function( evt ) {
						script.remove();
						callback = null;
						if ( evt ) {
							complete( evt.type === "error" ? 404 : 200, evt.type );
						}
					} );

				// Use native DOM manipulation to avoid our domManip AJAX trickery
				document.head.appendChild( script[ 0 ] );
			},
			abort: function() {
				if ( callback ) {
					callback();
				}
			}
		};
	}
} );




var oldCallbacks = [],
	rjsonp = /(=)\?(?=&|$)|\?\?/;

// Default jsonp settings
jQuery.ajaxSetup( {
	jsonp: "callback",
	jsonpCallback: function() {
		var callback = oldCallbacks.pop() || ( jQuery.expando + "_" + ( nonce.guid++ ) );
		this[ callback ] = true;
		return callback;
	}
} );

// Detect, normalize options and install callbacks for jsonp requests
jQuery.ajaxPrefilter( "json jsonp", function( s, originalSettings, jqXHR ) {

	var callbackName, overwritten, responseContainer,
		jsonProp = s.jsonp !== false && ( rjsonp.test( s.url ) ?
			"url" :
			typeof s.data === "string" &&
				( s.contentType || "" )
					.indexOf( "application/x-www-form-urlencoded" ) === 0 &&
				rjsonp.test( s.data ) && "data"
		);

	// Handle iff the expected data type is "jsonp" or we have a parameter to set
	if ( jsonProp || s.dataTypes[ 0 ] === "jsonp" ) {

		// Get callback name, remembering preexisting value associated with it
		callbackName = s.jsonpCallback = isFunction( s.jsonpCallback ) ?
			s.jsonpCallback() :
			s.jsonpCallback;

		// Insert callback into url or form data
		if ( jsonProp ) {
			s[ jsonProp ] = s[ jsonProp ].replace( rjsonp, "$1" + callbackName );
		} else if ( s.jsonp !== false ) {
			s.url += ( rquery.test( s.url ) ? "&" : "?" ) + s.jsonp + "=" + callbackName;
		}

		// Use data converter to retrieve json after script execution
		s.converters[ "script json" ] = function() {
			if ( !responseContainer ) {
				jQuery.error( callbackName + " was not called" );
			}
			return responseContainer[ 0 ];
		};

		// Force json dataType
		s.dataTypes[ 0 ] = "json";

		// Install callback
		overwritten = window[ callbackName ];
		window[ callbackName ] = function() {
			responseContainer = arguments;
		};

		// Clean-up function (fires after converters)
		jqXHR.always( function() {

			// If previous value didn't exist - remove it
			if ( overwritten === undefined ) {
				jQuery( window ).removeProp( callbackName );

			// Otherwise restore preexisting value
			} else {
				window[ callbackName ] = overwritten;
			}

			// Save back as free
			if ( s[ callbackName ] ) {

				// Make sure that re-using the options doesn't screw things around
				s.jsonpCallback = originalSettings.jsonpCallback;

				// Save the callback name for future use
				oldCallbacks.push( callbackName );
			}

			// Call if it was a function and we have a response
			if ( responseContainer && isFunction( overwritten ) ) {
				overwritten( responseContainer[ 0 ] );
			}

			responseContainer = overwritten = undefined;
		} );

		// Delegate to script
		return "script";
	}
} );




// Support: Safari 8 only
// In Safari 8 documents created via document.implementation.createHTMLDocument
// collapse sibling forms: the second one becomes a child of the first one.
// Because of that, this security measure has to be disabled in Safari 8.
// https://bugs.webkit.org/show_bug.cgi?id=137337
support.createHTMLDocument = ( function() {
	var body = document.implementation.createHTMLDocument( "" ).body;
	body.innerHTML = "<form></form><form></form>";
	return body.childNodes.length === 2;
} )();


// Argument "data" should be string of html
// context (optional): If specified, the fragment will be created in this context,
// defaults to document
// keepScripts (optional): If true, will include scripts passed in the html string
jQuery.parseHTML = function( data, context, keepScripts ) {
	if ( typeof data !== "string" ) {
		return [];
	}
	if ( typeof context === "boolean" ) {
		keepScripts = context;
		context = false;
	}

	var base, parsed, scripts;

	if ( !context ) {

		// Stop scripts or inline event handlers from being executed immediately
		// by using document.implementation
		if ( support.createHTMLDocument ) {
			context = document.implementation.createHTMLDocument( "" );

			// Set the base href for the created document
			// so any parsed elements with URLs
			// are based on the document's URL (gh-2965)
			base = context.createElement( "base" );
			base.href = document.location.href;
			context.head.appendChild( base );
		} else {
			context = document;
		}
	}

	parsed = rsingleTag.exec( data );
	scripts = !keepScripts && [];

	// Single tag
	if ( parsed ) {
		return [ context.createElement( parsed[ 1 ] ) ];
	}

	parsed = buildFragment( [ data ], context, scripts );

	if ( scripts && scripts.length ) {
		jQuery( scripts ).remove();
	}

	return jQuery.merge( [], parsed.childNodes );
};


/**
 * Load a url into a page
 */
jQuery.fn.load = function( url, params, callback ) {
	var selector, type, response,
		self = this,
		off = url.indexOf( " " );

	if ( off > -1 ) {
		selector = stripAndCollapse( url.slice( off ) );
		url = url.slice( 0, off );
	}

	// If it's a function
	if ( isFunction( params ) ) {

		// We assume that it's the callback
		callback = params;
		params = undefined;

	// Otherwise, build a param string
	} else if ( params && typeof params === "object" ) {
		type = "POST";
	}

	// If we have elements to modify, make the request
	if ( self.length > 0 ) {
		jQuery.ajax( {
			url: url,

			// If "type" variable is undefined, then "GET" method will be used.
			// Make value of this field explicit since
			// user can override it through ajaxSetup method
			type: type || "GET",
			dataType: "html",
			data: params
		} ).done( function( responseText ) {

			// Save response for use in complete callback
			response = arguments;

			self.html( selector ?

				// If a selector was specified, locate the right elements in a dummy div
				// Exclude scripts to avoid IE 'Permission Denied' errors
				jQuery( "<div>" ).append( jQuery.parseHTML( responseText ) ).find( selector ) :

				// Otherwise use the full result
				responseText );

		// If the request succeeds, this function gets "data", "status", "jqXHR"
		// but they are ignored because response was set above.
		// If it fails, this function gets "jqXHR", "status", "error"
		} ).always( callback && function( jqXHR, status ) {
			self.each( function() {
				callback.apply( this, response || [ jqXHR.responseText, status, jqXHR ] );
			} );
		} );
	}

	return this;
};




jQuery.expr.pseudos.animated = function( elem ) {
	return jQuery.grep( jQuery.timers, function( fn ) {
		return elem === fn.elem;
	} ).length;
};




jQuery.offset = {
	setOffset: function( elem, options, i ) {
		var curPosition, curLeft, curCSSTop, curTop, curOffset, curCSSLeft, calculatePosition,
			position = jQuery.css( elem, "position" ),
			curElem = jQuery( elem ),
			props = {};

		// Set position first, in-case top/left are set even on static elem
		if ( position === "static" ) {
			elem.style.position = "relative";
		}

		curOffset = curElem.offset();
		curCSSTop = jQuery.css( elem, "top" );
		curCSSLeft = jQuery.css( elem, "left" );
		calculatePosition = ( position === "absolute" || position === "fixed" ) &&
			( curCSSTop + curCSSLeft ).indexOf( "auto" ) > -1;

		// Need to be able to calculate position if either
		// top or left is auto and position is either absolute or fixed
		if ( calculatePosition ) {
			curPosition = curElem.position();
			curTop = curPosition.top;
			curLeft = curPosition.left;

		} else {
			curTop = parseFloat( curCSSTop ) || 0;
			curLeft = parseFloat( curCSSLeft ) || 0;
		}

		if ( isFunction( options ) ) {

			// Use jQuery.extend here to allow modification of coordinates argument (gh-1848)
			options = options.call( elem, i, jQuery.extend( {}, curOffset ) );
		}

		if ( options.top != null ) {
			props.top = ( options.top - curOffset.top ) + curTop;
		}
		if ( options.left != null ) {
			props.left = ( options.left - curOffset.left ) + curLeft;
		}

		if ( "using" in options ) {
			options.using.call( elem, props );

		} else {
			curElem.css( props );
		}
	}
};

jQuery.fn.extend( {

	// offset() relates an element's border box to the document origin
	offset: function( options ) {

		// Preserve chaining for setter
		if ( arguments.length ) {
			return options === undefined ?
				this :
				this.each( function( i ) {
					jQuery.offset.setOffset( this, options, i );
				} );
		}

		var rect, win,
			elem = this[ 0 ];

		if ( !elem ) {
			return;
		}

		// Return zeros for disconnected and hidden (display: none) elements (gh-2310)
		// Support: IE <=11 only
		// Running getBoundingClientRect on a
		// disconnected node in IE throws an error
		if ( !elem.getClientRects().length ) {
			return { top: 0, left: 0 };
		}

		// Get document-relative position by adding viewport scroll to viewport-relative gBCR
		rect = elem.getBoundingClientRect();
		win = elem.ownerDocument.defaultView;
		return {
			top: rect.top + win.pageYOffset,
			left: rect.left + win.pageXOffset
		};
	},

	// position() relates an element's margin box to its offset parent's padding box
	// This corresponds to the behavior of CSS absolute positioning
	position: function() {
		if ( !this[ 0 ] ) {
			return;
		}

		var offsetParent, offset, doc,
			elem = this[ 0 ],
			parentOffset = { top: 0, left: 0 };

		// position:fixed elements are offset from the viewport, which itself always has zero offset
		if ( jQuery.css( elem, "position" ) === "fixed" ) {

			// Assume position:fixed implies availability of getBoundingClientRect
			offset = elem.getBoundingClientRect();

		} else {
			offset = this.offset();

			// Account for the *real* offset parent, which can be the document or its root element
			// when a statically positioned element is identified
			doc = elem.ownerDocument;
			offsetParent = elem.offsetParent || doc.documentElement;
			while ( offsetParent &&
				( offsetParent === doc.body || offsetParent === doc.documentElement ) &&
				jQuery.css( offsetParent, "position" ) === "static" ) {

				offsetParent = offsetParent.parentNode;
			}
			if ( offsetParent && offsetParent !== elem && offsetParent.nodeType === 1 ) {

				// Incorporate borders into its offset, since they are outside its content origin
				parentOffset = jQuery( offsetParent ).offset();
				parentOffset.top += jQuery.css( offsetParent, "borderTopWidth", true );
				parentOffset.left += jQuery.css( offsetParent, "borderLeftWidth", true );
			}
		}

		// Subtract parent offsets and element margins
		return {
			top: offset.top - parentOffset.top - jQuery.css( elem, "marginTop", true ),
			left: offset.left - parentOffset.left - jQuery.css( elem, "marginLeft", true )
		};
	},

	// This method will return documentElement in the following cases:
	// 1) For the element inside the iframe without offsetParent, this method will return
	//    documentElement of the parent window
	// 2) For the hidden or detached element
	// 3) For body or html element, i.e. in case of the html node - it will return itself
	//
	// but those exceptions were never presented as a real life use-cases
	// and might be considered as more preferable results.
	//
	// This logic, however, is not guaranteed and can change at any point in the future
	offsetParent: function() {
		return this.map( function() {
			var offsetParent = this.offsetParent;

			while ( offsetParent && jQuery.css( offsetParent, "position" ) === "static" ) {
				offsetParent = offsetParent.offsetParent;
			}

			return offsetParent || documentElement;
		} );
	}
} );

// Create scrollLeft and scrollTop methods
jQuery.each( { scrollLeft: "pageXOffset", scrollTop: "pageYOffset" }, function( method, prop ) {
	var top = "pageYOffset" === prop;

	jQuery.fn[ method ] = function( val ) {
		return access( this, function( elem, method, val ) {

			// Coalesce documents and windows
			var win;
			if ( isWindow( elem ) ) {
				win = elem;
			} else if ( elem.nodeType === 9 ) {
				win = elem.defaultView;
			}

			if ( val === undefined ) {
				return win ? win[ prop ] : elem[ method ];
			}

			if ( win ) {
				win.scrollTo(
					!top ? val : win.pageXOffset,
					top ? val : win.pageYOffset
				);

			} else {
				elem[ method ] = val;
			}
		}, method, val, arguments.length );
	};
} );

// Support: Safari <=7 - 9.1, Chrome <=37 - 49
// Add the top/left cssHooks using jQuery.fn.position
// Webkit bug: https://bugs.webkit.org/show_bug.cgi?id=29084
// Blink bug: https://bugs.chromium.org/p/chromium/issues/detail?id=589347
// getComputedStyle returns percent when specified for top/left/bottom/right;
// rather than make the css module depend on the offset module, just check for it here
jQuery.each( [ "top", "left" ], function( _i, prop ) {
	jQuery.cssHooks[ prop ] = addGetHookIf( support.pixelPosition,
		function( elem, computed ) {
			if ( computed ) {
				computed = curCSS( elem, prop );

				// If curCSS returns percentage, fallback to offset
				return rnumnonpx.test( computed ) ?
					jQuery( elem ).position()[ prop ] + "px" :
					computed;
			}
		}
	);
} );


// Create innerHeight, innerWidth, height, width, outerHeight and outerWidth methods
jQuery.each( { Height: "height", Width: "width" }, function( name, type ) {
	jQuery.each( {
		padding: "inner" + name,
		content: type,
		"": "outer" + name
	}, function( defaultExtra, funcName ) {

		// Margin is only for outerHeight, outerWidth
		jQuery.fn[ funcName ] = function( margin, value ) {
			var chainable = arguments.length && ( defaultExtra || typeof margin !== "boolean" ),
				extra = defaultExtra || ( margin === true || value === true ? "margin" : "border" );

			return access( this, function( elem, type, value ) {
				var doc;

				if ( isWindow( elem ) ) {

					// $( window ).outerWidth/Height return w/h including scrollbars (gh-1729)
					return funcName.indexOf( "outer" ) === 0 ?
						elem[ "inner" + name ] :
						elem.document.documentElement[ "client" + name ];
				}

				// Get document width or height
				if ( elem.nodeType === 9 ) {
					doc = elem.documentElement;

					// Either scroll[Width/Height] or offset[Width/Height] or client[Width/Height],
					// whichever is greatest
					return Math.max(
						elem.body[ "scroll" + name ], doc[ "scroll" + name ],
						elem.body[ "offset" + name ], doc[ "offset" + name ],
						doc[ "client" + name ]
					);
				}

				return value === undefined ?

					// Get width or height on the element, requesting but not forcing parseFloat
					jQuery.css( elem, type, extra ) :

					// Set width or height on the element
					jQuery.style( elem, type, value, extra );
			}, type, chainable ? margin : undefined, chainable );
		};
	} );
} );


jQuery.each( [
	"ajaxStart",
	"ajaxStop",
	"ajaxComplete",
	"ajaxError",
	"ajaxSuccess",
	"ajaxSend"
], function( _i, type ) {
	jQuery.fn[ type ] = function( fn ) {
		return this.on( type, fn );
	};
} );




jQuery.fn.extend( {

	bind: function( types, data, fn ) {
		return this.on( types, null, data, fn );
	},
	unbind: function( types, fn ) {
		return this.off( types, null, fn );
	},

	delegate: function( selector, types, data, fn ) {
		return this.on( types, selector, data, fn );
	},
	undelegate: function( selector, types, fn ) {

		// ( namespace ) or ( selector, types [, fn] )
		return arguments.length === 1 ?
			this.off( selector, "**" ) :
			this.off( types, selector || "**", fn );
	},

	hover: function( fnOver, fnOut ) {
		return this.mouseenter( fnOver ).mouseleave( fnOut || fnOver );
	}
} );

jQuery.each(
	( "blur focus focusin focusout resize scroll click dblclick " +
	"mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave " +
	"change select submit keydown keypress keyup contextmenu" ).split( " " ),
	function( _i, name ) {

		// Handle event binding
		jQuery.fn[ name ] = function( data, fn ) {
			return arguments.length > 0 ?
				this.on( name, null, data, fn ) :
				this.trigger( name );
		};
	}
);




// Support: Android <=4.0 only
// Make sure we trim BOM and NBSP
// Require that the "whitespace run" starts from a non-whitespace
// to avoid O(N^2) behavior when the engine would try matching "\s+$" at each space position.
var rtrim = /^[\s\uFEFF\xA0]+|([^\s\uFEFF\xA0])[\s\uFEFF\xA0]+$/g;

// Bind a function to a context, optionally partially applying any
// arguments.
// jQuery.proxy is deprecated to promote standards (specifically Function#bind)
// However, it is not slated for removal any time soon
jQuery.proxy = function( fn, context ) {
	var tmp, args, proxy;

	if ( typeof context === "string" ) {
		tmp = fn[ context ];
		context = fn;
		fn = tmp;
	}

	// Quick check to determine if target is callable, in the spec
	// this throws a TypeError, but we will just return undefined.
	if ( !isFunction( fn ) ) {
		return undefined;
	}

	// Simulated bind
	args = slice.call( arguments, 2 );
	proxy = function() {
		return fn.apply( context || this, args.concat( slice.call( arguments ) ) );
	};

	// Set the guid of unique handler to the same of original handler, so it can be removed
	proxy.guid = fn.guid = fn.guid || jQuery.guid++;

	return proxy;
};

jQuery.holdReady = function( hold ) {
	if ( hold ) {
		jQuery.readyWait++;
	} else {
		jQuery.ready( true );
	}
};
jQuery.isArray = Array.isArray;
jQuery.parseJSON = JSON.parse;
jQuery.nodeName = nodeName;
jQuery.isFunction = isFunction;
jQuery.isWindow = isWindow;
jQuery.camelCase = camelCase;
jQuery.type = toType;

jQuery.now = Date.now;

jQuery.isNumeric = function( obj ) {

	// As of jQuery 3.0, isNumeric is limited to
	// strings and numbers (primitives or objects)
	// that can be coerced to finite numbers (gh-2662)
	var type = jQuery.type( obj );
	return ( type === "number" || type === "string" ) &&

		// parseFloat NaNs numeric-cast false positives ("")
		// ...but misinterprets leading-number strings, particularly hex literals ("0x...")
		// subtraction forces infinities to NaN
		!isNaN( obj - parseFloat( obj ) );
};

jQuery.trim = function( text ) {
	return text == null ?
		"" :
		( text + "" ).replace( rtrim, "$1" );
};



// Register as a named AMD module, since jQuery can be concatenated with other
// files that may use define, but not via a proper concatenation script that
// understands anonymous AMD modules. A named AMD is safest and most robust
// way to register. Lowercase jquery is used because AMD module names are
// derived from file names, and jQuery is normally delivered in a lowercase
// file name. Do this after creating the global so that if an AMD module wants
// to call noConflict to hide this version of jQuery, it will work.

// Note that for maximum portability, libraries that are not jQuery should
// declare themselves as anonymous modules, and avoid setting a global if an
// AMD loader is present. jQuery is a special case. For more information, see
// https://github.com/jrburke/requirejs/wiki/Updating-existing-libraries#wiki-anon

if ( true ) {
	!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = (function() {
		return jQuery;
	}).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
}




var

	// Map over jQuery in case of overwrite
	_jQuery = window.jQuery,

	// Map over the $ in case of overwrite
	_$ = window.$;

jQuery.noConflict = function( deep ) {
	if ( window.$ === jQuery ) {
		window.$ = _$;
	}

	if ( deep && window.jQuery === jQuery ) {
		window.jQuery = _jQuery;
	}

	return jQuery;
};

// Expose jQuery and $ identifiers, even in AMD
// (trac-7102#comment:10, https://github.com/jquery/jquery/pull/557)
// and CommonJS for browser emulators (trac-13566)
if ( typeof noGlobal === "undefined" ) {
	window.jQuery = window.$ = jQuery;
}




return jQuery;
} );


/***/ }),

/***/ "./node_modules/owl.carousel/dist/owl.carousel.js":
/*!********************************************************!*\
  !*** ./node_modules/owl.carousel/dist/owl.carousel.js ***!
  \********************************************************/
/***/ (() => {

/**
 * Owl Carousel v2.3.4
 * Copyright 2013-2018 David Deutsch
 * Licensed under: SEE LICENSE IN https://github.com/OwlCarousel2/OwlCarousel2/blob/master/LICENSE
 */
/**
 * Owl carousel
 * @version 2.3.4
 * @author Bartosz Wojciechowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 * @todo Lazy Load Icon
 * @todo prevent animationend bubling
 * @todo itemsScaleUp
 * @todo Test Zepto
 * @todo stagePadding calculate wrong active classes
 */
;(function($, window, document, undefined) {

	/**
	 * Creates a carousel.
	 * @class The Owl Carousel.
	 * @public
	 * @param {HTMLElement|jQuery} element - The element to create the carousel for.
	 * @param {Object} [options] - The options
	 */
	function Owl(element, options) {

		/**
		 * Current settings for the carousel.
		 * @public
		 */
		this.settings = null;

		/**
		 * Current options set by the caller including defaults.
		 * @public
		 */
		this.options = $.extend({}, Owl.Defaults, options);

		/**
		 * Plugin element.
		 * @public
		 */
		this.$element = $(element);

		/**
		 * Proxied event handlers.
		 * @protected
		 */
		this._handlers = {};

		/**
		 * References to the running plugins of this carousel.
		 * @protected
		 */
		this._plugins = {};

		/**
		 * Currently suppressed events to prevent them from being retriggered.
		 * @protected
		 */
		this._supress = {};

		/**
		 * Absolute current position.
		 * @protected
		 */
		this._current = null;

		/**
		 * Animation speed in milliseconds.
		 * @protected
		 */
		this._speed = null;

		/**
		 * Coordinates of all items in pixel.
		 * @todo The name of this member is missleading.
		 * @protected
		 */
		this._coordinates = [];

		/**
		 * Current breakpoint.
		 * @todo Real media queries would be nice.
		 * @protected
		 */
		this._breakpoint = null;

		/**
		 * Current width of the plugin element.
		 */
		this._width = null;

		/**
		 * All real items.
		 * @protected
		 */
		this._items = [];

		/**
		 * All cloned items.
		 * @protected
		 */
		this._clones = [];

		/**
		 * Merge values of all items.
		 * @todo Maybe this could be part of a plugin.
		 * @protected
		 */
		this._mergers = [];

		/**
		 * Widths of all items.
		 */
		this._widths = [];

		/**
		 * Invalidated parts within the update process.
		 * @protected
		 */
		this._invalidated = {};

		/**
		 * Ordered list of workers for the update process.
		 * @protected
		 */
		this._pipe = [];

		/**
		 * Current state information for the drag operation.
		 * @todo #261
		 * @protected
		 */
		this._drag = {
			time: null,
			target: null,
			pointer: null,
			stage: {
				start: null,
				current: null
			},
			direction: null
		};

		/**
		 * Current state information and their tags.
		 * @type {Object}
		 * @protected
		 */
		this._states = {
			current: {},
			tags: {
				'initializing': [ 'busy' ],
				'animating': [ 'busy' ],
				'dragging': [ 'interacting' ]
			}
		};

		$.each([ 'onResize', 'onThrottledResize' ], $.proxy(function(i, handler) {
			this._handlers[handler] = $.proxy(this[handler], this);
		}, this));

		$.each(Owl.Plugins, $.proxy(function(key, plugin) {
			this._plugins[key.charAt(0).toLowerCase() + key.slice(1)]
				= new plugin(this);
		}, this));

		$.each(Owl.Workers, $.proxy(function(priority, worker) {
			this._pipe.push({
				'filter': worker.filter,
				'run': $.proxy(worker.run, this)
			});
		}, this));

		this.setup();
		this.initialize();
	}

	/**
	 * Default options for the carousel.
	 * @public
	 */
	Owl.Defaults = {
		items: 3,
		loop: false,
		center: false,
		rewind: false,
		checkVisibility: true,

		mouseDrag: true,
		touchDrag: true,
		pullDrag: true,
		freeDrag: false,

		margin: 0,
		stagePadding: 0,

		merge: false,
		mergeFit: true,
		autoWidth: false,

		startPosition: 0,
		rtl: false,

		smartSpeed: 250,
		fluidSpeed: false,
		dragEndSpeed: false,

		responsive: {},
		responsiveRefreshRate: 200,
		responsiveBaseElement: window,

		fallbackEasing: 'swing',
		slideTransition: '',

		info: false,

		nestedItemSelector: false,
		itemElement: 'div',
		stageElement: 'div',

		refreshClass: 'owl-refresh',
		loadedClass: 'owl-loaded',
		loadingClass: 'owl-loading',
		rtlClass: 'owl-rtl',
		responsiveClass: 'owl-responsive',
		dragClass: 'owl-drag',
		itemClass: 'owl-item',
		stageClass: 'owl-stage',
		stageOuterClass: 'owl-stage-outer',
		grabClass: 'owl-grab'
	};

	/**
	 * Enumeration for width.
	 * @public
	 * @readonly
	 * @enum {String}
	 */
	Owl.Width = {
		Default: 'default',
		Inner: 'inner',
		Outer: 'outer'
	};

	/**
	 * Enumeration for types.
	 * @public
	 * @readonly
	 * @enum {String}
	 */
	Owl.Type = {
		Event: 'event',
		State: 'state'
	};

	/**
	 * Contains all registered plugins.
	 * @public
	 */
	Owl.Plugins = {};

	/**
	 * List of workers involved in the update process.
	 */
	Owl.Workers = [ {
		filter: [ 'width', 'settings' ],
		run: function() {
			this._width = this.$element.width();
		}
	}, {
		filter: [ 'width', 'items', 'settings' ],
		run: function(cache) {
			cache.current = this._items && this._items[this.relative(this._current)];
		}
	}, {
		filter: [ 'items', 'settings' ],
		run: function() {
			this.$stage.children('.cloned').remove();
		}
	}, {
		filter: [ 'width', 'items', 'settings' ],
		run: function(cache) {
			var margin = this.settings.margin || '',
				grid = !this.settings.autoWidth,
				rtl = this.settings.rtl,
				css = {
					'width': 'auto',
					'margin-left': rtl ? margin : '',
					'margin-right': rtl ? '' : margin
				};

			!grid && this.$stage.children().css(css);

			cache.css = css;
		}
	}, {
		filter: [ 'width', 'items', 'settings' ],
		run: function(cache) {
			var width = (this.width() / this.settings.items).toFixed(3) - this.settings.margin,
				merge = null,
				iterator = this._items.length,
				grid = !this.settings.autoWidth,
				widths = [];

			cache.items = {
				merge: false,
				width: width
			};

			while (iterator--) {
				merge = this._mergers[iterator];
				merge = this.settings.mergeFit && Math.min(merge, this.settings.items) || merge;

				cache.items.merge = merge > 1 || cache.items.merge;

				widths[iterator] = !grid ? this._items[iterator].width() : width * merge;
			}

			this._widths = widths;
		}
	}, {
		filter: [ 'items', 'settings' ],
		run: function() {
			var clones = [],
				items = this._items,
				settings = this.settings,
				// TODO: Should be computed from number of min width items in stage
				view = Math.max(settings.items * 2, 4),
				size = Math.ceil(items.length / 2) * 2,
				repeat = settings.loop && items.length ? settings.rewind ? view : Math.max(view, size) : 0,
				append = '',
				prepend = '';

			repeat /= 2;

			while (repeat > 0) {
				// Switch to only using appended clones
				clones.push(this.normalize(clones.length / 2, true));
				append = append + items[clones[clones.length - 1]][0].outerHTML;
				clones.push(this.normalize(items.length - 1 - (clones.length - 1) / 2, true));
				prepend = items[clones[clones.length - 1]][0].outerHTML + prepend;
				repeat -= 1;
			}

			this._clones = clones;

			$(append).addClass('cloned').appendTo(this.$stage);
			$(prepend).addClass('cloned').prependTo(this.$stage);
		}
	}, {
		filter: [ 'width', 'items', 'settings' ],
		run: function() {
			var rtl = this.settings.rtl ? 1 : -1,
				size = this._clones.length + this._items.length,
				iterator = -1,
				previous = 0,
				current = 0,
				coordinates = [];

			while (++iterator < size) {
				previous = coordinates[iterator - 1] || 0;
				current = this._widths[this.relative(iterator)] + this.settings.margin;
				coordinates.push(previous + current * rtl);
			}

			this._coordinates = coordinates;
		}
	}, {
		filter: [ 'width', 'items', 'settings' ],
		run: function() {
			var padding = this.settings.stagePadding,
				coordinates = this._coordinates,
				css = {
					'width': Math.ceil(Math.abs(coordinates[coordinates.length - 1])) + padding * 2,
					'padding-left': padding || '',
					'padding-right': padding || ''
				};

			this.$stage.css(css);
		}
	}, {
		filter: [ 'width', 'items', 'settings' ],
		run: function(cache) {
			var iterator = this._coordinates.length,
				grid = !this.settings.autoWidth,
				items = this.$stage.children();

			if (grid && cache.items.merge) {
				while (iterator--) {
					cache.css.width = this._widths[this.relative(iterator)];
					items.eq(iterator).css(cache.css);
				}
			} else if (grid) {
				cache.css.width = cache.items.width;
				items.css(cache.css);
			}
		}
	}, {
		filter: [ 'items' ],
		run: function() {
			this._coordinates.length < 1 && this.$stage.removeAttr('style');
		}
	}, {
		filter: [ 'width', 'items', 'settings' ],
		run: function(cache) {
			cache.current = cache.current ? this.$stage.children().index(cache.current) : 0;
			cache.current = Math.max(this.minimum(), Math.min(this.maximum(), cache.current));
			this.reset(cache.current);
		}
	}, {
		filter: [ 'position' ],
		run: function() {
			this.animate(this.coordinates(this._current));
		}
	}, {
		filter: [ 'width', 'position', 'items', 'settings' ],
		run: function() {
			var rtl = this.settings.rtl ? 1 : -1,
				padding = this.settings.stagePadding * 2,
				begin = this.coordinates(this.current()) + padding,
				end = begin + this.width() * rtl,
				inner, outer, matches = [], i, n;

			for (i = 0, n = this._coordinates.length; i < n; i++) {
				inner = this._coordinates[i - 1] || 0;
				outer = Math.abs(this._coordinates[i]) + padding * rtl;

				if ((this.op(inner, '<=', begin) && (this.op(inner, '>', end)))
					|| (this.op(outer, '<', begin) && this.op(outer, '>', end))) {
					matches.push(i);
				}
			}

			this.$stage.children('.active').removeClass('active');
			this.$stage.children(':eq(' + matches.join('), :eq(') + ')').addClass('active');

			this.$stage.children('.center').removeClass('center');
			if (this.settings.center) {
				this.$stage.children().eq(this.current()).addClass('center');
			}
		}
	} ];

	/**
	 * Create the stage DOM element
	 */
	Owl.prototype.initializeStage = function() {
		this.$stage = this.$element.find('.' + this.settings.stageClass);

		// if the stage is already in the DOM, grab it and skip stage initialization
		if (this.$stage.length) {
			return;
		}

		this.$element.addClass(this.options.loadingClass);

		// create stage
		this.$stage = $('<' + this.settings.stageElement + '>', {
			"class": this.settings.stageClass
		}).wrap( $( '<div/>', {
			"class": this.settings.stageOuterClass
		}));

		// append stage
		this.$element.append(this.$stage.parent());
	};

	/**
	 * Create item DOM elements
	 */
	Owl.prototype.initializeItems = function() {
		var $items = this.$element.find('.owl-item');

		// if the items are already in the DOM, grab them and skip item initialization
		if ($items.length) {
			this._items = $items.get().map(function(item) {
				return $(item);
			});

			this._mergers = this._items.map(function() {
				return 1;
			});

			this.refresh();

			return;
		}

		// append content
		this.replace(this.$element.children().not(this.$stage.parent()));

		// check visibility
		if (this.isVisible()) {
			// update view
			this.refresh();
		} else {
			// invalidate width
			this.invalidate('width');
		}

		this.$element
			.removeClass(this.options.loadingClass)
			.addClass(this.options.loadedClass);
	};

	/**
	 * Initializes the carousel.
	 * @protected
	 */
	Owl.prototype.initialize = function() {
		this.enter('initializing');
		this.trigger('initialize');

		this.$element.toggleClass(this.settings.rtlClass, this.settings.rtl);

		if (this.settings.autoWidth && !this.is('pre-loading')) {
			var imgs, nestedSelector, width;
			imgs = this.$element.find('img');
			nestedSelector = this.settings.nestedItemSelector ? '.' + this.settings.nestedItemSelector : undefined;
			width = this.$element.children(nestedSelector).width();

			if (imgs.length && width <= 0) {
				this.preloadAutoWidthImages(imgs);
			}
		}

		this.initializeStage();
		this.initializeItems();

		// register event handlers
		this.registerEventHandlers();

		this.leave('initializing');
		this.trigger('initialized');
	};

	/**
	 * @returns {Boolean} visibility of $element
	 *                    if you know the carousel will always be visible you can set `checkVisibility` to `false` to
	 *                    prevent the expensive browser layout forced reflow the $element.is(':visible') does
	 */
	Owl.prototype.isVisible = function() {
		return this.settings.checkVisibility
			? this.$element.is(':visible')
			: true;
	};

	/**
	 * Setups the current settings.
	 * @todo Remove responsive classes. Why should adaptive designs be brought into IE8?
	 * @todo Support for media queries by using `matchMedia` would be nice.
	 * @public
	 */
	Owl.prototype.setup = function() {
		var viewport = this.viewport(),
			overwrites = this.options.responsive,
			match = -1,
			settings = null;

		if (!overwrites) {
			settings = $.extend({}, this.options);
		} else {
			$.each(overwrites, function(breakpoint) {
				if (breakpoint <= viewport && breakpoint > match) {
					match = Number(breakpoint);
				}
			});

			settings = $.extend({}, this.options, overwrites[match]);
			if (typeof settings.stagePadding === 'function') {
				settings.stagePadding = settings.stagePadding();
			}
			delete settings.responsive;

			// responsive class
			if (settings.responsiveClass) {
				this.$element.attr('class',
					this.$element.attr('class').replace(new RegExp('(' + this.options.responsiveClass + '-)\\S+\\s', 'g'), '$1' + match)
				);
			}
		}

		this.trigger('change', { property: { name: 'settings', value: settings } });
		this._breakpoint = match;
		this.settings = settings;
		this.invalidate('settings');
		this.trigger('changed', { property: { name: 'settings', value: this.settings } });
	};

	/**
	 * Updates option logic if necessery.
	 * @protected
	 */
	Owl.prototype.optionsLogic = function() {
		if (this.settings.autoWidth) {
			this.settings.stagePadding = false;
			this.settings.merge = false;
		}
	};

	/**
	 * Prepares an item before add.
	 * @todo Rename event parameter `content` to `item`.
	 * @protected
	 * @returns {jQuery|HTMLElement} - The item container.
	 */
	Owl.prototype.prepare = function(item) {
		var event = this.trigger('prepare', { content: item });

		if (!event.data) {
			event.data = $('<' + this.settings.itemElement + '/>')
				.addClass(this.options.itemClass).append(item)
		}

		this.trigger('prepared', { content: event.data });

		return event.data;
	};

	/**
	 * Updates the view.
	 * @public
	 */
	Owl.prototype.update = function() {
		var i = 0,
			n = this._pipe.length,
			filter = $.proxy(function(p) { return this[p] }, this._invalidated),
			cache = {};

		while (i < n) {
			if (this._invalidated.all || $.grep(this._pipe[i].filter, filter).length > 0) {
				this._pipe[i].run(cache);
			}
			i++;
		}

		this._invalidated = {};

		!this.is('valid') && this.enter('valid');
	};

	/**
	 * Gets the width of the view.
	 * @public
	 * @param {Owl.Width} [dimension=Owl.Width.Default] - The dimension to return.
	 * @returns {Number} - The width of the view in pixel.
	 */
	Owl.prototype.width = function(dimension) {
		dimension = dimension || Owl.Width.Default;
		switch (dimension) {
			case Owl.Width.Inner:
			case Owl.Width.Outer:
				return this._width;
			default:
				return this._width - this.settings.stagePadding * 2 + this.settings.margin;
		}
	};

	/**
	 * Refreshes the carousel primarily for adaptive purposes.
	 * @public
	 */
	Owl.prototype.refresh = function() {
		this.enter('refreshing');
		this.trigger('refresh');

		this.setup();

		this.optionsLogic();

		this.$element.addClass(this.options.refreshClass);

		this.update();

		this.$element.removeClass(this.options.refreshClass);

		this.leave('refreshing');
		this.trigger('refreshed');
	};

	/**
	 * Checks window `resize` event.
	 * @protected
	 */
	Owl.prototype.onThrottledResize = function() {
		window.clearTimeout(this.resizeTimer);
		this.resizeTimer = window.setTimeout(this._handlers.onResize, this.settings.responsiveRefreshRate);
	};

	/**
	 * Checks window `resize` event.
	 * @protected
	 */
	Owl.prototype.onResize = function() {
		if (!this._items.length) {
			return false;
		}

		if (this._width === this.$element.width()) {
			return false;
		}

		if (!this.isVisible()) {
			return false;
		}

		this.enter('resizing');

		if (this.trigger('resize').isDefaultPrevented()) {
			this.leave('resizing');
			return false;
		}

		this.invalidate('width');

		this.refresh();

		this.leave('resizing');
		this.trigger('resized');
	};

	/**
	 * Registers event handlers.
	 * @todo Check `msPointerEnabled`
	 * @todo #261
	 * @protected
	 */
	Owl.prototype.registerEventHandlers = function() {
		if ($.support.transition) {
			this.$stage.on($.support.transition.end + '.owl.core', $.proxy(this.onTransitionEnd, this));
		}

		if (this.settings.responsive !== false) {
			this.on(window, 'resize', this._handlers.onThrottledResize);
		}

		if (this.settings.mouseDrag) {
			this.$element.addClass(this.options.dragClass);
			this.$stage.on('mousedown.owl.core', $.proxy(this.onDragStart, this));
			this.$stage.on('dragstart.owl.core selectstart.owl.core', function() { return false });
		}

		if (this.settings.touchDrag){
			this.$stage.on('touchstart.owl.core', $.proxy(this.onDragStart, this));
			this.$stage.on('touchcancel.owl.core', $.proxy(this.onDragEnd, this));
		}
	};

	/**
	 * Handles `touchstart` and `mousedown` events.
	 * @todo Horizontal swipe threshold as option
	 * @todo #261
	 * @protected
	 * @param {Event} event - The event arguments.
	 */
	Owl.prototype.onDragStart = function(event) {
		var stage = null;

		if (event.which === 3) {
			return;
		}

		if ($.support.transform) {
			stage = this.$stage.css('transform').replace(/.*\(|\)| /g, '').split(',');
			stage = {
				x: stage[stage.length === 16 ? 12 : 4],
				y: stage[stage.length === 16 ? 13 : 5]
			};
		} else {
			stage = this.$stage.position();
			stage = {
				x: this.settings.rtl ?
					stage.left + this.$stage.width() - this.width() + this.settings.margin :
					stage.left,
				y: stage.top
			};
		}

		if (this.is('animating')) {
			$.support.transform ? this.animate(stage.x) : this.$stage.stop()
			this.invalidate('position');
		}

		this.$element.toggleClass(this.options.grabClass, event.type === 'mousedown');

		this.speed(0);

		this._drag.time = new Date().getTime();
		this._drag.target = $(event.target);
		this._drag.stage.start = stage;
		this._drag.stage.current = stage;
		this._drag.pointer = this.pointer(event);

		$(document).on('mouseup.owl.core touchend.owl.core', $.proxy(this.onDragEnd, this));

		$(document).one('mousemove.owl.core touchmove.owl.core', $.proxy(function(event) {
			var delta = this.difference(this._drag.pointer, this.pointer(event));

			$(document).on('mousemove.owl.core touchmove.owl.core', $.proxy(this.onDragMove, this));

			if (Math.abs(delta.x) < Math.abs(delta.y) && this.is('valid')) {
				return;
			}

			event.preventDefault();

			this.enter('dragging');
			this.trigger('drag');
		}, this));
	};

	/**
	 * Handles the `touchmove` and `mousemove` events.
	 * @todo #261
	 * @protected
	 * @param {Event} event - The event arguments.
	 */
	Owl.prototype.onDragMove = function(event) {
		var minimum = null,
			maximum = null,
			pull = null,
			delta = this.difference(this._drag.pointer, this.pointer(event)),
			stage = this.difference(this._drag.stage.start, delta);

		if (!this.is('dragging')) {
			return;
		}

		event.preventDefault();

		if (this.settings.loop) {
			minimum = this.coordinates(this.minimum());
			maximum = this.coordinates(this.maximum() + 1) - minimum;
			stage.x = (((stage.x - minimum) % maximum + maximum) % maximum) + minimum;
		} else {
			minimum = this.settings.rtl ? this.coordinates(this.maximum()) : this.coordinates(this.minimum());
			maximum = this.settings.rtl ? this.coordinates(this.minimum()) : this.coordinates(this.maximum());
			pull = this.settings.pullDrag ? -1 * delta.x / 5 : 0;
			stage.x = Math.max(Math.min(stage.x, minimum + pull), maximum + pull);
		}

		this._drag.stage.current = stage;

		this.animate(stage.x);
	};

	/**
	 * Handles the `touchend` and `mouseup` events.
	 * @todo #261
	 * @todo Threshold for click event
	 * @protected
	 * @param {Event} event - The event arguments.
	 */
	Owl.prototype.onDragEnd = function(event) {
		var delta = this.difference(this._drag.pointer, this.pointer(event)),
			stage = this._drag.stage.current,
			direction = delta.x > 0 ^ this.settings.rtl ? 'left' : 'right';

		$(document).off('.owl.core');

		this.$element.removeClass(this.options.grabClass);

		if (delta.x !== 0 && this.is('dragging') || !this.is('valid')) {
			this.speed(this.settings.dragEndSpeed || this.settings.smartSpeed);
			this.current(this.closest(stage.x, delta.x !== 0 ? direction : this._drag.direction));
			this.invalidate('position');
			this.update();

			this._drag.direction = direction;

			if (Math.abs(delta.x) > 3 || new Date().getTime() - this._drag.time > 300) {
				this._drag.target.one('click.owl.core', function() { return false; });
			}
		}

		if (!this.is('dragging')) {
			return;
		}

		this.leave('dragging');
		this.trigger('dragged');
	};

	/**
	 * Gets absolute position of the closest item for a coordinate.
	 * @todo Setting `freeDrag` makes `closest` not reusable. See #165.
	 * @protected
	 * @param {Number} coordinate - The coordinate in pixel.
	 * @param {String} direction - The direction to check for the closest item. Ether `left` or `right`.
	 * @return {Number} - The absolute position of the closest item.
	 */
	Owl.prototype.closest = function(coordinate, direction) {
		var position = -1,
			pull = 30,
			width = this.width(),
			coordinates = this.coordinates();

		if (!this.settings.freeDrag) {
			// check closest item
			$.each(coordinates, $.proxy(function(index, value) {
				// on a left pull, check on current index
				if (direction === 'left' && coordinate > value - pull && coordinate < value + pull) {
					position = index;
				// on a right pull, check on previous index
				// to do so, subtract width from value and set position = index + 1
				} else if (direction === 'right' && coordinate > value - width - pull && coordinate < value - width + pull) {
					position = index + 1;
				} else if (this.op(coordinate, '<', value)
					&& this.op(coordinate, '>', coordinates[index + 1] !== undefined ? coordinates[index + 1] : value - width)) {
					position = direction === 'left' ? index + 1 : index;
				}
				return position === -1;
			}, this));
		}

		if (!this.settings.loop) {
			// non loop boundries
			if (this.op(coordinate, '>', coordinates[this.minimum()])) {
				position = coordinate = this.minimum();
			} else if (this.op(coordinate, '<', coordinates[this.maximum()])) {
				position = coordinate = this.maximum();
			}
		}

		return position;
	};

	/**
	 * Animates the stage.
	 * @todo #270
	 * @public
	 * @param {Number} coordinate - The coordinate in pixels.
	 */
	Owl.prototype.animate = function(coordinate) {
		var animate = this.speed() > 0;

		this.is('animating') && this.onTransitionEnd();

		if (animate) {
			this.enter('animating');
			this.trigger('translate');
		}

		if ($.support.transform3d && $.support.transition) {
			this.$stage.css({
				transform: 'translate3d(' + coordinate + 'px,0px,0px)',
				transition: (this.speed() / 1000) + 's' + (
					this.settings.slideTransition ? ' ' + this.settings.slideTransition : ''
				)
			});
		} else if (animate) {
			this.$stage.animate({
				left: coordinate + 'px'
			}, this.speed(), this.settings.fallbackEasing, $.proxy(this.onTransitionEnd, this));
		} else {
			this.$stage.css({
				left: coordinate + 'px'
			});
		}
	};

	/**
	 * Checks whether the carousel is in a specific state or not.
	 * @param {String} state - The state to check.
	 * @returns {Boolean} - The flag which indicates if the carousel is busy.
	 */
	Owl.prototype.is = function(state) {
		return this._states.current[state] && this._states.current[state] > 0;
	};

	/**
	 * Sets the absolute position of the current item.
	 * @public
	 * @param {Number} [position] - The new absolute position or nothing to leave it unchanged.
	 * @returns {Number} - The absolute position of the current item.
	 */
	Owl.prototype.current = function(position) {
		if (position === undefined) {
			return this._current;
		}

		if (this._items.length === 0) {
			return undefined;
		}

		position = this.normalize(position);

		if (this._current !== position) {
			var event = this.trigger('change', { property: { name: 'position', value: position } });

			if (event.data !== undefined) {
				position = this.normalize(event.data);
			}

			this._current = position;

			this.invalidate('position');

			this.trigger('changed', { property: { name: 'position', value: this._current } });
		}

		return this._current;
	};

	/**
	 * Invalidates the given part of the update routine.
	 * @param {String} [part] - The part to invalidate.
	 * @returns {Array.<String>} - The invalidated parts.
	 */
	Owl.prototype.invalidate = function(part) {
		if ($.type(part) === 'string') {
			this._invalidated[part] = true;
			this.is('valid') && this.leave('valid');
		}
		return $.map(this._invalidated, function(v, i) { return i });
	};

	/**
	 * Resets the absolute position of the current item.
	 * @public
	 * @param {Number} position - The absolute position of the new item.
	 */
	Owl.prototype.reset = function(position) {
		position = this.normalize(position);

		if (position === undefined) {
			return;
		}

		this._speed = 0;
		this._current = position;

		this.suppress([ 'translate', 'translated' ]);

		this.animate(this.coordinates(position));

		this.release([ 'translate', 'translated' ]);
	};

	/**
	 * Normalizes an absolute or a relative position of an item.
	 * @public
	 * @param {Number} position - The absolute or relative position to normalize.
	 * @param {Boolean} [relative=false] - Whether the given position is relative or not.
	 * @returns {Number} - The normalized position.
	 */
	Owl.prototype.normalize = function(position, relative) {
		var n = this._items.length,
			m = relative ? 0 : this._clones.length;

		if (!this.isNumeric(position) || n < 1) {
			position = undefined;
		} else if (position < 0 || position >= n + m) {
			position = ((position - m / 2) % n + n) % n + m / 2;
		}

		return position;
	};

	/**
	 * Converts an absolute position of an item into a relative one.
	 * @public
	 * @param {Number} position - The absolute position to convert.
	 * @returns {Number} - The converted position.
	 */
	Owl.prototype.relative = function(position) {
		position -= this._clones.length / 2;
		return this.normalize(position, true);
	};

	/**
	 * Gets the maximum position for the current item.
	 * @public
	 * @param {Boolean} [relative=false] - Whether to return an absolute position or a relative position.
	 * @returns {Number}
	 */
	Owl.prototype.maximum = function(relative) {
		var settings = this.settings,
			maximum = this._coordinates.length,
			iterator,
			reciprocalItemsWidth,
			elementWidth;

		if (settings.loop) {
			maximum = this._clones.length / 2 + this._items.length - 1;
		} else if (settings.autoWidth || settings.merge) {
			iterator = this._items.length;
			if (iterator) {
				reciprocalItemsWidth = this._items[--iterator].width();
				elementWidth = this.$element.width();
				while (iterator--) {
					reciprocalItemsWidth += this._items[iterator].width() + this.settings.margin;
					if (reciprocalItemsWidth > elementWidth) {
						break;
					}
				}
			}
			maximum = iterator + 1;
		} else if (settings.center) {
			maximum = this._items.length - 1;
		} else {
			maximum = this._items.length - settings.items;
		}

		if (relative) {
			maximum -= this._clones.length / 2;
		}

		return Math.max(maximum, 0);
	};

	/**
	 * Gets the minimum position for the current item.
	 * @public
	 * @param {Boolean} [relative=false] - Whether to return an absolute position or a relative position.
	 * @returns {Number}
	 */
	Owl.prototype.minimum = function(relative) {
		return relative ? 0 : this._clones.length / 2;
	};

	/**
	 * Gets an item at the specified relative position.
	 * @public
	 * @param {Number} [position] - The relative position of the item.
	 * @return {jQuery|Array.<jQuery>} - The item at the given position or all items if no position was given.
	 */
	Owl.prototype.items = function(position) {
		if (position === undefined) {
			return this._items.slice();
		}

		position = this.normalize(position, true);
		return this._items[position];
	};

	/**
	 * Gets an item at the specified relative position.
	 * @public
	 * @param {Number} [position] - The relative position of the item.
	 * @return {jQuery|Array.<jQuery>} - The item at the given position or all items if no position was given.
	 */
	Owl.prototype.mergers = function(position) {
		if (position === undefined) {
			return this._mergers.slice();
		}

		position = this.normalize(position, true);
		return this._mergers[position];
	};

	/**
	 * Gets the absolute positions of clones for an item.
	 * @public
	 * @param {Number} [position] - The relative position of the item.
	 * @returns {Array.<Number>} - The absolute positions of clones for the item or all if no position was given.
	 */
	Owl.prototype.clones = function(position) {
		var odd = this._clones.length / 2,
			even = odd + this._items.length,
			map = function(index) { return index % 2 === 0 ? even + index / 2 : odd - (index + 1) / 2 };

		if (position === undefined) {
			return $.map(this._clones, function(v, i) { return map(i) });
		}

		return $.map(this._clones, function(v, i) { return v === position ? map(i) : null });
	};

	/**
	 * Sets the current animation speed.
	 * @public
	 * @param {Number} [speed] - The animation speed in milliseconds or nothing to leave it unchanged.
	 * @returns {Number} - The current animation speed in milliseconds.
	 */
	Owl.prototype.speed = function(speed) {
		if (speed !== undefined) {
			this._speed = speed;
		}

		return this._speed;
	};

	/**
	 * Gets the coordinate of an item.
	 * @todo The name of this method is missleanding.
	 * @public
	 * @param {Number} position - The absolute position of the item within `minimum()` and `maximum()`.
	 * @returns {Number|Array.<Number>} - The coordinate of the item in pixel or all coordinates.
	 */
	Owl.prototype.coordinates = function(position) {
		var multiplier = 1,
			newPosition = position - 1,
			coordinate;

		if (position === undefined) {
			return $.map(this._coordinates, $.proxy(function(coordinate, index) {
				return this.coordinates(index);
			}, this));
		}

		if (this.settings.center) {
			if (this.settings.rtl) {
				multiplier = -1;
				newPosition = position + 1;
			}

			coordinate = this._coordinates[position];
			coordinate += (this.width() - coordinate + (this._coordinates[newPosition] || 0)) / 2 * multiplier;
		} else {
			coordinate = this._coordinates[newPosition] || 0;
		}

		coordinate = Math.ceil(coordinate);

		return coordinate;
	};

	/**
	 * Calculates the speed for a translation.
	 * @protected
	 * @param {Number} from - The absolute position of the start item.
	 * @param {Number} to - The absolute position of the target item.
	 * @param {Number} [factor=undefined] - The time factor in milliseconds.
	 * @returns {Number} - The time in milliseconds for the translation.
	 */
	Owl.prototype.duration = function(from, to, factor) {
		if (factor === 0) {
			return 0;
		}

		return Math.min(Math.max(Math.abs(to - from), 1), 6) * Math.abs((factor || this.settings.smartSpeed));
	};

	/**
	 * Slides to the specified item.
	 * @public
	 * @param {Number} position - The position of the item.
	 * @param {Number} [speed] - The time in milliseconds for the transition.
	 */
	Owl.prototype.to = function(position, speed) {
		var current = this.current(),
			revert = null,
			distance = position - this.relative(current),
			direction = (distance > 0) - (distance < 0),
			items = this._items.length,
			minimum = this.minimum(),
			maximum = this.maximum();

		if (this.settings.loop) {
			if (!this.settings.rewind && Math.abs(distance) > items / 2) {
				distance += direction * -1 * items;
			}

			position = current + distance;
			revert = ((position - minimum) % items + items) % items + minimum;

			if (revert !== position && revert - distance <= maximum && revert - distance > 0) {
				current = revert - distance;
				position = revert;
				this.reset(current);
			}
		} else if (this.settings.rewind) {
			maximum += 1;
			position = (position % maximum + maximum) % maximum;
		} else {
			position = Math.max(minimum, Math.min(maximum, position));
		}

		this.speed(this.duration(current, position, speed));
		this.current(position);

		if (this.isVisible()) {
			this.update();
		}
	};

	/**
	 * Slides to the next item.
	 * @public
	 * @param {Number} [speed] - The time in milliseconds for the transition.
	 */
	Owl.prototype.next = function(speed) {
		speed = speed || false;
		this.to(this.relative(this.current()) + 1, speed);
	};

	/**
	 * Slides to the previous item.
	 * @public
	 * @param {Number} [speed] - The time in milliseconds for the transition.
	 */
	Owl.prototype.prev = function(speed) {
		speed = speed || false;
		this.to(this.relative(this.current()) - 1, speed);
	};

	/**
	 * Handles the end of an animation.
	 * @protected
	 * @param {Event} event - The event arguments.
	 */
	Owl.prototype.onTransitionEnd = function(event) {

		// if css2 animation then event object is undefined
		if (event !== undefined) {
			event.stopPropagation();

			// Catch only owl-stage transitionEnd event
			if ((event.target || event.srcElement || event.originalTarget) !== this.$stage.get(0)) {
				return false;
			}
		}

		this.leave('animating');
		this.trigger('translated');
	};

	/**
	 * Gets viewport width.
	 * @protected
	 * @return {Number} - The width in pixel.
	 */
	Owl.prototype.viewport = function() {
		var width;
		if (this.options.responsiveBaseElement !== window) {
			width = $(this.options.responsiveBaseElement).width();
		} else if (window.innerWidth) {
			width = window.innerWidth;
		} else if (document.documentElement && document.documentElement.clientWidth) {
			width = document.documentElement.clientWidth;
		} else {
			console.warn('Can not detect viewport width.');
		}
		return width;
	};

	/**
	 * Replaces the current content.
	 * @public
	 * @param {HTMLElement|jQuery|String} content - The new content.
	 */
	Owl.prototype.replace = function(content) {
		this.$stage.empty();
		this._items = [];

		if (content) {
			content = (content instanceof jQuery) ? content : $(content);
		}

		if (this.settings.nestedItemSelector) {
			content = content.find('.' + this.settings.nestedItemSelector);
		}

		content.filter(function() {
			return this.nodeType === 1;
		}).each($.proxy(function(index, item) {
			item = this.prepare(item);
			this.$stage.append(item);
			this._items.push(item);
			this._mergers.push(item.find('[data-merge]').addBack('[data-merge]').attr('data-merge') * 1 || 1);
		}, this));

		this.reset(this.isNumeric(this.settings.startPosition) ? this.settings.startPosition : 0);

		this.invalidate('items');
	};

	/**
	 * Adds an item.
	 * @todo Use `item` instead of `content` for the event arguments.
	 * @public
	 * @param {HTMLElement|jQuery|String} content - The item content to add.
	 * @param {Number} [position] - The relative position at which to insert the item otherwise the item will be added to the end.
	 */
	Owl.prototype.add = function(content, position) {
		var current = this.relative(this._current);

		position = position === undefined ? this._items.length : this.normalize(position, true);
		content = content instanceof jQuery ? content : $(content);

		this.trigger('add', { content: content, position: position });

		content = this.prepare(content);

		if (this._items.length === 0 || position === this._items.length) {
			this._items.length === 0 && this.$stage.append(content);
			this._items.length !== 0 && this._items[position - 1].after(content);
			this._items.push(content);
			this._mergers.push(content.find('[data-merge]').addBack('[data-merge]').attr('data-merge') * 1 || 1);
		} else {
			this._items[position].before(content);
			this._items.splice(position, 0, content);
			this._mergers.splice(position, 0, content.find('[data-merge]').addBack('[data-merge]').attr('data-merge') * 1 || 1);
		}

		this._items[current] && this.reset(this._items[current].index());

		this.invalidate('items');

		this.trigger('added', { content: content, position: position });
	};

	/**
	 * Removes an item by its position.
	 * @todo Use `item` instead of `content` for the event arguments.
	 * @public
	 * @param {Number} position - The relative position of the item to remove.
	 */
	Owl.prototype.remove = function(position) {
		position = this.normalize(position, true);

		if (position === undefined) {
			return;
		}

		this.trigger('remove', { content: this._items[position], position: position });

		this._items[position].remove();
		this._items.splice(position, 1);
		this._mergers.splice(position, 1);

		this.invalidate('items');

		this.trigger('removed', { content: null, position: position });
	};

	/**
	 * Preloads images with auto width.
	 * @todo Replace by a more generic approach
	 * @protected
	 */
	Owl.prototype.preloadAutoWidthImages = function(images) {
		images.each($.proxy(function(i, element) {
			this.enter('pre-loading');
			element = $(element);
			$(new Image()).one('load', $.proxy(function(e) {
				element.attr('src', e.target.src);
				element.css('opacity', 1);
				this.leave('pre-loading');
				!this.is('pre-loading') && !this.is('initializing') && this.refresh();
			}, this)).attr('src', element.attr('src') || element.attr('data-src') || element.attr('data-src-retina'));
		}, this));
	};

	/**
	 * Destroys the carousel.
	 * @public
	 */
	Owl.prototype.destroy = function() {

		this.$element.off('.owl.core');
		this.$stage.off('.owl.core');
		$(document).off('.owl.core');

		if (this.settings.responsive !== false) {
			window.clearTimeout(this.resizeTimer);
			this.off(window, 'resize', this._handlers.onThrottledResize);
		}

		for (var i in this._plugins) {
			this._plugins[i].destroy();
		}

		this.$stage.children('.cloned').remove();

		this.$stage.unwrap();
		this.$stage.children().contents().unwrap();
		this.$stage.children().unwrap();
		this.$stage.remove();
		this.$element
			.removeClass(this.options.refreshClass)
			.removeClass(this.options.loadingClass)
			.removeClass(this.options.loadedClass)
			.removeClass(this.options.rtlClass)
			.removeClass(this.options.dragClass)
			.removeClass(this.options.grabClass)
			.attr('class', this.$element.attr('class').replace(new RegExp(this.options.responsiveClass + '-\\S+\\s', 'g'), ''))
			.removeData('owl.carousel');
	};

	/**
	 * Operators to calculate right-to-left and left-to-right.
	 * @protected
	 * @param {Number} [a] - The left side operand.
	 * @param {String} [o] - The operator.
	 * @param {Number} [b] - The right side operand.
	 */
	Owl.prototype.op = function(a, o, b) {
		var rtl = this.settings.rtl;
		switch (o) {
			case '<':
				return rtl ? a > b : a < b;
			case '>':
				return rtl ? a < b : a > b;
			case '>=':
				return rtl ? a <= b : a >= b;
			case '<=':
				return rtl ? a >= b : a <= b;
			default:
				break;
		}
	};

	/**
	 * Attaches to an internal event.
	 * @protected
	 * @param {HTMLElement} element - The event source.
	 * @param {String} event - The event name.
	 * @param {Function} listener - The event handler to attach.
	 * @param {Boolean} capture - Wether the event should be handled at the capturing phase or not.
	 */
	Owl.prototype.on = function(element, event, listener, capture) {
		if (element.addEventListener) {
			element.addEventListener(event, listener, capture);
		} else if (element.attachEvent) {
			element.attachEvent('on' + event, listener);
		}
	};

	/**
	 * Detaches from an internal event.
	 * @protected
	 * @param {HTMLElement} element - The event source.
	 * @param {String} event - The event name.
	 * @param {Function} listener - The attached event handler to detach.
	 * @param {Boolean} capture - Wether the attached event handler was registered as a capturing listener or not.
	 */
	Owl.prototype.off = function(element, event, listener, capture) {
		if (element.removeEventListener) {
			element.removeEventListener(event, listener, capture);
		} else if (element.detachEvent) {
			element.detachEvent('on' + event, listener);
		}
	};

	/**
	 * Triggers a public event.
	 * @todo Remove `status`, `relatedTarget` should be used instead.
	 * @protected
	 * @param {String} name - The event name.
	 * @param {*} [data=null] - The event data.
	 * @param {String} [namespace=carousel] - The event namespace.
	 * @param {String} [state] - The state which is associated with the event.
	 * @param {Boolean} [enter=false] - Indicates if the call enters the specified state or not.
	 * @returns {Event} - The event arguments.
	 */
	Owl.prototype.trigger = function(name, data, namespace, state, enter) {
		var status = {
			item: { count: this._items.length, index: this.current() }
		}, handler = $.camelCase(
			$.grep([ 'on', name, namespace ], function(v) { return v })
				.join('-').toLowerCase()
		), event = $.Event(
			[ name, 'owl', namespace || 'carousel' ].join('.').toLowerCase(),
			$.extend({ relatedTarget: this }, status, data)
		);

		if (!this._supress[name]) {
			$.each(this._plugins, function(name, plugin) {
				if (plugin.onTrigger) {
					plugin.onTrigger(event);
				}
			});

			this.register({ type: Owl.Type.Event, name: name });
			this.$element.trigger(event);

			if (this.settings && typeof this.settings[handler] === 'function') {
				this.settings[handler].call(this, event);
			}
		}

		return event;
	};

	/**
	 * Enters a state.
	 * @param name - The state name.
	 */
	Owl.prototype.enter = function(name) {
		$.each([ name ].concat(this._states.tags[name] || []), $.proxy(function(i, name) {
			if (this._states.current[name] === undefined) {
				this._states.current[name] = 0;
			}

			this._states.current[name]++;
		}, this));
	};

	/**
	 * Leaves a state.
	 * @param name - The state name.
	 */
	Owl.prototype.leave = function(name) {
		$.each([ name ].concat(this._states.tags[name] || []), $.proxy(function(i, name) {
			this._states.current[name]--;
		}, this));
	};

	/**
	 * Registers an event or state.
	 * @public
	 * @param {Object} object - The event or state to register.
	 */
	Owl.prototype.register = function(object) {
		if (object.type === Owl.Type.Event) {
			if (!$.event.special[object.name]) {
				$.event.special[object.name] = {};
			}

			if (!$.event.special[object.name].owl) {
				var _default = $.event.special[object.name]._default;
				$.event.special[object.name]._default = function(e) {
					if (_default && _default.apply && (!e.namespace || e.namespace.indexOf('owl') === -1)) {
						return _default.apply(this, arguments);
					}
					return e.namespace && e.namespace.indexOf('owl') > -1;
				};
				$.event.special[object.name].owl = true;
			}
		} else if (object.type === Owl.Type.State) {
			if (!this._states.tags[object.name]) {
				this._states.tags[object.name] = object.tags;
			} else {
				this._states.tags[object.name] = this._states.tags[object.name].concat(object.tags);
			}

			this._states.tags[object.name] = $.grep(this._states.tags[object.name], $.proxy(function(tag, i) {
				return $.inArray(tag, this._states.tags[object.name]) === i;
			}, this));
		}
	};

	/**
	 * Suppresses events.
	 * @protected
	 * @param {Array.<String>} events - The events to suppress.
	 */
	Owl.prototype.suppress = function(events) {
		$.each(events, $.proxy(function(index, event) {
			this._supress[event] = true;
		}, this));
	};

	/**
	 * Releases suppressed events.
	 * @protected
	 * @param {Array.<String>} events - The events to release.
	 */
	Owl.prototype.release = function(events) {
		$.each(events, $.proxy(function(index, event) {
			delete this._supress[event];
		}, this));
	};

	/**
	 * Gets unified pointer coordinates from event.
	 * @todo #261
	 * @protected
	 * @param {Event} - The `mousedown` or `touchstart` event.
	 * @returns {Object} - Contains `x` and `y` coordinates of current pointer position.
	 */
	Owl.prototype.pointer = function(event) {
		var result = { x: null, y: null };

		event = event.originalEvent || event || window.event;

		event = event.touches && event.touches.length ?
			event.touches[0] : event.changedTouches && event.changedTouches.length ?
				event.changedTouches[0] : event;

		if (event.pageX) {
			result.x = event.pageX;
			result.y = event.pageY;
		} else {
			result.x = event.clientX;
			result.y = event.clientY;
		}

		return result;
	};

	/**
	 * Determines if the input is a Number or something that can be coerced to a Number
	 * @protected
	 * @param {Number|String|Object|Array|Boolean|RegExp|Function|Symbol} - The input to be tested
	 * @returns {Boolean} - An indication if the input is a Number or can be coerced to a Number
	 */
	Owl.prototype.isNumeric = function(number) {
		return !isNaN(parseFloat(number));
	};

	/**
	 * Gets the difference of two vectors.
	 * @todo #261
	 * @protected
	 * @param {Object} - The first vector.
	 * @param {Object} - The second vector.
	 * @returns {Object} - The difference.
	 */
	Owl.prototype.difference = function(first, second) {
		return {
			x: first.x - second.x,
			y: first.y - second.y
		};
	};

	/**
	 * The jQuery Plugin for the Owl Carousel
	 * @todo Navigation plugin `next` and `prev`
	 * @public
	 */
	$.fn.owlCarousel = function(option) {
		var args = Array.prototype.slice.call(arguments, 1);

		return this.each(function() {
			var $this = $(this),
				data = $this.data('owl.carousel');

			if (!data) {
				data = new Owl(this, typeof option == 'object' && option);
				$this.data('owl.carousel', data);

				$.each([
					'next', 'prev', 'to', 'destroy', 'refresh', 'replace', 'add', 'remove'
				], function(i, event) {
					data.register({ type: Owl.Type.Event, name: event });
					data.$element.on(event + '.owl.carousel.core', $.proxy(function(e) {
						if (e.namespace && e.relatedTarget !== this) {
							this.suppress([ event ]);
							data[event].apply(this, [].slice.call(arguments, 1));
							this.release([ event ]);
						}
					}, data));
				});
			}

			if (typeof option == 'string' && option.charAt(0) !== '_') {
				data[option].apply(data, args);
			}
		});
	};

	/**
	 * The constructor for the jQuery Plugin
	 * @public
	 */
	$.fn.owlCarousel.Constructor = Owl;

})(window.Zepto || window.jQuery, window, document);

/**
 * AutoRefresh Plugin
 * @version 2.3.4
 * @author Artus Kolanowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	/**
	 * Creates the auto refresh plugin.
	 * @class The Auto Refresh Plugin
	 * @param {Owl} carousel - The Owl Carousel
	 */
	var AutoRefresh = function(carousel) {
		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl}
		 */
		this._core = carousel;

		/**
		 * Refresh interval.
		 * @protected
		 * @type {number}
		 */
		this._interval = null;

		/**
		 * Whether the element is currently visible or not.
		 * @protected
		 * @type {Boolean}
		 */
		this._visible = null;

		/**
		 * All event handlers.
		 * @protected
		 * @type {Object}
		 */
		this._handlers = {
			'initialized.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.autoRefresh) {
					this.watch();
				}
			}, this)
		};

		// set default options
		this._core.options = $.extend({}, AutoRefresh.Defaults, this._core.options);

		// register event handlers
		this._core.$element.on(this._handlers);
	};

	/**
	 * Default options.
	 * @public
	 */
	AutoRefresh.Defaults = {
		autoRefresh: true,
		autoRefreshInterval: 500
	};

	/**
	 * Watches the element.
	 */
	AutoRefresh.prototype.watch = function() {
		if (this._interval) {
			return;
		}

		this._visible = this._core.isVisible();
		this._interval = window.setInterval($.proxy(this.refresh, this), this._core.settings.autoRefreshInterval);
	};

	/**
	 * Refreshes the element.
	 */
	AutoRefresh.prototype.refresh = function() {
		if (this._core.isVisible() === this._visible) {
			return;
		}

		this._visible = !this._visible;

		this._core.$element.toggleClass('owl-hidden', !this._visible);

		this._visible && (this._core.invalidate('width') && this._core.refresh());
	};

	/**
	 * Destroys the plugin.
	 */
	AutoRefresh.prototype.destroy = function() {
		var handler, property;

		window.clearInterval(this._interval);

		for (handler in this._handlers) {
			this._core.$element.off(handler, this._handlers[handler]);
		}
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		}
	};

	$.fn.owlCarousel.Constructor.Plugins.AutoRefresh = AutoRefresh;

})(window.Zepto || window.jQuery, window, document);

/**
 * Lazy Plugin
 * @version 2.3.4
 * @author Bartosz Wojciechowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	/**
	 * Creates the lazy plugin.
	 * @class The Lazy Plugin
	 * @param {Owl} carousel - The Owl Carousel
	 */
	var Lazy = function(carousel) {

		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl}
		 */
		this._core = carousel;

		/**
		 * Already loaded items.
		 * @protected
		 * @type {Array.<jQuery>}
		 */
		this._loaded = [];

		/**
		 * Event handlers.
		 * @protected
		 * @type {Object}
		 */
		this._handlers = {
			'initialized.owl.carousel change.owl.carousel resized.owl.carousel': $.proxy(function(e) {
				if (!e.namespace) {
					return;
				}

				if (!this._core.settings || !this._core.settings.lazyLoad) {
					return;
				}

				if ((e.property && e.property.name == 'position') || e.type == 'initialized') {
					var settings = this._core.settings,
						n = (settings.center && Math.ceil(settings.items / 2) || settings.items),
						i = ((settings.center && n * -1) || 0),
						position = (e.property && e.property.value !== undefined ? e.property.value : this._core.current()) + i,
						clones = this._core.clones().length,
						load = $.proxy(function(i, v) { this.load(v) }, this);
					//TODO: Need documentation for this new option
					if (settings.lazyLoadEager > 0) {
						n += settings.lazyLoadEager;
						// If the carousel is looping also preload images that are to the "left"
						if (settings.loop) {
              position -= settings.lazyLoadEager;
              n++;
            }
					}

					while (i++ < n) {
						this.load(clones / 2 + this._core.relative(position));
						clones && $.each(this._core.clones(this._core.relative(position)), load);
						position++;
					}
				}
			}, this)
		};

		// set the default options
		this._core.options = $.extend({}, Lazy.Defaults, this._core.options);

		// register event handler
		this._core.$element.on(this._handlers);
	};

	/**
	 * Default options.
	 * @public
	 */
	Lazy.Defaults = {
		lazyLoad: false,
		lazyLoadEager: 0
	};

	/**
	 * Loads all resources of an item at the specified position.
	 * @param {Number} position - The absolute position of the item.
	 * @protected
	 */
	Lazy.prototype.load = function(position) {
		var $item = this._core.$stage.children().eq(position),
			$elements = $item && $item.find('.owl-lazy');

		if (!$elements || $.inArray($item.get(0), this._loaded) > -1) {
			return;
		}

		$elements.each($.proxy(function(index, element) {
			var $element = $(element), image,
                url = (window.devicePixelRatio > 1 && $element.attr('data-src-retina')) || $element.attr('data-src') || $element.attr('data-srcset');

			this._core.trigger('load', { element: $element, url: url }, 'lazy');

			if ($element.is('img')) {
				$element.one('load.owl.lazy', $.proxy(function() {
					$element.css('opacity', 1);
					this._core.trigger('loaded', { element: $element, url: url }, 'lazy');
				}, this)).attr('src', url);
            } else if ($element.is('source')) {
                $element.one('load.owl.lazy', $.proxy(function() {
                    this._core.trigger('loaded', { element: $element, url: url }, 'lazy');
                }, this)).attr('srcset', url);
			} else {
				image = new Image();
				image.onload = $.proxy(function() {
					$element.css({
						'background-image': 'url("' + url + '")',
						'opacity': '1'
					});
					this._core.trigger('loaded', { element: $element, url: url }, 'lazy');
				}, this);
				image.src = url;
			}
		}, this));

		this._loaded.push($item.get(0));
	};

	/**
	 * Destroys the plugin.
	 * @public
	 */
	Lazy.prototype.destroy = function() {
		var handler, property;

		for (handler in this.handlers) {
			this._core.$element.off(handler, this.handlers[handler]);
		}
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		}
	};

	$.fn.owlCarousel.Constructor.Plugins.Lazy = Lazy;

})(window.Zepto || window.jQuery, window, document);

/**
 * AutoHeight Plugin
 * @version 2.3.4
 * @author Bartosz Wojciechowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	/**
	 * Creates the auto height plugin.
	 * @class The Auto Height Plugin
	 * @param {Owl} carousel - The Owl Carousel
	 */
	var AutoHeight = function(carousel) {
		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl}
		 */
		this._core = carousel;

		this._previousHeight = null;

		/**
		 * All event handlers.
		 * @protected
		 * @type {Object}
		 */
		this._handlers = {
			'initialized.owl.carousel refreshed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.autoHeight) {
					this.update();
				}
			}, this),
			'changed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.autoHeight && e.property.name === 'position'){
					this.update();
				}
			}, this),
			'loaded.owl.lazy': $.proxy(function(e) {
				if (e.namespace && this._core.settings.autoHeight
					&& e.element.closest('.' + this._core.settings.itemClass).index() === this._core.current()) {
					this.update();
				}
			}, this)
		};

		// set default options
		this._core.options = $.extend({}, AutoHeight.Defaults, this._core.options);

		// register event handlers
		this._core.$element.on(this._handlers);
		this._intervalId = null;
		var refThis = this;

		// These changes have been taken from a PR by gavrochelegnou proposed in #1575
		// and have been made compatible with the latest jQuery version
		$(window).on('load', function() {
			if (refThis._core.settings.autoHeight) {
				refThis.update();
			}
		});

		// Autoresize the height of the carousel when window is resized
		// When carousel has images, the height is dependent on the width
		// and should also change on resize
		$(window).resize(function() {
			if (refThis._core.settings.autoHeight) {
				if (refThis._intervalId != null) {
					clearTimeout(refThis._intervalId);
				}

				refThis._intervalId = setTimeout(function() {
					refThis.update();
				}, 250);
			}
		});

	};

	/**
	 * Default options.
	 * @public
	 */
	AutoHeight.Defaults = {
		autoHeight: false,
		autoHeightClass: 'owl-height'
	};

	/**
	 * Updates the view.
	 */
	AutoHeight.prototype.update = function() {
		var start = this._core._current,
			end = start + this._core.settings.items,
			lazyLoadEnabled = this._core.settings.lazyLoad,
			visible = this._core.$stage.children().toArray().slice(start, end),
			heights = [],
			maxheight = 0;

		$.each(visible, function(index, item) {
			heights.push($(item).height());
		});

		maxheight = Math.max.apply(null, heights);

		if (maxheight <= 1 && lazyLoadEnabled && this._previousHeight) {
			maxheight = this._previousHeight;
		}

		this._previousHeight = maxheight;

		this._core.$stage.parent()
			.height(maxheight)
			.addClass(this._core.settings.autoHeightClass);
	};

	AutoHeight.prototype.destroy = function() {
		var handler, property;

		for (handler in this._handlers) {
			this._core.$element.off(handler, this._handlers[handler]);
		}
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] !== 'function' && (this[property] = null);
		}
	};

	$.fn.owlCarousel.Constructor.Plugins.AutoHeight = AutoHeight;

})(window.Zepto || window.jQuery, window, document);

/**
 * Video Plugin
 * @version 2.3.4
 * @author Bartosz Wojciechowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	/**
	 * Creates the video plugin.
	 * @class The Video Plugin
	 * @param {Owl} carousel - The Owl Carousel
	 */
	var Video = function(carousel) {
		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl}
		 */
		this._core = carousel;

		/**
		 * Cache all video URLs.
		 * @protected
		 * @type {Object}
		 */
		this._videos = {};

		/**
		 * Current playing item.
		 * @protected
		 * @type {jQuery}
		 */
		this._playing = null;

		/**
		 * All event handlers.
		 * @todo The cloned content removale is too late
		 * @protected
		 * @type {Object}
		 */
		this._handlers = {
			'initialized.owl.carousel': $.proxy(function(e) {
				if (e.namespace) {
					this._core.register({ type: 'state', name: 'playing', tags: [ 'interacting' ] });
				}
			}, this),
			'resize.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.video && this.isInFullScreen()) {
					e.preventDefault();
				}
			}, this),
			'refreshed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.is('resizing')) {
					this._core.$stage.find('.cloned .owl-video-frame').remove();
				}
			}, this),
			'changed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && e.property.name === 'position' && this._playing) {
					this.stop();
				}
			}, this),
			'prepared.owl.carousel': $.proxy(function(e) {
				if (!e.namespace) {
					return;
				}

				var $element = $(e.content).find('.owl-video');

				if ($element.length) {
					$element.css('display', 'none');
					this.fetch($element, $(e.content));
				}
			}, this)
		};

		// set default options
		this._core.options = $.extend({}, Video.Defaults, this._core.options);

		// register event handlers
		this._core.$element.on(this._handlers);

		this._core.$element.on('click.owl.video', '.owl-video-play-icon', $.proxy(function(e) {
			this.play(e);
		}, this));
	};

	/**
	 * Default options.
	 * @public
	 */
	Video.Defaults = {
		video: false,
		videoHeight: false,
		videoWidth: false
	};

	/**
	 * Gets the video ID and the type (YouTube/Vimeo/vzaar only).
	 * @protected
	 * @param {jQuery} target - The target containing the video data.
	 * @param {jQuery} item - The item containing the video.
	 */
	Video.prototype.fetch = function(target, item) {
			var type = (function() {
					if (target.attr('data-vimeo-id')) {
						return 'vimeo';
					} else if (target.attr('data-vzaar-id')) {
						return 'vzaar'
					} else {
						return 'youtube';
					}
				})(),
				id = target.attr('data-vimeo-id') || target.attr('data-youtube-id') || target.attr('data-vzaar-id'),
				width = target.attr('data-width') || this._core.settings.videoWidth,
				height = target.attr('data-height') || this._core.settings.videoHeight,
				url = target.attr('href');

		if (url) {

			/*
					Parses the id's out of the following urls (and probably more):
					https://www.youtube.com/watch?v=:id
					https://youtu.be/:id
					https://vimeo.com/:id
					https://vimeo.com/channels/:channel/:id
					https://vimeo.com/groups/:group/videos/:id
					https://app.vzaar.com/videos/:id

					Visual example: https://regexper.com/#(http%3A%7Chttps%3A%7C)%5C%2F%5C%2F(player.%7Cwww.%7Capp.)%3F(vimeo%5C.com%7Cyoutu(be%5C.com%7C%5C.be%7Cbe%5C.googleapis%5C.com)%7Cvzaar%5C.com)%5C%2F(video%5C%2F%7Cvideos%5C%2F%7Cembed%5C%2F%7Cchannels%5C%2F.%2B%5C%2F%7Cgroups%5C%2F.%2B%5C%2F%7Cwatch%5C%3Fv%3D%7Cv%5C%2F)%3F(%5BA-Za-z0-9._%25-%5D*)(%5C%26%5CS%2B)%3F
			*/

			id = url.match(/(http:|https:|)\/\/(player.|www.|app.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com|be\-nocookie\.com)|vzaar\.com)\/(video\/|videos\/|embed\/|channels\/.+\/|groups\/.+\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/);

			if (id[3].indexOf('youtu') > -1) {
				type = 'youtube';
			} else if (id[3].indexOf('vimeo') > -1) {
				type = 'vimeo';
			} else if (id[3].indexOf('vzaar') > -1) {
				type = 'vzaar';
			} else {
				throw new Error('Video URL not supported.');
			}
			id = id[6];
		} else {
			throw new Error('Missing video URL.');
		}

		this._videos[url] = {
			type: type,
			id: id,
			width: width,
			height: height
		};

		item.attr('data-video', url);

		this.thumbnail(target, this._videos[url]);
	};

	/**
	 * Creates video thumbnail.
	 * @protected
	 * @param {jQuery} target - The target containing the video data.
	 * @param {Object} info - The video info object.
	 * @see `fetch`
	 */
	Video.prototype.thumbnail = function(target, video) {
		var tnLink,
			icon,
			path,
			dimensions = video.width && video.height ? 'width:' + video.width + 'px;height:' + video.height + 'px;' : '',
			customTn = target.find('img'),
			srcType = 'src',
			lazyClass = '',
			settings = this._core.settings,
			create = function(path) {
				icon = '<div class="owl-video-play-icon"></div>';

				if (settings.lazyLoad) {
					tnLink = $('<div/>',{
						"class": 'owl-video-tn ' + lazyClass,
						"srcType": path
					});
				} else {
					tnLink = $( '<div/>', {
						"class": "owl-video-tn",
						"style": 'opacity:1;background-image:url(' + path + ')'
					});
				}
				target.after(tnLink);
				target.after(icon);
			};

		// wrap video content into owl-video-wrapper div
		target.wrap( $( '<div/>', {
			"class": "owl-video-wrapper",
			"style": dimensions
		}));

		if (this._core.settings.lazyLoad) {
			srcType = 'data-src';
			lazyClass = 'owl-lazy';
		}

		// custom thumbnail
		if (customTn.length) {
			create(customTn.attr(srcType));
			customTn.remove();
			return false;
		}

		if (video.type === 'youtube') {
			path = "//img.youtube.com/vi/" + video.id + "/hqdefault.jpg";
			create(path);
		} else if (video.type === 'vimeo') {
			$.ajax({
				type: 'GET',
				url: '//vimeo.com/api/v2/video/' + video.id + '.json',
				jsonp: 'callback',
				dataType: 'jsonp',
				success: function(data) {
					path = data[0].thumbnail_large;
					create(path);
				}
			});
		} else if (video.type === 'vzaar') {
			$.ajax({
				type: 'GET',
				url: '//vzaar.com/api/videos/' + video.id + '.json',
				jsonp: 'callback',
				dataType: 'jsonp',
				success: function(data) {
					path = data.framegrab_url;
					create(path);
				}
			});
		}
	};

	/**
	 * Stops the current video.
	 * @public
	 */
	Video.prototype.stop = function() {
		this._core.trigger('stop', null, 'video');
		this._playing.find('.owl-video-frame').remove();
		this._playing.removeClass('owl-video-playing');
		this._playing = null;
		this._core.leave('playing');
		this._core.trigger('stopped', null, 'video');
	};

	/**
	 * Starts the current video.
	 * @public
	 * @param {Event} event - The event arguments.
	 */
	Video.prototype.play = function(event) {
		var target = $(event.target),
			item = target.closest('.' + this._core.settings.itemClass),
			video = this._videos[item.attr('data-video')],
			width = video.width || '100%',
			height = video.height || this._core.$stage.height(),
			html,
			iframe;

		if (this._playing) {
			return;
		}

		this._core.enter('playing');
		this._core.trigger('play', null, 'video');

		item = this._core.items(this._core.relative(item.index()));

		this._core.reset(item.index());

		html = $( '<iframe frameborder="0" allowfullscreen mozallowfullscreen webkitAllowFullScreen ></iframe>' );
		html.attr( 'height', height );
		html.attr( 'width', width );
		if (video.type === 'youtube') {
			html.attr( 'src', '//www.youtube.com/embed/' + video.id + '?autoplay=1&rel=0&v=' + video.id );
		} else if (video.type === 'vimeo') {
			html.attr( 'src', '//player.vimeo.com/video/' + video.id + '?autoplay=1' );
		} else if (video.type === 'vzaar') {
			html.attr( 'src', '//view.vzaar.com/' + video.id + '/player?autoplay=true' );
		}

		iframe = $(html).wrap( '<div class="owl-video-frame" />' ).insertAfter(item.find('.owl-video'));

		this._playing = item.addClass('owl-video-playing');
	};

	/**
	 * Checks whether an video is currently in full screen mode or not.
	 * @todo Bad style because looks like a readonly method but changes members.
	 * @protected
	 * @returns {Boolean}
	 */
	Video.prototype.isInFullScreen = function() {
		var element = document.fullscreenElement || document.mozFullScreenElement ||
				document.webkitFullscreenElement;

		return element && $(element).parent().hasClass('owl-video-frame');
	};

	/**
	 * Destroys the plugin.
	 */
	Video.prototype.destroy = function() {
		var handler, property;

		this._core.$element.off('click.owl.video');

		for (handler in this._handlers) {
			this._core.$element.off(handler, this._handlers[handler]);
		}
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		}
	};

	$.fn.owlCarousel.Constructor.Plugins.Video = Video;

})(window.Zepto || window.jQuery, window, document);

/**
 * Animate Plugin
 * @version 2.3.4
 * @author Bartosz Wojciechowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	/**
	 * Creates the animate plugin.
	 * @class The Navigation Plugin
	 * @param {Owl} scope - The Owl Carousel
	 */
	var Animate = function(scope) {
		this.core = scope;
		this.core.options = $.extend({}, Animate.Defaults, this.core.options);
		this.swapping = true;
		this.previous = undefined;
		this.next = undefined;

		this.handlers = {
			'change.owl.carousel': $.proxy(function(e) {
				if (e.namespace && e.property.name == 'position') {
					this.previous = this.core.current();
					this.next = e.property.value;
				}
			}, this),
			'drag.owl.carousel dragged.owl.carousel translated.owl.carousel': $.proxy(function(e) {
				if (e.namespace) {
					this.swapping = e.type == 'translated';
				}
			}, this),
			'translate.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this.swapping && (this.core.options.animateOut || this.core.options.animateIn)) {
					this.swap();
				}
			}, this)
		};

		this.core.$element.on(this.handlers);
	};

	/**
	 * Default options.
	 * @public
	 */
	Animate.Defaults = {
		animateOut: false,
		animateIn: false
	};

	/**
	 * Toggles the animation classes whenever an translations starts.
	 * @protected
	 * @returns {Boolean|undefined}
	 */
	Animate.prototype.swap = function() {

		if (this.core.settings.items !== 1) {
			return;
		}

		if (!$.support.animation || !$.support.transition) {
			return;
		}

		this.core.speed(0);

		var left,
			clear = $.proxy(this.clear, this),
			previous = this.core.$stage.children().eq(this.previous),
			next = this.core.$stage.children().eq(this.next),
			incoming = this.core.settings.animateIn,
			outgoing = this.core.settings.animateOut;

		if (this.core.current() === this.previous) {
			return;
		}

		if (outgoing) {
			left = this.core.coordinates(this.previous) - this.core.coordinates(this.next);
			previous.one($.support.animation.end, clear)
				.css( { 'left': left + 'px' } )
				.addClass('animated owl-animated-out')
				.addClass(outgoing);
		}

		if (incoming) {
			next.one($.support.animation.end, clear)
				.addClass('animated owl-animated-in')
				.addClass(incoming);
		}
	};

	Animate.prototype.clear = function(e) {
		$(e.target).css( { 'left': '' } )
			.removeClass('animated owl-animated-out owl-animated-in')
			.removeClass(this.core.settings.animateIn)
			.removeClass(this.core.settings.animateOut);
		this.core.onTransitionEnd();
	};

	/**
	 * Destroys the plugin.
	 * @public
	 */
	Animate.prototype.destroy = function() {
		var handler, property;

		for (handler in this.handlers) {
			this.core.$element.off(handler, this.handlers[handler]);
		}
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		}
	};

	$.fn.owlCarousel.Constructor.Plugins.Animate = Animate;

})(window.Zepto || window.jQuery, window, document);

/**
 * Autoplay Plugin
 * @version 2.3.4
 * @author Bartosz Wojciechowski
 * @author Artus Kolanowski
 * @author David Deutsch
 * @author Tom De Caluwé
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	/**
	 * Creates the autoplay plugin.
	 * @class The Autoplay Plugin
	 * @param {Owl} scope - The Owl Carousel
	 */
	var Autoplay = function(carousel) {
		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl}
		 */
		this._core = carousel;

		/**
		 * The autoplay timeout id.
		 * @type {Number}
		 */
		this._call = null;

		/**
		 * Depending on the state of the plugin, this variable contains either
		 * the start time of the timer or the current timer value if it's
		 * paused. Since we start in a paused state we initialize the timer
		 * value.
		 * @type {Number}
		 */
		this._time = 0;

		/**
		 * Stores the timeout currently used.
		 * @type {Number}
		 */
		this._timeout = 0;

		/**
		 * Indicates whenever the autoplay is paused.
		 * @type {Boolean}
		 */
		this._paused = true;

		/**
		 * All event handlers.
		 * @protected
		 * @type {Object}
		 */
		this._handlers = {
			'changed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && e.property.name === 'settings') {
					if (this._core.settings.autoplay) {
						this.play();
					} else {
						this.stop();
					}
				} else if (e.namespace && e.property.name === 'position' && this._paused) {
					// Reset the timer. This code is triggered when the position
					// of the carousel was changed through user interaction.
					this._time = 0;
				}
			}, this),
			'initialized.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.autoplay) {
					this.play();
				}
			}, this),
			'play.owl.autoplay': $.proxy(function(e, t, s) {
				if (e.namespace) {
					this.play(t, s);
				}
			}, this),
			'stop.owl.autoplay': $.proxy(function(e) {
				if (e.namespace) {
					this.stop();
				}
			}, this),
			'mouseover.owl.autoplay': $.proxy(function() {
				if (this._core.settings.autoplayHoverPause && this._core.is('rotating')) {
					this.pause();
				}
			}, this),
			'mouseleave.owl.autoplay': $.proxy(function() {
				if (this._core.settings.autoplayHoverPause && this._core.is('rotating')) {
					this.play();
				}
			}, this),
			'touchstart.owl.core': $.proxy(function() {
				if (this._core.settings.autoplayHoverPause && this._core.is('rotating')) {
					this.pause();
				}
			}, this),
			'touchend.owl.core': $.proxy(function() {
				if (this._core.settings.autoplayHoverPause) {
					this.play();
				}
			}, this)
		};

		// register event handlers
		this._core.$element.on(this._handlers);

		// set default options
		this._core.options = $.extend({}, Autoplay.Defaults, this._core.options);
	};

	/**
	 * Default options.
	 * @public
	 */
	Autoplay.Defaults = {
		autoplay: false,
		autoplayTimeout: 5000,
		autoplayHoverPause: false,
		autoplaySpeed: false
	};

	/**
	 * Transition to the next slide and set a timeout for the next transition.
	 * @private
	 * @param {Number} [speed] - The animation speed for the animations.
	 */
	Autoplay.prototype._next = function(speed) {
		this._call = window.setTimeout(
			$.proxy(this._next, this, speed),
			this._timeout * (Math.round(this.read() / this._timeout) + 1) - this.read()
		);

		if (this._core.is('interacting') || document.hidden) {
			return;
		}
		this._core.next(speed || this._core.settings.autoplaySpeed);
	}

	/**
	 * Reads the current timer value when the timer is playing.
	 * @public
	 */
	Autoplay.prototype.read = function() {
		return new Date().getTime() - this._time;
	};

	/**
	 * Starts the autoplay.
	 * @public
	 * @param {Number} [timeout] - The interval before the next animation starts.
	 * @param {Number} [speed] - The animation speed for the animations.
	 */
	Autoplay.prototype.play = function(timeout, speed) {
		var elapsed;

		if (!this._core.is('rotating')) {
			this._core.enter('rotating');
		}

		timeout = timeout || this._core.settings.autoplayTimeout;

		// Calculate the elapsed time since the last transition. If the carousel
		// wasn't playing this calculation will yield zero.
		elapsed = Math.min(this._time % (this._timeout || timeout), timeout);

		if (this._paused) {
			// Start the clock.
			this._time = this.read();
			this._paused = false;
		} else {
			// Clear the active timeout to allow replacement.
			window.clearTimeout(this._call);
		}

		// Adjust the origin of the timer to match the new timeout value.
		this._time += this.read() % timeout - elapsed;

		this._timeout = timeout;
		this._call = window.setTimeout($.proxy(this._next, this, speed), timeout - elapsed);
	};

	/**
	 * Stops the autoplay.
	 * @public
	 */
	Autoplay.prototype.stop = function() {
		if (this._core.is('rotating')) {
			// Reset the clock.
			this._time = 0;
			this._paused = true;

			window.clearTimeout(this._call);
			this._core.leave('rotating');
		}
	};

	/**
	 * Pauses the autoplay.
	 * @public
	 */
	Autoplay.prototype.pause = function() {
		if (this._core.is('rotating') && !this._paused) {
			// Pause the clock.
			this._time = this.read();
			this._paused = true;

			window.clearTimeout(this._call);
		}
	};

	/**
	 * Destroys the plugin.
	 */
	Autoplay.prototype.destroy = function() {
		var handler, property;

		this.stop();

		for (handler in this._handlers) {
			this._core.$element.off(handler, this._handlers[handler]);
		}
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		}
	};

	$.fn.owlCarousel.Constructor.Plugins.autoplay = Autoplay;

})(window.Zepto || window.jQuery, window, document);

/**
 * Navigation Plugin
 * @version 2.3.4
 * @author Artus Kolanowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {
	'use strict';

	/**
	 * Creates the navigation plugin.
	 * @class The Navigation Plugin
	 * @param {Owl} carousel - The Owl Carousel.
	 */
	var Navigation = function(carousel) {
		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl}
		 */
		this._core = carousel;

		/**
		 * Indicates whether the plugin is initialized or not.
		 * @protected
		 * @type {Boolean}
		 */
		this._initialized = false;

		/**
		 * The current paging indexes.
		 * @protected
		 * @type {Array}
		 */
		this._pages = [];

		/**
		 * All DOM elements of the user interface.
		 * @protected
		 * @type {Object}
		 */
		this._controls = {};

		/**
		 * Markup for an indicator.
		 * @protected
		 * @type {Array.<String>}
		 */
		this._templates = [];

		/**
		 * The carousel element.
		 * @type {jQuery}
		 */
		this.$element = this._core.$element;

		/**
		 * Overridden methods of the carousel.
		 * @protected
		 * @type {Object}
		 */
		this._overrides = {
			next: this._core.next,
			prev: this._core.prev,
			to: this._core.to
		};

		/**
		 * All event handlers.
		 * @protected
		 * @type {Object}
		 */
		this._handlers = {
			'prepared.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.dotsData) {
					this._templates.push('<div class="' + this._core.settings.dotClass + '">' +
						$(e.content).find('[data-dot]').addBack('[data-dot]').attr('data-dot') + '</div>');
				}
			}, this),
			'added.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.dotsData) {
					this._templates.splice(e.position, 0, this._templates.pop());
				}
			}, this),
			'remove.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.dotsData) {
					this._templates.splice(e.position, 1);
				}
			}, this),
			'changed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && e.property.name == 'position') {
					this.draw();
				}
			}, this),
			'initialized.owl.carousel': $.proxy(function(e) {
				if (e.namespace && !this._initialized) {
					this._core.trigger('initialize', null, 'navigation');
					this.initialize();
					this.update();
					this.draw();
					this._initialized = true;
					this._core.trigger('initialized', null, 'navigation');
				}
			}, this),
			'refreshed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._initialized) {
					this._core.trigger('refresh', null, 'navigation');
					this.update();
					this.draw();
					this._core.trigger('refreshed', null, 'navigation');
				}
			}, this)
		};

		// set default options
		this._core.options = $.extend({}, Navigation.Defaults, this._core.options);

		// register event handlers
		this.$element.on(this._handlers);
	};

	/**
	 * Default options.
	 * @public
	 * @todo Rename `slideBy` to `navBy`
	 */
	Navigation.Defaults = {
		nav: false,
		navText: [
			'<span aria-label="' + 'Previous' + '">&#x2039;</span>',
			'<span aria-label="' + 'Next' + '">&#x203a;</span>'
		],
		navSpeed: false,
		navElement: 'button type="button" role="presentation"',
		navContainer: false,
		navContainerClass: 'owl-nav',
		navClass: [
			'owl-prev',
			'owl-next'
		],
		slideBy: 1,
		dotClass: 'owl-dot',
		dotsClass: 'owl-dots',
		dots: true,
		dotsEach: false,
		dotsData: false,
		dotsSpeed: false,
		dotsContainer: false
	};

	/**
	 * Initializes the layout of the plugin and extends the carousel.
	 * @protected
	 */
	Navigation.prototype.initialize = function() {
		var override,
			settings = this._core.settings;

		// create DOM structure for relative navigation
		this._controls.$relative = (settings.navContainer ? $(settings.navContainer)
			: $('<div>').addClass(settings.navContainerClass).appendTo(this.$element)).addClass('disabled');

		this._controls.$previous = $('<' + settings.navElement + '>')
			.addClass(settings.navClass[0])
			.html(settings.navText[0])
			.prependTo(this._controls.$relative)
			.on('click', $.proxy(function(e) {
				this.prev(settings.navSpeed);
			}, this));
		this._controls.$next = $('<' + settings.navElement + '>')
			.addClass(settings.navClass[1])
			.html(settings.navText[1])
			.appendTo(this._controls.$relative)
			.on('click', $.proxy(function(e) {
				this.next(settings.navSpeed);
			}, this));

		// create DOM structure for absolute navigation
		if (!settings.dotsData) {
			this._templates = [ $('<button role="button">')
				.addClass(settings.dotClass)
				.append($('<span>'))
				.prop('outerHTML') ];
		}

		this._controls.$absolute = (settings.dotsContainer ? $(settings.dotsContainer)
			: $('<div>').addClass(settings.dotsClass).appendTo(this.$element)).addClass('disabled');

		this._controls.$absolute.on('click', 'button', $.proxy(function(e) {
			var index = $(e.target).parent().is(this._controls.$absolute)
				? $(e.target).index() : $(e.target).parent().index();

			e.preventDefault();

			this.to(index, settings.dotsSpeed);
		}, this));

		/*$el.on('focusin', function() {
			$(document).off(".carousel");

			$(document).on('keydown.carousel', function(e) {
				if(e.keyCode == 37) {
					$el.trigger('prev.owl')
				}
				if(e.keyCode == 39) {
					$el.trigger('next.owl')
				}
			});
		});*/

		// override public methods of the carousel
		for (override in this._overrides) {
			this._core[override] = $.proxy(this[override], this);
		}
	};

	/**
	 * Destroys the plugin.
	 * @protected
	 */
	Navigation.prototype.destroy = function() {
		var handler, control, property, override, settings;
		settings = this._core.settings;

		for (handler in this._handlers) {
			this.$element.off(handler, this._handlers[handler]);
		}
		for (control in this._controls) {
			if (control === '$relative' && settings.navContainer) {
				this._controls[control].html('');
			} else {
				this._controls[control].remove();
			}
		}
		for (override in this.overides) {
			this._core[override] = this._overrides[override];
		}
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		}
	};

	/**
	 * Updates the internal state.
	 * @protected
	 */
	Navigation.prototype.update = function() {
		var i, j, k,
			lower = this._core.clones().length / 2,
			upper = lower + this._core.items().length,
			maximum = this._core.maximum(true),
			settings = this._core.settings,
			size = settings.center || settings.autoWidth || settings.dotsData
				? 1 : settings.dotsEach || settings.items;

		if (settings.slideBy !== 'page') {
			settings.slideBy = Math.min(settings.slideBy, settings.items);
		}

		if (settings.dots || settings.slideBy == 'page') {
			this._pages = [];

			for (i = lower, j = 0, k = 0; i < upper; i++) {
				if (j >= size || j === 0) {
					this._pages.push({
						start: Math.min(maximum, i - lower),
						end: i - lower + size - 1
					});
					if (Math.min(maximum, i - lower) === maximum) {
						break;
					}
					j = 0, ++k;
				}
				j += this._core.mergers(this._core.relative(i));
			}
		}
	};

	/**
	 * Draws the user interface.
	 * @todo The option `dotsData` wont work.
	 * @protected
	 */
	Navigation.prototype.draw = function() {
		var difference,
			settings = this._core.settings,
			disabled = this._core.items().length <= settings.items,
			index = this._core.relative(this._core.current()),
			loop = settings.loop || settings.rewind;

		this._controls.$relative.toggleClass('disabled', !settings.nav || disabled);

		if (settings.nav) {
			this._controls.$previous.toggleClass('disabled', !loop && index <= this._core.minimum(true));
			this._controls.$next.toggleClass('disabled', !loop && index >= this._core.maximum(true));
		}

		this._controls.$absolute.toggleClass('disabled', !settings.dots || disabled);

		if (settings.dots) {
			difference = this._pages.length - this._controls.$absolute.children().length;

			if (settings.dotsData && difference !== 0) {
				this._controls.$absolute.html(this._templates.join(''));
			} else if (difference > 0) {
				this._controls.$absolute.append(new Array(difference + 1).join(this._templates[0]));
			} else if (difference < 0) {
				this._controls.$absolute.children().slice(difference).remove();
			}

			this._controls.$absolute.find('.active').removeClass('active');
			this._controls.$absolute.children().eq($.inArray(this.current(), this._pages)).addClass('active');
		}
	};

	/**
	 * Extends event data.
	 * @protected
	 * @param {Event} event - The event object which gets thrown.
	 */
	Navigation.prototype.onTrigger = function(event) {
		var settings = this._core.settings;

		event.page = {
			index: $.inArray(this.current(), this._pages),
			count: this._pages.length,
			size: settings && (settings.center || settings.autoWidth || settings.dotsData
				? 1 : settings.dotsEach || settings.items)
		};
	};

	/**
	 * Gets the current page position of the carousel.
	 * @protected
	 * @returns {Number}
	 */
	Navigation.prototype.current = function() {
		var current = this._core.relative(this._core.current());
		return $.grep(this._pages, $.proxy(function(page, index) {
			return page.start <= current && page.end >= current;
		}, this)).pop();
	};

	/**
	 * Gets the current succesor/predecessor position.
	 * @protected
	 * @returns {Number}
	 */
	Navigation.prototype.getPosition = function(successor) {
		var position, length,
			settings = this._core.settings;

		if (settings.slideBy == 'page') {
			position = $.inArray(this.current(), this._pages);
			length = this._pages.length;
			successor ? ++position : --position;
			position = this._pages[((position % length) + length) % length].start;
		} else {
			position = this._core.relative(this._core.current());
			length = this._core.items().length;
			successor ? position += settings.slideBy : position -= settings.slideBy;
		}

		return position;
	};

	/**
	 * Slides to the next item or page.
	 * @public
	 * @param {Number} [speed=false] - The time in milliseconds for the transition.
	 */
	Navigation.prototype.next = function(speed) {
		$.proxy(this._overrides.to, this._core)(this.getPosition(true), speed);
	};

	/**
	 * Slides to the previous item or page.
	 * @public
	 * @param {Number} [speed=false] - The time in milliseconds for the transition.
	 */
	Navigation.prototype.prev = function(speed) {
		$.proxy(this._overrides.to, this._core)(this.getPosition(false), speed);
	};

	/**
	 * Slides to the specified item or page.
	 * @public
	 * @param {Number} position - The position of the item or page.
	 * @param {Number} [speed] - The time in milliseconds for the transition.
	 * @param {Boolean} [standard=false] - Whether to use the standard behaviour or not.
	 */
	Navigation.prototype.to = function(position, speed, standard) {
		var length;

		if (!standard && this._pages.length) {
			length = this._pages.length;
			$.proxy(this._overrides.to, this._core)(this._pages[((position % length) + length) % length].start, speed);
		} else {
			$.proxy(this._overrides.to, this._core)(position, speed);
		}
	};

	$.fn.owlCarousel.Constructor.Plugins.Navigation = Navigation;

})(window.Zepto || window.jQuery, window, document);

/**
 * Hash Plugin
 * @version 2.3.4
 * @author Artus Kolanowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {
	'use strict';

	/**
	 * Creates the hash plugin.
	 * @class The Hash Plugin
	 * @param {Owl} carousel - The Owl Carousel
	 */
	var Hash = function(carousel) {
		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl}
		 */
		this._core = carousel;

		/**
		 * Hash index for the items.
		 * @protected
		 * @type {Object}
		 */
		this._hashes = {};

		/**
		 * The carousel element.
		 * @type {jQuery}
		 */
		this.$element = this._core.$element;

		/**
		 * All event handlers.
		 * @protected
		 * @type {Object}
		 */
		this._handlers = {
			'initialized.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.startPosition === 'URLHash') {
					$(window).trigger('hashchange.owl.navigation');
				}
			}, this),
			'prepared.owl.carousel': $.proxy(function(e) {
				if (e.namespace) {
					var hash = $(e.content).find('[data-hash]').addBack('[data-hash]').attr('data-hash');

					if (!hash) {
						return;
					}

					this._hashes[hash] = e.content;
				}
			}, this),
			'changed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && e.property.name === 'position') {
					var current = this._core.items(this._core.relative(this._core.current())),
						hash = $.map(this._hashes, function(item, hash) {
							return item === current ? hash : null;
						}).join();

					if (!hash || window.location.hash.slice(1) === hash) {
						return;
					}

					window.location.hash = hash;
				}
			}, this)
		};

		// set default options
		this._core.options = $.extend({}, Hash.Defaults, this._core.options);

		// register the event handlers
		this.$element.on(this._handlers);

		// register event listener for hash navigation
		$(window).on('hashchange.owl.navigation', $.proxy(function(e) {
			var hash = window.location.hash.substring(1),
				items = this._core.$stage.children(),
				position = this._hashes[hash] && items.index(this._hashes[hash]);

			if (position === undefined || position === this._core.current()) {
				return;
			}

			this._core.to(this._core.relative(position), false, true);
		}, this));
	};

	/**
	 * Default options.
	 * @public
	 */
	Hash.Defaults = {
		URLhashListener: false
	};

	/**
	 * Destroys the plugin.
	 * @public
	 */
	Hash.prototype.destroy = function() {
		var handler, property;

		$(window).off('hashchange.owl.navigation');

		for (handler in this._handlers) {
			this._core.$element.off(handler, this._handlers[handler]);
		}
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		}
	};

	$.fn.owlCarousel.Constructor.Plugins.Hash = Hash;

})(window.Zepto || window.jQuery, window, document);

/**
 * Support Plugin
 *
 * @version 2.3.4
 * @author Vivid Planet Software GmbH
 * @author Artus Kolanowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	var style = $('<support>').get(0).style,
		prefixes = 'Webkit Moz O ms'.split(' '),
		events = {
			transition: {
				end: {
					WebkitTransition: 'webkitTransitionEnd',
					MozTransition: 'transitionend',
					OTransition: 'oTransitionEnd',
					transition: 'transitionend'
				}
			},
			animation: {
				end: {
					WebkitAnimation: 'webkitAnimationEnd',
					MozAnimation: 'animationend',
					OAnimation: 'oAnimationEnd',
					animation: 'animationend'
				}
			}
		},
		tests = {
			csstransforms: function() {
				return !!test('transform');
			},
			csstransforms3d: function() {
				return !!test('perspective');
			},
			csstransitions: function() {
				return !!test('transition');
			},
			cssanimations: function() {
				return !!test('animation');
			}
		};

	function test(property, prefixed) {
		var result = false,
			upper = property.charAt(0).toUpperCase() + property.slice(1);

		$.each((property + ' ' + prefixes.join(upper + ' ') + upper).split(' '), function(i, property) {
			if (style[property] !== undefined) {
				result = prefixed ? property : true;
				return false;
			}
		});

		return result;
	}

	function prefixed(property) {
		return test(property, true);
	}

	if (tests.csstransitions()) {
		/* jshint -W053 */
		$.support.transition = new String(prefixed('transition'))
		$.support.transition.end = events.transition.end[ $.support.transition ];
	}

	if (tests.cssanimations()) {
		/* jshint -W053 */
		$.support.animation = new String(prefixed('animation'))
		$.support.animation.end = events.animation.end[ $.support.animation ];
	}

	if (tests.csstransforms()) {
		/* jshint -W053 */
		$.support.transform = new String(prefixed('transform'));
		$.support.transform3d = tests.csstransforms3d();
	}

})(window.Zepto || window.jQuery, window, document);


/***/ }),

/***/ "./node_modules/toastify-js/src/toastify.js":
/*!**************************************************!*\
  !*** ./node_modules/toastify-js/src/toastify.js ***!
  \**************************************************/
/***/ (function(module) {

/*!
 * Toastify js 1.12.0
 * https://github.com/apvarun/toastify-js
 * @license MIT licensed
 *
 * Copyright (C) 2018 Varun A P
 */
(function(root, factory) {
  if ( true && module.exports) {
    module.exports = factory();
  } else {
    root.Toastify = factory();
  }
})(this, function(global) {
  // Object initialization
  var Toastify = function(options) {
      // Returning a new init object
      return new Toastify.lib.init(options);
    },
    // Library version
    version = "1.12.0";

  // Set the default global options
  Toastify.defaults = {
    oldestFirst: true,
    text: "Toastify is awesome!",
    node: undefined,
    duration: 3000,
    selector: undefined,
    callback: function () {
    },
    destination: undefined,
    newWindow: false,
    close: false,
    gravity: "toastify-top",
    positionLeft: false,
    position: '',
    backgroundColor: '',
    avatar: "",
    className: "",
    stopOnFocus: true,
    onClick: function () {
    },
    offset: {x: 0, y: 0},
    escapeMarkup: true,
    ariaLive: 'polite',
    style: {background: ''}
  };

  // Defining the prototype of the object
  Toastify.lib = Toastify.prototype = {
    toastify: version,

    constructor: Toastify,

    // Initializing the object with required parameters
    init: function(options) {
      // Verifying and validating the input object
      if (!options) {
        options = {};
      }

      // Creating the options object
      this.options = {};

      this.toastElement = null;

      // Validating the options
      this.options.text = options.text || Toastify.defaults.text; // Display message
      this.options.node = options.node || Toastify.defaults.node;  // Display content as node
      this.options.duration = options.duration === 0 ? 0 : options.duration || Toastify.defaults.duration; // Display duration
      this.options.selector = options.selector || Toastify.defaults.selector; // Parent selector
      this.options.callback = options.callback || Toastify.defaults.callback; // Callback after display
      this.options.destination = options.destination || Toastify.defaults.destination; // On-click destination
      this.options.newWindow = options.newWindow || Toastify.defaults.newWindow; // Open destination in new window
      this.options.close = options.close || Toastify.defaults.close; // Show toast close icon
      this.options.gravity = options.gravity === "bottom" ? "toastify-bottom" : Toastify.defaults.gravity; // toast position - top or bottom
      this.options.positionLeft = options.positionLeft || Toastify.defaults.positionLeft; // toast position - left or right
      this.options.position = options.position || Toastify.defaults.position; // toast position - left or right
      this.options.backgroundColor = options.backgroundColor || Toastify.defaults.backgroundColor; // toast background color
      this.options.avatar = options.avatar || Toastify.defaults.avatar; // img element src - url or a path
      this.options.className = options.className || Toastify.defaults.className; // additional class names for the toast
      this.options.stopOnFocus = options.stopOnFocus === undefined ? Toastify.defaults.stopOnFocus : options.stopOnFocus; // stop timeout on focus
      this.options.onClick = options.onClick || Toastify.defaults.onClick; // Callback after click
      this.options.offset = options.offset || Toastify.defaults.offset; // toast offset
      this.options.escapeMarkup = options.escapeMarkup !== undefined ? options.escapeMarkup : Toastify.defaults.escapeMarkup;
      this.options.ariaLive = options.ariaLive || Toastify.defaults.ariaLive;
      this.options.style = options.style || Toastify.defaults.style;
      if(options.backgroundColor) {
        this.options.style.background = options.backgroundColor;
      }

      // Returning the current object for chaining functions
      return this;
    },

    // Building the DOM element
    buildToast: function() {
      // Validating if the options are defined
      if (!this.options) {
        throw "Toastify is not initialized";
      }

      // Creating the DOM object
      var divElement = document.createElement("div");
      divElement.className = "toastify on " + this.options.className;

      // Positioning toast to left or right or center
      if (!!this.options.position) {
        divElement.className += " toastify-" + this.options.position;
      } else {
        // To be depreciated in further versions
        if (this.options.positionLeft === true) {
          divElement.className += " toastify-left";
          console.warn('Property `positionLeft` will be depreciated in further versions. Please use `position` instead.')
        } else {
          // Default position
          divElement.className += " toastify-right";
        }
      }

      // Assigning gravity of element
      divElement.className += " " + this.options.gravity;

      if (this.options.backgroundColor) {
        // This is being deprecated in favor of using the style HTML DOM property
        console.warn('DEPRECATION NOTICE: "backgroundColor" is being deprecated. Please use the "style.background" property.');
      }

      // Loop through our style object and apply styles to divElement
      for (var property in this.options.style) {
        divElement.style[property] = this.options.style[property];
      }

      // Announce the toast to screen readers
      if (this.options.ariaLive) {
        divElement.setAttribute('aria-live', this.options.ariaLive)
      }

      // Adding the toast message/node
      if (this.options.node && this.options.node.nodeType === Node.ELEMENT_NODE) {
        // If we have a valid node, we insert it
        divElement.appendChild(this.options.node)
      } else {
        if (this.options.escapeMarkup) {
          divElement.innerText = this.options.text;
        } else {
          divElement.innerHTML = this.options.text;
        }

        if (this.options.avatar !== "") {
          var avatarElement = document.createElement("img");
          avatarElement.src = this.options.avatar;

          avatarElement.className = "toastify-avatar";

          if (this.options.position == "left" || this.options.positionLeft === true) {
            // Adding close icon on the left of content
            divElement.appendChild(avatarElement);
          } else {
            // Adding close icon on the right of content
            divElement.insertAdjacentElement("afterbegin", avatarElement);
          }
        }
      }

      // Adding a close icon to the toast
      if (this.options.close === true) {
        // Create a span for close element
        var closeElement = document.createElement("button");
        closeElement.type = "button";
        closeElement.setAttribute("aria-label", "Close");
        closeElement.className = "toast-close";
        closeElement.innerHTML = "&#10006;";

        // Triggering the removal of toast from DOM on close click
        closeElement.addEventListener(
          "click",
          function(event) {
            event.stopPropagation();
            this.removeElement(this.toastElement);
            window.clearTimeout(this.toastElement.timeOutValue);
          }.bind(this)
        );

        //Calculating screen width
        var width = window.innerWidth > 0 ? window.innerWidth : screen.width;

        // Adding the close icon to the toast element
        // Display on the right if screen width is less than or equal to 360px
        if ((this.options.position == "left" || this.options.positionLeft === true) && width > 360) {
          // Adding close icon on the left of content
          divElement.insertAdjacentElement("afterbegin", closeElement);
        } else {
          // Adding close icon on the right of content
          divElement.appendChild(closeElement);
        }
      }

      // Clear timeout while toast is focused
      if (this.options.stopOnFocus && this.options.duration > 0) {
        var self = this;
        // stop countdown
        divElement.addEventListener(
          "mouseover",
          function(event) {
            window.clearTimeout(divElement.timeOutValue);
          }
        )
        // add back the timeout
        divElement.addEventListener(
          "mouseleave",
          function() {
            divElement.timeOutValue = window.setTimeout(
              function() {
                // Remove the toast from DOM
                self.removeElement(divElement);
              },
              self.options.duration
            )
          }
        )
      }

      // Adding an on-click destination path
      if (typeof this.options.destination !== "undefined") {
        divElement.addEventListener(
          "click",
          function(event) {
            event.stopPropagation();
            if (this.options.newWindow === true) {
              window.open(this.options.destination, "_blank");
            } else {
              window.location = this.options.destination;
            }
          }.bind(this)
        );
      }

      if (typeof this.options.onClick === "function" && typeof this.options.destination === "undefined") {
        divElement.addEventListener(
          "click",
          function(event) {
            event.stopPropagation();
            this.options.onClick();
          }.bind(this)
        );
      }

      // Adding offset
      if(typeof this.options.offset === "object") {

        var x = getAxisOffsetAValue("x", this.options);
        var y = getAxisOffsetAValue("y", this.options);

        var xOffset = this.options.position == "left" ? x : "-" + x;
        var yOffset = this.options.gravity == "toastify-top" ? y : "-" + y;

        divElement.style.transform = "translate(" + xOffset + "," + yOffset + ")";

      }

      // Returning the generated element
      return divElement;
    },

    // Displaying the toast
    showToast: function() {
      // Creating the DOM object for the toast
      this.toastElement = this.buildToast();

      // Getting the root element to with the toast needs to be added
      var rootElement;
      if (typeof this.options.selector === "string") {
        rootElement = document.getElementById(this.options.selector);
      } else if (this.options.selector instanceof HTMLElement || (typeof ShadowRoot !== 'undefined' && this.options.selector instanceof ShadowRoot)) {
        rootElement = this.options.selector;
      } else {
        rootElement = document.body;
      }

      // Validating if root element is present in DOM
      if (!rootElement) {
        throw "Root element is not defined";
      }

      // Adding the DOM element
      var elementToInsert = Toastify.defaults.oldestFirst ? rootElement.firstChild : rootElement.lastChild;
      rootElement.insertBefore(this.toastElement, elementToInsert);

      // Repositioning the toasts in case multiple toasts are present
      Toastify.reposition();

      if (this.options.duration > 0) {
        this.toastElement.timeOutValue = window.setTimeout(
          function() {
            // Remove the toast from DOM
            this.removeElement(this.toastElement);
          }.bind(this),
          this.options.duration
        ); // Binding `this` for function invocation
      }

      // Supporting function chaining
      return this;
    },

    hideToast: function() {
      if (this.toastElement.timeOutValue) {
        clearTimeout(this.toastElement.timeOutValue);
      }
      this.removeElement(this.toastElement);
    },

    // Removing the element from the DOM
    removeElement: function(toastElement) {
      // Hiding the element
      // toastElement.classList.remove("on");
      toastElement.className = toastElement.className.replace(" on", "");

      // Removing the element from DOM after transition end
      window.setTimeout(
        function() {
          // remove options node if any
          if (this.options.node && this.options.node.parentNode) {
            this.options.node.parentNode.removeChild(this.options.node);
          }

          // Remove the element from the DOM, only when the parent node was not removed before.
          if (toastElement.parentNode) {
            toastElement.parentNode.removeChild(toastElement);
          }

          // Calling the callback function
          this.options.callback.call(toastElement);

          // Repositioning the toasts again
          Toastify.reposition();
        }.bind(this),
        400
      ); // Binding `this` for function invocation
    },
  };

  // Positioning the toasts on the DOM
  Toastify.reposition = function() {

    // Top margins with gravity
    var topLeftOffsetSize = {
      top: 15,
      bottom: 15,
    };
    var topRightOffsetSize = {
      top: 15,
      bottom: 15,
    };
    var offsetSize = {
      top: 15,
      bottom: 15,
    };

    // Get all toast messages on the DOM
    var allToasts = document.getElementsByClassName("toastify");

    var classUsed;

    // Modifying the position of each toast element
    for (var i = 0; i < allToasts.length; i++) {
      // Getting the applied gravity
      if (containsClass(allToasts[i], "toastify-top") === true) {
        classUsed = "toastify-top";
      } else {
        classUsed = "toastify-bottom";
      }

      var height = allToasts[i].offsetHeight;
      classUsed = classUsed.substr(9, classUsed.length-1)
      // Spacing between toasts
      var offset = 15;

      var width = window.innerWidth > 0 ? window.innerWidth : screen.width;

      // Show toast in center if screen with less than or equal to 360px
      if (width <= 360) {
        // Setting the position
        allToasts[i].style[classUsed] = offsetSize[classUsed] + "px";

        offsetSize[classUsed] += height + offset;
      } else {
        if (containsClass(allToasts[i], "toastify-left") === true) {
          // Setting the position
          allToasts[i].style[classUsed] = topLeftOffsetSize[classUsed] + "px";

          topLeftOffsetSize[classUsed] += height + offset;
        } else {
          // Setting the position
          allToasts[i].style[classUsed] = topRightOffsetSize[classUsed] + "px";

          topRightOffsetSize[classUsed] += height + offset;
        }
      }
    }

    // Supporting function chaining
    return this;
  };

  // Helper function to get offset.
  function getAxisOffsetAValue(axis, options) {

    if(options.offset[axis]) {
      if(isNaN(options.offset[axis])) {
        return options.offset[axis];
      }
      else {
        return options.offset[axis] + 'px';
      }
    }

    return '0px';

  }

  function containsClass(elem, yourClass) {
    if (!elem || typeof yourClass !== "string") {
      return false;
    } else if (
      elem.className &&
      elem.className
        .trim()
        .split(/\s+/gi)
        .indexOf(yourClass) > -1
    ) {
      return true;
    } else {
      return false;
    }
  }

  // Setting up the prototype for the init object
  Toastify.lib.init.prototype = Toastify.lib;

  // Returning the Toastify function to be assigned to the window object/module
  return Toastify;
});


/***/ }),

/***/ "./src/assets/js/calculator.js":
/*!*************************************!*\
  !*** ./src/assets/js/calculator.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "calculator": () => (/* binding */ calculator)
/* harmony export */ });
let elem = [document.getElementById('priceHours'), document.getElementById('hoursQuantity'), document.getElementById('calcPeopleNumber')]
function calculator() {
  setCalc()
  let x = document.getElementsByClassName('panell')
  for (let i = 0; i < x.length; i++) {
    x[i].addEventListener('click', setCalc, {
      passive: true
    })
  }
  function writeFinalValue(a, b, c, d) {
    if (!c) c = false;
    if (!d) d = false;
    return Math.round(a * b * (c ? c : 1) * (d ? d : 1)).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' €'
  }
  function singleCallHelperCalc(x, y, z = false) {
    document.getElementById('result').textContent = writeFinalValue(x, y, (z ? z : false))
    document.getElementById('resultMobile').textContent = writeFinalValue(x, y, (z ? z : false))
    let newPrices = document.getElementsByClassName('newPrice')
    for (let i = 0; i < newPrices.length; i++) {
      newPrices[i].textContent = writeFinalValue(x, y, (z ? z : false), 0.8)
    }
  }
  function setCalc() {
    helper(elem)
  }
  function helper(x) {
    for (let i = 0; i < x.length; i++) {
      if (isIE11) {
        addEvent('change', x[i], function () {
          singleCallHelperCalc(parseInt(x[0].value), parseInt(x[1].value), window.groupCall === 1 ? parseInt(elem[2].value) : 1)
        })
      } else {
        x[i].addEventListener('input', function () {
          singleCallHelperCalc(parseInt(x[0].value), parseInt(x[1].value), window.groupCall === 1 ? parseInt(elem[2].value) : 1)
        })
      }
    }
  }
  let buttons = document.getElementsByClassName('panell')
  for (let i = 0; i < buttons.length; i++) {
    buttons[i].addEventListener('click', function () {
      if (this.className.indexOf('is-active') === -1) {
        if (this.dataset.pointer === "gc") {
          this.style.cssText = 'color:#1D293F; pointer-events:none'
          this.parentNode.getElementsByTagName('li')[0].style.cssText = 'color:#fff; pointer-events:auto; cursor:pointer;'
          document.getElementsByClassName('calcButton')[0].style.left = '50%'
          document.getElementsByClassName('peopleCount')[0].style.cssText = "transition:0.3s; opacity:1; transition-delay:0.1s;pointer-events:auto;"
          window.groupCall = 1
          singleCallHelperCalc(parseInt(elem[0].value), parseInt(elem[1].value), parseInt(elem[2].value))
        } else if (this.dataset.pointer === "pc") {
          this.style.cssText = 'color:#1D293F; pointer-events:none'
          this.parentNode.getElementsByTagName('li')[1].style.cssText = 'color:#fff; pointer-events:auto; cursor:pointer;'
          document.getElementsByClassName('calcButton')[0].style.left = '5px'
          document.getElementsByClassName('peopleCount')[0].style.cssText = "transition:0.3s; opacity:0; transition-delay:0.1s; pointer-events:auto;"
          window.groupCall = 0
          singleCallHelperCalc(parseInt(elem[0].value), parseInt(elem[1].value), 1)
        }
      }
    })
  }
}
function addEvent(evnt, elem, func) {
  if (elem.addEventListener)
    elem.addEventListener(evnt, func, false);
  else if (elem.attachEvent) {
    elem.attachEvent("on" + evnt, func);
  }
  else {
    elem[evnt] = func;
  }
}


/***/ }),

/***/ "./src/assets/js/closeSpanPopup.js":
/*!*****************************************!*\
  !*** ./src/assets/js/closeSpanPopup.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "showPopup": () => (/* binding */ showPopup)
/* harmony export */ });
window.maxPopup = 0

function showPopup() {
    let mainPopup
    let popupTrigers = document.getElementsByClassName('cp')

    let helperClose

    for (let i = 0; i < popupTrigers.length; i++) {
        popupTrigers[i].addEventListener('click', function (e) {
            let popupBases = document.getElementsByClassName('popupBase')

            if (this.dataset.popup === 'addCardPopUp') {

            } else if (this.dataset.popup === 'time-slot-popup') {
                if (this.dataset.jtctimeslot === "1") {
                    window.poperClickedZ = 1
                }
                //this list is for not closing popup when new one is opened in front
            } else if (this.dataset.popup === 'uploadDropArea') {

            } else if (this.dataset.popup === 'editFullName') {

            } else if (this.dataset.popup === 'editEmail') {

            } else if (this.dataset.popup === 'professionEdit') {

            } else if (this.dataset.popup === 'addShortDescription') {

            } else if (this.dataset.popup === 'addYouTubeVideo') {

            } else if (this.dataset.popup === 'setPrivateProfile') {

            } else if (this.dataset.popup === 'takePictureWithWebCam') {

            } else if (this.dataset.popup === 'editPassword') {

            } else if (this.dataset.popup === 'add_cv_work_experience') {

            } else if (this.dataset.popup === 'add_education') {

            } else if (this.dataset.popup === 'cardPopUp') {

            } else if (this.dataset.popup === 'addPrivateTalk') {

            } else if (this.dataset.popup === 'deleteTalkPopup') {

            } else if (this.dataset.popup === 'cv_popup') {

            } else if (this.dataset.popup === 'calendar_popup') {

            } else if (this.dataset.popup === 'social_verify') {

            } else if (this.dataset.popup === 'connected_calendars') {

            } else if (this.dataset.popup === 'deleteProfilePopup') {

            } else {
                if (window.popupIsShowing === 1) {

                    closePopupBeforeOpenOtherOne()
                }
            }

            for (let i = 0; i < popupBases.length; i++) {

                if (document.getElementById(this.dataset.popup)) {
                    let that = this.dataset.popup
                    if (helperClose === 1) {

                        setTimeout(function () {
                            if (that === 'extendCall') {
                                let extCal = document.getElementById('extendCall').getElementsByClassName('extCal')
                                for (let i = 0; i < extCal.length; i++) {
                                    if (extCal[i].classList.contains('hollow')) {
                                        extCal[i].classList.toggle('hollow')
                                    }
                                    document.getElementById('extendLesson').disabled = true
                                }
                            }
                            openPopup(that)
                        }, 410)
                    } else {
                        if (that === 'extendCall') {
                            let extCal = document.getElementById('extendCall').getElementsByClassName('extCal')
                            for (let i = 0; i < extCal.length; i++) {
                                if (extCal[i].classList.contains('hollow')) {
                                    extCal[i].classList.toggle('hollow')
                                }
                                document.getElementById('extendLesson').disabled = true
                            }
                        }
                        openPopup(this.dataset.popup)
                    }
                    return;
                }

            }

        })
    }

    let notificationBeforeMeeting = document.getElementsByClassName('notificationBeforeMeeting')

    for (let i = 0; i < notificationBeforeMeeting.length; i++) {
        notificationBeforeMeeting[i].addEventListener('click', function (e) {

            let bookingId = this.getAttribute('data-booking-id');
            let notification_state = this.checked ? 1 : 0;
            let xhttp = new XMLHttpRequest();
            let url = '/set-booking/notification/?booking_id=' + bookingId + '&notification_state=' + notification_state;

            xhttp.onreadystatechange = function () {
                if (this.readyState == 1) {
                    document.getElementsByTagName('html')[0].style.cursor = 'progress'
                }
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementsByTagName('html')[0].style.cursor = 'default'

                    let response = JSON.parse(xhttp.responseText)
                    Toastify({
                        text: response.message,
                        className: "notification",
                        gravity: "bottom",
                        position: "left",
                        close: true,
                        duration: 3000,
                        stopOnFocus: true,
                        escapeMarkup: false
                        // avatar: "/frontend/assets/img/user-img.png"
                    }).showToast()

                }
            }

            xhttp.onerror = function (error) {
                Sentry.captureException(new setBookingNotificationError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
            }

            xhttp.open("GET", url, true)
            xhttp.send()

        })
    }

    let cancelBooking = document.getElementsByClassName('cancelBooking')
    for (let i = 0; i < cancelBooking.length; i++) {
        cancelBooking[i].addEventListener('click', function (e) {

            let reasons = document.getElementsByClassName('reason')
            let checkedReason = 0
            Array.prototype.forEach.call(reasons, function (element) {
                if (element.checked) {
                    checkedReason = element.value
                }
            });

            let bookingId = this.getAttribute('data-booking-id');
            let xhttp = new XMLHttpRequest();
            let url = '/cancel-booking/?booking_id=' + bookingId + '&reason_id=' + checkedReason


            xhttp.onreadystatechange = function () {
                if (this.readyState == 1) {
                    document.getElementsByTagName('html')[0].style.cursor = 'progress'
                }
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementsByTagName('html')[0].style.cursor = 'default'

                    let response = JSON.parse(xhttp.responseText)
                    Toastify({
                        text: response.message,
                        className: "notification",
                        gravity: "bottom",
                        position: "left",
                        close: true,
                        duration: 3000,
                        stopOnFocus: true,
                        escapeMarkup: false
                        // avatar: "/frontend/assets/img/user-img.png"
                    }).showToast();

                    if (response.success) {
                        let closeSpanPopus = document.getElementsByClassName('closeSpanPopup')
                        for (let i = 0; i < closeSpanPopus.length; i++) {
                            closePopup(closeSpanPopus[i].parentNode.parentNode.id)

                        }
                        showLoading()
                        location.reload()
                    }
                }
            };

            xhttp.onerror = function (error) {
                Sentry.captureException(new CancelBookingError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
            };

            xhttp.open("GET", url, true);
            xhttp.send();

        })
    }


    // left: 37, up: 38, right: 39, down: 40,
    // spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
    var keys = { 37: 1, 38: 1, 39: 1, 40: 1 };

    function preventDefault(e) {
        e.preventDefault();
    }

    function preventDefaultForScrollKeys(e) {
        if (keys[e.keyCode]) {
            preventDefault(e);
            return false;
        }
    }

    // modern Chrome requires { passive: false } when adding event
    var supportsPassive = false;
    try {
        window.addEventListener("test", null, Object.defineProperty({}, 'passive', {
            get: function () { supportsPassive = true; }
        }));
    } catch (e) { }

    var wheelOpt = supportsPassive ? { passive: false } : false;
    var wheelEvent = 'onwheel' in document.createElement('div') ? 'wheel' : 'mousewheel';

    // call this to Disable
    function disableScroll() {
        window.addEventListener('DOMMouseScroll', preventDefault, false); // older FF
        window.addEventListener(wheelEvent, preventDefault, wheelOpt); // modern desktop
        window.addEventListener('touchmove', preventDefault, wheelOpt); // mobile
        window.addEventListener('keydown', preventDefaultForScrollKeys, false);
    }

    // call this to Enable
    function enableScroll() {
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
        window.removeEventListener(wheelEvent, preventDefault, wheelOpt);
        window.removeEventListener('touchmove', preventDefault, wheelOpt);
        window.removeEventListener('keydown', preventDefaultForScrollKeys, false);
    }

    window.openPopup = function (x) {

        if (document.getElementById(x)) {

            document.documentElement.style.overflow = 'hidden'

            let mainPopup = document.getElementById(x)
            mainPopup.style.display = 'flex'

            if (mainPopup.id === 'extendCall') {
                mainPopup.classList.add('extendCallPopupCorrection')
            } else if (mainPopup.id === 'paymentWalletPopUp') {
                mainPopup.classList.add('extendCallPopupCorrection')
            } else if (mainPopup.id === 'paymentCompletedPopUp') {
                mainPopup.classList.add('extendCallPopupCorrection')
                mainPopup.classList.add('extendCallPopupCorrection2')
            }else if (mainPopup.id === 'time-slot-popup') {

                mainPopup.style.alignItems = 'center'
            }  else {
                mainPopup.style.alignItems = 'center'
            }



            if (mainPopup.getElementsByClassName('popuper')[0]) {
                mainPopup.getElementsByClassName('popuper')[0].style.padding = '0'
            } else {
                mainPopup.getElementsByClassName('popuper2')[0].style.padding = '0'
            }


            setTimeout(function () {

                if (mainPopup.id === "callSetting") {

                    //mainPopup.getElementsByClassName('popuper')[0].style.height = elHight + 'px'
                    calculatePopUpHeight(mainPopup, 35)

                } else if (mainPopup.id === "time-slot-popup") {

                    calculatePopUpHeight(mainPopup, 52)
                    document.getElementById('timeSlotValidation').textContent = ''
                    if (window.poperClickedZ === 1) {

                        if (document.getElementById('time-slot-popup')) {
                            setDrums(document.getElementById('time-slot-popup'), '10', '00', '11', '00')
                        }
                        window.poperClickedZ = 0
                    }



                } else if (mainPopup.id === "setPrivateProfile") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "addGroupTalk") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "appStorePupUp") {

                    calculatePopUpHeight(mainPopup)

                } else if (mainPopup.id === "addPrivateTalk") {
                    setTimeout(function () {
                        if (window.clickedEdit === 1) {
                            calculatePopUpHeight(mainPopup, 94)
                        } else {
                            calculatePopUpHeight(mainPopup, 94)
                        }

                    }, 100)



                } else if (mainPopup.id === "cv_popup") {

                    calculatePopUpHeight(mainPopup, 52)


                } else if (mainPopup.id === "newFilterPopup") {

                    /*  document.getElementsByClassName('credit-model')[0].style.height = document.getElementById('newFilterForm').getElementsByClassName('pb4')[0].offsetHeight + 'px'
                     document.getElementById('newFilterPopup').getElementsByClassName('popuper')[0].style.height = document.getElementsByClassName('credit-model')[0].offsetHeight +
                     document.getElementsByClassName('zzswe')[0].offsetHeight + document.getElementById('newFilterForm').getElementsByClassName('bbut')[0].offsetHeight + 'px' */



                } else if (mainPopup.id === "profileSettings") {
                    window.profileSettings = 1
                } else if (mainPopup.id === "editPassword") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "uploadDropArea") {
                    document.getElementsByClassName('checkImageBeforeUpload')[0].classList.remove('dn')
                    if (document.getElementById('uploadDropArea')?.getElementsByClassName('popuper')[0]) {
                        document.getElementById('uploadDropArea').getElementsByClassName('popuper')[0].style.height = 'auto'
                    }

                } else if (mainPopup.id === "takePictureWithWebCam") {

                    calculatePopUpHeight(mainPopup, 82)

                } else if (mainPopup.id === "editEmail") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "chosePaymentMethodPopup") {

                    calculatePopUpHeight(mainPopup, 52)


                } else if (mainPopup.id === "connected_calendars") {

                    calculatePopUpHeight(mainPopup, 72)


                } else if (mainPopup.id === "calendar_popup") {
                    calculatePopUpHeight(mainPopup, 52)
                } else if (mainPopup.id === "languagePopUp") {

                    calculatePopUpHeight(mainPopup, 52)


                } else if (mainPopup.id === "social_verify") {

                    calculatePopUpHeight(mainPopup, 52)


                } else if (mainPopup.id === "permision_popup") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "blockedUsersPopup") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "privateFollowingPopup") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "cardPopUp") {

                    calculatePopUpHeight(mainPopup, 0)

                } else if (mainPopup.id === "editFullName") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "extendCall") {

                    calculatePopUpHeight(mainPopup, 10)

                } else if (mainPopup.id === "paymentCompletedPopUp") {

                    calculatePopUpHeight(mainPopup, 10)

                } else if (mainPopup.id === "paymentWalletPopUp") {

                    calculatePopUpHeight(mainPopup, 10)

                } else if (mainPopup.id === "deleteTalkPopup") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "addCompleteTalk") {

                    calculatePopUpHeight(mainPopup, 94)

                } else if (mainPopup.id === "addShortDescription") {

                    mainPopup.getElementsByClassName('b0')[0].textContent = '(' + mainPopup.getElementsByTagName('textarea')[0].textContent.length + '/1000)'
                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "add_education") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "addYouTubeVideo") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "changeAvailability") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "shareProfilePopUp") {

                    window.sharePopupTakl = 1

                    let k1ffs = document.getElementsByClassName('k1ff')
                    for (let i = 0; i < k1ffs.length; i++) {
                        k1ffs[i].classList.remove('dn')
                    }

                    let qrCodes = document.getElementsByClassName('qrcode')
                    for (let i = 0; i < qrCodes.length; i++) {
                        qrCodes[i].classList.add('dn')
                    }
                    let closeQR = document.getElementsByClassName('closeQR')
                    for (let i = 0; i < closeQR.length; i++) {
                        closeQR[i].classList.add('dn')
                    }
                    calculatePopUpHeight(mainPopup)
                } else if (mainPopup.id === "shareProfilePopUp2") {

                    window.sharePopupTakl = 0

                    let k1ffs = document.getElementsByClassName('k1ff')
                    for (let i = 0; i < k1ffs.length; i++) {
                        k1ffs[i].classList.remove('dn')
                    }

                    let qrCodes = document.getElementsByClassName('qrcode')
                    for (let i = 0; i < qrCodes.length; i++) {
                        qrCodes[i].classList.add('dn')
                    }
                    let closeQR = document.getElementsByClassName('closeQR')
                    for (let i = 0; i < closeQR.length; i++) {
                        closeQR[i].classList.add('dn')
                    }
                    calculatePopUpHeight(mainPopup)
                } else if (mainPopup.id === "shareProfilePopUp4") {

                    window.sharePopupTakl = 2

                    let k1ffs = document.getElementsByClassName('k1ff')
                    for (let i = 0; i < k1ffs.length; i++) {
                        k1ffs[i].classList.remove('dn')
                    }

                    let qrCodes = document.getElementsByClassName('qrcode')
                    for (let i = 0; i < qrCodes.length; i++) {
                        qrCodes[i].classList.add('dn')
                    }
                    let closeQR = document.getElementsByClassName('closeQR')
                    for (let i = 0; i < closeQR.length; i++) {
                        closeQR[i].classList.add('dn')
                    }
                    calculatePopUpHeight(mainPopup)
                } else if (mainPopup.id === "add_cv_work_experience") {

                    calculatePopUpHeight(mainPopup, 52)
                    window.experienceHelperCV = 1
                    window.professionHelper = 1

                    let inputs = document.getElementById('work-expirence-cv-form').elements
                    for (let i = 0; i < inputs.length; i++) {
                        if (inputs[i].type === 'checkbox') {
                            inputs[i].checked = false
                        } else {
                            inputs[i].value = ''
                            inputs[i].classList.remove('ok')
                        }
                    }

                } else if (mainPopup.id === "blankPopup") {
                    calculatePopUpHeight(mainPopup, 52)
                } else if (mainPopup.id === "professionEdit") {
                    calculatePopUpHeight(mainPopup, 52)

                    if (window.experienceHelperCV === 1) {
                        let proff = document.getElementById('edit_profession_form').elements['profession']
                        proff.value = ''
                        proff.classList.remove('ok')
                    }

                } else if (mainPopup.id === "call-popup") {

                    /* if(document.getElementsByTagName('main')[0]){
                        document.getElementsByTagName('main')[0].style.filter = 'blur(2px)'
                    }

                    if(document.getElementsByTagName('footer')[0]){
                        document.getElementsByTagName('footer')[0].style.filter = 'blur(2px)'
                    }

                    if(document.getElementsByTagName('header')[0]){
                        document.getElementsByTagName('header')[0].style.filter = 'blur(2px)'
                    }

                    if(document.getElementById('scroll')){
                        document.getElementById('scroll').style.filter = 'blur(2px)'
                    }
                    if(document.getElementsByClassName('ptbo')[0]){
                        document.getElementsByClassName('ptbo')[0].style.filter = 'blur(2px)'
                    }
                    if(document.getElementsByClassName('footer-tabs')[0]){
                       document.getElementsByClassName('footer-tabs')[0].style.filter = 'blur(2px)'
                    } */

                    setTimeout(function () {
                        setSizeOfCallingPopup()
                    }, 100)

                    function setSizeOfCallingPopup() {
                        let elHight, elHight1, elHight2

                        elHight1 = document.getElementById('call-popup').getElementsByClassName('form-option')[0].offsetHeight
                        elHight2 = document.getElementById('call-popup').getElementsByClassName('calling-model')[0].offsetHeight

                        elHight1 > elHight2 ? elHight = elHight1 + 20 : elHight = elHight2 + 20

                        let popuper
                        if (mainPopup.getElementsByClassName('popuper')[0]) {
                            popuper = mainPopup.getElementsByClassName('popuper')[0]
                        } else {
                            popuper = mainPopup.getElementsByClassName('popuper2')[0]
                        }

                        if (elHight > (window.innerHeight * 0.85)) {
                            popuper.style.height = '90%'
                            popuper.style.maxHeight = '90%'
                            popuper.style.marginTop = '5%'
                        } else {

                            popuper.style.maxHeight = '100%'
                            popuper.style.marginTop = '0'
                        }
                    }

                    window.addEventListener("resize", setSizeOfCallingPopup)

                } else {
                    calculatePopUpHeight(mainPopup)
                }
            }, 100)

            setTimeout(() => {
                if (mainPopup.id === "editFullName") {
                    document.getElementById('edit_full_name_form').elements['name'].focus()
                } else if (mainPopup.id === "editEmail") {
                    document.getElementById('edit_email_form').elements['email'].focus()
                } else if (mainPopup.id === "professionEdit") {
                    document.getElementById('edit_profession_form').elements['profession'].focus()
                } else if (mainPopup.id === "addShortDescription") {
                    document.getElementById('add-bio-form').elements['addBio'].focus()
                } else if (mainPopup.id === "editPassword") {
                    document.getElementById('edit_password_form').elements['password'].focus()
                }
            }, 200);


            setTimeout(function () {

                mainPopup.style.opacity = 1

                if (mainPopup.getElementsByClassName('popuper')[0]) {
                    mainPopup.getElementsByClassName('popuper')[0].style.transform = 'scale(1)'
                    mainPopup.getElementsByClassName('popuper')[0].style.padding = '0'
                } else {
                    mainPopup.getElementsByClassName('popuper2')[0].style.transform = 'scale(1)'
                    mainPopup.getElementsByClassName('popuper2')[0].style.padding = '0'
                }


            }, 110)

            mainPopup.dataset.opened = 1
            window.popupIsShowing = 1
            helperClose = 0
            mainPopup.style.zIndex = '99999999'
            if (window.mainPopuper123 === '' || typeof window.mainPopuper123 === 'undefined') {
                window.mainPopuper123 = mainPopup


            } else {

                if (window.mainPopuper1233 !== '' && typeof window.mainPopuper1233 !== 'undefined') {
                    window.mainPopuper1234 = window.mainPopuper1233
                    window.mainPopuper1233 = window.mainPopuper1232
                    window.mainPopuper1232 = window.mainPopuper123
                    window.mainPopuper123 = mainPopup

                } else {
                    if (window.mainPopuper1232 !== '' && typeof window.mainPopuper1232 !== 'undefined') {
                        window.mainPopuper1233 = window.mainPopuper1232
                        window.mainPopuper1232 = window.mainPopuper123
                        window.mainPopuper123 = mainPopup

                    } else {
                        if (window.mainPopuper123 !== '' && typeof window.mainPopuper123 !== 'undefined') {
                            window.mainPopuper1232 = window.mainPopuper123
                            window.mainPopuper123 = mainPopup

                        }
                    }
                }

            }
        } else {
            console.log('that popup is not on the page')
        }



    }




    function closePopupBeforeOpenOtherOne() {


        let popupBases = document.getElementsByClassName('popupBase')
        for (let i = 0; i < popupBases.length; i++) {

            if (popupBases[i].dataset.opened === "1") {

                closePopup(popupBases[i].id)
                helperClose = 1
            }
        }

    }

    window.closePopup = function (closePopupIdString) {

        if (document.getElementById(closePopupIdString)) {
            /* enableScroll() */


            document.documentElement.style.overflow = 'auto'
            let x = document.getElementById(closePopupIdString)

            //only for share popups, hide qr code before close popup
            if(x.getElementsByClassName('closeQR')[0]){

                if(!x.getElementsByClassName('closeQR')[0].classList.contains('dn')){
                    x.getElementsByClassName('closeQR')[0].click()
                }
            }

            if (x.getElementsByClassName('popuper')[0]) {
                x.getElementsByClassName('popuper')[0].style.transform = 'scale(0)'


                x.style.opacity = 0

                setTimeout(function () {
                    x.style.display = 'none'
                    x.style.zIndex = '1'
                }, 310)

                x.dataset.opened = 0

                if (x.id === "addCardPopUp") {
                    window.popupIsShowing = 1
                } else if (x.id === "call-popup") {
                    /*  if(document.getElementsByTagName('main')[0]){
                         document.getElementsByTagName('main')[0].style.filter = 'blur(0px)'
                     }

                     if(document.getElementsByTagName('footer')[0]){
                         document.getElementsByTagName('footer')[0].style.filter = 'blur(0px)'
                     }

                     if(document.getElementsByTagName('header')[0]){
                         document.getElementsByTagName('header')[0].style.filter = 'blur(0px)'
                     }

                     if(document.getElementById('scroll')){
                         document.getElementById('scroll').style.filter = 'blur(0px)'
                     }
                     if(document.getElementsByClassName('ptbo')[0]){
                         document.getElementsByClassName('ptbo')[0].style.filter = 'blur(0px)'
                     }
                     if(document.getElementsByClassName('footer-tabs')[0]){
                        document.getElementsByClassName('footer-tabs')[0].style.filter = 'blur(0px)'
                    } */
                } else if (x.id === "blankPopup") {
                    if (document.body.className === "book_slot") {
                        document.getElementById('funnelReviewWrapTotal').appendChild(document.getElementById('funnelReviewWrap'))
                        window.popupIsShowing = 0
                    }

                } else if (x.id === "private-talk-form") {

                    clearForm(document.getElementById('private-talk-form'))
                } else if (x.id === "time-slot-popup") {

                    document.getElementById('timeSlotValidation').style.height = '0px'

                } else {
                    window.popupIsShowing = 0
                }
            }


            if (
                (window.mainPopuper1234 !== '' && typeof window.mainPopuper1234 !== 'undefined') &&
                (window.mainPopuper1233 !== '' && typeof window.mainPopuper1233 !== 'undefined') &&
                (window.mainPopuper1232 !== '' && typeof window.mainPopuper1232 !== 'undefined') &&
                (window.mainPopuper123 !== '' && typeof window.mainPopuper123 !== 'undefined')
            ) {

                window.mainPopuper123 = window.mainPopuper1232
                window.mainPopuper1232 = window.mainPopuper1233
                window.mainPopuper1233 = window.mainPopuper1234
                window.mainPopuper1234 = ''
            } else if (
                (window.mainPopuper1234 === '' || typeof window.mainPopuper1234 === 'undefined') &&
                (window.mainPopuper1233 !== '' && typeof window.mainPopuper1233 !== 'undefined') &&
                (window.mainPopuper1232 !== '' && typeof window.mainPopuper1232 !== 'undefined') &&
                (window.mainPopuper123 !== '' && typeof window.mainPopuper123 !== 'undefined')
            ) {

                window.mainPopuper123 = window.mainPopuper1232
                window.mainPopuper1232 = window.mainPopuper1233
                window.mainPopuper1233 = ''
                window.mainPopuper1234 = ''
            } else if (
                (window.mainPopuper1234 === '' || typeof window.mainPopuper1234 === 'undefined') &&
                (window.mainPopuper1233 === '' || typeof window.mainPopuper1233 === 'undefined') &&
                (window.mainPopuper1232 !== '' && typeof window.mainPopuper1232 !== 'undefined') &&
                (window.mainPopuper123 !== '' && typeof window.mainPopuper123 !== 'undefined')
            ) {

                window.mainPopuper123 = window.mainPopuper1232
                window.mainPopuper1232 = ''
                window.mainPopuper1233 = ''
                window.mainPopuper1234 = ''
            } else if (
                (window.mainPopuper1234 === '' || typeof window.mainPopuper1234 === 'undefined') &&
                (window.mainPopuper1233 === '' || typeof window.mainPopuper1233 === 'undefined') &&
                (window.mainPopuper1232 === '' || typeof window.mainPopuper1232 === 'undefined') &&
                (window.mainPopuper123 !== '' && typeof window.mainPopuper123 !== 'undefined')
            ) {

                window.mainPopuper123 = ''
                window.mainPopuper1232 = ''
                window.mainPopuper1233 = ''
                window.mainPopuper1234 = ''
            }
        } else {
            console.log('that popup is not exist on this page')
        }



    }

    let closer = document.getElementsByClassName('closer')
    for (let i = 0; i < closer.length; i++) {
        closer[i].addEventListener('click', function () {
            if (this.dataset.close) {
                closePopup(this.dataset.close)
            }
        })
    }

    let closeSpanPopus = document.getElementsByClassName('closeSpanPopup')
    for (let i = 0; i < closeSpanPopus.length; i++) {
        closeSpanPopus[i].addEventListener('click', function (e) {
            closePopup(e.target.parentNode.parentNode.id)
            if (e.target.parentNode.parentNode.id === 'professionEdit') {

                document.getElementById('edit_profession_form').elements['profession'].value = ''
                document.getElementById('professionn').style.opacity = '0'

                document.getElementById('professionn').style.height = '0px'

                document.getElementById('professionn').innerHTML = ''
                setTimeout(function () {
                    document.getElementById('editProfessionSubmit').parentElement.style.opacity = '1'
                    document.getElementById('editProfessionSubmit').parentElement.style.transform = 'scale(1)'
                }, 310)

            }
        })
    }



    let popupers = document.getElementsByClassName('popuper')
    for (let i = 0; i < popupers.length; i++) {
        popupers[i].addEventListener('click', function (e) {
            e.stopPropagation()
        })
    }

    let popupBases = document.getElementsByClassName('popupBase')

    for (let i = 0; i < popupBases.length; i++) {
        popupBases[i].addEventListener('click', function () {

            // THIs popups wont close when you click dark transparent bacgkround
            if (this.id.trim() === 'call-popup' ||
                this.id.trim() === 'time-slot-popup' ||
                this.id.trim() === 'professionEdit' ||
                this.id.trim() === 'addPrivateTalk' ||
                this.id.trim() === 'addGroupTalk' ||
                this.id.trim() === 'reviewPopUp' ||
                this.id.trim() === 'addCoinsPopUp' ||
                this.id.trim() === 'cardPopUp' ||
                this.id.trim() === 'newFilterPopup' ||
                this.id.trim() === 'specialLoading' ||
                this.id.trim() === 'loadingPopup' ||
                this.id.trim().includes("classDetails")

            ) {

            } else if (this.id.trim() === 'blankPopup') {

                closePopup(this.id)
                setTimeout(function () {
                    if (document.getElementById('funnelReviewWrapTotal')) {
                        document.getElementById('funnelReviewWrapTotal').appendChild(document.getElementById('funnelReviewWrap'))
                    }
                }, 310)
            } else {

                closePopup(this.id)
            }
        })
    }

    document.getElementById('declineCall')?.addEventListener('click', function () {
        closePopup('call-popup')
    })

    document.getElementById('acceptCall')?.addEventListener('click', function () {
        location.assign(window.location.protocol + '//' + window.location.hostname + ':' + window.location.port + '/talk/incall');
    })




}

window.addEventListener("resize", function () {


    if (window.mainPopuper123 !== '' && typeof window.mainPopuper123 !== 'undefined') {
        if (window.mainPopuper123.id !== "newFilterPopup" || 'appStorePupUp') {
            if (window.mainPopuper123.getElementsByClassName('popuper')[0]) {
                calculatePopUpHeight(window.mainPopuper123, window.mainPopuper123.getElementsByClassName('popuper')[0].dataset.offset)
            } else if (window.mainPopuper123.getElementsByClassName('popuper2')[0]) {
                calculatePopUpHeight(window.mainPopuper123, window.mainPopuper123.getElementsByClassName('popuper2')[0].dataset.offset)
            }
        }
    }




})

window.calculatePopUpHeight = function (mainPopup, offset, minHeight) {
    setTimeout(function () {
        if (mainPopup) {

            if (!offset) {
                offset = 0
            } else {
                offset = parseInt(offset)
            }

            if (minHeight) {

                let elHight = minHeight + 5
                if (mainPopup.id === "calendar_popup" && window.innerWidth < 640) {
                    return
                } else {
                    calculatePopUpHeightHelper(mainPopup, elHight)

                }

            } else {

                if (mainPopup.getElementsByClassName('popuper')[0]) {

                    let elHight = mainPopup.getElementsByClassName('popuper')[0].getElementsByTagName('div')[0].offsetHeight + 5 + offset


                    if (offset) {
                        mainPopup.getElementsByClassName('popuper')[0].dataset.offset = offset
                    }

                    if (minHeight) {
                        mainPopup.getElementsByClassName('popuper')[0].dataset.minHeight = minHeight
                    }


                    if (mainPopup.id === "calendar_popup" && window.innerWidth < 640) {
                        return
                    } else {
                        calculatePopUpHeightHelper(mainPopup, elHight)

                    }
                } else {
                    let elHight = mainPopup.getElementsByClassName('popuper2')[0].getElementsByTagName('div')[0].offsetHeight + 5 + offset

                    if (offset) {
                        mainPopup.getElementsByClassName('popuper2')[0].dataset.offset = offset
                    }

                    if (minHeight) {
                        mainPopup.getElementsByClassName('popuper2')[0].dataset.minHeight = minHeight
                    }

                    if (mainPopup.id === "calendar_popup" && window.innerWidth < 640) {
                        return
                    } else {
                        calculatePopUpHeightHelper(mainPopup, elHight)

                    }
                }

            }
        }

    }, 310)


}

function calculatePopUpHeightHelper(mainPopup, elHight) {

    let popuper
    if (mainPopup.getElementsByClassName('popuper')[0]) {
        popuper = mainPopup.getElementsByClassName('popuper')[0]
    } else {
        popuper = mainPopup.getElementsByClassName('popuper2')[0]
    }



    if (elHight > (window.innerHeight * 0.85)) {
        //popuper.style.height = '90%'
        popuper.style.maxHeight = '90%'
        //popuper.dataset.height = '90%'Њ
        popuper.getElementsByTagName('div')[0].style.overflow = 'hidden'
    } else {
        popuper.style.maxHeight = '100%'
        //popuper.style.height = elHight + 'px'
        /* popuper.style.marginTop = '0px' */

        popuper.dataset.height = elHight
    }



}

class setBookingNotificationError extends Error {
    constructor(message) {
        super(message)
        this.name = "setBookingNotificationError"
    }
}

class CancelBookingError extends Error {
    constructor(message) {
        super(message)
        this.name = "CancelBookingError"
    }
}


/***/ }),

/***/ "./src/assets/js/comunicationControler.js":
/*!************************************************!*\
  !*** ./src/assets/js/comunicationControler.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "getTalkData": () => (/* binding */ getTalkData),
/* harmony export */   "uploadFile": () => (/* binding */ uploadFile)
/* harmony export */ });
function getTalkData(id) {

    let xhttp = new XMLHttpRequest()

    xhttp.onreadystatechange = function () {

        if (this.readyState == 1) {
            showLoading()
        }

        if (this.readyState == 4 && this.status == 200) {

            let response = JSON.parse(this.response)

            document.getElementById('acceptRemovingCourse').dataset.talkId = response.data.id
            if (response.data.call_type === consts.ONE_TO_ONE) {
                //input languages
                let app_languages = JSON.parse(localStorage.getItem('app_languages_' + getCookie('activeLang')))
                let languages = app_languages.data.languages

                inputLanguages()


                select_language(parseInt(response.data.languages_id))

                //input categories
                let app_talk_categories = JSON.parse(localStorage.getItem('app_talk_categories_' + getCookie('activeLang')))
                let data = app_talk_categories.talk_categories.data
                inputCategories()

                //select and input sub category
                select_category_input_and_select_subcategory(data, parseInt(response.data.talk_category_id), parseInt(response.data.talk_subcategory_id))
                //select sub category


                hideLoading()





                talkInputP.focus()

                let talk_data = response.data
                let form = document.getElementById('private-talk-form').elements

                form['talkIdP'].value = talk_data.id
                form['nameP'].classList.add('ok')
                form['nameP'].value = talk_data.headline
                form['descriptionP'].value = talk_data.description
                form['descriptionP'].classList.add('ok')


                //set duration
                let durationPOptions = durationP.options
                for (let i = 0; i < durationPOptions.length; i++) {
                    if (durationPOptions[i].value == talk_data.duration) {
                        durationP.selectedIndex = i
                        durationP.classList.add('ok')
                        break
                    }

                }

                form['priceP'].value = parseFloat(talk_data.price)
                form['priceP'].classList.add('ok')
                form['allowVideoTalkP'].checked = talk_data.is_anonymous_allowed === 0 ? false : true
                form['allowVideoTalkP'].checked = talk_data.talk_type === 1 ? false : true
                form['pauseThisTalk'].checked = talk_data.state === 1 ? false : true

                form['allowAnonimousTalkP'].checked = talk_data.is_anonymous_allowed == 1 ? true : false
                document.getElementById('addPrivateTalk').getElementsByClassName('deleteTalkButtoner')[0].classList.remove('dn')

                document.getElementsByClassName('pauseWrap')[0].classList.remove('dn')
                document.getElementsByClassName('deleteTalkButtoner')[0].classList.remove('dn')
                document.getElementById('privateSubmit').classList.remove('dn')
                document.getElementById('privateSubmit').textContent = getPoTranslate('EDIT_PRIVATE_TALK')
                document.getElementById('mobilePrivateTalkTitle').textContent = getPoTranslate('EDIT_PRIVATE_TALK')


                openPopup('addPrivateTalk')
            } else if (response.data.call_type === consts.GROUP) {

                let form = document.getElementById('group-talk-form').elements

                //input languages
                let app_languages = JSON.parse(localStorage.getItem('app_languages_' + getCookie('activeLang')))
                let languages = app_languages.data.languages

                inputGroupLanguages()

                select_group_language(getLanguageId())

                //input categories
                let app_talk_categories = JSON.parse(localStorage.getItem('app_talk_categories_' + getCookie('activeLang')))
                let data = app_talk_categories.talk_categories.data
                inputGroupCategories()

                //select and input sub category
                select_group_category_input_and_select_subcategory(data, parseInt(response.data.talk_category_id), parseInt(response.data.talk_subcategory_id))
                //select sub category


                hideLoading()

                let maxParticipantsOptions = participantsG.options
                let talk_data = response.data

                for (let k = 0; k < maxParticipantsOptions.length; k++) {

                    if (maxParticipantsOptions[k].value == talk_data.max_participiants) {

                        participantsG.classList.add('ok')
                        participantsG.selectedIndex = k

                        break
                    }
                }

                form['talkIdG'].value = talk_data.id

                form['nameG'].classList.add('ok')
                form['nameG'].value = talk_data.headline

                form['descriptionG'].value = talk_data.description
                form['descriptionG'].classList.add('ok')

                form['priceG'].value = parseFloat(talk_data.price)
                form['priceG'].classList.add('ok')

                let options = talkInteractionTypeG.options
                if(talk_data.interactive_mode){
                    for (let k = 0; k < options.length; k++) {

                        if (options[k].value == talk_data.interactive_mode) {

                            options[k].parentElement.classList.add('ok')
                            talkInteractionTypeG.selectedIndex = k
                            break
                        }
                    }
                }

                form['allowVideoTalkG'].checked = talk_data.is_anonymous_allowed === 0 ? false : true
                form['allowVideoTalkG'].checked = talk_data.talk_type === 1 ? false : true

                form['allowAnonimousTalkG'].checked = talk_data.is_anonymous_allowed == 1 ? true : false

                document.getElementById('group-talk-form').getElementsByClassName('pauseWrap')[0].classList.remove('dn')

                document.getElementById('group-talk-form').getElementsByClassName('date-scheduler-wrap')[0].getElementsByClassName('active')[0].classList.remove('active')
                let daysDivs = document.getElementById('group-talk-form').getElementsByClassName('date-scheduler-wrap')[0].getElementsByTagName('div')
                for (let i = 0; i < daysDivs.length; i++) {
                    if (daysDivs[i].dataset.index == talk_data.weekday) {
                        daysDivs[i].classList.add('active')
                    }

                }


                let start_time_call = new Date('1987.07.25. ' + talk_data.start_time_call)
                let end_time_call = new Date('1987.07.25. ' + talk_data.end_time_call)


                setDrums(
                    document.getElementById('group-talk-form'),
                    addZero(start_time_call.getHours()).toString(),
                    addZero(start_time_call.getMinutes()).toString(),
                    addZero(end_time_call.getHours()).toString(),
                    addZero(end_time_call.getMinutes()).toString()
                )

                document.getElementById('groupSubmit').parentElement.parentElement.classList.remove('dn')

                document.getElementById('groupSubmit').textContent = getPoTranslate('EDIT_GALLERY_TALK')
                document.getElementById('addGroupTalk').getElementsByClassName('pageTitlePoperAva')[0].textContent = getPoTranslate('EDIT_GALLERY_TALK')

                document.getElementById('group-talk-form').getElementsByClassName('deleteTalkButtoner')[0].classList.remove('dn')


                let pageTitlePoperAva = document.getElementById('addGroupTalk').getElementsByClassName('pageTitlePoperAva')

                for (let i = 0; i < pageTitlePoperAva.length; i++) {
                    pageTitlePoperAva[i].textContent = getPoTranslate('EDIT_GALLERY_TALK')
                }

                document.getElementById('jtc_add_gallery_talk_description').classList.add('dn')
                document.getElementById('jtc_edit_gallery_talk_description').classList.remove('dn')

                openPopup('addGroupTalk')
            }

        }
    }


    xhttp.onerror = function () {
        Sentry.captureException(new GetTalkDataError('status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
    }


    xhttp.open("GET", envAppBackendUrl + '/get-talk/' + id, true)


    xhttp.setRequestHeader('Accept', 'application/json')
    xhttp.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))
    xhttp.setRequestHeader('Authorization', bearerToken)
    xhttp.send();
}


function uploadFile(file) {


    var url = envAppBackendUrl + '/edit-profile-photo'

    var xhr = new XMLHttpRequest()

    var formData = new FormData()
    formData.append('_token', token)
    xhr.open('POST', url, true)

    xhr.setRequestHeader('Accept', 'application/json')

    xhr.addEventListener('loadstart', function () {
        /* document.getElementsByClassName('uplcnt')[0].style.display = 'block' */
    })

    // Update progress (can be used to show progress indicator)
    xhr.upload.addEventListener("progress", function (e) {

        /* updateProgress(i, (e.loaded * 100.0 / e.total) || 100) */
    })

    xhr.addEventListener('loadend', function () {
        /*  document.getElementsByClassName('uplcnt')[0].style.display = 'none'
            document.getElementsByClassName('icon-deletes')[0].style.display = 'none'
            dropArea.className = 'uploadedS' */
        window.fileUpl = true

    })

    xhr.addEventListener('readystatechange', function (e) {
        if (xhr.readyState == 4 && xhr.status == 200) {

            let obj = JSON.parse(this.responseText)

            if (obj.success == false) {
                toastify(obj.message)
                takePictureAgainHelper()
            } else {
                uploadCamPictureHelper(1, file)
                takePictureAgainHelper()
                /* window.location.reload(false) */
            }

            /* updateProgress(i, 100) */ // <- Add this
        } else if (xhr.readyState == 4 && xhr.status != 200) {
            // Error. Inform the user
            uploadCamPictureHelper(0)

        }
    })
    xhr.onerror = function () {
        Sentry.captureException(new editProfilePhotoError('status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
    }

    xhr.setRequestHeader('Accept', 'application/json')
    xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))
    xhr.setRequestHeader('Authorization', bearerToken)

    formData.append('file', file)

    xhr.send(formData)
}



function uploadCamPictureHelper(x, f) {



    if (x === 1) {

        var reader = new FileReader();
        reader.readAsDataURL(f);
        reader.onloadend = function () {
            var base64data = reader.result;

            let img = document.createElement('img')
            let img2 = document.createElement('img')

            img.src = base64data
            img2.src = base64data

            document.getElementsByClassName('loggedPic')[0].getElementsByTagName('img')[0].src = base64data

            if (document.getElementById('profile-img')) {
                document.getElementById('profile-img').src = base64data
            }

            if (document.getElementsByClassName('account-Vtion-group')[0]) {
                document.getElementsByClassName('account-Vtion-group')[0].getElementsByTagName('img')[0].src = base64data
            }



        }

        closePopup('takePictureWithWebCam')
        setTimeout(function () {
            closePopup('uploadDropArea')
            toastify(getPoTranslate('IMG_SUCCESS_UPLOADED'))

        }, 250)


    } else if (x === 0) {
        toastify(getPoTranslate('PLEASE_UPLOAD_IMG_AGAIN'))
    }
    hideLoading()
}

class UploadFileGetTokenError extends Error {
    constructor(message) {
        super(message)
        this.name = "UploadFileGetTokenError"
    }
}
class editProfilePhotoError extends Error {
    constructor(message) {
        super(message)
        this.name = "editProfilePhotoError"
    }
}
class GetDataError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetDataError"
    }
}
class PostDataError extends Error {
    constructor(message) {
        super(message)
        this.name = "PostDataError"
    }
}
class GetTalkDataError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTalkDataError"
    }
}

class GetCategorySubcategoriesError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetCategorySubcategoriesError"
    }
}


/***/ }),

/***/ "./src/assets/js/cookieNotice.js":
/*!***************************************!*\
  !*** ./src/assets/js/cookieNotice.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "cookieButtons": () => (/* binding */ cookieButtons)
/* harmony export */ });
function cookieButtons() {



    document.getElementById('cookieAllowAll').addEventListener('click', function () {

        document.getElementById('cookieMainCont').classList.add('accepted')
        document.getElementsByClassName('acceptedCookieContainer')[0].classList.add('accepted')


        createHelpCookieObject()

        setCookie("allow_cookies", getCookie('helpCookieObject'), 1 * 60 * 60 * 24 * 365, "/")

    })



    if (document.getElementById('acceptedCookieClosed')) {
        document.getElementById('acceptedCookieClosed').addEventListener('click', function () {
            if (document.getElementById('acceptedCookieClosed').classList.contains('accepted')) {
                document.getElementById('acceptedCookieClosed').classList.remove('accepted')

            }
            if (document.getElementById('cookieMainCont').classList.contains('accepted')) {
                document.getElementById('cookieMainCont').classList.remove('accepted')
            }
        })

    }

    //sett states by default
    if (getCookie('helpCookieObject') !== '') {

        let cookieObject = JSON.parse(getCookie('helpCookieObject'))

        let cookieInputs = document.getElementById('cookieOptions').getElementsByClassName('switch-input')
        for (let i = 0; i < cookieInputs.length; i++) {
            if (cookieObject.hasOwnProperty(cookieInputs[i].name)) {
                cookieInputs[i].checked = cookieObject[cookieInputs[i].name]

                let innerCookieInputs = cookieInputs[i].parentElement.parentElement.getElementsByClassName('switch-input')
                let counterForInnerCookieInputs = 0

                for (let j = 0; j < innerCookieInputs.length; j++) {
                    if (innerCookieInputs[j].checked) {
                        counterForInnerCookieInputs++
                    }

                }

                if (counterForInnerCookieInputs === 0) {

                    let mainCookieInputs = document.getElementsByClassName('mainCookieInput')
                    for (let k = 0; k < mainCookieInputs.length; k++) {

                        if (mainCookieInputs[k].dataset.property === cookieInputs[i].dataset.property) {

                            mainCookieInputs[k].checked = false
                        }
                    }
                }
            }


        }
    }

    function createHelpCookieObject() {
        let cookieSubOptions = document.getElementsByClassName('cookieSubOptions')
        let obj = {}
        for (let i = 0; i < cookieSubOptions.length; i++) {
            let cookeCheckedValues = cookieSubOptions[i].getElementsByClassName('switch-input')
            for (let j = 0; j < cookeCheckedValues.length; j++) {

                obj[cookeCheckedValues[j].id] = cookeCheckedValues[j].checked



            }
        }
        setCookie("helpCookieObject", JSON.stringify(obj), 1 * 60 * 2 * 24 * 30, "/")
    }


    if (document.getElementsByClassName('closeAllSuboptions')[0]) {
        let closeAllSuboptions = document.getElementsByClassName('closeAllSuboptions')
        for (let i = 0; i < closeAllSuboptions.length; i++) {
            closeAllSuboptions[i].addEventListener('click', function () {
                let cookieSubOptions = document.getElementsByClassName('cookieSubOptions')
                for (let i = 0; i < cookieSubOptions.length; i++) {
                    cookieSubOptions[i].style.left = '-1000px'

                }

                if (this.dataset.button === 'saveButton') {
                    createHelpCookieObject()
                    closePopup('cookieOptions')






                }

                if (document.getElementsByClassName('closeCookie')[0].dataset.opened === '1') {
                    document.getElementsByClassName('closeCookie')[0].dataset.opened = '0'
                } else {
                    closePopup('cookieOptions')
                }
            })

        }
    }






    let mainCookieSwitchChange = document.getElementsByClassName('mainCookieSwitchChange')
    for (let i = 0; i < mainCookieSwitchChange.length; i++) {
        mainCookieSwitchChange[i].addEventListener('click', function () {
            let cookieSubOptions = document.getElementsByClassName('cookieSubOptions')
            if (this.checked) {

                for (let i = 0; i < cookieSubOptions.length; i++) {
                    if (cookieSubOptions[i].dataset.property === this.dataset.property) {
                        let checkedInputs = cookieSubOptions[i].getElementsByClassName('switch-input')
                        for (let j = 0; j < checkedInputs.length; j++) {
                            checkedInputs[j].checked = true

                        }
                    }

                }

            } else {
                for (let i = 0; i < cookieSubOptions.length; i++) {
                    if (cookieSubOptions[i].dataset.property === this.dataset.property) {
                        let checkedInputs = cookieSubOptions[i].getElementsByClassName('switch-input')
                        for (let j = 0; j < checkedInputs.length; j++) {
                            checkedInputs[j].checked = false

                        }
                    }

                }
            }


        })

    }






    let selectParentCheckbox = document.getElementsByClassName('selectParentCheckbox')
    for (let i = 0; i < selectParentCheckbox.length; i++) {
        selectParentCheckbox[i].addEventListener('click', function () {
            let checkedInputs = this.parentElement.parentElement.getElementsByClassName('switch-input')
            let counter = 0

            for (let i = 0; i < checkedInputs.length; i++) {
                if (checkedInputs[i].checked) {
                    counter++
                }

            }
            let mainCookieInputs = this.parentElement.parentElement.parentElement.getElementsByClassName('mainCookieInput')

            if (counter === 0) {

                for (let i = 0; i < mainCookieInputs.length; i++) {

                    if (this.dataset.property === mainCookieInputs[i].dataset.property) {
                        mainCookieInputs[i].checked = false
                    }
                }

            } else {
                for (let i = 0; i < mainCookieInputs.length; i++) {

                    if (this.dataset.property === mainCookieInputs[i].dataset.property) {
                        mainCookieInputs[i].checked = true
                    }
                }
            }


        })

    }





    if (document.getElementsByClassName('closeCookieSubOptions')[0]) {
        let closeCookieSubOptions = document.getElementsByClassName('closeCookieSubOptions')
        for (let i = 0; i < closeCookieSubOptions.length; i++) {
            closeCookieSubOptions[i].addEventListener('click', function () {
                this.parentElement.style.left = '-1000px'
                document.getElementsByClassName('closeCookie')[0].dataset.opened = '0'
            })

        }
    }

    if (document.getElementsByClassName('clickLabel')[0]) {
        let clickLabel = document.getElementsByClassName('clickLabel')
        for (let i = 0; i < clickLabel.length; i++) {
            clickLabel[i].addEventListener('click', function () {
                this.parentElement.getElementsByTagName('label')[0].click()
            })

        }
    }
    if (document.getElementsByClassName('cookieSubOptionsOpen')[0]) {
        let cookieSubOptionsOpen = document.getElementsByClassName('cookieSubOptionsOpen')
        for (let i = 0; i < cookieSubOptionsOpen.length; i++) {
            cookieSubOptionsOpen[i].addEventListener('click', function (e) {
                e.stopPropagation()
                let cookieSubOptions = document.getElementsByClassName('cookieSubOptions')
                for (let j = 0; j < cookieSubOptions.length; j++) {
                    if (cookieSubOptionsOpen[i].dataset.property === cookieSubOptions[j].dataset.property) {
                        cookieSubOptions[j].style.left = '0px'
                        document.getElementsByClassName('closeCookie')[0].dataset.opened = '1'
                    }

                }


            })

        }
    }


}


/***/ }),

/***/ "./src/assets/js/detectScrollDirection.js":
/*!************************************************!*\
  !*** ./src/assets/js/detectScrollDirection.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "scrollDirection": () => (/* binding */ scrollDirection)
/* harmony export */ });
let sliders = [document.getElementById('sliderDesktop-One'), document.getElementById('sliderDesktop-Two')/* , document.getElementById('sliderDesktop-Three') */]

window.scrollPos = 0;
window.scrolPositionHelperDirection = '';
window.scrolPositionHelper = 0;

function scrollDirection() {

    for (let i = 0; i < sliders.length; i++) {

        sliders[i].getElementsByClassName('owl-carousel')[0].addEventListener('mouseenter', scrollDirectionDetect, { passive: false });

    }
}

function scrollDirectionDetect(e) {

    this.addEventListener("wheel", detetctScrollUpDown, { passive: false });
    this.addEventListener('mouseleave', mouseLeaveEvent, { passive: false });

}



function detetctScrollUpDown(e) {

    e.preventDefault()
    e.stopPropagation()

    if (e.deltaY < 0) {


        if (window.scrolPositionHelperDirection === "down") {
            window.setOne = 0
            window.scrolPositionHelper = 0
            window.scrolPositionHelper++
            window.scrolPositionHelperDirection = "up"
        }

        if (window.scrolPositionHelper > 2) {

            window.scrolPositionHelper = 0
            selectCarousel(this)
        }
        window.scrolPositionHelper++
        window.scrolPositionHelperDirection = "up"
    }
    else if (e.deltaY > 0) {

        if (window.scrolPositionHelperDirection === "up") {
            window.setThree = 0
            window.scrolPositionHelper = 0
            window.scrolPositionHelper++
            window.scrolPositionHelperDirection = "down"
        }

        if (window.scrolPositionHelper > 2) {

            selectCarousel(this)
            window.scrolPositionHelper = 0
        }
        window.scrolPositionHelper++
        window.scrolPositionHelperDirection = "down"
    }

}
window.setOne = 0
window.setThree = 0

function selectCarousel(x) {

    switch (x.id) {
        case 'slider-one':
            if (window.scrolPositionHelperDirection === "up") {

                jQuery('#slider-one').trigger('prev.owl');
                if (document.getElementById('carousel-one').getElementsByClassName('one')[0].className.indexOf('active') !== -1) {

                    window.setOne++
                    if (window.setOne > 2) {
                        document.getElementById('slider-one').removeEventListener('mouseleave', mouseLeaveEvent, { passive: false })
                        document.getElementById('slider-one').removeEventListener("wheel", detetctScrollUpDown, { passive: false });
                        window.setOne = 0
                    }

                }

            } else if (window.scrolPositionHelperDirection === "down") {

                jQuery('#slider-one').trigger('next.owl');
                if (document.getElementById('carousel-one').getElementsByClassName('three')[0].className.indexOf('active') !== -1) {

                    window.setThree++

                    if (window.setThree > 2) {
                        document.getElementById('slider-one').removeEventListener('mouseleave', mouseLeaveEvent, { passive: false })
                        document.getElementById('slider-one').removeEventListener("wheel", detetctScrollUpDown, { passive: false });
                        window.setThree = 0
                    }
                }
            }
            break
        case 'slider-two':
            if (window.scrolPositionHelperDirection === "up") {

                jQuery('#slider-two').trigger('prev.owl');
                if (document.getElementById('carousel-two').getElementsByClassName('one')[0].className.indexOf('active') !== -1) {

                    window.setOne++
                    if (window.setOne > 2) {
                        document.getElementById('slider-two').removeEventListener('mouseleave', mouseLeaveEvent, { passive: false })
                        document.getElementById('slider-two').removeEventListener("wheel", detetctScrollUpDown, { passive: false });
                        window.setOne = 0
                    }

                }
            } else if (window.scrolPositionHelperDirection === "down") {

                jQuery('#slider-two').trigger('next.owl');
                if (document.getElementById('carousel-two').getElementsByClassName('three')[0].className.indexOf('active') !== -1) {

                    window.setThree++

                    if (window.setThree > 2) {
                        document.getElementById('slider-two').removeEventListener('mouseleave', mouseLeaveEvent, { passive: false })
                        document.getElementById('slider-two').removeEventListener("wheel", detetctScrollUpDown, { passive: false });
                        window.setThree = 0
                    }
                }
            }
            break
        case 'testimonial':
            if (window.scrolPositionHelperDirection === "up") {

                jQuery('#testimonial').trigger('prev.owl');
                if (document.getElementsByClassName('firster')[0].parentNode.className.indexOf('active') !== -1) {

                    window.setThree++

                    if (window.setThree > 2) {
                        document.getElementById('testimonial').removeEventListener('mouseleave', mouseLeaveEvent, { passive: false })
                        document.getElementById('testimonial').removeEventListener("wheel", detetctScrollUpDown, { passive: false });
                        window.setThree = 0
                    }
                }
            } else if (window.scrolPositionHelperDirection === "down") {

                jQuery('#testimonial').trigger('next.owl');
                if (document.getElementsByClassName('laster')[0].parentNode.className.indexOf('active') !== -1) {

                    window.setThree++

                    if (window.setThree > 2) {
                        document.getElementById('testimonial').removeEventListener('mouseleave', mouseLeaveEvent, { passive: false })
                        document.getElementById('testimonial').removeEventListener("wheel", detetctScrollUpDown, { passive: false });
                        window.setThree = 0
                    }
                }

            }
    }

}

function mouseLeaveEvent(e) {
    e.target.removeEventListener('mouseleave', mouseLeaveEvent, { passive: false })
    e.target.removeEventListener("wheel", detetctScrollUpDown, { passive: false });
}



/***/ }),

/***/ "./src/assets/js/inputRange.js":
/*!*************************************!*\
  !*** ./src/assets/js/inputRange.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "inputRange": () => (/* binding */ inputRange)
/* harmony export */ });
/**
 * Sniffs for Older Edge or IE,
 * more info here:
 * https://stackoverflow.com/q/31721250/3528132
 */
function isOlderEdgeOrIE() {
    return (
      window.navigator.userAgent.indexOf("MSIE ") > -1 ||
      !!navigator.userAgent.match(/Trident.*rv\:11\./) ||
      window.navigator.userAgent.indexOf("Edge") > -1
    );
  }

  function valueTotalRatio(value, min, max) {
    return ((value - min) / (max - min)).toFixed(2);
  }

  function getLinearGradientCSS(ratio, leftColor, rightColor) {

    return [
      '-webkit-gradient(',
      'linear, ',
      'left top, ',
      'right top, ',
      'color-stop(' + ratio + ', ' + leftColor + '), ',
      'color-stop(' + ratio + ', ' + rightColor + ')',
      ')'
    ].join('')

  }

  function updateRangeEl(rangeEl) {

    var ratio = valueTotalRatio(rangeEl.value, rangeEl.min, rangeEl.max);
    rangeEl.style.backgroundImage = getLinearGradientCSS(ratio, '#ffffff', '#8e949f');

  }

  function inputRange() {
    let rangeInput = document.getElementsByClassName('rangeInput')

    for(let i =0; i<rangeInput.length; i++){

      let rangeEl = rangeInput[i].querySelector('input[type=range]');
      let textEl = rangeInput[i].querySelector('input[type=text]');

      /**
       * IE/Older Edge FIX
       * On IE/Older Edge the height of the <input type="range" />
       * is the whole element as oposed to Chrome/Moz
       * where the height is applied to the track.
       *
       */
      if (isOlderEdgeOrIE()) {
        rangeEl.style.height = "20px";
        // IE 11/10 fires change instead of input
        // https://stackoverflow.com/a/50887531/3528132
        rangeEl.addEventListener("change", function(e) {
          textEl.value = e.target.value;
        }, {passive:true});
        rangeEl.addEventListener("input", function(e) {
          textEl.value = e.target.value;
        }, {passive:true});
      } else {
        updateRangeEl(rangeEl);
        rangeEl.addEventListener("input", function(e) {
          updateRangeEl(e.target);
          textEl.value = e.target.value;
        }, {passive:true});
      }
    }
  }


/***/ }),

/***/ "./src/assets/js/isComponentPresentChecker.js":
/*!****************************************************!*\
  !*** ./src/assets/js/isComponentPresentChecker.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "isPresent": () => (/* binding */ isPresent)
/* harmony export */ });
/* harmony import */ var _scroll_to_top_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./scroll-to-top.js */ "./src/assets/js/scroll-to-top.js");
/* harmony import */ var _cookieNotice_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./cookieNotice.js */ "./src/assets/js/cookieNotice.js");
/* harmony import */ var _comunicationControler_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./comunicationControler.js */ "./src/assets/js/comunicationControler.js");






function isPresent() {


    if (document.getElementsByClassName('languageCell')[0]) {
        loadScript('/frontend/assets/js/LanguageMenu.js' + version, function () {

        }, 'module')
    }


    if (document.getElementsByClassName('ptbo')[0]) {
        loadScript('/frontend/assets/js/TopHeader.js' + version, function () {

        }, 'module')
    }

    if (document.getElementsByClassName('jtc2_submit')[0]) {
        let jtc_submits = document.getElementsByClassName('jtc2_submit')
        for (let i = 0; i < jtc_submits.length; i++) {

            jtc_submits[i].addEventListener('click', function () {


                jtc2StepComplete(this.dataset.step, this.dataset.redirect)


            })

        }
    }

    if (document.getElementById('cancelRemovingCourse')) {
        document.getElementById('cancelRemovingCourse').addEventListener('click', function () {
            closePopup('deleteTalkPopup');
        });
    }


    if (document.getElementsByClassName('addGroupTalkTalksAndAva')[0]) {
        document.getElementsByClassName('addGroupTalkTalksAndAva')[0].addEventListener('click', function () {

            window.clickedEdit = 0

            clearGroupForm(document.getElementById('group-talk-form'))

            let app_talk_categories = JSON.parse(localStorage.getItem('app_talk_categories_' + getCookie('activeLang')))
            let data = app_talk_categories.talk_categories.data

            inputGroupCategories()

            select_group_category_input_and_select_subcategory(data, 1, getCategoryLanguageId())

            inputGroupLanguages()

            select_group_language(getLanguageId())

            document.getElementById('group-talk-form').getElementsByClassName('pauseWrap')[0].classList.add('dn')
            document.getElementById('group-talk-form').elements['talkIdG'].value = ''

            document.getElementById('talkInputG').focus()

            document.getElementById('groupSubmit').parentElement.parentElement.classList.add('dn')
            document.getElementById('groupSubmit').textContent = getPoTranslate('ADD_GALLERY_TALK')
            let pageTitlePoperAva = document.getElementById('addGroupTalk').getElementsByClassName('pageTitlePoperAva')

            for (let i = 0; i < pageTitlePoperAva.length; i++) {
                pageTitlePoperAva[i].textContent = getPoTranslate('ADD_GALLERY_TALK')
            }

            document.getElementById('group-talk-form').getElementsByClassName('deleteTalkButtoner')[0].classList.add('dn')

            document.getElementById('jtc_add_gallery_talk_description').classList.remove('dn')
            document.getElementById('jtc_edit_gallery_talk_description').classList.add('dn')


        })
    }

    if (document.getElementsByClassName('addPrivateTalk')[0]) {
        document.getElementsByClassName('addPrivateTalk')[0].addEventListener('click', function () {

            window.clickedEdit = 0

            clearForm(document.getElementById('private-talk-form'))

            let app_talk_categories = JSON.parse(localStorage.getItem('app_talk_categories_' + getCookie('activeLang')))
            let data = app_talk_categories.talk_categories.data

            inputCategories()


            select_category_input_and_select_subcategory(data, 1, getCategoryLanguageId())

            inputLanguages()

            select_language(getLanguageId())

            document.getElementsByClassName('addNewTalkDescription')[0].classList.remove('dn')
            document.getElementsByClassName('editnewTalkDescription')[0].classList.add('dn')
            document.getElementsByClassName('pauseWrap')[0].classList.add('dn')
            document.getElementById('privateSubmit').classList.add('dn')
            document.getElementById('privateSubmit').textContent = getPoTranslate('ADD_PRIVATE_TALK')
            document.getElementsByClassName('pageTitlePoperAva').textContent = getPoTranslate('ADD_PRIVATE_TALK')



        })
    }

    window.jtc2StepComplete = function (step, redirect) {
        let xhr = new XMLHttpRequest()


        let url = envAppBackendUrl + '/jtc/complete'

        let params = {

            'step': parseInt(step)
        }

        xhr.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.response)

                if (response.success === true) {
                    showLoading()
                    location.assign(redirect)
                } else if (response.success === false) {
                    toastify(response.message)
                }



            }
        }

        xhr.onerror = function (error) {

            toastify(this.statusText)
            Sentry.captureException(new RemoveSocialVerify(error + 'status: ' + this
                .statusText +
                '|| response: ' + this.statusText + ' || url: ' + location.href));
        }

        xhr.open('POST', url, true)
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('Authorization', bearerToken)


        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))
        xhr.setRequestHeader('Content-Type', 'application/json')




        xhr.send(JSON.stringify(params))
    }

    //social verificaiton flow

    if (document.getElementsByClassName('removeSocialVerification')[0]) {
        let removeSocialVerification = document.getElementsByClassName('removeSocialVerification')

        for (let i = 0; i < removeSocialVerification.length; i++) {
            removeSocialVerification[i].addEventListener('click', function (e) {
                let that = this
                e.preventDefault()
                showLoading()
                let xhr = new XMLHttpRequest()


                let url = '/delete/social/verification'

                let params = {
                    '_token': token,
                    'socialVerifyId': that.dataset.verifiedId
                }

                xhr.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {
                        let response = JSON.parse(this.response)

                        if (response.success === true) {
                            toastify(response.message)

                            that.parentElement.parentElement.parentElement.style.cssText = 'transition:0.3s; scale:(0); opacity:0;'
                            setTimeout(function () {
                                that.parentElement.parentElement.parentElement.remove()
                            }, 310)
                            calculatePopUpHeight(document.getElementById('social_verify'), 52)
                        } else if (response.success === false) {
                            toastify(response.message)
                        }


                        hideLoading()
                    }
                }

                xhr.onloadend = function () {
                    hideLoading()
                }

                xhr.onerror = function (error) {
                    hideLoading()
                    toastify(this.statusText)
                    Sentry.captureException(new RemoveSocialVerify(error + 'status: ' + this
                        .statusText +
                        '|| response: ' + this.statusText + ' || url: ' + location.href));
                }

                xhr.open('POST', url, true)
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.setRequestHeader('Authorization', bearerToken)
                xhr.setRequestHeader('X-CSRF-TOKEN', token)

                xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))
                xhr.setRequestHeader('Content-Type', 'application/json')




                xhr.send(JSON.stringify(params))




            })

        }






        class RemoveSocialVerify extends Error {
            constructor(message) {
                super(message)
                this.name = "RemoveSocialVerify"
            }
        }
    }

    // calendar flow
    if (document.getElementsByClassName('removeCalendar')[0]) {

        let removeCalendar = document.getElementsByClassName('removeCalendar')

        for (let i = 0; i < removeCalendar.length; i++) {
            removeCalendar[i].addEventListener('click', function (e) {
                e.preventDefault()
                showLoading()
                let xhr = new XMLHttpRequest()
                let url = envAppBackendUrl + '/disconnect-calendar/' + e.currentTarget.dataset.calendarId

                let params = {
                    '_token': token
                }

                xhr.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {
                        let response = JSON.parse(this.response)

                        if (response.success === true) {
                            toastify(response.message)

                            removeCalendar[i].parentElement.parentElement.style.cssText = 'transition:0.3s; scale:(0); opacity:0;'
                            setTimeout(function () {
                                removeCalendar[i].parentElement.parentElement.remove()

                                let rCalendar = document.getElementsByClassName('removeCalendar')

                                if (rCalendar.length === 1) {
                                    rCalendar[0].classList.remove('dn')
                                }

                            }, 310)
                        } else if (response.success === false) {
                            toastify(response.message)
                        }


                        hideLoading()
                    }
                }

                xhr.onloadend = function () {
                    hideLoading()
                }

                xhr.onerror = function (error) {
                    hideLoading()
                    toastify(this.statusText)
                    Sentry.captureException(new RemoveCalendarError(error + 'status: ' + this
                        .statusText +
                        '|| response: ' + this.statusText + ' || url: ' + location.href));
                }

                xhr.open('POST', url, true)
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.setRequestHeader('Authorization', bearerToken)
                xhr.setRequestHeader('X-CSRF-TOKEN', token)

                xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))
                xhr.setRequestHeader('Content-Type', 'application/json')




                xhr.send(JSON.stringify(params))




            })

        }






        class RemoveCalendarError extends Error {
            constructor(message) {
                super(message)
                this.name = "RemoveCalendarError"
            }
        }
    }

    if (document.getElementsByClassName('scrollToTopArrow')[0]) {
        document.getElementsByClassName('scrollToTopArrow')[0].addEventListener('click', function () {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        })
    }

    if (document.getElementsByClassName('unblockUser')[0]) {

        let unblockUser = document.getElementsByClassName('unblockUser')

        for (let i = 0; i < unblockUser.length; i++) {

            unblockUser[i].addEventListener('click', function (e) {
                e.preventDefault()
                showLoading()
                let xhr = new XMLHttpRequest()
                let url = envAppBackendUrl + '/user-unblock'

                let params = {
                    '_token': token,
                    'teacher_id': parseInt(e.currentTarget.dataset.userId)
                }

                xhr.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {
                        let response = JSON.parse(this.response)

                        if (response.success === true) {
                            toastify(response.message)

                            let parent = unblockUser[i].parentElement.parentElement.parentElement
                            parent.style.scale = '0'
                            parent.style.opacity = '0'
                            setTimeout(function () {
                                parent.remove()

                                if (!document.getElementById('blockedUsersPopup').getElementsByClassName('followRequestContainer')[0]) {

                                    closePopup('blockedUsersPopup')
                                    let showBlockUserPopupButton = document.getElementById('showBlockUserPopupButton')
                                    showBlockUserPopupButton.style.scale = '0'
                                    setTimeout(function () {
                                        showBlockUserPopupButton.remove()

                                    }, 310)
                                }
                            }, 310)

                        } else if (response.success === false) {
                            toastify(response.message)
                        }


                        hideLoading()
                    }
                }

                xhr.onloadend = function () {
                    hideLoading()
                }

                xhr.onerror = function (error) {
                    hideLoading()
                    toastify(this.statusText)
                    Sentry.captureException(new SubmitRemovePrivateFallowing(error + 'status: ' + this
                        .statusText +
                        '|| response: ' + this.statusText + ' || url: ' + location.href));
                }

                xhr.open('POST', url, true)
                xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.setRequestHeader('Authorization', bearerToken)
                xhr.setRequestHeader('X-CSRF-TOKEN', token)

                xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

                xhr.send(JSON.stringify(params))
            })

        }



        class SubmitRemovePrivateFallowing extends Error {
            constructor(message) {
                super(message)
                this.name = "SubmitRemovePrivateFallowing"
            }
        }
    }

    // redirect after adding paypall flow
    let queryString = window.location.search
    let urlParams = new URLSearchParams(queryString)
    let code = urlParams.get('code')

    if (code) {
        if (
            document.body.className === 'settings_wallets' ||
            document.body.className === 'book_slot_payment' ||
            document.body.className === 'video_conference'
        ) {
            history.pushState({}, document.title, location.origin + location.pathname)
        }
    }


    //private fallow & regular fallow settings flow

    //CancelPendingFallowingRequestUser on 'settings_profile' page and 'settings_following' page
    if (document.getElementsByClassName('cancelRequest')[0]) {
        if (document.body.className === 'settings_profile' || document.body.className === 'settings_following') {
            let cancelRequest = document.getElementsByClassName('cancelRequest')

            for (let i = 0; i < cancelRequest.length; i++) {

                cancelRequest[i].addEventListener('click', function (e) {
                    e.preventDefault()
                    showLoading()
                    let xhr = new XMLHttpRequest()
                    let url = envAppBackendUrl + '/cancel-follow-request/' + e.currentTarget.dataset.user

                    let params = {
                        '_token': token
                    }
                    let that = this
                    xhr.onreadystatechange = function () {

                        if (this.readyState == 4 && this.status == 200) {
                            let response = JSON.parse(this.response)

                            if (response.success === true) {
                                toastify(response.message)

                                let parent = cancelRequest[i].parentElement.parentElement.parentElement
                                parent.style.scale = '0'
                                parent.style.opacity = '0'
                                setTimeout(function () {
                                    parent.remove()
                                }, 310)

                            } else if (response.success === false) {
                                toastify(response.message)
                            }


                            hideLoading()
                        }
                    }

                    xhr.onloadend = function () {
                        hideLoading()
                    }

                    xhr.onerror = function (error) {
                        hideLoading()
                        toastify(this.statusText)
                        Sentry.captureException(new CancelPendingFallowingRequestUser(error + 'status: ' + this
                            .statusText +
                            '|| response: ' + this.statusText + ' || url: ' + location.href));
                    }

                    xhr.open('POST', url, true)

                    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
                    xhr.setRequestHeader('Authorization', bearerToken)
                    xhr.setRequestHeader('X-CSRF-TOKEN', token)

                    xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

                    xhr.send(JSON.stringify(params))
                })

            }
        }




        class CancelPendingFallowingRequestUser extends Error {
            constructor(message) {
                super(message)
                this.name = "CancelPendingFallowingRequestUser"
            }
        }
    }






    if (document.getElementsByClassName('removeFollower')[0]) {
        let removeFolower = document.getElementsByClassName('removeFollower')

        for (let i = 0; i < removeFolower.length; i++) {

            removeFolower[i].addEventListener('click', function (e) {
                e.preventDefault()
                showLoading()
                let xhr = new XMLHttpRequest()
                let url = envAppBackendUrl + '/cancel-follow-request/' + e.currentTarget.dataset.userId

                let params = {
                    '_token': token
                }
                let that = this
                xhr.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {
                        let response = JSON.parse(this.response)

                        if (response.success === true) {
                            toastify(response.message)

                            let parent = removeFolower[i].parentElement.parentElement.parentElement
                            parent.style.scale = '0'
                            parent.style.opacity = '0'
                            setTimeout(function () {
                                parent.remove()
                            }, 310)

                        } else if (response.success === false) {
                            toastify(response.message)
                        }


                        hideLoading()
                    }
                }

                xhr.onloadend = function () {
                    hideLoading()
                }

                xhr.onerror = function (error) {
                    hideLoading()
                    toastify(this.statusText)
                    Sentry.captureException(new SubmitAcceptPrivateFallowing(error + 'status: ' + this
                        .statusText +
                        '|| response: ' + this.statusText + ' || url: ' + location.href));
                }

                xhr.open('POST', url, true)

                xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
                xhr.setRequestHeader('Authorization', bearerToken)
                xhr.setRequestHeader('X-CSRF-TOKEN', token)

                xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

                xhr.send(JSON.stringify(params))
            })

        }
        class SubmitAcceptPrivateFallowing extends Error {
            constructor(message) {
                super(message)
                this.name = "SubmitAcceptPrivateFallowing"
            }
        }
    }

    if (document.getElementById('durationP')) {
        document.getElementById('durationP').addEventListener('input', function () {
            this.classList.add('ok')
        })
    }





    if (document.getElementsByClassName('closeAddTalkFunnel')[0]) {

        let closeSpanPupups = document.getElementsByClassName('closeAddTalkFunnel')

        for (let i = 0; i < closeSpanPupups.length; i++) {
            closeSpanPupups[i].addEventListener('click', function () {
                closePopup(this.getElementsByClassName('closeThisPopup')[0].dataset.close)
            })

        }


    }

    if (document.getElementsByClassName('closeAddTalkFunnel2')[0]) {
        document.getElementsByClassName('closeAddTalkFunnel2')[0].addEventListener('click', function () {
            showLoading()
            location.reload()
        })
    }

    if (document.getElementsByClassName('popuper2')[0]) {
        document.getElementsByClassName('popuper2')[0].parentElement.addEventListener('click', function () {
            showLoading()
            location.reload()
        })
    }

    if (document.getElementById('goBack2')) {
        document.getElementById('goBack2').addEventListener('click', function () {
            location.assign('/')
        })
    }

    if (document.getElementById('newFilterSubmit')) {
        window.newFilterIsOpened = 0
        window.filterOpened = 0
        let newFilterSubmit = document.getElementById('newFilterSubmit')
        if (document.getElementsByClassName('filterOpener')[0]) {

            document.getElementById('newFilterPopup').addEventListener('click', function () {
                document.getElementsByClassName('filterOpener')[0].dataset.opened = "0"
                closeNewFilter()
            })

            document.getElementsByClassName('filterOpener')[0].addEventListener('click', function () {

                if (window.newFilterIsOpened == "0") {

                    openNewFilter()

                } else if (window.newFilterIsOpened == "1") {

                    closeNewFilter()

                }

            })
        }

        window.openNewFilter = function () {

            openPopup('newFilterPopup')

            setTimeout(function () {
                document.getElementById('newFilterPopup').style.left = '0px'
            }, 81)
            setTimeout(function () {
                document.getElementById('newFilterPopup').getElementsByClassName('popuper')[0].style.left = '0px'
            }, 161)

            window.newFilterIsOpened = 1
        }

        window.closeNewFilter = function () {

            document.getElementById('newFilterPopup').getElementsByClassName('popuper')[0].style.left = '1000px'

            setTimeout(function () {
                closePopup('newFilterPopup')
            }, 160)
            setTimeout(function () {
                document.getElementById('newFilterPopup').style.left = '1000px'
            }, 80)

            document.getElementsByClassName('filterOpener')[0].dataset.opened = "0"
            window.newFilterIsOpened = 0
        }



        window.addEventListener('resize', function () {
            if (window.innerWidth > 767) {
                if (window.newFilterIsOpened == 1) {
                    closeNewFilter()
                    openFilter()

                }

            }
        })
    }

    if (document.getElementById('showMoreLanguagesButton')) {
        document.getElementById('showMoreLanguagesButton').addEventListener('click', function () {
            let hiddenCheckboxes = this.parentElement.getElementsByClassName('dno0s0')

            for (let i = 0; i < hiddenCheckboxes.length; i++) {
                hiddenCheckboxes[i].style.transitionDelay = i * 0.05 + 's'
                hiddenCheckboxes[i].classList.remove('dno0s0')
            }
        })
    }

    if (document.getElementsByClassName('lefterZGT')[0]) {
        document.getElementsByClassName('lefterZGT')[0].addEventListener('click', function () {
            closePopup('newFilterPopup')
            document.getElementsByClassName('filterOpener')[0].dataset.opened = '0'
        })
    }

    if (document.getElementsByClassName('filterTypeBadge')[0]) {

        let filterTypeBadge = document.getElementsByClassName('filterTypeBadge')
        for (let i = 0; i < filterTypeBadge.length; i++) {
            filterTypeBadge[i].addEventListener('click', function () {
                if (this.dataset.clicked === "0") {


                    this.classList.add('active')
                    this.dataset.clicked = 1
                } else if (this.dataset.clicked === "1") {

                    this.classList.remove('active')
                    this.dataset.clicked = 0

                }

            })

        }

    }

    if (document.getElementById('lengthAvailability')) {

        var owl1 = jQuery("#lengthAvailability");

        owl1.owlCarousel({
            margin: 4,
            dots: true,
            nav: false,
            items: 7
        });
        document.getElementById('lengthAvailability').style.opacity = '1'

        if (document.getElementsByClassName('filterLengthBadge')[0]) {

            let filterLengthBadge = document.getElementsByClassName('filterLengthBadge')
            for (let i = 0; i < filterLengthBadge.length; i++) {
                filterLengthBadge[i].addEventListener('click', function () {
                    if (this.dataset.checked === "0") {
                        this.classList.add('active')
                        this.dataset.checked = "1"
                    } else {
                        this.classList.remove('active')
                        this.dataset.checked = "0"
                    }

                })

            }
        }

    }

    if (document.getElementsByClassName('filterAvailability')[0]) {

        let filterAvailability = document.getElementsByClassName('filterAvailability')[0].getElementsByClassName('filterDayBadge')
        for (let i = 0; i < filterAvailability.length; i++) {
            filterAvailability[i].addEventListener('click', function () {
                if (this.dataset.checked === "0") {
                    this.classList.add('active')
                    this.dataset.checked = "1"
                } else {
                    this.classList.remove('active')
                    this.dataset.checked = "0"
                }

            })

        }
    }

    if (document.getElementsByClassName('burgerItemMenu')[0]) {
        document.getElementsByClassName('burgerItemMenu')[0].addEventListener('click', function () {
            if (this.dataset.opened === '0') {
                let appendStyle = document.createElement('div')
                appendStyle.id = 'appendStyle'
                appendStyle.innerHTML = '<style>.menuIcon:before{transform: translateY(6px) rotate(135deg)!important;}.menuIcon:after{transform: translateY(-6px) rotate(-135deg)!important;}.menuIcon div{transform: scale(0)!important;}</style>'

                document.body.append(appendStyle)

                document.getElementsByClassName('cs16')[0].style.right = '0px'


                this.dataset.opened = 1
            } else if (this.dataset.opened === '1') {

                document.getElementById('appendStyle').remove()
                document.getElementsByClassName('cs16')[0].style.right = '-250%'


                this.dataset.opened = 0
            }

        })
    }

    if (document.getElementsByClassName('cz')[0]) {
        let closePopupButtons = document.getElementsByClassName('cz')
        for (let i = 0; i < closePopupButtons.length; i++) {
            closePopupButtons[i].addEventListener('click', function () {
                if (this.dataset.closePopup) {
                    closePopup(this.dataset.closePopup)
                }
            })
        }
    }

    if (document.getElementsByClassName('chch')[0]) {
        let checkers = document.getElementsByClassName('chch')
        for (let i = 0; i < checkers.length; i++) {
            checkers[i].addEventListener('click', function () {

                if (this.dataset.checkedCheckbox === "0") {

                    this.dataset.checkedCheckbox = "1"
                    this.getElementsByClassName('afterCheck')[0].classList.add('checkedCheck')
                    this.getElementsByClassName('beforeCheck')[0].classList.add('backgroundCheckedCheck')

                } else {

                    this.dataset.checkedCheckbox = "0"
                    this.getElementsByClassName('afterCheck')[0].classList.remove('checkedCheck')
                    this.getElementsByClassName('beforeCheck')[0].classList.remove('backgroundCheckedCheck')

                }
            })
        }
    }

    if (document.getElementsByClassName('flash-message')[0]) {
        if (document.getElementsByClassName('flash-message')[0].getElementsByTagName('p')[0]) {
            if (document.getElementsByClassName('flash-message')[0].getElementsByTagName('p')[0].textContent.trim().length > 0) {
                getBackgroundColorOfFlashMesage(document.getElementsByClassName('flash-message')[0].getElementsByTagName('p')[0])

                document.getElementsByClassName('flash-message')[0].style.top = '0px'

                setTimeout(function () {
                    document.getElementsByClassName('flash-message')[0].style.top = '-200px'
                }, 8000)

            }
        }
    }

    function getBackgroundColorOfFlashMesage(flashMessagePTag) {

        if (flashMessagePTag.classList.contains('alert-info')) {
            flashMessagePTag.style.background = '#3e80af'
        } else if (flashMessagePTag.classList.contains('alert-success')) {
            flashMessagePTag.style.background = '#2a7749'
        } else if (flashMessagePTag.classList.contains('alert-warning')) {
            flashMessagePTag.style.background = '#f79317'
        } else if (flashMessagePTag.classList.contains('alert-danger')) {
            flashMessagePTag.style.background = '#f71717'
        }
    }



    if (document.getElementById('jtcCarousel')) {


        let jtcCarousel = document.getElementById('jtcCarousel')

        let jtcCarousel2 = jQuery("#jtcCarousel")

        jtcCarousel2.owlCarousel({

            dots: true,
            nav: false,
            stagePadding: 0,
            items: 1,
            onInitialized: counter,
            onTranslated: counter,
            onChanged: onChangedfunct

        })

        document.getElementsByClassName('nextCarousel')[0].addEventListener('click', function nextItem() {
            jtcCarousel2.trigger('next.owl.carousel')
        })

        function onChangedfunct(event) {

            var item = event.item.index + 1

            if (item === 3) {
                document.getElementsByClassName('nextCarousel')[0].style.display = 'none'
                document.getElementById('counter').style.display = 'none'
                if (document.getElementById('jtcCarousel').getElementsByClassName('owl-dots')[0]) {
                    document.getElementById('jtcCarousel').getElementsByClassName('owl-dots')[0].style.display = 'none'
                }

                document.getElementsByClassName('blueButton')[0].style.display = 'block'

            } else {
                document.getElementsByClassName('nextCarousel')[0].style.display = 'block'
                document.getElementById('counter').style.display = 'block'
                if (document.getElementById('jtcCarousel').getElementsByClassName('owl-dots')[0]) {
                    document.getElementById('jtcCarousel').getElementsByClassName('owl-dots')[0].style.display = 'block'
                }
                document.getElementsByClassName('blueButton')[0].style.display = 'none'

            }
        }

        function counter(event) {

            var items = event.item.count
            var item = event.item.index + 1

            if (item > items) {
                item = item - items
            }
            document.getElementById('counter').textContent = item + "|" + items

        }
        jtcCarousel.style.opacity = '1'
        jtcCarousel.style.height = 'auto'
        document.getElementsByClassName('nextCarousel')[0].style.display = 'block'

    }

    if (document.getElementById('otherTeachersCarousel')) {

        let testimonialAboutMeProfile = document.getElementById('otherTeachersCarousel')


        var owl1 = jQuery(testimonialAboutMeProfile)

        owl1.owlCarousel({
            margin: 20,
            dots: false,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1024: {
                    items: 3
                }
            }
        })

        testimonialAboutMeProfile.style.opacity = '1'
        testimonialAboutMeProfile.getElementsByClassName('owl-nav')[0].classList.remove('disabled')

    }

    if (document.getElementById('testimonialAboutMeProfile')) {

        let testimonialAboutMeProfile = document.getElementById('testimonialAboutMeProfile')


        var owl1 = jQuery(testimonialAboutMeProfile)

        owl1.owlCarousel({
            margin: 20,
            dots: false,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1024: {
                    items: 3
                }
            }
        })

        testimonialAboutMeProfile.style.opacity = '1'


    }

    if (document.getElementsByClassName('testimonialAboutMe')[0]) {
        if (document.body.className !== 'profile') {
            let testimonialAboutMe = document.getElementsByClassName('testimonialAboutMe')
            for (let i = 0; i < testimonialAboutMe.length; i++) {

                var owl1 = jQuery(testimonialAboutMe[i])

                owl1.owlCarousel({
                    margin: 20,
                    dots: true,
                    nav: false,

                    responsive: {
                        0: {
                            items: 1
                        },
                        320: {
                            items: 2
                        },
                        1024: {
                            items: 3
                        },
                        1200: {
                            items: 4
                        }
                    }
                })

                testimonialAboutMe[i].style.opacity = '1'
            }
        }


    }

    if (document.getElementById('showMoreDesc')) {
        showMoreThreeDots()
    }


    if (document.getElementsByClassName('bMySlotsButtons')[0]) {
        loadScript('/frontend/assets/js/bookButton.js' + version, function () {

            /*    profileCourses2()
               window.addEventListener("resize", profileCourses2);

               function profileCourses2() {


                   if (window.innerWidth < 768) {
                       if (document.getElementsByClassName('privateC')[0].style.left === '0%' || document.getElementsByClassName('privateC')[0].style.left === '') {

                           document.getElementsByClassName('gropings')[0].style.height = 73 + document.getElementsByClassName('privateC')[0].offsetHeight + 'px'
                       } else {

                           document.getElementsByClassName('gropings')[0].style.height = 73 + document.getElementsByClassName('groupC')[0].offsetHeight + 'px'
                       }
                   }
                   else if (window.innerWidth > 767) {
                       if (document.getElementsByClassName('privateC')[0].style.left === '0%' || document.getElementsByClassName('privateC')[0].style.left === '') {

                           document.getElementsByClassName('gropings')[0].style.height = 73 + document.getElementsByClassName('privateC')[0].offsetHeight + 'px'
                       } else {

                           document.getElementsByClassName('gropings')[0].style.height = document.getElementsByClassName('bMySlotsButtons')[0].offsetHeight + document.getElementsByClassName('groupC')[0].offsetHeight + 'px'
                       }
                   }

               } */
        });
    }

    if (document.getElementsByClassName('copyText')[0]) {

        let copyTexts = document.getElementsByClassName('copyText')
        for (let i = 0; i < copyTexts.length; i++) {
            copyTexts[i].addEventListener('click', function copyTextToClipboard() {
                let copyText = this.parentElement.getElementsByTagName('input')[0]

                copyText.select();
                copyText.setSelectionRange(0, 99999)

                try {
                    navigator.clipboard.writeText(copyText.value);
                    toastify(getPoTranslate('COPIED_TO_CLIPBOARD'))

                } catch (error) {

                    Sentry.captureException(new TryCatchCopyURLPathError(err));

                }
            })

        }

        class TryCatchCopyURLPathError extends Error {
            constructor(message) {
                super(message)
                this.name = "TryCatchCopyURLPathError"
            }
        }


    }



    if (document.getElementsByClassName('backButtonings')[0]) {
        let backButtonings = document.getElementsByClassName('backButtonings')
        for (let i = 0; i < backButtonings.length; i++) {
            backButtonings[i].addEventListener('click', function () {
                history.back()
            })
        }
    }

    if (document.getElementsByClassName('backButtonings2')[0]) {
        let backButtonings = document.getElementsByClassName('backButtonings2')
        for (let i = 0; i < backButtonings.length; i++) {
            backButtonings[i].addEventListener('click', function () {
                closePopup(this.dataset.close)
            })
        }
    }

    if (document.getElementById('loadingCanvas')) {
        processLoading(document.getElementById('loadingCanvas'))
    }

    if (document.getElementById('loadingCanvas2')) {

        processLoading(document.getElementById('loadingCanvas2'))

    }




    if (document.getElementById('loadingCanvas8')) {

        processLoading(document.getElementById('loadingCanvas8'))
    }

    function processLoading(element) {
        let c = element,
            ctx = c.getContext('2d'),
            pi = Math.PI,
            xCenter = c.width / 2,
            yCenter = c.height / 2,
            radius = c.width / 6,
            startSize = radius / 6,
            num = 9,
            posX = [],
            posY = [],
            angle, size, i
        window.setInterval(function () {
            num++
            ctx.clearRect(0, 0, xCenter * 2, yCenter * 2)
            for (i = 0; i < 9; i++) {
                ctx.beginPath()
                ctx.fillStyle = 'rgba(255, 184, 5,.' + i + ')'
                if (posX.length == i) {
                    angle = pi * i * .25
                    posX[i] = xCenter + radius * Math.cos(angle)
                    posY[i] = yCenter + radius * Math.sin(angle)
                }
                ctx.arc(
                    posX[(i + num) % 8],
                    posY[(i + num) % 8],
                    startSize / 9 * i,
                    0, pi * 2, 1)
                ctx.fill()
            }
        }, 50)

    }



    if (document.getElementsByClassName('date_range')[0]) {
        let date_rage = document.getElementsByClassName('date_range')
        loadScript('/frontend/assets/js/lib/hammer.js' + version, function () {

            loadScript('/frontend/assets/js/lib/hammer.fakemultitouch.js' + version, function () {
                loadCss('/frontend/assets/css/drum.css' + version)
                loadScript('/frontend/assets/js/drum.js' + version, function () {
                    function fromHourChange(x) {
                        document.getElementById('fromHours').textContent = x.value
                    }

                    function fromMinuteChange(x) {
                        document.getElementById('fromMinutes').textContent = x.value
                    }

                    function toHourChange(x) {
                        document.getElementById('toHours').textContent = x.value
                    }

                    function toMinuteChange(x) {
                        document.getElementById('toMinutes').textContent = x.value
                    }

                    function pad(number) {
                        if (number < 10) {
                            return '0' + number;
                        }
                        return number;
                    }

                    function update(section, datetime) {

                        jQuery("#" + section + "_hours").drum('setIndex', datetime.getHours());
                        jQuery("#" + section + "_minutes").drum('setIndex', datetime.getMinutes());
                    }

                    let dates = document.getElementsByClassName('date')

                    jQuery(dates).drum({
                        onChange: function (elem) {
                            var section = elem.name.substr(0, elem.name.indexOf("_"));
                            var arr = {
                                'hours': 'setHours',
                                'minutes': 'setMinutes'
                            };
                            var date = new Date();
                            for (var s in arr) {
                                var i = (jQuery("form[name='date_" + section + "'] select[name='" + section + "_" + s + "']"))[0].value;
                                eval("date." + arr[s] + "(" + i + ")");
                            }
                            date.setSeconds(0);
                            update(section, date);

                            var format = pad(date.getHours()) + ':' + pad(date.getMinutes());

                            jQuery('.date_range_' + section + '_header .selection').html(format);
                        }
                    })

                    setTimeout(function () {
                        if (document.getElementById('time-slot-popup')) {
                            setDrums(document.getElementById('time-slot-popup'), '10', '00', '11', '00')
                        }
                        if (document.getElementById('group-talk-form')) {
                            setDrums(document.getElementById('group-talk-form'), '10', '00', '11', '00')
                        }
                    })

                    /* jQuery("select.date").drum({
                        onChange: function (elem) {
                            var section = elem.name.substr(0, elem.name.indexOf("_"));
                            var arr = {
                                'hours': 'setHours',
                                'minutes': 'setMinutes'
                            };
                            var date = new Date();
                            for (var s in arr) {
                                var i = (jQuery("form[name='date_" + section + "'] select[name='" + section + "_" + s + "']"))[0].value;
                                eval("date." + arr[s] + "(" + i + ")");
                            }
                            date.setSeconds(0);
                            update(section, date);

                            var format = pad(date.getHours()) + ':' + pad(date.getMinutes());

                            jQuery('.date_range_' + section + '_header .selection').html(format);
                        }
                    }); */
                    if (document.getElementById('time-slot-popup')) {
                        /* document.getElementById('time-slot-popup').getElementsByClassName('popuper')[0].addEventListener('mouseenter', disableScroll)
                        document.getElementById('time-slot-popup').getElementsByClassName('popuper')[0].addEventListener('mouseleave', enableScroll) */
                    }

                    function disableScroll() {
                        window.addEventListener('DOMMouseScroll', preventDefault, false); // older FF
                        window.addEventListener(wheelEvent, preventDefault, wheelOpt); // modern desktop
                        window.addEventListener('touchmove', preventDefault, wheelOpt); // mobile
                        //window.addEventListener('keydown', preventDefaultForScrollKeys, false);
                    }

                    // call this to Enable
                    function enableScroll() {
                        window.removeEventListener('DOMMouseScroll', preventDefault, false);
                        window.removeEventListener(wheelEvent, preventDefault, wheelOpt);
                        window.removeEventListener('touchmove', preventDefault, wheelOpt);
                        //window.removeEventListener('keydown', preventDefaultForScrollKeys, false);
                    }

                    function preventDefault(e) {
                        e.preventDefault();
                    }

                    function preventDefaultForScrollKeys(e) {
                        if (keys) {


                            if (keys[e.keyCode]) {
                                preventDefault(e);
                                return false;
                            }
                        }
                    }

                    // modern Chrome requires { passive: false } when adding event
                    var supportsPassive = false;
                    try {
                        window.addEventListener("test", null, Object.defineProperty({}, 'passive', {
                            get: function () {
                                supportsPassive = true;
                            }
                        }));
                    } catch (e) { }

                    var wheelOpt = supportsPassive ? {
                        passive: false
                    } : false;
                    var wheelEvent = 'onwheel' in document.createElement('div') ? 'wheel' : 'mousewheel';

                    let rollers = document.getElementsByClassName('rollers')

                    for (let i = 0; i < rollers.length; i++) {

                        rollers[i].addEventListener('mouseenter', disableScroll);

                        rollers[i].addEventListener('mouseleave', enableScroll);
                    }

                    function disableScroll2() {
                        // Get the current page scroll position
                        scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                        scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,

                            // if any scroll is attempted, set this to the previous value
                            window.onscroll = function () {
                                window.scrollTo(scrollLeft, scrollTop);
                            };
                    }

                    function enableScroll2() {
                        window.onscroll = function () { };
                    }
                })
            })
        })
        // for(let i = 0; i<date_rage.length; i++){

        // }

    }


    if (document.getElementsByClassName('popuper2')[0]) {
        document.getElementsByClassName('popuper2')[0].addEventListener('click', function (e) {
            e.preventDefault()
            e.stopPropagation()
        })
    }


    if (document.getElementsByClassName('drop-area')[0]) {
        loadScript('/frontend/assets/js/fileUpload.js' + version, function () {

            //this is function for simulating events on html elements
            //we using this function to trigger click on close icon on toastify notifications.
            //i didnt find in toastify documentation where is triggering of close event function, so i added this eventFire function to triger click on close icon
            if (document.getElementById('closeUploadPopup')) {
                document.getElementById('closeUploadPopup').addEventListener('click', function () {
                    eventFire(document.getElementById('uploadImagePopup').getElementsByClassName('closeSpanPopup')[0], 'click');
                })
            }

        })
    }

    if (document.getElementById('firstHeader')) {
        let heightBefore = document.getElementById('textCont').offsetHeight + 'px'

        document.getElementById('textCont').style.height = heightBefore

        if (document.getElementsByClassName('mt161res')[0]) {
            if (window.innerWidth < 768) {
                document.getElementsByClassName('mt161res')[0].style.marginTop = (document.getElementById('firstHeader').offsetHeight + 16) + 'px'
            }
        }

        var handleIntersection = function handleIntersection(entries) {

            entries.map(function (entry) {
                if (entry.isIntersecting) {

                    if (window.innerWidth < 768) {

                        document.getElementById('textCont').style.height = heightBefore
                        document.getElementById('firstHeader').style.height = (32 + 8 + document.getElementById('logoContainers').offsetHeight + document.getElementById('textCont').getElementsByTagName('h4')[0].offsetHeight + document.getElementById('textCont').getElementsByTagName('p')[0].offsetHeight) + 'px'

                        document.getElementById('firstHeader').style.boxShadow = 'none'


                        if (document.getElementsByClassName('ptbo')[0]) {
                            document.getElementById('firstHeader').style.top = '0px'



                        }
                    }

                } else {

                    if (window.innerWidth < 768) {

                        document.getElementById('textCont').style.height = '0px'
                        document.getElementById('firstHeader').style.height = (document.getElementById('logoContainers').offsetHeight + document.getElementById('textCont').offsetHeight + 32) + 'px'
                        document.getElementById('firstHeader').style.boxShadow = '0px 0px 8px -3px, inset 1px -2px 0 -1px rgba(6,4,3,.1)'



                        if (document.getElementsByClassName('ptbo')[0]) {
                            document.getElementById('firstHeader').style.top = '64px'
                        }
                    }
                }
            })
        }

        let targi

        if (document.body.className === 'jtc2_create_profile') {
            targi = document.getElementById('desktopUsername')
        } else if (document.body.className === 'jtc2_add_your_first_talk') {
            targi = document.getElementsByClassName('privateCourseItem')[0] || document.getElementById('intersectActivator')
        } else if (document.body.className === 'jtc2_set_availabilities') {
            targi = document.getElementById('intersectActivator').getElementsByClassName('date-wrap-content')[0]
        } else if (document.body.className === 'jtc2_verify_account') {
            targi = document.getElementById('verification-form')
        } else if (document.body.className === 'jtc2_account_created') {
            targi = document.getElementById('intersectActivator').getElementsByClassName('h3DownloadAppNow')[0]
        }

        var target = targi

        if (target) {
            var observer = new IntersectionObserver(handleIntersection);
            observer.observe(target);
        }



        const divElem = document.querySelector("body");

        const resizeObserver = new ResizeObserver((entries) => {
            for (const entry of entries) {
                if (entry.contentBoxSize) {

                    if (window.innerWidth > 767) {


                        document.getElementById('jtcStep1FormContainer') ? document.getElementById('jtcStep1FormContainer').style.marginTop = '0px' : document.getElementById('intersectActivator').style.marginTop = '0px'
                        let headerText = document.getElementById('textCont')
                        let elementalHeight = (headerText.getElementsByTagName('h4')[0].offsetHeight + headerText.getElementsByTagName('p')[0].offsetHeight + 8)

                        document.getElementById('firstHeader').style.height = (32 + document.getElementById('logoContainers').offsetHeight + elementalHeight) + 'px'

                        headerText.style.height = (headerText.getElementsByTagName('h4')[0].offsetHeight + headerText.getElementsByTagName('p')[0].offsetHeight + 8) + 'px'
                    } else if (window.innerWidth < 768) {


                        let headerText = document.getElementById('textCont')
                        let elementalHeight = (headerText.getElementsByTagName('h4')[0].offsetHeight + headerText.getElementsByTagName('p')[0].offsetHeight + 8)
                        headerText.style.height = elementalHeight + 'px'


                        document.getElementById('firstHeader').style.height = (32 + document.getElementById('logoContainers').offsetHeight + elementalHeight) + 'px'
                        document.getElementById('jtcStep1FormContainer') ? document.getElementById('jtcStep1FormContainer').style.marginTop = (8 + 32 + document.getElementById('logoContainers').offsetHeight + elementalHeight) + 'px' : document.getElementById('intersectActivator').style.marginTop = (8 + 32 + document.getElementById('logoContainers').offsetHeight + elementalHeight) + 'px'
                    }
                }
            }
        });

        resizeObserver.observe(divElem);

    }

    if (document.getElementById('webCamContTakePic')) {
        document.getElementsByClassName('takePictureWithWebCam')[0].addEventListener('click', function () {

            if (document.getElementsByClassName('icon-deletes')[0]) {
                let iconDeletes = document.getElementsByClassName('icon-deletes')
                for (let i = 0; i < iconDeletes.length; i++) {
                    iconDeletes[i].click()
                }
            }

            let width = 320
            let height = 0
            let streaming = false

            let video = document.getElementById('video')
            var canvas = document.getElementById('canvas')
            let photo = document.getElementById('photo')
            let photo2 = document.getElementById('photo2')
            let startbutton = document.getElementById('startbutton')

            const videoElement = document.getElementById('video')
            //const audioInputSelect = document.querySelector('select#audioSource')
            //const audioOutputSelect = document.getElementById('audioOutput')
            const videoSelect = document.getElementById('videoSource')
            const selectors = [ /*audioInputSelect, audioOutputSelect,*/ videoSelect]

            //audioOutputSelect.disabled = !('sinkId' in HTMLMediaElement.prototype)

            function gotDevices(deviceInfos) {
                // Handles being called several times to update labels. Preserve values.
                const values = selectors.map(select => select.value)

                selectors.forEach(select => {
                    while (select.firstChild) {
                        select.removeChild(select.firstChild)
                    }
                });

                for (let i = 0; i !== deviceInfos.length; ++i) {
                    const deviceInfo = deviceInfos[i]
                    const option = document.createElement('option')
                    option.value = deviceInfo.deviceId
                    /* if (deviceInfo.kind === 'audioinput') {
                        option.text = deviceInfo.label || `microphone ${audioInputSelect.length + 1}`;
                        audioInputSelect.appendChild(option);
                    } else if (deviceInfo.kind === 'audiooutput') {
                        option.text = deviceInfo.label || `speaker ${audioOutputSelect.length + 1}`
                        audioOutputSelect.appendChild(option)
                    } else */
                    if (deviceInfo.kind === 'videoinput') {
                        option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`
                        videoSelect.appendChild(option)
                    }
                }
                selectors.forEach((select, selectorIndex) => {
                    if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
                        select.value = values[selectorIndex]
                    }
                });
            }

            navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError)


            function gotStream(stream) {
                window.stream = stream // make stream available to console
                videoElement.srcObject = stream
                // Refresh button list in case labels have become available
                return navigator.mediaDevices.enumerateDevices()
            }

            function handleError(error) {
                toastify(error.message)
            }

            function start() {
                if (window.stream) {
                    window.stream.getTracks().forEach(track => {
                        track.stop()
                    });
                }
                //const audioSource = audioInputSelect.value;
                const videoSource = videoSelect.value;
                const constraints = {
                    audio: false,
                    video: { deviceId: videoSource ? { exact: videoSource } : undefined }
                };
                navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError)
            }

            //audioInputSelect.onchange = start;
            //audioOutputSelect.onchange = changeAudioDestination;

            videoSelect.onchange = start

            video.addEventListener('canplay', function () {
                if (!streaming) {
                    height = video.videoHeight / (video.videoWidth / width);

                    // Firefox currently has a bug where the height can't be read from
                    // the video, so we will make assumptions if this happens.

                    if (isNaN(height)) {
                        height = width / (4 / 3)
                    }
                    /*
                    video.setAttribute('width', width)
                    video.setAttribute('height', height) */
                    video.style.width = '100%'
                    video.style.height = '100%'
                    /*
                    canvas.setAttribute('width', width)
                    canvas.setAttribute('height', height) */
                    canvas.style.width = '100%'
                    canvas.style.height = '100%'
                    streaming = true;

                    calculatePopUpHeight(document.getElementById('takePictureWithWebCam'), 52)

                }
            }, false);

            if (typeof document.getElementById('startbutton').dataset.event === 'undefined') {
                document.getElementById('startbutton').dataset.event = 1
                startbutton.addEventListener('click', takePhotoEvent, false)
            }


            function takePhotoEvent(e) {
                e.currentTarget.dataset.event = 1


                takepicture()
                e.preventDefault()

            }

            function clearphoto(e) {

                var context = canvas.getContext('2d')
                context.fillStyle = "#AAA"
                context.fillRect(0, 0, canvas.width, canvas.height)

                var data = canvas.toDataURL('image/jpeg')
                photo.setAttribute('src', data)
            }

            function takePictureHelper(e) {

                e.currentTarget.dataset.event = 1
                showLoading()

                _comunicationControler_js__WEBPACK_IMPORTED_MODULE_2__.uploadFile(window.blobObj)

                window.blobObj = ''


                takePictureAgainFunction(e)

            }

            window.takePictureAgainFunction = function (e) {

                if (document.getElementsByClassName('takePictureAgain')[0]) {
                    let takePictureAgainButtons = document.getElementsByClassName('takePictureAgain')
                    for (let i = 0; i < takePictureAgainButtons.length; i++) {
                        takePictureAgainButtons[i].dataset.event = '0'
                    }
                }

                takePictureAgainHelper()

                start()

                setTimeout(function () {
                    calculatePopUpHeight(document.getElementById('takePictureWithWebCam'), 52)
                }, 310)

                if (window.cropper) {
                    for (let i = 0; i < window.cropper.length; i++) {
                        window.cropper[i].destroy()

                    }
                }
                clearAfterDestroyCropper()
            }

            window.takePictureAgainHelper = function () {

                document.getElementById('videoSourceSelect').classList.remove('dn')
                document.getElementById('videoSourceInput').classList.remove('dn')
                document.getElementById('takePhotoButton').classList.remove('dn')

                document.getElementById('submitButton').classList.add('dn')
                document.getElementById('takePictureAgain').classList.add('dn')
                document.getElementById('photo').src = ''
                document.getElementById('photo2').src = ''
                if (typeof document.getElementById('startbutton').dataset.event === 'undefined') {
                    document.getElementById('startbutton').dataset.event = 1
                    startbutton.addEventListener('click', takePhotoEvent)
                }
                window.blobObj = ''

            }

            // Capture a photo by fetching the current contents of the video
            // and drawing it into a canvas, then converting that to a PNG
            // format data URL. By drawing it on an offscreen canvas and then
            // drawing that to the screen, we can change its size and/or apply
            // other changes before drawing it.
            if (document.getElementsByClassName('webCampPopup')[0]) {
                let webCampPopups = document.getElementsByClassName('webCampPopup')
                for (let i = 0; i < webCampPopups.length; i++) {
                    webCampPopups[i].addEventListener('click', closeWebcam)
                }
            }

            function closeWebcam(e) {

                let webCampPopups = document.getElementsByClassName('webCampPopup')
                for (let i = 0; i < webCampPopups.length; i++) {
                    webCampPopups[i].removeEventListener('click', closeWebcam)
                }

                takePictureAgainHelper()

                if (e.target.classList.contains('closeSpanPopup')) {
                    e.target.parentElement.parentElement.getElementsByClassName('popuper')[0].style.transform = 'scale(0)'
                    e.target.parentElement.parentElement.style.opacity = '0'

                    setTimeout(function () {
                        e.target.parentElement.parentElement.style.display = 'none'
                        e.target.parentElement.parentElement.dataset.opened = "0"
                    }, 310)
                } else {
                    e.target.getElementsByClassName('popuper')[0].style.transform = 'scale(0)'
                    e.target.style.opacity = '0'

                    setTimeout(function () {
                        e.target.style.display = 'none'
                        e.target.dataset.opened = "0"
                    }, 310)
                }


                if (window.stream) {
                    window.stream.getTracks().forEach(track => {
                        track.stop();
                    });
                }
            }

            function takepicture() {


                var context = canvas.getContext('2d');
                if (width && height) {

                    canvas.width = document.getElementById('video').offsetWidth
                    canvas.height = document.getElementById('video').offsetHeight

                    context.drawImage(video, 0, 0, document.getElementById('video').offsetWidth, document.getElementById('video').offsetHeight);

                    canvas.toBlob(function (blob) {

                        var newImg = document.createElement('img'),
                            url = URL.createObjectURL(blob);

                        window.blobObj = blob

                        newImg.onload = function () {
                            // no longer need to read the blob so it's revoked
                            URL.revokeObjectURL(url);
                        }

                        photo2.setAttribute('src', url);



                        let croppero = new Cropper(document.getElementById('photo2'), {
                            aspectRatio: 1 / 1,
                            minCropBoxWidth: 300,
                            minCropBoxHeight: 300,
                            crop(event) {

                                let kr = croppero.getCroppedCanvas()

                                if (kr) {
                                    let initialAvatarURL = kr.toBlob(function (blobObject) {

                                        window.blobObj = blobObject
                                    })
                                }





                            },
                        })
                        window.cropper.push(croppero)









                    })



                    document.getElementById('videoSourceSelect').classList.add('dn')
                    document.getElementById('videoSourceInput').classList.add('dn')
                    document.getElementById('takePhotoButton').classList.add('dn')

                    document.getElementById('submitButton').classList.remove('dn')
                    document.getElementById('takePictureAgain').classList.remove('dn')

                    if (window.stream) {
                        window.stream.getTracks().forEach(track => {
                            track.stop()
                        });
                    }

                    if (typeof document.getElementById('takePictureAgain').dataset.event === 'undefined' || document.getElementById('takePictureAgain').dataset.event === '0') {
                        document.getElementById('takePictureAgain').addEventListener('click', takePictureAgainFunction)
                    }

                    if (typeof document.getElementById('submitButton').dataset.event === 'undefined' || document.getElementById('submitButton').dataset.event === '0') {
                        document.getElementById('submitButton').addEventListener('click', takePictureHelper)
                    }


                    setTimeout(function () {
                        calculatePopUpHeight(document.getElementById('takePictureWithWebCam'), 52)
                    }, 310)


                } else {

                    clearphoto()
                    hideLoading()
                }
            }

            start()

        })

    }

    if (document.getElementsByClassName('qrGeneration')[0]) {
        loadCss("/frontend/assets/css/qrCodeGen.css" + version)
        loadScript("/frontend/assets/js/lib/qrcode.js" + version, function () {

            if (document.getElementsByClassName('shbt')[0]) {

                let shbts = document.getElementsByClassName('shbt')
                for (let i = 0; i < shbts.length; i++) {
                    shbts[i].addEventListener('click', function () {

                        if (shbts[i].classList.contains('shbtt2')) {
                            window.sharePopupTakl = 3
                        } else {
                            window.sharePopupTakl = 1
                        }


                        if (shbts[i].classList.contains('teacherShare')) {
                            if (!window.teacherShareHelper) {
                                window.teacherShareHelper = document.getElementById('shareProfilePopUp2').getElementsByClassName('profile-path-holder')[0].value

                                document.getElementById('shareProfilePopUp2').getElementsByClassName('profile-path-holder')[0].value = document.getElementById('teacherSharingDomain').textContent + document.getElementById('languageTexter').textContent

                            }

                        } else {
                            if (shbts[i].classList.contains('zi999')) {

                            } else {
                                if (window.teacherShareHelper) {
                                    document.getElementById('shareProfilePopUp2').getElementsByClassName('profile-path-holder')[0].value = window.teacherShareHelper
                                }

                            }

                        }
                    })

                }


            }

            if (document.getElementsByClassName('supikar')[0]) {
                document.getElementsByClassName('supikar')[0].addEventListener('click', function () {

                    window.sharePopupTakl = 0
                })
            }




            let k1ffs = document.getElementsByClassName('k1ff')
            for (let i = 0; i < k1ffs.length; i++) {
                k1ffs[i].classList.remove('dn')

            }

            let qrCodes = document.getElementsByClassName('qrGeneration')
            for (let i = 0; i < qrCodes.length; i++) {
                qrCodes[i].addEventListener('click', function () {

                    let parent = qrCodes[i].parentElement.parentElement.parentElement.parentElement.parentElement


                    parent.getElementsByClassName('qrCodeDiv')[0].classList.remove('dn')


                    parent.getElementsByClassName('realQr')[0].innerHTML = ''
                    parent.getElementsByClassName('realQr')[0].title = ''

                    let qrPoint = parent.getElementsByClassName('realQr')[0].id

                    if (window.sharePopupTakl === 3) {
                        qrPoint = 'qrcode4'
                    }

                    let QR_CODE = new QRCode(qrPoint, {
                        width: 260,
                        height: 260,
                        colorDark: "#000000",
                        colorLight: "#ffffff",
                        correctLevel: QRCode.CorrectLevel.H,
                    })

                    parent.getElementsByClassName('qrCodeDiv')[0].getElementsByClassName('realQr')[0].classList.add('dn')

                    let k1ffs = document.getElementsByClassName('k1ff')

                    for (let i = 0; i < k1ffs.length; i++) {
                        k1ffs[i].classList.add('dn')
                    }

                    let closeQRs = document.getElementsByClassName('closeQR')
                    for (let i = 0; i < closeQRs.length; i++) {
                        closeQRs[i].classList.add('dn')
                    }

                    let closeQR = parent.getElementsByClassName('closeQR')[0]

                    if (window.addCompletedTalkToAvailability === 1) {

                        document.getElementsByClassName('white-box-share')[0].classList.add('dn')

                        closeQR.addEventListener('click', function () {

                            let that = this


                            closeQR.classList.add('dn')
                            document.getElementsByClassName('white-box-share')[0].classList.remove('dn')
                            that.parentElement.classList.add('dn')
                            that.parentElement.parentElement.getElementsByClassName('k1ff')[0].classList.remove('dn')
                            parent.getElementsByClassName('qrCodeDiv')[0].classList.add('dn')

                            calculatePopUpHeight(parent.parentElement.parentElement.parentElement.parentElement)



                        })


                        parent.parentElement.getElementsByClassName('k1ff')[0].classList.remove('dn')
                        generateQRCode(location.origin + '/' + document.getElementById('usernameValue').textContent.trim() + '/talk/' + window.addCompletedTalkToAvailabilityId, QR_CODE)
                        closeQR.classList.remove('dn')
                        calculatePopUpHeight(parent.parentElement.parentElement.parentElement.parentElement)

                    } else if (window.sharePopupTakl === 0) {

                        if (typeof closeQR.dataset.added === 'undefined') {
                            closeQR.addEventListener('click', function () {

                                let that = this

                                closeQR.dataset.added = '1'
                                closeQR.classList.add('dn')
                                that.parentElement.parentElement.parentElement.getElementsByClassName('secerr')[0]?.classList.remove('dn')
                                that.parentElement.classList.add('dn')
                                that.parentElement.parentElement.getElementsByClassName('k1ff')[0].classList.remove('dn')
                                parent.getElementsByClassName('qrCodeDiv')[0].classList.add('dn')
                                parent.parentElement.parentElement.parentElement.parentElement.getElementsByClassName('firsterShare')[0].getElementsByTagName('h5')[0].classList.remove('dn')
                                calculatePopUpHeight(parent.parentElement.parentElement.parentElement.parentElement)



                            })
                        }


                        parent.parentElement.getElementsByClassName('k1ff')[0].classList.remove('dn')

                        generateQRCode(parent.getElementsByClassName('profile-path-holder')[0].value, QR_CODE)


                        closeQR.classList.remove('dn')
                        calculatePopUpHeight(parent.parentElement.parentElement.parentElement.parentElement)


                    } else if (window.sharePopupTakl === 1) {

                        if (typeof closeQR.dataset.added === 'undefined') {

                            closeQR.addEventListener('click', function () {

                                let that = this

                                closeQR.classList.add('dn')
                                that.parentElement.parentElement.parentElement.getElementsByClassName('secerr')[0]?.classList.remove('dn')
                                that.parentElement.classList.add('dn')
                                that.parentElement.parentElement.getElementsByClassName('k1ff')[0].classList.remove('dn')
                                parent.getElementsByClassName('qrCodeDiv')[0].classList.add('dn')
                                if (document.getElementsByClassName('fisterkano')[0]) {


                                    if (document.getElementsByClassName('fisterkano')[0].getElementsByClassName('k1ff')[0]) {


                                        let kifs = document.getElementsByClassName('fisterkano')[0].getElementsByClassName('k1ff')
                                        for (let i = 0; i < kifs.length; i++) {
                                            kifs[i].classList.remove('dn')
                                        }
                                    }
                                }

                                calculatePopUpHeight(parent.parentElement.parentElement.parentElement.parentElement)



                            })
                            closeQR.dataset.added = '1'
                        }

                        parent.parentElement.getElementsByClassName('k1ff')[0].classList.remove('dn')

                        generateQRCode(parent.getElementsByClassName('profile-path-holder')[0].value, QR_CODE)

                        calculatePopUpHeight(parent.parentElement.parentElement.parentElement.parentElement)

                        closeQR.classList.remove('dn')
                    } else if (window.sharePopupTakl === 3) {

                        if (typeof closeQR.dataset.added === 'undefined') {

                            closeQR.addEventListener('click', function () {

                                let that = this

                                closeQR.classList.add('dn')
                                that.parentElement.parentElement.parentElement.getElementsByClassName('secerr')[0]?.classList.remove('dn')
                                that.parentElement.classList.add('dn')
                                that.parentElement.parentElement.getElementsByClassName('k1ff')[0].classList.remove('dn')
                                parent.getElementsByClassName('qrCodeDiv')[0].classList.add('dn')
                                if (document.getElementsByClassName('fisterkano')[0]) {


                                    if (document.getElementsByClassName('fisterkano')[0].getElementsByClassName('k1ff')[0]) {


                                        let kifs = document.getElementsByClassName('fisterkano')[0].getElementsByClassName('k1ff')
                                        for (let i = 0; i < kifs.length; i++) {
                                            kifs[i].classList.remove('dn')
                                        }
                                    }
                                }

                                calculatePopUpHeight(parent.parentElement.parentElement.parentElement.parentElement)

                                document.getElementById('profileShareElement').classList.remove('dn')

                            })
                            closeQR.dataset.added = '1'
                        }

                        parent.parentElement.getElementsByClassName('k1ff')[0].classList.remove('dn')

                        generateQRCode(parent.getElementsByClassName('profile-path-holder')[0].value, QR_CODE)

                        calculatePopUpHeight(parent.parentElement.parentElement.parentElement.parentElement)


                    } else {
                        closeQR.classList.remove('dn')
                        if (typeof closeQR.dataset.added === 'undefined') {

                            closeQR.addEventListener('click', function () {

                                let that = this

                                closeQR.classList.add('dn')

                                let firsterShares = document.getElementById('shareProfilePopUp24').getElementsByClassName('firsterShare')
                                for (let i = 0; i < firsterShares.length; i++) {
                                    firsterShares[i].classList.remove('dn')

                                }

                                that.parentElement.parentElement.parentElement.getElementsByClassName('secerr')[0]?.classList.remove('dn')

                                that.parentElement.classList.add('dn')

                                that.parentElement.parentElement.getElementsByClassName('k1ff')[0].classList.remove('dn')

                                parent.getElementsByClassName('qrCodeDiv')[0].classList.add('dn')


                                calculatePopUpHeight(parent.parentElement.parentElement.parentElement.parentElement)



                            })
                            closeQR.dataset.added = '1'
                        }


                    }

                    generateQRCode(parent.getElementsByClassName('profile-path-holder')[0].value, QR_CODE)

                    parent.getElementsByClassName('qrCodeDiv')[0].classList.remove('dn')

                    parent.getElementsByClassName('qrCodeDiv')[0].getElementsByClassName('realQr')[0].classList.remove('dn')





                })

            }

            function generateQRCode(data, QR_CODE) {

                QR_CODE.clear()
                QR_CODE.makeCode(data)

            }

        })
    }

    if (document.getElementsByClassName('bankTansferStuff')[0]) {
        document.getElementsByClassName('bankTansferStuff')[0].addEventListener('click', function () {

            document.getElementsByClassName('bankTansferStuffInner')[0]?.getElementsByClassName('circle-check')[0]?.classList.remove('dn') ?? ''
            document.getElementsByClassName('checekrPayPalPayouout')[0]?.classList.add('dn')
            if (this.dataset.opened === "0") {

                this.style.height = '253px';


                this.getElementsByClassName('mobileStep4Form')[0].style.height = '192px'

                addPreventDefault(document.getElementsByClassName('mobileStep4Form')[0].elements)

                this.dataset.opened = "1"

                if (document.body.className === 'settings_payouts_page') {
                    calculatePopUpHeight(document.getElementById('chosePaymentMethodPopup'), 52, 582)
                }

            } else if (this.dataset.opened === "1") {

                this.style.height = '82px';


                this.getElementsByClassName('mobileStep4Form')[0].style.height = '0px'

                removePreventDefault(document.getElementsByClassName('mobileStep4Form')[0].elements)

                this.dataset.opened = "0"
                if (document.body.className === 'settings_payouts_page') {
                    calculatePopUpHeight(document.getElementById('chosePaymentMethodPopup'), 52, 373)
                }
            }


        })
    }

    function addPreventDefault(arrayOfFormElements) {
        for (let i = 0; i < arrayOfFormElements.length; i++) {
            arrayOfFormElements[i].addEventListener('click', eventHelperFunction)
        }
    }

    function removePreventDefault(arrayOfFormElements) {
        for (let i = 0; i < arrayOfFormElements.length; i++) {
            arrayOfFormElements[i].removeEventListener('click', eventHelperFunction)
        }
    }

    function eventHelperFunction(e) {
        e.preventDefault()
        e.stopPropagation()
        e.stopImmediatePropagation()
    }

    if (document.getElementById('changeAvailability')) {
        if (document.getElementById('changeAvailability').getElementsByClassName('date-time')[0]) {


            allClickableTimeSlot()



        }
    }


    if (document.getElementsByClassName('date-scheduler-wrap')[0]) {

        let dateSchedulerWrap = document.getElementsByClassName('date-scheduler-wrap')

        for (let i = 0; i < dateSchedulerWrap.length; i++) {

            let date7DaysTA = dateSchedulerWrap[i].getElementsByTagName('div')
            for (let i = 0; i < date7DaysTA.length; i++) {
                date7DaysTA[i].addEventListener('click', function () {
                    for (let i = 0; i < date7DaysTA.length; i++) {
                        date7DaysTA[i].className = ''
                    }
                    this.className = 'active'
                })
            }
        }

        let date7DaysTA = document.getElementsByClassName('date-scheduler-wrap')[0].getElementsByTagName('div')
        for (let i = 0; i < date7DaysTA.length; i++) {
            date7DaysTA[i].addEventListener('click', function () {
                for (let i = 0; i < date7DaysTA.length; i++) {
                    date7DaysTA[i].className = ''
                }
                this.className = 'active'
            })
        }
    }

    if (document.getElementsByClassName('optionButton')[0]) {
        /*  optionButton.optionButton() */
        loadScript('/frontend/assets/js/optionButton.js' + version, function () {
            optionButton2()
        })
    }

    if (document.getElementById('cookieCont')) {
        _cookieNotice_js__WEBPACK_IMPORTED_MODULE_1__.cookieButtons()
    }

    if (document.getElementById('scroller')) {
        _scroll_to_top_js__WEBPACK_IMPORTED_MODULE_0__.scrollToTop()
    }



    if (document.getElementById('categoryCarousel')) {

        let categoryCarousel = document.getElementById('categoryCarousel')

        let defaultCarousel = jQuery(categoryCarousel);
        defaultCarousel.owlCarousel({

            loop: false,
            nav: false,
            dots: false,
            stagePadding: 10,
            autoWidth: true,
            responsive: {
                0: {
                    items: 1
                },
                320: {
                    items: 2
                },
                640: {
                    items: 3
                },
                768: {
                    items: 4
                },
                870: {
                    items: 5
                },
                1024: {
                    items: 6
                },
                1280: {
                    items: 7
                }

            }
        });

        setTimeout(function () {
            let w3000 = document.getElementsByClassName('width3000')

            for (let i = 0; i < w3000.length; i++) {
                w3000[i].classList.remove('width3000')
                w3000[i].classList.add('w-100')
            }

            categoryCarousel.style.opacity = '1'
        }, 10)




    }



    if (document.getElementsByClassName('defaultCarousel')[0]) {
        let defaultCarousels = document.getElementsByClassName('defaultCarousel')
        for (let i = 0; i < defaultCarousels.length; i++) {
            let defaultCarousel = jQuery(defaultCarousels[i]);
            defaultCarousel.owlCarousel({

                // autoplay: true,


                center: true,
                loop: true,
                nav: false,
                dots: false,

                responsive: {
                    0: {
                        items: 1,
                        stagePadding: 20,
                        margin: 15
                    },
                    320: {
                        items: 1,
                        stagePadding: 40,
                        margin: 20
                    },
                    360: {
                        items: 1,
                        stagePadding: 60,
                        margin: 30
                    },
                    400: {
                        items: 1,
                        stagePadding: 70,
                        margin: 30
                    },
                    1024: {
                        items: 2,
                        stagePadding: 130,
                        margin: 33

                    },
                    1140: {
                        items: 2,
                        stagePadding: 150,
                        margin: 33

                    }

                }
            });

            setTimeout(function () {
                defaultCarousels[i].style.opacity = '1'
            }, 10)
        }

    }


    if (document.getElementById('payStripeConts')) {
        document.getElementById('payStripeConts')
        if (document.getElementById('stripeerCont') && document.getElementById('paypalerCont')) {
            if (document.getElementById('stripeerButton') && document.getElementById('paypalerButton')) {

                let payPallTabButton = document.getElementById('paypalerButton')
                let stripeTabButton = document.getElementById('stripeerButton')

                payPallTabButton.addEventListener('click', function () {
                    document.getElementById('stripeerCont').classList.add('dn')
                    document.getElementById('paypalerCont').classList.remove('dn')
                    calculatePopUpHeight(document.getElementById('addCoinsPaymentPopUp'))

                    document.getElementById('paymentTabsUl').getElementsByClassName('is-active')[0].classList.remove('is-active')
                    this.parentElement.classList.add('is-active')
                    document.getElementById('add_wallet_booking_cachier')?.parentElement?.classList.add('dn')

                    calculatePopUpHeight(document.getElementById('paymentWalletPopUp'), 10)
                })

                stripeTabButton.addEventListener('click', function () {
                    document.getElementById('stripeerCont').classList.remove('dn')
                    document.getElementById('paypalerCont').classList.add('dn')
                    calculatePopUpHeight(document.getElementById('addCoinsPaymentPopUp'))

                    document.getElementById('paymentTabsUl').getElementsByClassName('is-active')[0].classList.remove('is-active')
                    this.parentElement.classList.add('is-active')
                    document.getElementById('add_wallet_booking_cachier')?.parentElement?.classList.remove('dn')

                    calculatePopUpHeight(document.getElementById('paymentWalletPopUp'), 10)
                })
            }

        }
    }

    if (document.getElementById('goBack')) {
        document.getElementById('goBack').addEventListener('click', function () {
            window.history.back()
        })
    }

    if (document.getElementsByClassName('fButtonCont')[0]) {

        if (document.body.className !== "favorites_talks" && document.body.className !== "favorites_users") {
            window.addEventListener('resize', checkIfFilterButtonIsOpenedBeforeResize)
        } else {
            window.addEventListener('resize', function () {
                if (window.innerWidth < 768) {
                    if (window.filterOpened == "1") {
                        document.getElementsByClassName('desktopContainer')[0].style.opacity = '0'
                        closeFilter()
                    }
                } else if (window.innerWidth > 1023) {
                    if (window.filterOpened == "1") {
                        document.getElementsByClassName('desktopContainer')[0].style.opacity = '0'
                        showLoading()
                        closeFilter()
                        setTimeout(function () {
                            document.getElementsByClassName('desktopContainer')[0].style.opacity = '1'
                            hideLoading()
                        }, 610)
                    } else {
                        document.getElementsByClassName('desktopContainer')[0].style.opacity = '1'
                    }
                }
            })
        }

        function checkIfFilterButtonIsOpenedBeforeResize() {
            if (window.filterOpened === 1) {
                if (window.innerWidth < 769) {
                    window.filterOpenedHelper = 0
                    closeFilter()
                    if (document.body.className === 'talkCategorySubcategory') {
                        openNewFilter()
                    }

                } else if (window.innerWidth > 768 && window.innerWidth < 1024) {

                    if (window.filterOpenedHelper === 1) {

                        openFilter()
                    }



                } else if (window.innerWidth > 1023) {
                    if (window.filterOpenedHelper != 1) {
                        if (document.getElementsByClassName('mainSearchContainerZ')[0]) {
                            document.getElementsByClassName('mainSearchContainerZ')[0].style.opacity = '0'
                        }

                        showLoading()
                        closeFilter()
                        window.filterOpenedHelper = 1

                        setTimeout(function () {
                            if (document.getElementsByClassName('mainSearchContainerZ')[0]) {
                                document.getElementsByClassName('mainSearchContainerZ')[0].style.opacity = '1'
                            }

                            hideLoading()
                        }, 620)
                    }

                }
            } else if (window.filterOpenedHelper === 1) {
                if (window.innerWidth < 769) {


                    if (document.body.className === 'talkCategorySubcategory') {
                        openNewFilter()
                    }
                    window.filterOpenedHelper = 0
                } else if (window.innerWidth > 768 && window.innerWidth < 1024) {

                    openFilter()
                    window.filterOpenedHelper = 0

                } else if (window.innerWidth > 1023) {

                }
            }
        }

        document.getElementsByClassName('fButtonCont')[0].addEventListener('click', function () {

            if (window.filterOpened != "1") {

                openFilter()
            } else if (window.filterOpened == "1") {

                closeFilter()
            }

        })

    }


}

function openFilter() {
    let background = document.createElement('div')
    background.className = 'popupBase'
    background.id = 'bgFilter'
    background.style.cssText = 'left:-1250px; display:block; opacity:1; transition:0.6s; z-index:99999;'

    document.getElementsByTagName('header')[0].append(background)
    document.getElementById('filterTalks').classList.add('filterOpens')

    setTimeout(function () {
        document.getElementById('bgFilter').style.left = '0px'
        document.getElementById('bgFilter').insertBefore(document.getElementById('filterTalks'), document.getElementById('bgFilter').firstChild)
    }, 0)
    setTimeout(function () {
        document.getElementById('filterTalks').style.left = '0px'
        document.getElementsByClassName('submitFilterParent')[0].style.bottom = '0px'
    }, 240)

    document.getElementsByClassName('fButtonCont')[0].getElementsByTagName('p')[0].textContent = getPoTranslate('CLOSE_FILTER')
    document.getElementsByClassName('svgFilterDiv')[0].getElementsByTagName('svg')[0].style.left = '+100px'
    document.getElementsByClassName('svgFilterDiv')[0].getElementsByTagName('svg')[1].style.left = '-12px'

    document.getElementsByClassName('fButtonCont')[0].dataset.opened = "1"
    window.filterOpened = 1
}



/***/ }),

/***/ "./src/assets/js/lib/foundation-explicit-pieces.js":
/*!*********************************************************!*\
  !*** ./src/assets/js/lib/foundation-explicit-pieces.js ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);

window.jQuery = (jquery__WEBPACK_IMPORTED_MODULE_0___default());

__webpack_require__(/*! owl.carousel */ "./node_modules/owl.carousel/dist/owl.carousel.js");
//require('../jquery.mousewheel.js');
//require('jquery-sticky');


//import { Foundation } from 'foundation-sites/js/foundation.core';
//import * as CoreUtils from 'foundation-sites/js/foundation.core.utils';
//import { Box } from 'foundation-sites/js/foundation.util.box'
//import { onImagesLoaded } from 'foundation-sites/js/foundation.util.imageLoader';
//import { Keyboard } from 'foundation-sites/js/foundation.util.keyboard';
//import { MediaQuery } from 'foundation-sites/js/foundation.util.mediaQuery';
//import { Motion, Move } from 'foundation-sites/js/foundation.util.motion';
//import { Nest } from 'foundation-sites/js/foundation.util.nest';
//import { Timer } from 'foundation-sites/js/foundation.util.timer';
//import { Touch } from 'foundation-sites/js/foundation.util.touch';
//import { Triggers } from 'foundation-sites/js/foundation.util.triggers';
//import { Abide } from 'foundation-sites/js/foundation.abide';
//import { Accordion } from 'foundation-sites/js/foundation.accordion';
//import { AccordionMenu } from 'foundation-sites/js/foundation.accordionMenu';
//import { Drilldown } from 'foundation-sites/js/foundation.drilldown';
//import { Dropdown } from 'foundation-sites/js/foundation.dropdown';
//import { DropdownMenu } from 'foundation-sites/js/foundation.dropdownMenu';
//import { Equalizer } from 'foundation-sites/js/foundation.equalizer';
//import { Interchange } from 'foundation-sites/js/foundation.interchange';
//import { Magellan } from 'foundation-sites/js/foundation.magellan';
//import { OffCanvas } from 'foundation-sites/js/foundation.offcanvas';
//import { Orbit } from 'foundation-sites/js/foundation.orbit';
//import { ResponsiveMenu } from 'foundation-sites/js/foundation.responsiveMenu';
//import { ResponsiveToggle } from 'foundation-sites/js/foundation.responsiveToggle';
//import { Reveal } from 'foundation-sites/js/foundation.reveal';
//import { Slider } from 'foundation-sites/js/foundation.slider';
//import { SmoothScroll } from 'foundation-sites/js/foundation.smoothScroll';
//import { Sticky } from 'foundation-sites/js/foundation.sticky';
//import { Tabs } from 'foundation-sites/js/foundation.tabs';
//import { Toggler } from 'foundation-sites/js/foundation.toggler';
//import { Tooltip } from 'foundation-sites/js/foundation.tooltip';
//import { ResponsiveAccordionTabs } from 'foundation-sites/js/foundation.responsiveAccordionTabs';

//Foundation.addToJquery($);

/* Add Foundation Utils to Foundation global namespace for backwards
   compatibility.*/
//Foundation.rtl = CoreUtils.rtl;
//Foundation.GetYoDigits = CoreUtils.GetYoDigits;
//Foundation.transitionend = CoreUtils.transitionend;
//Foundation.RegExpEscape = CoreUtils.RegExpEscape;
//Foundation.onLoad = CoreUtils.onLoad;

//Foundation.Box = Box;
//Foundation.onImagesLoaded = onImagesLoaded;
//Foundation.Keyboard = Keyboard;
//Foundation.MediaQuery = MediaQuery;
//Foundation.Motion = Motion;
//Foundation.Move = Move;
//Foundation.Nest = Nest;
//Foundation.Timer = Timer;

/* Touch and Triggers previously were almost purely sede effect driven,
   so no need to add it to Foundation, just init them.*/
//Touch.init($);
//Triggers.init($, Foundation);
//MediaQuery._init();

//Foundation.plugin(Abide, 'Abide');
//Foundation.plugin(Accordion, 'Accordion');
//Foundation.plugin(AccordionMenu, 'AccordionMenu');
//Foundation.plugin(Drilldown, 'Drilldown');
//Foundation.plugin(Dropdown, 'Dropdown');
//Foundation.plugin(DropdownMenu, 'DropdownMenu');
//Foundation.plugin(Equalizer, 'Equalizer');
//Foundation.plugin(Interchange, 'Interchange');
//Foundation.plugin(Magellan, 'Magellan');
//Foundation.plugin(OffCanvas, 'OffCanvas');
//Foundation.plugin(Orbit, 'Orbit');
//Foundation.plugin(ResponsiveMenu, 'ResponsiveMenu');
//Foundation.plugin(ResponsiveToggle, 'ResponsiveToggle');
//Foundation.plugin(Reveal, 'Reveal');
//Foundation.plugin(Slider, 'Slider');
//Foundation.plugin(SmoothScroll, 'SmoothScroll');
//Foundation.plugin(Sticky, 'Sticky');
//Foundation.plugin(Tabs, 'Tabs');
//Foundation.plugin(Toggler, 'Toggler');
//Foundation.plugin(Tooltip, 'Tooltip');
//Foundation.plugin(ResponsiveAccordionTabs, 'ResponsiveAccordionTabs');

//export { Foundation };

//jQuery(document).foundation();


/***/ }),

/***/ "./src/assets/js/loggedOut.js":
/*!************************************!*\
  !*** ./src/assets/js/loggedOut.js ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "loggedOutHome": () => (/* binding */ loggedOutHome),
/* harmony export */   "showMoreTalks": () => (/* binding */ showMoreTalks)
/* harmony export */ });
/* harmony import */ var _detectScrollDirection_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./detectScrollDirection.js */ "./src/assets/js/detectScrollDirection.js");
/* harmony import */ var _inputRange_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./inputRange.js */ "./src/assets/js/inputRange.js");
/* harmony import */ var _calculator_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./calculator.js */ "./src/assets/js/calculator.js");








function initCarousels() {

    if (window.innerWidth < 768) {
        mobileCarousels()
    } else if (window.innerWidth > 767) {
        desktopCarousels()
    }

    function removeActiveThumbs(x) {
        for (let i = 0; i < x.length; i++) {
            x[i].classList.remove('active');
        }
    }

    function owlClick(x, y) {
        for (let i = 0; i < x.length; i++) {
            x[i].addEventListener('click', function () {
                y.trigger('to.owl.carousel', this.dataset.owlIndex)
            })
        }
    }

    function owlSwitch(x, y) {
        switch (x) {
            case 0:
                removeActiveThumbs(y)
                y[x].className += " active";
                break;
            case 1:
                removeActiveThumbs(y)
                y[x].className += " active";
                break;
            case 2:
                removeActiveThumbs(y)
                y[x].className += " active";
        }
    }

    function desktopCarousels() {

        setTimeout(function () {
            var owl2 = jQuery("#slider-one");
            owl2.owlCarousel({
                margin: 20,
                dots: true,
                nav: false,
                stagePadding: 0,
                items: 1,
                autoplay: true,
                autoplayHoverPause: true
            });

            let carOne = document.getElementById('carousel-one').getElementsByClassName('slider-item')
            document.getElementById('slider-one').style.opacity = '1'
            owl2.on('changed.owl.carousel', function (event) {
                owlSwitch(event.item.index, carOne)
            })

            owlClick(carOne, owl2)
        }, 30)

        setTimeout(function () {
            var owl3 = jQuery("#slider-two");
            owl3.owlCarousel({
                margin: 20,
                dots: true,
                nav: false,
                items: 1,
                autoplay: true,
                autoplayHoverPause: true

            });

            let carTwo = document.getElementById('carousel-two').getElementsByClassName('slider-item')

            document.getElementById('slider-two').style.opacity = '1'
            owl3.on('changed.owl.carousel', function (event) {

                owlSwitch(event.item.index, carTwo)

            })

            owlClick(carTwo, owl3)

        }, 60)

        setTimeout(function () {
            if (window.desktopCarouselsHelper !== 1) {
                desktopCarouselsHelper()
            }
            window.desktopCarousels = 1

        }, 65)
    }

    function desktopCarouselsHelper() {

        window.desktopCarouselsHelper = 1
    }

    function mobileCarousels() {

        setTimeout(function () {
            var owl4 = jQuery("#mobile-slider-one");
            owl4.owlCarousel({
                margin: 20,
                dots: true,
                nav: false,
                stagePadding: 0,
                items: 1
            });
            document.getElementById('mobile-slider-one').style.opacity = '1'
        }, 30)
        setTimeout(function () {
            var owl5 = jQuery("#mobile-slider-two");
            owl5.owlCarousel({
                margin: 20,
                dots: true,
                nav: false,
                stagePadding: 0,
                items: 1
            });
            document.getElementById('mobile-slider-two').style.opacity = '1'
        }, 60)
        window.mobileCarousels = 1

    }

    function initializeCarousels() {
        if (window.innerWidth < 768) {
            if (window.mobileCarousels !== 1) {

                mobileCarousels()
            }
        } else if (window.innerWidth > 767) {
            if (window.desktopCarousels !== 1) {
                desktopCarousels()
            }
        }
    }

    window.addEventListener("resize", initializeCarousels);




}

function showMoreTalks() {

    let limit = 500

    let privateShowMore = document.getElementsByClassName('privateShowMore')

    for (let i = 0; i < privateShowMore.length; i++) {
        privateShowMore[i].addEventListener('click', function () {

            displayTalks(this.dataset.userid, this.dataset.type, limit)
        })
    }

    let privateHideMore = document.getElementsByClassName('privateHideMore')
    for (let i = 0; i < privateHideMore.length; i++) {
        privateHideMore[i].addEventListener('click', function () {


            let privateC = document.getElementsByClassName('privateC')

            for (let i = 0; i < privateC.length; i++) {

                let privateCourses = privateC[i].getElementsByClassName('privateCourseItem')

                for (let i = (privateCourses.length - 1); i >= 0; i--) {
                    if (i > 4) {

                        privateCourses[i].parentElement.removeChild(privateCourses[i])
                    }
                }


                let privateShowMore = document.getElementsByClassName('privateShowMore')
                for (let i = 0; i < privateShowMore.length; i++) {
                    privateShowMore[i].parentElement.style.display = 'block'

                }

                let privateHideMore = document.getElementsByClassName('privateHideMore')
                for (let i = 0; i < privateHideMore.length; i++) {
                    privateHideMore[i].parentElement.style.display = 'none'
                }

            }


        })
    }

    function displayTalks(user, type, limit) {
        let offset = document.getElementById('privateTeacherTalks').getElementsByClassName('privateCourseItem').length
        let xhr = new XMLHttpRequest()
        let url = '/teacher-talks?talk_type=' + type + '&limit=' + limit + '&teacherId=' + user + '&offset=' + offset  + '&teacher_username=' + location.pathname.split('/')[1]
        xhr.onloadstart = function () {
            showLoading()
        }
        xhr.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.response)

                if (response.success === true) {

                    if (type === "1") {


                        let privateTeacherTalks = document.getElementById('privateTeacherTalks')
                        privateTeacherTalks.innerHTML += response.html

                        let mobilePrivateProfileTeacherTalks = document.getElementById('mobilePrivateProfileTeacherTalks')
                        mobilePrivateProfileTeacherTalks.innerHTML += response.htmlMobile

                        let privateShowMore = document.getElementsByClassName('privateShowMore')
                        for (let i = 0; i < privateShowMore.length; i++) {
                            privateShowMore[i].parentElement.style.display = 'none'

                        }

                        let privateHideMore = document.getElementsByClassName('privateHideMore')
                        for (let i = 0; i < privateHideMore.length; i++) {
                            privateHideMore[i].parentElement.style.display = 'block'
                        }




                    } /* else if (type === "2") {

                        let groupC = document.getElementsByClassName('groupC')
                        for (let i = 0; i < groupC.length; i++) {
                            groupC[i].innerHTML = response.html

                        }

                    } */
                } else {
                    toastify(getPoTranslate('COMUNICATION_WITH_API_SUCCES_FALSE'))
                }

            }
        }
        xhr.onloadend = function () {
            hideLoading()
        }
        xhr.onerror = function (error) {
            hideLoading()
            Sentry.captureException(new GetTeacherTalksError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
        }

        xhr.open("GET", url, true)
        xhr.send()


    }
}


function loggedOutHome() {
    initCarousels()
    ;(0,_detectScrollDirection_js__WEBPACK_IMPORTED_MODULE_0__.scrollDirection)()
    ;(0,_inputRange_js__WEBPACK_IMPORTED_MODULE_1__.inputRange)()
    ;(0,_calculator_js__WEBPACK_IMPORTED_MODULE_2__.calculator)()

}


/***/ }),

/***/ "./src/assets/js/mobileMenu.js":
/*!*************************************!*\
  !*** ./src/assets/js/mobileMenu.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "menuResponsiveCheck": () => (/* binding */ menuResponsiveCheck),
/* harmony export */   "mobileMenu": () => (/* binding */ mobileMenu)
/* harmony export */ });


function mobileMenu() {

    if (document.getElementsByClassName('mobileNav')[0]) {
        var mobileNavElement = document.getElementsByClassName('mobileNav')[0]
        if (document.getElementsByClassName('ptbo')[0] && window.scrollY > 150) {
            mobileNavElement.style.cssText = 'height:calc(100% - 84px);top:84px;'
        } else {
            mobileNavElement.style.cssText = 'height:100vh'
        }

        if (document.getElementsByClassName('menuIconCont')[0]) {


            document.getElementsByClassName('menuIconCont')[0].addEventListener('click', function () {
                document.getElementsByClassName('menuIconCont')[0].style.pointerEvents = 'none'
                if (document.getElementsByClassName('menuIcon')[0].dataset.isOpen === "0") {

                    document.getElementsByClassName('menuIcon')[0].style.cssText = 'position:fixed;right:32px;'

                    if (document.getElementsByClassName('langCont')[0]) {
                        document.getElementsByClassName('langCont')[0].style.right = '36px'
                    }

                    let appendStyle = document.createElement('div')
                    appendStyle.id = 'appendStyle'
                    appendStyle.innerHTML = '<style>.menuIcon:before{transform: translateY(6px) rotate(135deg)!important;}.menuIcon:after{transform: translateY(-6px) rotate(-135deg)!important;}.menuIcon div{transform: scale(0)!important;}</style>'

                    document.body.insertBefore(appendStyle, document.body.firstChild)

                    if (!document.getElementsByClassName('menuBackgroundMobile')[0]) {
                        let menuBackground = document.createElement('div')
                        menuBackground.setAttribute('class', 'menuBackgroundMobile')

                        document.getElementsByClassName('mHeader')[0].append(menuBackground)
                    } else {
                        document.getElementsByClassName('menuBackgroundMobile')[0].style.zIndex = '10'
                    }


                    setTimeout(function () {
                        document.getElementsByClassName('menuBackgroundMobile')[0].style.opacity = '1'

                        mobileNavElement.style.right = '0rem'

                        mobileNavElement.dataset.mobileOpen = 1


                    }, 10)
                    setTimeout(function () {
                        document.getElementsByClassName('menuIconCont')[0].style.pointerEvents = 'all'
                    }, 510)
                    document.getElementsByClassName('menuBackgroundMobile')[0].addEventListener('click', closeMenu)
                    document.getElementsByClassName('menuIcon')[0].dataset.isOpen = 1
                }
                else {
                    closeMenu()
                }
            })
        }

    }



}


function menuResponsiveCheck() {
    if (document.getElementsByClassName('menuIcon')[0]) {
        if (document.getElementsByClassName('menuIcon')[0].dataset.isOpen === "1") {
            if (window.innerWidth > 639) {
                closeMenu()
            }
        }
    }
}

function closeMenu() {
    document.getElementsByClassName('menuIconCont')[0].style.pointerEvents = 'none'
    document.getElementsByClassName('menuIcon')[0].style.cssText = 'position:relative;right:0rem; transition:0s;'
    document.getElementsByClassName('langCont')[0].style.right = '0px'
    if (document.getElementById('appendStyle')) {
        document.getElementById('appendStyle').parentNode.removeChild(document.getElementById('appendStyle'))
    }
    document.getElementsByClassName('menuBackgroundMobile')[0].style.opacity = '0'
    setTimeout(function () {
        document.getElementsByClassName('menuBackgroundMobile')[0].parentElement?.removeChild(document.getElementsByClassName('menuBackgroundMobile')[0])
        document.getElementsByClassName('menuIconCont')[0].style.pointerEvents = 'all'
    }, 510)
    mobileNavElement.style.right = '-100%'

    document.getElementsByClassName('menuIcon')[0].dataset.isOpen = 0

}


/***/ }),

/***/ "./src/assets/js/payment.js":
/*!**********************************!*\
  !*** ./src/assets/js/payment.js ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "deleteCards": () => (/* binding */ deleteCards),
/* harmony export */   "extendTalkPaymentInitialize": () => (/* binding */ extendTalkPaymentInitialize),
/* harmony export */   "initializePayPal": () => (/* binding */ initializePayPal),
/* harmony export */   "initializeStripe": () => (/* binding */ initializeStripe),
/* harmony export */   "selectCardForPayment": () => (/* binding */ selectCardForPayment),
/* harmony export */   "selectDefaultCard": () => (/* binding */ selectDefaultCard)
/* harmony export */ });
let bearerToken = document.querySelector('meta[name="access_token"]').content
let token = document.querySelector('meta[name="csrf-token"]').content

function openPaymentPopuper(x) {
    openPopup('specialLoading')
    document.getElementById('loadingText').textContent = x
}

function initializePayPal(intentValue) {

    let paypal_client_id = document.getElementById('ppbpci').value

    loadScript("https://www.paypal.com/sdk/js?intent=" + intentValue + "&vault=false&client-id=" + paypal_client_id + "&disable-funding=credit,card,giropay,sofort,sepa&currency=EUR", function () {

        try {
            initPayPal()
        } catch (err) {
            Sentry.captureException(new TryCatchInitPayPal(err))
        }

        function initPayPal() {
            let payPalEnvironment = document.getElementById('ppenv').value

            paypal.Buttons({

                // Set your environment
                env: payPalEnvironment,

                // Set style of button
                style: {
                    layout: 'vertical', // horizontal | vertical
                    size: 'responsive', // medium | large | responsive
                    shape: 'pill', // pill | rect
                    color: 'gold' // gold | blue | silver | black
                },

                // Execute payment on authorize
                commit: true,
                // Wait for the PayPal button to be clicked
                createOrder: function () {

                    let total_amount

                    if (document.body.className === "settings_wallets") {
                        total_amount = parseFloat(document.getElementById('online_amount').value.replace(',', '.')).toFixed(2)
                    } else if (document.body.className === "video_conference") {

                        let userBalance = parseFloat(document.getElementById('upperBallance').textContent.replace(',', '.'))
                        let extendionPrice = parseFloat(document.getElementById('paymentWalletPopUp').getElementsByClassName('extend_call_price')[0].textContent.replace(',', '.'))

                        if (userBalance > 0) {
                            total_amount = parseFloat(extendionPrice - userBalance).toFixed(2)
                        }else{
                            total_amount = parseFloat(extendionPrice).toFixed(2)
                        }

                        /* if( parseFloat(document.getElementById('upperBallance').textContent) === 0){

                            total_amount = parseFloat(
                                document.getElementById('paymentWalletPopUp').getElementsByClassName('extend_call_price')[0].textContent
                            ).toFixed(2)

                        }else if(parseFloat(document.getElementById('upperBallance').textContent) < parseFloat(document.getElementById('paymentWalletPopUp').getElementsByClassName('extend_call_price')[0].textContent)){
                            total_amount = parseFloat(

                                parseFloat(document.getElementById('paymentWalletPopUp').getElementsByClassName('extend_call_price')[0].textContent)
                                -
                                parseFloat(document.getElementById('upperBallance').textContent)

                            ).toFixed(2)
                        } */


                    } else if (document.body.className === "book_slot_payment") {
                        /* total_amount = parseFloat(document.getElementById('paypalAmount').textContent.replace(',', '.')) */
                        total_amount = parseFloat(document.getElementById('paypalAmountReal').value).toFixed(2)
                    }else{
                        total_amount = parseFloat(document.getElementById('online_amount').value)

                    }

                    let payment_type = document.getElementById('payment_type').value

                    let params = {
                        item_amt: total_amount,
                        total_amt: total_amount,
                        currency: 'EUR',
                        intent: intentValue.toUpperCase(),
                        _token: token,
                        payment_type: payment_type
                    }

                    return fetch(
                        '/frontend/api/paypal-create-order', {
                        method: 'POST',
                        body: JSON.stringify(params),
                        headers: {
                            "Content-Type": "application/json;charset=UTF-8",
                            "X-CSRF-TOKEN": token,
                            "Time-Zone-Offset-UTC": getCookie('timezone')
                        }
                    }).then(function (response) {
                        return response.json()
                    }).then(function (resJson) {
                        return resJson.data.id
                    })
                },

                // Wait for the payment to be authorized by the customer
                onApprove: function (data, actions) {

                    let bookingObj = document.body.className === 'book_slot_payment' ? JSON.parse(getCookie('bookingObj')) : null
                    let amount, talk_id, start_call, extension_time, url

                    if (document.body.className === 'book_slot_payment') {
                        amount = parseFloat(parseFloat(document.getElementById('paypalAmountReal').value).toFixed(2))
                        talk_id = parseFloat(document.getElementsByClassName('dataTalkId')[0].dataset.talkId)
                        start_call = document.body.className === 'book_slot_payment' ? bookingObj.bookingDate + ' ' + bookingObj.bookingTime[0] : null
                        extension_time = false
                        url = '/frontend/api/bookings'

                    } else if (document.body.className === 'settings_wallets') {
                        amount = parseFloat(document.getElementById('addCoinsPaymentPopUp').getElementsByClassName('online_amount')[0].textContent)
                        url = '/frontend/api/paypal-capture-order'

                    } else if(document.body.className === 'video_conference') {
                        amount = parseFloat(document.getElementById('paymentWalletPopUp').getElementsByClassName('extend_call_price')[0].textContent)
                        talk_id = parseFloat(9999999999999)
                        start_call = false
                        extension_time = parseInt(document.getElementById('paymentWalletPopUp').getElementsByClassName('extend_call_time')[0].textContent)
                        url = '/frontend/api/book-extension'

                    }else{

                        amount = parseFloat(document.getElementById('online_amount').value)
                        url = '/frontend/api/paypal-capture-order'
                    }


                    let params = {
                        order_id: data.orderID,
                        _token: token,
                        payment_type: 'paypal',
                        talk_id: talk_id,
                        amount: amount,
                        start_call: start_call,
                        extension_time: extension_time,
                    }

                    openPaymentPopuper(getPoTranslate('PROCESSING_PAYPAL_PAYMENT'))

                    try {
                        finishPayPalTransaction()

                    } catch (err) {

                        Sentry.captureException(new TryCatchFinishPayPalTransaction(err))
                    }

                    function finishPayPalTransaction() {

                        return fetch(
                            url, {
                            method: 'POST',
                            body: JSON.stringify(params),
                            headers: {
                                "Content-Type": "application/json;charset=UTF-8",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                "Time-Zone-Offset-UTC": getCookie('timezone')
                            }
                        }).then(function (res) {
                            return res.json()
                        }).then(function (res) {

                            if (res.success == true) {


                                if (document.body.className === "settings_wallets") {

                                    let available_balance = new Intl.NumberFormat(getCookie('activeLang'), { style: 'currency', currency: 'EUR' }).format(parseFloat(res.data.available_balance)).replace(/[^0-9.,]/g, '')

                                    document.getElementsByClassName('available_balance')[0].textContent = available_balance
                                    closePopup('addCoinsPaymentPopUp')
                                    closePopup('specialLoading')
                                    toastify(res.message)
                                } else if (document.body.className === "book_slot_payment") {
                                    document.cookie = 'bookingObj=; Path=/booking-payment; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                                    location.assign(origin + '/booking-thank-you')
                                    toastify(res.message)
                                } else if (document.body.className === "video_conference") {

                                    let thatsMe
                                    for (let i = 0; i < others.length; i++) {
                                        if (others[i].user_id === userObj1.id) {
                                            thatsMe = {
                                                name: others[i].name_of_user,
                                                profile_picture: others[i].user_image
                                            }
                                        }

                                    }

                                    EXTEND_CALL_SUCCESSFUL_Send_Event_Function(call, thatsMe, window.extendTalkParameters)

                                    closePopup('paymentWalletPopUp')
                                    openPopup('paymentCompletedPopUp')

                                    setTimeout(function () {
                                        closePopup('paymentCompletedPopUp')
                                    }, 5000)

                                    closePopup('specialLoading')

                                } else {




                                   toastify(res.message)
                                    closePopup('specialLoading')
                                    closePopup('blankPopup')
                                }

                            } else {

                                toastify(res.message)
                                closePopup('specialLoading')
                            }

                        }).catch((error) => {
                            Sentry.captureException(new finishPayPalTransactionError(error))
                        })

                    }
                }
            }).render('#paypalCheckoutContainer')

        }
    })

    class TryCatchInitPayPal extends Error {
        constructor(message) {
            super(message)
            this.name = "TryCatchInitPayPal"
        }
    }
    class TryCatchFinishPayPalTransaction extends Error {
        constructor(message) {
            super(message)
            this.name = "TryCatchFinishPayPalTransaction"
        }
    }
    class finishPayPalTransactionError extends Error {
        constructor(message) {
            super(message)
            this.name = "finishPayPalTransactionError"
        }
    }

}

function extendTalkPaymentInitialize() {




    document.getElementsByClassName('getcddata')[0].addEventListener('click', function () {


        let walletBalance



        let url = envAppBackendUrl + "/get-wallet-balance"
        let xhr = new XMLHttpRequest()

        xhr.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.responseText)


                if (response.success == true) {

                    walletBalance = parseFloat(response.data.available_balance_regular_format)
                    document.getElementById('upperBallance').textContent = walletBalance
                    closePopup('extendAnswer')

                    let walletBalanceContainer = document.getElementsByClassName('wallet_balance_section')[0]

                    if(parseFloat(response.data.available_balance_regular_format) == 0){


                        walletBalanceContainer.classList.add('dn')
                        document.getElementsByClassName('wallet_balance_section')[0].classList.add('dn')
                    }else{
                        document.getElementsByClassName('wallet_balance_section')[0].classList.remove('dn')
                        walletBalanceContainer.classList.remove('dn')
                    }
                    //openPaymentPopuper(getPoTranslate('PROCESSING_PAYMENT'))

                    document.getElementById('paypalVideoExtendViewAmount').textContent = parseFloat(
                        walletBalance - parseFloat(document.getElementById('paymentWalletPopUp').getElementsByClassName('extend_call_price')[0].textContent.replace(',', '.'))
                    ).toFixed(2)

                    initializePayPal('authorize')
                    document.getElementById('nameOfTalkForPaymentExtension').textContent = call.room_name
                    openPopup('paymentWalletPopUp')
                   if (parseFloat(walletBalance) > parseFloat(document.getElementsByClassName('extend_call_price')[0].textContent)) {

                        let peregarders = document.getElementsByClassName('peregarder')
                        for (let i = 0; i < peregarders.length; i++) {
                            peregarders[i].classList.add('dn')

                        }
                        if(document.getElementById('stripePricer')){
                            document.getElementById('stripePricer').remove()
                        }
                        document.getElementById("pay_via_stripe_cachsier").textContent = getPoTranslate('PAY_VIA_COINS')

                    } else if ((parseFloat(document.getElementsByClassName('extend_call_price')[0].textContent) - parseFloat(walletBalance)) > 0) {

                        let peregarders = document.getElementsByClassName('peregarder')
                        for (let i = 0; i < peregarders.length; i++) {
                            peregarders[i].classList.remove('dn')

                        }
                        document.getElementById("pay_via_stripe_cachsier").textContent = getPoTranslate('PAY_USING_STRIPE')
                        let price = document.createElement('span')
                        price.id = "stripePricer"
                        price.textContent = ' (' + new Intl.NumberFormat(getCookie('activeLang'), { style: 'currency', currency: 'EUR' }).format((parseFloat(document.getElementsByClassName('extend_call_price')[0].textContent) - parseFloat(document.getElementsByClassName('greenInfo')[0].dataset.realPrice)).toFixed(2)) + ')'
                        document.getElementById("pay_via_stripe_cachsier").append(price)
                        document.getElementById('paypalVideoExtendViewAmount').textContent = parseFloat(
                            parseFloat(document.getElementById('paymentWalletPopUp').getElementsByClassName('extend_call_price')[0].textContent.replace(',', '.'))
                            -
                            walletBalance
                        ).toFixed(2)
                        if(document.getElementById('payAmountStripeVideoExtend')){
                            document.getElementById('payAmountStripeVideoExtend').innerHTML = ' (<b>' + new Intl.NumberFormat(getCookie('activeLang'), { style: 'currency', currency: 'EUR' }).format(parseFloat(document.getElementById('paypalVideoExtendViewAmount').textContent)) + '</b>)'
                        }
                      } else {
                        document.getElementById('pay_via_stripe_cachsier').classList.add('dn')
                        document.getElementById('paypalVideoExtendViewAmount').textContent = parseFloat(
                            parseFloat(document.getElementById('paymentWalletPopUp').getElementsByClassName('extend_call_price')[0].textContent.replace(',', '.'))
                            -
                            walletBalance
                        ).toFixed(2)
                    }

                } else {


                    toastify(response.message)

                }

            }
        }

        xhr.open("GET", url, true)

        xhr.onerror = function () {
            hideLoading()
            closePopup('specialLoading')
            Sentry.captureException(new getWalletBalanceError('status: ' + this.statusText + '|| response: ' +
                this.statusText + ' || url: ' + location.href))
        }

        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8")
        xhr.setRequestHeader('Authorization', bearerToken)
        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

        xhr.send()

        class getWalletBalanceError extends Error {
            constructor(message) {
                super(message)
                this.name = "TryCatchBlockBookingPaymentFunction"
            }
        }


    })


}





function addCreditCardSubmit(stripe) {
    if (document.getElementById('submitAddCreditCard')) {

        let nameStatus = {}
        let nameValue

        if (document.getElementById("submitAddCreditCard")) {

            let nameInput = document.getElementById('card_holder_name')
            let nameWarn = nameInput.parentElement.getElementsByClassName("default-warn")[0]
            let nameSvg = nameInput.parentElement.getElementsByClassName("verified-svg")[0]

            nameInput.parentElement.getElementsByClassName('clear-button')[0].addEventListener('click',function(){
                this.parentElement.classList.remove('active')
                this.parentElement.parentElement.getElementsByClassName('default-input')[0].classList.remove('ok')
                this.parentElement.parentElement.getElementsByClassName('default-input')[0].value = ''
            })

            nameInput.addEventListener("input", nameHandler)


            function nameHandler() {
                nameValue = nameInput.value

                let check = nameCheck(nameValue)
                nameStatus = check

                if (check.isOk) {

                    nameInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#1d293f'

                    countLabelDriver({ el: nameInput, min: 2, max: 100 })
                    nameInput.classList.remove("error")
                    nameInput.classList.add("ok")

                    nameSvg.classList.add("active")
                    nameWarn.classList.remove("active")

                } else {
                    nameInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#FD2A18'

                    countLabelDriver({ el: nameInput, min: 4, max: 50 })


                    nameInput.classList.add("error")
                    nameInput.classList.remove("ok")

                    nameSvg.classList.remove("active")

                    nameWarn.classList.add("active")

                    nameWarn.innerHTML = "&nbsp"
                    /* nameWarn.innerHTML += check.hasName ? "" : translate.missingName + ","
                    nameWarn.innerHTML += check.hasSurname ? "" : " " + translate.missingSurname + ","
                    nameWarn.innerHTML += check.hasNumber ? " " + translate.noNumbers + "," : ""
                    nameWarn.innerHTML += check.hasSymbol ? " " + translate.noSpecialCharacters + "," : "" */
                    nameWarn.innerHTML += check.lengthLimit ? " " + getPoTranslate('MINIMUM_AND_MAXIMUM_CHARACTERS', { 'minimum_characters': '2', 'maximum_characters': '100' }) + "," : ""


                    nameWarn.textContent = removeCommaFromValidationWarning(nameWarn.textContent)
                }
            }


            document.getElementById('submitAddCreditCard').addEventListener('click', function () {

                nameHandler()

                let postData = {
                    name: nameValue
                }

                let postStatus = {
                    name: nameStatus
                }

                if (nameStatus.isOk) {


                    openPaymentPopuper(getPoTranslate('PROCESSING_ADD_CREDIT_CARD'))

                   /*  try { */
                        addCreditCardToWallet()
                    /* } catch (err) {
                        Sentry.captureException(new tryCatchAddCreditCardFunction(err));
                    } */

                    function addCreditCardToWallet() {


                        stripe.confirmCardSetup(
                            document.getElementById('userCardsIntent').value, {
                            payment_method: {
                                card: card,
                                billing_details: {
                                    name: document.getElementById('card_holder_name').value
                                }
                            }
                        }).then(function (result) {

                            if (result.error) {


                                if (document.getElementById('creditCardMesasge')) {
                                    let creditCardMesasge = document.getElementById('creditCardMesasge')
                                    creditCardMesasge.style.display = 'block'
                                    setTimeout(function () {

                                        creditCardMesasge.textContent = result.error.message
                                        creditCardMesasge.style.color = 'red'
                                        creditCardMesasge.style.opacity = '1'
                                        creditCardMesasge.style.transform = 'scale(1)'
                                        calculatePopUpHeight(document.getElementById('cardPopUp'))


                                        setTimeout(function () {

                                            creditCardMesasge.style.opacity = '0'
                                            creditCardMesasge.style.transform = 'scale(0)'
                                            setTimeout(function () {
                                                calculatePopUpHeight(document.getElementById('cardPopUp'))
                                                setTimeout(function () {

                                                    creditCardMesasge.style.display = 'none'


                                                }, 10)
                                            }, 350)
                                        }, 5000)


                                    }, 10)

                                    closePopup('specialLoading')

                                } else {
                                    toastify(result.error.message)
                                }


                            } else {

                                let params = {
                                    payment_method: result.setupIntent.payment_method,
                                    _token: token
                                }

                                let xhr = new XMLHttpRequest()

                                xhr.onreadystatechange = function () {

                                    if (this.readyState == 4 && this.status == 200) {

                                        let response = JSON.parse(this.responseText)

                                        toastify(response.message)

                                        if (document.getElementById('loadingText')) {
                                            document.getElementById('loadingText').textContent = response.message
                                        }



                                        closePopup('cardPopUp')

                                        openPaymentPopuper(getPoTranslate('PROCESSING_ADD_CREDIT_CARD'))

                                        removeActivePointerCreditCardsPointers()

                                        if (response.data.cards.hasOwnProperty('deleted')) {

                                            let cards = document.getElementsByClassName('set_default_card')
                                            for (let i = 0; i < cards.length; i++) {
                                                let cardItem = cards[i]
                                                if (cardItem.dataset.cardId === response.data.cards.deleted.card_id) {

                                                    cardItem.parentElement.style.scale = '0'

                                                    if (cardItem.parentElement.parentElement.classList.contains('card-list')) {
                                                        cardItem.removeEventListener('click', selectDefaultCardHelper)
                                                    } else if (cardItem.parentElement.parentElement.classList.contains('stripe_cards_without_delete')) {
                                                        cardItem.removeEventListener('click', selectPaymentCard)
                                                    }

                                                    setTimeout(function () {
                                                        cardItem.parentElement.remove()
                                                    }, 310)
                                                }

                                            }
                                            setTimeout(function () {
                                                appendClonedElement(response.data.cards.added)



                                            }, 310)


                                        } else {

                                            appendClonedElement(response.data.cards.added)

                                        }

                                        closePopup('specialLoading')

                                        if (document.body.className === 'settings_wallets') {
                                            document.getElementById('walletStripeButtonCont').classList.remove('dn')
                                        } else if (document.body.className === 'video_conference') {
                                            document.getElementById('pay_via_stripe_cachsier').classList.remove('dn')
                                            document.getElementById('ccContainerBookingFunnel').classList.remove('dn')
                                        }





                                        if (document.getElementById('add_wallet_booking_cachier')) {
                                            if (document.getElementById('add_wallet_booking_cachier').classList.contains('dn')) {
                                                document.getElementById('add_wallet_booking_cachier').classList.remove('dn')
                                            }
                                        }
                                    }
                                }

                                xhr.open("POST", "/frontend/api/add-card", true)

                                xhr.onerror = function (error) {
                                    hideLoading()
                                    closePopup('specialLoading')
                                    console.log(new Error(error))
                                }

                                xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                                xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'));

                                xhr.send(JSON.stringify(params))

                            }
                        })

                    }

                    class getStripeCardsForExtendionError extends Error {
                        constructor(message) {
                            super(message)
                            this.name = "getStripeCardsForExtendionError"
                        }
                    }

                    class tryCatchAddCreditCardFunction extends Error {
                        constructor(message) {
                            super(message)
                            this.name = "tryCatchAddCreditCardFunction"
                        }
                    }



                } else {
                    console.log("fullName validation failed", postData)
                    console.log("fullName validation errors", postStatus)
                }


            })
        }

    }
}

function appendClonedElement(cardItem) {
    let clonedElementWithDelete = createClonedElement(cardItem)
    let clonedElementWithoutDelete = createClonedElement(cardItem)

    clonedElementWithDelete.querySelector(".set_default_card").addEventListener('click', selectDefaultCardHelper)
    clonedElementWithDelete.querySelector(".delete_card").addEventListener('click', deleteCardHelper)
    clonedElementWithoutDelete.querySelector(".set_default_card").addEventListener('click', selectPaymentCard)

    document.getElementsByClassName('card-list')[0]?.prepend(clonedElementWithDelete)
    document.getElementsByClassName('stripe_cards_without_delete')[0].prepend(clonedElementWithoutDelete)

    if (document.getElementsByClassName('noCardsAdded')[0]) {

        let noCardsAdded = document.getElementsByClassName('noCardsAdded')

        for (let i = noCardsAdded.length - 1; i >= 0; i--) {

            noCardsAdded[i].remove()
        }


    }
    if (document.body.className === 'settings_wallets') {
        let cardList = document.getElementsByClassName('card-list')[0].getElementsByClassName('delete_card')

        if (cardList.length === 1) {
            document.getElementsByClassName('card-list')[0].getElementsByClassName('delete_card')[0].classList.remove('dn')
        }
    }


    setTimeout(function () {
        calculatePopUpHeight(document.getElementById('addCoinsPaymentPopUp'))
    })

}

function createClonedElement(cardObject) {
    let cardItemTemplate = document.getElementById("cardItemTemplate")
    let clonedTemplate = cardItemTemplate.content.cloneNode(true)

    clonedTemplate.querySelector(".set_default_card").dataset.cardId = cardObject.card_id
    clonedTemplate.querySelector(".card-select").dataset.cardId = cardObject.card_id
    clonedTemplate.querySelector(".delete_card").dataset.cardId = cardObject.card_id

    clonedTemplate.querySelector(".cardHolderName").textContent = cardObject.name
    clonedTemplate.querySelector(".lastFourNumbers").textContent = cardObject.card_last_four_digit

    clonedTemplate.querySelector(".card_month_expire").textContent = cardObject.card_month_expire
    clonedTemplate.querySelector(".card_year_expire").textContent = cardObject.card_year_expire

    clonedTemplate.querySelector(".cardIconHolder").append(getCardIcon(cardObject.card_brand))
    return clonedTemplate
}

function getCardIcon(card_brand) {
    switch (card_brand) {
        case 'visa':

            if (document.getElementById('visaCard')) {
                let cardIconTemplate = document.getElementById("visaCard")
                return cardIconTemplate.content.cloneNode(true)
            }

        case 'mastercard':

            if (document.getElementById('mastercardCard')) {
                let cardIconTemplate = document.getElementById("mastercardCard")
                return cardIconTemplate.content.cloneNode(true)
            }

        case 'amex':
            if (document.getElementById('amexCard')) {
                let cardIconTemplate = document.getElementById("amexCard")
                return cardIconTemplate.content.cloneNode(true)
            }
        case 'Discover':
            if (document.getElementById('discoverCard')) {
                let cardIconTemplate = document.getElementById("discoverCard")
                return cardIconTemplate.content.cloneNode(true)
            }
        case 'Diners Club':
            if (document.getElementById('dinersClubCard')) {
                let cardIconTemplate = document.getElementById("dinersClubCard")
                return cardIconTemplate.content.cloneNode(true)
            }
        case 'UnionPay':
            if (document.getElementById('unionPayCard')) {
                let cardIconTemplate = document.getElementById("unionPayCard")
                return cardIconTemplate.content.cloneNode(true)
            }
        case 'JCB':
            if (document.getElementById('JCBCard')) {
                let cardIconTemplate = document.getElementById("JCBCard")
                return cardIconTemplate.content.cloneNode(true)
            }
        case 'Cartes Bancaires':
            if (document.getElementById('cartesBancairesCard')) {
                let cardIconTemplate = document.getElementById("cartesBancairesCard")
                return cardIconTemplate.content.cloneNode(true)
            }
        case 'paypal':
            if (document.getElementById('paypalCard')) {
                let cardIconTemplate = document.getElementById("paypalCard")
                return cardIconTemplate.content.cloneNode(true)
            }
        case 'Interac':
            if (document.getElementById('interacCard')) {
                let cardIconTemplate = document.getElementById("interacCard")
                return cardIconTemplate.content.cloneNode(true)
            }
    }
}

function initializeStripe() {
    loadScript('https://js.stripe.com/v3/', function () {

        let stripe_key = document.getElementById('spck').value
        var stripe = Stripe(stripe_key)
        var elements = stripe.elements()

        window.styleZ = {
            base: {
                fontWeight: 300,
                fontFamily: 'sans-serif',
                fontSize: '16px',

                ':focus': {
                    color: '#1d293f',
                },

                '::placeholder': {
                    color: '#999',
                },

                ':focus::placeholder': {
                    color: '#CFD7DF',
                },
            },
            invalid: {
                color: '#fff',
                ':focus': {
                    color: '#FA755A',
                },
                '::placeholder': {
                    color: '#FFCCA5',
                },
            },
        }

        window.card = elements.create('card', {
            iconStyle: 'solid',
            style: styleZ,
        })

        if (document.getElementById('card-element')) {
            card.mount('#card-element')
        }

        //this is used for stripe payment on settings wallet and video extend

        if (document.getElementById('pay_via_stripe_cachsier')) {

            document.getElementById('pay_via_stripe_cachsier').addEventListener('click', function () {

                openPaymentPopuper(getPoTranslate('PROCESSING_STRIPE_PAYMENT'))
bookingPayment()
                /* try {
                    bookingPayment()
                } catch (err) {
                    Sentry.captureException(new TryCatchBookingPaymentFunction(err))
                } */

            })

            function bookingPayment() {

                

                    if (document.body.className === "settings_wallets") {
                        //this part is used for add coins from wallet payments: stripe and automatic pay pal payment

                        let activeCard = document.getElementById('stripeerCont')?.getElementsByClassName('active')[0]
                        if (!activeCard) {
                            closePopup('specialLoading')
                            toastify(getPoTranslate('PLEASE_SELECT_A_CARD'))
                            return
                        }
                        let defaultCardElement = activeCard.dataset.cardId
                        let amount = parseFloat(document.getElementById('online_amount').value)
                        let payment_type, url


                        payment_type = 'stripe'
                        url = "/frontend/api/deposite-in-wallet"


                        let params = {

                            selected_card_data: {
                                "card_id": defaultCardElement
                            },
                            amount: amount,
                            _token: token,
                            payment_type: payment_type
                        }

                        let xhr = new XMLHttpRequest()

                        xhr.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {

                                let response = JSON.parse(this.responseText)

                                if (response.depositeInWallet.success == true) {

                                    if (response.depositeInWallet.hasOwnProperty('data')) {

                                        if (response.depositeInWallet.data.hasOwnProperty('redirect')) {
                                            let origins = location.origin

                                            if (origins.includes('www.')) {
                                                origins.replace('www.', '')
                                            }

                                            location.assign(origins + response.depositeInWallet.data.redirect)
                                        }

                                    } else {

                                        toastify(response.depositeInWallet.message)

                                        let ballance = response.wallet_balance
                                        let ballanceDiv = document.getElementById('Profile').getElementsByClassName('available_balance')[0]
                                        let coinsToAdd = new Intl.NumberFormat(getCookie('activeLang'), { style: 'currency', currency: 'EUR' }).format(parseFloat(ballance) ).replace(/[^0-9.,]/g, '')

                                        ballanceDiv.textContent = coinsToAdd
                                        closePopup('specialLoading')

                                        closePopup('addCoinsPaymentPopUp')
                                    }

                                } else {
                                    closePopup('specialLoading')


                                    toastify(response.depositeInWallet.message)

                                }

                            }
                        }

                        xhr.open("POST", url, true)

                        xhr.onerror = function () {
                            closePopup('specialLoading')
                            /* Sentry.captureException(new depositInWalletPaymentStripeError_settingsWallet('status: ' + this.statusText + '|| response: ' +
                                this.statusText + ' || url: ' + location.href)) */
                        }

                        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8")
                        xhr.setRequestHeader('Authorization', bearerToken)
                        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

                        xhr.send(JSON.stringify(params))
                    } else if (document.body.className === "video_conference") {

                        //this part is used for video talk extend payments: stripe and automatic pay pal payment

                        let activeCardEl = document.getElementById('stripeerCont')?.getElementsByClassName('active')[0]
                        if (!activeCardEl) {
                            closePopup('specialLoading')
                            toastify(getPoTranslate('PLEASE_SELECT_A_CARD'))
                            return
                        }
                        let defaultCardElement = activeCardEl.parentElement.parentElement
                        let  url, payment_type, date_time

                        url = "/frontend/api/book-extension"
                        payment_type = 'stripe'


                        let booking_obj = JSON.parse(document.getElementById('bookingObjVideoTalk').textContent)

                        let params = {
                            booking_id: booking_obj.id,
                            talk_id: booking_obj.talk_id,
                            selected_card_data: {
                                "card_id": defaultCardElement.dataset.cardId
                            },
                            payment_type: payment_type,

                            _token: token,
                            date_time: date_time,
                            extension_time: parseInt(document.getElementById('paymentWalletPopUp').getElementsByClassName('extend_call_time')[0].textContent)
                        }



                        let xhr = new XMLHttpRequest()
                        xhr.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {

                                let response = JSON.parse(this.responseText)

                                if (response.success == true) {

                                    if (response.data.hasOwnProperty('redirect')) {

                                        if (response.data.redirect == null) {
                                            //toastify(response.message)
                                            closePopup('paymentWalletPopUp')

                                            let thatsMe
                                            for (let i = 0; i < others.length; i++) {
                                                if (others[i].user_id === userObj1.id) {
                                                    thatsMe = {
                                                        name: others[i].name_of_user,
                                                        profile_picture: others[i].user_image
                                                    }
                                                }

                                            }
                                            EXTEND_CALL_SUCCESSFUL_Send_Event_Function(call, thatsMe, window.extendTalkParameters)
                                            hideLoading()
                                            openPopup('paymentCompletedPopUp')

                                            setTimeout(function () {
                                                closePopup('paymentCompletedPopUp')
                                            }, 5000)

                                            /*    if (window.innerHeight > 767) {
                                                   document.getElementById('extendThisCallLi').style.left = "100%"
                                               } else {
                                                   document.getElementById('extendThisCallLi').style.top = "calc(100vh + 80px)"
                                               }
                                            */
                                            closePopup('specialLoading')
                                        } else {
                                            document.getElementById('specialLoading').style.zIndex = '9999999999999999999999999999999999999'
                                            let origins = location.origin

                                            if (origins.includes('www.')) {
                                                origins.replace('www.', '')
                                            }

                                            location.assign(origins + response.data.redirect)
                                        }

                                    }




                                } else {

                                    hideLoading()

                                    if (document.getElementById('errorMessageVideoTalk')) {
                                        let errorMessageVideoTalk = document.getElementById('errorMessageVideoTalk')
                                        errorMessageVideoTalk.classList.remove('dn')
                                        errorMessageVideoTalk.textContent = response.message
                                        setTimeout(function () {
                                            errorMessageVideoTalk.classList.add('dn')
                                        }, 5000)
                                    } else {
                                        toastify(response.message)
                                    }

                                    closePopup('specialLoading')

                                }


                            }

                        }

                        xhr.open("POST", url, true)

                        xhr.onerror = function () {
                            hideLoading()
                            closePopup('specialLoading')
                           /*  Sentry.captureException(new bookExtensionPaymentStripeError_videoConference('status: ' + this.statusText + '|| response: ' +
                                this.statusText + ' || url: ' + location.href)) */
                        }

                        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8")
                        xhr.setRequestHeader("X-CSRF-TOKEN", token)
                        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))
                        xhr.setRequestHeader('Authorization', bearerToken)
                        xhr.send(JSON.stringify(params))

                    }else{

                        let activeCard = document.getElementById('stripeerCont')?.getElementsByClassName('active')[0]
                        if (!activeCard) {
                            closePopup('specialLoading')
                            toastify(getPoTranslate('PLEASE_SELECT_A_CARD'))
                            return
                        }
                        let defaultCardElement = activeCard.dataset.cardId
                        let amount = parseFloat(document.getElementById('online_amount').value)
                        let payment_type, url


                            payment_type = 'stripe'
                            url = "/frontend/api/deposite-in-wallet"

                        let params = {

                            selected_card_data: {
                                "card_id": defaultCardElement
                            },
                            amount: amount,
                            _token: token,
                            payment_type: payment_type
                        }

                        let xhr = new XMLHttpRequest()

                        xhr.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {

                                let response = JSON.parse(this.responseText)


                                if (response.depositeInWallet.success == true) {

                                    if (response.depositeInWallet.hasOwnProperty('data')) {

                                        if (response.depositeInWallet.data.hasOwnProperty('redirect')) {
                                            let origins = location.origin

                                            if (origins.includes('www.')) {
                                                origins.replace('www.', '')
                                            }

                                            location.assign(origins + response.depositeInWallet.data.redirect)
                                        }

                                    } else {

                                        toastify(response.depositeInWallet.message)

                                        closePopup('specialLoading')

                                        closePopup('addCoinsPaymentPopUp')
                                        closePopup('blankPopup')
                                    }

                                } else {
                                    closePopup('specialLoading')


                                    toastify(response.depositeInWallet.message)

                                }

                            }
                        }

                        xhr.open("POST", url, true)

                        xhr.onerror = function () {
                            closePopup('specialLoading')
                           /*  Sentry.captureException(new depositInWalletPaymentStripeError_settingsWallet('status: ' + this.statusText + '|| response: ' +
                                this.statusText + ' || url: ' + location.href)) */
                        }

                        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8")
                        xhr.setRequestHeader('Authorization', bearerToken)
                        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

                        xhr.send(JSON.stringify(params))
                    }


                /* } catch (err) {
                    Sentry.captureException(new TryCatchBlockBookingPaymentFunction(err))
                } */
            }


            class TryCatchBookingPaymentFunction extends Error {
                constructor(message) {
                    super(message)
                    this.name = "TryCatchBookingPaymentFunction"
                }
            }

            class depositInWalletPaymentStripeError_settingsWallet extends Error {
                constructor(message) {
                    super(message)
                    this.name = "depositInWalletPaymentStripeError_settingsWallet"
                }
            }

            class bookExtensionPaymentStripeError_videoConference extends Error {
                constructor(message) {
                    super(message)
                    this.name = "bookExtensionPaymentStripeError_videoConference"
                }
            }

            class TryCatchBlockBookingPaymentFunction extends Error {
                constructor(message) {
                    super(message)
                    this.name = "TryCatchBlockBookingPaymentFunction"
                }
            }
        }

        //this is for adding stripe cards
        if (document.getElementsByClassName('creditCardReset')[0]) {
            let creditCardResets = document.getElementsByClassName('creditCardReset')

            for (let i = 0; i < creditCardResets.length; i++) {
                creditCardResets[i].addEventListener('click', function () {
                    showLoading()

                    window.cardAddingClicked = 1
                    //card.destroy()
                    card.destroy()

                    try {
                        getCreditCard()
                    } catch (err) {
                        Sentry.captureException(new TryCatchAddCardToWalletXMLHttpRequestFunction(err));
                    }

                    function getCreditCard() {

                        let xhr = new XMLHttpRequest()

                        xhr.onloadstart = function () {
                            showLoading()
                        }

                        xhr.onreadystatechange = function () {

                            if (this.readyState == 4 && this.status == 200) {

                                let response = JSON.parse(this.response)

                                if (response) {

                                    document.getElementById('carderPopuper').innerHTML = response.html
                                    document.getElementById('cardPopUp').getElementsByClassName('closeSpanPopup')[0].addEventListener('click', function () {
                                        closePopup('cardPopUp')
                                    })

                                    openPopup('cardPopUp')

                                    addCreditCardSubmit(stripe)

                                    window.card = elements.create('card', {
                                        theme: 'night',
                                        iconStyle: 'solid',
                                        style: styleZ,
                                    })

                                    if (document.getElementById('card-element')) {
                                        card.mount('#card-element')
                                    }

                                } else {
                                    toastify(response.message)
                                }

                                hideLoading()
                            }
                        }

                        xhr.onloadend = function () {
                            hideLoading()

                        }

                        xhr.onerror = function (error) {
                            toastify(this.statusText)
                            Sentry.captureException(new SubmitFeedbackSubmitError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
                        }

                        xhr.open("GET", "/add-stripe-card", true)

                        xhr.setRequestHeader("Content-Type", "application/text;charset=UTF-8");
                        xhr.setRequestHeader('Authorization', bearerToken);
                        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'));

                        xhr.send()


                    }

                    let cardHolderInput = document.getElementById('card_holder_name')
                    let parent = cardHolderInput.parentElement

                    cardHolderInput.classList.remove('ok')
                    cardHolderInput.classList.remove('error')
                    cardHolderInput.value = ''
                    parent.getElementsByClassName('verified-svg')[0].classList.remove('active')
                    parent.getElementsByClassName('default-warn')[0].classList.remove('active')
                    parent.getElementsByClassName('input-label')[0].style.color = 'rgba(155, 172, 200, 1)'
                })

            }
        }

        //this is stripe payment on booking funnel
        if (document.getElementById('add_wallet_booking_cachier')) {

            document.getElementById('add_wallet_booking_cachier').addEventListener('click', function () {


                if (this.dataset.payment === 'paymentTalkila') {
                    openPaymentPopuper(getPoTranslate('PROCESSING_PAYMENT'))
                } else {
                    openPaymentPopuper(getPoTranslate('PROCESSING_STRIPE_PAYMENT'))
                }

                try {
                    bookingPayment()
                } catch (err) {
                    Sentry.captureException(new TryCatchAddCardToWalletXMLHttpRequestFunction(err));
                }
            })

            function bookingPayment() {

                try {

                    let activeCard = document.getElementsByClassName('stripe_cards_without_delete')[0]?.getElementsByClassName('active')[0]

                    let paymentMethod = document.getElementById('paymentTabsUl')?.getElementsByClassName('is-active')[0].dataset.card

                    try {
                        let bookingObj = JSON.parse(getCookie('bookingObj'))
                        let token = document.querySelector('meta[name="csrf-token"]').content

                        let amount = parseFloat(document.getElementById('moneyContar').value)
                        let payment_type, url

                        if (activeCard) {
                            if (activeCard.dataset.pointer === 'paypal') {
                                payment_type = 0
                                url = envAppBackendUrl + "/paypal-payment"
                            } else {
                                payment_type = 'stripe'
                                url = "/frontend/api/bookings"
                            }
                        } else {
                            url = "/frontend/api/bookings"
                        }

                        let params = {
                            account_id: activeCard?.dataset.cardId,
                            selected_card_data: {
                                "card_id": activeCard?.dataset.cardId
                            },
                            payment_method: paymentMethod,
                            talk_id: document.getElementsByClassName('dataTalkId')[0].dataset.talkId,
                            teacher_id: document.getElementsByClassName('step1username')[0].dataset.id,
                            start_call: bookingObj.bookingDate + ' ' + bookingObj.bookingTime[0],
                            date_time: bookingObj.bookingDate + ' ' + bookingObj.bookingTime[0],
                            anonym: bookingObj.anonymousMeeting,
                            amount: amount,
                            _token: token,
                            payment_type: payment_type


                        }

                        let xhr = new XMLHttpRequest()
                        xhr.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {

                                let response = JSON.parse(this.responseText)

                                if (response.success == true) {
                                    if (response.hasOwnProperty('data')) {
                                        if (response.data.hasOwnProperty('redirect')) {


                                            let origins = location.origin
                                            if (origins.includes('www.')) {
                                                origins.replace('www.', '')
                                            }

                                            location.assign(location.origin + response.data.redirect)


                                        } else {

                                            document.cookie = 'bookingObj=; Path=/booking-payment; Expires=Thu, 01 Jan 1970 00:00:01 GMT;'


                                            location.assign(location.origin + '/booking-thank-you')
                                        }
                                    }

                                } else {

                                    closePopup('specialLoading')
                                    toastify(response.message)


                                }

                            }
                        }

                        xhr.open("POST", url, true)

                        xhr.onerror = function () {
                            closePopup('specialLoading')
                            Sentry.captureException(new SendCCDetaulsToBe('status: ' + this.statusText + '|| response: ' +
                                this
                                    .statusText + ' || url: ' + location.href))
                        }


                        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                        xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'));
                        xhr.setRequestHeader('Authorization', bearerToken)
                        xhr.send(JSON.stringify(params))
                    } catch (error) {
                        console.log(error)

                        toastify(getPoTranslate('PAYMENT_OBJECT_HAS_EXPIRED_PLEASE_RESTART_BOOKING_PROCESS'))
                        setTimeout(function () {
                            location.assign('')
                        }, 3000)

                    }


                } catch (err) {
                    console.log(err)
                    Sentry.captureException(new TryBookingPayment(err))
                }
            }



            class SendCCDetaulsToBe extends Error {
                constructor(message) {
                    super(message)
                    this.name = "SendCCDetaulsToBe"
                }
            }

            class TryBookingPayment extends Error {
                constructor(message) {
                    super(message)
                    this.name = "TryBookingPayment"
                }
            }
        }
    })

    class TryCatchBookingPaymentFunction extends Error {
        constructor(message) {
            super(message)
            this.name = "TryCatchBookingPaymentFunction"
        }
    }
    class depositInWalletPaymentStripeError_settingsWallet extends Error {
        constructor(message) {
            super(message)
            this.name = "depositInWalletPaymentStripeError_settingsWallet"
        }
    }
    class bookExtensionPaymentStripeError_videoConference extends Error {
        constructor(message) {
            super(message)
            this.name = "bookExtensionPaymentStripeError_videoConference"
        }
    }

}

//chose card for payment, not set as default
function selectCardForPayment() {
    if(document.getElementById('stripeerCont')?.getElementsByClassName("set_default_card")[0]){
        let cardItems = document.getElementById('stripeerCont').getElementsByClassName("set_default_card")

        for (let i = 0; i < cardItems.length; i++) {

            cardItems[i].addEventListener('click', selectPaymentCard)
        }
    }

}

function selectPaymentCard(e) {

    let cardForPayment = e.currentTarget

    if (document.getElementById('stripeerCont').getElementsByClassName('active')[0]) {
        document.getElementById('stripeerCont').getElementsByClassName('active')[0].classList.remove('active')
    }
    if (document.getElementById('stripeerCont').getElementsByClassName('pon')[0]) {
        document.getElementById('stripeerCont').getElementsByClassName('pon')[0].classList.remove('pon')
    }
    cardForPayment.getElementsByClassName('card-select')[0].classList.add('active')
    cardForPayment.classList.add('pon')
}

function selectDefaultCard() {

    let set_default_cards = document.getElementsByClassName('card-list')[0].getElementsByClassName('set_default_card')
    for (let i = 0; i < set_default_cards.length; i++) {
        set_default_cards[i].addEventListener('click', selectDefaultCardHelper)

    }

}

function selectDefaultCardHelper(e) {


    let defaultCardElement = e.currentTarget
    showLoading()
    let xhr = new XMLHttpRequest()
    let url = envAppBackendUrl + '/payment-methods/update'

    let params = {
        'id': defaultCardElement.dataset.cardId
    }

    xhr.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.response)

            if (response.success === true) {

                removeActivePointerCreditCardsPointers()

                let cardItems = document.getElementById('stripeerCont').getElementsByClassName('set_default_card')
                for (let j = 0; j < cardItems.length; j++) {
                    if (cardItems[j].dataset.cardId === defaultCardElement.dataset.cardId) {
                        cardItems[j].getElementsByClassName('card-select')[0].classList.add('active')
                        cardItems[j].classList.add('pon')
                    }
                }

                defaultCardElement.parentElement.getElementsByClassName('delete_card')[0].classList.add('dn')
                defaultCardElement.getElementsByClassName('card-select')[0].classList.add('active')
                defaultCardElement.classList.add('pon')

                toastify(response.message)

            } else if (response.success === false) {
                toastify(response.message)
            }


            hideLoading()
        }
    }

    xhr.onloadend = function () {
        hideLoading()
    }

    xhr.onerror = function (error) {
        hideLoading()
        toastify(this.statusText)
        Sentry.captureException(new SubmitSetDefaultCreditCardError(error + 'status: ' + this
            .statusText +
            '|| response: ' + this.statusText + ' || url: ' + location.href));
    }

    xhr.open('PATCH', url, true)

    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
    xhr.setRequestHeader('Authorization', bearerToken)


    xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

    xhr.send(JSON.stringify(params))

    class SubmitSetDefaultCreditCardError extends Error {
        constructor(message) {
            super(message)
            this.name = "SubmitSetDefaultCreditCardError"
        }
    }

}

function removeActivePointerCreditCardsPointers() {

    removeActivePointerFromNoDeleteCardList()

    if (document.body.className === 'settings_wallets') {

        removeActivePointers(document.getElementsByClassName('card-list')[0])
    } else if (document.body.className === 'book_slot_payment') {
        removeActivePointers(document.getElementsByClassName('stripe_cards_without_delete')[0])
    }

}

function removeActivePointers(cardList) {

    cardList.getElementsByClassName('active')[0]?.classList.remove('active')
    cardList.getElementsByClassName('pon')[0]?.classList.remove('pon')

    if (cardList.getElementsByClassName('delete_card')[0]) {

        let deleteCards = cardList.getElementsByClassName('delete_card')
        for (let i = 0; i < deleteCards.length; i++) {
            if (deleteCards[i].classList.contains('dn')) {
                deleteCards[i].classList.remove('dn')
            }

        }
    }
}

function deleteCards() {

    let deleteButtons = document.getElementsByClassName('card-list')[0].getElementsByClassName('delete_card')

    for (let i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener('click', function () {

            document.getElementById('delete_card_id').value = this.dataset.cardId
            openPopup('deleteStripeCardPopUp')

        })
    }

    document.getElementsByClassName('deletecard')[0].addEventListener('click', cardDelete)
    document.getElementsByClassName('canceldeletecard')[0].addEventListener('click', clearDeleteCardsEventsAndCloseDeleteCardsPrePopup)
    document.getElementById('deleteStripeCardPopUp').addEventListener('click', clearDeleteCardsEventsAndCloseDeleteCardsPrePopup)
}

function deleteCardHelper(e) {

    document.getElementById('delete_card_id').value = this.dataset.cardId
    openPopup('deleteStripeCardPopUp')

}

function clearDeleteCardsEventsAndCloseDeleteCardsPrePopup() {


    document.getElementById('delete_card_id').value = ''
    closePopup('deleteStripeCardPopUp')


}

function cardDelete() {



    showLoading()
    let xhr = new XMLHttpRequest()
    let url = envAppBackendUrl + '/payment-methods/delete'

    let params = {
        'id': document.getElementById('delete_card_id').value

    }


    xhr.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.response)

            if (response.success === true) {








                let cards = document.getElementsByClassName('set_default_card')
                for (let j = 0; j < cards.length; j++) {
                    if (cards[j].dataset.cardId === document.getElementById('delete_card_id').value) {
                        let cardWrapper = cards[j].parentElement
                        cardWrapper.style.scale = '0'
                        setTimeout(function () {
                            cardWrapper.remove()

                            setTimeout(function () {
                                let deleteButtons = document.getElementsByClassName('card-list')[0].getElementsByClassName('delete_card')

                                if (deleteButtons.length === 1) {
                                    deleteButtons[0].classList.remove('dn')
                                }
                            })

                        }, 310)
                    }

                }

                toastify(response.message)



                clearDeleteCardsEventsAndCloseDeleteCardsPrePopup()




                if (document.getElementsByClassName('card-list')[0].getElementsByClassName('delete_card').length === 1) {

                    let coinsAddPopupNoCards = document.createElement('p')
                    coinsAddPopupNoCards.className = 'noCardsAdded text-center m0'
                    coinsAddPopupNoCards.textContent = getPoTranslate('NO_CARDS')

                    document.getElementsByClassName('card-list')[0].append(coinsAddPopupNoCards)


                    document.getElementsByClassName('stripe_cards_without_delete')[0].append(coinsAddPopupNoCards.cloneNode(true))

                }



            } else if (response.success === false) {
                toastify(response.message)
            }


            hideLoading()
        }
    }

    xhr.onloadend = function () {

        hideLoading()
    }

    xhr.onerror = function (error) {
        hideLoading()
        toastify(this.statusText)
        Sentry.captureException(new SubmitDeleteCreditCardsError(error + 'status: ' + this
            .statusText +
            '|| response: ' + this.statusText + ' || url: ' + location.href));
    }

    xhr.open('DELETE', url, true)

    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
    xhr.setRequestHeader('Authorization', bearerToken)


    xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

    xhr.send(JSON.stringify(params))

    class SubmitDeleteCreditCardsError extends Error {
        constructor(message) {
            super(message)
            this.name = "SubmitDeleteCreditCardsError"
        }
    }

}



/***/ }),

/***/ "./src/assets/js/profileMenu.js":
/*!**************************************!*\
  !*** ./src/assets/js/profileMenu.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "openProfileMenu": () => (/* binding */ openProfileMenu)
/* harmony export */ });
function openProfileMenu() {


    if (document.getElementById('profile-menu')) {
        document.getElementById('profile-menu').addEventListener('click', function (e) {
            e.preventDefault()
            e.stopImmediatePropagation()
            e.stopPropagation()
        })
    }

    if (document.getElementsByClassName('linkTopProfileDropdown')[0]) {
        document.getElementsByClassName('linkTopProfileDropdown')[0].addEventListener('click', function () {
            closeMainDropdownMenu()
            location.href = this.href
        })
    }

    if (document.getElementById('profile-menuParent')) {
        if (document.getElementById('profile-menuParent').getElementsByClassName('menu-bar')[0]) {
            let allDropdownMenuBars = document.getElementById('profile-menuParent').getElementsByClassName('menu-bar')
            for (let i = 0; i < allDropdownMenuBars.length; i++) {
                let liItemsWithATag = allDropdownMenuBars[i].getElementsByTagName('li')
                for (let i = 0; i < liItemsWithATag.length; i++) {
                    liItemsWithATag[i].addEventListener('click', function () {
                        if (this.getElementsByTagName('a')[0]) {

                            closeMainDropdownMenu()
                            location.href = this.getElementsByTagName('a')[0].href

                        } else {

                            closeMainDropdownMenu()
                        }
                    })
                }
            }
        }
    }


    if (document.getElementsByClassName('closeDropDownMenu')[0]) {
        let closeDropDownMenu = document.getElementsByClassName('closeDropDownMenu')[0]
        closeDropDownMenu.addEventListener('click', function (e) {
            closeMainDropdownMenu()
        })
    }


    if (document.getElementsByClassName('profile-area2')[0] && document.getElementById('profile-img')) {

        document.getElementsByClassName('profile-area2')[0].addEventListener('click', function () {

            let profileMenu = document.getElementById('profile-menuParent')
            let profileMenuChild = document.getElementById('profile-menu')

            if (this.dataset.opened === "0") {


                profileMenu.style.display = "block"

                setTimeout(function () {
                    profileMenu.style.opacity = '1'

                    profileMenuChild.style.top =    "0px"

                })

                this.dataset.opened = 1

                document.addEventListener('keydown', pressEscape, false)
                document.addEventListener('click', checkIfIsInOptionButton, false)

            } else {

                closeMainDropdownMenu()
            }

        })
    }
}

function closeMainDropdownMenu() {

    let languageCell = document.getElementsByClassName('languageCell')
    let languageList = document.getElementsByClassName('languageList')[0]

    if (languageCell[0].dataset.opened === "1") {
        languageList.style.height = '0px'
        languageList.style.border = '1px solid transparent'
        languageList.style.boxShadow = 'inset 0 0 0 0px rgba(6, 4, 3, 0.1)'
        languageCell[0].dataset.opened = 0
    }

    document.getElementById('profile-menu').style.top = "-1000px"


    setTimeout(function () {
        document.getElementsByClassName('profile-area2')[0].dataset.opened = "0"
        document.getElementById('profile-menuParent').style.opacity = '0'
        setTimeout(function () {
            document.getElementById('profile-menuParent').style.display = 'none'
        }, 310)
    }, 10)
    document.removeEventListener('click', checkIfIsInOptionButton, false)
    document.removeEventListener('keydown', pressEscape, false)

    if(document.getElementById('mainLanguageCell')){
        if(document.getElementById('mainLanguageCell').getElementsByClassName('rotate90')[0]){
            document.getElementById('mainLanguageCell').getElementsByClassName('rotate90')[0].style.transform = 'rotate(90deg) scale(1, 1)'
        }
    }
}

function checkIfIsInOptionButton(event) {

    if (event.currentTarget.id === "profile-menuParent" || event.currentTarget.className === "closeDropDownMenu") {
        closeMainDropdownMenu()
    }


}

function pressEscape(e) {

    if (e.key === "Escape") {
        closeMainDropdownMenu()
    }
}


/***/ }),

/***/ "./src/assets/js/routeController.js":
/*!******************************************!*\
  !*** ./src/assets/js/routeController.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "routeController": () => (/* binding */ routeController)
/* harmony export */ });
/* harmony import */ var _routeHelpers_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./routeHelpers.js */ "./src/assets/js/routeHelpers.js");
/* harmony import */ var _payment_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./payment.js */ "./src/assets/js/payment.js");
/* harmony import */ var _talks_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./talks.js */ "./src/assets/js/talks.js");
/* harmony import */ var _loggedOut_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./loggedOut.js */ "./src/assets/js/loggedOut.js");
/* harmony import */ var _comunicationControler_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./comunicationControler.js */ "./src/assets/js/comunicationControler.js");














function logged_inF() {


    talksAndAvailabilityF();
    (0,_talks_js__WEBPACK_IMPORTED_MODULE_2__.pauseTalks)();

    //intersectionObserveer for scrolling header
    const target = document.getElementById('buttonConta');

    function handleIntersection(entries) {
        entries.map((entry) => {
            if (entry.isIntersecting) {

                document.getElementById('intersectTester').style.top = '-100px'
            } else {

                document.getElementById('intersectTester').style.top = '0px'

            }
        });
    }

    const observer = new IntersectionObserver(handleIntersection);

    observer.observe(target);

    (0,_routeHelpers_js__WEBPACK_IMPORTED_MODULE_0__.calendarLogics)()

    const queryString = window.location.search
    const urlParams = new URLSearchParams(queryString)
    const code = urlParams.get('code')

    if (code) {
        history.pushState({}, document.title, location.origin + location.pathname)
    }

    if (document.getElementsByClassName('shareTalk')[0]) {
        let shareTalks = document.getElementsByClassName('shareTalk')
        for (let i = 0; i < shareTalks.length; i++) {
            shareTalks[i].addEventListener('click', function () {

                let talkId = shareTalks[i].parentElement.getElementsByClassName('dataTalkId')[0].dataset.talkId
                let talkName = shareTalks[i].parentElement.getElementsByClassName('headlineTextSpecific')[0].textContent
                let talkIdHolder = document.getElementById('shareProfilePopUp').getElementsByClassName('profile-path-holder22')[0]

                talkIdHolder.value = talkIdHolder.value.substring(0, talkIdHolder.value.lastIndexOf('/')) + '/' + talkId

                let nativeShareLink = document.getElementById('shareProfilePopUp').getElementsByClassName('nativeSharez')[0]
                nativeShareLink.dataset.link = nativeShareLink.dataset.linker + talkId

                let talkSherers = document.getElementById('shareProfilePopUp').getElementsByClassName('talkSherer')
                for (let i = 0; i < talkSherers.length; i++) {
                    talkSherers[i].href = talkSherers[i].href + talkId

                }

                let talk_headline = document.getElementById('shareProfilePopUp').getElementsByClassName('talk_headline')[0]
                talk_headline.textContent = talkName
            })

        }

        if (document.getElementById('shareProfilePopUp')) {
            document.getElementById('shareProfilePopUp').addEventListener('click', function () {
                closeQrs()
            })

            document.getElementById('shareProfilePopUp').getElementsByClassName('closeSpanPopup')[0].addEventListener('click', function () {
                closeQrs()
            })
        }

        function closeQrs() {
            document.getElementById('shareProfilePopUp').getElementsByClassName('closeQR')[0].click()
        }
    }

}

function homeF() {
    (0,_loggedOut_js__WEBPACK_IMPORTED_MODULE_3__.loggedOutHome)();

    loadScript('/frontend/assets/js/accordion.js' + version, function () {

    });
}

function faqF() {

    loadScript('/frontend/assets/js/accordion.js' + version, function () {

    });
}

function profileF() {

    loadScript('/frontend/assets/js/accordion.js' + version, function () {

    });

    (0,_routeHelpers_js__WEBPACK_IMPORTED_MODULE_0__.followUnfollowUserOptions)();
    (0,_loggedOut_js__WEBPACK_IMPORTED_MODULE_3__.showMoreTalks)();

    if (document.getElementsByClassName('playButtonProfile')[0]) {
        document.getElementsByClassName('playButtonProfile')[0].addEventListener('click', function () {
            showLoading()



            let helpDiv = document.createElement('div')
            helpDiv.innerHTML = document.getElementById('youTubeIframe').value

            let srcs = helpDiv.getElementsByTagName('iframe')[0].src
            helpDiv.getElementsByTagName('iframe')[0].src = srcs.split('?')[0].split('&')[0].split('#')[0]


            document.getElementById('innerVideoContainer').innerHTML = helpDiv.innerHTML
            setTimeout(function () {
                openPopup('videoPopup')
                setTimeout(function () {
                    hideLoading()
                })
            }, 510)

        })
    }
    if (document.getElementsByClassName('closinger')[0]) {
        document.getElementsByClassName('closinger')[0].addEventListener('click', function () {
            closePopup('videoPopup');
            document.getElementById('innerVideoContainer').innerHTML = '';
        });
    }

    if (document.getElementsByClassName('userBlcok')[0]) {

        let userBlocks = document.getElementsByClassName('userBlcok')


        window.userUnblock = function (e) {


            showLoading()
            let xhr = new XMLHttpRequest()
            let url = envAppBackendUrl + '/user-unblock'

            let params = {
                '_token': token,
                'teacher_id': e.dataset.userId
            }


            xhr.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.response)

                    if (response.success === true) {
                        for (let j = 0; j < userBlocks.length; j++) {
                            userBlocks[j].textContent = getPoTranslate('BLOCK')
                            userBlocks[j].removeEventListener('click', userUnblock)
                            userBlocks[j].setAttribute('onClick', 'userBlock(this)')
                        }

                        document.getElementsByClassName('thisUserIsBlocked')[0].classList.add('dn')


                        toastify(response.message)


                    } else if (response.success === false) {
                        toastify(response.message)
                    }


                    hideLoading()
                }
            }

            xhr.onloadend = function () {

                hideLoading()
            }

            xhr.onerror = function (error) {
                hideLoading()
                toastify(this.statusText)
                Sentry.captureException(new SubmitRemovePrivateFallowing(error + 'status: ' + this
                    .statusText +
                    '|| response: ' + this.statusText + ' || url: ' + location.href));
            }

            xhr.open('POST', url, true)

            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
            xhr.setRequestHeader('Authorization', bearerToken)
            xhr.setRequestHeader('X-CSRF-TOKEN', token)

            xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

            xhr.send(JSON.stringify(params))
        }

        window.userBlock = function (e) {

            showLoading()
            let xhr = new XMLHttpRequest()
            let url = envAppBackendUrl + '/user-block'

            let params = {
                '_token': token,
                'teacher_id': e.dataset.userId
            }


            xhr.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.response)

                    if (response.success === true) {
                        for (let j = 0; j < userBlocks.length; j++) {
                            userBlocks[j].textContent = getPoTranslate('UNBLOCK')
                            userBlocks[j].removeEventListener('click', userBlock)
                            userBlocks[j].setAttribute('onClick', 'userUnblock(this)')
                        }

                        document.getElementsByClassName('thisUserIsBlocked')[0].classList.remove('dn')



                        toastify(response.message)


                    } else if (response.success === false) {
                        toastify(response.message)
                    }


                    hideLoading()
                }
            }

            xhr.onloadend = function () {

                hideLoading()
            }

            xhr.onerror = function (error) {
                hideLoading()
                toastify(this.statusText)
                Sentry.captureException(new SubmitRemovePrivateFallowing(error + 'status: ' + this
                    .statusText +
                    '|| response: ' + this.statusText + ' || url: ' + location.href));
            }

            xhr.open('POST', url, true)

            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
            xhr.setRequestHeader('Authorization', bearerToken)
            xhr.setRequestHeader('X-CSRF-TOKEN', token)

            xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

            xhr.send(JSON.stringify(params))
        }



        class SubmitRemovePrivateFallowing extends Error {
            constructor(message) {
                super(message)
                this.name = "SubmitRemovePrivateFallowing"
            }
        }


    }


    if (document.getElementsByClassName('openShareForTeacher')[0]) {
        let openShareForTeacher = document.getElementsByClassName('openShareForTeacher')
        for (let i = 0; i < openShareForTeacher.length; i++) {

            openShareForTeacher[i].addEventListener('click', function () {
                window.sharePopupTakl = 1
                openPopup('shareProfilePopUpEr')
                let hiddenElements = document.getElementById('shareProfilePopUpEr').getElementsByClassName('k1ff')
                for (let i = 0; i < hiddenElements.length; i++) {
                    hiddenElements[i].classList.remove('dn')

                }
            })

        }

    }

    // block unblock flow
    if (document.getElementsByClassName('cancelRequest')[0]) {

        let cancelRequest = document.getElementsByClassName('cancelRequest')

        for (let i = 0; i < cancelRequest.length; i++) {

            cancelRequest[i].addEventListener('click', function (e) {
                e.preventDefault()
                showLoading()
                let xhr = new XMLHttpRequest()
                let url = envAppBackendUrl + '/cancel-follow-request/' + e.currentTarget.dataset.user

                let params = {
                    '_token': token
                }

                xhr.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {
                        let response = JSON.parse(this.response)

                        if (response.success === true) {

                            let followingPendingButtons = document.getElementsByClassName('followingPending')
                            for (let i = (followingPendingButtons.length - 1); i >= 0; i--) {
                                let newFollowButton = document.createElement('button')
                                newFollowButton.dataset.user = followingPendingButtons[i].dataset.user
                                newFollowButton.dataset.private = followingPendingButtons[i].dataset.private
                                newFollowButton.className = 'hollow btn w-100 secondary follow_user mb0'
                                newFollowButton.textContent = getPoTranslate('FOLLOW')
                                newFollowButton.addEventListener('click', _routeHelpers_js__WEBPACK_IMPORTED_MODULE_0__.followFunction)
                                followingPendingButtons[i].parentElement.insertBefore(newFollowButton, followingPendingButtons[i])
                                followingPendingButtons[i].remove()
                            }
                            closePopup('privatePopupCancel')
                            toastify(response.message)



                        } else if (response.success === false) {
                            toastify(response.message)
                        }


                        hideLoading()
                    }
                }

                xhr.onloadend = function () {
                    hideLoading()
                }

                xhr.onerror = function (error) {
                    hideLoading()
                    toastify(this.statusText)
                    Sentry.captureException(new SubmitRemovePrivateFallowing(error + 'status: ' + this
                        .statusText +
                        '|| response: ' + this.statusText + ' || url: ' + location.href));
                }

                xhr.open('POST', url, true)
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.setRequestHeader('Authorization', bearerToken)
                xhr.setRequestHeader('X-CSRF-TOKEN', token)

                xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))
                xhr.setRequestHeader('Content-Type', 'application/json')




                xhr.send(JSON.stringify(params))




            })

        }



        class SubmitRemovePrivateFallowing extends Error {
            constructor(message) {
                super(message)
                this.name = "SubmitRemovePrivateFallowing"
            }
        }
    }
}

function privacyPolicyF() { }

function loginF() {


    loadScript('/frontend/assets/js/loginValidation.js' + version, function () {
        loadScript('/frontend/assets/js/formValidators.js' + version, function () {

        });
        loadScript('/frontend/assets/js/loginRegisterForgot.js' + version, function () {
            showHidePassword();
        });
    });

    if (getCookie('registrationMessage') !== '') {
        if (document.getElementsByClassName('messageForEmail')[0]) {
            let m = document.getElementsByClassName('messageForEmail')[0];
            m.textContent = getPoTranslate('PLEASE_CHECK_EMAIL')
            m.classList.add('messageForEmailCorrection');
            document.cookie = 'registrationMessage=; Path=/account/login; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        }


    }


    const queryString = window.location.search
    const urlParams = new URLSearchParams(queryString)
    const email = urlParams.has('email') ? urlParams.get('email') : false
    const message = urlParams.has('message') ? urlParams.get('message') : false
    if (email) {
        document.getElementsByClassName('email-input')[0].value = email
        history.pushState({}, document.title, location.origin + location.pathname)

        document.getElementById('login-form').getElementsByClassName('password-input')[0].focus()
    }

    if (message) {

        if (document.getElementsByClassName('messageForEmail')[0]) {
            let m = document.getElementsByClassName('messageForEmail')[0];
            m.textContent = message
            m.classList.add('messageForEmailCorrection')


        }


    }

}

function forgotPasswordF() {

    loadScript('/frontend/assets/js/forgotValidation.js' + version, function () {
        loadScript('/frontend/assets/js/formValidators.js' + version, function () {

        });
        loadScript('/frontend/assets/js/loginRegisterForgot.js' + version, function () {
            showHidePassword();
        });
    });
}

function signUpF() {


    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/signUpValidation.js' + version, function () {
            window.onSubmit = function (token) {
                handleSubmitto();
                grecaptcha.reset();
            };
        });
        loadScript('/frontend/assets/js/loginRegisterForgot.js' + version, function () {
            showHidePassword();
        });

    });
}

function settingsProfileF() {
    const queryString = window.location.search
    const urlParams = new URLSearchParams(queryString)
    const code = urlParams.get('code')

    if (code) {
        history.pushState({}, document.title, location.origin + location.pathname)
    }


    loadScript('/frontend/assets/js/loginRegisterForgot.js' + version, function () {

        showHidePasswordSettings();

        loadScript('/frontend/assets/js/formValidators.js' + version, function () {

            loadScript('/frontend/assets/js/fullNameValidation.js' + version, function () {

            });
            loadScript('/frontend/assets/js/addBioValidation.js' + version, function () {

            });
            loadScript('/frontend/assets/js/emailValidation.js' + version, function () {

            });


            loadScript('/frontend/assets/js/setPrivateProfile.js' + version, function () {

            });
            loadScript('/frontend/assets/js/getPermisionLogics.js' + version, function () {

            })
            loadScript('/frontend/assets/js/passwordValidation.js' + version, function () {

            });
        });

    });


    removeProfilePhoto()

    if (document.getElementById('languagePopUp')) {
        if (!getCookie('activeLang')) {
            document.getElementById('german').checked = true
            return
        }

        let languageItemLists = document.getElementById('languagePopUp').getElementsByClassName('languageItemList')

        for (let i = 0; i < languageItemLists.length; i++) {

            languageItemLists[i].addEventListener('click', function () {

                languageItemLists[i].getElementsByTagName('input')[0].checked = true

                location.assign(location.origin + location.pathname + '?hl=' + languageItemLists[i].getElementsByTagName('input')[0].value.toLocaleLowerCase())
            });


            if (getCookie('activeLang') === languageItemLists[i].getElementsByTagName('input')[0].value.toLocaleLowerCase()) {
                languageItemLists[i].getElementsByTagName('input')[0].checked = true
            }
        }



    }

    if (document.getElementById('feedbackPopUp')) {
        let rateApp = document.getElementById('feedbackPopUp').getElementsByClassName('rateApp');
        for (let i = 0; i < rateApp.length; i++) {
            rateApp[i].addEventListener('click', function () {
                if (document.getElementById('feedbackPopUp').getElementsByClassName('selected')[0]) {
                    document.getElementById('feedbackPopUp').getElementsByClassName('selected')[0].classList.remove('selected');
                }
                this.classList.add('selected');
            });

        }
    }

    if (document.getElementById('showAppFeedbacPopup')) {
        document.getElementById('showAppFeedbacPopup').addEventListener('click', getAppFeedback);
    }

    if (document.getElementById('feedbackAppButton')) {
        document.getElementById('feedbackAppButton').addEventListener('click', submitAppFeedback);
    }

    function getAppFeedback() {
        try {
            getReviewXMLHttpRequestFunction()
        } catch (err) {
            Sentry.captureException(new TryCatchGetFeedbackReviewXMLHttpRequestFunction(err));
        }
    }

    function submitAppFeedback() {
        try {
            submitReviewXMLHttpRequestFunction()
        } catch (err) {
            Sentry.captureException(new TryCatchSubmitFeedbackReviewXMLHttpRequestFunction(err));
        }
    }

    function getReviewXMLHttpRequestFunction() {

        let xhr = new XMLHttpRequest()

        xhr.onloadend = function () {
            hideLoading()
        }
        xhr.onloadstart = function () {
            showLoading()
        }

        xhr.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.response);

                if (response.success === true) {


                    if (response.data) {
                        let rateApps = document.getElementById('feedbackPopUp').getElementsByClassName('rateApp');
                        for (let i = 0; i < rateApps.length; i++) {
                            if (rateApps[i].dataset.feedback == response.data.rating) {
                                rateApps[i].classList.add('selected')
                            }
                            document.getElementById('feedbackText').value = response.data.comment
                        }

                        openPopup('feedbackPopUp')
                    } else {
                        openPopup('feedbackPopUp')
                    }


                } else if (response.success === false) {
                    toastify(response.message)
                }

                hideLoading()
            }
        }



        xhr.onerror = function (error) {
            toastify(this.statusText)
            Sentry.captureException(new SubmitFeedbackSubmitError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href))
        }

        xhr.open('GET', envAppBackendUrl + '/app-feedback', true)

        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
        xhr.setRequestHeader('Authorization', bearerToken)
        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

        xhr.send()


    }

    function submitReviewXMLHttpRequestFunction() {

        let xhr = new XMLHttpRequest();

        let data = {
            'rating': document.getElementById('feedbackPopUp').getElementsByClassName('selected')[0].dataset.feedback,
            'comment': document.getElementById('feedbackText').value,
        };

        xhr.onloadend = function () {
            hideLoading()
        }
        xhr.onloadstart = function () {
            showLoading()
        }

        xhr.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.response)

                if (response.success === true) {
                    toastify(response.message)

                } else if (response.success === false) {
                    toastify(response.message)
                }
                closePopup('feedbackPopUp')

            }
        }

        xhr.onerror = function (error) {

            toastify(this.statusText);
            Sentry.captureException(new SubmitFeedbackSubmitError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
        }

        xhr.open('POST', envAppBackendUrl + '/send-feedback', true)

        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
        xhr.setRequestHeader('Authorization', bearerToken)
        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

        xhr.send(JSON.stringify(data));

    }


    moveForm()
    window.addEventListener("resize", moveForm);


    function moveForm() {

        if (document.getElementsByClassName('form-wrapperZ')[0]) {

            let form = document.getElementsByClassName('form-wrapperZ')[0]

            if (window.innerWidth < 640) {
                document.getElementsByClassName('setPageForm')[0].appendChild(form)
                form.classList.remove('dn')
            } else if (window.innerWidth > 639) {
                document.getElementById('Profile').getElementsByClassName('largingZ')[0].getElementsByClassName(
                    'setting-inner')[0].appendChild(form)
                form.classList.remove('dn')
                if (window.profileSettings === 1) {
                    closePopup('profileSettings')
                }
            }

        }
    }

    (0,_routeHelpers_js__WEBPACK_IMPORTED_MODULE_0__.followUnfollowUserOptions)()

    //logics for setting calendar states
    ;(0,_routeHelpers_js__WEBPACK_IMPORTED_MODULE_0__.calendarLogics)()


}

function settingsNotificationF() {
    (0,_routeHelpers_js__WEBPACK_IMPORTED_MODULE_0__.showMoreNotifications)();
    if (document.getElementById('readAllNotifications')) {
        document.getElementById('readAllNotifications').addEventListener('click', function () {
            showLoading()


            let xhr = new XMLHttpRequest()

            xhr.onloadstart = function () {
                showLoading()
            }

            xhr.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.response);

                    if (response.success === true) {
                        let notificationWrappers = document.getElementById('notificationWrapper')
                            .getElementsByTagName('a')
                        for (let i = 0; i < notificationWrappers.length; i++) {
                            notificationWrappers[i].getElementsByTagName('small')[0].classList.remove(
                                'addDot')

                        }
                        toastify(response.message)


                    } else if (response.success === false) {
                        toastify(response.message)

                    }

                    hideLoading()

                }
            }

            xhr.onloadend = function () {
                console.log('The request has completed.');
            }

            xhr.onerror = function (error) {
                hideLoading()
                toastify(this.statusText)
                Sentry.captureException(new ReadAllNotificationsError(error + 'status: ' + this
                    .statusText +
                    '|| response: ' + this.statusText + ' || url: ' + location.href));
            }

            xhr.open('POST', envAppBackendUrl + '/read-all-notifications', true)

            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
            xhr.setRequestHeader('Authorization', bearerToken)
            xhr.setRequestHeader('X-CSRF-TOKEN', token)

            xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))
            xhr.send()
        })

    }

    class ReadAllNotificationsError extends Error {
        constructor(message) {
            super(message);
            this.name = 'ReadAllNotificationsError';
        }
    }

    if (document.getElementById('deleteAllNotifications')) {
        document.getElementById('deleteAllNotifications').addEventListener('click', function () {


            showLoading()


            let xhr = new XMLHttpRequest()

            xhr.onloadstart = function () {
                showLoading()
            }

            xhr.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.response);

                    if (response.success === true) {
                        document.getElementById('notificationWrapper').remove()
                        document.getElementById('noNotificationsCont').classList.remove('dn')

                        document.getElementById('notificationsOptions').classList.add('dn')

                        toastify(response.message)

                    } else if (response.success === false) {
                        toastify(response.message)

                    }

                    hideLoading()

                }
            }

            xhr.onloadend = function () {
                console.log('The request has completed.');
            }

            xhr.onerror = function (error) {
                hideLoading()
                toastify(this.statusText)
                Sentry.captureException(new DeleteAllNotificationsError(error + 'status: ' + this
                    .statusText +
                    '|| response: ' + this.statusText + ' || url: ' + location.href));
            }

            xhr.open('DELETE', envAppBackendUrl + '/delete-all-notifications', true)

            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
            xhr.setRequestHeader('Authorization', document.querySelector('meta[name="access_token"]').content);
            xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

            xhr.send()
        })

    }

    class DeleteAllNotificationsError extends Error {
        constructor(message) {
            super(message);
            this.name = 'DeleteAllNotificationsError';
        }
    }
}

function talks() {
    const target = document.getElementById('mainCategoriesCarousel');

    function handleIntersection(entries) {
        entries.map((entry) => {
            if (entry.isIntersecting) {
                document.getElementsByClassName('fixedPositionMobile')[0].dataset.fixed = '0'
                document.getElementsByClassName('fixedPositionMobile')[0].style.top = '-200px'
            } else {

                if (window.innerWidth < 640) {
                    document.getElementsByClassName('fixedPositionMobile')[0].style.top = document.querySelector('main .steperko').offsetHeight + 'px'
                } else {

                    document.getElementsByClassName('fixedPositionMobile')[0].style.top = document.querySelector('main .steperko').offsetHeight + 'px'
                }

                document.getElementsByClassName('fixedPositionMobile')[0].dataset.fixed = '1'

            }
        });
    }

    const observer = new IntersectionObserver(handleIntersection);

    observer.observe(target);


    const divElem = document.getElementsByClassName('fixedPositionMobile')[0]

    const resizeObserver = new ResizeObserver((entries) => {
        for (const entry of entries) {
            if (window.innerWidth > 639) {

                if (divElem.dataset.fixed === '1') {
                    divElem.style.top = document.querySelector('main .steperko').offsetHeight + 'px'
                }
            } else {
                if (divElem.dataset.fixed === '1') {

                    divElem.style.top = document.querySelector('main .steperko').offsetHeight + 'px'
                }
            }

        }
    });

    resizeObserver.observe(divElem);

    if (document.getElementsByClassName('searchPageLinks')[0]) {
        let searchPageLinks = document.getElementsByClassName('searchPageLinks')
        for (let i = 0; i < searchPageLinks.length; i++) {
            searchPageLinks[i].addEventListener('click', function (e) {
                if (window.innerWidth < 768) {
                    e.preventDefault()
                    location.assign(searchPageLinks[i].dataset.mobileHref)
                }
            })


        }
    }

}

function favoriteUsers() {
    (0,_routeHelpers_js__WEBPACK_IMPORTED_MODULE_0__.followUnfollowUserOptions)();

    (0,_routeHelpers_js__WEBPACK_IMPORTED_MODULE_0__.showMoreFavoriteUsers)();



}

function favoriteTalks() {
    loadScript('/frontend/assets/js/searchFilters.js' + version, function () {

    })
}

function talkCategorySubcategoryF() {

    loadScript('/frontend/assets/js/searchFilters.js' + version, function () {

    })

    let items = document.getElementById('categoryCarousel').getElementsByClassName('tabs-title');

    for (let i = 0; i < items.length; i++) {

        //set active carousel item
        /*      if (items[i].getElementsByTagName('a')[0].getElementsByTagName('p')[0].textContent.trim() === location.href.split('/')[location.href.split('/').length - 1]) {
         items[i].style.textDecoration = 'underline'
         items[i].getElementsByTagName('p')[0].style.color = '#313131'
         items[i].getElementsByTagName('p')[1].style.color = '#313131'
         }
         */
        //location change on click o carousel item
        items[i].addEventListener('click', function () {

            let items2 = document.getElementById('categoryCarousel').getElementsByClassName('tabs-title');

            for (let i = 0; i < items2.length; i++) {

                if (items2[i].getElementsByTagName('a')[0].getElementsByTagName('p')[0].textContent.trim() === location.href.split('/')[location.href.split('/').length - 1]) {
                    items2[i].style.textDecoration = 'underline';
                    items2[i].getElementsByTagName('p')[0].style.color = '#8C97AC';
                    items2[i].getElementsByTagName('p')[1].style.color = '#8C97AC';
                }

            }

            items[i].style.textDecoration = 'underline';
            items[i].getElementsByTagName('p')[0].style.color = '#313131';
            items[i].getElementsByTagName('p')[1].style.color = '#313131';
            //showLoading()
            //location.assign('/search-talks/' + location.href.split('/')[location.href.split('/').length - 2] + '/' + this.getElementsByClassName('innerTitlesForCarouselSlider')[0].textContent.trim())
        });
    }
}

function accountVerificationF() {
    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/addBioValidation.js' + version, function () {

        });

        loadScript('/frontend/assets/js/fullNameValidation.js' + version, function () {

        });

        loadScript('/frontend/assets/js/verificationValidation.js' + version, function () {
            if (document.getElementsByClassName('imagePointerForCropper')[0]) {
                document.getElementsByClassName('imagePointerForCropper')[0].addEventListener('click', function () {
                    window.clickOnUploadImageOnVerificationPage = true
                })
            }
        });

    });

    let urlParams = new URLSearchParams(location.search);
    let myParam = urlParams.get('opensharepopup');

    if (myParam === '1') {
        openPopup('shareProfilePopUp2');
        history.pushState({}, document.title, location.origin + location.pathname)
    }


}

function jtcSetPayoutOptions() {
    loadScript('/frontend/assets/js/formValidators.js' + version, function () {

        loadScript('/frontend/assets/js/step4Validation.js' + version, function () {

        });
    });
}

function jtcSetPayoutOptionsF() {


    let paypalEnv = document.getElementById('ppenv').value



    let settingsPayoutPayPalReturnUrl = document.getElementById('appUrl').value + '/settings/payout';
    let settingsPayoutPayPalAppid = document.getElementById('settingsAppId').value;

    paypal.use(['login'], function (login) {
        login.render({
            'appid': settingsPayoutPayPalAppid,
            'authend': paypalEnv,
            'scopes': 'email',
            'containerid': 'paypal-button-container2',
            'responseType': 'code',
            'locale': 'en-us',
            'buttonType': 'CWP',
            'buttonShape': 'pill',
            'buttonSize': 'lg',
            'fullPage': 'true',
            'returnurl': settingsPayoutPayPalReturnUrl,
        })
    })




}

function talksAndAvailabilityF() {
    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/talksAndAvailabilityValidation.js' + version, function () {



            let courseItem = document.getElementsByClassName('dataTalkId');

            for (let i = 0; i < courseItem.length; i++) {
                courseItem[i].addEventListener('click', function () {

                    window.clickedEdit = 1
                    ;(0,_comunicationControler_js__WEBPACK_IMPORTED_MODULE_4__.getTalkData)(courseItem[i].dataset.talkId)
                    document.getElementsByClassName('addNewTalkDescription')[0].classList.add('dn')

                    document.getElementsByClassName('editnewTalkDescription')[0].classList.remove('dn')

                });
            }

            let talk = location.href.split('talk=')[1];

            if (talk != undefined) {
                let modal = document.querySelector('[data-talk-id="' + talk + '"]');
                modal.click();
            }
        });

        loadScript('/frontend/assets/js/step3Validation.js' + version, function () {



        });

        if (document.getElementsByClassName('addPrivateTalk')[0]) {
            document.getElementsByClassName('addPrivateTalk')[0].addEventListener('click', function () {

                window.clickedEdit = 0

                clearForm(document.getElementById('private-talk-form'))

                document.getElementsByClassName('addNewTalkDescription')[0].classList.remove('dn')
                document.getElementsByClassName('editnewTalkDescription')[0].classList.add('dn')
                document.getElementsByClassName('pauseWrap')[0].classList.add('dn')
                document.getElementById('privateSubmit').classList.add('dn')
                document.getElementById('privateSubmit').textContent = getPoTranslate('ADD_PRIVATE_TALK')




            })
        }



        document.getElementsByClassName('loadAboutMe')[0].addEventListener('click', function () {

            showLoading()

            let xhr = new XMLHttpRequest()

            xhr.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {

                    document.getElementById('blankPopupPopuper').innerHTML = this.response;

                    if (document.getElementsByClassName('testimonialAboutMe')[0]) {
                        let owls = document.getElementsByClassName('testimonialAboutMe')

                        for (let i = 0; i < owls.length; i++) {

                            let owl1 = jQuery(owls[i])

                            owl1.owlCarousel({
                                margin: 10,
                                dots: true,
                                nav: false,
                                stagePadding: 40,
                                items: 1,
                            })

                            owls[i].style.opacity = '1'
                        }


                    }

                    openPopup('blankPopup')
                    calculatePopUpHeight(document.getElementById('blankPopup'))
                    hideLoading()

                    let groupC = document.getElementsByClassName('groupC')[0];
                    let privateC = document.getElementsByClassName('privateC')[0];

                    let buttons = document.getElementsByClassName('bMySlotsButtonsCont');
                    let bottomLine = document.getElementsByClassName('buttonLine')[0];

                    for (let i = 0; i < buttons.length; i++) {
                        buttons[i].addEventListener('click', function () {

                            if (this.dataset.pointer === 'gc') {


                                this.classList.add('active');
                                buttons[0].classList.remove('active');

                                bottomLine.style.left = '50%';

                                groupC.style.left = '0';
                                privateC.style.left = '200%';

                                document.getElementById('aboutMeContaR').style.height =
                                    document.getElementsByClassName('bMySlotsButtons')[0].offsetHeight + document.getElementsByClassName('groupC')[0].offsetHeight + 'px';

                            } else if (this.dataset.pointer === 'pc') {


                                this.classList.add('active');
                                buttons[1].classList.remove('active');

                                bottomLine.style.left = '0%';

                                bottomLine.style.left = '0%';

                                groupC.style.left = '-200%';
                                privateC.style.left = '0%';

                                document.getElementById('aboutMeContaR').style.height =
                                    document.getElementsByClassName('bMySlotsButtons')[0].offsetHeight + document.getElementsByClassName('privateC')[0].offsetHeight + 'px';

                            }
                        })
                    }

                    let switches = document.getElementsByClassName('switch');
                    for (let i = 0; i < switches.length; i++) {
                        switches[i].addEventListener('click', function () {

                            let input = switches[i].getElementsByTagName('input')[0];

                            if (input.checked) {
                                input.checked = false;
                            } else {
                                input.checked = true;
                            }

                        })
                    }

                    if (document.getElementsByClassName('teacherDescOpenBios')[0]) {
                        document.getElementsByClassName('teacherDescOpenBios')[0].addEventListener('click', function () {
                            openPopup('addShortDescription')
                            document.getElementById('addShortDescription').style.zIndex = '214743643'
                        })
                    }

                }
            }

            xhr.onerror = function (error) {
                console.log(error);
            };

            xhr.open('GET', '/about-me-partial', true);
            xhr.send();


        });
    });


    (0,_talks_js__WEBPACK_IMPORTED_MODULE_2__.deleteTalk)();



}

function book_slotF() {

    window.localStorage.removeItem('bookingObj')

    loadScript('/frontend/assets/js/calendar.js' + version, function () {

    })

    hideLoading()
    document.getElementsByClassName('bookingSlotCalendarHolder')[0].getElementsByClassName('booking-slot')[0].style.opacity = '1';

    (0,_routeHelpers_js__WEBPACK_IMPORTED_MODULE_0__.showHideCalendarBigSmall)()
    //ako bi ova stranica bila za logged out
    /* loadScript('/frontend/assets/js/loginRegisterForgot.js' + version, function () {
        showHidePassword()
    })
    loadScript('/frontend/assets/js/loginValidation.js' + version, function () {
        loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        })
    }) */

    if (document.getElementById('teacherAvailabilityDatesTime')) {
        if (document.getElementById('teacherAvailabilityDatesTime').value) {

            let teacherAvailabilityDatesTime = JSON.parse(document.getElementById('teacherAvailabilityDatesTime').value.trim())

            getBookingTalkAvailability(Object.keys(teacherAvailabilityDatesTime)[0])

        }
    }

    // ova sekcija je za rebook time, pokusavamo da nadjemo isto vreme
    // da bi se ovo trigerovalo korisnik mora da ode na rebook preko booking stranice

    let urlParams = new URLSearchParams(window.location.search);
    let reebok_time = urlParams.get('reebok_time');

    if (reebok_time) {
        if (reebok_time.length > 1) {
            let d = new Date(reebok_time)
            d = addZero(d.getHours()) + ':' + addZero(d.getMinutes())


            let weeklyTimes = document.getElementsByClassName('weekly-time')[0].getElementsByTagName('button')
            for (let i = 0; i < weeklyTimes.length; i++) {

                if (weeklyTimes[i].textContent === d) {

                    history.pushState({}, document.title, location.origin + (location.pathname).split('&reebok_time=')[0])
                    eventFire(weeklyTimes[i], 'click')
                } else {

                    history.pushState({}, document.title, location.origin + (location.pathname).split('&reebok_time=')[0])

                }

            }
        }
    }

    //prikupljamo rating za prikazivanje ratinga sa leve strane
    setTimeout(function () {

        let xhr = new XMLHttpRequest()
        let user_id = document.getElementsByClassName('step1name')[0].dataset.id
        let url = '/get-rating/' + user_id

        xhr.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {


                document.getElementById('reviewWrap').innerHTML = this.response
                document.getElementById('funnelReviewWrap').style.opacity = '1'
                feedbackComments()

            }

        }

        xhr.onerror = function (error) {
            console.log(error)
        }

        xhr.open('GET', url, true)
        xhr.send()


    }, 1000)

    //logics for setting calendar states
    ;(0,_routeHelpers_js__WEBPACK_IMPORTED_MODULE_0__.calendarLogics)()

    if (document.getElementsByClassName('calendarFunnelHighlightingState')[0]) {
        let calendarFunnelHighlightingState = document.getElementsByClassName('calendarFunnelHighlightingState')[0]

        calendarFunnelHighlightingState.addEventListener('click', function () {
            if (calendarFunnelHighlightingState.dataset.clicked === '1') {

                removeHighlightedAvailabilites()

                calendarFunnelHighlightingState.dataset.clicked = '0'
            } else if (calendarFunnelHighlightingState.dataset.clicked === '0') {


                calculateUserAvailabilites()

                hideLoading()
                calendarFunnelHighlightingState.dataset.clicked = '1'
            }
        })
    }



}

function bookingF() {
    loadScript('/frontend/assets/js/calendar.js' + version, function () {

    })
    loadScript('/frontend/assets/js/optionButton.js' + version, function () {
        ;(0,_routeHelpers_js__WEBPACK_IMPORTED_MODULE_0__.showHideCalendarBigSmall)()
    })
}

function feedbackComments() {

    let buttons = document.getElementsByClassName('bMySlotsButtonsCont')

    for (let i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener('click', function () {
            if (buttons[i].dataset.pointer === "pc") {

                document.getElementById('reviewHeighter').style.height = (document.getElementById('showMoresReceived').closest('.coursesBlock').offsetHeight + document.getElementById('bMySlotsButtons').offsetHeight + 32) + 'px'

            } else if (buttons[i].dataset.pointer === "gc") {

                document.getElementById('reviewHeighter').style.height = (document.getElementById('showMoresGiven').closest('.coursesBlock').offsetHeight + document.getElementById('bMySlotsButtons').offsetHeight + 32) + 'px'

            }
        })

    }



    let star = 0;

    ratingLogics();

    function ratingLogics() {


        function getFeedbackCommentss(target, offset) {

            let pointer = target.dataset.reviews // pointer is 1 for
            let url = '/settings/reviews-partial' + '?offset=' + offset + '&limit=2' + '&pointer=' + pointer


            let xhr = new XMLHttpRequest()

            xhr.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {

                    let response = JSON.parse(this.response);

                    target.closest('.review-right').getElementsByClassName('feedback-comments')[0].innerHTML += response.html

                    if (response.totalReviews <= target.closest('.review-right').getElementsByClassName('feedback-comments')[0].getElementsByClassName('each-review').length) {
                        target.classList.add('dn')
                    }


                    document.getElementById('reviewHeighter').style.height = (target.closest('.coursesBlock').offsetHeight + document.getElementById('bMySlotsButtons').offsetHeight + 32) + 'px'



                }
            }

            xhr.onloadend = function () {
                hideLoading()
            }
            xhr.onerror = function (error) {
                hideLoading()
                toastify(this.statusText)
                Sentry.captureException(new FeedbackCommentsUrlError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href))
            }

            xhr.open('GET', url, true)
            xhr.send()


        }

        if (document.getElementsByClassName('seeMores')[0]) {

            let seeMores = document.getElementsByClassName('seeMores')
            for (let i = 0; i < seeMores.length; i++) {

                if (typeof seeMores[i].dataset.eventLoaded === 'undefined') {
                    seeMores[i].addEventListener('click', function () {

                        showLoading()

                        let offset = seeMores[i].closest('.review-right').getElementsByClassName('feedback-comments')[0].getElementsByClassName('each-review').length


                        if (this.dataset.type === "1") {

                            getFeedbackCommentss(this, offset)
                        } else if (this.dataset.type === "2") {
                            getFeedbackComments(this.dataset.star, offset, this.dataset.reviews, true);
                        }


                    });

                    seeMores[i].dataset.eventLoaded = '1';
                }
            }

        }



        function getFeedbackComments(star, offset, pointer, sourcePointer) {

            let totalFeedbacks = parseInt(document.getElementById('totalFeedbackCount').value)
            let limit = 2
            star = star ? star : 5

            offset = offset ? offset : 0

            let pointer2 = pointer ? '&pointer=' + pointer : ''

            let url = document.getElementById('feedbackCommentsUrl').value + '?star=' + star + '&offset=' + offset + '&limit=' + limit + pointer2

            let xhr = new XMLHttpRequest()

            xhr.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {


                    let response = JSON.parse(this.response)

                    if (response.hasOwnProperty('noData')) {
                        if (response.noData === true) {

                            toastify(response.message)
                            if (pointer === '1') {

                                document.getElementById('showMoresReceived').closest('.inner-review').getElementsByClassName('no-found-heading')[0].classList.remove('dn')
                                document.getElementById('recievedComentsFalback').innerHTML = '';
                                document.getElementById('showMoresReceived').classList.add('dn')
                                document.getElementById('reviewHeighter').style.height = (document.getElementById('showMoresReceived').closest('.coursesBlock').offsetHeight + document.getElementById('bMySlotsButtons').offsetHeight + 32) + 'px'

                            } else if (pointer === '2') {

                                document.getElementById('showMoresGiven').closest('.inner-review').getElementsByClassName('no-found-heading')[0].classList.remove('dn')
                                document.getElementById('givenComentsFalback').innerHTML = '';
                                document.getElementById('showMoresGiven').classList.add('dn')
                                document.getElementById('reviewHeighter').style.height = (document.getElementById('showMoresGiven').closest('.coursesBlock').offsetHeight + document.getElementById('bMySlotsButtons').offsetHeight + 32) + 'px'

                            }
                        }
                    } else {
                        if (response.total_items == 0) {

                            if (pointer == 1) {

                                document.getElementById('bookingNoFoundRecieved').classList.remove('dn');
                                document.getElementById('recievedComentsFalback').innerHTML = '';
                                document.getElementById('showMoresReceived').classList.add('dn')
                                document.getElementById('reviewHeighter').style.height = (document.getElementById('showMoresReceived').closest('.coursesBlock').offsetHeight + document.getElementById('bMySlotsButtons').offsetHeight + 32) + 'px'

                            } else if (pointer == 2) {

                                document.getElementById('bookingNoFoundGiven').classList.remove('dn');
                                document.getElementById('givenComentsFalback').innerHTML = '';
                                document.getElementById('showMoresGiven').classList.add('dn')
                                document.getElementById('reviewHeighter').style.height = (document.getElementById('showMoresGiven').closest('.coursesBlock').offsetHeight + document.getElementById('bMySlotsButtons').offsetHeight + 32) + 'px'

                            }

                        } else {

                            if (pointer == 1) {

                                if (sourcePointer) {
                                    document.getElementById('recievedComentsFalback').innerHTML += response.html;
                                } else {
                                    document.getElementById('recievedComentsFalback').innerHTML = response.html;
                                }

                                document.getElementById('bookingNoFoundRecieved').classList.add('dn')

                                let commentsPresent = document.getElementById('recievedComentsFalback').getElementsByClassName('each-review').length
                                if (response.stars_total > commentsPresent) {

                                    document.getElementById('showMoresReceived').classList.remove('dn')
                                } else if (response.stars_total <= commentsPresent) {

                                    document.getElementById('showMoresReceived').classList.add('dn')
                                }

                                document.getElementById('reviewHeighter').style.height = (document.getElementById('showMoresReceived').closest('.coursesBlock').offsetHeight + document.getElementById('bMySlotsButtons').offsetHeight + 32) + 'px'


                            } else if (pointer == 2) {

                                if (sourcePointer) {
                                    document.getElementById('givenComentsFalback').innerHTML += response.html;
                                } else {
                                    document.getElementById('givenComentsFalback').innerHTML = response.html;
                                }

                                document.getElementById('bookingNoFoundGiven').classList.add('dn');

                                let commentsPresent = document.getElementById('givenComentsFalback').getElementsByClassName('each-review').length

                                if (response.stars_total > commentsPresent) {
                                    document.getElementById('showMoresGiven').classList.remove('dn')
                                } else if (response.stars_total <= commentsPresent) {
                                    document.getElementById('showMoresGiven').classList.add('dn')
                                }

                                document.getElementById('reviewHeighter').style.height = (document.getElementById('showMoresGiven').closest('.coursesBlock').offsetHeight + document.getElementById('bMySlotsButtons').offsetHeight + 32) + 'px'

                            }



                        }
                    }



                    hideLoading();

                }
            }


            xhr.onerror = function (error) {
                hideLoading()
                toastify(this.statusText)
                Sentry.captureException(new FeedbackCommentsUrlError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href))
            }

            xhr.open('GET', url, true)
            xhr.send()


        }

        let progresStars = document.getElementsByClassName('progress-star');
        for (let i = 0; i < progresStars.length; i++) {
            if (progresStars[i].dataset.eventAdded !== "1") {
                progresStars[i].addEventListener('click', function () {
                    if (document.body.className !== 'book_slot') {


                        showLoading();


                        for (let i = 0; i < progresStars.length; i++) {
                            if (progresStars[i].getElementsByClassName('progress-meter')[0]) {
                                if (
                                    progresStars[i].getElementsByClassName('progress-meter')[0].closest('.ratingS') ===
                                    this.parentElement
                                ) {
                                    progresStars[i].getElementsByClassName('progress-meter')[0].style.width = '0%';
                                }

                            }

                            progresStars[i].classList.remove('pon');
                        }

                        this.classList.add('pon');

                        //document.getElementById('totalFeedbackCount').value = progresStars[i].dataset.total;
                        star = progresStars[i].dataset.id;

                        progresStars[i].closest('.inner-review').getElementsByClassName('seeMores')[0].dataset.type = "2"
                        progresStars[i].closest('.inner-review').getElementsByClassName('seeMores')[0].dataset.star = star

                        getFeedbackComments(star, 0, this.dataset.rating)

                        if (progresStars[i].getElementsByClassName('progress-meter')[0]) {
                            progresStars[i].getElementsByClassName('progress-meter')[0].style.width = '100%';
                        }




                    }
                })
                progresStars[i].dataset.eventAdded = 1
            }


        }

    }

    if (document.getElementsByClassName('allRating')[0]) {

        let allRatingS = document.getElementsByClassName('allRating');

        for (let i = 0; i < allRatingS.length; i++) {
            allRatingS[i].addEventListener('click', function () {

                if (document.body.className === 'book_slot') {


                    document.getElementById('blankPopupPopuper').appendChild(document.getElementById('funnelReviewWrap'));
                    setTimeout(function () {
                        openPopup('blankPopup');

                    }, 10);


                } else {




                    let pointer = this.dataset.pointer; //pointer for recieved = 1; pointer for given = 2;
                    showLoading();
                    let xhttp = new XMLHttpRequest();
                    let url = '/settings/reviews?pointer=' + pointer

                    xhttp.onreadystatechange = function () {

                        if (this.readyState == 4 && this.status == 200) {

                            let response = JSON.parse(this.response)


                            if (response.hasOwnProperty('noData')) {
                                if (response.noData === true) {
                                    if (pointer === '1') {
                                        allRatingS[i].closest('.inner-review').getElementsByClassName('no-found-heading')[0].classList.remove('dn')
                                        document.getElementById('showMoresReceived').classList.add('dn')
                                    } else if (pointer === '2') {
                                        allRatingS[i].closest('.inner-review').getElementsByClassName('no-found-heading')[0].classList.remove('dn')
                                        document.getElementById('showMoresGiven').classList.add('dn')
                                    }
                                    toastify(response.message)
                                }
                            } else {
                                if (pointer === '1') {

                                    document.getElementsByClassName('ratingS')[0].innerHTML = response.reviewBars
                                    document.getElementsByClassName('feedback-comments')[0].innerHTML = response.feedbackComments
                                    document.getElementById('ratingBigReceived').textContent = Number((response.teacherAverageRating).toFixed(1))
                                    document.getElementById('totalRatingsRecieved').textContent = response.totalRatings
                                    document.getElementById('totalReviewsRecieved').textContent = response.totalReviews
                                    document.getElementById('showMoresReceived').dataset.type = "1"
                                    allRatingS[i].closest('.inner-review').getElementsByClassName('no-found-heading')[0].classList.add('dn')
                                    if (response.numberOfComments >= 2) {
                                        document.getElementById('showMoresReceived').classList.remove('dn')
                                    }


                                } else if (pointer === '2') {


                                    document.getElementsByClassName('ratingS')[1].innerHTML = response.reviewBars
                                    document.getElementsByClassName('feedback-comments')[1].innerHTML = response.feedbackComments
                                    document.getElementById('ratingBigGiven').textContent = Number((response.teacherAverageRating).toFixed(1))
                                    document.getElementById('totalRatingsGiven').textContent = response.totalRatings
                                    document.getElementById('totalReviewsGiven').textContent = response.totalReviews
                                    document.getElementById('showMoresGiven').dataset.type = "1"
                                    allRatingS[i].closest('.inner-review').getElementsByClassName('no-found-heading')[0].classList.add('dn')
                                    if (response.numberOfComments >= 2) {
                                        document.getElementById('showMoresGiven').classList.remove('dn')
                                    }
                                }
                            }

                            document.getElementById('reviewHeighter').style.height = (allRatingS[i].closest('.coursesBlock').offsetHeight + document.getElementById('bMySlotsButtons').offsetHeight + 32) + 'px'

                            ratingLogics()

                            hideLoading()

                        }
                    }

                    xhttp.onerror = function (error) {
                        Sentry.captureException(new GetRatingFullError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href))
                    }

                    xhttp.open('GET', url, true)
                    xhttp.send()
                }
            });
        }
    }



}

function videoConferenceF() {

    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/step5Validation.js' + version, function () {
            loadScript('/frontend/assets/js/optionButton.js' + version, function () {

                loadScript('/frontend/assets/js/talk/socketBundle.js' + version, function () {

                    (0,_payment_js__WEBPACK_IMPORTED_MODULE_1__.initializeStripe)()

                    ;(0,_payment_js__WEBPACK_IMPORTED_MODULE_1__.extendTalkPaymentInitialize)()

                    ;(0,_payment_js__WEBPACK_IMPORTED_MODULE_1__.selectCardForPayment)()

                    if (document.getElementsByClassName('extendLessonDuration')[0]) {
                        let extendLessonDuration = document.getElementsByClassName('extendLessonDuration');
                        for (let i = 0; i < extendLessonDuration.length; i++) {
                            extendLessonDuration[i].addEventListener('click', function () {

                                showLoading()

                                //document.getElementById('extendLesson').disabled = true
                                document.getElementById('extendLessonTime').value = '';
                                document.getElementById('priceHours').value = '';

                                let that = this;

                                submitValidationForm(that.dataset.popup);

                                function submitValidationForm(popupPointer) {

                                    jQuery.ajax({
                                        type: 'POST',
                                        headers: {
                                            'Accept': 'application/json',
                                            'Time-Zone-Offset-UTC': getCookie('timezone'),
                                        },
                                        data: {
                                            '_token': token,
                                        },
                                        url: '/frontend/api/teacher-available-extensions',

                                        complete: function () {
                                            hideLoading()
                                        },

                                        success: function (response) {

                                            if (response.success) {

                                                document.getElementById('extendCall').getElementsByClassName('buttons')[0].textContent = '';

                                                if (document.getElementsByClassName('infoAboutExtend')[0]) {
                                                    document.getElementsByClassName('infoAboutExtend')[0].remove();
                                                }

                                                toastify(response.message);

                                                window.dataca = response;
                                                let count = 0;

                                                if (response.data) {

                                                    document.getElementsByClassName('textForExtend')[0].classList.remove('dn');
                                                    document.getElementsByClassName('submitButtonsForExtend')[0].classList.remove('dn');

                                                    let obj = response.data;

                                                    for (let i = 0; i < Object.keys(obj).length; i++) {

                                                        if (obj[Object.keys(obj)[i]].success === true) {

                                                            /* <span class="btn extCal"><span class="minutes">15</span> Minutes - <span class="prices">15</span> €</span> */

                                                            let extendionItem = document.createElement('div');
                                                            extendionItem.className = 'btn mt16 posrelative expanded extCal';


                                                            let firsterDiv = document.createElement('div')
                                                            firsterDiv.className = 'firsterDivier'

                                                            let minutesSpan = document.createElement('span')
                                                            minutesSpan.className = 'minutes'
                                                            let minutes = Object.keys(obj)[i].split('_')
                                                            let minutesLast = minutes[minutes.length - 1]
                                                            minutesSpan.textContent = minutesLast + ' Minutes'

                                                            firsterDiv.append(minutesSpan)

                                                            let seccerDikvie = document.createElement('div')
                                                            seccerDikvie.className = 'rightSideofExtendSlots df aic jcc'

                                                            let pricesSpan = document.createElement('span')
                                                            pricesSpan.className = 'prices mr4'
                                                            pricesSpan.textContent = new Intl.NumberFormat(getCookie('activeLang'), {
                                                                style: 'currency',
                                                                currency: 'EUR'
                                                            }).format(parseFloat(obj[Object.keys(obj)[i]].price).toFixed(2)).replace(/[^0-9.,]/g, '')

                                                            let chartIconDivExtend = document.createElement('div')
                                                            chartIconDivExtend.className = 'chartIconDivExtend'
                                                            chartIconDivExtend.innerHTML = '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.591 8.42484H12.6669C12.9816 8.42484 13.2289 8.16461 13.2289 7.8508C13.2289 7.52934 12.9816 7.27677 12.6669 7.27677H10.591C10.2762 7.27677 10.0289 7.52934 10.0289 7.8508C10.0289 8.16461 10.2762 8.42484 10.591 8.42484ZM15.1324 4.44562C15.5896 4.44562 15.8893 4.60635 16.1891 4.95843C16.4889 5.3105 16.5413 5.81565 16.4739 6.27412L15.7619 11.295C15.627 12.2602 14.8177 12.9712 13.8659 12.9712H5.68979C4.69307 12.9712 3.86871 12.1913 3.78627 11.181L3.09681 2.83755L1.96519 2.63855C1.66543 2.58498 1.45559 2.28648 1.50805 1.98032C1.56051 1.66728 1.85278 1.45987 2.16004 1.50655L3.9474 1.78133C4.2022 1.82801 4.38955 2.04156 4.41204 2.30179L4.55443 4.01624C4.57691 4.26193 4.77176 4.44562 5.01157 4.44562H15.1324ZM5.56974 14.1809C4.94023 14.1809 4.43063 14.7014 4.43063 15.3443C4.43063 15.9795 4.94023 16.5 5.56974 16.5C6.19176 16.5 6.70136 15.9795 6.70136 15.3443C6.70136 14.7014 6.19176 14.1809 5.56974 14.1809ZM14.0007 14.1809C13.3712 14.1809 12.8616 14.7014 12.8616 15.3443C12.8616 15.9795 13.3712 16.5 14.0007 16.5C14.6227 16.5 15.1323 15.9795 15.1323 15.3443C15.1323 14.7014 14.6227 14.1809 14.0007 14.1809Z" fill="white"/></svg>';


                                                            seccerDikvie.append(pricesSpan)
                                                            seccerDikvie.innerHTML += ' €'

                                                            extendionItem.prepend(firsterDiv)
                                                            extendionItem.append(seccerDikvie)
                                                            extendionItem.append(chartIconDivExtend)

                                                            document.getElementById('extendCall').getElementsByClassName('buttons')[0].append(extendionItem)

                                                            count++;
                                                        }

                                                    }

                                                    extendCallButtonEvent()
                                                    openPopup(popupPointer)
                                                }

                                                if (count === 0) {
                                                    document.getElementsByClassName('textForExtend')[0].classList.add('dn')
                                                    document.getElementsByClassName('submitButtonsForExtend')[0].classList.add('dn')

                                                    let infoAboutExtend = document.createElement('p')
                                                    infoAboutExtend.className = 'infoAboutExtend'
                                                    infoAboutExtend.textContent = getPoTranslate('NO_TALK_EXTENSION_TIME_SLOT')
                                                    document.getElementsByClassName('innerExtendCall')[0].append(infoAboutExtend)

                                                    openPopup(popupPointer)

                                                    hideLoading()
                                                }
                                            } else {

                                                document.getElementsByClassName('innerExtendCall')[0].textContent = ''

                                                let infoAboutExtend = document.createElement('p')
                                                infoAboutExtend.className = 'infoAboutExtend'
                                                infoAboutExtend.textContent = getPoTranslate('NO_TALK_EXTENSION_TIME_SLOT')
                                                document.getElementsByClassName('innerExtendCall')[0].append(infoAboutExtend)

                                                openPopup(popupPointer)

                                                toastify(response.message)
                                                hideLoading()
                                            }


                                        },
                                        error: function (errorMessage) {

                                            hideLoading();

                                            Sentry.captureException(new TeacherAvailableExtensionsError(errorMessage + ' || URL: ' + location.href))
                                        },

                                    });
                                }
                            });

                        }

                    }

                    if (document.getElementsByClassName('closePopup')[0]) {
                        let closePopups = document.getElementsByClassName('closePopup');
                        for (let i = 0; i < closePopups.length; i++) {
                            closePopups[i].addEventListener('click', function () {
                                if (this.dataset.closePopup) {
                                    closePopup(this.dataset.closePopup);
                                }
                            });
                        }
                    }

                    if (document.getElementsByClassName('pencilOpener')[0]) {
                        let pencilOpener = document.getElementsByClassName('pencilOpener')[0]

                        pencilOpener.addEventListener('click', function () {

                            if (pencilOpener.dataset.opened === '0') {
                                document.getElementsByClassName('hiddenForm')[0].style.maxHeight = '1000px'
                                pencilOpener.dataset.opened = '1'
                                calculatePopUpHeight(document.getElementById('paymentWalletPopUp'), 6)

                            } else if (pencilOpener.dataset.opened === '1') {
                                document.getElementsByClassName('hiddenForm')[0].style.maxHeight = '0px'
                                pencilOpener.dataset.opened = '0'
                                calculatePopUpHeight(document.getElementById('paymentWalletPopUp'), 6)

                            }

                        })

                    }
                })

            })
        })
    })

}


function book_slot_paymentF() {
    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        const params = new URLSearchParams(window.location.search);

        if (params.has('success')) {
            if (params.get('success') === 'true') {

                /* let dzens = document.getElementsByClassName('dzen');
                for (let i = 0; i < dzens.length; i++) {
                    dzens[i].classList.add('dn');
                }
                document.getElementsByClassName('payButton')[0].classList.add('dn'); */
                openPaymentPopuper(getPoTranslate('YOUR_PAYMENT_SUCCESS'))
                toastify(getPoTranslate('YOUR_PAYMENT_SUCCESS'))

                setTimeout(function () {
                    location.assign(location.origin + '/booking-thank-you')
                }, 2000)


                document.cookie = 'bookingObj=; Path=/booking-payment; Expires=Thu, 01 Jan 1970 00:00:01 GMT;'
                document.cookie = 'bookingObj=; Path=/booking-summary; Expires=Thu, 01 Jan 1970 00:00:01 GMT;'
                window.localStorage.removeItem('bookingObj')
            }
        }


        if (document.getElementById('shouldShowPayPalAndStripe').value === '1') {
            (0,_payment_js__WEBPACK_IMPORTED_MODULE_1__.selectCardForPayment)()

            ;(0,_payment_js__WEBPACK_IMPORTED_MODULE_1__.initializePayPal)('authorize')
        }

        (0,_payment_js__WEBPACK_IMPORTED_MODULE_1__.initializeStripe)()

        if (document.getElementById('vat_id')) {
            let vatSelect = document.querySelector('#vat_id');
            let vatInput = document.querySelector('input#vat_id');
            let base = document.querySelector('#bookingBase');
            let VAT = document.querySelector('#bookingVAT');
            let percentage = document.querySelector('#bookingVATPercentage');
            let price = parseFloat(document.getElementById('moneyConta').textContent.substring(0, document.getElementById('moneyConta').textContent.length - 1))

            if (document.querySelector('#bookingBase')) {
                vatSelect.addEventListener('change', updateVAT)
                window.addEventListener('load', updateVAT)
            }


            /**
             * Update VAT values in the Payment Header.
             */
            function updateVAT() {
                let vat = vatSelect.options[vatSelect.selectedIndex];

                base.innerHTML = setBase(vat);
                VAT.innerHTML = setVAT(vat);
                percentage.innerHTML = setPercentage(vat);
                vatInput.value = vat.value;
            }

            /**
             * Set Base Cost before VAT.
             *
             * @param vat Country of Residence VAT.
             *
             * @returns {string}
             */
            function setBase(vat) {
                return parseFloat(price - setVAT(vat)).toFixed(2);
            }

            /**
             * Set Country of Residence VAT value from the total price.
             *
             * @param vat Country of Residence VAT.
             *
             * @returns {string}
             */
            function setVAT(vat) {
                return parseFloat(price / 100 * vat.getAttribute('data-value')).toFixed(2);
            }

            /**
             * Set Country of Residence VAT percentage
             *
             * @param vat Country of Residence VAT.
             *
             * @returns {string}
             */
            function setPercentage(vat) {
                return parseFloat(vat.getAttribute('data-value')).toFixed(2);

            }
        }


        let payPallButtonPay = document.getElementsByClassName('payPallButtonPay')
        for (let i = 0; i < payPallButtonPay.length; i++) {
            payPallButtonPay[i].addEventListener('click', function () {

                showLoading()

                let form = payPallButtonPay[i].parentElement.getElementsByTagName('form')[0].elements

                let xhr = new XMLHttpRequest();

                let params = {
                    account_id: form['account_id'].value,
                    talk_id: form['talk_id'].value,
                    amount: form['amount'].value,
                    date_time: form['date_time'].value,
                    payment_type: form['payment_type'].value,
                    vat_id: form['vat_id'].value,
                    _token: token
                }



                xhr.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {

                        let response = JSON.parse(this.response);

                        if (response.success === true) {

                            toastify(response.message)
                            location.assign('/booking-thank-you')
                        } else if (response.success === false) {


                            hideLoading()
                            openPopup('specialLoading')
                            document.getElementById('loadingText').textContent = response.message

                            let helperButton = document.createElement('a')
                            helperButton.className = 'btn'
                            helperButton.textContent = 'Please try pay directly on PayPal'
                            helperButton.href = response.data.errors.approval_link

                            document.getElementById('specialLoadingContainer').insertBefore(helperButton, document.getElementById('loadingText').nextSibling)

                        }

                    }
                };

                xhr.onerror = function (error) {
                    hideLoading()
                    toastify(this.statusText);
                    Sentry.captureException(new SubmitFeedbackSubmitError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
                };

                xhr.open('POST', '/v1/paypal-payment', true);

                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('Authorization', token);
                xhr.send(JSON.stringify(params));

            })

        }


        loadScript('/frontend/assets/js/step5Validation.js' + version, function () {
            if (document.getElementsByClassName('pencilOpener')[0]) {
                let pencilOpener = document.getElementsByClassName('pencilOpener')[0]

                pencilOpener.addEventListener('click', function () {

                    if (pencilOpener.dataset.opened === '0') {
                        document.getElementsByClassName('hiddenForm')[0].style.maxHeight = '1000px'
                        pencilOpener.dataset.opened = '1'
                    } else if (pencilOpener.dataset.opened === '1') {
                        document.getElementsByClassName('hiddenForm')[0].style.maxHeight = '0px'
                        pencilOpener.dataset.opened = '0'
                    }

                })

            }
        })

    })
}

function settings_wallets() {

    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/addCoinsToWalletValidation.js' + version, function () {
            //initialize stripe SDK
            (0,_payment_js__WEBPACK_IMPORTED_MODULE_1__.initializeStripe)()

            //reseting add coins form
            if (document.getElementsByClassName('addCoinsToWalletPage')[0]) {
                document.getElementsByClassName('addCoinsToWalletPage')[0].addEventListener('click', function () {
                    document.getElementById('coins').value = ''
                    document.getElementById('coins').classList.remove('ok')
                })

            }

            //initialize PayPal SDK
            (0,_payment_js__WEBPACK_IMPORTED_MODULE_1__.initializePayPal)('capture')

            if (document.getElementsByClassName('calculateHeighter')[0]) {
                let calculateHeighters = document.getElementsByClassName('calculateHeighter')
                for (let i = 0; i < calculateHeighters.length; i++) {
                    calculateHeighters[i].addEventListener('click', function () {
                        setTimeout(function () {
                            calculatePopUpHeight(document.getElementById('addCoinsPaymentPopUp'))
                        })
                    })
                }
            }

            (0,_payment_js__WEBPACK_IMPORTED_MODULE_1__.deleteCards)()
            ;(0,_payment_js__WEBPACK_IMPORTED_MODULE_1__.selectDefaultCard)()
            ;(0,_payment_js__WEBPACK_IMPORTED_MODULE_1__.selectCardForPayment)()

        })

    })

    //when 3ds payment is done we put succes query parameter to show message to user
    let params = new URLSearchParams(window.location.search)
    if (params.has('success')) {
        toastify(getPoTranslate('YOUR_PAYMENT_SUCCESS'))
        history.pushState({}, document.title, location.origin + location.pathname)
    }

    if (params.has('openAddCoins')) {
        openPopup('addCoinsPopUp')
        history.pushState({}, document.title, location.origin + location.pathname)
    }
}

function settings_payouts() {
    hideLoading()
    let transactionHistoryTrLinks = document.getElementsByClassName('transactionHistoryLink')
    for (let i = 0; i < transactionHistoryTrLinks.length; i++) {
        transactionHistoryTrLinks[i].addEventListener('click', function () {

            if (typeof transactionHistoryTrLinks[i].dataset.booking !== 'undefined') {
                showLoading()

                //let newUrlConstructor = new URL(feurl.value + '/booking/' + 512);

                location.assign(transactionHistoryTrLinks[i].dataset.booking)

            }


        })

    }
}

function billing_ingormations() {
    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/step5Validation.js' + version, function () {

        });





    })
}


function talkCategoryF() {

    loadScript('/frontend/assets/js/searchFilters.js' + version, function () {

    })

    let items = document.getElementById('categoryCarousel').getElementsByClassName('tabs-title');
    for (let i = 0; i < items.length; i++) {

        items[i].addEventListener('click', function () {

            this.style.textDecoration = 'underline';
            this.getElementsByTagName('span')[0].style.color = '#313131';
            this.getElementsByTagName('span')[1].style.color = '#313131';
            showLoading();
            location.assign(location.href + '/' + this.getElementsByClassName('innerTitlesForCarouselSlider')[0].textContent.trim());
        });

    }

}

function booking_thank_you_page() {

    /* if (document.getElementsByClassName('dateHolderBookingToShow')[0]) {
     document.getElementsByClassName('dateHolderBookingToShow')[0].style.visibility = 'visible'
     }
     if (document.getElementsByClassName('dateToShowOnThankYou')[0]) {
     let dateToShowOnThankYou = document.getElementsByClassName('dateToShowOnThankYou')
     for (let i = 0; i < dateToShowOnThankYou.length; i++) {
     dateToShowOnThankYou[i].textContent = getDateWithMonthName(dateToShowOnThankYou[i].textContent.trim())
     }
     } */

    window.localStorage.removeItem('bookingObj');

    window.addEventListener('resize', resizeDots);
    resizeDots();

    function resizeDots() {
        let maxHeight;
        if (document.getElementsByClassName('thankyou-item')[0]) {
            let heights = document.getElementsByClassName('thankyou-item');
            maxHeight = heights[0].offsetHeight;
            for (let i = 0; i < heights.length; i++) {
                if (heights[i].offsetHeight > maxHeight) {
                    maxHeight = heights[i].offsetHeight;
                }

            }
        }

        if (document.getElementById('styledResizer')) {
            document.getElementById('styledResizer').remove();
        }

        let style = document.createElement('style');
        style.id = 'styledResizer';
        style.innerHTML = '.icon-re-size::before {height:' + (maxHeight - 64) + 'px!important}';

        document.getElementsByClassName('thankyou-item')[0].appendChild(style);

    }

}

function about_meF() {
    loadScript('/frontend/assets/js/step3Validation.js' + version, function () {

    })
}


function talkDetailFunction() {
    let follow_user = document.getElementsByClassName('follow_user');
    for (let i = 0; i < follow_user.length; i++) {
        follow_user[i].addEventListener('click', function () {
            (0,_routeHelpers_js__WEBPACK_IMPORTED_MODULE_0__.followFunction)(this, false);
        })

    }

}

function jtc_welcomeF() {


    if (document.getElementById('getStartedJtc')) {
        let getStartedJtc = document.getElementById('getStartedJtc');
        getStartedJtc.addEventListener('click', function () {
            let xhr = new XMLHttpRequest()

            let params = {
                '_token': token,
            };

            xhr.onloadstart = function () {
                showLoading();
            };

            xhr.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.response);

                    if (response.success === true) {
                        let partnerId = document.querySelector("meta[name='partner_id']")
                        if (loggedIn) {
                            location.href = '/jtc/create-profile';
                        } else {

                            location.href = '/jtc/create-profile';
                        }


                    } else if (response.success === false) {
                        toastify(response.message)
                    }


                }
            };

            xhr.onerror = function (error) {
                toastify(this.statusText);
                Sentry.captureException(new SubmitFeedbackSubmitError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
            };

            xhr.open('POST', '/jtc/start', true);

            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

            xhr.send(JSON.stringify(params));
        });
    }


}

function settingsPayoutExclusive() {
    let cpPayments = document.getElementsByClassName('cpPayment');
    let hasEventListener = false;

    for (let i = 0; i < cpPayments.length; i++) {
        cpPayments[i].addEventListener('click', function () {
            //this.dataset.date, uzimamo date i saljemo ga preko ajaxa serveru, server nam vraca podatke za payment popup
            let xhr = new XMLHttpRequest();

            // Payout Data from clicked element.
            let data = {
                payout: this.getAttribute('data-payout'),
            };

            let url = '/v1/payouts/' + data.payout;

            // Popup element.
            let popup = document.getElementById(cpPayments[i].dataset.popup);


            if (data.payout === 'currentEarnings') {
                url = '/v1/payouts/current-earnings';
            }

            xhr.open('GET', url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('Authorization', document.querySelector('meta[name="access_token"]').content);
            xhr.setRequestHeader('Accept-Language', document.querySelector('meta[name="app_language"]').content);

            xhr.send();

            xhr.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.response);

                    populatePopup(response.data)

                    calculatePopUpHeight(document.getElementById('payoutPopup'), 52)
                }
            }

            /**
             * Populate Payout Modal with the Data from the response.
             *
             * @param data
             */
            function populatePopup(data) {
                let popupBookingsContainer = popup.querySelector('.paymentItemsContainer');
                let popupBookings = popup.querySelectorAll('.paymentItemsPaymentPopup');

                popup.querySelector('.add-time-title').innerHTML = (url !== '/v1/payouts/current-earnings' ? getPoTranslate('PAYOUT') : getPoTranslate('TOTAL')) + ' ' + getPoTranslate('MONTH_' + data.month.toUpperCase() + '_LONG') + ' ' + data.year;
                popup.querySelector('.payoutPopupMethodTotal').innerHTML = '€ ' + data.payout;
                popup.querySelector('.payoutPopupMethodTotalSub').innerHTML = data.talks_count + ' ' + getPoTranslate('TALKS') + ' / ' + data.duration;
                popup.querySelector('.payoutPopupBoldText').innerHTML = data.payout_date ? getPoTranslate('PAYOUT_MODAL_SUBTITLE').replace(':method', 'IBAN').replace(':date', data.payout_date) : 'Current earnings';
                popup.querySelector('.payoutTableBlackText.iban').innerHTML = data.iban;
                popup.querySelector('.payoutTableBlackText.name').innerHTML = data.name;

                if (!hasEventListener) {
                    popup.querySelector('.btn').addEventListener('click', sendPayoutMail.bind(event, data.payout_id));
                    hasEventListener = true;
                }

                popup.querySelector('.btn').style.display = (url !== '/v1/payouts/current-earnings' ? 'inline-block' : 'none');

                if (url === '/v1/payouts/current-earnings') {
                    popup.querySelector('div').style.overflowY = 'hidden';
                    popupBookingsContainer.style.maxHeight = '200px';
                    popupBookingsContainer.style.overflowY = 'auto';
                }

                data.bookings.forEach(booking => {
                    let popupBooking = popupBookings[0].cloneNode(true);

                    popupBooking.querySelector('.payoutTableBlackText').innerHTML = booking.headline;
                    popupBooking.querySelector('.stateOfPaymentPayout').innerHTML = booking.date + ' ' + (booking.extension ? '(Extension)' : '');
                    popupBooking.querySelector('.pricePayment').innerHTML = booking.price + ' €';

                    popupBookingsContainer.appendChild(popupBooking.cloneNode(true));
                });

                popupBookings.forEach(booking => booking.outerHTML = '');
            }

            /**
             * Send Payout Summary to the Client.
             *
             * @param payout
             */
            function sendPayoutMail(payout) {
                let xhr = new XMLHttpRequest();
                xhr.open('POST', '/v1/payouts/' + payout + '/send-payout-summary');
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('Authorization', bearerToken);
                xhr.setRequestHeader('Accept-Language', document.querySelector('meta[name="app_language"]').content);
                xhr.send();

                xhr.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        let response = JSON.parse(this.response);
                        toastify(response.message);
                    }
                };
            }

            setTimeout(function () {
                calculatePopUpHeight(document.getElementById(cpPayments[i].dataset.popup), 52);
            }, 310);

            openPopup(this.dataset.popup);
        });

    }
}

function settings_followingF() {

    //reject user from private fallowing list
    if (document.getElementsByClassName('rejectFollowerPrivate')[0]) {

        let rejectFollowerPrivate = document.getElementsByClassName('rejectFollowerPrivate')

        for (let i = 0; i < rejectFollowerPrivate.length; i++) {

            rejectFollowerPrivate[i].addEventListener('click', function (e) {
                e.preventDefault()
                showLoading()
                let xhr = new XMLHttpRequest()
                let url = envAppBackendUrl + '/reject-follow-request/' + e.currentTarget.dataset.userId

                let params = {
                    '_token': token
                }

                xhr.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {
                        let response = JSON.parse(this.response)

                        if (response.success === true) {


                            let parent = rejectFollowerPrivate[i].parentElement.parentElement.parentElement
                            parent.style.scale = '0'
                            parent.style.opacity = '0'
                            setTimeout(function () {
                                parent.remove()

                                if (document.getElementById('privatePendingContainer').getElementsByClassName('followRequestContainer').length === 0) {
                                    document.getElementById('privatePendingContainer').innerHTML = ''
                                } else {
                                    let numberOfFollowers = document.getElementsByClassName('numberOfFollowers')
                                    for (let i = 0; i < numberOfFollowers.length; i++) {
                                        numberOfFollowers[i].textContent = parseInt(numberOfFollowers[i].textContent) - 1
                                    }
                                }
                            }, 310)

                            toastify(response.message)
                        } else if (response.success === false) {
                            toastify(response.message)
                        }


                        hideLoading()
                    }
                }

                xhr.onloadend = function () {
                    hideLoading()
                }

                xhr.onerror = function (error) {
                    hideLoading()
                    toastify(this.statusText)
                    Sentry.captureException(new SubmitRejectPrivateFallowing(error + 'status: ' + this
                        .statusText +
                        '|| response: ' + this.statusText + ' || url: ' + location.href));
                }

                xhr.open('POST', url, true)

                xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
                xhr.setRequestHeader('Authorization', bearerToken)
                xhr.setRequestHeader('X-CSRF-TOKEN', token)

                xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

                xhr.send(JSON.stringify(params))
            })

        }



        class SubmitRejectPrivateFallowing extends Error {
            constructor(message) {
                super(message)
                this.name = "SubmitRejectPrivateFallowing"
            }
        }
    }

    //remove user from private fallowing list
    if (document.getElementsByClassName('removeUserFromFollowingList')[0]) {

        let removeUserFromFollowingList = document.getElementsByClassName('removeUserFromFollowingList')

        for (let i = 0; i < removeUserFromFollowingList.length; i++) {

            removeUserFromFollowingList[i].addEventListener('click', _routeHelpers_js__WEBPACK_IMPORTED_MODULE_0__.removePrivateFollower)

        }

    }

    //accept user to private fallowing list



    if (document.getElementsByClassName('acceptFollowerPrivate')[0]) {
        let acceptFollowerPrivate = document.getElementsByClassName('acceptFollowerPrivate')

        for (let i = 0; i < acceptFollowerPrivate.length; i++) {

            acceptFollowerPrivate[i].addEventListener('click', _routeHelpers_js__WEBPACK_IMPORTED_MODULE_0__.acceptFollowRequest)

        }

    }
}


function jtc2_create_profileF() {

    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/jtc2Step1Validators.js' + version, function () {
            loadScript('/frontend/assets/js/loginRegisterForgot.js' + version, function () {
                showHidePassword()


            })

        })
    })

}

function jtc2_email_verificationF() {

    loadScript('/frontend/assets/js/jtc2Step2Validators.js' + version, function () {

    })

}



function jtc2_add_your_first_talkF() {
    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/talksAndAvailabilityValidation.js' + version, function () {
            if (document.getElementsByClassName('addPrivateTalk')[0]) {
                document.getElementsByClassName('addPrivateTalk')[0].addEventListener('click', function () {

                    window.clickedEdit = 0

                    clearForm(document.getElementById('private-talk-form'))

                    let app_talk_categories = JSON.parse(localStorage.getItem('app_talk_categories_' + getCookie('activeLang')))
                    let data = app_talk_categories.talk_categories.data

                    inputCategories()


                    select_category_input_and_select_subcategory(data, 1, getCategoryLanguageId())

                    inputLanguages()

                    select_language(getLanguageId())

                    document.getElementsByClassName('addNewTalkDescription')[0].classList.remove('dn')
                    document.getElementsByClassName('editnewTalkDescription')[0].classList.add('dn')
                    document.getElementsByClassName('pauseWrap')[0].classList.add('dn')
                    document.getElementById('privateSubmit').classList.add('dn')
                    document.getElementById('privateSubmit').textContent = getPoTranslate('ADD_PRIVATE_TALK')
                    document.getElementsByClassName('pageTitlePoperAva').textContent = getPoTranslate('ADD_PRIVATE_TALK')



                })
            }

            let courseItem = document.getElementsByClassName('dataTalkId');

            for (let i = 0; i < courseItem.length; i++) {
                courseItem[i].addEventListener('click', function () {

                    window.clickedEdit = 1;
                    (0,_comunicationControler_js__WEBPACK_IMPORTED_MODULE_4__.getTalkData)(courseItem[i].dataset.talkId);
                    document.getElementsByClassName('addNewTalkDescription')[0].classList.add('dn');

                    document.getElementsByClassName('editnewTalkDescription')[0].classList.remove('dn');


                });
            }

            (0,_talks_js__WEBPACK_IMPORTED_MODULE_2__.deleteTalk)()
        })
    })
}

function jtc2_set_availabilitiesF() {
    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/jtc2Step3Validators.js' + version, function () {




        })
    })

}

function jtc2_verify_accountF() {
    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/verificationValidation.js' + version, function () {
            document.getElementsByClassName('imagePointerForCropper')[0].addEventListener('click', function () {
                window.verificationSuccess = 2
            })
            document.getElementsByClassName('my-form')[0].addEventListener('click', function () {
                window.verificationSuccess = 1
            })

        });
    });
}

function password_resetF() {
    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/forgotPasswordValidation.js' + version, function () {


        });
    });
}


function routeController() {

    let pageName = document.body.className

    switch (pageName) {

        case 'header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden login-page password_reset':
            password_resetF()
            break
        case 'account_verification':
            accountVerificationF();
            break;

        case 'jtc2_verify_account':
            jtc2_verify_accountF()
            break
        case 'jtc2_set_availabilities':
            jtc2_set_availabilitiesF()
            break
        case 'jtc2_add_your_first_talk':
            jtc2_add_your_first_talkF()
            break
        case 'jtc2_create_profile':
            jtc2_create_profileF()
            break
        case 'jtc2_email_verification':
            jtc2_email_verificationF()
            break
        case 'jtc_welcome':
            jtc_welcomeF();
            break;
        case 'home':
            homeF();
            break;
        case 'settings_following':
            (0,_routeHelpers_js__WEBPACK_IMPORTED_MODULE_0__.followUnfollowUserOptions)();
            settings_followingF()
            break;
        case 'faq':
            faqF();
            break;
        case 'logged_in':
            logged_inF();
            break;
        case 'talk_details':
            talkDetailFunction();
            break;
        case 'profile':
            profileF();
            break;
        case 'privacy-policy':
            privacyPolicyF();
            break;
        case 'about_me':
            about_meF();
            break;
        case 'logout':
            loginF();
            break;
        case 'login':
            loginF();
            break;
        case 'forgot_password':
            forgotPasswordF();
            break;
        case 'signup':
            signUpF();
            break;
        case 'settings_profile':
            settingsProfileF();
            break;
        case 'settings_notifications':
            settingsNotificationF();
            break;
        case 'booking':
            bookingF();
            break;
        case 'courses':
            talks();
            break;
        case 'settings_reviews':
            feedbackComments();
            break;
        case 'video_conference':
            videoConferenceF();
            break;
        case 'book_slot':
            book_slotF();
            break;
        case 'favorites_users':
            favoriteUsers();
            break;
        case 'favorites_talks':
            favoriteTalks();
            break;
        case 'book_slot_payment':
            book_slot_paymentF();
            break;
        case 'settings_wallets':
            settings_wallets();
            break;
        case 'billing_ingormations':
            billing_ingormations();
            break;
        case 'talkCategory':
            talkCategoryF();
            break;
        case 'booking_thank_you':
            booking_thank_you_page();
            break;
        case 'settings_transaction_history':
            settings_payouts();
            break;
        case 'settings_payouts_page':
            jtcSetPayoutOptions();
            jtcSetPayoutOptionsF();
            settingsPayoutExclusive();
            break;
        case 'talkCategorySubcategory':
            talkCategorySubcategoryF();
            break;

    }
}

class SubmitFeedbackSubmitError extends Error {
    constructor(message) {
        super(message);
        this.name = 'SubmitFeedbackSubmitError';
    }
}

class TryCatchGetFeedbackReviewXMLHttpRequestFunction extends Error {
    constructor(message) {
        super(message);
        this.name = 'TryCatchGetFeedbackReviewXMLHttpRequestFunction';
    }
}

class TryCatchSubmitFeedbackReviewXMLHttpRequestFunction extends Error {
    constructor(message) {
        super(message);
        this.name = 'TryCatchSubmitFeedbackReviewXMLHttpRequestFunction';
    }
}

class GetRatingFullError extends Error {
    constructor(message) {
        super(message);
        this.name = 'GetRatingFullError';
    }
}


class FeedbackCommentsUrlError extends Error {
    constructor(message) {
        super(message);
        this.name = 'FeedbackCommentsUrlError';
    }
}



class TeacherAvailableExtensionsError extends Error {
    constructor(message) {
        super(message);
        this.name = 'TeacherAvailableExtensionsError';
    }
}




/***/ }),

/***/ "./src/assets/js/routeHelpers.js":
/*!***************************************!*\
  !*** ./src/assets/js/routeHelpers.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "acceptFollowRequest": () => (/* binding */ acceptFollowRequest),
/* harmony export */   "calendarLogics": () => (/* binding */ calendarLogics),
/* harmony export */   "followFunction": () => (/* binding */ followFunction),
/* harmony export */   "followUnfollowUserOptions": () => (/* binding */ followUnfollowUserOptions),
/* harmony export */   "removePrivateFollower": () => (/* binding */ removePrivateFollower),
/* harmony export */   "showHideCalendarBigSmall": () => (/* binding */ showHideCalendarBigSmall),
/* harmony export */   "showMoreFavoriteUsers": () => (/* binding */ showMoreFavoriteUsers),
/* harmony export */   "showMoreNotifications": () => (/* binding */ showMoreNotifications),
/* harmony export */   "unfallowFunction": () => (/* binding */ unfallowFunction)
/* harmony export */ });
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);


window.jQuery = (jquery__WEBPACK_IMPORTED_MODULE_0___default());


function calendarLogics() {

    //select default calendar
    if (document.getElementsByClassName('defaultCalendarSelection')[0]) {

        let defaultCalendarSelection = document.getElementsByClassName('defaultCalendarSelection')
        for (let i = 0; i < defaultCalendarSelection.length; i++) {
            defaultCalendarSelection[i].addEventListener('click', function (e) {
                if (document.body.className !== 'book_slot') {
                    let that = e.currentTarget

                    showLoading()
                    let calendar_id = that.dataset.calendarId

                    let xhr = new XMLHttpRequest()

                    xhr.onloadstart = function () {
                        showLoading()
                    }

                    xhr.onreadystatechange = function () {

                        if (this.readyState == 4 && this.status == 200) {
                            let response = JSON.parse(this.response);

                            if (response.success === true) {

                                if (that.parentElement.parentElement.parentElement.getElementsByClassName('active')[0]) {
                                    that.parentElement.parentElement.parentElement.getElementsByClassName('active')[0].parentElement.getElementsByClassName('buttoneroKalendar')[0].classList.remove('dn')
                                    that.parentElement.parentElement.parentElement.getElementsByClassName('active')[0].classList.remove('active')

                                }

                                if (that.parentElement.parentElement.parentElement.getElementsByClassName('pon')[0]) {
                                    that.parentElement.parentElement.parentElement.getElementsByClassName('pon')[0].classList.remove('pon')
                                }

                                that.classList.add('active')
                                that.classList.add('pon')


                                that.parentElement.getElementsByClassName('garbage_can')[0].classList.add('dn')

                                //buttoneroKale

                            } else if (response.success === false) {
                                toastify(response.message)
                            }
                            if (document.getElementById('feedbackPopUp')) {
                                closePopup('feedbackPopUp')
                            }

                            hideLoading()
                        }
                    }

                    xhr.onloadend = function () {
                        hideLoading()

                    }

                    xhr.onerror = function (error) {
                        hideLoading()
                        toastify(this.statusText)
                        Sentry.captureException(new SubmitFeedbackSubmitError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
                    }

                    xhr.open('POST', envAppBackendUrl + '/set-primary-calendar/' + calendar_id, true)

                    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
                    xhr.setRequestHeader('Authorization', bearerToken);
                    xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

                    xhr.send()
                } else {

                    e.currentTarget.parentElement.getElementsByClassName('buttoneroKale')[0].click()
                }


            })

        }
    }

    if (document.getElementsByClassName('gear')) {

        let gears = document.getElementsByClassName('gear')
        for (let i = 0; i < gears.length; i++) {
            gears[i].addEventListener('click', function () {

                if (gears[i].dataset.opened === '1') {
                    gears[i].getElementsByTagName('svg')[0].style.rotate = '0deg'
                    gears[i].parentElement.parentElement.getElementsByClassName('tranzicioniHeight')[0].style.maxHeight = '0px'
                    gears[i].dataset.opened = '0'
                    /*       setTimeout(function(){
                              calculatePopUpHeight(document.getElementById('calendarNavigation'),52)
                          },310) */

                } else if (gears[i].dataset.opened === '0') {
                    gears[i].getElementsByTagName('svg')[0].style.rotate = '45deg'
                    gears[i].parentElement.parentElement.getElementsByClassName('tranzicioniHeight')[0].style.maxHeight = '500px'
                    gears[i].dataset.opened = '1'
                    /*      setTimeout(function(){
                             calculatePopUpHeight(document.getElementById('calendarNavigation'),52)
                         },310) */

                }


            })

        }

    }

    if (document.getElementById('connected_calendars')) {
        document.getElementById('connected_calendars').addEventListener('click', function () {
            if (document.getElementsByClassName('buttoneroKale')[0]) {
                let buttoneroKale = document.getElementsByClassName('buttoneroKale')
                for (let i = 0; i < buttoneroKale.length; i++) {
                    if (buttoneroKale[i].dataset.opened === '1') {
                        buttoneroKale[i].click()
                    }

                }
            }
        })
    }

    if (document.getElementsByClassName('swp1')[0]) {
        let calendarStatesSwitch = document.getElementsByClassName('swp1'),
            state
        for (let i = 0; i < calendarStatesSwitch.length; i++) {
            calendarStatesSwitch[i].addEventListener('click', function () {
                if (this.dataset.clicked === '0' || this.dataset.clicked === ' 0 ') {
                    let that = this



                    if (this.dataset.pointer === 'cli') {

                        setTimeout(function () {

                            state = getStateForCalendar(
                                that.parentElement.parentElement.parentElement.getElementsByClassName('clientCaleInputState')[0],
                                that.parentElement.parentElement.parentElement.getElementsByClassName('supplierCaleInputState')[0]
                            )
                        })

                    } else if (this.dataset.pointer === 'sup') {

                        setTimeout(function () {



                            state = getStateForCalendar(
                                that.parentElement.parentElement.parentElement.getElementsByClassName('clientCaleInputState')[0],
                                that.parentElement.parentElement.parentElement.getElementsByClassName('supplierCaleInputState')[0]
                            )
                        })

                    }

                    this.dataset.clicked = '1'


                    setTimeout(function () {

                        submitCalendarState(state, that.dataset.calendarId /* calendar_id */)
                    })

                } else if (this.dataset.clicked === '1' || this.dataset.clicked === ' 1 ') {
                    let that = this

                    if (this.dataset.pointer === 'cli') {

                        setTimeout(function () {
                            state = getStateForCalendar(
                                that.parentElement.parentElement.parentElement.getElementsByClassName('clientCaleInputState')[0],
                                that.parentElement.parentElement.parentElement.getElementsByClassName('supplierCaleInputState')[0]
                            )
                        })




                    } else if (this.dataset.pointer === 'sup') {

                        setTimeout(function () {
                            state = getStateForCalendar(
                                that.parentElement.parentElement.parentElement.getElementsByClassName('clientCaleInputState')[0],
                                that.parentElement.parentElement.parentElement.getElementsByClassName('supplierCaleInputState')[0]
                            )
                        })

                    }

                    this.dataset.clicked = '0'


                    setTimeout(function () {

                        submitCalendarState(state, that.dataset.calendarId, that.parentElement.parentElement.parentElement.parentElement.getElementsByClassName('gear')[0])
                    })
                }
            })
        }
    }

    function submitCalendarState(state, calendar_id, calendar_to_close = false) {

        showLoading()

        let xhr = new XMLHttpRequest()

        let url = envAppBackendUrl + '/calendar-account-state'

        let params = {
            state,
            calendar_id,
            _token: token
        }

        xhr.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.response)

                if (response.success === true) {
                    toastify(response.message)

                    if (document.body.className === 'book_slot') {
                        if (state === 0) {
                            if (calendar_to_close) {

                                calendar_to_close.click()
                            }

                        }

                    }

                } else if (response.success === false) {
                    toastify(response.message)
                }
                if (document.body.className !== 'book_slot') {
                    hideLoading()
                }


            }
        }

        xhr.onerror = function (error) {
            hideLoading()
            toastify(this.statusText)
            Sentry.captureException(
                new SubmitCalendarStateError(
                    error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href
                )
            )
        }

        xhr.open('POST', url, true)
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('Content-Type', 'application/json')
        xhr.setRequestHeader('Authorization', bearerToken)
        xhr.send(JSON.stringify(params))

        class SubmitCalendarStateError extends Error {
            constructor(message) {
                super(message)
                this.name = 'SubmitCalendarStateError'
            }
        }
    }

    function getStateForCalendar(clientCaleInputState, supplierCaleInputState) {
        if (document.body.className === '') {

        }
        if (clientCaleInputState.checked === false && (supplierCaleInputState ? supplierCaleInputState.checked : false) === false) {
            return 0
        } else if (clientCaleInputState.checked === true && (supplierCaleInputState ? supplierCaleInputState.checked : false) === false) {
            return 1
        } else if (clientCaleInputState.checked === false && (supplierCaleInputState ? supplierCaleInputState.checked : true) === true) {
            return 2
        } else if (clientCaleInputState.checked === true && (supplierCaleInputState ? supplierCaleInputState.checked : true) === true) {
            return 3
        }
    }

    //turn on whole client calle
    if (
        document.body.className === 'book_slot'
    ) {
        if (document.getElementsByClassName('clientCalendarSwitch')[0]) {
            let clientCalendarSwitch = document.getElementsByClassName('clientCalendarSwitch')

            for (let i = 0; i < clientCalendarSwitch.length; i++) {
                clientCalendarSwitch[i].addEventListener('click', function () {


                    getNewTeacherAvailabilityData()
                })
            }
        }
    }


    //logics for turn off and turn on particular cale

    if (document.getElementsByClassName('caleSwitchesCheckers')[0]) {
        let caleSwitchesCheckers = document.getElementsByClassName('caleSwitchesCheckers')
        for (let i = 0; i < caleSwitchesCheckers.length; i++) {
            caleSwitchesCheckers[i].addEventListener('click', function () {
                if (this.dataset.clicked === '0' || this.dataset.clicked === ' 0 ') {
                    submitSubCallendarChange(1, parseInt(this.dataset.calendarId) /* calendar_id */)
                    this.dataset.clicked = '1'
                } else if (this.dataset.clicked === '1' || this.dataset.clicked === ' 1 ') {

                    submitSubCallendarChange(0, parseInt(this.dataset.calendarId) /* calendar_id */)

                    this.dataset.clicked = '0'
                }
            })
        }
    }

    function submitSubCallendarChange(state, calendar_id) {


        showLoading()

        let xhr = new XMLHttpRequest()

        let url = envAppBackendUrl + '/calendar-state'

        let params = {
            state,
            calendar_id,
            _token: token
        }

        xhr.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.response)

                if (response.success === true) {

                    if (document.body.className === 'book_slot') {

                        if (document.getElementsByClassName('calendarFunnelHighlightingState')[0]) {
                            let calendarFunnelHighlightingState = document.getElementsByClassName('calendarFunnelHighlightingState')[0]

                            calendarFunnelHighlightingState.addEventListener('click', function () {
                                if (calendarFunnelHighlightingState.dataset.clicked === '1') {

                                    removeHighlightedAvailabilites()

                                    calendarFunnelHighlightingState.dataset.clicked = '0'
                                } else if (calendarFunnelHighlightingState.dataset.clicked === '0') {

                                    if (document.getElementById('calendarFunnelHighlightingState').checked) {
                                        calculateUserAvailabilites()
                                    }
                                    hideLoading()
                                    calendarFunnelHighlightingState.dataset.clicked = '1'
                                }
                            })
                        }

                        getNewTeacherAvailabilityData()

                    } else {

                        toastify(response.message)
                        hideLoading()
                    }

                } else if (response.success === false) {
                    toastify(response.message)
                    hideLoading()
                }

            }

        }

        xhr.onerror = function (error) {
            hideLoading()
            toastify(this.statusText)
            Sentry.captureException(
                new SubmitSubCalendarChangesError(
                    error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href
                )
            )
        }

        xhr.open('POST', url, true)
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('Content-Type', 'application/json')
        xhr.setRequestHeader('Authorization', bearerToken)
        xhr.send(JSON.stringify(params))

        class SubmitSubCalendarChangesError extends Error {
            constructor(message) {
                super(message)
                this.name = 'SubmitSubCalendarChangesError'
            }
        }
    }

    function getNewTeacherAvailabilityData() {

        showLoading()

        let xhr = new XMLHttpRequest()

        let url = envAppBackendUrl + '/supplier-availabilities/' + document.getElementsByClassName('dataTalkId')[0]?.dataset.talkId ?? 0

        xhr.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.response)

                if (response.success === true) {

                    toastify(response.message)
                    overlapingSlots = {}

                    document.getElementById('newTeacherAvailabilityDatesTime').value = JSON.stringify(response.data)
                    createOverlapingSlotsObject(response.data, document.getElementById('calendar-body').getElementsByClassName('selected')[0].dataset.fullDate)

                    removeHighlightedAvailabilites()
                    if (document.getElementById('calendarFunnelHighlightingState').checked) {
                        calculateUserAvailabilites()
                    }
                    hideLoading()
                } else if (response.success === false) {
                    toastify(response.message)
                    hideLoading()
                }


            }

        }

        xhr.onerror = function (error) {
            hideLoading()
            toastify(this.statusText)
            Sentry.captureException(
                new SubmitCalendarChangeOnBookingFunnel(
                    error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href
                )
            )
        }

        xhr.open('GET', url, true)
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('Content-Type', 'application/json')
        xhr.setRequestHeader('Authorization', bearerToken)
        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

        xhr.send()

        class SubmitCalendarChangeOnBookingFunnel extends Error {
            constructor(message) {
                super(message)
                this.name = 'SubmitCalendarChangeOnBookingFunnel'
            }
        }
    }

}

function acceptFollowRequest(e) {

    e.preventDefault()
    showLoading()
    let target = e.currentTarget
    let xhr = new XMLHttpRequest()
    let url = envAppBackendUrl + '/accept-follow-request/' + target.dataset.userId

    let params = {
        '_token': token
    }

    xhr.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.response)

            if (response.success === true) {
                toastify(response.message)

                let parent = target.parentElement.parentElement.parentElement
                parent.style.scale = '0'
                parent.style.opacity = '0'


                setTimeout(function () {

                    if (!document.getElementById('privateFollowersContainer')) {
                        let privateFollowersContainer = document.createElement('div')
                        privateFollowersContainer.id = 'privateFollowersContainer'

                        let privateFollowersContainerHeadline = document.createElement('h5')
                        privateFollowersContainerHeadline.textContent = getPoTranslate('PRIVATE_FOLLOWERS')

                        privateFollowersContainer.append(privateFollowersContainerHeadline)

                        let privateFollowersContainerItems = document.createElement('div')
                        privateFollowersContainerItems.id = 'privateFollowersContainerItems'

                        let privateFollowersContainerDivContainer = createPrivateFollowerContainer(target, parent)

                        privateFollowersContainerItems.append(privateFollowersContainerDivContainer)

                        privateFollowersContainer.append(privateFollowersContainerItems)

                        let privateFollowersHr = document.createElement('hr')
                        privateFollowersHr.className = 'pr24'

                        document.getElementById('fallowingPageMainCont').append(privateFollowersContainer)
                    } else {

                        let privateFollowersContainerDivContainer = createPrivateFollowerContainer(target, parent)

                        document.getElementById('privateFollowersContainerItems').append(privateFollowersContainerDivContainer)


                    }


                }, 310)

            } else if (response.success === false) {
                toastify(response.message)
            }


            hideLoading()
        }
    }

    xhr.onloadend = function () {
        hideLoading()
    }

    xhr.onerror = function (error) {
        hideLoading()
        toastify(this.statusText)
        Sentry.captureException(new SubmitAcceptPrivateFallowing(error + 'status: ' + this
            .statusText +
            '|| response: ' + this.statusText + ' || url: ' + location.href));
    }

    xhr.open('POST', url, true)

    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
    xhr.setRequestHeader('Authorization', bearerToken)
    xhr.setRequestHeader('X-CSRF-TOKEN', token)

    xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

    xhr.send(JSON.stringify(params))

}

class SubmitAcceptPrivateFallowing extends Error {
    constructor(message) {
        super(message)
        this.name = "SubmitAcceptPrivateFallowing"
    }
}

function createPrivateFollowerContainer(clickedElement, parent) {

    let privateFollowersContainerDivContainer = document.createElement('div')
    privateFollowersContainerDivContainer.className = 'df aic w-100 followRequestContainer g1rem mb16'

    let privateFollowersContainerDivContainerFirstDiv = document.createElement('div')
    privateFollowersContainerDivContainerFirstDiv.className = 'df aic jcc br12 oh mh82'
    privateFollowersContainerDivContainerFirstDiv.innerHTML = parent.getElementsByClassName('mh82')[0].innerHTML

    privateFollowersContainerDivContainer.append(privateFollowersContainerDivContainerFirstDiv)


    let privateFollowersContainerDivContainerSeccondDiv = document.createElement('div')
    privateFollowersContainerDivContainerSeccondDiv.className = 'df fdc aic jcsa w-100'

    privateFollowersContainerDivContainer.append(privateFollowersContainerDivContainerSeccondDiv)

    let privateFollowersContainerDivContainerSeccondDivP = document.createElement('p')
    privateFollowersContainerDivContainerSeccondDivP.className = 'df jcfs w-100 mb0 pendingFallowersName'
    privateFollowersContainerDivContainerSeccondDivP.innerHTML = parent.getElementsByClassName('pendingFallowersName')[0].innerHTML

    privateFollowersContainerDivContainerSeccondDiv.append(privateFollowersContainerDivContainerSeccondDivP)

    let privateFollowersContainerDivContainerSeccondDivDiv = document.createElement('p')
    privateFollowersContainerDivContainerSeccondDivDiv.className = 'df aic jcfs w-100'

    privateFollowersContainerDivContainerSeccondDiv.append(privateFollowersContainerDivContainerSeccondDivDiv)

    let privateFollowersContainerDivContainerSeccondDivDivButton = document.createElement('button')
    privateFollowersContainerDivContainerSeccondDivDivButton.className = 'btn hollow mr8 lh24 h40 removeUserFromFollowingList'
    privateFollowersContainerDivContainerSeccondDivDivButton.dataset.userId = clickedElement.dataset.userId
    privateFollowersContainerDivContainerSeccondDivDivButton.textContent = getPoTranslate('REMOVE')

    privateFollowersContainerDivContainerSeccondDivDivButton.addEventListener('click', removePrivateFollower)

    privateFollowersContainerDivContainerSeccondDivDiv.append(privateFollowersContainerDivContainerSeccondDivDivButton)

    parent.remove()

    if (document.getElementById('privatePendingContainer')) {
        if (document.getElementById('privatePendingContainer').getElementsByClassName('followRequestContainer').length === 0) {
            document.getElementById('privatePendingContainer').innerHTML = ''
        } else {
            let numberOfFollowers = document.getElementsByClassName('numberOfFollowers')
            for (let i = 0; i < numberOfFollowers.length; i++) {
                numberOfFollowers[i].textContent = parseInt(numberOfFollowers[i].textContent) - 1

            }
        }
    }

    return privateFollowersContainerDivContainer
}

function removePrivateFollower(e) {

    e.preventDefault()
    showLoading()
    let target = e.currentTarget
    let xhr = new XMLHttpRequest()
    let url = envAppBackendUrl + '/remove-follow-requests/' + target.dataset.userId

    let params = {
        '_token': token,
        'teacher_cancel': true
    }

    xhr.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.response)

            if (response.success === true) {
                toastify(response.message)

                let parent = target.parentElement.parentElement.parentElement
                parent.style.scale = '0'
                parent.style.opacity = '0'
                setTimeout(function () {
                    parent.remove()
                }, 310)

            } else if (response.success === false) {
                toastify(response.message)
            }


            hideLoading()
        }
    }

    xhr.onloadend = function () {
        hideLoading()
    }

    xhr.onerror = function (error) {
        hideLoading()
        toastify(this.statusText)
        Sentry.captureException(new SubmitRemovePrivateFallowing(error + 'status: ' + this
            .statusText +
            '|| response: ' + this.statusText + ' || url: ' + location.href));
    }

    xhr.open('POST', url, true)

    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
    xhr.setRequestHeader('Authorization', bearerToken)
    xhr.setRequestHeader('X-CSRF-TOKEN', token)

    xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

    xhr.send(JSON.stringify(params))

}

class SubmitRemovePrivateFallowing extends Error {
    constructor(message) {
        super(message)
        this.name = "SubmitRemovePrivateFallowing"
    }
}



function followUnfollowUserOptions() {

    //put follow events on profile page

    let follow_user = document.getElementsByClassName('follow_user')

    for (let i = 0; i < follow_user.length; i++) {
        if (typeof follow_user[i].dataset.eventAdded === 'undefined') {
            follow_user[i].dataset.eventAdded = "1"
            follow_user[i].addEventListener('click', followFunction)
        }
    }

    let unfollow_user = document.getElementsByClassName('unfollow_user')

    if (document.body.className === 'favorites_users') {
        unfollow_user = Array.from(document.getElementsByClassName('unfollow_user')).concat(Array.from(document.getElementsByClassName('heartSvg')))
    }

    for (let i = 0; i < unfollow_user.length; i++) {
        if (typeof unfollow_user[i].dataset.eventAdded === 'undefined') {
            unfollow_user[i].dataset.eventAdded = "1"
            unfollow_user[i].addEventListener('click', unfallowFunction)
        }
    }

}

function unfallowFunction(e, t) {

    let target = t ? e : e.currentTarget

    let userId = t ? target.dataset.user : target.dataset.user


    //Route::post('/remove-follow-requests/{id}', [UserFollowedApiController::class, 'removeFollow']);
    let url = envAppBackendUrl + '/unfollow-user-request/' + userId
    let xhr = new XMLHttpRequest();

    let data = {
        '_token': document.querySelector('meta[name="csrf-token"]').content
    };

    xhr.onloadstart = function () {
        showLoading()
    }

    xhr.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.response)

            if (response.success === true) {
                if (document.body.className === "favorites_users") {

                    toastify(response.message)

                    if (target.dataset.device === "desktop") {
                        target.closest('.favorites_holder').remove()
                        let heartSvgs = document.getElementsByClassName('heartSvg')
                        for (let i = 0; i < heartSvgs.length; i++) {
                            if (heartSvgs[i].dataset.user === target.dataset.user) {
                                heartSvgs[i].closest('.pBottomItemsSearch').remove()
                            }
                        }

                        if (document.getElementsByClassName('tabDeskFavUsers')[0].getElementsByClassName('favorites_holder').length === 0) {
                            let isShowMoreOnThePage = document.getElementsByClassName('favoritesShowMore')

                            for (let i = 0; i < isShowMoreOnThePage.length; i++) {
                                if (isShowMoreOnThePage[i].classList.contains('dn')) {

                                    let showNoFavorites = document.getElementsByClassName('no-found-heading')
                                    for (let i = 0; i < showNoFavorites.length; i++) {
                                        showNoFavorites[i].classList.remove('dn')
                                    }

                                    hideLoading()
                                    break

                                } else {

                                    showLoading()
                                    isShowMoreOnThePage[i].click()
                                    break

                                }
                            }


                        } else {
                            hideLoading()
                        }
                    } else if (target.dataset.device === "mobile") {
                        target.closest('.pBottomItemsSearch').remove()
                        let unfollow_user = document.getElementsByClassName('tabDeskFavUsers')[0].getElementsByClassName('unfollow_user')
                        for (let i = 0; i < unfollow_user.length; i++) {
                            if (unfollow_user[i].dataset.user === target.dataset.user) {
                                unfollow_user[i].closest('.favorites_holder').remove()
                            }
                        }


                        if (document.getElementsByClassName('tabDeskFavUsers')[0].getElementsByClassName('favorites_holder').length === 0) {
                            let isShowMoreOnThePage = document.getElementsByClassName('favoritesShowMore')

                            for (let i = 0; i < isShowMoreOnThePage.length; i++) {
                                if (isShowMoreOnThePage[i].classList.contains('dn')) {

                                    let showNoFavorites = document.getElementsByClassName('no-found-heading')
                                    for (let i = 0; i < showNoFavorites.length; i++) {
                                        showNoFavorites[i].classList.remove('dn')
                                    }
                                    hideLoading()
                                    break
                                } else {
                                    showLoading()
                                    isShowMoreOnThePage[i].click()
                                    break
                                }
                            }


                        } else {
                            hideLoading()
                        }


                    }


                    /* } else {

                        let parent = target.parentElement
                        let folowersNumber = target.parentElement.parentElement.parentElement.getElementsByClassName('social-box')[0].getElementsByTagName('strong')[0]
                        folowersNumber.textContent = (parseInt(folowersNumber.textContent) - 1) + ' '
                        target.removeEventListener('click', unfallowFunction)

                        target.textContent = getPoTranslate('FOLLOW')

                        target.className = "hollow btn w-100 follow_user mb0"

                        target.addEventListener('click', followFunction)

                        parent.append(target)


                        let svg
                        let that
                        let heartSvgs = document.getElementsByClassName('heartSvg')

                        for (let i = 0; i < heartSvgs.length; i++) {
                            if (heartSvgs[i].dataset.user === target.dataset.user) {
                                that = heartSvgs[i]
                                svg = heartSvgs[i].getElementsByTagName('svg')[0]
                            }
                        }

                        svg.style.transform = 'scale(0)'

                        setTimeout(function () {
                            svg.innerHTML = '<path d="M7 1.5L10.5 4L11.5 3.5L12.5 2.5L14 1.5H17.5C18.3 1.5 19.1667 2.83333 19.5 3.5C19.8333 4.66667 20.5 7.1 20.5 7.5C20.5 7.9 18.1667 10.6667 17 12C15 13.8333 10.9 17.6 10.5 18C10.1 18.4 6 13.8333 4 11.5L1.5 9L1 6.5L2 3.5L4.5 1.5H7Z" fill="#F4F9FF" stroke="black"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.44583 2.17107C4.06979 2.17107 2.16667 4.07378 2.16667 6.39259C2.16667 7.522 2.61498 8.54793 3.35127 9.30824L10.8332 16.9082L18.1906 9.43199L18.2021 9.42092C19.0056 8.65095 19.5 7.57855 19.5 6.39259C19.5 4.07378 17.5969 2.17107 15.2208 2.17107C14.8518 2.17107 14.4317 2.31793 13.9572 2.64139C13.484 2.96407 13.0199 3.41997 12.5862 3.92814C11.67 5.00131 9.99667 5.00131 9.0805 3.92814C8.64672 3.41997 8.18269 2.96407 7.70939 2.64139C7.23499 2.31793 6.81484 2.17107 6.44583 2.17107ZM0 6.39259C0 2.84939 2.89862 0 6.44583 0C7.39449 0 8.23651 0.374791 8.92829 0.846413C9.62108 1.3188 10.2272 1.93141 10.7271 2.5169C10.749 2.54276 10.784 2.56195 10.8333 2.56195C10.8826 2.56195 10.9176 2.54276 10.9396 2.5169C11.4395 1.93141 12.0456 1.3188 12.7384 0.846413C13.4302 0.374791 14.2722 0 15.2208 0C18.768 0 21.6667 2.84939 21.6667 6.39259C21.6667 8.19351 20.9145 9.81964 19.7116 10.9784L10.8334 20L1.80025 10.8243C0.687819 9.67754 0 8.11459 0 6.39259Z" fill="#172B4D"></path>'
                            svg.setAttribute('width', '22')
                            svg.setAttribute('height', '20')
                            svg.setAttribute('viewBox', '0 0 22 20')
                            svg.setAttribute('fill', 'none')
                            svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg')

                            that.dataset.follow = 0
                            that.parentElement.getElementsByClassName('numberF')[0].textContent = parseInt(that.parentElement.getElementsByClassName('numberF')[0].textContent) - 1

                            svg.style.transform = 'scale(1)'

                        }, 310)
                    } */



                } else if (document.body.className === "profile") {

                    let faworiteButtonsConts = document.getElementsByClassName('fallowFavCont')
                    for (let i = 0; i < faworiteButtonsConts.length; i++) {
                        if (faworiteButtonsConts[i].getElementsByTagName('button')[0]) {
                            let targetButton = faworiteButtonsConts[i].getElementsByTagName('button')[0]

                            if (targetButton.parentElement) {
                                let parent = targetButton.parentElement
                                let target = targetButton
                                target.removeEventListener('click', unfallowFunction)
                                targetButton.remove()


                                target.textContent = getPoTranslate('FOLLOW')


                                target.className = "hollow btn w-100 secondary follow_user mb0"


                                target.innerHTML = getPoTranslate('FOLLOW')

                                target.addEventListener('click', followFunction)


                                parent.append(target)
                            }

                        }

                    }


                    let folowerS = document.getElementsByClassName('folowerS')
                    for (let i = 0; i < folowerS.length; i++) {
                        folowerS[i].textContent = parseInt(folowerS[i].textContent) - 1

                    }

                    toastify(response.message)
                    hideLoading()
                } else {

                    let parent = e.target.parentElement
                    let userId = e.target.dataset.user
                    e.target.remove()
                    let fallowingButton = document.createElement('button')
                    fallowingButton.className = "button extended expanded secondary follow_user w-100"
                    fallowingButton.dataset.user = userId

                    fallowingButton.innerHTML = getPoTranslate('FOLLOW')

                    fallowingButton.addEventListener('click', followFunction)


                    parent.append(fallowingButton)



                    toastify(response.message)
                }

            } else if (response.success === false) {
                toastify(response.message)
            }

        }
    }

    xhr.onerror = function (error) {
        toastify(this.statusText);
        Sentry.captureException(new UnfollowUserRequestError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
    }

    xhr.open('POST', url, true)
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
    xhr.setRequestHeader('Authorization', bearerToken)
    xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

    xhr.send(JSON.stringify(data));



}

function followFunction(e, t) {

    let target = t ? e : e.currentTarget

    let userId
    if (document.body.className !== 'talk_details') {
        userId = t ? target.dataset.user : target.dataset.user
    } else {
        userId = e.dataset.user
    }


    //Route::post('/remove-follow-requests/{id}', [UserFollowedApiController::class, 'removeFollow']);
    let url = envAppBackendUrl + '/follow-user-request/' + userId
    let xhr = new XMLHttpRequest();

    let data = {
        '_token': token
    };

    xhr.onloadstart = function () {
        showLoading()
    }

    xhr.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.response)
            if (document.body.className === "profile") {

                let faworiteButtonsConts = document.getElementsByClassName('fallowFavCont')
                for (let i = 0; i < faworiteButtonsConts.length; i++) {


                    if (faworiteButtonsConts[i].getElementsByTagName('button')[0]) {
                        let targetButton = faworiteButtonsConts[i].getElementsByTagName('button')[0]


                        let parent = targetButton.parentElement
                        let target = targetButton

                        targetButton.remove()
                        target.removeEventListener('click', followFunction)

                        let privateFollow = getPoTranslate('FOLLOWING')
                        if (target.dataset.private) {
                            if (target.dataset.private === '2') {
                                privateFollow = getPoTranslate('FOLLOWING_PENDING')
                            }
                        }

                        target.innerHTML = '<svg class="mr4" width="11" height="8" viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M3.76666 6.13325L9.89991 0L10.8333 0.933373L3.76666 8L0 4.23334L0.933373 3.29997L3.76666 6.13325Z" fill="white"></path></svg> ' + privateFollow

                        target.className = "btn warning followingPending w-100 mb0"
                        if (target.dataset.private) {
                            if (target.dataset.private === '2') {
                                target.classList.add('followingPending')
                                target.classList.add('warning')
                                target.setAttribute('onclick', 'openPopup("privatePopupCancel")')
                            }
                        } else {
                            target.addEventListener('click', unfallowFunction)
                        }



                        parent.append(target)

                    }
                }
                if (!target.dataset.private) {

                    let folowerS = document.getElementsByClassName('folowerS')[0]

                    folowerS.textContent = parseInt(folowerS.textContent) + 1
                }


                toastify(response.message)
                hideLoading()

            } else {
                let parent = e.target.parentElement
                let userId = e.target.dataset.user
                e.target.remove()
                let fallowingButton = document.createElement('button')
                fallowingButton.className = "button extended expanded unfollow_user w-100"
                fallowingButton.dataset.user = userId

                fallowingButton.innerHTML = '<svg width="11" height="8" viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M3.76666 6.13325L9.89991 0L10.8333 0.933373L3.76666 8L0 4.23334L0.933373 3.29997L3.76666 6.13325Z" fill="white"></path></svg> ' + getPoTranslate('FOLLOWING_PENDING')

                fallowingButton.addEventListener('click', unfallowFunction)

                parent.append(fallowingButton)


                toastify(response.message)
            }

        }
    }

    xhr.onerror = function (error) {
        toastify(this.statusText);
        Sentry.captureException(new GetUserFollowError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
    }

    xhr.open('POST', url, true)
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
    xhr.setRequestHeader('Authorization', bearerToken)
    xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

    xhr.send(JSON.stringify(data));




}



function showMoreFavoriteUsers() {
    let offsetAdd = parseInt(document.getElementById('default_favorites_show_more_users').value)
    var offset = 0
    let favoritesShowMores = document.getElementsByClassName('favoritesShowMore')
    for (let i = 0; i < favoritesShowMores.length; i++) {
        favoritesShowMores[i].addEventListener('click', function () {
            showLoading()
            if (document.body.className === 'favorites_users') {
                if (document.getElementsByClassName('tabDeskFavUsers')[0].getElementsByClassName('favorites_holder')[0]) {



                    offset = parseInt(document.getElementsByClassName('tabDeskFavUsers')[0].getElementsByClassName('favorites_holder').length)

                }
            } else {

                offset += offsetAdd
            }

            displayFavoriteUsers(offset, this, document.getElementById('filter-form')?.elements ?? false)
        })

    }




    function displayFavoriteUsers(offset, target, filter) {
        let f

        if (filter) {
            f = getFilterObj(filter)
        } else {
            f = {}
        }

        jQuery.ajax({
            type: 'GET',
            url: '/favorites/users',
            data: {
                'offset': offset
            },
            beforeSend: function () {
                // Handle the beforeSend event
                showLoading()
            },
            complete: function () {
                hideLoading()

            },
            success: function (response) {

                if ((offset + offsetAdd) >= response.total_users) {
                    if (document.getElementsByClassName('favoritesShowMore')[0]) {
                        let favoritesShowMore = document.getElementsByClassName('favoritesShowMore')
                        for (let i = 0; i < favoritesShowMore.length; i++) {
                            favoritesShowMore[i].classList.add('dn')

                        }
                    }
                }

                if (response.success) {
                    if (response.html.length > 0) {

                        addUserItemsToList(response.html)
                        addUserItemsToList2(response.html2)

                        if (window.innerWidth < 768) {
                            closeFilter()
                        }


                        document.getElementById('containerFavorites').scrollIntoView({
                            block: "end",
                            behavior: "smooth"
                        });
                    } else {

                        if (document.getElementsByClassName('favoritesShowMore')[0]) {
                            let favoritesShowMore = document.getElementsByClassName('favoritesShowMore')
                            for (let i = 0; i < favoritesShowMore.length; i++) {
                                favoritesShowMore[i].classList.add('dn')

                            }
                        }
                        /* toastify(response.message) */
                        toastify(getPoTranslate('NO_RESULT_FOR_THIS_FILTER'))
                    }

                } else {
                    toastify(response.message)
                }


                favoriteAndUnFavoriteTalk()

                if (document.getElementById('submitFilter')) {
                    document.getElementById('submitFilter').disabled = true
                }

            },
            error: function (errorMessage) {
                Sentry.captureException(new GetFavoriteUsersError(errorMessage + ' || URL: ' + location.href));
            }
        });
    }
}

function addUserItemsToList2(responseHtml) {

    let addUser = document.createElement('div')
    addUser.innerHTML = responseHtml
    let htmlLayout = addUser.getElementsByClassName('pBottomItemsSearch')[0]

    document.getElementsByClassName('thxer')[0].append(htmlLayout)
    /*  document.getElementsByClassName('thxer')[0].innerHTML += responseHtml */
}

function showHideCalendarBigSmall() {
    if(document.getElementsByClassName('dateDDIner')[0]){
        document.getElementsByClassName('dateDDIner')[0].addEventListener('click', function () {
            if (this.dataset.opened === '1') {
                document.getElementsByClassName('sevDaysCaleWrap')[0].style.height = '0px'

                document.getElementsByClassName('container-calendarCont')[0].style.height = document.getElementsByClassName('container-calendar')[0].offsetHeight + 'px'


                document.getElementById('previous').style.cssText = 'display:block; z-index:100;'
                document.getElementById('next').style.cssText = 'display:block; z-index:100;'
                this.dataset.opened = 0
                this.getElementsByTagName('svg')[0].style.transform = 'scale(1,-1)'
            } else if (this.dataset.opened === '0') {

                document.getElementsByClassName('container-calendarCont')[0].style.height = '0px'
                document.getElementsByClassName('sevDaysCaleWrap')[0].style.height = document.getElementsByClassName('sevDaysCale')[0].offsetHeight + 'px'
                document.getElementById('previous').style.cssText = 'display:none;'
                document.getElementById('next').style.cssText = 'display:none;'
                this.dataset.opened = 1
                this.getElementsByTagName('svg')[0].style.transform = 'scale(1,1)'

            }
        })
    }
}
function addUserItemsToList(responseHtml) {

    let html = document.createElement('div')

    html.innerHTML = responseHtml
    let htmlGrid = html.getElementsByClassName('grid-x')

    let helper = htmlGrid

    for (let i = 0; i < helper.length; i++) {

        let favItem = document.createElement('div')
        favItem.className = 'fav-item favorites_holder'

        let cln = htmlGrid[i].cloneNode(true);

        favItem.insertBefore(cln, favItem.firstChild)
        document.getElementsByClassName('tabDeskFavUsers')[0].insertBefore(favItem, document.getElementsByClassName('tabDeskFavUsers')[0].getElementsByClassName('no-found-heading')[0])


    }

    if (helper.length > 0) {
        document.getElementsByClassName('buttCont')[0].classList.remove('dn')
    } else {
        if (document.getElementsByClassName('buttCont')[0].classList.contains('dn') === false) {
            document.getElementsByClassName('buttCont')[0].classList.add('dn')
        }

    }
}

function getFilterObj(filter, pointer, secPointer) {
    let anon
    let f
    let categoriesCheckboxes
    let subCategoriesCheckboxes

    if (pointer) {
        categoriesCheckboxes = getCategoriesCeheckboxes(pointer)
        subCategoriesCheckboxes = getSubCategoriesCheckboxes(pointer)
        anon = false
    } else {
        categoriesCheckboxes = getCategoriesCeheckboxes()
        subCategoriesCheckboxes = getSubCategoriesCheckboxes()

        for (let i = 0; i < filter['group1'].length; i++) {
            if (filter['group1'][i].checked) {
                if (filter['group1'][i].dataset.value === "0") {
                    anon = false
                } else if (filter['group1'][i].dataset.value === "1") {
                    anon = true
                } else if (filter['group1'][i].dataset.value === "2") {
                    anon = 2
                }
                break
            }
        }
    }


    let durationFilters = document.getElementById('durationFilters').getElementsByTagName('input')

    let arrayFiltersHelper = []

    for (let i = 0; i < durationFilters.length; i++) {
        if (durationFilters[i].checked) {
            arrayFiltersHelper.push(parseInt(durationFilters[i].parentElement.getElementsByTagName('label')[0].dataset.minutes))
        }
    }

    let availabilityFilters = document.getElementById('availabilityFilters').getElementsByTagName('input')

    let availabilityFiltersObject = {}
    for (let i = 0; i < availabilityFilters.length; i++) {

        availabilityFiltersObject[availabilityFilters[i].dataset.day] = availabilityFilters[i].checked
    }

    let priceFilters = document.getElementById('priceFilters').getElementsByTagName('input')
    let priceFiltersPriceFiltersObject = {}
    for (let i = 0; i < priceFilters.length; i++) {
        priceFiltersPriceFiltersObject[priceFilters[i].dataset.pricerange] = priceFilters[i].checked
    }

    let talkTypeFilters = document.getElementById('typeFilters').getElementsByTagName('input')

    let talkTypeFiltersObject = {}
    for (let i = 0; i < talkTypeFilters.length; i++) {
        talkTypeFiltersObject[talkTypeFilters[i].dataset.type] = talkTypeFilters[i].checked
    }
    if (secPointer) {
        f = {
            "categories": categoriesCheckboxes,
            "subCategories": subCategoriesCheckboxes,
            "type": {
                "private": true /* filter['filter[type][private][1]'].checked */,
                "group": false /* filter['filter[type][group][2]'].checked */
            },
            "duration": arrayFiltersHelper,
            "priceRange": priceFiltersPriceFiltersObject,
            "availability": availabilityFiltersObject,
            "talks": talkTypeFiltersObject,
            "order_by": window.orderByFilter[0],
            "order_by_type": window.orderByFilter[1]
        }
    } else {
        f = {
            "categories": categoriesCheckboxes,
            "subCategories": subCategoriesCheckboxes,
            "type": {
                "private": true /* filter['filter[type][private][1]'].checked */,
                "group": false /* filter['filter[type][group][2]'].checked */
            },
            "duration": arrayFiltersHelper,
            "priceRange": priceFiltersPriceFiltersObject,
            "availability": availabilityFiltersObject,
            "talks": talkTypeFiltersObject,
            "anonTalks": anon,
            "order_by": window.orderByFilter[0],
            "order_by_type": window.orderByFilter[1]
        }
    }


    return f
}

function showMoreTeacherTalksOne(element) {

    element.addEventListener('click', function () {


        let teacher = this.dataset.teacher
        if (this.getElementsByTagName('span')[0].classList.contains('showLess')) {
            let courseItems = this.parentElement.getElementsByClassName('course-item')

            for (let i = courseItems.length - 1; i >= 0; i--) {
                if (i > 1) {
                    courseItems[i].remove()
                }

            }

            this.getElementsByTagName('span')[0].textContent = 'Show More'
            this.getElementsByTagName('span')[0].classList.remove('showLess')


        } else {
            displayTalks(this, teacher, document.getElementById('filter-form').elements, 100)
            favoriteAndUnFavoriteTalk()
        }


    });

    function displayTalks(clickedElement, teacher, filter, limit, helper) {

        let f = getFilterObj(filter)

        jQuery.ajax({
            type: 'GET',
            url: '/talks',
            data: {
                'offset': 0,
                'limit': limit,
                'teacherId': teacher,
                'filter': JSON.stringify(f)
            },
            beforeSend: function () {
                // Handle the beforeSend event
                showLoading()
            },
            complete: function () {
                hideLoading()
            },
            success: function (response) {

                let html2 = stringToHTML(response.html, clickedElement.dataset.teacher)

                showMoreTalksSearch(clickedElement, html2, helper)

            },
            error: function (errorMessage) {
                Sentry.captureException(new GetTalksError3(errorMessage + ' || URL: ' + location.href));
            }
        });
    }
}



function showMoreTalksSearch(clickedElement, html, helper) {

    if (html) {

        clickedElement.parentElement.parentElement.parentElement.parentElement.insertBefore(html, clickedElement.parentElement.parentElement.parentElement)

        clickedElement.parentElement.parentElement.parentElement.parentElement.removeChild(clickedElement.parentElement.parentElement.parentElement)




        if (!helper) {

            let showLess = html.getElementsByClassName('show-more-teacher-talks')[0].getElementsByTagName('span')[0]

            showLess.classList.add('showLess')
            showLess.dataset.teacher = clickedElement.dataset.teacher
            clickedElement.parentElement.parentElement.parentElement.id = 'showLess' + clickedElement.dataset.teacher
            showLess.textContent = 'Show Less'

            showMoreTeacherTalksOne(showLess.parentElement)
            return

        }
        showMoreTeacherTalks()
    } else {

        toastify(getPoTranslate('NO_RESULT_FOR_THIS_FILTER'))
    }

}

Element.prototype.scrollIntoViewPromise = function (options) {

    // "this" refers to the current element (el.scrollIntoViewPromise(options): this = el)
    this.scrollIntoView(options);

    // I create a variable that can be read inside the returned object ({ then: f() }) to expose the current element
    let parent = this;

    // I return an object with just a property inside called then
    // then contains a function which accept a function as parameter that will be execute when the scroll ends
    return {
        then: function (x) {
            // Check out https://developer.mozilla.org/en-US/docs/Web/API/Intersection_Observer_API for more informations
            const intersectionObserver = new IntersectionObserver((entries) => {
                let [entry] = entries;

                // When the scroll ends (when our element is inside the screen)
                if (entry.isIntersecting) {

                    // Execute the function into then parameter and stop observing the html element
                    setTimeout(() => {
                        x();
                        intersectionObserver.unobserve(parent)
                    }, 100)
                }
            });

            // I start to observe the element where I scrolled
            intersectionObserver.observe(parent);
        }
    };
}



let stringToHTML = function (str) {
    let parser = new DOMParser()
    let doc = parser.parseFromString(str, 'text/html')

    return doc.body.getElementsByClassName('favorites_holder')[0]
}


function showMoreNotifications() {
    let total = document.getElementById("total_notifications_count").value
    let limiter = parseInt(document.getElementById('default_notifications_count_show_more').value)
    let limit = limiter

    jQuery(".showMoreNotification").on('click', function () {

        limit += limiter

        if (limit > total) {
            jQuery('.showMoreNotification').hide();
        }
        displayNotifications(limit)
    });

    function displayNotifications(limit) {
        jQuery.ajax({
            type: 'GET',
            url: '/settings/notifications',
            data: {
                'limit': limit,
            },
            beforeSend: function () {
                // Handle the beforeSend event
                showLoading()
            },
            complete: function () {
                hideLoading()
            },
            success: function (response) {

                if (response.success) {
                    jQuery('.notificatoin-wrapper').html(response.html);
                } else {
                    console.log(response)
                }
            },
            error: function (errorMessage) {
                Sentry.captureException(new GetSettingsNotificationsError(errorMessage + ' || URL: ' + location.href));
            }
        });
    }
}



class GetUserFollowError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetUserFollowError"
    }
}


class GetTalksError3 extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTalksError3"
    }
}
class GetTalksError4 extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTalksError4"
    }
}
class GetFavoriteUsersError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetFavoriteUsersError"
    }
}



class GetSettingsNotificationsError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetSettingsNotificationsError"
    }
}


/***/ }),

/***/ "./src/assets/js/scroll-to-top.js":
/*!****************************************!*\
  !*** ./src/assets/js/scroll-to-top.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "scrollToTop": () => (/* binding */ scrollToTop)
/* harmony export */ });
/* import {removeDots} from './dotNavigation.js' */

function scrollToTop() {

    document.body.addEventListener('scroll', function(e) {

        if (document.body.scrollTop > 400) {
            document.getElementById('scroller').style.opacity = 1
        } else {
            document.getElementById('scroller').style.opacity = 0
        }
    })

    document.getElementById('scroller').addEventListener('click',function(){


        document.getElementsByTagName('html')[0].style.scrollBehavior = 'smooth'
        setTimeout(function(){
            document.body.scrollTo(0, 0)
        })
        setTimeout(function(){
            document.getElementsByTagName('html')[0].style.scrollBehavior = 'unset'
        },310)
    })

}



/***/ }),

/***/ "./src/assets/js/talks.js":
/*!********************************!*\
  !*** ./src/assets/js/talks.js ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "deleteTalk": () => (/* binding */ deleteTalk),
/* harmony export */   "pauseTalks": () => (/* binding */ pauseTalks)
/* harmony export */ });
function pauseTalks() {
    if (document.getElementById('categorySubcategoryTalksTable')) {

        if (document.getElementById('categorySubcategoryTalksTable').getElementsByClassName('switcher')[0]) {

            let switches = document.getElementById('categorySubcategoryTalksTable').getElementsByClassName('switcher')
            for (let i = 0; i < switches.length; i++) {

                switches[i].getElementsByTagName('input')[0].addEventListener('change', function () {

                    showLoading()

                    if (this.checked === false) {

                        try {

                            pauseTalk(this.parentElement.parentElement.parentElement.parentElement.getElementsByClassName('dataTalkId')[0].dataset.talkId, this.parentElement.parentElement.parentElement.parentElement, !this.checked)
                        } catch (err) {
                            Sentry.captureException(new TryCatchPauseTalk(err));
                        }

                    } else if (this.checked === true) {

                        try {

                            unPauseTalk(this.parentElement.parentElement.parentElement.parentElement.getElementsByClassName('dataTalkId')[0].dataset.talkId, this.parentElement.parentElement.parentElement.parentElement, !this.checked)
                        } catch (err) {
                            Sentry.captureException(new TryCatchUnPauseTalk(err));
                        }

                    }

                })
            }
        }
    }

    function pauseTalk(talkId, parent = false, pauseStateBefore) {
        let url = '/frontend/api/pause-talk/' + talkId
        let params = {
            _token: document.querySelector("meta[name='csrf-token']").getAttribute("content")
        }
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.responseText)

                if (response.success == true) {
                    toastify(response.message)
                    if (document.body.className === 'logged_in') {
                        if (parent) {
                            parent.getElementsByClassName('shareTalk')[0].classList.add('pen')
                            parent.getElementsByClassName('shareTalk')[0].getElementsByTagName('div')[0].classList.add('dn')
                        }
                    }



                } else {
                    toastify(response.message)
                    if (document.body.className === 'logged_in') {

                        if (parent) {
                            parent.getElementsByClassName('switch-input')[0].checked = pauseStateBefore
                        }
                    }
                }
                hideLoading()
            }
        };

        xhr.open("POST", url, true)

        xhr.onerror = function () {
            Sentry.captureException(new pauseTalkError('status: ' + this.statusText + '|| response: ' +
                this.statusText + ' || url: ' + location.href))
        }
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhr.send(JSON.stringify(params))
    }

    function unPauseTalk(talkId, parent = false, pauseStateBefore) {
        let url = '/frontend/api/unpause-talk/' + talkId
        let params = {
            _token: document.querySelector("meta[name='csrf-token']").getAttribute("content")
        }
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.responseText)

                if (response.success == true) {

                    toastify(response.message)
                    if (document.body.className === 'logged_in') {
                        if (parent) {
                            parent.getElementsByClassName('shareTalk')[0].classList.remove('pen')
                            parent.getElementsByClassName('shareTalk')[0].getElementsByTagName('div')[0].classList.remove('dn')
                        }
                    }
                } else {
                    toastify(response.message)
                    if (document.body.className === 'logged_in') {

                        if (parent) {
                            parent.getElementsByClassName('switch-input')[0].checked = pauseStateBefore
                        }
                    }
                }
                hideLoading()
            }
        };

        xhr.open("POST", url, true)

        xhr.onerror = function () {
            Sentry.captureException(new unPauseTalkError('status: ' + this.statusText + '|| response: ' +
                this.statusText + ' || url: ' + location.href))
        }
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhr.send(JSON.stringify(params))
    }

    class TryCatchPauseTalk extends Error {
        constructor(message) {
            super(message)
            this.name = "TryCatchPauseTalk"
        }
    }

    class TryCatchUnPauseTalk extends Error {
        constructor(message) {
            super(message)
            this.name = "TryCatchUnPauseTalk"
        }
    }

    class pauseTalkError extends Error {
        constructor(message) {
            super(message)
            this.name = "pauseTalkError"
        }
    }

    class unPauseTalkError extends Error {
        constructor(message) {
            super(message)
            this.name = "unPauseTalkError"
        }
    }
}

function deleteTalk() {
    if (document.getElementById('acceptRemovingCourse')) {
        document.getElementById('acceptRemovingCourse').addEventListener('click', function () {
            showLoading()
            try {

                removeCourse()
            } catch (err) {
                hideLoading()
                Sentry.captureException(new TryCatchRemoveCourseFunction(err));
            }

            function removeCourse() {

                try {
                    let courseId = document.getElementById('acceptRemovingCourse').dataset.talkId

                    let cancelFutureBookingState = ''
                    if (document.getElementById('cancel_bookings').checked) {
                        cancelFutureBookingState = '?cancel_bookings=true'
                    }

                    let xhr = new XMLHttpRequest()

                    xhr.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {

                            let response = JSON.parse(this.responseText)

                            if (response.success == true) {

                                toastify(response.message)
                                location.reload()
                            } else {
                                toastify(response.message)
                                hideLoading()
                            }
                        }
                    }

                    xhr.open("DELETE", "/frontend/api/delete-talks/" + courseId + cancelFutureBookingState, true)

                    xhr.onerror = function () {
                        Sentry.captureException(new deleteTalkError('status: ' + this.statusText + '|| response: ' +
                            this.statusText + ' || url: ' + location.href))
                    }

                    xhr.setRequestHeader('X-CSRF-TOKEN', token);

                    xhr.send()

                } catch (err) {
                    Sentry.captureException(new TryDeleteTalkError(err))
                }
            }

            class deleteTalkError extends Error {
                constructor(message) {
                    super(message)
                    this.name = "deleteTalkError"
                }
            }

            class TryDeleteTalkError extends Error {
                constructor(message) {
                    super(message)
                    this.name = "TryDeleteTalkError"
                }
            }


        })
    }
}


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!******************************!*\
  !*** ./src/assets/js/app.js ***!
  \******************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _isComponentPresentChecker_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./isComponentPresentChecker.js */ "./src/assets/js/isComponentPresentChecker.js");
/* harmony import */ var _routeController_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./routeController.js */ "./src/assets/js/routeController.js");
/* harmony import */ var _mobileMenu_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./mobileMenu.js */ "./src/assets/js/mobileMenu.js");
/* harmony import */ var _closeSpanPopup_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./closeSpanPopup.js */ "./src/assets/js/closeSpanPopup.js");
/* harmony import */ var _profileMenu_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./profileMenu.js */ "./src/assets/js/profileMenu.js");
__webpack_require__(/*! ./lib/foundation-explicit-pieces */ "./src/assets/js/lib/foundation-explicit-pieces.js")

;








class CheckCache {

    constructor(name, version, apiUrl, lang = false) {

        this.name = name
        this.version = version
        this.apiUrl = apiUrl
        this.lang = lang

        this.check_local_storadge_for_data()
    }

    check_local_storadge_for_data() {
        if (localStorage.getItem(`app_${this.name}${this.lang ? '_' + this.lang : ''}`) === null) {
            this.get_data_from_json_file(this.apiUrl, this.name, this.version, this.lang)
        } else {
            if (localStorage.getItem(`app_${this.name}${this.lang ? '_' + this.lang : ''}_version`) !== document.getElementById(`app_${this.name}_version`).value) {

                this.get_data_from_json_file(this.apiUrl, this.name, this.version, this.lang)
            } else {
                this.get_data_from_cache(JSON.parse(localStorage.getItem(`app_${this.name}`)))
            }
        }


    }

    get_data_from_json_file(url, localStorageName, version, lang) {

        var xhttp = new XMLHttpRequest()

        xhttp.onreadystatechange = function () {


            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.response)

                localStorage.setItem(`app_${localStorageName}${lang ? '_' + lang : ''}`, JSON.stringify(response))
                localStorage.setItem(`app_${localStorageName}${lang ? '_' + lang : ''}_version`, version)

            }
        }

        xhttp.onerror = function () {
            Sentry.captureException(new GetDataError('status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href))
        }
        xhttp.open("GET", url, true)

        xhttp.setRequestHeader('Content-Type', 'application/json');
        xhttp.setRequestHeader('Accept', 'application/json')
        xhttp.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))
        xhttp.setRequestHeader('Application-Language', appLanguage);
        xhttp.setRequestHeader('X-CSRF-TOKEN', token)
        xhttp.setRequestHeader('Authorization', bearerToken)

        xhttp.send()
    }

    get_data_from_cache(obj) {
        /* console.log(obj, 'kari') */
    }
}



window.Toastify = __webpack_require__(/*! toastify-js */ "./node_modules/toastify-js/src/toastify.js")



window.addEventListener('load', function () {
    if (loggedIn) {
        if (document.body.className !== "video_conference") {
            loadScript('/frontend/assets/js/talk/callingScreen.js' + version, function () {

            })
        }


        try {



            const checkCacheLanguages = new CheckCache("languages", app_languages_version.value, envAppBackendUrl + "/languages", getCookie('activeLang'))
            const checkCacheTalkCategories = new CheckCache("talk_categories", app_talk_categories_version.value, "/category-subcategories", getCookie('activeLang'))

        } catch (error) {
            console.log('error', error)
        }
    }




    try { (0,_closeSpanPopup_js__WEBPACK_IMPORTED_MODULE_3__.showPopup)() } catch(e) { console.error('showPopup error:', e) }

    try { (0,_mobileMenu_js__WEBPACK_IMPORTED_MODULE_2__.mobileMenu)() } catch(e) { console.error('mobileMenu error:', e) }

    try { (0,_profileMenu_js__WEBPACK_IMPORTED_MODULE_4__.openProfileMenu)() } catch(e) { console.error('openProfileMenu error:', e) }

    try { (0,_isComponentPresentChecker_js__WEBPACK_IMPORTED_MODULE_0__.isPresent)() } catch(e) { console.error('isPresent error:', e) }

    try { (0,_routeController_js__WEBPACK_IMPORTED_MODULE_1__.routeController)() } catch(e) { console.error('routeController error:', e) }

    try {


        const checkCacheFlags = new CheckCache("flags", app_flags_version.value, "/frontend/assets/js/lang.json")


    } catch (error) {
        console.log('error', error)
    }




})


window.addEventListener("resize", _mobileMenu_js__WEBPACK_IMPORTED_MODULE_2__.mobileMenu.menuResponsiveCheck);

window.sendEvents = function (event, options = {}, call) {

    let data = options

    if (!data['user_id']) {
        data['user_id'] = call.user_id
    }

    data['event'] = event


    fetch(socketServerUrl + '/api/socket-event', {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-type": "application/json; charset=UTF-8",
            "Authorization": document.querySelector("meta[name='access_token']").content
        }
    }).then(response => response.json())
        .then(data => {
            toastify(data.message)
        })
        .catch(function (e) {
            console.error('sendEvents error:', e)
            if (typeof Sentry !== 'undefined') {
                Sentry.captureException(new SocketSendEventsError(e))
            }
        })

}


//unutrasnja
window.getCategoriesCeheckboxes = function (pointer) {

    if (pointer) {
        if (location.pathname.split('/')[location.pathname.split('/').length - 2] === 'talks') {
            if (getCategoryId(location.pathname.split('/')[location.pathname.split('/').length - 1])) {
                return (getCategoryId(location.pathname.split('/')[location.pathname.split('/').length - 1])).toString()
            } else {
                return null
            }
        } else if (location.pathname.split('/')[location.pathname.split('/').length - 3] === 'talks') {
            if (getCategoryId(location.pathname.split('/')[location.pathname.split('/').length - 2])) {
                return (getCategoryId(location.pathname.split('/')[location.pathname.split('/').length - 2])).toString()
            } else {
                return null
            }
        }



    } else {
        let checkedCategoryArray = []
        let categories = document.getElementById('categoriesHolder').getElementsByClassName('filter_category')

        for (let i = 0; i < categories.length; i++) {
            if (categories[i].checked) {
                checkedCategoryArray.push(categories[i].dataset.categoryId)
            }
        }

        return checkedCategoryArray
    }
}

function getCategoryId(categoryString) {

    let obj = JSON.parse(document.getElementById('talkCategoriesObj').textContent)
    for (let i = 0; i < obj.data.length; i++) {

        if (obj.data[i].value.trim() === categoryString.trim()) {
            return obj.data[i].id

        }
    }
}
//unutrasnja
window.getSubCategoriesCheckboxes = function (pointer) {
    if (pointer) {
        if (location.pathname.split('/')[location.pathname.split('/').length - 3] === 'talks') {
            if (getSubCategoryId(location.pathname.split('/')[location.pathname.split('/').length - 2], location.pathname.split('/')[location.pathname.split('/').length - 1])) {
                return (getSubCategoryId(location.pathname.split('/')[location.pathname.split('/').length - 2], location.pathname.split('/')[location.pathname.split('/').length - 1])).toString()
            } else {
                return false
            }
        } else {
            return false
        }


    } else {
        let checkedSubCategoryArray = []
        let subCategories = document.getElementById('categoriesHolder').getElementsByClassName('filter_subcategory')

        for (let i = 0; i < subCategories.length; i++) {

            if (subCategories[i].checked) {
                checkedSubCategoryArray.push(subCategories[i].dataset.subCategoryId)
            }
        }
        return checkedSubCategoryArray
    }

}

function getSubCategoryId(categoryString, subCategoryString) {
    let obj = JSON.parse(document.getElementById('talkCategoriesObj').textContent)
    for (let i = 0; i < obj.data.length; i++) {
        if (obj.data[i].value.trim() === categoryString.trim()) {
            for (let j = 0; j < obj.data[i].subcategories.length; j++) {
                if (obj.data[i].subcategories[j].value.trim() === subCategoryString.trim()) {
                    return obj.data[i].subcategories[j].id
                }
            }
        }
    }
}





//both
window.getDateWithMonthName = function (dateString) {
    let monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ]
    let realDateString = isSafari ? dateString.replaceAll('-', '/') : dateString
    let d = new Date(realDateString)

    return addZero(d.getDate()) + '. ' + monthNames[d.getMonth()] + ' ' + d.getFullYear()
}

//unutrasnja
window.setDrums = function (parentElementOfTimeSelect, t1h, t1m, t2h, t2m) {

    let from_hoursDrum = parentElementOfTimeSelect.getElementsByClassName('from_hours')[0]
    let from_minutesDrum = parentElementOfTimeSelect.getElementsByClassName('from_minutes')[0]
    let to_hoursDrum = parentElementOfTimeSelect.getElementsByClassName('to_hours')[0]
    let to_minutesDrum = parentElementOfTimeSelect.getElementsByClassName('to_minutes')[0]

    jQuery(from_hoursDrum).drum('setIndex', getIndex(t1h, from_hoursDrum))
    jQuery(from_minutesDrum).drum('setIndex', getIndex(t1m, from_minutesDrum))
    jQuery(to_hoursDrum).drum('setIndex', getIndex(t2h, to_hoursDrum))
    jQuery(to_minutesDrum).drum('setIndex', getIndex(t2m, to_minutesDrum))

    function getIndex(time, element) {
        let index = 0
        for (let i = 0; i < element.length; i++) {

            if (element[i].value === time) {

                return index
            } else {
                index++
            }
        }
    }

}
//unutrasnja
window.setAndClearDay = function (parentElementOfSevenDays, x) {
    parentElementOfSevenDays.getElementsByClassName('date-scheduler-wrap')[0].getElementsByClassName('active')[0].classList.remove('active')
    let days = parentElementOfSevenDays.getElementsByClassName('date-scheduler-wrap')[0].getElementsByTagName('div')
    for (let j = 0; j < days.length; j++) {
        if (days[j].dataset.index == x) {
            days[j].classList.add('active')
        }
    }
}

window.toastify = function (x) {
    Toastify({
        text: '<div class="fr toastContMain"><div class="lefter"><p class="fl cw m0 pr20 cc1"> ' + x + ' </p><h5 class="fl cw"></h5></div></div>',
        className: "notification",
        gravity: "top",
        position: "right",
        close: true,
        duration: 4000,
        stopOnFocus: true,
        escapeMarkup: false
    }).showToast();
}
//both

//both
window.chekToShowButton = function () {

    if (

        document.body.className === "logged_in" ||
        document.body.className === "jtc2_add_your_first_talk"
    ) {



        if (
            document.getElementById('talkInputP').classList.contains('ok') &&
            document.getElementById('categoryP').classList.contains('ok') &&
            document.getElementById('subCategoryP').classList.contains('ok')
        ) {
            document.getElementById('privateSubmit').classList.remove('dn')
        } else {
            document.getElementById('privateSubmit').classList.add('dn')
        }
    }
}
//both
window.getBookingTalkAvailability = function (date) {

    if (document.body.className === 'book_slot') {

        let teacherAvailabilityDatesTime = JSON.parse(document.getElementById('teacherAvailabilityDatesTime').value)

        document.getElementsByClassName('weekly-time')[0].innerHTML = ''

        for (let i = 0; i < Object.keys(teacherAvailabilityDatesTime).length; i++) {

            if (date === Object.keys(teacherAvailabilityDatesTime)[i]) {
                for (let i = 0; i < teacherAvailabilityDatesTime[date].length; i++) {

                    let time = teacherAvailabilityDatesTime[date][i].split(' ')

                    let button = document.createElement("button")

                    button.className = 'hollow btn'
                    button.textContent = time[1].slice(0, -3)
                    let bookingPaymentButton = document.getElementById('booking-payment')

                    button.addEventListener('click', function (e) {
                        e.stopPropagation()
                        bookingPaymentButton.style.right = '-50%'

                        if (document.getElementsByClassName('weekly-time')[0].getElementsByClassName('activee')[0]) {
                            document.getElementsByClassName('weekly-time')[0].getElementsByClassName('activee')[0].textContent =
                                document.getElementsByClassName('weekly-time')[0].getElementsByClassName('activee')[0].dataset.time

                            document.getElementsByClassName('weekly-time')[0].getElementsByClassName('activee')[0].classList.remove('activee')
                        }
                        this.classList.add('activee')

                        this.dataset.time = this.textContent

                        let isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent)

                        let dateHelper

                        isSafari ? dateHelper = new Date('2021/04/01 ' + this.textContent + ':00') : dateHelper = new Date('2021-04-01 ' + this.textContent + ':00')


                        let dateHelperToTime = addMinutes(dateHelper, document.getElementById('talkMinutes').textContent.match(/\d+/g).join(''))



                        this.textContent += ' - ' + addZero(dateHelperToTime.getHours()) + ':' + addZero(dateHelperToTime.getMinutes())
                        this.dataset.endTime = addZero(dateHelperToTime.getHours()) + ':' + addZero(dateHelperToTime.getMinutes())
                        this.innerHTML = '<span class="bookingCalendarFunnelButton mr8">' + document.getElementById('talkMinutes').textContent + ' | </span>' + this.textContent
                        let timeSlots = document.getElementsByClassName('weekly-time')[0].getElementsByTagName('button')

                        for (let i = 0; i < timeSlots.length; i++) {
                            timeSlots[i].style.width = "100%"
                            if (timeSlots[i].getElementsByClassName('bookingAnonCont')[0]) {
                                timeSlots[i].getElementsByClassName('bookingAnonCont')[0].style.transform = 'scale(0)'
                                timeSlots[i].getElementsByClassName('bookingAnonCont')[0].style.opacity = '0'
                            }
                            timeSlots[i].parentElement.style.height = 'auto'
                        }

                        this.style.width = '49%'


                        if (document.getElementById('bookingAnonCont')) {
                            this.parentElement.append(document.getElementById('bookingAnonCont'))
                            this.parentElement.style.height = 'auto'
                        } else {
                            this.parentElement.style.height = 'auto'
                        }

                        let that = this

                        setTimeout(function () {

                            that.parentElement.insertBefore(bookingPaymentButton, that.parentElement.getElementsByClassName('bookingAnonCont')[0])

                            setTimeout(function () {
                                bookingPaymentButton.style.right = "0%"
                            }, 10)

                            bookingPaymentButton.classList.add('activeButtoner')

                        }, 310)


                        setBookingTimeToLocalStoradge(this.dataset.time, addZero(dateHelperToTime.getHours()) + ':' + addZero(dateHelperToTime.getMinutes()))
                    })

                    let diver = document.createElement('div')
                    diver.className = "divItemTransition"
                    diver.append(button)

                    document.getElementsByClassName('weekly-time')[0].append(diver)

                }

                if (teacherAvailabilityDatesTime[date].length === 1) {

                    eventFire(document.getElementsByClassName('weekly-time')[0].getElementsByTagName('button')[0], 'click')
                }
            }
        }

    }
}
//both


window.setBookingTimeToLocalStoradge = function (startTime, endTime) {

    let obj

    if (window.localStorage.getItem('bookingObj') === null) {
        obj = {}

    } else {
        obj = JSON.parse(window.localStorage.getItem('bookingObj'))
    }

    obj.bookingTime = [startTime, endTime]

    window.localStorage.setItem('bookingObj', JSON.stringify(obj))

    setCookie("bookingObj", JSON.stringify(obj), 900, "/booking-payment")
    setCookie("bookingObjHelp", JSON.stringify(obj), 900, "/booking-summary")
    setCookie("bookingObj", JSON.stringify(obj), 900, "/booking-postpone")
}

window.removeProfilePhoto = function () {
    if (document.getElementById('removePhoto')) {
        document.getElementById('removePhoto').style.cursor = 'pointer'
        document.getElementById('removePhoto').addEventListener('click', function () {

            jQuery.ajax({
                type: 'POST',

                url: '/frontend/api/remove-user-image',
                data: {
                    "_token": document.getElementsByClassName('uploadPhotoTextHolder')[0].getElementsByTagName('input')[0].value
                },
                beforeSend: function () {
                    // Handle the beforeSend event
                    showLoading()
                },
                complete: function () {
                    hideLoading()
                },
                success: function (response) {

                    if (response.success) {
                        toastify(response.message)

                        document.getElementsByClassName('middleLine')[0].remove()
                        document.getElementById('removePhoto').remove()

                        if (document.getElementsByClassName('profPict')[0]) {
                            let profPict = document.getElementsByClassName('profPict')
                            for (let i = 0; i < profPict.length; i++) {
                                profPict[i].getElementsByTagName('img')[0].remove()

                                let noProfPict = document.createElement('div')
                                noProfPict.innerHTML = '<svg width="72" height="72" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg"> <mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="72" height="72"> <rect width="72" height="72" rx="36" fill="white"></rect> </mask> <g mask="url(#mask0)"> <rect width="72" height="72" rx="36" fill="white"></rect> <path opacity="0.15" fill-rule="evenodd" clip-rule="evenodd" d="M48 36C48 29.3726 42.6274 24 36 24C29.3726 24 24 29.3726 24 36C24 42.6274 29.3726 48 36 48C42.6274 48 48 42.6274 48 36ZM60 63C60 54.99 44.01 51 36 51C27.99 51 12 54.99 12 63V72H60V63Z" fill="#172B4D"></path> </g></svg>'

                                profPict[i].appendChild(noProfPict.getElementsByTagName('svg')[0])
                                noProfPict.remove()

                            }
                        }

                    } else {
                        toastify(response.message)
                        return response.message
                    }
                },
                error: function (errorMessage) {
                    Sentry.captureException(new RemoveUserImageError(errorMessage + ' url: ' + location.href));
                }
            });
        })
    }
}


//TODO
window.favoriteAndUnFavoriteTalk = function () {
    if (document.getElementsByClassName('favoriteHeart')[0]) {

        if (document.getElementsByClassName('favoriteHeart')[0].getElementsByTagName('svg')[0]) {

            let favoriteTalkButtons = document.getElementsByClassName('favoriteHeart')

            for (let i = 0; i < favoriteTalkButtons.length; i++) {

                if (typeof favoriteTalkButtons[i].dataset.eventAdded === 'undefined') {

                    favoriteTalkButtons[i].dataset.eventAdded = "1"

                    favoriteTalkButtons[i].getElementsByTagName('svg')[0].addEventListener('click', function (e) {
                        e.preventDefault()

                        let that = this
                        let index = i


                        if (that.parentElement.dataset.fallowing === '0') {
                            fallowTalk(that.parentElement.dataset.id, index)
                            that.parentElement.dataset.fallowing = '1'
                            if (document.body.className === 'favorites_talks' || document.body.className === 'talkCategorySubcategory') {

                                let thxer = document.body.className === 'talkCategorySubcategory' ?
                                    document.getElementsByClassName('innerResultsSearch')[0].getElementsByClassName('pBottomItemsSearch') :
                                    document.getElementsByClassName('thxer')[0].getElementsByClassName('pBottomItemsSearch')
                                for (let i = 0; i < thxer.length; i++) {
                                    if (thxer[i].dataset.talkId === document.getElementsByClassName('dataTalkId')[index].dataset.talkId) {

                                        document.body.className === 'talkCategorySubcategory' ?
                                            thxer[i].getElementsByClassName('favoriteHeart2')[0].dataset.fallowing = '1' :
                                            thxer[i].getElementsByClassName('favoriteHeart2')[0].dataset.fallowing = '1'
                                    }

                                }

                            }
                        } else {

                            unfallowTalk(that.parentElement.dataset.id, index)

                            that.parentElement.dataset.fallowing = '0'
                            if (document.body.className === 'favorites_talks' || document.body.className === 'talkCategorySubcategory') {


                                let thxer = document.body.className === 'talkCategorySubcategory' ?
                                    document.getElementsByClassName('innerResultsSearch')[0].getElementsByClassName('pBottomItemsSearch') :
                                    document.getElementsByClassName('thxer')[0].getElementsByClassName('pBottomItemsSearch')


                                for (let i = 0; i < thxer.length; i++) {
                                    if (thxer[i].dataset.talkId === document.getElementsByClassName('dataTalkId')[index].dataset.talkId) {

                                        document.body.className === 'talkCategorySubcategory' ?
                                            thxer[i].getElementsByClassName('favoriteHeart2')[0].dataset.fallowing = '0' :
                                            thxer[i].getElementsByClassName('favoriteHeart2')[0].dataset.fallowing = '0'
                                    }

                                }

                            }
                        }

                    })
                }
            }

            function fallowTalk(id, index) {

                jQuery.ajax({
                    type: 'POST',
                    headers: {
                        "Accept": 'application/json',

                    },
                    url: '/frontend/api/user-bookmarked-talks',
                    data: {
                        'talks_id': id,
                        '_token': token
                    },
                    beforeSend: function () {
                        // Handle the beforeSend event

                        showLoading()
                    },
                    complete: function () {
                        hideLoading()
                    },
                    success: function (response) {

                        if (response.success) {

                            let svgHeart = document.getElementsByClassName('favoriteHeart')[index].getElementsByTagName('svg')[0]

                            svgHeart.parentElement.style.transform = 'scale(0)'

                            setTimeout(function () {
                                svgHeart.innerHTML = '<path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>'
                                svgHeart.setAttribute('width', '1em')
                                svgHeart.setAttribute('height', '1em')
                                svgHeart.setAttribute('viewBox', '0 0 16 16')
                                svgHeart.setAttribute('fill', '#172b4d')
                                svgHeart.setAttribute('class', 'bi bi-heart-fill')
                                svgHeart.parentElement.style.transform = 'scale(1)'
                            }, 310)

                            if (document.body.className === 'favorites_talks' || document.body.className === 'talkCategorySubcategory') {
                                let svgHeart = document.getElementsByClassName('favoriteHeart2')[index].getElementsByTagName('svg')[0]

                                svgHeart.parentElement.style.transform = 'scale(0)'

                                setTimeout(function () {
                                    svgHeart.innerHTML = '<path d="M7 1.5L10.5 4L11.5 3.5L12.5 2.5L14 1.5H17.5C18.3 1.5 19.1667 2.83333 19.5 3.5C19.8333 4.66667 20.5 7.1 20.5 7.5C20.5 7.9 18.1667 10.6667 17 12C15 13.8333 10.9 17.6 10.5 18C10.1 18.4 6 13.8333 4 11.5L1.5 9L1 6.5L2 3.5L4.5 1.5H7Z" fill="#DF1818" stroke="black"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.44583 2.17107C4.06979 2.17107 2.16667 4.07378 2.16667 6.39259C2.16667 7.522 2.61498 8.54793 3.35127 9.30824L10.8332 16.9082L18.1906 9.43199L18.2021 9.42092C19.0056 8.65095 19.5 7.57855 19.5 6.39259C19.5 4.07378 17.5969 2.17107 15.2208 2.17107C14.8518 2.17107 14.4317 2.31793 13.9572 2.64139C13.484 2.96407 13.0199 3.41997 12.5862 3.92814C11.67 5.00131 9.99667 5.00131 9.0805 3.92814C8.64672 3.41997 8.18269 2.96407 7.70939 2.64139C7.23499 2.31793 6.81484 2.17107 6.44583 2.17107ZM0 6.39259C0 2.84939 2.89862 0 6.44583 0C7.39449 0 8.23651 0.374791 8.92829 0.846413C9.62108 1.3188 10.2272 1.93141 10.7271 2.5169C10.749 2.54276 10.784 2.56195 10.8333 2.56195C10.8826 2.56195 10.9176 2.54276 10.9396 2.5169C11.4395 1.93141 12.0456 1.3188 12.7384 0.846413C13.4302 0.374791 14.2722 0 15.2208 0C18.768 0 21.6667 2.84939 21.6667 6.39259C21.6667 8.19351 20.9145 9.81964 19.7116 10.9784L10.8334 20L1.80025 10.8243C0.687819 9.67754 0 8.11459 0 6.39259Z" fill="#DF1818"></path>'
                                    svgHeart.setAttribute('width', '22')
                                    svgHeart.setAttribute('height', '20')
                                    svgHeart.setAttribute('viewBox', '0 0 22 20')
                                    svgHeart.setAttribute('fill', 'none')
                                    svgHeart.parentElement.style.transform = 'scale(1)'
                                }, 310)

                            }
                        } else {
                            toastify(response.message)
                        }
                    },
                    error: function (errorMessage) {
                        Sentry.captureException(new FallowTalkError(errorMessage + ' url: ' + location.href));
                    }
                });
            }

            function unfallowTalk(id, index) {

                let token = document.querySelector('meta[name="csrf-token"]').content
                jQuery.ajax({
                    type: 'POST',
                    headers: {
                        "Accept": 'application/json',
                    },
                    url: '/frontend/api/unfollow-single-talk',
                    data: {
                        'talks_id': id,
                        '_token': token
                    },
                    beforeSend: function () {
                        // Handle the beforeSend event

                        showLoading()
                    },
                    complete: function () {
                        hideLoading()
                    },
                    success: function (response) {

                        if (response.success) {

                            let svgHeart = document.getElementsByClassName('favoriteHeart')[index].getElementsByTagName('svg')[0]

                            svgHeart.parentElement.style.transform = 'scale(0)'

                            setTimeout(function () {
                                svgHeart.innerHTML = '<path fill-rule="evenodd" clip-rule="evenodd" d="M4.5815 1.51975C2.89268 1.51975 1.54 2.85165 1.54 4.47482C1.54 5.2654 1.85865 5.98355 2.38198 6.51577L7.69992 11.8357L12.9293 6.6024L12.9375 6.59465C13.5086 6.05567 13.86 5.30499 13.86 4.47482C13.86 2.85165 12.5073 1.51975 10.8185 1.51975C10.5562 1.51975 10.2576 1.62255 9.92037 1.84897C9.58404 2.07485 9.25417 2.39398 8.94586 2.7497C8.29467 3.50092 7.10533 3.50092 6.45414 2.7497C6.14582 2.39398 5.816 2.07485 5.4796 1.84897C5.14241 1.62255 4.84378 1.51975 4.5815 1.51975ZM0 4.47482C0 1.99457 2.06025 0 4.5815 0C5.25577 0 5.85426 0.262354 6.34595 0.592489C6.83837 0.923164 7.26919 1.35198 7.62446 1.76183C7.64009 1.77993 7.66496 1.79336 7.7 1.79336C7.73503 1.79336 7.75991 1.77993 7.77554 1.76183C8.13081 1.35198 8.56163 0.923164 9.05404 0.592489C9.54577 0.262354 10.1442 0 10.8185 0C13.3397 0 15.4 1.99457 15.4 4.47482C15.4 5.73546 14.8654 6.87375 14.0104 7.68491L7.70008 14L1.27956 7.57701C0.488881 6.77428 0 5.68021 0 4.47482Z" fill="#172B4D"></path>'
                                svgHeart.setAttribute('width', '16')
                                svgHeart.setAttribute('height', '14')
                                svgHeart.setAttribute('viewBox', '0 0 16 16')
                                svgHeart.setAttribute('fill', 'none')
                                svgHeart.setAttribute('class', '')
                                svgHeart.parentElement.style.transform = 'scale(1)'
                            }, 310)

                            if (document.body.className === 'favorites_talks' || document.body.className === 'talkCategorySubcategory') {
                                let svgHeart = document.getElementsByClassName('favoriteHeart2')[index].getElementsByTagName('svg')[0]

                                svgHeart.parentElement.style.transform = 'scale(0)'

                                setTimeout(function () {
                                    svgHeart.innerHTML = '<path d="M7 1.5L10.5 4L11.5 3.5L12.5 2.5L14 1.5H17.5C18.3 1.5 19.1667 2.83333 19.5 3.5C19.8333 4.66667 20.5 7.1 20.5 7.5C20.5 7.9 18.1667 10.6667 17 12C15 13.8333 10.9 17.6 10.5 18C10.1 18.4 6 13.8333 4 11.5L1.5 9L1 6.5L2 3.5L4.5 1.5H7Z" fill="#F4F9FF" stroke="black"/><path fill-rule="evenodd" clip-rule="evenodd" d="M6.44583 2.17107C4.06979 2.17107 2.16667 4.07378 2.16667 6.39259C2.16667 7.522 2.61498 8.54793 3.35127 9.30824L10.8332 16.9082L18.1906 9.43199L18.2021 9.42092C19.0056 8.65095 19.5 7.57855 19.5 6.39259C19.5 4.07378 17.5969 2.17107 15.2208 2.17107C14.8518 2.17107 14.4317 2.31793 13.9572 2.64139C13.484 2.96407 13.0199 3.41997 12.5862 3.92814C11.67 5.00131 9.99667 5.00131 9.0805 3.92814C8.64672 3.41997 8.18269 2.96407 7.70939 2.64139C7.23499 2.31793 6.81484 2.17107 6.44583 2.17107ZM0 6.39259C0 2.84939 2.89862 0 6.44583 0C7.39449 0 8.23651 0.374791 8.92829 0.846413C9.62108 1.3188 10.2272 1.93141 10.7271 2.5169C10.749 2.54276 10.784 2.56195 10.8333 2.56195C10.8826 2.56195 10.9176 2.54276 10.9396 2.5169C11.4395 1.93141 12.0456 1.3188 12.7384 0.846413C13.4302 0.374791 14.2722 0 15.2208 0C18.768 0 21.6667 2.84939 21.6667 6.39259C21.6667 8.19351 20.9145 9.81964 19.7116 10.9784L10.8334 20L1.80025 10.8243C0.687819 9.67754 0 8.11459 0 6.39259Z" fill="#172B4D"/>'
                                    svgHeart.setAttribute('width', '22')
                                    svgHeart.setAttribute('height', '20')
                                    svgHeart.setAttribute('viewBox', '0 0 22 20')
                                    svgHeart.setAttribute('fill', 'none')
                                    svgHeart.setAttribute('class', '')
                                    svgHeart.parentElement.style.transform = 'scale(1)'
                                }, 310)


                            }
                        } else {
                            toastify(response.message)
                        }
                    },
                    error: function (errorMessage) {
                        Sentry.captureException(new UnfallowTalkError(errorMessage + ' url: ' + location.href));
                    }
                });
            }

        }
        if (document.getElementsByClassName('favoriteHeart2')[0]) {
            if (document.getElementsByClassName('favoriteHeart2')[0].getElementsByTagName('svg')[0]) {

                let favoriteTalkButtons2 = document.getElementsByClassName('favoriteHeart2')

                for (let i = 0; i < favoriteTalkButtons2.length; i++) {

                    if (typeof favoriteTalkButtons2[i].dataset.eventAdded === 'undefined') {

                        favoriteTalkButtons2[i].dataset.eventAdded = "1"

                        favoriteTalkButtons2[i].getElementsByTagName('svg')[0].addEventListener('click', function (e) {
                            e.preventDefault()

                            let that = this
                            let index = i
                            jQuery.ajax({
                                type: 'GET',
                                url: '/my-tokens',
                                success: function (res) {
                                    if (res.length > 0) {


                                        if (that.parentElement.dataset.fallowing === '0') {
                                            fallowTalk2(res, document.getElementsByClassName('dataTalkId')[index].dataset.talkId, index)
                                            that.parentElement.dataset.fallowing = '1'

                                            if (document.body.className === 'favorites_talks' || document.body.className === 'talkCategorySubcategory') {

                                                let thxer = document.body.className === 'talkCategorySubcategory' ?
                                                    document.getElementsByClassName('searcTalksContainer')[0].getElementsByClassName('course-item') :
                                                    document.getElementsByClassName('favorites_holder')[0].getElementsByClassName('course-item')

                                                for (let i = 0; i < thxer.length; i++) {


                                                    if (thxer[i].getElementsByTagName('a')[0].dataset.talkId === document.getElementsByClassName('dataTalkId')[index].dataset.talkId) {

                                                        document.body.className === 'talkCategorySubcategory' ?
                                                            thxer[i].getElementsByClassName('favoriteHeart')[0].dataset.fallowing = '1' :
                                                            thxer[i].getElementsByClassName('favoriteHeart')[0].dataset.fallowing = '1'
                                                    }

                                                }

                                            }

                                        } else {

                                            unfallowTalk2(res, document.getElementsByClassName('dataTalkId')[index].dataset.talkId, index)
                                            that.parentElement.dataset.fallowing = '0'


                                            if (document.body.className === 'favorites_talks' || document.body.className === 'talkCategorySubcategory') {

                                                let thxer = document.body.className === 'talkCategorySubcategory' ?
                                                    document.getElementsByClassName('searcTalksContainer')[0].getElementsByClassName('course-item') :
                                                    document.getElementsByClassName('favorites_holder')[0].getElementsByClassName('course-item')
                                                for (let i = 0; i < thxer.length; i++) {
                                                    if (thxer[i].getElementsByTagName('a')[0].dataset.talkId === document.getElementsByClassName('dataTalkId')[index].dataset.talkId) {

                                                        document.body.className === 'talkCategorySubcategory' ?
                                                            thxer[i].getElementsByClassName('favoriteHeart')[0].dataset.fallowing = '0' :
                                                            thxer[i].getElementsByClassName('favoriteHeart')[0].dataset.fallowing = '0'
                                                    }

                                                }

                                            }

                                        }


                                    }
                                },
                                error: function (errorMessage) {
                                    Sentry.captureException(new GetTokenForFallowUnfallowError(errorMessage + ' url: ' + location.href));
                                }
                            });
                        })
                    }
                }


                function fallowTalk2(res, id, index) {

                    jQuery.ajax({
                        type: 'POST',
                        headers: {
                            "Accept": 'application/json',
                            "Authorization": res,
                        },
                        url: envAppBackendUrl + '/user-bookmarked-talks',
                        data: {
                            'talks_id': id
                        },
                        beforeSend: function () {
                            // Handle the beforeSend event

                            showLoading()
                        },
                        complete: function () {
                            hideLoading()
                        },
                        success: function (response) {

                            if (response.success) {

                                let svgHeart = document.getElementsByClassName('favoriteHeart2')[index].getElementsByTagName('svg')[0]

                                /*       let svgHeart =  document.body.className === 'talkCategorySubcategory' ?
                                      document.getElementsByClassName('searcTalksContainer')[0].getElementsByClassName('course-item')
                                      :
                                      document.getElementsByClassName('favorites_holder')[0].getElementsByClassName('course-item') */
                                svgHeart.parentElement.style.transform = 'scale(0)'

                                setTimeout(function () {
                                    svgHeart.innerHTML = '<path d="M7 1.5L10.5 4L11.5 3.5L12.5 2.5L14 1.5H17.5C18.3 1.5 19.1667 2.83333 19.5 3.5C19.8333 4.66667 20.5 7.1 20.5 7.5C20.5 7.9 18.1667 10.6667 17 12C15 13.8333 10.9 17.6 10.5 18C10.1 18.4 6 13.8333 4 11.5L1.5 9L1 6.5L2 3.5L4.5 1.5H7Z" fill="#DF1818" stroke="black"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.44583 2.17107C4.06979 2.17107 2.16667 4.07378 2.16667 6.39259C2.16667 7.522 2.61498 8.54793 3.35127 9.30824L10.8332 16.9082L18.1906 9.43199L18.2021 9.42092C19.0056 8.65095 19.5 7.57855 19.5 6.39259C19.5 4.07378 17.5969 2.17107 15.2208 2.17107C14.8518 2.17107 14.4317 2.31793 13.9572 2.64139C13.484 2.96407 13.0199 3.41997 12.5862 3.92814C11.67 5.00131 9.99667 5.00131 9.0805 3.92814C8.64672 3.41997 8.18269 2.96407 7.70939 2.64139C7.23499 2.31793 6.81484 2.17107 6.44583 2.17107ZM0 6.39259C0 2.84939 2.89862 0 6.44583 0C7.39449 0 8.23651 0.374791 8.92829 0.846413C9.62108 1.3188 10.2272 1.93141 10.7271 2.5169C10.749 2.54276 10.784 2.56195 10.8333 2.56195C10.8826 2.56195 10.9176 2.54276 10.9396 2.5169C11.4395 1.93141 12.0456 1.3188 12.7384 0.846413C13.4302 0.374791 14.2722 0 15.2208 0C18.768 0 21.6667 2.84939 21.6667 6.39259C21.6667 8.19351 20.9145 9.81964 19.7116 10.9784L10.8334 20L1.80025 10.8243C0.687819 9.67754 0 8.11459 0 6.39259Z" fill="#DF1818"></path>'
                                    svgHeart.setAttribute('width', '22')
                                    svgHeart.setAttribute('height', '20')
                                    svgHeart.setAttribute('viewBox', '0 0 22 20')
                                    svgHeart.setAttribute('fill', 'none')
                                    svgHeart.parentElement.style.transform = 'scale(1)'
                                }, 310)


                                if (document.body.className === 'favorites_talks' || document.body.className === 'talkCategorySubcategory') {
                                    let svgHeart = document.getElementsByClassName('favoriteHeart')[index].getElementsByTagName('svg')[0]

                                    svgHeart.parentElement.style.transform = 'scale(0)'

                                    setTimeout(function () {
                                        svgHeart.innerHTML = '<path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"></path>'
                                        svgHeart.setAttribute('width', '22')
                                        svgHeart.setAttribute('height', '20')
                                        svgHeart.setAttribute('viewBox', '0 0 22 20')
                                        svgHeart.setAttribute('fill', '#172B4D')
                                        svgHeart.parentElement.style.transform = 'scale(1)'
                                    }, 310)

                                }

                            } else {
                                toastify(response.message)
                            }
                        },
                        error: function (errorMessage) {
                            Sentry.captureException(new FallowTalkError(errorMessage + ' url: ' + location.href));
                        }
                    });
                }

                function unfallowTalk2(res, id, index) {
                    jQuery.ajax({
                        type: 'POST',
                        headers: {
                            "Accept": 'application/json',
                            "Authorization": res,
                        },
                        url: envAppBackendUrl + '/unfollow-single-talk',
                        data: {
                            'talks_id': id
                        },
                        beforeSend: function () {
                            // Handle the beforeSend event

                            showLoading()
                        },
                        complete: function () {
                            hideLoading()
                        },
                        success: function (response) {

                            if (response.success) {

                                let svgHeart = document.getElementsByClassName('favoriteHeart2')[index].getElementsByTagName('svg')[0]

                                svgHeart.parentElement.style.transform = 'scale(0)'

                                setTimeout(function () {
                                    svgHeart.innerHTML = '<path d="M7 1.5L10.5 4L11.5 3.5L12.5 2.5L14 1.5H17.5C18.3 1.5 19.1667 2.83333 19.5 3.5C19.8333 4.66667 20.5 7.1 20.5 7.5C20.5 7.9 18.1667 10.6667 17 12C15 13.8333 10.9 17.6 10.5 18C10.1 18.4 6 13.8333 4 11.5L1.5 9L1 6.5L2 3.5L4.5 1.5H7Z" fill="#F4F9FF" stroke="black"/><path fill-rule="evenodd" clip-rule="evenodd" d="M6.44583 2.17107C4.06979 2.17107 2.16667 4.07378 2.16667 6.39259C2.16667 7.522 2.61498 8.54793 3.35127 9.30824L10.8332 16.9082L18.1906 9.43199L18.2021 9.42092C19.0056 8.65095 19.5 7.57855 19.5 6.39259C19.5 4.07378 17.5969 2.17107 15.2208 2.17107C14.8518 2.17107 14.4317 2.31793 13.9572 2.64139C13.484 2.96407 13.0199 3.41997 12.5862 3.92814C11.67 5.00131 9.99667 5.00131 9.0805 3.92814C8.64672 3.41997 8.18269 2.96407 7.70939 2.64139C7.23499 2.31793 6.81484 2.17107 6.44583 2.17107ZM0 6.39259C0 2.84939 2.89862 0 6.44583 0C7.39449 0 8.23651 0.374791 8.92829 0.846413C9.62108 1.3188 10.2272 1.93141 10.7271 2.5169C10.749 2.54276 10.784 2.56195 10.8333 2.56195C10.8826 2.56195 10.9176 2.54276 10.9396 2.5169C11.4395 1.93141 12.0456 1.3188 12.7384 0.846413C13.4302 0.374791 14.2722 0 15.2208 0C18.768 0 21.6667 2.84939 21.6667 6.39259C21.6667 8.19351 20.9145 9.81964 19.7116 10.9784L10.8334 20L1.80025 10.8243C0.687819 9.67754 0 8.11459 0 6.39259Z" fill="#172B4D"/>'
                                    svgHeart.setAttribute('width', '22')
                                    svgHeart.setAttribute('height', '20')
                                    svgHeart.setAttribute('viewBox', '0 0 22 20')
                                    svgHeart.setAttribute('fill', 'none')
                                    svgHeart.setAttribute('class', '')
                                    svgHeart.parentElement.style.transform = 'scale(1)'
                                }, 310)

                                if (document.body.className === 'favorites_talks' || document.body.className === 'talkCategorySubcategory') {
                                    let svgHeart = document.getElementsByClassName('favoriteHeart')[index].getElementsByTagName('svg')[0]

                                    svgHeart.parentElement.style.transform = 'scale(0)'

                                    setTimeout(function () {
                                        svgHeart.innerHTML = '<path fill-rule="evenodd" clip-rule="evenodd" d="M4.5815 1.51975C2.89268 1.51975 1.54 2.85165 1.54 4.47482C1.54 5.2654 1.85865 5.98355 2.38198 6.51577L7.69992 11.8357L12.9293 6.6024L12.9375 6.59465C13.5086 6.05567 13.86 5.30499 13.86 4.47482C13.86 2.85165 12.5073 1.51975 10.8185 1.51975C10.5562 1.51975 10.2576 1.62255 9.92037 1.84897C9.58404 2.07485 9.25417 2.39398 8.94586 2.7497C8.29467 3.50092 7.10533 3.50092 6.45414 2.7497C6.14582 2.39398 5.816 2.07485 5.4796 1.84897C5.14241 1.62255 4.84378 1.51975 4.5815 1.51975ZM0 4.47482C0 1.99457 2.06025 0 4.5815 0C5.25577 0 5.85426 0.262354 6.34595 0.592489C6.83837 0.923164 7.26919 1.35198 7.62446 1.76183C7.64009 1.77993 7.66496 1.79336 7.7 1.79336C7.73503 1.79336 7.75991 1.77993 7.77554 1.76183C8.13081 1.35198 8.56163 0.923164 9.05404 0.592489C9.54577 0.262354 10.1442 0 10.8185 0C13.3397 0 15.4 1.99457 15.4 4.47482C15.4 5.73546 14.8654 6.87375 14.0104 7.68491L7.70008 14L1.27956 7.57701C0.488881 6.77428 0 5.68021 0 4.47482Z" fill="#172B4D"></path>'
                                        svgHeart.setAttribute('width', '22')
                                        svgHeart.setAttribute('height', '20')
                                        svgHeart.setAttribute('viewBox', '0 0 22 20')
                                        svgHeart.setAttribute('fill', 'none')
                                        svgHeart.setAttribute('class', '')
                                        svgHeart.parentElement.style.transform = 'scale(1)'
                                    }, 310)


                                }
                            } else {
                                toastify(response.message)
                            }
                        },
                        error: function (errorMessage) {
                            Sentry.captureException(new UnfallowTalkError(errorMessage + ' url: ' + location.href));
                        }
                    });
                }

            }
        }

    }
}


window.getLanguageId = function () {

    switch (appLanguage) {
        case 'en':
            return 38;

        case 'hr':
            return 60;

        case 'de':
            return 33;

        case 'pl':
            return 127;

    }
}

window.getCategoryLanguageId = function () {

    switch (appLanguage) {
        case 'en':
            return 3;

        case 'hr':
            return 2;

        case 'de':
            return 1;

        case 'pl':
            return 17;

    }
}

window.clearGroupForm = function (form) {
    let ele = form.elements

    //clear category
    let optionsParticipantsG = ele['participantsG'].options

    for (let i = 0; i < optionsParticipantsG.length; i++) {
        if(optionsParticipantsG[i].value === '5'){
            ele['participantsG'].selectedIndex = i
        }

    }

    ele['participantsG'].classList.add('ok')


    //clear talk name

    ele['nameG'].value = ''
    ele['nameG'].classList.remove('ok')
    ele['nameG'].classList.remove('error')
    ele['nameG'].parentElement.getElementsByClassName('default-warn')[0].classList.remove('active')
    ele['nameG'].parentElement.getElementsByClassName('verified-svg')[0].style.right = '-55px'
    ele['nameG'].parentElement.getElementsByClassName('input-label')[0].style.color = ''
    ele['nameG'].parentElement.getElementsByClassName('clear-button')[0].style.right = '-55px'

    //clear category

    ele['categoryG'].selectedIndex = -1
    ele['categoryG'].classList.remove('ok')
    ele['categoryG'].classList.remove('error')
    ele['categoryG'].parentElement.getElementsByClassName('default-warn')[0].classList.remove('active')
    ele['categoryG'].parentElement.getElementsByClassName('verified-svg')[0].style.right = '-55px'
    ele['categoryG'].parentElement.getElementsByClassName('input-label')[0].style.color = ''
    ele['categoryG'].parentElement.getElementsByClassName('clear-button')[0].style.right = '-55px'


    //clear subCategory
    ele['subCategoryG'].parentElement.parentElement.classList.add('dn')
    ele['subCategoryG'].selectedIndex = -1
    ele['subCategoryG'].classList.remove('ok')
    ele['subCategoryG'].classList.remove('error')
    ele['subCategoryG'].parentElement.getElementsByClassName('default-warn')[0].classList.remove('active')
    ele['subCategoryG'].parentElement.getElementsByClassName('verified-svg')[0].style.right = '-55px'
    ele['subCategoryG'].parentElement.getElementsByClassName('input-label')[0].style.color = ''
    ele['subCategoryG'].parentElement.getElementsByClassName('clear-button')[0].style.right = '-55px'

    //reset description

    ele['descriptionG'].value = ''
    ele['descriptionG'].classList.remove('ok')
    ele['descriptionG'].classList.remove('error')
    ele['descriptionG'].parentElement.getElementsByClassName('default-warn')[0].classList.remove('active')
    ele['descriptionG'].parentElement.getElementsByClassName('verified-svg')[0].style.right = '-55px'
    ele['descriptionG'].parentElement.getElementsByClassName('input-label')[0].style.color = ''
    ele['descriptionG'].parentElement.getElementsByClassName('clear-button')[0].style.right = '-55px'


    //reset language


    //reset price
    ele['priceG'].value = ''
    ele['priceG'].classList.remove('ok')
    ele['priceG'].classList.remove('error')
    ele['priceG'].parentElement.getElementsByClassName('default-warn')[0].classList.remove('active')
    ele['priceG'].parentElement.getElementsByClassName('verified-svg')[0].style.right = '-55px'
    ele['priceG'].parentElement.getElementsByClassName('input-label')[0].style.color = ''
    ele['priceG'].parentElement.getElementsByClassName('clear-button')[0].style.right = '-55px'

    //reset anon and video/audio switches
    ele['allowVideoTalkG'].checked = true
    ele['allowAnonimousTalkG'].checked = false

    //reset days
    if (form.getElementsByClassName('date-scheduler-wrap')[0].getElementsByClassName('active')[0]) {
        form.getElementsByClassName('date-scheduler-wrap')[0].getElementsByClassName('active')[0].classList.remove('active')
        form.getElementsByClassName('date-scheduler-wrap')[0].getElementsByTagName('div')[0].classList.add('active')
    }

    //reset time selectors
    setDrums(form, '10', '00', '11', '00')

    //reset talk interaction type
    document.getElementById('talkInteractionTypeG').selectedIndex = -1

    //reset add to group talk button
    document.getElementById('groupSubmit').parentElement.parentElement.classList.add('dn')
}


window.clearForm = function (form) {
    let ele = form.elements
    if (form.getElementsByClassName('deleteTalkButtoner')[0]) {
        form.getElementsByClassName('deleteTalkButtoner')[0].classList.add('dn')
    }
    for (let i = 0; i < ele.length; i++) {

        ele[i].value = ''


        if (ele[i].id != "languageP") {
            ele[i].classList.remove('ok')
        }

        ele[i].classList.remove('error')

        if (ele[i].id === "exampleSwitch8" || ele[i].id === "exampleSwitch4") {
            ele[i].checked = true
        } else {
            ele[i].checked = false
        }

    }

    let defaultWarn = form.getElementsByClassName('default-warn')
    for (let i = 0; i < defaultWarn.length; i++) {
        defaultWarn[i].classList.remove('active')
    }

    let inputLabel = form.getElementsByClassName('input-label')
    for (let i = 0; i < inputLabel.length; i++) {
        inputLabel[i].style.color = ''
    }

    form.getElementsByTagName('textarea')[0].style.height = '120px'

    if (document.body.className === "logged_in") {

        if (form.id === "private-talk-form") {
            if (document.body.className !== "logged_in") {
                document.getElementById('privateSubmit').textContent = getPoTranslate('ADD_PRIVATE_TALK')
                document.getElementsByClassName('mainTitlePrivate')[0].textContent = getPoTranslate('ADD_PRIVATE_TALK')
            }

            document.getElementById('mobilePrivateTalkTitle').textContent = getPoTranslate('ADD_PRIVATE_TALK')
            document.getElementById('addPrivateTalk').getElementsByClassName('pageTitlePoperAva')[0].textContent = getPoTranslate('ADD_PRIVATE_TALK')
            document.getElementById('addPrivateTalk').getElementsByClassName('saveButtonPrivateTalk')[0].textContent = getPoTranslate('ADD_PRIVATE_TALK')




        }

    }



    if (form.id === 'private-talk-form') {
        selectOptionByValue(document.getElementById('durationP'), "45")
        selectOptionByValue(document.getElementById('languageP'), "33")

        document.getElementById('talkInputP').parentElement.style.height = '84px'
        document.getElementById('talkInputP').parentElement.style.marginTop = '8px'
        //document.getElementById('talkInputP').classList.add('ok')
        document.getElementById('talkInputP').style.background = 'white'
        document.getElementById('talkInputP').parentElement.getElementsByClassName('count-label')[0].style.color = 'white'
        document.getElementById('talkInputP').parentElement.getElementsByClassName('clear-button')[0].style.opacity = 0
        document.getElementById('talkInputP').parentElement.getElementsByClassName('verified-svg')[0].style.opacity = 0
        document.getElementById('private-talk-form').getElementsByTagName('textarea')[0].style.height = '120px'

        document.getElementById('talkInputP').focus()


    }

}




window.selectOptionByValue = function (selectOptionElement, valueForSelect) {
    if (document.body.className !== "profile" && document.body.className !== "settings_reviews") {
        for (var i = 0; i < selectOptionElement.options.length; i++) {
            if (selectOptionElement.options[i].value == valueForSelect) {
                selectOptionElement.selectedIndex = i;
                selectOptionElement.classList.add('ok')
                break;
            }
        }
    }
}

window.showTimePupup = function () {

    document.getElementById('submit-btn').textContent = getPoTranslate('ADD_TIME_SLOT')
    if (document.getElementById('time-slot-popup').getElementsByClassName('add-time-title')[0]) {
        document.getElementById('time-slot-popup').getElementsByClassName('add-time-title')[0].textContent = getPoTranslate('ADD_TIME_SLOT')

    }

    document.getElementById('submit-btn').dataset.timeSlotId = ''
    document.getElementsByClassName('endTime')[0].style.border = '1px solid transparent'
    openPopup('time-slot-popup')
}

//TODO
window.allClickableTimeSlot = function (addtionalElementsToAddEvent) {


    let allTableFieldsa, array1a, array2a, array3a

    if (document.body.className === "logged_in") {

        if (document.getElementById('changeAvailability').getElementsByClassName('date-time')[0]) {

            allTableFieldsa = document.getElementById('changeAvailability').getElementsByClassName('date-time')
        }

    }


}

window.closeFilter = function () {
    if (document.getElementById('bgFilter')) {

        setTimeout(function () {
            document.getElementById('bgFilter').style.left = '-1250px'
        }, 0)
        setTimeout(function () {
            document.getElementById('filterTalks').style.left = '-1250px'

            document.getElementsByClassName('submitFilterParent')[0].style.bottom = '-200px'
        }, 240)
        setTimeout(function () {
            document.getElementById('filterTalks').classList.remove('filterOpens')
            document.getElementsByClassName('pointerForFilter')[0].parentElement.parentElement.insertBefore(document.getElementById('filterTalks'), document.getElementsByClassName('pointerForFilter')[0].parentElement)
            document.getElementById('bgFilter').parentNode.removeChild(document.getElementById('bgFilter'))
        }, 610)

        document.getElementsByClassName('fButtonCont')[0].dataset.opened = "0"
        document.getElementsByClassName('fButtonCont')[0].getElementsByTagName('p')[0].textContent = getPoTranslate('FILTER')
        document.getElementsByClassName('svgFilterDiv')[0].getElementsByTagName('svg')[0].style.left = '12px'
        document.getElementsByClassName('svgFilterDiv')[0].getElementsByTagName('svg')[1].style.left = '-100px'
    }

    window.filterOpened = 0

}



class GetBookingError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetBookingError"
    }
}

class GetTokenForFallowUnfallowError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTokenForFallowUnfallowError"
    }
}

class FallowTalkError extends Error {
    constructor(message) {
        super(message)
        this.name = "FallowTalkError"
    }
}

class UnfallowTalkError extends Error {
    constructor(message) {
        super(message)
        this.name = "UnfallowTalkError"
    }
}

class GetTokenForCancelationReasonsError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTokenForCancelationReasonsError"
    }
}

class CallCancelationReasonsError extends Error {
    constructor(message) {
        super(message)
        this.name = "CallCancelationReasonsError"
    }
}

class GetTokenForRemoveProfilePhotoError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTokenForRemoveProfilePhotoError"
    }
}

class RemoveUserImageError extends Error {
    constructor(message) {
        super(message)
        this.name = "RemoveUserImageError"
    }
}

})();

/******/ })()
;
//# sourceMappingURL=app.js.map