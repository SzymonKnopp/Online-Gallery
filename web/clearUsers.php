<?php
	require '../business.php';

	$users = $db->users->find();
	foreach ($users as $user) {
		$db->users->deleteOne($user);
	}
	echo 'Wyczyszczono użytkowników';