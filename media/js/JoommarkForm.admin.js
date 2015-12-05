(function ($) {
	$(document).ready(function ()
	{
		// hide field on load on the form for the plans
		//document.getElementById('jform_target_expectation').parentElement.parentElement.style.display = 'none';

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

		/* All menus assignment */
			$("#jform_allmenus").click(function() {
				checked = $(this).is(':checked');

				if (checked) {
					disableElement($("#jform_menuitems"), true);
					disableElement($("#jform_menuitems_chzn"), true);
				} else {
					disableElement($("#jform_menuitems"), false);
					disableElement($("#jform_menuitems_chzn"), false);
				}
			});

			function disableElement(element, state) {
				if (state) {
					element.addClass("hide");
				} else {
					element.removeClass("hide");
				}
			}

			window.addEvent('domready', function() {
				allMenusIsChecked = $("#jform_allmenus").is(':checked');
				disableElement($("#jform_menuitems_chzn"),allMenusIsChecked);
			});


	});
})(jQuery);



