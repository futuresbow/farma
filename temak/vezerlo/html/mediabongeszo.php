<div class="utvonal">
	<ul>
		<li><a href="?dir=">Feltöltések mappa</a></li>
		<?php if($utvonal!=''): $utak = explode('/', $utvonal); $dir = ''; foreach($utak as $ut): $dir .= $ut.'/';?>
		<li><a href="?dir=<?= $dir;?>"><?= $ut;?></a></li>
		<?php endforeach; else:  $utvonal = '';endif;?>
	</ul>
</div>
<div class="filelista">
	<div class="jobbpanel">
		<div class="upload">
		
			 <form method="post" enctype="multipart/form-data">

				<input type="file" name="file"> <input type="submit" value="OK" />
			</form>
		</div>
		
		<div class="info">
			
			File adatok
		</div>
	</div>
	<table>
		<tr>
			<th></th>
			<th>Név</th>
			<th>Módosítva</th>
			<th>Méret</th>
		</tr>
		<?php foreach($files as $file): if($file=='.' or $file=='..') continue;$fn = $bDir.$utvonal.'/'.$file; ?>
		<tr data-dir="<?php if(is_dir($bDir.$utvonal.'/'.$file)) print $utvonal.'/'.$file; ?>" data-file="<?= $utvonal.'/'.$file; ?>">
			<td><i class="far fa-file"></i></td>
			<td><?= $file?></td>
			<td><?= date('Y-m-d H:i',filemtime($fn));?></td>
			<td><?= !is_dir($fn)?filesize($fn):''; ?></td>
		</tr>
		
		
		<?php endforeach;?>
	</table>
</div>

<script>
	$().ready(function(){
		$('.filelista td').click(function(e) {
			$('.filelista tr').removeClass('selected');
			$(this).parent().toggleClass('selected');
		})
		$('.filelista td').dblclick(function(e) {
			//console.log( $(this).parent().attr('data-dir') );
			file = $(this).parent().attr('data-dir');
			if(file!='') {
				window.location.href="?dir="+$(this).parent().attr('data-dir');
			} else {
				$('div.info').load("<?= ADMINURL.'media/mediainfo?file='; ?>"+$(this).parent().attr('data-file'));
			}
		})
	});
</script>

<style>
/* TODO: kirakni az extra.css-be*/
.selected td {
	background: #CEFFFA;
}
div.jobbpanel {
	float: right;
	width: 27%;
	padding: 10px;
}
div.upload {
	border: 3px dashed #aaa;
	padding: 10px;
	text-align:center;
	border-radius: 20px;
}
.jobbpanel div.info {
	border: 1px solid #aaa;
	padding: 10px;
	margin: 10px;
	text-align:left;
}
div.filelista {
	position: relative;
	width: 100%;
	text-align:right;
	padding: 20px;
	background: #fff;
	margin: 20px;
	border: 1px solid #ddd;
}
div.filelista table th { 
	background: #aaa;
	color: #fff;
	font-size: 14px;
	font-weight: normal;
	text-align: left;
	padding: 5px 10px; 
}
div.filelista table td { 
	color: #333;
	font-size: 14px;
	font-weight: normal;
	text-align: left;
	padding: 5px 10px; 
	border-bottom: 1px solid #aaa;
}
div.filelista table {
	width: 70%;
	min-height: calc( 100% - 200px ); 
}

div.utvonal {
	width: 100%;
	text-align:left;
}

div.utvonal ul {
	list-style: none;
	display: block;
	padding: 0px 20px;
}
div.utvonal ul li {
	display: inline-block;
	margin:10px 4px;
	background: #fff;
	border-radius: 20px;
	box-shadow: 0 0 5px rgba(0,0,0,0.23);
	font-size: 11px;
	line-height: 15px;
	padding: 5px 10px
}
div.utvonal ul li a {
	color: #777;
}

</style>
