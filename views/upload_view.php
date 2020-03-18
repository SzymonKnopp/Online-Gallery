<!DOCTYPE html>
<html>
    <head>
            <meta charset="utf-8" />
            <title>Dodawanie zdjęcia</title>
            <link rel="stylesheet" href="static/style.css">
    </head>
    <body>
        <header>
            <div id="title">Dodawanie zdjęcia</div>
        </header>

        <nav>
            <div style="border: solid black 3px; padding: 10px; width: 150px">
                <?php if(isset($_SESSION['user'])) echo "
                        <a href='logout'>Wyloguj się</a></br>";
                    else echo "
                        <a href='login'>Zaloguj się</a></br>
                        <a href='register'>Zarejestruj się</a></br>
                "?>
                <a href='/'>Galeria</a></br>
                <a href='savedGallery'>Zapisane zdjęcia</a></br>
                <a href='searchGallery'>Wyszukiwarka zdjęć</a></br>
            </div>
        </nav>

        <main style="margin-left: 200px">
            <?=$message?>
            <form method="post" enctype="multipart/form-data">
                Plik:       <input type="file" name="file" required="true"/><br />
                Tytuł:      <input type="text" name="title" required="true"/><br />
                Autor:      <input type="text" name="author" required="true" value="<?=$user?>"/><br />
                Znak wodny: <input type="text" name="watermark" required="true"/><br />
                <?php if(isset($user)):?>
                Widoczność: <input type="radio" name="user" value='' required="true"/> - publiczny
                            <input type="radio" name="user" value="<?=$user?>" required="true"/> - prywatny</br>
                <?php endif?>
                <?php if(!isset($user)) echo "<input type='hidden' name='user' value=''/>"?>
                            <input type="submit" value="Wyślij"/>
            </form>
        </main>
    </body>
</html>