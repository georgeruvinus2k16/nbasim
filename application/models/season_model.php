<?php
	
	class Season_model extends CI_Model{
		
		//===Season model=====================
	    function get_seasons_list(){
	    	 	$this->db->select('a.id, a.season_yr,a.gamestoplay,CONCAT(b.cities," ",b.names) as east_champs,(SELECT x.seed FROM playoff_teams x WHERE x.team_id=a.eastchamp and x.pl_id=a.id) as eseed,CONCAT(c.cities," ",c.names) as west_champs,(SELECT y.seed FROM playoff_teams y WHERE y.team_id=a.westchamp and y.pl_id=a.id) as wseed,d.conf as champconf,(SELECT z.seed FROM playoff_teams z WHERE z.team_id=a.nbachamp and z.pl_id=a.id) as cseed,CONCAT(d.cities," ",d.names) as nba_champs,(SELECT h.nbafs FROM playoff_match h WHERE h.id=a.id and h.nbafc=a.nbachamp) as cseries',FALSE);
				$this->db->from('seasons a');
				$this->db->join('teams b', 'b.id = a.eastchamp', 'left');
				$this->db->join('teams c', 'c.id = a.westchamp', 'left');
				$this->db->join('teams d', 'd.id = a.nbachamp', 'left');
				$this->db->order_by("a.id","desc");
				$q = $this->db->get();
				if($q->num_rows() > 0){
					foreach($q->result() as $row){
						$data[] = $row;
					}
					return $data;
				}
	    }
	    function get_teams($conf){
	            $this->db->select('a.id,a.cities,a.names,a.bg_color,a.font_color,(SELECT count(f.id) as confcha FROM seasons f WHERE f.eastchamp=a.id or f.westchamp=a.id) as conf_titles,(SELECT count(r.id) as nbacha FROM seasons r WHERE r.nbachamp=a.id) as nba_titles,(SELECT count(g.pl_id) as plapp FROM playoff_teams g WHERE g.team_id=a.id) as pl_apps',FALSE);
				$this->db->from('teams a');
				$this->db->where('a.conf', $conf);
				$this->db->order_by("nba_titles","desc");
				$this->db->order_by("conf_titles","desc");
				$this->db->order_by("pl_apps","desc");
				$q = $this->db->get();
				if($q->num_rows() > 0){
					foreach($q->result() as $row){
						$data[] = $row;
					}
					return $data;
				}
	    }
	    function get_team_colors($team_id){
	    		$this->db->select('bg_color,font_color',FALSE);
				$this->db->from('teams');
				$this->db->where('id', $team_id);
				$q = $this->db->get();
				$e=$q->result();
					return $e[0];
			
	    }
	    function get_team_id($team_name){
	            $s=$this->db->query("SELECT id FROM teams WHERE CONCAT(cities,' ',names)='".$team_name."'");
	            $k=$s->result();
	            $team_id=$k[0]->id;
	            return $team_id;
	       
	    }
	    function get_team_championships($team_id){
	    		$q=$this->db->query("SELECT b.playoff_yr as pl_yr FROM playoff_match a LEFT JOIN playoff_head b ON b.id=a.pl_id WHERE a.nbafc=".$team_id."");
                if($q->num_rows() > 0){
					foreach($q->result() as $row){
						$data[] = $row;
					}
					return $data;
				}
	    }
	    function get_team_conf_championships($team_id){
	    		$q=$this->db->query("SELECT b.playoff_yr as pl_yr,(SELECT f.conf FROM teams f WHERE f.id=".$team_id.") as confee FROM playoff_match a LEFT JOIN playoff_head b ON b.id=a.pl_id WHERE a.ecp=".$team_id." or a.wcp=".$team_id."");
                if($q->num_rows() > 0){
					foreach($q->result() as $row){
						$data[] = $row;
					}
					return $data;
				}
	    }
	    function get_nbafinals_appearances($team_id){
	           $q=$this->db->query("SELECT count(pl_id) as nbafcnt FROM playoff_match WHERE ecp=".$team_id." or wcp=".$team_id."");
                if($q->num_rows() > 0){
					$r=$q->result(); 
					return $r[0]->nbafcnt;
				}
	    }
	    function get_playoff_appearances($team_id){
	            $q=$this->db->query("SELECT count(pl_id) as plapp FROM playoff_teams WHERE team_id=".$team_id."");
                if($q->num_rows() > 0){
					$r=$q->result(); 
					return $r[0]->plapp;
				}
	    }
	    function get_peryear($team_id){
	    		$q=$this->db->query("SELECT id,playoff_yr,season_id FROM playoff_head ORDER BY playoff_yr DESC");
	    		$str=array();
	    		foreach($q->result() as $row){
						    $j=$this->db->query("SELECT seed,record,finish FROM playoff_teams WHERE team_id=".$team_id." and pl_id=".$row->id."");    
					        if($j->num_rows() > 0){
					              $b=$j->result();
					              $str[]=$row->playoff_yr." - (".$b[0]->record.") regular season, clinched playoffs ".$this->misclib->getOrdinal($b[0]->seed)." seed, ".$b[0]->finish;
					        }else{
					        	 $j=$this->db->query("SELECT CONCAT(wins,'-',losses) as season_record FROM season_cards WHERE team_id=".$team_id." and season_id=".$row->season_id."");    
					             $b=$j->result();
					        	 $str[]=$row->playoff_yr." - (".$b[0]->season_record.") regular season, missed the playoffs";
					        }
				}
				return $str;
                
	    }
	    function is_done_season($season_id){
		        $this->db->select('id');
				$this->db->from('season_games');
				$this->db->where('season_id', $season_id);
				$q = $this->db->get();
				if($q->num_rows() > 0){
					return true;
				}else{
					$this->db->select('id');
					$this->db->from('playoff_head');
					$this->db->where('season_id', $season_id);
					$q = $this->db->get();
					if($q->num_rows() > 0){
						return true;
					}else{
						return false;
					}
				}
	    }
	    function get_season_standings($season_id,$conf,$stime){
	    	   $g=$this->db->query("SELECT id FROM seasons");
	    	   $prev_season_id=0;
	    	   if($g->num_rows() > 1){
	    	        $prev_season_id=$season_id-1;
	    	   }else{
	    	        $prev_season_id=$season_id;
	    	   }
	    	   
	    	   if($stime=='regular'){
	    	          $r=$this->db->query("SELECT a.wins,a.losses,a.team_rating,b.id,b.cities,b.names FROM season_cards a LEFT JOIN teams b ON b.id=a.team_id WHERE a.season_id=$season_id and b.conf='".$conf."' ORDER BY ((a.wins/82)*100) DESC");
			   }else{
	    	          $r=$this->db->query("SELECT a.wins,a.losses,a.team_rating as prev_team_rating,(SELECT l.team_rating FROM season_cards l WHERE l.team_id=a.team_id and l.season_id=".$season_id.") as team_rating,b.id,b.cities,b.names FROM season_cards a LEFT JOIN teams b ON b.id=a.team_id WHERE a.season_id=$prev_season_id and b.conf='".$conf."' ORDER BY ((a.wins/82)*100) DESC");
	           }
	    	   
	           if($r->num_rows() > 0){
					foreach($r->result() as $row){
						$data[] = $row;
					}
					return $data;
				}
	    }
	    function get_season_preview($season_id,$conf){
	           $r=$this->db->query("SELECT a.wins,a.losses,a.team_rating,b.id,b.cities,b.names FROM season_cards a LEFT JOIN teams b ON b.id=a.team_id WHERE a.season_id=$season_id and b.conf='".$conf."' ORDER BY a.team_rating DESC");
	    	   
	           if($r->num_rows() > 0){
					foreach($r->result() as $row){
						$data[] = $row;
					}
					return $data;
				}
	    }
	    function process_draft_lottery($season_id){
	    	    $g=$this->db->query("SELECT id FROM seasons");
	    	    $base_season_id=0;
	    	    if($g->num_rows() > 1){
	    	        $base_season_id=$season_id-1;
	    	    }else{
	    	        $base_season_id=$season_id;
	    	    }
	    		$r=$this->db->query("SELECT team_id,team_rating FROM season_cards WHERE season_id=$base_season_id ORDER BY ((wins/82)*100) LIMIT 10");
                $lotters=array();
                $draft_order=array();
                $draftees=array();
                if($r->num_rows() > 0){
                	$data=array();
					foreach($r->result() as $row){
						$lotters[] = $row->team_id;
					}
					$worst3=array_chunk($lotters, 3);
					$first3picks=$this->misclib->getTopPicks($worst3[0]);
					$toppicks=explode('*',$first3picks);
					$draft_order[]=$toppicks[0];
					$draft_order[]=$toppicks[1];
					$draft_order[]=$toppicks[2];
					for($f=3;$f<=9;$f++){
					     $draft_order[]=$lotters[$f];
					}
					foreach($draft_order as $df){
					   		 $r=$this->db->query("SELECT a.wins,a.losses,a.team_rating,a.draft,b.id,b.cities,b.names FROM season_cards a LEFT JOIN teams b ON b.id=a.team_id WHERE a.season_id=$season_id and a.team_id=".$df."");
							 $b=$r->result();
							 $data[]=$b[0];         
					}
					for($s=1;$s<=15;$s++){
					   $draftees[]=rand(65,90);
					}
					arsort($draftees);
					$ordered_picks=array();
					foreach($draftees as $g){
				         $ordered_picks[]=$g;
				    }
					$this->session->set_userdata('draftees',$ordered_picks);
					return $data;
				}
	    }
	    function make_season(){
	    		  $year=0;
		          $r=$this->db->query("SELECT season_yr FROM seasons ORDER BY id DESC LIMIT 1");
	              if($r->num_rows() > 0){
		              $row=$r->result();
		              $year=floatval($row[0]->season_yr)+1;
		          }else{
		              $year=1946;
		          }
		           
		          $this->db->query("INSERT INTO seasons(season_yr,gamestoplay)VALUES('$year','82')");
		          $last_id=$this->db->insert_id();
		          
		          $d=$this->db->query("SELECT id FROM seasons ORDER BY id DESC LIMIT 1,1");
		          if($d->num_rows() > 0){
		          	      $row=$d->result();
		          	      $last_season_id=$row[0]->id;
		          	      
		                  $c=$this->db->query("SELECT team_id,team_rating FROM season_cards WHERE season_id=$last_season_id");
		                  foreach($c->result() as $row2){
		                       $team_id=$row2->team_id;
		                       $team_rating=$row2->team_rating;
		                       $this->db->query("INSERT INTO season_cards(season_id,team_id,wins,losses,games_left,team_rating,draft)VALUES('$last_id','$team_id','0','0','0','$team_rating','0')");
						 }
		         }else{
		         	     for($s=1;$s<=30;$s++){
		         	     	$rand_rating=rand(69,90);
		                 	$this->db->query("INSERT INTO season_cards(season_id,team_id,wins,losses,games_left,team_rating,draft)VALUES('$last_id','$s','0','0','0','$rand_rating','0')");
		                 }
		         } 
	    	
	    }
	    function update_team_rating($id,$new_rating,$season_id){
	             $this->db->query("UPDATE season_cards SET team_rating='".$new_rating."' WHERE season_id=".$season_id." and team_id=".$id."");
	    }
	    function update_team_draft($id,$season_id,$draftpick){
	          	 $this->db->query("UPDATE season_cards SET draft='".$draftpick."' WHERE season_id=".$season_id." and team_id=".$id."");
		}
		function sign_draft_pick($id,$season_id){
		         $this->db->query("UPDATE season_cards SET team_rating=draft WHERE season_id=".$season_id." and team_id=".$id."");
		}
		function season_scheduler($games_sked,$last_id){
	    	
	             $this->plot58min_games($last_id);
	             $this->plotInterConference($last_id);
	             $this->plotVersusConference($last_id);
	             $this->plotOrderGames($last_id);
	    
	            
	    }
	    function plotOrderGames($last_id){
	    		$games=array();
	    		$c=$this->db->query("SELECT home_team,road_team FROM season_games WHERE season_id=$last_id");
	    		foreach($c->result() as $row){
	    		    $games[]=$row->home_team."*".$row->road_team;
	    		}
	    		$this->db->query("DELETE FROM season_games WHERE season_id=$last_id");
	    		shuffle($games);
	    		shuffle($games);
	    		shuffle($games);
	    		foreach($games as $f){
	    		      $d=explode('*',$f);
	    		      $home_t=$d[0];
	    		      $road_t=$d[1];
	    		      $this->db->query("INSERT INTO season_games(season_id,home_team,road_team)VALUES('$last_id','$home_t','$road_t')");
	    		}
	    }
	    function plot58min_games($last_id){
	    		for($s=1;$s<30;$s++){
	                  for($n=$s+1;$n<=30;$n++){
	                  		$this->db->query("INSERT INTO season_games(season_id,home_team,road_team)VALUES('$last_id','$s','$n')");
	                		$this->db->query("INSERT INTO season_games(season_id,home_team,road_team)VALUES('$last_id','$n','$s')");
	                        $this->db->query("UPDATE season_cards SET games_left=games_left+2 WHERE season_id=$last_id and team_id=$s");
	                        $this->db->query("UPDATE season_cards SET games_left=games_left+2 WHERE season_id=$last_id and team_id=$n");
	                  }
	            }
	    }
	    function plotInterConference($last_id){
	    		$east_con=array();
	    		$west_con=array();
	    		$v=$this->db->query("SELECT id,conf FROM teams");
	    		foreach($v->result() as $row){
	    			 if($row->conf=='east'){
	    			       $east_con[]=$row->id;
	    			 }else{
	    			       $west_con[]=$row->id;
	    			 }
	    		     
	    		}
	    		for($x=1;$x<=12;$x++){ //this is 12 because we need additional 24 games from the initial 58(versus all), so we need 12 games(versus conference) and 12games(versus other conference)
	    		    shuffle($east_con);
	    		    shuffle($west_con);
	    		    for($i=1;$i<=count($east_con)-2;$i+=2){
	    		          $ht=$east_con[$i];
	    		          $rt=$east_con[$i+1];
	    		          $this->db->query("INSERT INTO season_games(season_id,home_team,road_team)VALUES('$last_id','$ht','$rt')");
	    		          $this->db->query("UPDATE season_cards SET games_left=games_left+1 WHERE season_id=$last_id and team_id=$ht");
	                      $this->db->query("UPDATE season_cards SET games_left=games_left+1 WHERE season_id=$last_id and team_id=$rt");
	    		    }
	    		    for($i=1;$i<=count($west_con)-2;$i+=2){
	    		          $rt=$west_con[$i];
	    		          $ht=$west_con[$i+1];
	    		          $this->db->query("INSERT INTO season_games(season_id,home_team,road_team)VALUES('$last_id','$ht','$rt')");
	    		          $this->db->query("UPDATE season_cards SET games_left=games_left+1 WHERE season_id=$last_id and team_id=$ht");
	                      $this->db->query("UPDATE season_cards SET games_left=games_left+1 WHERE season_id=$last_id and team_id=$rt");
	    		    }
	    		    $ec=$east_con[0];
	    		    $wc=$west_con[0];
	    		    $eo=rand(1,2);
	    		    if($eo==1){
	    		            $this->db->query("INSERT INTO season_games(season_id,home_team,road_team)VALUES('$last_id','$ec','$wc')");
	    		    }else{
	    		            $this->db->query("INSERT INTO season_games(season_id,home_team,road_team)VALUES('$last_id','$wc','$ec')");
	    		    }
	    		    
	    		    $this->db->query("UPDATE season_cards SET games_left=games_left+1 WHERE season_id=$last_id and team_id=$ec");
	                $this->db->query("UPDATE season_cards SET games_left=games_left+1 WHERE season_id=$last_id and team_id=$wc");
	    		    
	    		}
	    		
	    }
	    function plotVersusConference($last_id){
	    		$east_con=array();
	    		$west_con=array();
	    		$z=$this->db->query("SELECT id,conf FROM teams");
	    		foreach($z->result() as $row){
	    			 if($row->conf=='east'){
	    			       $east_con[]=$row->id;
	    			 }else{
	    			       $west_con[]=$row->id;
	    			 }
	    		     
	    		}
	    		for($x=1;$x<=12;$x++){
	    		    shuffle($east_con);
	    		    shuffle($west_con);
	    		    for($j=0;$j<15;$j++){
	    		         $et=$east_con[$j];
	    		         $wt=$west_con[$j];
	    		         $eo=rand(1,2);
	    		         if($eo==1){
	    		            	$this->db->query("INSERT INTO season_games(season_id,home_team,road_team)VALUES('$last_id','$et','$wt')");
		    		    }else{
		    		            $this->db->query("INSERT INTO season_games(season_id,home_team,road_team)VALUES('$last_id','$wt','$et')");
		    		    }
		    		    
		    		    $this->db->query("UPDATE season_cards SET games_left=games_left+1 WHERE season_id=$last_id and team_id=$et");
		                $this->db->query("UPDATE season_cards SET games_left=games_left+1 WHERE season_id=$last_id and team_id=$wt");
	    		    }
	    		}
	    }
	    function runSeasonGames($season_id){
	             $r=$this->db->query("SELECT a.id,a.home_team,a.road_team,(SELECT b.team_rating as g FROM season_cards b where b.team_id=a.home_team and b.season_id=a.season_id) as hrating,(SELECT c.team_rating as h FROM season_cards c where c.team_id=a.road_team and c.season_id=a.season_id) as rrating FROM season_games a WHERE a.season_id=".$season_id."");
	             foreach($r->result() as $row){
	                  $mscores=array();
	                  $mscores=$this->misclib->seasons_clash($row->hrating,$row->rrating);
	                  
	                  if($mscores[0]>=$mscores[1]){
			    	            
			    	            $this->db->query("UPDATE season_games SET winner=$row->home_team WHERE id=$row->id");
			    	            $this->db->query("UPDATE season_cards SET wins=wins+1,games_left=games_left-1 WHERE team_id=$row->home_team and season_id=$season_id");
			    	            $this->db->query("UPDATE season_cards SET losses=losses+1,games_left=games_left-1 WHERE team_id=$row->road_team and season_id=$season_id");
			    	  }else{
			    	             
			    	            $this->db->query("UPDATE season_games SET winner=$row->road_team WHERE id=$row->id");
			    	            $this->db->query("UPDATE season_cards SET wins=wins+1,games_left=games_left-1 WHERE team_id=$row->road_team and season_id=$season_id");
			    	            $this->db->query("UPDATE season_cards SET losses=losses+1,games_left=games_left-1 WHERE team_id=$row->home_team and season_id=$season_id");
			    	  }
	             } 
	            
	    }
	    
	    function checkSeasonRunnable($season_id){
	        $r=$this->db->query("SELECT id FROM season_cards WHERE games_left>0 and season_id=".$season_id."");
	        if($r->num_rows() > 0){
	        		return true;
	        }else{
	        		return false;
	        }
	    }
	    function enlist_playoff_contenders($season_id){
	           $t=$this->db->query("SELECT season_yr FROM seasons WHERE id=$season_id");
	           $r=$t->result();
	           $plyr=floatval($r[0]->season_yr)+1;
	           $this->db->query("INSERT INTO playoff_head(playoff_yr,season_id)VALUES('$plyr','$season_id')");
	           $last_id=$this->db->insert_id();
	           $this->db->query("INSERT INTO playoff_match(pl_id)VALUES('$last_id')");
	           
	           //list the east contenders
	           $d=$this->db->query("SELECT team_id,wins,losses,team_rating FROM season_cards WHERE season_id=$season_id and team_id<16 ORDER BY ((wins/82)*100) DESC LIMIT 8");
	           $seed=1;
	           if($d->num_rows() > 0){
	           		foreach($d->result() as $row){
	           			      $record=$row->wins."-".$row->losses;
	           		          $this->db->query("INSERT INTO playoff_teams(pl_id,team_id,seed,record,rating)VALUES('$last_id','$row->team_id','$seed','$record','$row->team_rating')");
	           		          $team_pl_spot=$this->getPlayoffSpot($seed,$row->team_id);
	           		          $this->db->query("UPDATE playoff_match SET ".$team_pl_spot."='".$row->team_id."' WHERE pl_id=$last_id");
	           		    $seed++;
	           		}
	           }
	           //list the west contenders
	           $d=$this->db->query("SELECT team_id,wins,losses,team_rating FROM season_cards WHERE season_id=$season_id and team_id>15 ORDER BY ((wins/82)*100) DESC LIMIT 8");
	           $seed=1;
	           if($d->num_rows() > 0){
	           		foreach($d->result() as $row){
	           			      $record=$row->wins."-".$row->losses;
	           		          $this->db->query("INSERT INTO playoff_teams(pl_id,team_id,seed,record,rating)VALUES('$last_id','$row->team_id','$seed','$record','$row->team_rating')");
	           		          $team_pl_spot=$this->getPlayoffSpot($seed,$row->team_id);
	           		          $this->db->query("UPDATE playoff_match SET ".$team_pl_spot."='".$row->team_id."' WHERE pl_id=$last_id");
	           		    $seed++;
	           		}
	           }
	           //Now we put the firstrounders to their respective match_ups 
	           $m_codes=array('ea1','eb1','ec1','ed1','wa1','wb1','wc1','wd1');
	           foreach($m_codes as $q){
	                  $y=$this->db->query("SELECT ".$q."f as fteam,".$q."d as dteam FROM playoff_match WHERE pl_id=$last_id");
	                  $i=$y->result();
	                  $fteam=$i[0]->fteam;
	                  $dteam=$i[0]->dteam;
	                  $this->setMatchUp($last_id,$q,$fteam,$dteam);
	           } 
	           $m_up=array('esfa2','esfb2','wsfa2','wsfb2','esf','wsf','nbafs');
	           foreach($m_up as $q){
	                 $this->setMatchUp($last_id,$q,0,0);
	           } 
	           return $last_id;
	    }
	    function setMatchUp($pl_id,$mcode,$fteam,$dteam){
	           $this->db->query("INSERT INTO playoff_matchups(pl_id,match_code,fav,dog)VALUES('$pl_id','$mcode','$fteam','$dteam')");
	    }
	    function getPlayoffSpot($seed,$team_id){
	    	    $pl_spot="";
	    		switch($seed){
		            case 1: $pl_spot=($team_id<16) ? "ea1f" : "wa1f";
		                    break;
		            case 2: $pl_spot=($team_id<16) ? "ed1f" : "wd1f"; 
		                    break;
		            case 3: $pl_spot=($team_id<16) ? "ec1f" : "wc1f"; 
		                    break;
		            case 4: $pl_spot=($team_id<16) ? "eb1f" : "wb1f"; 
		                    break;
		            case 5: $pl_spot=($team_id<16) ? "eb1d" : "wb1d"; 
		                    break;
		            case 6: $pl_spot=($team_id<16) ? "ec1d" : "wc1d"; 
		                    break;
		            case 7: $pl_spot=($team_id<16) ? "ed1d" : "wd1d"; 
		                    break;
		            case 8: $pl_spot=($team_id<16) ? "ea1d" : "wa1d"; 
		                    break;
		         }
		         return $pl_spot;
	    }
	    function getPlayoff_picture($season_id){
	            $d=$this->db->query("SELECT id,playoff_yr FROM playoff_head WHERE season_id=$season_id");
	            if($d->num_rows() > 0){
	           		$e=$d->result(); 
	           		return $e[0]->id;
	           }else{
	           		return false;
	           }
	    }
	    function getPlayoff_year($pl_id){
	            $d=$this->db->query("SELECT playoff_yr FROM playoff_head WHERE id=$pl_id");
	            if($d->num_rows() > 0){
	           		$e=$d->result(); 
	           		return $e[0]->playoff_yr;
	           }else{
	           		return false;
	           }
	    }
	    function get_pl_row1($pl_id,$efield,$wfield){
	           $r=$this->db->query("SELECT a.pl_id,(SELECT b.cities as t FROM teams b WHERE b.id=a.".$efield.") as et1,(SELECT d.bg_color as t FROM teams d WHERE d.id=a.".$efield.") as ebg1,(SELECT e.font_color as t FROM teams e WHERE e.id=a.".$efield.") as efc1,(SELECT c.cities as t FROM teams c WHERE c.id=a.".$wfield.") as wt1,(SELECT f.bg_color as t FROM teams f WHERE f.id=a.".$wfield.") as wbg1,(SELECT g.font_color as t FROM teams g WHERE g.id=a.".$wfield.") as wfc1 FROM playoff_match a WHERE pl_id=$pl_id");
	           if($r->num_rows() > 0){
	           		$e=$r->result(); 
	           		return $e[0];
	           }
	    }
	    function get_pl_row2($pl_id,$erec,$wrec,$efield,$wfield){
	           $r=$this->db->query("SELECT a.pl_id,'".$erec."' as et_id,'".$wrec."' as wt_id,IFNULL(a.".$erec.",'0-0') as em1,IFNULL(a.".$wrec.",'0-0') as wm1,IFNULL((SELECT b.cities as t FROM teams b WHERE b.id=a.".$efield."),'-') as et1,IFNULL((SELECT d.bg_color as t FROM teams d WHERE d.id=a.".$efield."),'#CCFFFF') as ebg1,IFNULL((SELECT e.font_color as t FROM teams e WHERE e.id=a.".$efield."),'#000') as efc1,IFNULL((SELECT c.cities as t FROM teams c WHERE c.id=a.".$wfield."),'-') as wt1,IFNULL((SELECT f.bg_color as t FROM teams f WHERE f.id=a.".$wfield."),'#CCFFFF') as wbg1,IFNULL((SELECT g.font_color as t FROM teams g WHERE g.id=a.".$wfield."),'#000') as wfc1 FROM playoff_match a WHERE pl_id=$pl_id");
	           if($r->num_rows() > 0){
	           		$e=$r->result(); 
	           		return $e[0];
	           }
	    }
	    function get_pl_row3($pl_id){
	           $r=$this->db->query("SELECT a.pl_id,'nbafs' as fin_id,IFNULL(a.nbafs,'0-0') as nbafrec,IFNULL((SELECT b.cities as t FROM teams b WHERE b.id=a.nbafc),'-') as ct,IFNULL((SELECT d.bg_color as t FROM teams d WHERE d.id=a.nbafc),'#CCFFFF') as cbg,IFNULL((SELECT e.font_color as t FROM teams e WHERE e.id=a.nbafc),'#000') as cfc FROM playoff_match a WHERE pl_id=$pl_id");
	           if($r->num_rows() > 0){
	           		$e=$r->result(); 
	           		return $e[0];
	           }
	    }
	    function get_match_up_details($pl_id,$mcode){
	    	  if(strpos($mcode,"1")){
	              $pl_level=(substr($mcode,0,1)=='e') ? "EASTERN CONFERENCE 1ST ROUND":"WESTERN CONFERENCE 1ST ROUND";
	          }else if(strpos($mcode,"2")){
	          	  $pl_level=(substr($mcode,0,1)=='e') ? "EASTERN CONFERENCE SEMI-FINALS":"WESTERN CONFERENCE SEMI-FINALS";
	          }else if(strpos($mcode,"sf")){
	              $pl_level=(substr($mcode,0,1)=='e') ? "EASTERN CONFERENCE FINALS":"WESTERN CONFERENCE FINALS";
	          }else if($mcode=='nbafs'){
	              $pl_level="NBA FINALS";
	          }
	          $r=$this->db->query("SELECT IFNULL(matchups,'-') as matchups,(SELECT CONCAT(cities,' ',names) as g FROM teams WHERE id=fav) as favteam,(SELECT CONCAT(cities,' ',names) as g FROM teams WHERE id=dog) as dogteam,(SELECT g.rating FROM playoff_teams g WHERE g.team_id=fav and g.pl_id=$pl_id) as fav_rating,(SELECT b.seed FROM playoff_teams b WHERE b.team_id=fav and b.pl_id=$pl_id) as fav_seed,(SELECT s.seed FROM playoff_teams s WHERE s.team_id=dog and s.pl_id=$pl_id) as dog_seed,(SELECT o.rating FROM playoff_teams o WHERE o.team_id=dog and o.pl_id=$pl_id) as dog_rating,(SELECT k.record FROM playoff_teams k WHERE k.team_id=fav and k.pl_id=$pl_id) as favrec,(SELECT w.record FROM playoff_teams w WHERE w.team_id=dog and w.pl_id=$pl_id) as dogrec FROM playoff_matchups WHERE pl_id=".$pl_id." and match_code='".$mcode."'");
	          $e=$r->result();
	          $restr='<table cellpadding="3" cellspacing="0" border="0" id="matchup_table">';
	          $restr.='<tr><td colspan="8" style="text-align:center;">'.$pl_level.'</td></tr>';
	          $restr.='<tr><td colspan="5" style="text-align:center;">'.$this->misclib->getOrdinal($e[0]->fav_seed).' ('.$e[0]->fav_rating.')</td><td></td><td colspan="2" style="text-align:center;">'.$this->misclib->getOrdinal($e[0]->dog_seed).' ('.$e[0]->dog_rating.')</td></tr>';
	          $restr.='<tr><td colspan="5" style="text-align:center;font-weight:bold;">'.$e[0]->favteam.'</td><td style="text-align:center;font-weight:bold;">vs</td><td colspan="2" style="text-align:center;font-weight:bold;">'.$e[0]->dogteam.'</td></tr>';
	          $restr.='<tr><td colspan="5" style="text-align:center;font-size:10px;">'.$e[0]->favrec.'</td><td></td><td colspan="2" style="text-align:center;font-size:10px;">'.$e[0]->dogrec.'</td></tr>';
	          $h=$this->db->query("SELECT fav,dog FROM playoff_matchups WHERE pl_id=$pl_id and match_code='$mcode'");
			  $n=$h->result();
			  $fav_id=$n[0]->fav;
			  $dog_id=$n[0]->dog;
	          $h=$this->db->query("SELECT (SELECT COUNT(a.id) FROM season_games a WHERE (a.season_id=$pl_id and a.home_team=$fav_id and a.road_team=$dog_id and a.winner=$fav_id) or (a.season_id=$pl_id and a.home_team=$dog_id and a.road_team=$fav_id and a.winner=$fav_id)) as favi,(SELECT COUNT(a.id) FROM season_games a WHERE (a.season_id=$pl_id and a.home_team=$fav_id and a.road_team=$dog_id and a.winner=$dog_id) or (a.season_id=$pl_id and a.home_team=$dog_id and a.road_team=$fav_id and a.winner=$dog_id)) as dogi FROM teams LIMIT 1");
			  $n=$h->result();
	          $restr.='<tr><td colspan="8" style="text-align:center;font-size:11px;">Season series ('.$n[0]->favi.'-'.$n[0]->dogi.')</td></tr>';
	          $restr.='<tr><td colspan="5" style="height:5px;"></td><td></td><td colspan="2"></td></tr>';
	          $restr.='<tr style="color:#FFF;font-size:9px;font-weight:bold;background:#0099FF;"><td>Game #</td><td></td><td class="ctm">Away</td><td></td><td class="ctm">Home</td><td></td><td>Game result</td><td>Series</td></tr>';
	          $match_up_status="THE SERIES IS UNDER WAY 0-0";
	          $h=$this->db->query("SELECT (SELECT a.abbs FROM teams a LEFT JOIN playoff_matchups b ON b.fav=a.id WHERE b.pl_id=$pl_id and b.match_code='$mcode') as favi,(SELECT a.abbs FROM teams a LEFT JOIN playoff_matchups b ON b.dog=a.id WHERE b.pl_id=$pl_id and b.match_code='$mcode') as dog FROM teams LIMIT 1");
			  $n=$h->result();
	          if($e[0]->matchups!='-'){
	          	       $dv=explode('=',$e[0]->matchups);
	          	       $match_up_status=$dv[1];
	                   $dx=explode('*',$dv[0]);
	                   $cnt=1;
	                   $fav="";
	                   $dog="";
	                   $fav_win=0;
	                   $dog_win=0;
	                   foreach($dx as $rows){
	                   	     $restr.='<tr><td>Game '.$cnt.'</td><td style="width:5px;"></td>';
	                         $gm=explode('@',$rows);
	                         if($fav==""){
	                            $fav=trim($gm[1]);
	                            $dog=trim($gm[0]);
	                         }
	                         $fav_win=(trim($gm[2])==$fav) ? $fav_win+1 : $fav_win;
	                         $dog_win=(trim($gm[2])==$dog) ? $dog_win+1 : $dog_win;
	                         $restr.='<td class="ctm">'.$gm[0].'</td><td>@</td><td class="ctm">'.$gm[1].'</td><td style="width:5px;"></td><td>'.$gm[2].' '.str_replace('WINS','wins',$gm[3]).'</td><td>('.$fav_win.'-'.$dog_win.')</td>';
	                               
	                         $restr.='</tr>';
	                         $cnt++;      
	                   }
	                   if($fav_win<4 and $dog_win<4){
	                   	     $gw=($fav_win>$dog_win) ? $fav_win : $dog_win;
	                   	     $p=((4-$gw)+$cnt);
	                   	     while($cnt<=7){
	                   	     	 $res=($cnt>=$p) ? 'if necessary' : '-';
		                   	     $restr.='<tr><td>Game '.$cnt.'</td><td style="width:5px;"></td>';
		                   	     if($cnt==2 or $cnt==5 or $cnt==7){
		                   		 	$restr.='<td class="ctm">'.$n[0]->dog.'</td><td>@</td><td class="ctm">'.$n[0]->favi.'</td><td style="width:5px;"></td><td>'.$res.'</td><td>---</td>';
		                         }
		                         if($cnt==3 or $cnt==4 or $cnt==6){
		                   		 	$restr.='<td class="ctm">'.$n[0]->favi.'</td><td>@</td><td class="ctm">'.$n[0]->dog.'</td><td style="width:5px;"></td><td>'.$res.'</td><td>---</td>';
		                         }
		                         $restr.='</tr>';
		                         $cnt++;
	                         }
	                         
	                   }
	                   
	          }else{
	          	  
				  for($g=1;$g<=7;$g++){
				  	    $res=($g>4) ? 'if necessary' : '';
				  	    if($g==1 or $g==2 or $g==5 or $g==7){
				  	    	$restr.='<tr><td colspan="2">Game '.$g.'</td><td class="ctm">'.$n[0]->dog.'</td><td>@</td><td class="ctm">'.$n[0]->favi.'</td><td></td><td colspan="2">'.$res.'</td></tr>';
				  	    }
				  	    if($g==3 or $g==4 or $g==6){
				  	    	$restr.='<tr><td colspan="2">Game '.$g.'</td><td class="ctm">'.$n[0]->favi.'</td><td>@</td><td class="ctm">'.$n[0]->dog.'</td><td></td><td colspan="2">'.$res.'</td></tr>';
				  	    }
				  }
	              
	          }
	          $restr.='<tr><td colspan="8" style="text-align:center;padding-top:30px;">'.$match_up_status.'</td></tr>';
	          $restr.='</table>';
	          
	          return $restr;
	    }
	    function series_playable($pl_id,$mcode){
	          $t=$this->db->query("SELECT ".$mcode." as srec FROM playoff_match WHERE pl_id=$pl_id");
	          $e=$t->result();
	          $pos = strpos($e[0]->srec,'4');
	          if($pos === false){
	              return true;
	          }else{
	          	  return false;
	          }
	          
	    }
	    function play_series_game($pl_id,$mcode){
	    	  $t=$this->db->query("SELECT a.fav,a.dog,IFNULL(a.matchups,'=') as matchups,(SELECT b.rating FROM playoff_teams b WHERE b.pl_id=a.pl_id and b.team_id=a.fav) as fav_rating,(SELECT c.rating FROM playoff_teams c WHERE c.pl_id=a.pl_id and c.team_id=a.dog) as dog_rating,(SELECT abbs FROM teams WHERE id=a.fav) as fav_team,(SELECT abbs FROM teams WHERE id=a.dog) as dog_team FROM playoff_matchups a WHERE a.pl_id=".$pl_id." and a.match_code='".$mcode."'");
	          $e=$t->result();
	          $fav_id=$e[0]->fav;
	          $dog_id=$e[0]->dog;
	          $fav_rec=$e[0]->fav_rating;
	          $dog_rec=$e[0]->dog_rating;
	          $fav_team=$e[0]->fav_team;
	          $dog_team=$e[0]->dog_team;
	          $motools=explode('=',$e[0]->matchups);
	          $matchups=$motools[0];
	      
	          $f=$this->db->query("SELECT IFNULL(".$mcode.",'0-0') as csec FROM playoff_match WHERE pl_id=$pl_id");
	          $h=$f->result();
	          $r_ar=explode('-',$h[0]->csec);
	       
	          $fav_wins=floatval($r_ar[0]);
	          $dog_wins=floatval($r_ar[1]);
	          
	          $h_change=rand(1,3);
			  $r_change=rand(1,3);
			  if($h_change==1){
				  $change_type=array('b','g','b','g','b','g');
				  shuffle($change_type);
			      $change_amt=rand(1,5);
			      if($change_type[$change_amt]=='g'){
			            $fav_rec+=$change_amt;
			      }else{
			            $fav_rec-=$change_amt;
			      }
			  }
			  if($r_change==1){
				  $change_type=array('b','g','b','g','b','g');
				  shuffle($change_type);
			      $change_amt=rand(1,5);
			      if($change_type[$change_amt]=='g'){
			            $dog_rec+=$change_amt;
			      }else{
			            $dog_rec-=$change_amt;
			      }
			  }
	          
 	          $arrot=array(); 
	          $game_no=($fav_wins+$dog_wins)+1;
	          $res="";
	          //main clashes
	          if($game_no==3 or $game_no==4 or $game_no==6){
			      $arrot=$this->misclib->playoffs_clash($dog_rec,$fav_rec);
			      $res.=$fav_team."@".$dog_team."@";
			      $arrot[0]=($arrot[0]==$arrot[1]) ? $arrot[0]+1 : $arrot[0];
			      $res.=($arrot[0]>$arrot[1]) ? $dog_team."@WINS " : $fav_team."@WINS ";
			      if($arrot[0]>$arrot[1]){
			           $dog_wins+=1;
			      }else{
			           $fav_wins+=1;
			      }
			      
			}else{
				  $arrot=$this->misclib->playoffs_clash($fav_rec,$dog_rec);
				  $res.=$dog_team."@".$fav_team."@";
				  $arrot[0]=($arrot[0]==$arrot[1]) ? $arrot[0]+1 : $arrot[0];
			      $res.=($arrot[0]>$arrot[1]) ? $fav_team."@WINS " : $dog_team."@WINS ";
                  if($arrot[0]>$arrot[1]){
			           $fav_wins+=1;
			      }else{
			           $dog_wins+=1;
			      }
			}
			if($arrot[0]>$arrot[1]){
				$res.=$arrot[0]."-".$arrot[1];
			}else{
				$res.=$arrot[1]."-".$arrot[0];
			}
			if($fav_wins==4 or $dog_wins==4){ //when the winner of the series finally determined

			      $winner=($fav_wins==4) ? $fav_team." WINS SERIES ".$fav_wins."-".$dog_wins : $dog_team." WINS SERIES ".$dog_wins."-".$fav_wins;
			      $res.="=".$winner;
			      $winner=($fav_wins==4) ? $fav_id : $dog_id;
			      $loser=($fav_wins==4) ? $dog_id : $fav_id;
			      $winners_win=($winner==$fav_id) ? $fav_wins : $dog_wins;
			      $losers_win=($winner==$fav_id) ? $dog_wins : $fav_wins;
			      $won_spot=$this->getNextSpot($mcode);
			      
			      //we get the full name of the teams
			      $z=$this->db->query("SELECT a.pl_id,(SELECT CONCAT(b.cities,' ',b.names) as cf FROM teams b WHERE b.id=".$winner.") as wteam,(SELECT CONCAT(c.cities,' ',c.names) as cf FROM teams c WHERE c.id=".$loser.") as lteam FROM playoff_matchups a WHERE a.pl_id=".$pl_id." LIMIT 1");
				  $t=$z->result();
				  $winning_team=$t[0]->wteam;
				  $losing_team=$t[0]->lteam;
				  
			      //we set the losers ended round
			      $loser_ending=$this->getPlayoffRound($mcode);
			      $fintext="lose to the ".$winning_team." in the ".$loser_ending." (".$winners_win."-".$losers_win.")";
			      
			      
			      $this->db->query("UPDATE playoff_teams SET finish='".$fintext."' WHERE pl_id=".$pl_id." and team_id=".$loser."");
			      //we set the winner as contender for the next round
			      $this->db->query("UPDATE playoff_match SET ".$won_spot."='".$winner."' WHERE pl_id=".$pl_id."");
			      //we record the big winners
			      $o=$this->db->query("SELECT season_id FROM playoff_head WHERE id=".$pl_id."");
			      $s=$o->result();
			      $season_id=$s[0]->season_id;
			      if($won_spot=="ecp"){
			      		$this->db->query("UPDATE seasons SET eastchamp='".$winner."' WHERE id=".$season_id."");
			      }
			      if($won_spot=="wcp"){
			      		$this->db->query("UPDATE seasons SET westchamp='".$winner."' WHERE id=".$season_id."");
			      }
			      if($won_spot=="nbafc"){
			      		$this->db->query("UPDATE seasons SET nbachamp='".$winner."' WHERE id=".$season_id."");
			      		$total_games=$winners_win+$losers_win;
			      		$this->db->query("UPDATE playoff_teams SET finish='won the NBA Championship by beating the ".$losing_team." in ".$total_games." games' WHERE pl_id=".$pl_id." and team_id=".$winner."");
			      } 
			}else{
				  if($fav_wins>$dog_wins){
				     $res.="=".$fav_team." LEADS SERIES ".$fav_wins."-".$dog_wins;
				  }else if($dog_wins>$fav_wins){
				     $res.="=".$dog_team." LEADS SERIES ".$dog_wins."-".$fav_wins;
				  }else{
				     $res.="=SERIES TIED ".$fav_wins."-".$dog_wins;
				  }
			      
			}
			$new_series_standing=$fav_wins."-".$dog_wins;
			$match_txt=($matchups=='') ? $res."" : $matchups."*".$res;
			$this->db->query("UPDATE playoff_match SET ".$mcode."='".$new_series_standing."' WHERE pl_id=".$pl_id."");
			$this->db->query("UPDATE playoff_matchups SET matchups='".$match_txt."' WHERE match_code='".$mcode."' and pl_id=".$pl_id."");
	    }
	    function getNextSpot($mcode){
	    	  
	          if(strpos($mcode,"1")){
	              $nextspot=str_replace("1","2",$mcode);
	          }else if(strpos($mcode,"2")){
	          	  $nextspot=str_replace("2","",$mcode);
	          }else if(strpos($mcode,"sf")){
	              $nextspot=str_replace("sf","cp",$mcode);
	          }else if($mcode=='nbafs'){
	              $nextspot="nbafc";
	          }
	          return $nextspot;
	    	   
	    }
	    function getPlayoffRound($mcode){
	    	  
	          if(strpos($mcode,"1")){
	              $cur_round="1st round";
	          }else if(strpos($mcode,"2")){
	          	  $cur_round="2nd round";
	          }else if(strpos($mcode,"sf")){
	              $cur_round=(substr($mcode,0,1)=='e') ? "Eastern Conference Finals":"Western Conference Finals";
	          }else if($mcode=='nbafs'){
	              $cur_round="NBA Finals";
	          }
	          return $cur_round;
	    	   
	    }
	    function matchup_incomplete($pl_id,$mcode){
	    	$t=$this->db->query("SELECT fav,dog FROM playoff_matchups WHERE match_code='".$mcode."' and pl_id=".$pl_id."");
	    	$e=$t->result();
	    	if($e[0]->fav==0 or $e[0]->dog==0){
	    			return true;
	    	}else{
	    	        return false;
	    	}
	    }
	    function update_matchup($pl_id,$mcode){
	    	$cont1="";
	    	$cont2="";
	    	switch($mcode){
		            case 'esfa2': 
		                    $cont1="ea2";
	    					$cont2="eb2";
		                    break;
		            case 'esfb2':
		                    $cont1="ec2";
	    					$cont2="ed2";
		                    break;
		            case 'wsfa2': 
		                    $cont1="wa2";
	    					$cont2="wb2";
		                    break;
		            case 'wsfb2': 
		                    $cont1="wc2";
	    					$cont2="wd2";
		                    break;
		            case 'esf': 
		                    $cont1="esfa";
	    					$cont2="esfb";
		                    break;
		            case 'wsf': 
		                    $cont1="wsfa";
	    					$cont2="wsfb";
		                    break;
		            case 'nbafs': 
		                    $cont1="ecp";
	    					$cont2="wcp";
		                    break;
		      }
		      
		      $j=$this->db->query("SELECT IFNULL(".$cont1.",0) as c1,IFNULL(".$cont2.",0) as c2,(SELECT v.record FROM playoff_teams v WHERE v.team_id=".$cont1." and v.pl_id=$pl_id) as c1r,(SELECT f.record FROM playoff_teams f WHERE f.team_id=".$cont2." and f.pl_id=$pl_id) as c2r FROM playoff_match WHERE pl_id=$pl_id");
		      $g=$j->result();
		      $c1=$g[0]->c1;
		      $c2=$g[0]->c2;
		      $c1r=explode('-',$g[0]->c1r);
		      $c2r=explode('-',$g[0]->c2r);
		      $c1_r=(floatval($c1r[0])/82)*100;
		      $c2_r=(floatval($c2r[0])/82)*100;
		      if($c1!=0 and $c2!=0){
		         	$b=$this->db->query("SELECT a.pl_id,(SELECT b.seed FROM playoff_teams b WHERE b.pl_id=".$pl_id." and b.team_id=".$c1.") as c1_rating,(SELECT d.seed FROM playoff_teams d WHERE d.pl_id=".$pl_id." and d.team_id=".$c2.") as c2_rating FROM playoff_match a WHERE a.pl_id=".$pl_id."");
		            $w=$b->result();
		            
		            if(floatval($w[0]->c1_rating)<floatval($w[0]->c2_rating)){
		                        $this->db->query("UPDATE playoff_matchups SET fav='".$c1."',dog='".$c2."' WHERE pl_id=".$pl_id." and match_code='".$mcode."'");
		            }else if(floatval($w[0]->c2_rating)<floatval($w[0]->c1_rating)){
		            			$this->db->query("UPDATE playoff_matchups SET fav='".$c2."',dog='".$c1."' WHERE pl_id=".$pl_id." and match_code='".$mcode."'");
		            }else if(floatval($w[0]->c1_rating)==floatval($w[0]->c2_rating)){
		                    
		                    if($c1_r==$c2_r){
		                       $toss=rand(1,2);
		                       $fav=($toss==1) ? $c1 : $c2;
		                       $dog=($toss==1) ? $c2 : $c1;
		                    }else{
		                       $fav=($c1_r>$c2_r) ? $c1 : $c2;
		                   	   $dog=($c1_r>$c2_r) ? $c2 : $c1;
		                    }
		                    $this->db->query("UPDATE playoff_matchups SET fav='".$fav."',dog='".$dog."' WHERE pl_id=".$pl_id." and match_code='".$mcode."'");

		            
		            }
		      }
	    }
	    
	}
?>