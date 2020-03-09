			<div class="box-item checkboxes">
				
                <?php $r = rand(1,9999);foreach($jelolok as $k => $jelolo): $jelolo->data['id'] = 'chk'.$r.'_'.$k; ?>
				<div class="checkbox-container">
                    <?= $jelolo->kimenet();?>
                    <label for="chk<?= $r.'_'.$k;?>"><?= $jelolo->data['felirat'];?></label>
                </div>
                <?php endforeach; ?>
			</div> 
