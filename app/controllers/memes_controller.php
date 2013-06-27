<?php
class MemesController extends AppController {

	var $name = 'Memes';
	var $uses = array('Meme','MemeType','MemeCaption','MemeRating','User','League','Sport','Team');
	var $helpers = array('Form','Time');
	var $components = array('Auth','Image','Session');
	var $paginate_limit = 30;

	function beforeFilter(){
		$this->Auth->allow('*');
		parent::beforeFilter();
	}
 //    function isAuthorized(){
	// 	if (isset($this->params[Configure::read('Routing.admin')])){
 //        	if ($this->Auth->user('admin') == 0) {
 //            	return false;
 //            }
 //        }
 //        return true;
	// }

  	function index($cat_id=null){
  		$data['sort'] = $this->Meme->getSortParam($_GET,$this->params);
		$data['memes']=  $this->Meme->getMemesByPopularity($data,$this->params);
  		if(!empty($this->params['form'])){
  			$this->layout = '';
  			$this->set('data',$data);
  			$this->render('ajax-results');
  		} else{
  			$data['user'] = $this->Auth->user();
  			$data['sports'] = $this->Sport->grabAll();
	  		$this->set('data',$data);
  		}
  	}
  	
  	function popular($category_id=null){
  		$this->redirect('/');
  		// $data['sort'] = $this->Meme->getSortParam($_GET,$this->params);
  		// $data['memes']=  $this->Meme->getMemesByPopularity($data,$this->params);
  		// if(!empty($this->params['form'])){
  		// 	$this->layout = '';
  		// 	$this->set('data',$data);
  		// 	$this->render('ajax-results');
  		// } else{
	  	// 	$this->set('data',$data);
  		// }
  	}
  	
  	function random(){
  		$data['memes'] = $this->Meme->getRandomMemes(5,1);
  		$data['random'] = true;
  		$this->set('data',$data);
  		$this->render('popular');
  	}

  	function sport($sport_name=null){
  		$data['sport'] = $this->Sport->checkForSport($sport_name,$this->params);  	
  		if(!empty($this->params['form'])){ 
  			$this->layout = null;
  		}
  		$data['sort'] = $this->Meme->getSortParam($_GET,$this->params);
  		$data['sport_id'] = $this->Sport->findIdByName($data['sport']);
  		if($data['sport_id']===false){ $this->redirect("/"); }

  		$data['leagues'] = $this->League->getSportLeagues($data['sport_id']);
  		//$data['teams'] = $this->Team->getAllForSport($data['sport_id']);
  		$data['memes'] = $this->Meme->grabMemesByLeague($data['leagues'],$data);
  		$this->set('data',$data);
  	}

  	//this function is called for LEAGUE browsing, ie MLB, NBA, NHL, NCAAF
  	function league($league_name=null){
 		$data['league'] = $this->League->checkForLeague($league_name,$this->params);
 		$data['league_id'] = (isset($this->params['form']['league_id']))?$this->params['form']['league_id']:$this->League->getLeagueId($data['league']);
 		$data['sort'] = $this->Meme->getSortParam($_GET,$this->params);

 		if(!empty($this->params['form'])){ //ajax request.
 			$this->layout = 'ajax';
 			$data['team_id'] = $this->params['form']['team_id'];
 			$data['memes'] = $this->Meme->grabMemesByLeague($data['league_id'],$data);
 			$this->set('data',$data);
 			$this->render('ajax-results');
 		} else{

	 		$data['parent'] = $this->League->getLeagueParent($league_name);
	  		$data['teams'] = $this->Team->getAllForLeague($data['league_id']);
	  		$data['sport'] = $league_name;
	  		$data['memes'] = $this->Meme->grabMemesByLeague($data['league_id'],$data);
	  		$this->set('data',$data);
  		}
  	}

	function browse($sort=null){
		$this->redirect('/memes');
	}

  	//browsing all memes related to a given meme parent.
  	function all($meme_id){
		$meme_id = $this->checkId($meme_id);
		$data['meme_data'] = $this->Meme->read(null,$meme_id);
		$data['sort'] = $this->Meme->getSortParam($_GET,$this->params);
		$data['memes'] = $this->Meme->grabMemesByParent($data['meme_data']['Meme']['parent_id'],$data);		

  		if(!empty($this->params['form'])){
  			$this->layout = '';
  			$this->set('data',$data);
  			$this->render('ajax-results');
  		} else{
	  		$this->set('data',$data);
  		}
	}
  	
