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
<body id="<?php echo 'por'; ?>">
		<table cellpadding="0" cellspacing="0" border="0" id="team_rafter">
	        <tr><td id="team_name"><?php echo trim(str_replace('%20',' ',$this->uri->segment(3)))." "; ?></td></tr>
	        <tr><td style="border-top:1px solid #999;" valign="top"><table cellpadding="0" cellspacing="15" border="0" class="arena_rafter">
	                <?php $i=1; if(isset($championship_yrs)): foreach($championship_yrs as $row): ?>
	                              <?php if($i==1){ echo '<tr>';} ?>
	                              <td style="background:<?php echo $tc->bg_color; ?>"><div class="trophy_img"></div>
	                              	  <div class="champ_year" style="color:<?php echo $tc->font_color; ?>"><?php echo $row->pl_yr; ?></div>
	                              </td>	  
	                              <?php  /*     in the future if you want to change the designs of banners, all you have to change is the
	                              	            structure of that <td></td> above, it will have to appear like below.
	                                            if($row->pl_yr<=2000){
	                              						<td style="background:<?php echo $tc->bg_color; ?>"><div class="trophy_img"></div>
							                              	  <div class="champ_year" style="color:<?php echo $tc->font_color; ?>"><?php echo $row->pl_yr; ?></div>
							                             </td>
	                              				}else if($row->pl_yr<=2015){
	                              						 <td style="background:<?php echo $tc->bg_color; ?>"><div class="trophy_img"></div>
							                              	  <div class="champ_year" style="color:<?php echo $tc->font_color; ?>"><?php echo $row->pl_yr; ?></div>
							                             </td>
	                              				}
	                              	  
	                              	     */
	                               ?>  
	                               <?php if($i==10){ echo '</tr>'; $i=0; } ?>	   
					<?php $i++; 
					 	 endforeach;
						 endif; 
					 ?>
					 </table>
				</td>
			</tr>
			<tr><td style="border-top:1px solid #999;"><table cellpadding="0" cellspacing="15" border="0" class="arena_rafter">
	                <?php $i=1; if(isset($conf_champ_yrs)): foreach($conf_champ_yrs as $row): ?>
	                              <?php if($i==1){ echo '<tr>';} ?>
	                              <td style="background:<?php echo ($row->confee=='east') ? '#3366FF':'#FF0033'; ?>;padding:4px;"><div class="conf_champ_img"><?php echo 'NBA </br>'.ucfirst($row->confee).'ern Conference </br></br>CHAMPIONS'; ?></div>
	                              	  <div class="champ_year" style="color:#FFFFFF;"><?php echo $row->pl_yr; ?></div>
	                              </td>	  
	                               <?php if($i==10){ echo '</tr>'; $i=0; } ?>	   
					<?php $i++; 
					 	 endforeach;
						 endif; 
					 ?>
					 </table>
				</td>
			</tr>			 
			<tr><td class="team_history" style="border-top:1px solid #999;"><?php  if(isset($championship_yrs)): ?>
							<?php echo count($championship_yrs)." NBA Championships "; ?>
					<?php 
						   endif; 
					 ?>
				</td>
			</tr>			 
			<tr><td class="team_history"><?php  if(isset($nbaf_app)): ?>
							<?php echo $nbaf_app." NBA Finals appearances"; ?>
					<?php 
						   endif; 
					 ?>
				</td>
			</tr>
			<tr><td class="team_history"><?php  if(isset($pl_app)): ?>
							<?php echo $pl_app." Playoffs appearances"; ?>
					<?php 
						   endif; 
					 ?>
				</td>
			</tr>
			<tr><td style="border-top:1px solid #999;">  <table cellpadding="0" cellspacing="0" border="0">
					         <?php $i=1; if(isset($peryear)): foreach($peryear as $row): ?>
								<tr><td  class="team_history"><?php echo $row; ?></td></tr>
							<?php $i++;
							 	  endforeach;
								  endif; 
							 ?>  
					  </table>
				</td>
			</tr>			 			 			 
	    </table>	
