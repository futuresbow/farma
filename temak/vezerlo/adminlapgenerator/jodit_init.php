<script>
$().ready(function(){ 
	var editorGyarto = new Jodit("<?= $selector;?>", 
	{ 
		"buttons": ",,,,,,,,,,,,,font,brush,paragraph,|,|,align,undo,redo,|"
	}); 
});
</script>
