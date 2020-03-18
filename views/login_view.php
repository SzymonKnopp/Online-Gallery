<!DOCTYPE html>
<head>
		<meta charset="utf-8" />
		<title>Logowanie</title>
		<link rel="stylesheet" href="static/style.css">
</head>
<body>
	<header>
		<div id="title">Logowanie użytkownika</div>
	</header>

	<nav>
		<div style="border: solid black 3px; padding: 10px; width: 150px">
			<a href='register'>Zarejestruj się</a></br>
			<a href='upload'>Dodaj zdjęcie</a></br>
			<a href='/'>Galeria</a></br>
			<a href='savedGallery'>Zapisane zdjęcia</a></br>
            <a href='searchGallery'>Wyszukiwarka zdjęć</a></br>
		</div>
	</nav>

	<main style="margin-left: 200px">
		<?=$message?>
		<form method="post">
				Login:	<input type="text" name="login" required="true"/><br />
				Hasło:	<input type="password" name="pass" required="true"/><br />
						<input type="submit" value="Logowanie"/>
		</form>
	</main>
</body>