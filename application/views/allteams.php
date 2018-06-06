<script>
	$(function(){
	       $( "#seasons_list" ).click(function( event ) {
			   		location.href="<?php echo site_url('/f_main/index/'); ?>";
			});
			$( ".team_pads" ).click(function( event ) {
				    location.href="<?php echo site_url('/f_main/team/'); ?>"+"/"+$(this).html();
		   });
	})
</script>
</head>
<body>
			<table cellpadding="5" cellspacing="0" border="0" id="teams_frame">
			   <tr><td class="page_titles" colspan="3"></td></tr>
			   <tr><td class="confs">WESTERN CONFERENCE</td><td><input type="button" value="Seasons List" id="seasons_list"/></td><td class="confs">EASTERN CONFERENCE</td></tr>
			   <tr><td>       	<table cellpadding="10" cellspacing="1" border="0">
										<?php $i=1; if(isset($westeams)): foreach($westeams as $row): ?>
											  <tr><td style="text-align:right;width:5px;"><?php echo $i; ?></td><td class="team_pads" style="background:<?php echo $row->bg_color; ?>;color:<?php echo $row->font_color; ?>;" id="<?php echo $row->id; ?>"><?php echo $row->cities." ".$row->names ?></td></tr>
										      <tr><td></td><td class="team_achive"><?php echo $this->misclib->grz($row->nba_titles,"NBA Title").", ".$this->misclib->grz($row->conf_titles,"Conference Title")." in ".$this->misclib->grz($row->pl_apps,"playoffs appearance"); ?></td></tr>

										<?php $i++;
										 	  endforeach;
											  endif; 
										?>
							   </table>	
			                 
			               	
			       </td>
			       <td valign="middle">     
				   </td>							
			       <td>       <table cellpadding="10" cellspacing="1" border="0">
										<?php $i=1; if(isset($easteams)): foreach($easteams as $row): ?>
											  <tr><td style="text-align:right;width:5px;"><?php echo $i; ?></td><td class="team_pads" style="background:<?php echo $row->bg_color; ?>;color:<?php echo $row->font_color; ?>;" id="<?php echo $row->id; ?>"><?php echo $row->cities." ".$row->names ?></td></tr>
										      <tr><td></td><td class="team_achive"><?php echo $this->misclib->grz($row->nba_titles,"NBA Title").", ".$this->misclib->grz($row->conf_titles,"Conference Title")." in ".$this->misclib->grz($row->pl_apps,"playoffs appearance"); ?></td></tr>
										<?php $i++;
										 	  endforeach;
											  endif; 
										?>
							   </table>
			       			
							 			
			       </td>
			   </tr>
			</table> 
