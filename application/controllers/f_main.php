<?php
      class F_main extends CI_Controller{
      	
      		function __construct(){
				parent::__construct();
				define('HEADERCAP','RASMUS');
			}
			
			function index(){
					$data = array();
					if($query = $this->season_model->get_seasons_list()){
						$data['season_rows'] = $query;
					}
					$data['main_content'] = 'homee';
					$this->load->view('includes/midtemp',$data);
			}
			function allteams(){
					$data = array();
					if($query = $this->season_model->get_teams('east')){
						$data['easteams'] = $query;
					}
					if($query = $this->season_model->get_teams('west')){
						$data['westeams'] = $query;
					}
					$data['main_content'] = 'allteams';
					$this->load->view('includes/midtemp',$data);
			}
			function team(){
				    $team_name=trim(str_replace('%20',' ',$this->uri->segment(3)));
				    $team_id = $this->season_model->get_team_id($team_name);
				    if($query = $this->season_model->get_team_colors($team_id)){
						$data['tc'] = $query;
					}
					$data['championship_yrs']=array();
				    if($query = $this->season_model->get_team_championships($team_id)){
						$data['championship_yrs'] = $query;
					}
					$data['conf_champ_yrs']=array();
				    if($query = $this->season_model->get_team_conf_championships($team_id)){
						$data['conf_champ_yrs'] = $query;
					}
					$data['nbaf_app']=0;
					if($query = $this->season_model->get_nbafinals_appearances($team_id)){
						$data['nbaf_app'] = $query;
					}
					$data['pl_app']=0;
					if($query = $this->season_model->get_playoff_appearances($team_id)){
						$data['pl_app'] = $query;
					}
					if($query = $this->season_model->get_peryear($team_id)){
						$data['peryear'] = $query;
					}
					
					
			        $data['main_content'] = 'teampage';
					$this->load->view('includes/midtemp',$data);
			}
			function tester(){
				
					$data['main_content'] = 'tester';
					$this->load->view('includes/midtemp',$data);
			}
			function create_new_season(){
			        $this->season_model->make_season();
			        redirect('f_main/index');
			}
			function season(){
				    if($this->season_model->is_done_season($this->uri->segment(3))){
				           $data['season_time']='regular';
				           if($query = $this->season_model->get_season_standings($this->uri->segment(3),'east','regular')){
								$data['eastcon'] = $query;
						   }
						   if($query = $this->season_model->get_season_standings($this->uri->segment(3),'west','regular')){
										$data['westcon'] = $query;
						   } 
				    }else{
				           $data['season_time']='offseason';
				           if($query = $this->season_model->get_season_standings($this->uri->segment(3),'east','offseason')){
								$data['eastcon'] = $query;
						   }
						   if($query = $this->season_model->get_season_standings($this->uri->segment(3),'west','offseason')){
										$data['westcon'] = $query;
						   }
				    }
				    
			        $data['main_content'] = 'season_detail';
					$this->load->view('includes/midtemp',$data);
			}
			function draft_day(){
				    if($query = $this->season_model->process_draft_lottery($this->uri->segment(3))){
								$data['nbateams'] = $query;
					} 
			        $data['main_content'] = 'draft_detail';
					$this->load->view('includes/midtemp',$data);
			}
			function keepcore(){
			        $id=$this->input->post('id');
			        $rating=floatval($this->input->post('rating'));
			        $new_rating=rand(($rating-5),($rating+5));
			        if($new_rating>99){
			           $new_rating=rand(($rating-10),99);    
			        }
			        $this->season_model->update_team_rating($id,$new_rating,$this->input->post('season_id'));
			        echo $new_rating;
			}
			function rebuild(){
			        $id=$this->input->post('id');
			        $rating=floatval($this->input->post('rating'));
			        $new_rating=rand(69,82);
			        $this->season_model->update_team_rating($id,$new_rating,$this->input->post('season_id'));
			        echo $new_rating;
			}
			function pick_from_draft(){
			        $id=$this->input->post('id');
			        $season_id=$this->input->post('season_id');
			        $draftees=$this->session->userdata('draftees');
			        $draftpick=$draftees[0];
			        
			        array_shift($draftees);
			        $this->session->set_userdata('draftees',$draftees);
			        $this->season_model->update_team_draft($id,$season_id,$draftpick);
			        echo $draftpick;
			}
			function sign_pick(){
			        $this->season_model->sign_draft_pick($this->input->post('id'),$this->input->post('season_id'));
			        echo "signed";
			}
			function set_season_schedule(){
			        $this->season_model->season_scheduler(82,$this->uri->segment(3));
			        redirect('f_main/team_previews/'.$this->uri->segment(3));
			}
			function team_previews(){
			        if($query = $this->season_model->get_season_preview($this->uri->segment(3),'east')){
								$data['eastcon'] = $query;
					}
					if($query = $this->season_model->get_season_preview($this->uri->segment(3),'west')){
								$data['westcon'] = $query;
					} 
			        $data['main_content'] = 'season_preview';
					$this->load->view('includes/midtemp',$data);
			}
			function run_season(){
				  if($this->season_model->checkSeasonRunnable($this->input->post('season_id'))){
					  $this->season_model->runSeasonGames($this->input->post('season_id'));
					  echo "success";
				  }else{
				  	   echo "This season is over";
				  }
			       
			}
			function enlist_playoff_contenders(){
				if($pl_id=$this->season_model->getPlayoff_picture($this->uri->segment(3))){
				      
				}else{
					$pl_id=$this->season_model->enlist_playoff_contenders($this->uri->segment(3));
				}
			 	redirect('f_main/playoff_picture/'.$pl_id); 
			}
			function playoff_picture(){
				if($query = $this->season_model->getPlayoff_year($this->uri->segment(3))){
								$data['playoff_year'] = $query;
				}
				if($f1 = $this->season_model->get_pl_row1($this->uri->segment(3),'wa1f','ea1f')){
								$data['f1'] = $f1;
				}
				if($f2 = $this->season_model->get_pl_row2($this->uri->segment(3),'wa1','ea1','wa2','ea2')){
								$data['f2'] = $f2;
				}
				if($f3 = $this->season_model->get_pl_row1($this->uri->segment(3),'wa1d','ea1d')){
								$data['f3'] = $f3;
				}
				if($f4 = $this->season_model->get_pl_row2($this->uri->segment(3),'wsfa2','esfa2','wsfa','esfa')){
								$data['f4'] = $f4;
				}
				if($f5 = $this->season_model->get_pl_row1($this->uri->segment(3),'wb1f','eb1f')){
								$data['f5'] = $f5;
				}
				if($f6 = $this->season_model->get_pl_row2($this->uri->segment(3),'wb1','eb1','wb2','eb2')){
								$data['f6'] = $f6;
				}
				if($f7 = $this->season_model->get_pl_row1($this->uri->segment(3),'wb1d','eb1d')){
								$data['f7'] = $f7;
				}
				if($f8 = $this->season_model->get_pl_row3($this->uri->segment(3))){
								$data['f8'] = $f8;
				}
				if($f9 = $this->season_model->get_pl_row2($this->uri->segment(3),'wsf','esf','wcp','ecp')){
								$data['f9'] = $f9;
				}
				if($f10 = $this->season_model->get_pl_row1($this->uri->segment(3),'wc1f','ec1f')){
								$data['f10'] = $f10;
				}
				if($f11 = $this->season_model->get_pl_row2($this->uri->segment(3),'wc1','ec1','wc2','ec2')){
								$data['f11'] = $f11;
				}
				if($f12 = $this->season_model->get_pl_row1($this->uri->segment(3),'wc1d','ec1d')){
								$data['f12'] = $f12;
				}
				if($f13 = $this->season_model->get_pl_row2($this->uri->segment(3),'wsfb2','esfb2','wsfb','esfb')){
								$data['f13'] = $f13;
				}
				if($f14 = $this->season_model->get_pl_row1($this->uri->segment(3),'wd1f','ed1f')){
								$data['f14'] = $f14;
				}
				if($f15 = $this->season_model->get_pl_row2($this->uri->segment(3),'wd1','ed1','wd2','ed2')){
								$data['f15'] = $f15;
				}
				if($f16 = $this->season_model->get_pl_row1($this->uri->segment(3),'wd1d','ed1d')){
								$data['f16'] = $f16;
				}
				
				$data['main_content'] = 'playoff_stage';
				$this->load->view('includes/midtemp',$data);
			}
			function get_match_up_run(){
				if($this->season_model->matchup_incomplete($this->input->post('pl_id'),$this->input->post('mcode'))){
						$this->season_model->update_matchup($this->input->post('pl_id'),$this->input->post('mcode'));
				}
			    $disp=$this->season_model->get_match_up_details($this->input->post('pl_id'),$this->input->post('mcode'));
			    echo $disp;
			}
			function playseries(){
			    if($this->season_model->series_playable($this->input->post('pl_id'),$this->input->post('mcode'))){
			    	   $this->season_model->play_series_game($this->input->post('pl_id'),$this->input->post('mcode'));
			           $disp=$this->season_model->get_match_up_details($this->input->post('pl_id'),$this->input->post('mcode'));
			           echo $disp;   
			    }else{
			       echo "over";
			    }
			}
		
      }
?>
