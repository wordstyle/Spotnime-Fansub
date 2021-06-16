<?php
$host = "localhost";
$username = "spot_fansub";
$password = "xotH+fe^D2G6nNog";
$database = "spot_fansub";
$config = mysqli_connect($host, $username, $password, $database);

if(!$config){
	die("Koneksi database gagal: " . mysqli_connect_error());
}

if(isset($_GET['id']) && $_GET['id'] == 'spotnime'){

	$getresult = array();

	$getdata = $config->query("SELECT * FROM releases Order By id DESC LIMIT 10");

	while($data = mysqli_fetch_array($getdata)){

		$num_char = 25;
		$text = $data['name'];
		$title = substr($text, 0, $num_char) . '...';

		array_push($getresult,array(
			"title" 		=> $title,
			"pubDate"		=> date("H:d, d M Y",strtotime($data['date'])),
			"link"			=> "https://fansub.spotnime.xyz",
			"guid"			=> "https://fansub.spotnime.xyz",
			"author"		=> "Wordstyle Creator",
			"thumbnail"		=> "https://spotnime.xyz/assets/images/logo-squer.png",
			"description"	=> "Spotnime Channel App",
			"content"		=> "Spotnime Channel App",
			"episode"		=> $data['episode']
		));
	}

	$result=array(
		"uri" 			=> "https://fansub.spotnime.xyz",
		"title" 		=> "spotnime Update",
		"link"			=> "https://fansub.spotnime.xyz",
		"author"		=> "Wordstyle Creator",
		"description"	=> "Latest spotnime Releases",
		"image"			=> "https://spotnime.xyz/assets/images/logo-squer.png"
	);

	echo json_encode(array('status'=>'ok','feed'=>$result, 'items'=>$getresult));
}
?>