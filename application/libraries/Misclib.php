<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Misclib {
   
    public function __construct(){
       
    }
   
	public function getTopPicks($toparr){
		$lot_chances=array(25,15,5);
		$chancery=array();
		$key=0;
		for($v=0;$v<3;$v++){
			   
		       for($f=1;$f<=$lot_chances[$key];$f++){
		          $chancery[]=$toparr[$v];
		       }
		       $key++;
		}
		shuffle($chancery);
		$dpick=array_rand($chancery,2);
		$first_pick = $chancery[$dpick[0]];
		
		$next_two_arr=array();
		foreach($toparr as $rem){
		   if($rem!=$first_pick)
		   	   $next_two_arr[]=$rem;
		}
		$v=rand(1,2);
		$second_pick=($v==1) ? $next_two_arr[0] : $next_two_arr[1];
		$third_pick=($second_pick==$next_two_arr[0]) ? $next_two_arr[1] : $next_two_arr[0];
		
		return $first_pick."*".$second_pick."*".$third_pick; 
	}
	function seasons_clash($ht_r,$rt_r){
	             
	    	     $court_adv=array('Y','Y','Y','N','N');
	    	     shuffle($court_adv);
	    	     $a=rand(0,4);
	    	     $adv=$court_adv[$a];
	    	     if($adv=='Y'){
	    	             $ht_score=rand($ht_r,($ht_r+10));
	    	     }else{
	    	             $ht_score=rand(($ht_r-10),($ht_r+10));
	    	     }
	    	     $rt_score=rand(($rt_r-10),($rt_r+10));
	    	     //miracle shot chances it will take the N of the $court_adv which is 2/5 % chance to happen this gives the super underdog team a very little chance to win against powerhouse teams
	    	     shuffle($court_adv);
	    	     $h=rand(0,2);
	    	     $r=rand(0,2);
	    	     $h_msm=$court_adv[$h];
	    	     $r_msm=$court_adv[$r];
	    	     if($h_msm=='N'){
	    	          $miracle_score=rand(11,15);
	    	          $ht_score=$ht_score+$miracle_score;
	    	     }
	    	     if($r_msm=='N'){
	    	          $miracle_score=rand(11,15);
	    	          $rt_score=$rt_score+$miracle_score;
	    	     }	 
	    	     $match_scores=array();
	    	     $match_scores[]=$ht_score;
	    	     $match_scores[]=$rt_score;       
	    	     
	    	     return $match_scores;
	}
	function playoffs_clash($ht_r,$rt_r){
	             
	    	     $court_adv=array('Y','Y','Y','N','N');
	    	     shuffle($court_adv);
	    	     $a=rand(0,4);
	    	     $b=rand(0,4);
	    	     $adv=$court_adv[$a];
	    	     $dadv=$court_adv[$b];
	    	     if($adv=='Y'){
	    	             $ht_score=rand($ht_r,($ht_r+10));
	    	     }else{
	    	             $ht_score=rand(($ht_r-10),($ht_r+10));
	    	     }
	    	     if($dadv=='Y'){
	    	     	     $rt_score=rand(($rt_r-10),($rt_r+5));
	    	             
	    	     }else{
	    	             $rt_score=rand(($rt_r-10),($rt_r+10));
	    	     }
	    	     //miracle shot chances it will take the N of the $court_adv which is 2/5 % chance to happen this gives the super underdog team a very little chance to win against powerhouse teams
	    	     shuffle($court_adv);
	    	     $h=rand(0,3);
	    	     $r=rand(0,3);
	    	     $h_msm=$court_adv[$h];
	    	     $r_msm=$court_adv[$r];
	    	     if($h_msm=='N'){
	    	     	  $miracle_score=rand(11,15);
	    	          $ht_score=$ht_score+$miracle_score;
	    	     }
	    	     if($r_msm=='N'){
	    	     	  $miracle_score=rand(11,15);
	    	          $rt_score=$rt_score+$miracle_score;
	    	     }	 
	    	     $match_scores=array();
	    	     $match_scores[]=$ht_score;
	    	     $match_scores[]=$rt_score;       
	    	     
	    	     return $match_scores;
	}
	function grz($cnt,$disc){
	    if($cnt>1){
	         return $cnt." ".$disc."s";
	    }else{
	         return $cnt." ".$disc;
	    }
	}
	function getOrdinal($rf){
         $rank="";
         $sto=$rf%10;
         switch($sto){
            case 1: 
                    $rank=$rf."st";
                    break;
            case 2:
                    $rank=$rf."nd";
                    break;
            case 3: 
                    $rank=$rf."rd";
                    break;
            case 4: 
                    $rank=$rf."th";
                    break;
            case 5: 
                    $rank=$rf."th";
                    break;
            case 6: 
                    $rank=$rf."th";
                    break;
            case 7: 
                    $rank=$rf."th";
                    break;
            case 8: 
                    $rank=$rf."th";
                    break;
            case 0:
                    $rank=$rf."th";
                    break;	    
         }
         return $rank;
    }
}



/* End of file Misclib.php */