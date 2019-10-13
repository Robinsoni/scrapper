<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
/* require('simplehtmldom_1_9/simple_html_dom.php'); */
include_once('simplehtmldom_1_9/simple_html_dom.php');
include('simplehtmldom_1_9/httpful.phar');
class HomeController extends Controller
{
	
	Public function index(Request $response){
		// echo 'hi';exit;
		$formInput = $response->input();
		// echo '<pre>';print_r($formInput);echo 'LINE'.__LINE__;exit;
		// $domain = 'www.travelfx.co.uk';
		// $domain = 'www.sportscheck.com';
		$domain = $formInput['domain'];
		if(!$domain){
			return Redirect::back()->withMessage('message','Please Enter the Domain name');
		}
		/* $url ='https://www.trustpilot.com/review/'.$domain;
		$url = 'https://www.trustedshops.de/shops/?q='.$domain; */
		$url ='https://www.trustpilot.com/review/'.$domain;
		// $trustedShop = $this->trustedShop($url);
		
		$return['trusPilot'] = $this->trustpilot($url);
		$return['trusPilot']['domain'] = $domain;
		return view('home',['result'=>$return]);
		
	}
	
	
	public function trustpilot($url){
		$html = file_get_html($url);
		
		$title = $html->find('meta[property="og:title"]', 0)->content;
		$score=$this->scrape_between('with', 'on',$title);
		 /* echo '<pre>';print_r($score);echo 'LINE__'.__LINE__;exit;  */
		
		$ret['img'] = $html->find('img[class="business-unit-profile-summary__image"]', 0)->src;
		
		
		$doms = file_get_contents($url);
		
		preg_match('!<script type="application/json" data-initial-state="business-unit-info">(.*?)</script>!is',$doms,$apario);
	   $trustScore = json_decode($apario[1],true);
	   $ret['rating']['trustScore'] = $score;
		
		
		preg_match('!<div class="star-rating ">(.*?)</div>!is',$doms,$apario);
		$rating = $this->scrape_between('<div class="star-rating ">','<div class="badges" data-badges>',$doms);
		$rating=$this->scrape_between('alt=','>',$rating);
		
		$ret['reviewCount'] = $this->scrape_between('<span class="headline__review-count">','</span>',$doms);
		$cardTitle = $this->scrape_between('<span class="badge-card__title">','</span>',$doms);
		$logo = $this->scrape_between('<div class="business-unit-profile-summary__image-wrapper">','</a>',$doms);
		$categoryData = $this->scrape_between('data-initial-state="business-unit-tracking-properties">','</script>',$doms);
		
		$categoryData = json_decode($categoryData,true);
		$ret['category']= $categoryData['categories'];
		
		$ret['rating']['numberOfStars'] = 'https://cdn.trustpilot.net/brand-assets/4.1.0/stars/stars-'.$categoryData['numberOfStars'].'.svg';
		return $ret;
		// echo '<pre>';print_r($ret);echo 'LINE'.__LINE__;exit; 
		
		// echo '<pre>';print_r($domain);echo 'LINE'.__LINE__;exit; 
		
	}
	
	public function trustedShop($url){
			
		$html = file_get_html($url);
		$ret['img'] = $html->find('img[class="business-unit-profile-summary__image"]', 0)->src;
		
		echo '<pre>'.$url;print_r($ret);exit;
		$atag = $html->find('a',0)->innertext;
		
		// $ret['img'] = $html->find('div[class="business-unit-profile-summary__image"]', 0)->innertext;
		
		/* $ch = curl_init();
		CURL_SETOPT($ch, CURLOPT_URL, $url);
		CURL_SETOPT($ch,CURLOPT_RETURNTRANSFER,true);    // Setting URL
		CURL_SETOPT($ch,CURLOPT_CUSTOMREQUEST,strtoupper('get')); */

		
                    
		$response = \Httpful\Request::get('https://www.trustedshops.de/shops/?q=www.sportscheck.com')->send();
        
        

        $results = curl_exec($ch);
		$html= file_get_contents($url);
		
		
	}
	
	
	public function dlPage($href) {

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_URL, $href);
    curl_setopt($curl, CURLOPT_REFERER, $href);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.4 (KHTML, like Gecko) Chrome/5.0.375.125 Safari/533.4");
    $str = curl_exec($curl);
    curl_close($curl);

    // Create a DOM object
    $dom = new simple_html_dom();
    // Load HTML from a string
    $dom->load($str);
	echo 'hi';exit;
    return $dom;
    }
	
	public function scrape_between($start, $end,$data){
	//$data = $this->source;
		$data = stristr($data, $start); 
		$data = substr($data, strlen($start));  
		$stop = stripos($data, $end);   
		$data = substr($data, 0, $stop);    
		return $data;   
}
}