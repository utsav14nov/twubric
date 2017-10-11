# twubric
Teamie assignment for Twubric
I have used the Codeigniter Framework for the development.


I have deployed the code to heroku.
Following is the link : https://boiling-citadel-96590.herokuapp.com/

Used the Twitter oAuth api's for the authentication
Used get followers/list for extracting followers list and statuses/user_timeline for user's all tweets.


The code is structured in the following way:

	application/controllers/Auth.php          // Called the authentication api of the twitter.        
	application/controllers/Followers.php     // Called the follower's list api and the Twubric Calculation code.
	
	application/views/home_view.php 					// Application home view 
	application/views/followers_view.php      // Application Followers list pafge view
	
	application/libraries/Twitter.php         // Library functions to authenticate,get followers and user time line.
	
	
	
	
	
	Thanks
