/*
 t3CMS:admin.js
 Administration scripts
 TODO: Fix TinyMCE size
*/

function title2name(){
    var delay = 400;
    var maxlen = 16;
    var repchar = '_';
    var a = document.getElementById('_name');
    var b = document.getElementById('_title');
    s = b.value;
    if(s.length>maxlen) s = s.substr(0,maxlen-2) + '_1';
    s = s.toLowerCase();
    s = s.replace(/[å|ä|æ|à|á|â|ã]/g,'a');
    s = s.replace(/[ö|ø|ò|ó|õ|ô]/g,'o');
    s = s.replace(/[ñ]/g,'n');
    s = s.replace(/[^a-z|_|0-9]/g,repchar);
    a.value = s;
    //setTimeout('t2n()', delay);
}

function setAutoResize(ed)
{   
    //Function to fix iframe to document height
    fitEditor = function(ed)
    {
        editorID = ed.id;
        var tble, frame, doc, docHeight, frameHeight;
        
        frame = document.getElementById(editorID+"_ifr");
        if ( frame != null )
        {
            //get the document object
            if (frame.contentDocument) doc = frame.contentDocument; 
            else if (frame.contentWindow) doc = frame.contentWindow.document; 
            else if (frame.document) doc = frame.document; 
            
            if ( doc == null )
            return;
            
            //prevent the scrollbar from showing
            doc.body.style.overflow = "hidden";
            
            //Fixes the issue of the table leaving empty space below iframe
            tble = frame.parentNode.parentNode.parentNode.parentNode;
            tble.style.height = 'auto';
            
            frameHeight = parseInt(frame.style.height);
            
            //Firefox
            if ( doc.height ) docHeight = doc.height;
            //MSIE
            else docHeight = parseInt(doc.body.scrollHeight);
            
            //MAKE BIGGER
            if ( docHeight > frameHeight ) frame.style.height = (docHeight + 20) + "px";
            //MAKE SMALLER
            else if ( docHeight < frameHeight ) frame.style.height = Math.max((docHeight + 20), 100) + "px";
        }
    };
    
    //add fitEditor function to tinyMCE events
    ed.onSetContent.add( fitEditor );
    ed.onChange.add( fitEditor );
    ed.onKeyPress.add( fitEditor );
    
    fitEditor(ed);
    
//Remaining bug: (Chrome and Opera) editor grows but doesn't shrink
}

function alertAllEditorIDs () {
    var IDs = new Array();
    var editorID;
    for (editorID in tinyMCE.editors) {
        IDs[IDs.length] = editorID;
    };

    alert("All editor IDs:\n" + IDs);
}

function deletePage(){
    if(confirm('Are you sure you want to DELETE this page?')){
        alert('Poff!');
    }
}

function init_mce(type){
    var tiny_mce_default_value = 'Please replace this dummy content with your own!';
	if (type == 'full'){
        tinyMCE.init({
            // General options
            mode : "none",
            theme : "advanced",
            plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount",
 
            // Theme options
            theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
            theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            //theme_advanced_resizing : true,
            
            default_value: 'Please replace this dummy content with your own!',
            
            width: '100%',
            height: '100%',
     
            // Example content CSS (should be your site CSS)
            content_css : "etc/mce_content.css",
     
            // Drop lists for link/image/media/template dialogs
            template_external_list_url : "js/lists/template_list.js",
            external_link_list_url : "js/lists/link_list.js",
            external_image_list_url : "js/lists/image_list.js",
            media_external_list_url : "js/lists/media_list.js"

        });
	}
    else if(type == 'nano') {
    	tinyMCE.init({mode : "textareas", theme : "simple"});
    }
    
    id = 'content';
    
    tinyMCE.execCommand('mceAddControl',false,id);
    //setTimeout('setAutoResize(tinyMCE.get("content"))',200);

}

function testa(){
    alertAllEditorIDs();
    alert(tinyMCE.get("content"));
    setAutoResize(tinyMCE.get("content"));
}