function success_confirmation(confirm_msg,elid){
		
		$("#"+elid).html(confirm_msg);
			$("#"+elid).fadeIn('fast');
			
			setTimeout(function(){ 
				           $("#"+elid).fadeOut('slow');
			     },3000);

}
function loadStockageListeners(){
	
		$("#to_parent").click(function(){
			  var fp=parseFloat($("#factor_parent").html());
			  var fc=parseFloat($("#cont_i").html());
			  if(fc==0){
			      alert("Action denied");
			  }else{
					  var r_content=($("#child_i").html()!="") ? parseFloat($("#child_i").html()) : 0;
					  var ws_content=($("#parent_i").html()!="") ? parseFloat($("#parent_i").html()) : 0;
					  if(r_content-fc>=0){
							 $("#child_i").html(r_content-fc);
							 $("#parent_i").html(ws_content+1);
							 var pqty=(parseFloat($("#p_qty").val())<1) ? 0 : parseFloat($("#p_qty").val())-fp;
							 var rqty=(parseFloat($("#p_qty").val())>0) ? 0 : parseFloat($("#r_qty").val())+fc;
							 $("#p_qty").val(pqty);
							 $("#r_qty").val(rqty);
							 
							 var conv_no=$("#no_of_conv").html();
					         conv_no=parseInt(conv_no)-1;
					         $("#no_of_conv").html(conv_no); 
					  }else{
						  alert("Our Retail quantity is not enough to make 1 wholesale item.");
					  }
			  }
			   
		});
		
		$("#to_child").click(function(){
			  var fc=parseFloat($("#cont_i").html());
			  var fp=parseFloat($("#factor_parent").html());
			  if(fc==0){
				alert("Action denied");
			  }else{
					  var r_content=($("#child_i").html()!="") ? parseFloat($("#child_i").html()) : 0;
					  var ws_content=($("#parent_i").html()!="") ? parseFloat($("#parent_i").html()) : 0;
					  if(ws_content-1>=0){
							 $("#child_i").html(r_content+fc);
							 $("#parent_i").html(ws_content-1);
							 var pqty=(parseFloat($("#r_qty").val())>0) ? 0 : parseFloat($("#p_qty").val())+fp;
							 var rqty=(parseFloat($("#r_qty").val())<1) ? 0 : parseFloat($("#r_qty").val())-fc;
							 $("#p_qty").val(pqty);
							 $("#r_qty").val(rqty);
							 var conv_no=$("#no_of_conv").html();
					         conv_no=parseInt(conv_no)+1;
					         $("#no_of_conv").html(conv_no);
					  }else{
						  alert("There's no more wholesale item to break down.");
					  }
			  }
			  
		});	
}