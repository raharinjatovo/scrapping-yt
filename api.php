
  <?php

header("Content-Type: application/json; charset=UTF-8");
  //prise de données par youtube api 50 resultat
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
$response = array();
$response["data"] = array();
  for ($i=0; $i <22 ; $i++) {

    $data[]=$parsed_json->{'contents'}->{'twoColumnSearchResultsRenderer'}

  ->{'primaryContents'}->{'sectionListRenderer'}->{'contents'}[0]
  ->{'itemSectionRenderer'}->{'contents'}[$i];
  }




for ($i=0; $i <22 ; $i++) {
  if ($data[$i]->{'videoRenderer'}->{'videoId'}!='') {
            $product = array();
            $product["id"] = $data[$i]->{'videoRenderer'}->{'videoId'};
            $product["title"] = $data[$i]->{'videoRenderer'}->{'title'}
->{'runs'}[0]->{'text'};

            $product["image"] = $data[$i]->{'videoRenderer'}->{'thumbnail'}
->{'thumbnails'}[3]->{'url'};
            $product["description"] = $data[$i]->{'videoRenderer'}->{'descriptionSnippet'}
->{'runs'}[0]->{'text'};
            $product["channel"] = $data[$i]->{'videoRenderer'}->{'longBylineText'}
->{'runs'}[0]->{'text'};
            $product["duration"] = $data[$i]->{'videoRenderer'}->{'lengthText'}
->{'simpleText'};
             $product["views"] = $data[$i]->{'videoRenderer'}->{'viewCountText'}
->{'simpleText'};
   array_push($response["data"], $product);

    // code...
  }
}
echo json_encode($response);
  ?>
