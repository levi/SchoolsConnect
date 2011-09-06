jQuery(document).ready(function($) {
	$('.add_member').live('click', function() {
		var $link = $(this)
			$td = $link.parent(),
			$input = $link.prev('input'),
			$newInput = $input.clone(),
			guid_parts = /^(\w+)\[(\d+)\]$/.exec($input.attr('name')),
			guid = guid_parts[1]+'['+(++guid_parts[2])+']';

		$td.append($('<br />'));
		$newInput.attr('name', guid).attr('id', guid).val('');
		$newInput.appendTo($td);
		$link.appendTo($td);

		return false;
	});
});