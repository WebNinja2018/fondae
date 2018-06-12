function getCookie(c_name)
{
	if (document.cookie.length>0)
	  {
	  c_start=document.cookie.indexOf(c_name + "=");
	  if (c_start!=-1)
		{ 
		c_start=c_start + c_name.length+1; 
		c_end=document.cookie.indexOf(";",c_start);
		if (c_end==-1) c_end=document.cookie.length;
		return unescape(document.cookie.substring(c_start,c_end));
		} 
	  }
	return "";
}
function Set_Cookie( name, value, expires, path, domain, secure ) 
{
	var today = new Date();
	today.setTime( today.getTime() );

	if ( expires )
	{
	expires = expires * 1000 * 60 * 60 * 24;
	}
	var expires_date = new Date( today.getTime() + (expires) );

	document.cookie = name + "=" +escape( value ) +
	( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) + 
	( ( path ) ? ";path=" + path : "" ) + 
	( ( domain ) ? ";domain=" + domain : "" ) +
	( ( secure ) ? ";secure" : "" );
}
changeTo(getCookie('mysheet'));			
function changeTo(s)
{
	if(s==null || s=='undefined' || s == '' || s == 'none')
	{s='';}	
	if(s==0)
	{
		$('#advance_search_col').css('display','none');
	}
	else{
		$('#advance_search_col').css('display','block');
	}
	Set_Cookie('mysheet',s,'30','/','','');
}

function return_Page(returnTypeID){
	/*
		returnTypeID = 1 remove thickbox and page reload.
		returnTypeID = 2 remove thickbox and call ajax function.
		returnTypeID = 1 remove thickbox and redirect page.
	*/
	if(returnTypeID==1){ //remove thickbox and page reload.
		
		//window.opener.location.reload();
		window.location.reload();
		tb_remove();
		
	}else if(returnTypeID==2){
		tb_remove();
		$("#propertyID").selectmenu("refresh");
		
	}else if(returnTypeID==3){
		tb_remove();
		window.location.href='';
	}else{
		tb_remove();	
	}
}

function load_dropdown(popupOpenType,typeID,optionID,optionName)
{	
	/*
		1 for property.
	    2 for property Owner.
		3 for unit.
		4 for tenant.
		5 for lease.
	*/
	tb_remove();
	if(popupOpenType == 1){   //property popup
		if(typeID == 3){            // property popup open in unit module
			$('#propertyID').append( '<option value="'+optionID+'" selected="selected">'+optionName+'</option>' );
		}
		else if(typeID == 5){		// property popup open in lease modules
			$('#leasePropertyID').append( '<option value="'+optionID+'" selected="selected">'+optionName+'</option>' );
			$('#leasePropertyID').change();
		}
		else{
			
		}
	}
	else if(popupOpenType == 2){    //property owner popup
		if(typeID == 1){                // property owner popup open in property module
			$('#propertyOwnerID').append( '<option value="'+optionID+'" selected="selected">'+optionName+'</option>' );
		}
		else{
			
		}
	}
	else if(popupOpenType == 3){    //unit popup
		if(typeID == 5){                // unit popup open in lease module
			$('#leaseUnitID').append( '<option value="'+optionID+'" selected="selected">'+optionName+'</option>' );
		}
		else{
			
		}
	}
	else if(popupOpenType == 4){
		if(typeID == 5){                //tenant popup open in lease module
			$('#leaseTenantID').append( '<option value="'+optionID+'" selected="selected">'+optionName+'</option>' );
		}
	}
	
}