<div class="box box-dark box-flat">

            <div class="pagination-container">

                <div class="bottom-controls">
                    <div class="show-items" style="display:none">
                        <div class="input-container">
                            <div class="input-select-container">
                                <div class="styled-select">
                                    <select>
                                        <option>20 / oldal</option>
                                        <option>50 / oldal</option>
                                        <option>100 / oldal</option>
                                        <option>Mind</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="showed">
                        <span><?= $start+1;?> - <?= $start+$limit;?></span> / <?= $osszTalalat; ?>
                    </div>
                </div>
				<?php 
				?>
                <div class="pagination">
                    <ul>
                        <?php if(isset($prev)):?>
                        <li><a href="?<?= $prev;?>" title="" class="prev"></a></li>
						<?php endif; ?>
						<?php if($lapozoGombok) foreach($lapozoGombok as $gomb):?>
                        <li><a href="?<?= $gomb['link'];?>" class="<?= $gomb['class'];?>" title="<?= $gomb['felirat'] ;?>"><?= $gomb['felirat'] ;?></a></li>
                        <?php endforeach ;?>
                         <?php if(isset($next)):?>
                        <li><a href="?<?= $next;?>" title="" class="next"></a></li>
						<?php endif; ?>
                    </ul>
                </div>
            </div>

        </div>
