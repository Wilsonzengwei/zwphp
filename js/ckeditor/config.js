/**
 * Ckeditor 4.4.7
 * http://ckeditor.com/addons/plugins/all
 */

CKEDITOR.editorConfig = function( config ) {
	
	config.filebrowserUploadUrl='/js/ckeditor/upload.php?file_type=attach';
	config.filebrowserImageUploadUrl='/js/ckeditor/upload.php?file_type=img';
	config.filebrowserFlashUploadUrl='/js/ckeditor/upload.php?file_type=flash';
	
	config.skin = 'office2013';
	config.resize_enabled=false;
	config.toolbarCanCollapse=true;
	config.toolbarStartupExpanded = true;
	config.language='zh-cn';
	config.allowedContent=true;
	config.colorButton_enableMore=false;
	config.enterMode=CKEDITOR.ENTER_BR;
	config.font_names='黑体;宋体;新宋体;楷体_GB2312;Arial;Times New Roman;Times;serif';
	config.fontSize_sizes='10px;12px;14px;16px;18px;20px;22px;24px;28px';
	config.undoStackSize=200;
	config.height=400;
	config.width=screen.width>1024?'80%':'90%';
	//config.line_height="1em;1.1em;1.2em;1.3em;1.4em;1.5em";
	if(document.documentElement.scrollWidth*parseInt(config.width, 10)/100<650){
		config.width=600;
	}
	
	config.toolbar = [
		['Source','-'],
		['Cut','Copy','Paste','PasteText','PasteFromWord'],
		['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
		['TextColor','BGColor'],
		['Image','multiimg','Flash','Table','Smiley','SpecialChar','HorizontalRule','NumberedList','BulletedList'],
		'/',
		['Bold','Italic','Underline','Strike'],
		['Outdent','Indent'],
		['JustifyLeft','JustifyCenter','JustifyRight'],
		['Link','Unlink'],
		['Font','FontSize','lineheight'],
		['Maximize']
    ];
	
	config.extraPlugins = 'dialog,dialogui,colordialog,colorbutton,button,panel,floatpanel,panelbutton,multiimg,flash,font,find,selectall,indent,indentlist,indentblock,justify,horizontalrule,list,lineheight,listblock';

};
