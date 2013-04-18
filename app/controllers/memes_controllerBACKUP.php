<?php
class MemesController extends AppController {

	var $name = 'Memes';
	var $uses = array('Meme','MemeType','MemeCaption','MemeRating','User','Sport','Team');
	var $helpers = array('Form','Time');
	var $components = array('Image','Session');

  	function index(){

  		$data['memes']=$this->Meme->find('all');
		$this->set('data',$data);  		
  	}
  	
  	function popular($category_id=null){
 		$sort=(isset($_GET['sort']))?$_GET['sort']:'';
 		$data['memes']=  $this->Meme->getMemesByPopularity($sort);
  		$this->set('data',$data);		
  	
  	}
  	
  	function random(){
  		$data['memes'] = $this->Meme->getRandomMemes(5,1);
  		$data['random'] = true;
  		$this->set('data',$data);
  		$this->render('popular');
  	}

  	function nfl(){
  		$data['sport'] = 'NFL';
  		$data['memes'] = $this->_fetchForSport($data['sport']);
  		$this->set('data',$data);
  		$this->render('popular');
  	}
  	function mlb(){
		$data['sport'] = 'MLB';
  		$data['memes'] = $this->_fetchForSport($data['sport']);
  		$this->set('data',$data);
  		$this->render('popular');
  	}
  	function nhl(){
		$data['sport'] = 'NHL';
  		$data['memes'] = $this->_fetchForSport($data['sport']);
  		$this->set('data',$data);
  		$this->render('popular');
  	}
  	function nba(){
		$data['sport'] = 'NBA';
  		$data['memes'] = $this->_fetchForSport($data['sport']);
  		$this->set('data',$data);
  		$this->render('popular');
  	}

  	private function _fetchForSport($sport){
  		$sport_id = $this->Sport->getSportId($sport);
		$sort = (isset($_GET['sort']))?$_GET['sort']:'viewcount';
  		$memes = $this->Meme->grabMemesBySport($sport_id);
  		return $memes;
  	}
	function browse($sort=null){
		$this->redirect('/memes/popular');
		$data['memes']=$this->Meme->grabMemesByParent(0,$sort);
		$data['browse']=true;

		$this->set('data',$data);
  		$this->render('popular');
	}

  	function all($meme_id){
		$meme_id = $this->checkId($meme_id);
		$data['meme_data'] = $this->Meme->read(null,$meme_id);
		$sort = (isset($_GET['sort']))?$_GET['sort']:'viewcount';
		$data['memes'] = $this->Meme->grabMemesByParent($data['meme_data']['Meme']['parent_id'],$sort);		

		$this->set('data',$data);
		$this->render('popular');
	}
  	
