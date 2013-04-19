<?php
class Meme extends AppModel {

	var $name = 'Meme';
	var $hasMany = array(
		'MemeCaption' => array(
			'className' => 'MemeCaption',
			'foreignKey' => 'meme_id',
			'dependent' => false
		),
		'MemeTag'	=> array(
			'className'=> 'MemeTag',
			'foreignKey'=>'meme_id',
			'dependent'=>false
		)
	);

	var $paginate_limit = '30';
	var $paginate ="";

	function findDefaults(){
		return array();
	}
	
	function afterFind($results){
		for($i=0; $i<count($results); $i++ ) {
			if(isset($results[$i]['Meme']['title'])){
				$title=$results[$i]['Meme']['title'];
				
				$results[$i]['Meme']['url']=$this->getUrlPart($title.'-'.$results[$i]['Meme']['id']);
			}
		}
		return $results;
	}	
	
	function checkMemeOwner($meme_id,$user){ 
		if($user['User']['admin']==1){
			return true;
		}
		
		$meme = $this->find('first',array('fields'=>array('user_id'),'conditions'=>array('Meme.id'=>$meme_id)));
		if($meme['Meme']['user_id']!=$user['User']['id']){
			return false;
		}
		return true;

	}

	function deleteMeme($meme_id){
		$d=array('id'=>$meme_id,'deleted'=>1,'active'=>0);
		$this->set($d);
		$this->save();
		//$this->delete($meme_id);
		return true;

	}
	function getCaptionSizes(){
		$data[]= array('id'=>'auto','value'=>'Size: Auto');
		for($i=10;$i<=20;$i++){
			$data[]=array('id'=>$i,'value'=>'Size: '.$i.'pt');
		}
		$i=22;
		while($i<66){
			$data[]=array('id'=>$i,'value'=>'Size: '.$i.'pt');
			$i=$i+2;		
		}			
		return $data;
	}
	
	function getAlignMentOptions(){
	//	$arr= array('left top','left center','left bottom','right top','right center','right bottom','center top','center center','center bottom');
		$arr = array('center'=>'Center Align','left'=>'Left Align','right'=>'Right Align');
		return $arr;
	}
	
	function updateViewCount($meme_id,$current_count){
		$d['id']=$meme_id;
		$d['view_count']=$current_count+1;
		$this->set($d);
		$this->save();
	}
	
	function getRandomMemes($limit,$page){
		$conditions[] = array('active'=>1);
		 
		//do a quick count on the memes table in order to calculate our coefficient
		$meme_count = $this->find('count',array('conditions'=>$conditions));
		
		$fragment = $limit/$meme_count; //this value should be a very small decimal.
		
		$conditions[] = array('RAND() <= '=>$fragment);
		
		$data = $this->find('all',
			array('fields'=>array('Meme.title,Meme.image_url,Meme.image_url_medium,Meme.id,Meme.rating,Meme.view_count,Meme.created'),
				'conditions'=>array($conditions),
				'recursive'=>-1,
				'limit'=>$limit));
		return $data;
	
	}
	function getMemesByPopularity($date_range){
		//date range passed through in format of days.  ie 2, 7, 30, etc.
		$conditions[]=array('active'=>1);
		if(is_numeric($date_range) && in_array($date_range,array('2','7','30'))){
			$created = date('Y-m-d',strtotime("-".$date_range." days"));
			$conditions[] = array("DATE_FORMAT(Meme.created, '%Y-%m-%d') >="=>$created);
		}

		$data = $this->find('all',array('conditions'=>$conditions,'order'=>'Meme.view_count DESC','limit'=>50));
		return $data;
	}
	function getMemes($category_id=null,$limit=null,$order=null,$page=null){
 		$conditions[] = array('active'=>1);
 		if($category_id != null){
 			$conditions[] = array('category_id'=>$category_id);
 		}
 		if($order != null){
	 		$order = $order;
 		}else{
 		 	$order = '';
 		}
		 		
  		$data = $this->find('all',
  			array('fields'=>array('Meme.title,Meme.image_url,Meme.image_url_medium,Meme.id,Meme.rating,Meme.view_count,Meme.created'),
  				'conditions'=>$conditions,
  				'recursive'=>-1,
  				'limit'=>($limit!=null)?$limit:10));
		return $data;
	}

