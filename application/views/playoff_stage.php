<script>
	$(function(){
	    
	    $( "#playofflogo" ).click(function( event ) {
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
		$( "#series_recap" ).dialog({
				autoOpen: false,
				resizable: false,
				width:420,
				position: {at: "middle top"},
				modal: true,
				buttons: {
					"Play": function() {
						$.post("<?php echo site_url('/f_main/playseries'); ?>",
							 {"mcode":$("#idtoprocess").val(),
					          "pl_id":<?php echo intval($this->uri->segment(3)); ?>
							 },
							 function(data){
							 	 if(data=='over'){
							 	      alert("THIS SERIES IS OVER");
							 	 }else{
							 	 	  // alert(data);
							 	      $("#match_up_detail").html(data); 
							 	 }
							 }
			 			);
						
					},
					Close: function() {
						$( this ).dialog( "close" );
						location.href="<?php echo site_url('/f_main/playoff_picture/'.$this->uri->segment(3)); ?>";
					}
				}
		});
		$( ".g_series" ).click(function( event ) {
			 $.post("<?php echo site_url('/f_main/get_match_up_run'); ?>",
							 {"mcode":$(this).attr('id'),
					          "pl_id":<?php echo intval($this->uri->segment(3)); ?>
							 },
							 function(data){
							 	 $("#match_up_detail").html(data);
							 }
			 );
			 $("#idtoprocess").val($(this).attr('id'));
		     $("#series_recap").dialog("open");
			 event.preventDefault();
		});
	})
</script>
</head>
<body id="stage_bg">

			<table cellpadding="5" cellspacing="0" border="0" id="playoff_stage">
			     <tr><td colspan="11" id="stage_header"><?php echo $playoff_year." NBA PLAYOFFS"; ?></td></tr>
			     <tr><td style="width:3px;"></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td style="width:3px;"></td></tr>
		         <tr><td>1</td><td style="background:<?php echo $f1->ebg1; ?>;color:<?php echo $f1->efc1; ?>;" class="team_pad_east"><?php echo $f1->et1; ?></td><td></td><td></td><td></td><td rowspan="9"><div id="trophic"></div></td><td></td><td></td><td></td><td style="background:<?php echo $f1->wbg1; ?>;color:<?php echo $f1->wfc1; ?>;" class="team_pad_west"><?php echo $f1->wt1; ?></td><td>1</td></tr>
		         <tr><td></td><td class="g_series" id="<?php echo $f2->et_id; ?>" style="border-right:2px solid #CCC;"><?php echo $f2->em1; ?></td><td style="background:<?php echo $f2->ebg1; ?>;color:<?php echo $f2->efc1; ?>;border-right:2px solid #CCC;" class="team_pad_east"><?php echo $f2->et1; ?></td><td></td><td></td><td></td><td></td><td style="background:<?php echo $f2->wbg1; ?>;color:<?php echo $f2->wfc1; ?>;border-left:2px solid #CCC;" class="team_pad_west"><?php echo $f2->wt1; ?></td><td class="g_series" id="<?php echo $f2->wt_id; ?>" style="border-left:2px solid #CCC;"><?php echo $f2->wm1; ?></td><td></td></tr>
		         <tr><td>8</td><td style="background:<?php echo $f3->ebg1; ?>;color:<?php echo $f3->efc1; ?>;" class="team_pad_east"><?php echo $f3->et1; ?></td><td class="east_border"></td><td></td><td></td><td></td><td></td><td class="west_border"></td><td style="background:<?php echo $f3->wbg1; ?>;color:<?php echo $f3->wfc1; ?>;" class="team_pad_west"><?php echo $f3->wt1; ?></td><td>8</td></tr>
		         <tr><td></td><td></td><td style="border-right:2px solid #CCC;"></td><td></td><td></td><td></td><td></td><td class="west_border"></td><td></td><td></td></tr>
		         <tr><td></td><td></td><td class="g_series" id="<?php echo $f4->et_id; ?>" style="border-right:2px solid #CCC;"><?php echo $f4->em1; ?></td><td style="background:<?php echo $f4->ebg1; ?>;color:<?php echo $f4->efc1; ?>;border-right:2px solid #CCC;" class="team_pad_east"><?php echo $f4->et1; ?></td><td></td><td></td><td style="background:<?php echo $f4->wbg1; ?>;color:<?php echo $f4->wfc1; ?>;border-left:2px solid #CCC;" class="team_pad_west"><?php echo $f4->wt1; ?></td><td class="g_series" id="<?php echo $f4->wt_id; ?>" style="border-left:2px solid #CCC;"><?php echo $f4->wm1; ?></td><td></td><td></td></tr>
		         <tr><td></td><td></td><td class="east_border"></td><td class="east_border"></td><td></td><td></td><td class="west_border"></td><td class="west_border"></td><td></td><td></td></tr>
		         <tr><td>4</td><td style="background:<?php echo $f5->ebg1; ?>;color:<?php echo $f5->efc1; ?>;" class="team_pad_east"><?php echo $f5->et1; ?></td><td class="east_border"></td><td class="east_border"></td><td></td><td></td><td class="west_border"></td><td class="west_border"></td><td style="background:<?php echo $f5->wbg1; ?>;color:<?php echo $f5->wfc1; ?>;" class="team_pad_west"><?php echo $f5->wt1; ?></td><td>4</td></tr>
		         <tr><td></td><td class="g_series" id="<?php echo $f6->et_id; ?>" style="border-right:2px solid #CCC;"><?php echo $f6->em1; ?></td><td style="background:<?php echo $f6->ebg1; ?>;color:<?php echo $f6->efc1; ?>;border-right:2px solid #CCC;" class="team_pad_east"><?php echo $f6->et1; ?></td><td class="east_border"></td><td></td><td></td><td class="west_border"></td><td style="background:<?php echo $f6->wbg1; ?>;color:<?php echo $f6->wfc1; ?>;border-left:2px solid #CCC;" class="team_pad_west"><?php echo $f6->wt1; ?></td><td class="g_series" id="<?php echo $f6->wt_id; ?>" style="border-left:2px solid #CCC;"><?php echo $f6->wm1; ?></td><td></td></tr>
		         <tr><td>5</td><td style="background:<?php echo $f7->ebg1; ?>;color:<?php echo $f7->efc1; ?>;" class="team_pad_east"><?php echo $f7->et1; ?></td><td></td><td class="east_border"></td><td></td><td></td><td class="west_border"></td><td></td><td style="background:<?php echo $f7->wbg1; ?>;color:<?php echo $f7->wfc1; ?>;" class="team_pad_west"><?php echo $f7->wt1; ?></td><td>5</td></tr>
		         <tr><td></td><td></td><td></td><td style="border-right:2px solid #CCC;"></td><td></td><td style="background:#FFFF00;color:#F00;border:3px solid #FFCC00;font-weight:bold;text-align:center;"><?php echo $f8->ct; ?></td><td></td><td class="west_border"></td><td></td><td></td><td></td></tr>
		         <tr><td></td><td></td><td></td><td class="g_series" id="<?php echo $f9->et_id; ?>" style="border-right:2px solid #CCC;"><?php echo $f9->em1; ?></td><td style="background:<?php echo $f9->ebg1; ?>;color:<?php echo $f9->efc1; ?>;" class="team_pad_east"><?php echo $f9->et1; ?></td><td></td><td style="background:<?php echo $f9->wbg1; ?>;color:<?php echo $f9->wfc1; ?>;" class="team_pad_west"><?php echo $f9->wt1; ?></td><td class="g_series" id="<?php echo $f9->wt_id; ?>" style="border-left:2px solid #CCC;"><?php echo $f9->wm1; ?></td><td></td><td></td><td></td></tr>
		         <tr><td></td><td></td><td></td><td class="east_border"></td><td></td><td class="g_series" id="<?php echo $f8->fin_id; ?>"><?php echo $f8->nbafrec; ?></td><td></td><td class="west_border"></td><td></td><td></td><td></td></tr>
		         <tr><td>3</td><td style="background:<?php echo $f10->ebg1; ?>;color:<?php echo $f10->efc1; ?>;" class="team_pad_east"><?php echo $f10->et1; ?></td><td></td><td class="east_border"></td><td></td><td></td><td></td><td class="west_border"></td><td></td><td style="background:<?php echo $f10->wbg1; ?>;color:<?php echo $f10->wfc1; ?>;" class="team_pad_west"><?php echo $f10->wt1; ?></td><td>3</td></tr>
		         <tr><td></td><td class="g_series" id="<?php echo $f11->et_id; ?>" style="border-right:2px solid #CCC;"><?php echo $f11->em1; ?></td><td style="background:<?php echo $f11->ebg1; ?>;color:<?php echo $f11->efc1; ?>;border-right:2px solid #CCC;" class="team_pad_east"><?php echo $f11->et1; ?></td><td class="east_border"></td><td></td><td></td><td></td><td  class="west_border"></td><td style="background:<?php echo $f11->wbg1; ?>;color:<?php echo $f11->wfc1; ?>;border-left:2px solid #CCC;" class="team_pad_west"><?php echo $f11->wt1; ?></td><td class="g_series" id="<?php echo $f11->wt_id; ?>" style="border-left:2px solid #CCC;"><?php echo $f11->wm1; ?></td><td></td></tr>
		         <tr><td>6</td><td style="background:<?php echo $f12->ebg1; ?>;color:<?php echo $f12->efc1; ?>;" class="team_pad_east"><?php echo $f12->et1; ?></td><td class="east_border"></td><td class="east_border"></td><td></td><td></td><td></td><td  class="west_border"></td><td class="west_border"></td><td style="background:<?php echo $f12->wbg1; ?>;color:<?php echo $f12->wfc1; ?>;" class="team_pad_west"><?php echo $f12->wt1; ?></td><td>6</td></tr>
		         <tr><td></td><td></td><td class="east_border"></td><td class="east_border"></td><td></td><td></td><td></td><td  class="west_border"></td><td class="west_border"></td><td></td><td></td></tr>
		         <tr><td></td><td></td><td class="g_series" id="<?php echo $f13->et_id; ?>" style="border-right:2px solid #CCC;"><?php echo $f13->em1; ?></td><td style="background:<?php echo $f13->ebg1; ?>;color:<?php echo $f13->efc1; ?>;border-right:2px solid #CCC;" class="team_pad_east" style="border-right:2px solid #CCC;"><?php echo $f13->et1; ?></td><td></td><td></td><td ></td><td style="background:<?php echo $f13->wbg1; ?>;color:<?php echo $f13->wfc1; ?>;border-left:2px solid #CCC;" class="team_pad_west"><?php echo $f13->wt1; ?></td><td class="g_series" id="<?php echo $f13->wt_id; ?>" style="border-left:2px solid #CCC;"><?php echo $f13->wm1; ?></td><td></td><td></td></tr>
		         <tr><td></td><td></td><td class="east_border"></td><td></td><td></td><td></td><td></td><td></td><td class="west_border"></td><td></td><td></td></tr>
		         <tr><td>2</td><td style="background:<?php echo $f14->ebg1; ?>;color:<?php echo $f14->efc1; ?>;" class="team_pad_east"><?php echo $f14->et1; ?></td><td class="east_border"></td><td></td><td colspan="3" rowspan="3"><div id="playofflogo"></div></td><td></td><td class="west_border"></td><td style="background:<?php echo $f14->wbg1; ?>;color:<?php echo $f14->wfc1; ?>;" class="team_pad_west"><?php echo $f14->wt1; ?></td><td>2</td></tr>
		         <tr><td></td><td class="g_series" id="<?php echo $f15->et_id; ?>" style="border-right:2px solid #CCC;"><?php echo $f15->em1; ?></td><td style="background:<?php echo $f15->ebg1; ?>;color:<?php echo $f15->efc1; ?>;border-right:2px solid #CCC;" class="team_pad_east"><?php echo $f15->et1; ?></td><td></td><td></td><td style="background:<?php echo $f15->wbg1; ?>;color:<?php echo $f15->wfc1; ?>;border-left:2px solid #CCC;" class="team_pad_west"><?php echo $f15->wt1; ?></td><td class="g_series" id="<?php echo $f15->wt_id; ?>" style="border-left:2px solid #CCC;"><?php echo $f15->wm1; ?></td><td></td></tr>
		         <tr><td>7</td><td style="background:<?php echo $f16->ebg1; ?>;color:<?php echo $f16->efc1; ?>;" class="team_pad_east"><?php echo $f16->et1; ?></td><td></td><td></td><td></td><td></td><td style="background:<?php echo $f16->wbg1; ?>;color:<?php echo $f16->wfc1; ?>;" class="team_pad_west"><?php echo $f16->wt1; ?></td><td>7</td></tr>
		         <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			</table> 
<div id="series_recap" class="dialog" title="Playoff Series">
			<div id="match_up_detail"></div>
			<input type="hidden" id="idtoprocess"/>	
</div>