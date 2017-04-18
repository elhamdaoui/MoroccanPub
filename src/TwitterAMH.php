<?php

include_once './tools.php';
include_once './TwitterAPIExchange.php';
?>
<?php

class TwitterAMH {

    protected $author = "Elhamdaoui Abdelmajid";
    public $settings = array(
        'oauth_access_token' => "",
        'oauth_access_token_secret' => "",
        'consumer_key' => "",
        'consumer_secret' => ""
    );

    /** Twitter app* */
    public $twitter_app = null;

    /** Method * */
    public $method = null;

    /** urls * */
    public $urls = null;

    /** response * */
    public $response = "No thing";

    /**
     * 
     */
    public function TwitterAMH() {
        
    }

    /**
     * 
     * @param type $new_method
     */
    public function _init($new_method) {
        $this->urls = array(
            'blocks_create' => "https://api.twitter.com/1.1/blocks/create.json",
            'status_update' => "https://api.twitter.com/1.1/statuses/update.json",
            'followers_ids' => "https://api.twitter.com/1.1/followers/ids.json",
            'status_show' => "https://api.twitter.com/1.1/statuses/show.json",
            'status_destroy' => "https://api.twitter.com/1.1/statuses/destroy/",
        );

        $this->method = $new_method;
        $this->twitter_app = new TwitterAPIExchange($this->settings);
    }

    /**
     * Pulish a status in twitter
     */
    public function publish($status) {
        $postfields = array(
            'status' => $status,
        );
        $this->response = $this->twitter_app->buildOauth($this->urls['status_update'], $this->method)
                ->setPostfields($postfields)
                ->performRequest();
    }

    /**
     * Get tweet by id
     * @param type $id
     */
    public function get_tweet_by_id($id) {
        $getfield = "?id=".$id;
        $this->response = $this->twitter_app->setGetfield($getfield)
                ->buildOauth($this->urls['status_show'], $this->method)
                ->performRequest();
    }

    /**
     * delete a tweet in twitter
     */
    public function delete($id) {
        $postfields = array(
            'id' => "$id",
        );
        $url=$this->urls['status_destroy']."$id.json";
        echo "<script>alert('$url');</script>";
        $this->response = $this->twitter_app->buildOauth($url, $this->method)
                ->setPostfields($postfields)
                ->performRequest();
    }

    /**
     * Show the response 
     */
    public function show_twitter() {
        /* echo "<table class='table'>";
          foreach($this->response as $key => $value)
          echo "<tr><td>".$key."</td><td><label class='alert alert-info'>".$value."</label></td></tr>";
          echo "</table>"; */
        echo "<p class='alert alert-info'>" . $this->response . "</p>";
    }

    /**
     * get the response 
     */
    public function get_response_array() {
        return json_decode($this->response, $assoc = true);
    }

    /**
     * 
     * @param type $bdd
     */
    public function store_id_bdd() {
        global $bdd;
        try {
            $id_user = $_SESSION['id'];
            $pub = $this->get_response_array();
            $statment = "insert into publications(id,user_app_id) values(:id,:user_id)";
            $result = $bdd->prepare($statment);
            $result->execute(array('id' => $pub['id_str'], 'user_id' => $id_user));
            return true;
        } catch (Exception $e) {
            return false;
        }
        return false;
    }

}
