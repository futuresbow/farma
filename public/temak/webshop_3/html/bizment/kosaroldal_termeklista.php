<?php if(!empty($rendeles->termekLista)) : ?>
					<table>
					<?php foreach($rendeles->termekLista as $termek):?>
                        <tr>
                            <td class="thumb"><img src="<?= $termek->fokep()?base_url().ws_image($termek->fokep(), 'smallboxed'):beallitasOlvasas('kepek.nincskepurl'); ?>"></td>
                            <td class="prod-name">								<a href="<?=  $termek->link(); ?>" title="" class="prod-name"><?=  $termek->kosarTermekNev(); ?></a>
								<div class="unit-price">Egységár: <?=  PN_ELO.' '.ws_arformatum($termek->kosarDarabAr()).' '.PN_UTO; ?></div>

								<?php if($termek->vannakKosarOpciok()):?>
									<?php foreach($termek->kivalasztottOpciok as $opcio):?>									&nbsp;&nbsp;&nbsp;&nbsp;<i><?= $opcio->nev ?></i><br>									<?php endforeach;?>
								<?php endif;?>
                            </td>
                           
                            <td class="quantity">
                                <div class="quantity-container ">
                                    <a href="javascript:void(0);" onclick="siteJs.kosarDarabModositas('<?= $termek->kosarId;?>',-1);" title="minus"  class="minus desc <?= $termek->kosarDarabszam()==1?' del ':''?>"></a> <!-- + "del" class, if quantity = 1 -->
                                    <input type="text" readonly name="" value="<?= $termek->kosarDarabszam(); ?>">
                                    <a href="javascript:void(0);" onclick="siteJs.kosarDarabModositas('<?= $termek->kosarId;?>',1);" title="minus"  class="plus asc"></a>
                                </div>
                            </td>
                            <td class="price"><?=  PN_ELO.' '.ws_arformatum($termek->kosarOsszNettoAr()).' '.PN_UTO; ?></td>
                        </tr>
                        
                    <?php endforeach ; ?>
                        
                        <tr>
                            <td colspan="3" class="single-line"><?= __f('Termékek összesen');?></td>
                            <td class="price"><?= PN_ELO.' '.ws_arformatum($rendeles->osszNetto()).' '.PN_UTO; ?></td>
                        </tr>
                        <tr>

                            <td colspan="3" class="single-line"><?= __f('Termékek összesen');?></td>

                            <td class="price"><?= PN_ELO.' '.ws_arformatum($rendeles->osszAfa()).' '.PN_UTO; ?></td>

                        </tr>
                        <tr>

                            <td colspan="3" class="sum"><?= __f('Termékek összesen');?></td>

                            <td class="price"><?= PN_ELO.' '.ws_arformatum($rendeles->osszBrutto()).' '.PN_UTO; ?></td>

                        </tr>
                    </table>
<?php else: ?>
<script>$().ready(function(){ window.location.href='<?= base_url().beallitasOlvasas('kosar.oldal.url'); ?>'; });</script>
<?php endif; ?>           
