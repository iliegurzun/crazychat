/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
  
  // LOAD FRONTEND STYLESHEET
  config.filebrowserUploadUrl = '/admin/ckeditorimageupload';
  mainFrontendBundle = '';
  
  config.contentsCss = location.protocol + '//' + location.host + '/bundles/' + mainFrontendBundle + '/css/style.css';
	config.bodyPrepend = '<div id="wrapper"><div id="content"><div class="main">';
  config.bodyAppend  = '</div></div></div>';
};
