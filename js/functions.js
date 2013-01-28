// Javascript Document

$(document).ready(function(){

	$('button').attr('class', 'buttonTemplate');
	$('button:first').css('margin-left', '2em');
	$('label').append('<br/>')

	$('button[name*="remove"]').click(function(){
		var currentID = $(this).attr('id');
		IDtoPHP(currentID, "remove");
	});

	$('button[name*="edit"]').click(function(){
		var currentID = $(this).attr('id');
		IDtoPHP(currentID, "edit");
	});
/*	$('button[name*="new"]').click(function(){
	  	addNew();		
	}); */
	$('#cancel').click(function(){
		window.location.href = "../index.php";
	})


});

function IDtoPHP(id, act) { 
	if(act == "remove" ){
		//alert('Sending to db to '+act+' row number:'+id);
		var r=confirm("Do you really want to remove this model?");
		r;
		if (r==true){
		  	x="You pressed OK!";
		  	window.location.href = "db/act.php?id=" + id + "&act=remove";
		} else {
		  	x="You pressed Cancel!";
		}
	} else if(act == "edit"){
		//alert('sending id to edit the row'+id);
		window.location.href = "db/act.php?id=" + id + "&act=edit";
	}
};