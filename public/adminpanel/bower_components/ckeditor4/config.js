/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
    config.contentsCss = [
        '/css/bootstrap.min.css',
        '/css/jquery-3-5-7.fancybox.css',
        '/css/style.css',
    ];
    config.allowedContent = {
        $1: {
            // Use the ability to specify elements as an object.
            elements: CKEDITOR.dtd,
            attributes: true,
            styles: true,
            classes: true
        }
    };
    config.disallowedContent = 'script; *[on*]';
	config.language = 'ru';
	// config.uiColor = '#fff';
	config.toolbarGroups = [
	    { name: 'document',    groups: [ 'mode' ] },
	    { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
	    { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
	    { name: 'tools' },
	    { name: 'about' },
	    { name: 'document',    groups: [ 'doctools' ] },
	    '/',
	    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
	    { name: 'colors' },
	    { name: 'paragraph',   groups: [ 'list', 'indent', 'align' ] },	/* 'bidi'*/
	    { name: 'links' },
	    { name: 'insert' },
	    '/',
	    { name: 'styles' },

	    //{ name: 'others' },
	];
};