  	function create(){
  		$this->loadModel('MemeTag');
  		if(!empty($this->data)){ //it's on.  uploading time.

			$user_id = $this->Auth->user('id');

    		$data=pathinfo($this->data['image']['name']);
    		$l_ext = strtolower($data['extension']);
			
			$filename=strtotime("now").'-'.$this->data['image']['name'];
			$serverpath = WWW_ROOT."img/user_memes/".$filename;
			$allow_extensions = array('gif', 'jpeg', 'jpg', 'png');

			if($l_ext && in_array($l_ext, $allow_extensions)){
					
				//$move_file= move_uploaded_file($this->data['image']['tmp_name'], $serverpath);		
				$type_id=(isset($_GET['type_id']))?$_GET['type_id']:1;
				$d = array('user_id'=>$this->Auth->user('id'),'is_original'=>1,'active'=>0,'type_id'=>$type_id);
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
  	
  	   		$data['memes']=  $this->Meme->getMemes(null,50,'Meme.rating DESC');
  	   		//pr($data['memes']);
  	   		$data['meme_types']=$this->MemeType->grabTypes();
			$data['teams'] = $this->Team->getTeamsBySport();
			$data['leagues'] = $data['teams']['leagues'];
			
			//print_r($data['teams']);
			//exit;
			//->grabAllLeagues();
			
  			$this->set('data',$data);
  		}
  	}

  	function carouselPaging($category_id=null,$page=1){
  		$data['memes']=  $this->Meme->getMemes(null,10,'Meme.rating DESC',$page);
  	//	$this->set('data',$)
  	}
  	
  	function step2($meme_id){
  		$data['alignment_options']=$this->Meme->getAlignmentOptions();
  		$this->loadModel('MemeTag');
  		
  		if(!empty($this->data)){
  			//pr($this->data);exit;
			if(isset($this->data['meme']['parent'])){
				$new_meme = $this->Meme->baseOnParent($this->data['meme']['parent']);
				$this->Meme->create();
				$this->Meme->save($new_meme);
				$data['meme_id'] = $this->Meme->id;			
				$meme_img = $this->Meme->find('first',array('conditions'=>array('Meme.id'=>$meme_id)));
			}
			else{
				$data['meme_id']=$meme_id;
			  	$meme_img = $this->Meme->find('first',array('conditions'=>array('Meme.id'=>$meme_id)));
			}		
			
  			if(isset($this->data['caption'])){
  				$caption_count=count($this->data['caption']['body']);
  				$this->MemeCaption->deleteAll(array('meme_id'=>$data['meme_id'])); //remove previously saved memes here first.
  				for($i=0;$i<$caption_count;$i++){
					$data['body']=str_replace('<br>','',$this->data['caption']['body'][$i]);
					if(!empty($this->data['caption']['auto_size'][$i]) && !is_numeric($this->data['caption']['size'][$i])){
						$data['font_size']=$this->data['caption']['auto_size'][$i];
					}
					else{
						$data['font_size']=$this->data['caption']['size'][$i];
					}
					//$data['text_align']=$data['alignment_options'][$this->data['caption']['align'][$i]]; 				
  					$data['text_align'] = $this->data['caption']['align'][$i];
  					$data['latitude']=$this->data['caption_coords'][$i+1]['left'][0];//[$i];
  					$data['longitude']=$this->data['caption_coords'][$i+1]['top'][0];//[$i];
  					$data['letter_left'] = $this->data['caption_coords'][$i+1]['letter_left'][0];//[$i];
  					$data['letter_top'] = $this->data['caption_coords'][$i+1]['letter_top'][0];//[$i];

  					$this->MemeCaption->create();
  					$this->MemeCaption->save($data);
  				}
  			
  			}
  			
			$image_file = WWW_ROOT.'img/user_memes/'.$meme_img['Meme']['image_url_original'];
//			pr($this->data['meme']['league_id']);exit;

  			$meme = array('id'=>$data['meme_id'],
  				'title'=>(isset($new_meme))?$new_meme['title']:$this->data['meme']['title'],
  				'public' => ($this->data['meme']['public']=='1')?1:0,
  				'user_id' => ($this->data['meme']['creator']=='anon')?0:$this->Auth->user('id'),
  				'parent_id' => (isset($this->data['meme']['parent']))?$this->data['meme']['parent']:$data['meme_id'],
  				'ip_address'=>$_SERVER['REMOTE_ADDR'],
  				'league_id' => (isset($new_meme))?$new_meme['league_id']:$this->data['meme']['league_id'],
  				'created'=>date('Y-m-d H:i:s',strtotime("now")),
  				'active'=>1);

			$meme['image_url'] = "final-".time()."-".$meme_img['Meme']['image_url_original'];	
			$meme['image_url_medium'] = "medium-".time()."-".$meme_img['Meme']['image_url_original'];	
			
			$text = $this->data['caption']['body'][0];
			$font_file = WWW_ROOT.'phptxtonimage/Impact/Impact';
			$font_color = (!empty($this->data['caption']['color']))?$this->data['caption']['color']:'#ffffff';
		
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

			//imagefilter($image,IMG_FILTER_GRAYSCALE);
			//imagefilter($image,IMG_FILTER_NEGATE);
			// imagefilter($image,IMG_FILTER_BRIGHTNESS,50);
			//imagefilter($image,IMG_FILTER_EDGEDETECT);
			//imagefilter($image,IMG_FILTER_EMBOSS);
			//imagefilter($image,IMG_FILTER_GAUSSIAN_BLUR);
			// imagefilter($image,IMG_FILTER_SELECTIVE_BLUR);
			//imagefilter($image,IMG_FILTER_MEAN_REMOVAL);
			// imagefilter($image,IMG_FILTER_SMOOTH,2);
			imagefilter($image,IMG_FILTER_PIXELATE,4,true);

			if(!$image || !$box){ $this->Meme->fatal_error('Error: The server could not create this image.') ;}
			// pr($image_file);
			$image_height = getimagesize($image_file);
			//pr($image_height);exit;
			// allocate colors and measure final text position
			$font_color = ImageColorAllocate($image,$font_rgb['red'],$font_rgb['green'],$font_rgb['blue']);
			$font_color2 =ImageColorAllocate($image,0,0,0);
			$white = ImageColorAllocate($image,255,255,255);
	
			//$watermark = imagecolorallocatealpha($image,0,0,0,0);

			$im = imagecreatetruecolor(400, 30);
			$stroke_color = imagecolorallocate($image, 0, 0, 0);

			// Write the text
			if(isset($caption_count)){
				//$this->data['caption']['body'][1] = str_replace("like them apples ","\nlike them apples",$this->data['caption']['body'][1]);
				for($i=0;$i<$caption_count;$i++){
					$caption_number = $i+1; //starts at 1, not 0 on the form input side.

					// x and y for the bottom right of the text so it expands like right aligned text
					$x_coord = $this->data['caption_coords'][$caption_number]['letter_left'][0]+2;//for padding.
					$y_coord = $this->data['caption_coords'][$caption_number]['letter_top'][0];
					//print_r($this->data);exit;

					//$font_Size
					$font_size = $this->data['caption']['size'][$i];						
					if(!empty($this->data['caption']['auto_size'][$i]) && !is_numeric($this->data['caption']['size'][$i])){
						$font_size = $this->data['caption']['auto_size'][$i]; //autosized, already converted to PT!
					}

					if($this->data['caption']['text_style']!='lower'){
						$this->data['caption']['body'][$i]= strtoupper($this->data['caption']['body'][$i]);
					}

					$lines=explode("<BR>",strtoupper($this->data['caption']['body'][$i]));

//					$lines = preg_split("/(\n|<br>)/",$this->data['caption']['body'][$i]);
					$stroke_width = 3;
					// if($font_size<65){
					// 	$stroke_width=2;
					// }
//					print $font_size;exit;

					for($z=0; $z< count($lines); $z++){
						if(trim($lines[$z])==''){ continue; }
					//	$newY = $y_coord + ($z * $font_size * 1)-5;//adding 5 for bottom padding considerations.
						$newY = $y_coord;// + ($z * $font_size * 1)-5;//adding 5 for bottom padding considerations.
						$x2 = false;
						if($z>0){//more than one line in this caption.  tricky.
							// print $newY;
							// print "font ".$font_size;
							// exit;
							//$newY += ($stroke_width*2)+5;//add extra cushion for stroke width top and bottom.//5; //for line height.. $font_size;
							if(isset($this->data['caption_coords'][$caption_number]['letter_left'][$z])){
								$newY = $y_coord+$this->data['caption_coords'][$caption_number]['letter_top'][$z];

								$x2 = $this->data['caption_coords'][$caption_number]['letter_left'][$z]+2;
							}
						}
						if($x2!==false){
							// print $x2;
							// print $newY;exit;
							$this->Meme->imagettfstroketext($image, $font_size, 0, $x2, $newY, $font_color, $stroke_color, $font_file, $lines[$z], $stroke_width);
							$x2=false;
						} else{
							$this->Meme->imagettfstroketext($image, $font_size, 0, $x_coord, $newY, $font_color, $stroke_color, $font_file, $lines[$z], $stroke_width);
						}
						

						
				    }
				}
			}
			$this->Meme->imagettfstroketext($image, 8, 0, ($image_height[0]-90), ($image_height[1]-2), $white, $stroke_color, $font_file, 'SPORTSMEMES.COM', 1);

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
		
			$this->MemeTag->saveTags($data['meme_id'],$this->data['meme']['tags'],$this->Auth->user('id'));

			$this->redirect('/memes/view/'.$data['meme_id']);
			exit;
  		
  		}
  		
  	//	$teams = $this->Team->getTeamsBySport();
		//$data['leagues'] = $teams['leagues'];
	//	$data['teams'] =  $teams['teams'];
	//	$data['leagues'] = $this->League->getAll();
		$data['sports'] = $this->Sport->getAllWithChildren();
		$data['meme']=$this->Meme->read(null,$meme_id);
		if($data['meme']['Meme']['active'] == 1){
			$this->redirect('/memes/view/'.$meme_id);
			exit;
		}
		$data['user'] = $this->Auth->user();
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
		$data=$this->Meme->find('first',array('conditions'=>array('Meme.id'=>$meme_id)));
		if(empty($data)){
			$this->redirect('/memes/browse');
		} elseif($data['Meme']['deleted']==1 || $data['Meme']['active']==0){
			$this->Session->setFlash('This meme is no longer visible.');
			$this->redirect('/memes/browse');
		}
		$data['user_id'] = $this->Auth->user('id');
		$data['owner']=true;
		$this->Meme->updateViewCount($meme_id,$data['Meme']['view_count']);
		$data['jumpToLinks'] = $this->Meme->findPrevAndNext($meme_id);
		if($data['Meme']['user_id'] > 0){
			$data['creator']=$this->User->getUserName($data['Meme']['user_id']);
			$data['creator_slug'] = $this->User->getUrlPart($data['creator'].'-'.$data['Meme']['user_id']);
		}
		else{
			$data['creator']='Bart Simpy';
			$data['creator_slug'] = 'bartsimpy-0';
		}

		$data['meme_rating'] = $data['Meme']['rating'];//$this->Meme->getRating($data['Meme']['id']);
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
	
	function users($user_id=null){
		$user_id = $this->checkId($user_id,'User');
		if(empty($user_id) || $user_id==null || $user_id<0){
			$user = $this->Auth->user();
			if(!empty($user)){
				$user_id = $user['User']['id'];
			} else{
				$this->redirect('/memes');
			}
		} 
		$data['user'] = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
		if(empty($data['user'])){
			$this->redirect('/memes');				
		}

		$data['sort'] = $this->Meme->getSortParam($_GET,$this->params);
		$data['memes'] = $this->Meme->findAllByUserId($user_id);
		$this->set('data',$data);
	}

	function saveFavorite(){
		if(!empty($this->params['form'])){
			$this->loadModel('UserFavorite');
			$data = array('meme_id'=>$this->params['form']['meme_id'],'ip_address' => $_SERVER['REMOTE_ADDR'],	
				'favorite' => $this->params['form']['favorite']);
			$user = $this->Auth->user();
			$new_count = $this->UserFavorite->saveFavorite($data,$user);
			$this->Session->write('favorite_count',$new_count);
		}
		exit;
	}

	function saveRating(){
		if(isset($_POST['meme_id'])){
			$user_id = $this->Auth->user('id');
			$meme_rating_id = $this->MemeRating->checkIfUserHasRated($_POST['meme_id'],$user_id);
			//pr($meme_rating_id);
			$score = $this->MemeRating->saveScore($meme_rating_id,$user_id,$_POST);
			$new_rating = $this->Meme->updateRating($_POST['meme_id'],$score);
			//$new_rating = $this->MemeRating->getRating($_POST['meme_id']);
			echo json_encode(array('value'=>$new_rating));
		}
		exit;		

	}
	

	function delete($meme_id=null){
		$formSubmit = false;
		if($meme_id==null && !empty($this->data)){
			$meme_id = $this->data['meme_id'];
			$formSubmit = true;
		}
	
		$data['user'] = $this->Auth->user();
		if($this->Meme->checkMemeOwner($meme_id,$data['user'])){
			$this->Meme->deleteMeme($meme_id);
		}
		if($formSubmit){
			print "deleted.";
			exit;
		} else{
			$this->Session->setFlash('Your meme has been wiped out.');	
			$this->redirect('/memes/browse');			
		}


	}
	
	function favorites(){
		if($this->Auth->user()){
			//$data['favorites'] = $this->Meme->
		}
	
	}
}

?>