<script>
	$(function(){
	  
	    $( "#go_draft_btn" ).click(function( event ) {
		    location.href="<?php echo site_url('/f_main/draft_day/'.$this->uri->segment(3)); ?>";
			event.preventDefault();
		});
		$( "#seasons_view" ).click(function( event ) {
		    location.href="<?php echo site_url('/f_main/season/'.$this->uri->segment(3)); ?>";
			event.preventDefault();
		});
		$( ".pickbtn" ).click(function( event ) {
			var id=$(this).attr('id').replace('pick','');
		    $.post("<?php echo site_url('/f_main/pick_from_draft'); ?>",
							 {"id":id,
						      "season_id":<?php echo intval($this->uri->segment(3)); ?>
							 },
							 function(data){
                                  $("#draft"+id).html(data);
							 }
			);
		});
		$( ".applybtn" ).click(function( event ) {
			var id=$(this).attr('id').replace('apply','');
		    $.post("<?php echo site_url('/f_main/sign_pick'); ?>",
							 {"id":id,
						      "season_id":<?php echo intval($this->uri->segment(3)); ?>
							 },
							 function(data){
							 	 if(data=="signed"){
							 	 		$("#announce"+id).html("The "+$("#teamname"+id).html()+" signed their draft pick.");
								}
							 }
			);
		});
	})
</script>
</head>
<body>
			<table cellpadding="5" cellspacing="0" border="0">
			   <tr><td class="page_titles">DRAFT BOUND TEAMS</td></tr>
	           <tr><td><input type="button" value="back" id="seasons_view"/></td></tr>
			   <tr><td>
			               	<table cellpadding="5" cellspacing="0" border="0" class="team_standings_season">
								  <tr><td>TEAM</td><td>RATING</td><td>PICK</td><td colspan="2">DRAFT PICK</td></tr>
										<?php if(isset($nbateams)): foreach($nbateams as $row): ?>
											  <tr><td id="<?php echo 'teamname'.$row->id; ?>"><?php echo $row->cities." ".$row->names; ?></td><td><?php echo $row->team_rating; ?></td><td id="draft<?php echo $row->id; ?>"><?php echo $row->draft; ?></td><td><input type="button" value="Pick" id="<?php echo 'pick'.$row->id; ?>" class="pickbtn"/></td><td><input type="button" value="Sign Draft Pick" id="<?php echo 'apply'.$row->id; ?>" class="applybtn"/></td><td id="<?php echo 'announce'.$row->id; ?>"></td></tr>
										<?php
										 	  endforeach;
											  endif; 
										?>
							   </table>
			       </td>
			       
			   </tr>
			</table> 
								
