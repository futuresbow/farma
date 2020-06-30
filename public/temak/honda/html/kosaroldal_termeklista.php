
<?php if(!empty($rendeles->termekLista)) : ?>
<?php $armod = (beallitasOlvasas('armod-osszesito')=="0")?'Nettó':'Bruttó'; ?>
					<table>

					<?php foreach($rendeles->termekLista as $termek):?>

                        <tr>

                            <td class="img-container"><img src="<?= $termek->fokep()?base_url().ws_image($termek->fokep(), 'smallboxed'):beallitasOlvasas('kepek.nincskepurl'); ?>"></td>

                            <td class="prod-name">

								<?=  $termek->kosarTermekNev(); ?>

								<?php if($termek->vannakKosarOpciok()):?>

									

									<?php foreach($termek->kivalasztottOpciok as $opcio):?>

									&nbsp;&nbsp;&nbsp;&nbsp;<i><?= $opcio->nev ?></i><br>

									<?php endforeach;?>

								<?php endif;?>

                            </td>

                            <td class="one-price"><?=  PN_ELO.' '.ws_arformatum($termek->kosarDarabAr()).' '.PN_UTO; ?></td>

                            <td class="quantity">

                                <div class="quantity-container clearfix">

                                    <a href="javascript:void(0);" onclick="siteJs.kosarDarabModositas('<?= $termek->kosarId;?>',-1);" title="minus"  class="minus <?= $termek->kosarDarabszam()==1?' del ':''?>"></a> <!-- + "del" class, if quantity = 1 -->

                                    <input type="text" readonly name="" value="<?= $termek->kosarDarabszam(); ?>" >
									<?php $keszlet = $termek->elerhetoKeszlet((int)@$termek->kivalasztottValtozat->id, (int)@$termek->kivalasztottValtozat2->id);?>
									
									<?php if($keszlet>$termek->kosarDarabszam()):?>
                                    <a href="javascript:void(0);" onclick="siteJs.kosarDarabModositas('<?= $termek->kosarId;?>',1);" title="minus"  class="plus"></a>
									<?php endif; ?>
                                </div>

                            </td>
							
                            <td class="all-price"><?=  PN_ELO.' '.ws_arformatum(($armod=="Bruttó")?$termek->kosarOsszBruttoAr():$termek->kosarOsszNettoAr()).' '.PN_UTO; ?></td>

                        </tr>

                        

                    <?php endforeach ; ?>

                        

                        <tr>

                            <td colspan="4" class="prod-name prod-all"><?= __f('Termékek összesen');?></td>

                            <td class="all-price"><?= PN_ELO.' '.ws_arformatum(($armod=="Bruttó")?$rendeles->osszBrutto():$rendeles->osszNetto()).' '.PN_UTO; ?></td>

                        </tr>

                    </table>

<?php else: ?>

<script>$().ready(function(){ window.location.href='<?= base_url().beallitasOlvasas('kosar.oldal.url'); ?>'; });</script>

<?php endif; ?>           