  	function create(){
  		$this->loadModel('MemeTag');
  		
  		// is a valid solution... Apparently it wasn't installed properly and halfway through, the program failed. So it works now.
  		if(!empty($this->data)){ //it's on.  uploading time.

			$user_id = $this->Auth->user('id');

    		$data=pathinfo($this->data['image']['name']);
    		$l_ext = strtolower($data['extension']);
			
			$filename=strtotime("now").'-'.$this->data['image']['name'];
			$serverpath = WWW_ROOT."img/user_memes/".$filename;
			$allow_extensions = array('gif', 'jpeg', 'jpg', 'png');

			if($l_ext && in_array($l_ext, $allow_extensions)){
					
				//$move_file= move_uploaded_file($this->data['image']['tmp_name'], $serverpath);			
				$d = array('user_id'=>$this->Auth->user('id'),'is_original'=>1,'active'=>0,'type_id'=>$_GET['type_id']);
				$d['image_url_original']=$filename;

      	    	//$cropped = $this->Image->resize($serverpath,$thumb_serverpath,135,0,100);

				$dimensions = getimagesize($this->data['image']['tmp_name']);
				$d['mime_type'] = $dimensions['mime'];
				
				
				
				$maxWidth  = 625;
				$maxHeight = 575;

				if ($dimensions) {
				    $imageWidth  = $dimensions[0];
    				$imageHeight = $dimensions[1];
   					 $wRatio = $imageWidth / $maxWidth;
   					 $hRatio = $imageHeight / $maxHeight;
    				$maxRatio = max($wRatio, $hRatio);
    				if ($maxRatio > 1) {
        				$outputWidth = $imageWidth / $maxRatio;
        				$outputHeight = $imageHeight / $maxRatio;
				    } else {
        				$outputWidth = $imageWidth;
        				$outputHeight = $imageHeight;
				    }
				}

				if(isset($outputWidth) && isset($outputHeight)){
					$cropped = $this->Image->resize($this->data['image']['tmp_name'],$serverpath,$outputWidth,$outputHeight,100);
				}
				
				/*if($dimensions[0] < 650){ //don't resize if it's less than the max width we're allowing?
					$cropped = $this->Image->resize($this->data['image']['tmp_name'],$serverpath,0,0,100);
				}
				else{
					$cropped = $this->Image->resize($this->data['image']['tmp_name'],$serverpath,650,0,100);				
				}*/
				//$data['cropped_image_url'] = $file_small;	
				
				$this->Meme->create();
				$this->Meme->save($d);

				$this->redirect('/memes/step2/'.$this->Meme->id);
				exit;
				
			
			}
			else{

				$this->redirect('/memes/create?err=true');
				exit;
				
			
			}
  		
  		}
  		elseif(isset($_GET['type_id'])){
  			$data['meme_type']=$this->MemeType->find('first',array("conditions"=>array("MemeType.id"=>$_GET['type_id'])));
  	   		$data['memes']=  $this->Meme->getMemes();
			$data['teams'] = $this->Team->getTeamsBySport();

		  	$data['leagues'] = $data['teams']['leagues'];
			$data['teams'] = $data['teams']['teams'];
			//print_r($data['teams'][1]);
  			//foreach($data['teams'][1] as $team){
			//	echo $team['name'];
			//}
			
  			if(empty($data['meme_type'])){
  				$this->redirect('/memes/create');
  			}
  			$this->set('data',$data);
  		}
  		else{
  	
  	   		$data['memes']=  $this->Meme->grabMemesByParent(0,null,10);
  			$data['meme_types']=$this->MemeType->grabTypes();
			$data['teams'] = $this->Team->getTeamsBySport();
			$data['leagues'] = $data['teams']['leagues'];
			
			//print_r($data['teams']);
			//exit;
			//->grabAllLeagues();
			
  			$this->set('data',$data);
  		}
  	}
  	
