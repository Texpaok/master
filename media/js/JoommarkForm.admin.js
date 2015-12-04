(function ($) {
	$(document).ready(function ()
	{
		// hide field on load on the form for the plans
		document.getElementById('jform_target_expectation').parentElement.parentElement.style.display = 'none';

        // Target
        $('#jform_hastarget').change(function () {
            if ($(this).find("option:selected").attr('value') == '1') {
        		document.getElementById('jform_target_expectation').parentElement.parentElement.style.display = 'block';
                $('#jform_target_expectation').attr('required', true);
            } else {
				document.getElementById('jform_target_expectation').parentElement.parentElement.style.display = 'none';
                $('#jform_target_expectation').attr('required', false);
                $('#jform_target_expectation').val('');
            }
            ;
        });



	});
})(jQuery);