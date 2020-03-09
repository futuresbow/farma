<div class="box">

            <div class="box-item scrollable">

                <div class="scrollable-container">

                    <div class="scrollable-item">

                        <table class="data-table" id="<?= $sortableId;?>">

                            <tbody><tr class="table-head"> <!-- + class="items-selected" if there's selected items -->
                                <th class="chk-column">
								#
                                </th>
                                <?php foreach($megjelenitettMezok as $k => $felirat):?>
                                <th><span><?= $felirat; ?></span></th>
                                
                                <?php endforeach; ?>
                                <?php if($sortable):?>
                                 <th class="align-right">Áthelyezés</th>
                                <?php endif;?>
                            </tr>
                            <?php $r = rand(0,9999);if($lista):foreach($lista as $kulcs => $sor):?>
                            <tr data-id="<?= $sor->id; ?>">
								<td style="<?= (isset($sor->mezoSzin))?' background:'.$sor->mezoSzin:''?>">
                                    <?= $sor->id;?>
                                </td>
                                <?php foreach($megjelenitettMezok as $k => $felirat):?>
                                <?php if($k == 'szerkesztes'):?>
                                <td >
                                <a href="<?= ADMINURL.$szerkeszto_url.$sor->id; ?>"><span>szerkesztés</span></a>
                                </td>
                                
                                <?php elseif($k=='torles'):?>
                                                                <td >
                                <a onclick="return confirm('Kérem, erősítsd meg a törlést!');" href="<?= ADMINURL.$torles_url.$sor->id; ?>"><span>törlés</span></a>
                                </td>
                                
                                <?php else:?>
                                <td <?= (isset($cellaAttr[$k]))?$cellaAttr[$k]:''; ?>><?= @$sor->$k; ?></td>
                                <?php endif; ?>
                                <?php endforeach; ?>
                                
                                <?php if($sortable):?>
                                 <td class="align-right nowrap bold"><div class="move"></div></td>
                                <?php endif;?>
                            </tr>
                           <?php endforeach;endif; ?>
                      
                        </tbody></table>

                    </div>

                </div>

            </div>

        </div>
 