  	function step2($meme_id){
  		$data['alignment_options']=$this->Meme->getAlignmentOptions();
  		$this->loadModel('MemeTag');
  		
  		if(!empty($this->data)){
  			//pr($this->data);exit;
			if(isset($this->data['meme']['parent'])){
				//$this->data['meme']['parent']=12;
				$meme_img = $this->Meme->read(null,$this->data['meme']['parent']);
				
				$new_meme = array(
					'title'=>$meme_img['Meme']['title'],
					'type_id'=>$meme_img['Meme']['type_id'],
					'parent_id'=>$this->data['meme']['parent'],
					'image_url_original'=>$meme_img['Meme']['image_url_original'],
					'mime_type'=>$meme_img['Meme']['mime_type'],
					'active'=>1
				);
				
				$this->Meme->create();
				$this->Meme->save($new_meme);
				$data['meme_id'] = $this->Meme->id;			
				
			}
			else{
				$data['meme_id']=$meme_id;
			  	$meme_img = $this->Meme->find('first',array('conditions'=>array('Meme.id'=>$meme_id)));

			}		
			
  			if(isset($this->data['caption'])){
  				$caption_count=count($this->data['caption']['body']);
  				$this->MemeCaption->deleteAll(array('meme_id'=>$data['meme_id'])); //remove previously saved memes here first.
  				for($i=0;$i<$caption_count;$i++){
					$data['body']=$this->data['caption']['body'][$i];
					if(!empty($this->data['caption']['auto_size'][$i]) && !is_numeric($this->data['caption']['size'][$i])){
						$data['font_size']=$this->data['caption']['auto_size'][$i];
					}
					else{
						$data['font_size']=$this->data['caption']['size'][$i];
					}
					//$data['text_align']=$data['alignment_options'][$this->data['caption']['align'][$i]]; 				
  					$data['text_align'] = $this->data['caption']['align'][$i];
  					$data['latitude']=$this->data['caption_coords']['left'][$i];
  					$data['longitude']=$this->data['caption_coords']['top'][$i];
  					$data['letter_left'] = $this->data['caption_coords']['letter_left'][$i];
  					$data['letter_top'] = $this->data['caption_coords']['letter_top'][$i];

  					$this->MemeCaption->create();
  					$this->MemeCaption->save($data);
  				}
  			
  			}
  			
			$image_file = WWW_ROOT.'img/user_memes/'.$meme_img['Meme']['image_url_original'];
			
  			$meme = array('id'=>$data['meme_id'],
  				'title'=>(isset($new_meme))?$new_meme['title']:$this->data['meme']['title'],
  				'public' => ($this->data['meme']['public']=='1')?1:0,
  				'user_id' => ($this->data['meme']['creator']=='anon')?0:$this->Auth->user('id'),
  				'parent_id' => (isset($this->data['meme']['parent']))?$this->data['meme']['parent']:$data['meme_id'],
  				'ip_address'=>$_SERVER['REMOTE_ADDR'],
  				'created'=>date('Y-m-d H:i:s',strtotime("now")),
  				'active'=>1);

			$meme['image_url'] = "final-".time()."-".$meme_img['Meme']['image_url_original'];	
			$meme['image_url_medium'] = "medium-".time()."-".$meme_img['Meme']['image_url_original'];	
			
			$text = $this->data['caption']['body'][0];
			//$font_file      = WWW_ROOT.'css/Chunkfive-webfont.ttf';
			//$font_file      = WWW_ROOT.'phptxtonimage/Impact_Label.ttf';
//			$font_file = 'impact.ttf';
			$font_file = WWW_ROOT.'phptxtonimage/Impact/Impact';
			$font_file2 = WWW_ROOT.'phptxtonimage/ImpactMeme.ttf';
  			$font_file3= WWW_ROOT.'phptxtonimage/INNER.ttf';
			$font_file4= WWW_ROOT.'phptxtonimage/OUTER.ttf';
			$font_color     = '#ffffff';
		
			$mime_type 	= $meme_img['Meme']['mime_type']; //image/png, image/jpeg, etc
			$extension = '.'.trim(array_pop(explode("/",$mime_type)));//.png,.jpeg,.jpg,etc
			$s_end_buffer_size  = 4096 ;

			// check for GD support
			//if(!function_exists('ImageCreate')) //$this->Meme->fatal_error('Error: Server does not support PHP image generation') ;

			// check font availability;
			if(!is_readable($font_file)) $this->Meme->fatal_error('Error: The server is missing the specified font.') ;
			
			// create and measure the text
			$font_rgb = $this->Meme->hex_to_rgb($font_color) ;
			$box = @ImageTTFBBox($font_size,0,$font_file,$text) ;

			//$text_width = abs($box[2]-$box[0]);$text_height = abs($box[5]-$box[3]);

			if($extension == '.png'){ 
				$image =  imagecreatefrompng($image_file);
			}
			elseif($extension == '.jpeg' || $extension == '.jpg'){
				$image =  imagecreatefromjpeg($image_file);
			}
			elseif($extension == '.gif'){
				$image =  imagecreatefromgif($image_file);
			}
			else{
				$this->Meme->fatal_error('Error: Unsupported mime-type.  Please try again with a different image.');
			}
		
			if(!$image || !$box){ $this->Meme->fatal_error('Error: The server could not create this image.') ;}


			// allocate colors and measure final text position
			$font_color = ImageColorAllocate($image,$font_rgb['red'],$font_rgb['green'],$font_rgb['blue']) ;
			//$font_color = ImageColorAllocate($image,0,0,0);
			$im = imagecreatetruecolor(400, 30);
			$black = imagecolorallocate($im, 0, 0, 0);

//			print_r($font_color);exit;$grey = '#999999';

			// Write the text
			if(isset($caption_count)){
				for($i=0;$i<$caption_count;$i++){
					// x and y for the bottom right of the text so it expands like right aligned text
					$x_coord = $this->data['caption_coords']['letter_left'][$i]+2;//for padding.
					$y_coord = $this->data['caption_coords']['letter_top'][$i];
				//	print_r($this->data);exit;
					// $x_coord = $this->data['caption_coords']['left'][$i];
					// $y_coord = $this->data['caption_coords']['top'][$i];
					
					//$y_coord = $this->data['caption_coords']['top'][$i]+12+10;//for the padding top of the div.caption

					//$font_Size
					$font_size = $this->data['caption']['size'][$i];						
					if(!empty($this->data['caption']['auto_size'][$i]) && !is_numeric($this->data['caption']['size'][$i])){
						$font_size = $this->data['caption']['auto_size'][$i]; //autosized, already converted to PT!
					}

					if($this->data['caption']['text_style']!='lower'){
						$this->data['caption']['body'][$i]= strtoupper($this->data['caption']['body'][$i]);
					}
					
					$lines=explode("\n",$this->data['caption']['body'][$i]);
					//pr($lines);
					//exit;
					for($z=0; $z< count($lines); $z++){
						$newY = $y_coord + ($z * $font_size * 1);
						// imagettftext($image, $font_size, 0, ($x_coord+2), ($newY+2), $black, $font_file, $lines[$z]);//adding same text shadow.
   		 // 				imagettftext($image, $font_size, 0, $x_coord, $newY, $font_color, $font_file,  $lines[$z]);
						imagettftext($image, $font_size, 0, $x_coord, $newY, $black, $font_file3, $lines[$z]);//adding same text shadow.
						imagettftext($image, $font_size, 0, $x_coord, $newY, $black, $font_file4, $lines[$z]);//adding same text shadow.
						
				    }
				}
			}
			//exit;
			imagettftext($image, 12, 0, 5, 5, $black, $font_file4, $lines[$z]);//adding same text shadow.
			$new_path = WWW_ROOT."/img/user_memes/".$meme['image_url'];	
			$cropped_path = WWW_ROOT."/img/user_memes/".$meme['image_url_medium'];

			if($extension == '.png'){ 
				$ne = ImagePNG($image,$new_path);
			}
			elseif($extension == '.jpeg' || $extension == '.jpg'){
				$ne = ImageJPEG($image,$new_path);
			}
			elseif($extension == '.gif'){
				$ne = ImageGIF($image,$new_path);
			}
			ImageDestroy($image);			
			//header('Content-type: ' . $mime_type) ;ImagePNG($image) ;ImageDestroy($image);exit;

			
			$maxWidth  = 310;
			$maxHeight = 310;

			$size = getimagesize($new_path);
			if ($size) {
			    $imageWidth  = $size[0];
    			$imageHeight = $size[1];
    			$wRatio = $imageWidth / $maxWidth;
   				$hRatio = $imageHeight / $maxHeight;
    			$maxRatio = max($wRatio, $hRatio);
    			if ($maxRatio > 1) {
        			$outputWidth = $imageWidth / $maxRatio;
       			 	$outputHeight = $imageHeight / $maxRatio;
			    } else {
        			$outputWidth = $imageWidth;
        			$outputHeight = $imageHeight;
			    }
			}
			
			if(isset($outputHeight) && isset($outputWidth)){
				$this->Image->resize($new_path,$cropped_path,$outputWidth,$outputHeight,100);
			}

			
			$this->Meme->set($meme);
			$this->Meme->save();
		
			$this->MemeTag->saveTags($data['meme_id'],$this->data['meme']['tags']);

			$this->redirect('/memes/view/'.$data['meme_id']);
			exit;
  		
  		}
  		
  		$teams = $this->Team->getTeamsBySport();
		//$data['leagues'] = $teams['leagues'];
		$data['teams'] =  $teams['teams'];
		$data['leagues'] = $this->Sport->getAll();
		$data['meme']=$this->Meme->read(null,$meme_id);
		if($data['meme']['Meme']['active'] == 1){
			$this->redirect('/memes/view/'.$meme_id);
			exit;
		}
		$data['dimensions'] = getimagesize(WWW_ROOT."/img/user_memes/".$data['meme']['Meme']['image_url_original']);
		$data['caption_sizes']=$this->Meme->getCaptionSizes();
		$data['team_colors'] = $this->_getTeamColors();
		$this->set('data',$data);  		
  	
  	
  	}
  	
