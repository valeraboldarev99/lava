/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'ru';
	// config.uiColor = '#fff';
	config.toolbarGroups = [
	    { name: 'document',    groups: [ 'mode' ] },
	    { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
	    { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
	    { name: 'tools' },
	    { name: 'about' },
	    '/',
	    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
	    { name: 'colors' },
	    { name: 'paragraph',   groups: [ 'list', 'indent', 'align' ] },	/* 'bidi'*/
	    { name: 'links' },
	    { name: 'insert' },
	    '/',
	    { name: 'styles' },

	    // { name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
	    // { name: 'others' },
	];
};
