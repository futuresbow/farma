
	<?php foreach($hirlista as $post):?>
    <!-- start: static -->

            <img src="<?= base_url().ws_image($post->fokep, 'big')?>" alt="<?= $post->cim;?>">			<br>

            <h1><?= $post->cim;?></h1>
            <p class="lead"><?= $post->bevezeto;?></p>
            <a href="<?= $post->link;;?>" title="Hírek" class="more-news">Tovább</a>
    <!-- end: static -->
	<?php endforeach;?>
    
    
    <!-- start: news-list -->

            <h4>További híreink</h4>
            <ul>
                <?php foreach($hirlista as $sor):?>
                <li>

                        <a href="<?= $sor->link; ?>" title="<?= $sor->cim;?>">
                            <img src="<?= base_url().ws_image($sor->fokep, 'smallboxed')?>" alt="<?= $sor->cim;?>">
                        </a>


                        <a href="<?= $sor->link; ?>" title="<?= $sor->cim;?>" class="title">
                            <?= $sor->cim;?>
                        </a>
                        <p><?= ws_date($sor->datum); ?></p>
                        <p><?= $sor->bevezeto; ?></p>
                    
                </li>
				<?php endforeach;?>
            </ul>
            <a href="<?= base_url().beallitasOlvasas('post.oldal.url');?>" title="Hírek" class="more-news">További hírek betöltése</a>