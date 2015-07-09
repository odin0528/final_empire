$(document).ready(function() { 

	// Navigation menu

	$('ul#navigation').superfish({ 
		delay:       1000,
		animation:   {opacity:'show',height:'show'},
		speed:       'fast',
		autoArrows:  true,
		dropShadows: false
	});
	
	$('ul#navigation li').hover(function(){
		$(this).addClass('sfHover2');
	},
	function(){
		$(this).removeClass('sfHover2');
	});

	// Accordion
	$("#accordion, #accordion2").accordion({ header: "h3" });

	// Tabs
	$('#tabs, #tabs2, #tabs5').tabs();

	// Dialog			
	$('#dialog').dialog({
		autoOpen: false,
		width: 600,
		bgiframe: false,
		modal: false,
		buttons: {
			"Ok": function() { 
				$(this).dialog("close"); 
			}, 
			"Cancel": function() { 
				$(this).dialog("close"); 
			} 
		}
	});
	
	// Login Dialog Link
	$('#login_dialog').click(function(){
		$('#login').dialog('open');
		return false;
	});

	// Login Dialog			
	$('#login').dialog({
		autoOpen: false,
		width: 300,
		height: 230,
		bgiframe: true,
		modal: true,
		buttons: {
			"Login": function() { 
				$('#login form')[0].submit(); 
			}, 
			"Close": function() { 
				$(this).dialog("close"); 
			} 
		}
	});

	// Dialog auto open			
	$('#welcome').dialog({
		autoOpen: false,
		width: 470,
		height: 180,
		bgiframe: true,
		modal: true,
		buttons: {
			"Close this dialog box": function() { 
				$(this).dialog("close"); 
			}
		}
	});

	// Dialog auto open			
	$('#welcome_login').dialog({
		autoOpen: false,
		width: 470,
		height: 630,
		bgiframe: true,
		modal: true,
		buttons: {
			"Proceed to demo !": function() {
				window.location = "index.php";
			}
		}
	});

	// Datepicker
	$('#datepicker').datepicker({
		inline: true
	});
	
	//Hover states on the static widgets
	$('#dialog_link, #login_dialog, ul#icons li').hover(
		function() { $(this).addClass('ui-state-hover'); }, 
		function() { $(this).removeClass('ui-state-hover'); }
	);


	$(".portlet").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
		.find(".portlet-header")
			.addClass("ui-widget-header")
			.prepend('<span class="ui-icon ui-icon-circle-arrow-s"></span>')
			.end()
		.find(".portlet-content");

	$(".portlet-header .ui-icon").click(function() {
		$(this).toggleClass("ui-icon-circle-arrow-n");
		$(this).parents(".portlet:first").find(".portlet-content").slideToggle();
	});

	$(".header").append('<span class="ui-icon ui-icon-carat-2-n-s"></span>');

	
});

	/* Tooltip */

	$(function() {
		$('.tooltip').tooltip({
			track: true,
			delay: 0,
			showURL: false,
			showBody: " - ",
			fade: 250
		});
	});
    
 	/* Check all table rows */
	
var checkflag = "false";
function check(field) {
if (checkflag == "false") {
for (i = 0; i < field.length; i++) {
field[i].checked = true;}
checkflag = "true";
return "check_all"; }
else {
for (i = 0; i < field.length; i++) {
field[i].checked = false; }
checkflag = "false";
return "check_none"; }
}