  	function add($meme_id){
		
		$meme_id=$this->checkId($meme_id);
		$data['meme']=$this->Meme->read(null,$meme_id);
		$data['user_id'] = $this->Auth->user('id');
		//$this->Meme->updateViewCount($meme_id,$data['Meme']['view_count']);
		if($data['meme']['Meme']['user_id'] > 0){
			$data['creator']=$this->User->getUserName($data['meme']['Meme']['user_id']);
		}

		$data['parent_id'] = $data['meme']['Meme']['parent_id'];
		$data['alignment_options']=$this->Meme->getAlignmentOptions();		
		$data['dimensions'] = getimagesize(WWW_ROOT."/img/user_memes/".$data['meme']['Meme']['image_url_original']);
		$data['caption_sizes']=$this->Meme->getCaptionSizes();
		$data['team_colors'] = $this->_getTeamColors();
  		
  		$teams = $this->Team->getTeamsBySport();
		$data['leagues'] = $teams['leagues'];
		$data['teams'] =  $teams['teams'];
		
		$data['remake'] = true;
		if(!empty($data['meme']['MemeCaption'])){
			for($i=0;$i<count($data['meme']['MemeCaption']);$i++){
				$data['meme']['MemeCaption'][$i]['properties'] = $this->MemeCaption->getAttributes($data['meme']['MemeCaption'][$i]);			
				$data['meme']['MemeCaption'][$i]['font_size_str'] = $this->MemeCaption->setFontSize($data['meme']['MemeCaption'][$i]);
			}

		}

		$this->set('data',$data);
		$this->render('step2');
		//print_r($data);exit;	
	
	}	
  	
