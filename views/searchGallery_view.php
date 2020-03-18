<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Wyszukiwarka</title>
        <link rel="stylesheet" href="static/style.css">

        <script>
            function findImages(query){
                if (query.length == 0) {
                    document.getElementById("gallery").innerHTML = "Wpisz część tytułu w pole powyżej";
                    return;
                } else {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("gallery").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET", "getSearchResults?query=" + query, true);
                    xmlhttp.send();
                }
            }
        </script>
    </head>
    <body>
        <header>
            <div id="title">Wyszukiwanie po tytule</div>
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
            </div>
            <?php if(isset($_SESSION['user'])) echo "Zalogowano jako: </br>" . $_SESSION['user'];?>
        </nav>

        <main >
            <form style="margin-left: 300px">
                Tytuł: <input type="text" onkeyup="findImages(this.value)">
            </form>
            </br>
            <div style="display: flex; justify-content:center; align-items: center">
                <span id="gallery">
                    Wpisz część tytułu w pole powyżej
                </span>
            </div>
        </main>
    </body>
</html>