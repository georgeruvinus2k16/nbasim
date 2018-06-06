<script>
	$(function(){
			$( "#start_new_season" ).click(function( event ) {
			   		location.href="<?php echo site_url('/f_main/create_new_season/'); ?>";
			});
			$( "#view_all_teams" ).click(function( event ) {
			   		location.href="<?php echo site_url('/f_main/allteams/'); ?>";
			});
    });
</script>
</head>
<body>
	<?php $ewin=0;$wwin=0; 
	  if(isset($season_rows)): foreach($season_rows as $row): 
	      if($row->champconf=='east'){
	           $ewin++;
	      }
	      if($row->champconf=='west'){
	           $wwin++;
	      }
	  endforeach;
	  endif;
    ?>
	<table cellpadding="5" cellspacing="0" border="0" id="seasons_list_table">
	  <tr><td colspan="9"><input type="button" value="Start new Season" id="start_new_season"/><input type="button" value="View Teams" id="view_all_teams"/></td></tr>
	  <tr id="headrow"><th>SEASON</th><th>YEAR</th><th style="text-align:left;padding-left:25px;" colspan="2">WEST CHAMPIONS</th><th style="width:50px;"></th><th style="text-align:left;padding-left:25px;" colspan="2">EAST CHAMPIONS</th><th style="width:100px;text-align:center;">SERIES</th><th style="text-align:left;padding-left:25px;" colspan="2">NBA CHAMPIONS</th><th style="text-align:center;"><?php echo $wwin.'-'.$ewin; ?></th></tr>
<?php if(isset($season_rows)): foreach($season_rows as $row): ?> 
<?php if($row->nba_champs){
	        $cs=explode('-',$row->cseries);
            $chs=(intval($cs[0])>intval($cs[1])) ? $cs[0]."-".$cs[1] : $cs[1]."-".$cs[0];
    }else{
            $chs="0-0";
    }
 ?>
	  <tr><td><?php echo anchor('f_main/season/'.$row->id, $row->id); ?></td><td><?php echo $row->season_yr; ?></td><td><?php echo $row->west_champs; ?></td><td style="padding:0;font-size:9px;color:#999;"><?php echo '('.$this->misclib->getOrdinal($row->wseed).')'; ?></td><td></td><td><?php echo $row->east_champs; ?></td><td style="padding:0;font-size:9px;color:#999;"><?php echo '('.$this->misclib->getOrdinal($row->eseed).')'; ?></td><td style="text-align:center;"><?php echo $chs; ?></td><td><?php echo $row->nba_champs; ?></td><td style="padding:0;font-size:9px;color:#999;"><?php echo '('.$this->misclib->getOrdinal($row->cseed).')'; ?></td><td style="text-align:center;"><?php echo strtoupper($row->champconf); ?></td></tr>
<?php
 	  endforeach;
	  endif; 
?>
   </table>