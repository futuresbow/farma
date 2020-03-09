<?php

$ci = getCI();
$valtozok = $ci->Sql->gets('temavaltozok', " WHERE tema = 'fashion' ");

if($valtozok) foreach($valtozok as $sor) {
	${$sor->kulcs} = $sor->ertek;

}
