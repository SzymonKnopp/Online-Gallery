<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Galeria</title>
        <link rel="stylesheet" href="static/style.css">
    </head>
    <body>
        <header>
            <div id="title">Galeria zdjęć</div>
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
                <a href='savedGallery'>Zapisane zdjęcia</a></br>
                <a href='searchGallery'>Wyszukiwarka zdjęć</a></br>
            </div>
            <?php if(isset($_SESSION['user'])) echo "Zalogowano jako: </br>" . $_SESSION['user'];?>
        </nav>

        <main>
            <form method="post" style="display: flex; justify-content:center; align-items: center">
                <?php if($lastPage!=0):?>
                    <div style="width: 200px">
                        <?php
                            if($page>1) echo ("<a href='?page=" . ($page-1) . "'>Poprzednia strona</a>");
                        ?>
                    </div>

                    <div style="width: 660px; height: 340px; display:flex; flex-wrap: wrap">
                            <?php foreach($images as $image):?>
                                <div style="width: 200px;  height: 170px; padding: 10px; display:flex; flex-wrap: wrap">
                                    <a href="static/images/watermark/<?=$image['src']?>">
                                        <img src='static/images/miniature/<?=$image['src']?>'/>
                                    </a>
                                    <div style="width: 200px;  height: 45px; text-align:center">
                                        <input  type="checkbox" value="true" 
                                                name="checked[<?=$image['src']?>]">
                                        <?php
                                            echo $image['title'];
                                            if ($image['user'] != '') echo ' (prywatny)';
                                            echo '</br>'.$image['author']?>

                                    </div>
                                </div>
                            <?php endforeach?>
                    </div>

                    <div style="width: 200px">
                        <?php
                            if($page!=$lastPage) echo ("<a href='?page=" . ($page+1) . "'>Następna strona</a>");
                        ?>
                    </div>
                    <input type="submit" value="Zapisz zaznaczone"/>
                <?php endif?>
                <?php if($lastPage==0) echo "Nic tu nie ma :/</br></br>Dodaj jakieś zdjęcia!";?>
            </form>
        </main>
    </body>
</html>