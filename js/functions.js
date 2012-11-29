// Javascript Document

$(document).ready(function(){

	$('form').submit(function checkEmpty() {
	   	var empty = false;
       	$("input").each(function() {
           empty = ($(this).val() == "") ? true : empty;
    	});
	    if(empty) {
	        alert("All fields are mandatory");
	        $(':submit').die();
       	};
     });

	$('button[name*="remove"]').click(function(){
		var currentID = $(this).attr('id');
		IDtoPHP(currentID, "remove");
	});

	$('button[name*="edit"]').click(function(){
		var currentID = $(this).attr('id');
		IDtoPHP(currentID, "edit");
	});
	$('button[name*="new"]').click(function(){
	  	addNew();		
	});
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

function addNew(){
	window.location.href = "db/act.php?act=new";
}