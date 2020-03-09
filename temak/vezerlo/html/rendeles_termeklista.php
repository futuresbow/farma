<?php


?>
<div class="box-item scrollable">

                <div class="scrollable-container">

                    <div class="scrollable-item">

                        <table class="data-table">
                            <tbody><tr class="table-head">
                                <th>Kép</th>
                                <th>Terméknév</th>
                                <th>Egységár</th>
                                <th class="align-center">Darabszám</th>
                                <th class="align-right">Összesen nettó</th>
                            </tr>
                            <?php $osszar = 0; $osszarBrutto = 0; foreach($lista as  $t): ?>
                            <?php $osszar += $t->megrendeltOsszAr(); $osszarBrutto += $t->megrendeltOsszBruttoAr(); ?>
                            <tr >
                                <td>
                                    <div class="pic-container" style="background-image: url('<?= $t->fokep()?base_url().ws_image($t->fokep(), 'smallboxed'):beallitasOlvasas('kepek.nincskepurl');?>');"></div>
                                </td>
                                <td>
									<a href="<?= $t->link(); ?>" target="_blank" title=""><?= $t->nev; ?></a> 
									<?php if($t->megrendeltValtozat()):$v = $t->megrendeltValtozat();?>
									<br><b style="verzioLabel"><?= $v->nev." (".ws_arformatum($v->ar).") "; ?> <a><sup onclick="aJs.rendelesValtozatTorles(<?= $t->rendeles_id; ?>,<?= $t->id; ?>,<?= $v->id; ?>);"><i class="fas fa-times-circle"></i></sup></a></b>
									<?php endif;?>
									&nbsp;&nbsp;
									<?php if($t->megrendeltValtozat2()):$v = $t->megrendeltValtozat2();?>
									<br><b style="verzioLabel"><?= $v->nev." (".ws_arformatum($v->ar).") "; ?> <a><sup onclick="aJs.rendelesValtozatTorles2(<?= $t->rendeles_id; ?>,<?= $t->id; ?>,<?= $v->id; ?>);"><i class="fas fa-times-circle"></i></sup></a></b>
									<?php endif;?><br>
									
									<?php if($t->megrendeltOpciok()) foreach($t->megrendeltOpciok() as $sor):?>
									<span style="opcioLabel"><?= $sor->nev." ( +".ws_arformatum($sor->ar).") "; ?> <a><sup onclick="aJs.rendelesOpcioTorles(<?= $t->rendeles_id; ?>,<?= $t->id; ?>,<?= $sor->id; ?>);"><i class="fas fa-times-circle"></i></sup></a></span>&nbsp;
									<?php endforeach;?>
                                </td>
                                <td class="align-right nowrap"><?= PN_ELO.' '.ws_arformatum($t->megrendeltEgysegAr()).' '.PN_UTO;?></td>
                                <td class="align-center">
                                    <div class="quantity clearfix">
                                        <a href="javascript:void();"  onclick="aJs.rendelesTermekDb(<?= $t->rendeles_id; ?>,<?= $t->id; ?>,-1);" title="" class="btn btn-small decrease <?= ($t->darab==1)?'del':'';?>"></a>
                                        <input type="text" name="" value="<?= $t->darab;?>">
                                        <a href="javascript:void();"  onclick="aJs.rendelesTermekDb(<?= $t->rendeles_id; ?>,<?= $t->id; ?>,1);" title="" class="btn btn-small increase"></a>
                                    </div>
                                </td>
                                <td class="align-right nowrap bold"><?= PN_ELO.' '.ws_arformatum($t->megrendeltOsszAr()).' '.PN_UTO;?></td>
                            </tr>
                            <tr class="opciosTablaSor">
								<td colspan="1"></td>
								<td colspan="1">
									<label>Változat: </label>
									<?php if($t->valtozatok()):?>
									<select id="valtozat" class="">
										<?php
											foreach($t->valtozatok() as $valtozat):
											?>
											<option value="<?= $valtozat->id; ?>"><?= $valtozat->nev ?></option>
											<?php
											endforeach;
										?>
									</select><input class="selectbtn" style="border-left:none;" onclick="aJs.rendelesTermekValtozatMentes(<?= $t->rendeles_id; ?>,<?= $t->id; ?>,this)" type="button" value="Kiválaszt">
									<?php else: ?>
									<input disabled type="text" value="Nincs változat">
									<?php endif; ?>
									
									
								</td>
								<td colspan="1">
									<label>Változat: </label>
									<?php if($t->valtozatok2()):?>
									<select id="valtozat" class="">
										<?php
											foreach($t->valtozatok2() as $valtozat):
											?>
											<option value="<?= $valtozat->id; ?>"><?= $valtozat->nev ?></option>
											<?php
											endforeach;
										?>
									</select><input class="selectbtn" style="border-left:none;" onclick="aJs.rendelesTermekValtozatMentes2(<?= $t->rendeles_id; ?>,<?= $t->id; ?>,this)" type="button" value="Kiválaszt">
									<?php else: ?>
									<input disabled type="text" value="Nincs változat">
									<?php endif; ?>
									
									
								</td>
								<td colspan="3">
									<label>Opciók: </label>
									<?php if($t->opciok()):?>
									<select id="valtozat" class="">
										<?php
											foreach($t->opciok() as $opcio):
											?>
											<option value="<?= $opcio->id; ?>"><?= $opcio->nev ?></option>
											<?php
											endforeach;
										?>
									</select><input class="selectbtn" style="border-left:none;" onclick="aJs.rendelesTermekOpcioMentes(<?= $t->rendeles_id; ?>,<?= $t->id; ?>,this)" type="button" value="Hozzáad">
									<?php else: ?>
									<input disabled type="text" value="Nincs opció">
									<?php endif; ?>
								</td>
                            </tr>
                            <?php endforeach;?>
                            
                        </tbody></table>

                    </div>

                </div>

            </div>
            
            <div class="box">

            <div class="box-item double">

                <div class="item-label">
                    Termékek összesen
                    <div class="price-details">
                        <div>ÁFA-tartalom</div>
                        <div>Nettó érték összesen</div>
                    </div>
                </div>

                <div class="price-container">
                    <?= PN_ELO.' '.ws_arformatum($osszar).' '.PN_UTO;?>
                    <div class="price-details">
                        <div><?= PN_ELO.' '.ws_arformatum($osszarBrutto-$osszar).' '.PN_UTO;?></div>
                        <div><?= PN_ELO.' '.ws_arformatum($osszarBrutto).' '.PN_UTO;?></div>
                    </div>
                </div>

            </div>

        </div>
        <?php if($modositoHTLM!='') print $modositoHTLM; ?>
        
        <div class="box">

            <div class="box-item fw">

                <div class="input-container">
                    <div class="label-container">
                        <label class="important">Költségek és kedvezmények</label>
                    </div>
                    <div class="input-select-container">
                        <div class="styled-select">
                            <select onchange="aJs.rendelesKoltsegHozzaadas(<?= $t->rendeles_id; ?>,this)">
                                <option >Szállítás, fizetés, költség, kedvezmény hozzáadása</option>
                                <option value="szallitasmod">Szállítási mód</option>
                                <option value="fizetesmod">Fizetési mód</option>
                                <option value="kedvezmeny">Kedvezmény</option>
                                <option value="egyeb">Egyedi</option>
                                
                            </select>
                        </div>
                    </div>
                </div>

               
            </div>

        </div>
        
        <div class="box">

            <div class="box-item double">

                <div class="item-label">
                    Megrendelés összár
                    <div class="price-details">
                        <div>ÁFA-tartalom</div>
                        <div>Bruttó érték összesen</div>
                    </div>
                </div>

                <div class="price-container">
                    <?= PN_ELO.' '.ws_arformatum($rendeles->megrendelesOsszar()).' '.PN_UTO;?>
                    <div class="price-details">
                        <div><?= PN_ELO.' '.ws_arformatum($rendeles->megrendelesOsszarAfa()).' '.PN_UTO;?></div>
                        <div><?= PN_ELO.' '.ws_arformatum($rendeles->megrendelesOsszarBrutto()).' '.PN_UTO;?></div>
                    </div>
                </div>

            </div>

        </div>
        
        <div class="box box-dark box-flat">

            <div class="box-item double summ-item">

                <div class="item-label">Fizetendő összesen</div>
                <div class="price-container"><?= PN_ELO.' '.ws_arformatum($rendeles->megrendelesOsszarBrutto()).' '.PN_UTO;?></div>

            </div>

        </div>
