<?php if(isset($images)):?>
    <div style="width: 660px; display:flex; flex-wrap: wrap">
        <?php foreach($images as $image):?>
            <div style="width: 200px;  height: 170px; padding: 10px; display:flex; flex-wrap: wrap">
                <a href="static/images/watermark/<?=$image['src']?>">
                    <img src='static/images/miniature/<?=$image['src']?>'/>
                </a>
                <div style="width: 200px;  height: 45px; text-align:center">
                    <?=$image['title'].'<br/>'.$image['author']?>
                </div>
            </div>
        <?php endforeach?>
    </div>
<?php endif?>