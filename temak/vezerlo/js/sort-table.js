$(document).ready(function () {


	var fixHelperModified = function(e, tr) {
	var $originals = tr.children();
	var $helper = tr.clone();

	$helper.children().each(function(num) {
		$(this).width($originals.eq(num).width())
	});
	return $helper;
},
	updateIndex = function(e, ui) {
		$('td.num', ui.item.parent()).each(function (i) {
			$(this).html(i + 1);
		});
	};


	$("#sort tbody").sortable({
		helper: fixHelperModified,
		axis: "y",
		containment: "parent",
		handle: ".move",
		cancel: ".editable",
		stop: updateIndex
	}).disableSelection();

});
