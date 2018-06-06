<script>
	$(function(){
	    
	    $( "#go_draft_btn" ).click(function( event ) {
		    location.href="<?php echo site_url('/f_main/draft_day/'.$this->uri->segment(3)); ?>";
			event.preventDefault();
		});
		$( "#team_previews" ).click(function( event ) {
		    location.href="<?php echo site_url('/f_main/team_previews/'.$this->uri->segment(3)); ?>";
			event.preventDefault();
		});
		$( "#start_season" ).click(function( event ) {
		    location.href="<?php echo site_url('/f_main/set_season_schedule/'.$this->uri->segment(3)); ?>";
			event.preventDefault();
		});
		$( "#seasons_list" ).click(function( event ) {
		    location.href="<?php echo site_url('/f_main/index/'); ?>";
			event.preventDefault();
		});
		$( "#list_playoff_contenders" ).click(function( event ) {
		    location.href="<?php echo site_url('/f_main/enlist_playoff_contenders/'.$this->uri->segment(3)); ?>";
			event.preventDefault();
		});
		$( ".keepbtn" ).click(function( event ) {
			var id=$(this).attr('id').replace('kip','');
		    $.post("<?php echo site_url('/f_main/keepcore'); ?>",
							 {"id":id,
						      "rating":$("#rating"+id).html(),
						      "season_id":<?php echo intval($this->uri->segment(3)); ?>
							 },
							 function(data){
                                  $("#rating"+id).html(data);
							 }
			);
		});
		$( ".rebildbtn" ).click(function( event ) {
			var id=$(this).attr('id').replace('rebild','');
		    $.post("<?php echo site_url('/f_main/rebuild'); ?>",
							 {"id":id,
						      "rating":$("#rating"+id).html(),
						      "season_id":<?php echo intval($this->uri->segment(3)); ?>
							 },
							 function(data){
								$("#rating"+id).html(data);
							 }
			);
		});
	})
