<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Nie znaleziono strony</title>
        <link rel="stylesheet" href="static/style.css">
    </head>
    <body>
        <header>
            <div id="title">Nie znaleziono strony</div>
        </header>
        <nav>
            <div style="border: solid black 3px; padding: 10px; width: 150px">
                <?php if(isset($_SESSION['user'])) echo "
                    <a href='logout'>Wyloguj się</a></br>";
                else echo "
                    <a href='login'>Zaloguj się</a></br>
                    <a href='register'>Zarejestruj się</a></br>
                "?>
                <a href='upload'>Dodaj zdjęcie</a></br>
                <a href='/'>Galeria</a></br>
                <a href='savedGallery'>Zapisane zdjęcia</a></br>
                <a href='searchGallery'>Wyszukiwarka zdjęć</a></br>
            </div>
            <?php if(isset($_SESSION['user'])) echo "Zalogowano jako: </br>" . $_SESSION['user'];?>
        </nav>
        <main style="display: flex; justify-content:center; align-items: center; font-size: 20px">
            Żądana strona nie istnieje :/
        </main>
    </body>
</html>