<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Followers extends CI_controller{
    
	public function __construct(){
		parent::__construct();
        $this->load->library('twitter');
        $this->load->helper('url');

	}

	public function index(){

		$screenName = $this->session->userdata('access_token')['screen_name'];
		$result = $this->twitter->followers($screenName);
		$result = $result->users;
		$resultData = array();
  		foreach($result as $follower){
  			$follower = (array) $follower;
  			if (array_key_exists('status', $follower)){
				$status = $follower['status'];
  			}
  			
  			$dataArray = ["id" => $follower['id'],
  						"name" =>$follower['name'],
  						"screen_name" => $follower['screen_name'],
  						"followers_count" =>$follower['followers_count'],
  						"friends_count" => $follower['friends_count'],
  						"listed_count" => $follower['listed_count'],
  						"favourites_count" => $follower['favourites_count'],
  						"statuses_count" => $follower['statuses_count'],
  						"created_at" => $follower['created_at'],
  						"last_status_created" => isset($status) ? $status->created_at:0
  			];

  			array_push($resultData, $dataArray);
		}

		$data['resultData'] = $resultData;
		$this->load->view('followers_view',$data);
	}

	public function twubric(){

		$data = $_GET['data'];
		$screenName = $data['screen_name'];
		$followerCount = $data['followers_count'];
		$friendCount =$data['friends_count'];
		$listedCount = $data['listed_count'];
		$favoriteCount = $data['favourites_count'];
		$statusCount = $data['statuses_count'];
		$lastStatusCreated = $data['last_status_created'];

		if($followerCount == 0){
			$friendFollowerRatio = 0;
		}else{
			$friendFollowerRatio = $friendCount/$followerCount;
		}

		if($friendFollowerRatio >=2){
			$firendScore = 2;
		}elseif($friendFollowerRatio >=1.5){
			$firendScore = 1.5;
		}elseif($friendFollowerRatio >=1){
			$firendScore = 1;
		}elseif($friendFollowerRatio >=0.5){
			$firendScore = 0.5;
		}else{
			$firendScore = 0;
		}

		
		$result = $this->twitter->tweets($screenName);
		$totalTweetCount = 0;$totalRetweetCount=0;
		foreach($result as $tweet){
			$totalTweetCount += 1;
			$totalRetweetCount += $tweet->retweet_count;
		}

		if($totalTweetCount == 0){
			$influenceRatio = 0;
		}else{
			$influenceRatio = $totalRetweetCount/$totalTweetCount;
		}

		if($influenceRatio >=4){
			$influenceScore = 4;
		}elseif($influenceRatio >=3){
			$influenceScore = 3;
		}elseif($influenceRatio >=2){
			$influenceScore = 2;
		}elseif($influenceRatio >=1){
			$influenceScore = 1;
		}else{
			$influenceScore = 0;
		}		
		
		$lastStatusCreated = new DateTime(date("Y-m-d",strtotime($lastStatusCreated)));
		$now = new DateTime(Date('Y-m-d'));
		$diffDate = $lastStatusCreated->diff($now);
		$dayCount = $diffDate->d; 

		if($dayCount >=50){
			$chirpScore = 1;
		}elseif($dayCount >=25){
			$chirpScore = 2;
		}elseif($dayCount > 7){
			$chirpScore = 3;
		}else{
			$chirpScore = 4;
		}

		$totalScore = $firendScore+$influenceScore+$chirpScore;
		$data['twubric']['total'] = $totalScore;
		$data['twubric']['friends'] = $firendScore;
		$data['twubric']['influence'] = $influenceScore;
		$data['twubric']['chirpy'] = $chirpScore;

		print_r(json_encode($data));
	}
}



/* End of file Auth.php */