	private function _getTeamColors(){
		return array('#355E3B'=>'Hunter Green','#000'=>'Black');
	}
	

	function view($meme_id){
		$meme_id = $this->checkId($meme_id);
		$data=$this->Meme->read(null,$meme_id);

		if(empty($data)){
			$this->redirect('/memes/browse');
		}
		$data['user_id'] = $this->Auth->user('id');
		$data['owner']=true;
		$this->Meme->updateViewCount($meme_id,$data['Meme']['view_count']);
		
		if($data['Meme']['user_id'] > 0){
			$data['creator']=$this->User->getUserName($data['Meme']['user_id']);
			$data['creator_slug'] = $this->User->getUrlPart($data['creator'].'-'.$data['Meme']['user_id']);
		}
		else{
			$data['creator']='Bart Simpy';
			$data['creator_slug'] = 'bartsimpy-0';
		}

		$data['meme_rating'] = $this->MemeRating->getRating($data['Meme']['id']);
		$data['user_rating'] = $this->MemeRating->getUserRatingForMeme($data['Meme']['id'],$data['user_id']);
	
		if($data['Meme']['parent_id'] > 0){ //this is a child
		//	$data['other_memes'] = $this->Meme->grabMemesByParent($data['Meme']['parent_id'],$meme_id);		
		
		}
		else{ 	//this is the original.
			//$data['other_memes'] = $this->Meme->grabMemesByParent($meme_id,$meme_id);		
		
		}
		//print_r($data['other_memes']);

		$this->set('data',$data);
	
	}
	
	function users($user_id){
		$user_id = $this->checkId($user_id,'User');
		$data['memes'] = $this->Meme->findAllByUserId($user_id);
		$this->set('data',$data);
		$this->render('popular');
	}
	function addRating(){
		if(isset($_POST['id']) && isset($_POST['value'])){
			$user_id = $this->Auth->user('id');
			if(!is_numeric($user_id)){
				$user_id = 0;
			}
			if($user_id < 1){
			
				//grab user by IP Address
			}
			$data = array('meme_id'=>$_POST['id'],'rating'=>$this->MemeRating->translateScore($_POST['value']));
			$exists = $this->MemeRating->find('first',array('conditions'=>array('meme_id'=>$_POST['id'],'user_id'=>$user_id)));
		
			if(!empty($exists)){
				$data['id'] = $exists['MemeRating']['id'];
				$this->MemeRating->set($data);
				$this->MemeRating->save();
			}
			else{
				$this->MemeRating->create();
				$this->MemeRating->save($data);			
			}

			$new_rating = $this->MemeRating->getRating($_POST['id']);
			echo json_encode(array('value'=>$new_rating));
			exit;		
		
		}
	
	}

	function delete($meme_id){
		$data['user'] = $this->Auth->user();
		//if($this->Meme->checkMemeOwner($meme_id,$data['user'])){
			$this->Meme->deleteMeme($meme_id);
		//}
		$this->Session->setFlash('Your meme has been wiped out.');
		$this->redirect('/memes/browse');

	}
	
	function favorites(){
		if($this->Auth->user()){
			//$data['favorites'] = $this->Meme->
		}
	
	}
}

?>