	function getOriginals($limit){
		$order=$this->setOrder();
		$data=$this->find('all',array('conditions'=>array('is_original'=>1,'active'=>1),'order'=>$order,'limit'=>$limit));
		return $data;
	}
	function grabMemesByParent($parent_id,$sort =null,$limit=null){
		//$cond[] = array('OR'=>array('parent_id'=>$parent_id,'Meme.id'=>$parent_id),'active'=>1);
		//print 'parent '.$parent_id;

		$cond[] = array('parent_id'=>$parent_id,'active'=>1);	
		$order = $this->setOrder($sort);


		$data = $this->find('all',array(
			'conditions'=>$cond,
			 'order'=>$order,
			 'limit'=>$limit));

		//print_r($data);
		return $data;
	
	}
	function setOrder($sort=null){
		$order = 'Meme.rating DESC'; 
		if($sort == 'viewcount'){
			$order = 'view_count DESC';
		}
		elseif($sort == 'newest' || $sort=='new'){
			$order = 'Meme.id DESC';
		}
		elseif($sort == 'oldest'){
			$order = 'Meme.id ASC';
		}
		elseif($sort == 'random'){
			$order  = 'RANDOM(Meme.id)';
		}
		return $order;
	}

	function grabMemesByLeague($league_id,$sort=null){
		//league_id can be a single value OR an array.
		$cond[] = array('league_id'=>$league_id,'active'=>1);
		$order = $this->setOrder($sort);
		$data = $this->find('all',array(
			'conditions'=>$cond,
			'order'=>$order));
		return $data;
	}
	
	/*attempt to create an image containing the error message given.
    if this works, the image is sent to the browser. if not, an error
    is logged, and passed back to the browser as a 500 code instead.*/
	function fatal_error($message){
	    // send an image
	    if(function_exists('ImageCreate'))
	    {
	        $width = ImageFontWidth(5) * strlen($message) + 10 ;
	        $height = ImageFontHeight(5) + 10 ;
	        if($image = ImageCreate($width,$height))
	        {
	            $background = ImageColorAllocate($image,255,255,255) ;
	            $text_color = ImageColorAllocate($image,0,0,0) ;
	            ImageString($image,5,5,5,$message,$text_color) ;
	            header('Content-type: image/png') ;
	            ImagePNG($image) ;
	            ImageDestroy($image) ;
	            exit ;
	        }
	    }
	
	    // send 500 code
	    header("HTTP/1.0 500 Internal Server Error") ;
	    print($message) ;
	    exit ;
	}
	
	/*decode an HTML hex-code into an array of R,G, and B values.
    accepts these formats: (case insensitive) #ffffff, ffffff, #fff, fff*/
	function hex_to_rgb($hex) {
	    // remove '#'
	    if(substr($hex,0,1) == '#')
	        $hex = substr($hex,1) ;
	
	    // expand short form ('fff') color to long form ('ffffff')
    	if(strlen($hex) == 3) {
    	    $hex = substr($hex,0,1) . substr($hex,0,1) .
    	           substr($hex,1,1) . substr($hex,1,1) .
    	           substr($hex,2,1) . substr($hex,2,1) ;
    	}
	
	    if(strlen($hex) != 6)
	        fatal_error('Error: Invalid color "'.$hex.'"') ;

	    // convert from hexidecimal number systems
	    $rgb['red'] = hexdec(substr($hex,0,2)) ;
	    $rgb['green'] = hexdec(substr($hex,2,2)) ;
	    $rgb['blue'] = hexdec(substr($hex,4,2)) ;
	
	    return $rgb ;
	}

   	function fetchForSport($sport){
   		$League = ClassRegistry::init('League');
  		$league_id = $League->getLeagueId($sport);
		$sort = (isset($_GET['sort']))?$_GET['sort']:'viewcount';
  		$memes = $this->grabMemesByLeague($league_id);
  		return $memes;
  	}




}
?>
