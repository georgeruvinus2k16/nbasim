<script>
	$(function(){
	    
	    $( "#view_standings" ).click(function( event ) {
		    location.href="<?php echo site_url('/f_main/season/'.$this->uri->segment(3)); ?>";
			event.preventDefault();
		});
		$( "#run_season" ).click(function( event ) {
			$.post("<?php echo site_url('/f_main/run_season'); ?>",
							 {"season_id":<?php echo intval($this->uri->segment(3)); ?>
							 },
							 function(data){
                                     if(data=='success'){
                                           location.href="<?php echo site_url('/f_main/season/'.$this->uri->segment(3)); ?>";
                                     }else{
                                           alert(data);
                                     }
							 }
			);
		});
		$( "#seasons_list" ).click(function( event ) {
		    location.href="<?php echo site_url('/f_main/index/'); ?>";
			event.preventDefault();
		});
	})
</script>
</head>
<body>

			<table cellpadding="5" cellspacing="0" border="0">
			   <tr><td class="page_titles" colspan="3">SEASON PREVIEW</td></tr>
			   <tr><td class="confs">WESTERN CONFERENCE</td><td><input type="button" value="Seasons List" id="seasons_list"/></td><td class="confs">EASTERN CONFERENCE</td></tr>
			   <tr><td>
			               	    <table cellpadding="5" cellspacing="0" border="0" class="team_standings_season">
								  <tr><td></td><td>TEAM</td><td style="text-align:center;">RATING</td><td style="text-align:center;">RECORD</td></tr>
										<?php $i=1; if(isset($westcon)): foreach($westcon as $row): ?>
											  <tr><td style="text-align:right;"><?php echo $i; ?></td><td><?php echo $row->cities." ".$row->names; ?></td><td style="text-align:center;"><?php echo $row->team_rating; ?></td><td class="records">0-0</td></tr>
										<?php $i++;
										 	  endforeach;
											  endif; 
										?>
							   </table>	
			       </td>
			       <td>         <table border="0" cellspacing="0" cellpadding="5">
			       					<tr><td><input type="button" value="Season standings" id="view_standings"/></td></tr>
			       					<tr><td><input type="button" value="Run Season" id="run_season"/></td></tr>
			       				</table>
			       </td>							
			       <td>
			       				
							   <table cellpadding="5" cellspacing="0" border="0" class="team_standings_season">
								  <tr><td></td><td>TEAM</td><td style="text-align:center;">RATING</td><td style="text-align:center;">RECORD</td></tr>
										<?php $i=1; if(isset($eastcon)): foreach($eastcon as $row): ?>
											  <tr><td style="text-align:right;"><?php echo $i; ?></td><td><?php echo $row->cities." ".$row->names; ?></td><td style="text-align:center;"><?php echo $row->team_rating; ?></td><td class="records">0-0</td></tr>
										<?php $i++;
										 	  endforeach;
											  endif; 
										?>
							   </table>								
			       </td>
			   </tr>
			</table> 
