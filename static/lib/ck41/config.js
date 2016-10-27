/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	/*config.toolbarGroups = [

        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] }

	];*/
	
	config.toolbar=
		[
			{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','RemoveFormat' ] },
			{ name: 'paragraph', items : [ 'NumberedList','BulletedList','Outdent','Indent','Blockquote',
			'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
			{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
			{ name: 'insert', items : [ 'Image','Flash','Table','SpecialChar','TextColor','BGColor','FontSize','Font','Source' ] }
		];

	
	config.removeButtons = 'Subscript,Superscript';

	// Se the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Make dialogs simpler.
	config.removeDialogTabs = 'image:advanced;link:advanced';
	config.enterMode = CKEDITOR.ENTER_BR;
	config.uiColor= '#f2f2f2';
	
	config.filebrowserImageUploadUrl = '/index.php?b=uye/editor_foto_yukle';
	
};

/*
$.each(CKEDITOR.instances,function(i,j){
	j.on('focus',function(){ $('#cke_'+i).removeClass('zorunlu'); });
});*/