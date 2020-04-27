<a href="<?= ADMINURL; ?>post/lista" class="btn btn-info topadminlink">Mégsem</a>

<h3>Termék szerkesztése</h3>

<form method="post">
<div class="form-group">
	<label>Cím</label>
	<input class="form-control" name="a[cim]" value="<?= @$sor->cim; ?>" />
	
</div>

<div class="form-group">
	<label>Tartalom</label>
	<textarea class="fedit" name="a[szoveg]" ><?= @$sor->szoveg; ?></textarea>
	
</div>

<div class="form-group">
	
	<input class="btn btn-success" value="Ment" type="submit" />
	
</div>
</form>
<script>
 var tid = <?= $tid;?>;
$().ready(function(){
	
		$('.fedit').summernote({
			toolbar: [
				// [groupName, [list of button]]
				['style', ['bold', 'italic', 'underline', 'clear']],
				['font', ['strikethrough', 'superscript', 'subscript']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']]
				]
			});
		
		
	
});
</script>
