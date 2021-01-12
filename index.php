
	<?php
 // header('Content-type: text/html; charset=utf-8');

	
	$search=$_GET['search'];
$link="https://www.youtube.com/results?search_query=".rawurlencode($search)."";
//

$html=file_get_contents($link);
$imgs = array();
$dom = new domDocument;
@$dom->loadHTML($html);
$dom->preserveWhiteSpace = false;
$images = $dom->getElementsByTagName('script');
$teny ='; window"[
   "ytInitialPlayerResponse"
]"= null; if (window.ytcsi)"{
   "window.ytcsi.tick(""pdr",
   null,
   """);"
}';


foreach ($images as $image) {

$imgs[] = $image->nodeValue;//atribut qui sort l'image
}

$vowels = array('window["ytInitialData"] = ','');
$suite= str_replace($vowels, "", $imgs[26]);
$result= substr($suite,0,strlen($suite)-110);
//print_r($result);

//echo $result;
$data= array();
$parsed_json= json_decode($result);
  for ($i=0; $i <22 ; $i++) {
    $data[]=$parsed_json->{'contents'}->{'twoColumnSearchResultsRenderer'}

  ->{'primaryContents'}->{'sectionListRenderer'}->{'contents'}[0]
  ->{'itemSectionRenderer'}->{'contents'}[$i];
  }




for ($i=0; $i <22 ; $i++) {
	if ($data[$i]->{'videoRenderer'}->{'videoId'}!='') {

		 echo '


		      <div class="card" style="width: 18rem;">
		        <img src="'.$data[$i]->{'videoRenderer'}->{'thumbnail'}
						->{'thumbnails'}[3]->{'url'}.'" class="card-img-top" alt="...">
		        <div class="card-body">
		        <h5 class="card-title">'.$data[$i]->{'videoRenderer'}->{'title'}
						->{'runs'}[0]->{'text'}.'</h5>

		          <p class="card-text">'.$data[$i]->{'videoRenderer'}->{'descriptionSnippet'}
							->{'runs'}[0]->{'text'}.'</p>
							      <form method="get" action="mp3_recieve.php" target="_blank"  >
		                  <input type="hidden" name="id" value="'.$data[$i]->{'videoRenderer'}->{'videoId'}.'" >
		                  <input type="hidden" name="title" value="'.str_replace('a','',$data[$i]->{'videoRenderer'}->{'title'}
                      ->{'runs'}[0]->{'text'}).'" >
		                  <input type="hidden" name="channel" value="'.rawurlencode($data[$i]->{'videoRenderer'}->{'longBylineText'}
											->{'runs'}[0]->{'text'}).'" >



		                 </form>

		        </div>
		    </div>




		  ';
		// code...
	}
}
	?>


  <?php

 ?>





  </div>
	</div>
 </div>


    <script src="js/jquery.min.js"></script>
	    <script src="js/bootstrap.min.js"></script>
	    <script src="js/bootstrap.js"></script>
	</body>
	</html>
