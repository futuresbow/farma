 





<!-- start: breadcrumb -->

<div class="breadcrumb">

    <ul>

        <li><a href="<?= base_url();?>" title="Főoldal">Főoldal</a></li>

        <li title="Hírek">Hírek</li>

        

    </ul>

</div>

<!-- end: breadcrumb -->





<!-- start: news -->

<div class="news clearfix">

	

	<?php foreach($hirlista as $post):?>

    <!-- start: static -->

    <div class="static">

        <div class="inner">



            <img src="<?= base_url().ws_image($post->fokep, 'big')?>" alt="<?= $post->cim;?>">



            <h1><?= $post->cim;?></h1>

            <p class="lead"><?= $post->bevezeto;?></p>

            <a href="<?= $post->link;;?>" title="Hírek" class="more-news">Tovább</a>

        </div>

    </div>

    <!-- end: static -->

	<?php endforeach;?>

    

    

    <!-- start: news-list -->

    <div class="news-list">

        <div class="inner">

            <h4>További híreink</h4>

            <ul>

                <?php foreach($hirlista as $sor):?>

                <li>

                    <div class="img-container">

                        <a href="<?= $sor->link; ?>" title="<?= $sor->cim;?>">

                            <img src="<?= base_url().ws_image($sor->fokep, 'smallboxed')?>" alt="<?= $sor->cim;?>">

                        </a>

                    </div>

                    <div class="details">

                        <a href="<?= $sor->link; ?>" title="<?= $sor->cim;?>" class="title">

                            <?= $sor->cim;?>

                        </a>

                        <div class="date"><?= ws_date($sor->datum); ?></div>

                        <div class="lead"><?= $sor->bevezeto; ?></div>

                    </div>

                </li>

				<?php endforeach;?>

            </ul>

            <a href="<?= base_url().beallitasOlvasas('post.oldal.url');?>" title="Hírek" class="more-news">További hírek betöltése</a>

        </div>

    </div>

    <!-- start: end-list -->



</div>

<!-- end: news -->



