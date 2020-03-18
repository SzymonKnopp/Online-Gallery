<?php
	require '../business.php';

	$_SESSION['user'] = [];
	$images = $db->images->find();
	foreach ($images as $image) {
		$db->images->deleteOne($image);
	}
	echo 'Wyczyszczono zdjęcia';