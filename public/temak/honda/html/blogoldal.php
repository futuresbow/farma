 


<?php if(!isset($post->id)) return;?>
<?php $post = new Post_osztaly($post->id);  ?>


<!-- start: news -->
<div class="news clearfix">

    <!-- start: static -->
    <div class="static">
        <div class="inner">

            <img src="<?= base_url().ws_image($post->fokep, 'big')?>" alt="<?= $post->cim;?>">

            <h1><?= $post->cim;?></h1>
            <?php if($post->bevezeto!=''):?>
            <p class="lead"><?= $post->bevezeto; ?></p>
            <?php endif; ?>
            <?= $post->szoveg;?>
        </div>
    </div>
    <!-- end: static -->
    <?php if(isset($lista[0])): ?>
    <!-- start: news-list -->
    <div class="news-list">
        <div class="inner">
            <h4>További híreink</h4>
            <ul>
                <?php if(!empty($lista)) for($i = 0; $i < count($lista); $i++): $post = new Post_osztaly($lista[$i]->id);?>
                <li>
                    <div class="img-container">
                        <a href="<?= $post->link('hirek');?>" title="">
                            <img src="<?= base_url().ws_image($post->fokep, 'small')?>" alt="<?= $post->cim;?>" />
                        </a>
                    </div>
                    <div class="details">
                        <a href="" title="" class="title">
                            <?= $post->cim;?>
                        </a>
                        <div class="date"> <?= date('Y. m. d.', strtotime($post->datum) );?></div>
                        <div class="lead"><?= $post->bevezeto;?></div>
                    </div>
                </li>
                <?php endfor; ?>
             
            </ul>
            
        </div>
    </div>
    <!-- start: end-list -->
    <?php endif; ?>
</div>
<!-- end: news -->