</script>
</head>
<body>
	<?php if($season_time=='regular'){ ?>
			<table cellpadding="5" cellspacing="0" border="0">
			   <tr><td class="page_titles" colspan="3"><?php echo "SEASON ".$this->uri->segment(3)." STANDINGS"; ?></td></tr>
			   <tr><td class="confs">WESTERN CONFERENCE</td><td><input type="button" value="Seasons List" id="seasons_list"/></td><td class="confs">EASTERN CONFERENCE</td></tr>
			   <tr><td>       	
			                  <table cellpadding="6" cellspacing="2" border="0" class="team_standings_season">
								  <tr><th></th><th>TEAM</th><th style="text-align:center;">RATING</th><th style="text-align:center;">RECORD</th></tr>
										<?php $i=1; if(isset($westcon)): foreach($westcon as $row): ?>
											  <?php $rowclass=($i<=8) ? "listrow":"elim"; ?>
											  <tr class="<?php echo $rowclass; ?>"><td style="text-align:right;"><?php echo $i; ?></td><td><?php echo $row->cities." ".$row->names; ?></td><td style="text-align:center;"><?php echo $row->team_rating; ?></td><td class="records"><?php echo $row->wins."-".$row->losses; ?></td></tr>
										<?php $i++;
											  $winloss=$row->wins."-".$row->losses;
										 	  endforeach;
											  endif; 
										?>
							   </table>	
			               	
			       </td>
			       <td valign="middle">         <table border="0" cellspacing="0" cellpadding="5">
							       			        <tr><td><input type="button" value="Team Previews" id="team_previews"/></td></tr>
							       	   <?php if($winloss!="0-0"){ ?><tr><td><input type="button" value="Start Playoffs" id="list_playoff_contenders"/></td></tr><?php } ?>  
									       	    </table>
				   </td>							
			       <td>
			       			
							   <table cellpadding="6" cellspacing="2" border="0" class="team_standings_season">
								  <tr><th></th><th>TEAM</th><th style="text-align:center;">RATING</th><th style="text-align:center;">RECORD</th></tr>
										<?php $i=1; if(isset($eastcon)): foreach($eastcon as $row): ?>
											  <?php $rowclass=($i<=8) ? "listrow":"elim"; ?>
											  <tr class="<?php echo $rowclass; ?>"><td style="text-align:right;"><?php echo $i; ?></td><td><?php echo $row->cities." ".$row->names; ?></td><td style="text-align:center;"><?php echo $row->team_rating; ?></td><td class="records"><?php echo $row->wins."-".$row->losses; ?></td></tr>
										<?php $i++;
										 	  endforeach;
											  endif; 
										?>
							   </table>				
			       </td>
			   </tr>
			</table> 
 <?php }else{ ?>
 			<table cellpadding="5" cellspacing="0" border="1">
			   <tr><td class="page_titles" colspan="3">SEASON MOVEMENTS</td></tr>
			   <tr><td class="confs">WESTERN CONFERENCE</td><td><input type="button" value="Seasons List" id="seasons_list"/></td><td class="confs">EASTERN CONFERENCE</td></tr>
			   <tr><td>
			               	  <table cellpadding="5" cellspacing="0" border="0" class="team_standings_season2">
								  <tr><td></td><td>TEAM</td><td style="text-align:center;">RATING</td><td style="text-align:center;">RECORD</td><td style="text-align:center;">RATING</td><td>MOVEMENTS</td></tr>
										<?php $i=1; if(isset($westcon)): foreach($westcon as $row): ?>
											  <tr><td style="text-align:right;"><?php echo $i; ?></td><td><?php echo $row->cities." ".$row->names; ?></td><td style="text-align:center;"><?php echo $row->prev_team_rating; ?></td><td style="text-align:center;"><?php echo $row->wins.'-'.$row->losses; ?></td><td id="<?php echo 'rating'.$row->id; ?>" style="text-align:center;"><?php echo $row->team_rating; ?></td><td><input type="button" value="Keep" id="<?php echo 'kip'.$row->id; ?>" class="keepbtn"/></td><td><input type="button" value="Rebuild" id="<?php echo 'rebild'.$row->id; ?>" class="rebildbtn"/></td></tr>
										<?php $i++;
										 	  endforeach;
											  endif; 
										?>
							   </table>	
			       </td>
			       <td><table cellpadding="0" cellspacing="5" border="0">
			                <tr><td><input type="button" value="enter draft" id="go_draft_btn"/></td></tr>
			                <tr><td><input type="button" id="start_season" value="start season"/><td></tr>
			           </table>
			       </td>							
			       <td>
			       				
							   <table cellpadding="5" cellspacing="0" border="0" class="team_standings_season2">
								  <tr><td></td><td>TEAM</td><td style="text-align:center;">RATING</td><td style="text-align:center;">RECORD</td><td style="text-align:center;">RATING</td><td colspan="2">MOVEMENTS</td></tr>
										<?php $i=1; if(isset($eastcon)): foreach($eastcon as $row): ?>
											  <tr><td style="text-align:right;"><?php echo $i; ?></td><td><?php echo $row->cities." ".$row->names; ?></td><td style="text-align:center;"><?php echo $row->prev_team_rating; ?></td><td style="text-align:center;"><?php echo $row->wins.'-'.$row->losses; ?></td><td id="<?php echo 'rating'.$row->id; ?>" style="text-align:center;"><?php echo $row->team_rating; ?></td><td><input type="button" value="Keep" id="<?php echo 'kip'.$row->id; ?>" class="keepbtn"/></td><td><input type="button" value="Rebuild" id="<?php echo 'rebild'.$row->id; ?>" class="rebildbtn"/></td></tr>
										<?php $i++;
										 	  endforeach;
											  endif; 
										?>
							   </table>				
			       </td>
			   </tr>
			   <tr><td colspan="3"></td></tr>								
			</table> 
 <?php } ?>											
