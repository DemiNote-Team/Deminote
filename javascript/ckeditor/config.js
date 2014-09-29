CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
		{ name: 'undo',   groups: [ 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
        { name: 'others' },
        { name: 'tools' },
        { name: 'forms' }
        //{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] }
	];

	config.removeButtons = 'Table,Underline,Subscript,Anchor';
	config.format_tags = 'p;h1;h2;h3;pre';
	config.removeDialogTabs = 'image:advanced;link:advanced;link:target';
    config.autoParagraph = false;
};

CKEDITOR.on( 'dialogDefinition', function( ev ) {
    var dialogName = ev.data.name;
    var dialogDefinition = ev.data.definition;

    if ( dialogName == 'link' ) {
        dialogDefinition.removeContents('advanced');
        dialogDefinition.removeContents('target');
        dialogDefinition.height = '250px';
        var g = dialogDefinition.getContents('info');
        g.remove('linkType');
    }

    if (dialogName == 'image') {
        dialogDefinition.height = '250px';
        dialogDefinition.removeContents('advanced');
        var g = dialogDefinition.getContents('info');
        g.remove('basic');
        g.remove('htmlPreview');
        g.remove('txtAlt');
    }
});