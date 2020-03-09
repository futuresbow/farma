<?php

$ci = getCI();
$valtozok = $ci->Sql->gets('temavaltozok', " WHERE tema = 'it' ");

if($valtozok) foreach($valtozok as $sor) {
	${$sor->kulcs} = $sor->ertek;

}
