(function ($) {
	$(document).ready(function ()
	{
		/*
		 *
		 * PLANS
		 *
		 */
		// Hide fields on load
		if ($('#jform_hastarget').length) {
			if ($('#jform_hastarget').find("option:selected").attr('value') == '1') {
				document.getElementById('jform_target_expectation').parentElement.parentElement.style.display = 'block';
				$('#jform_target_expectation').attr('required', true);
			} else {
				document.getElementById('jform_target_expectation').parentElement.parentElement.style.display = 'none';
				$('#jform_target_expectation').attr('required', false);
				$('#jform_target_expectation').val('');
			}
		}
		if ($('#jform_type').length) {
			if ($('#jform_type').find("option:selected").attr('value') == '0') {
				document.getElementById('jform_plans_min_visited_pages').parentElement.parentElement.style.display = 'block';
				$('#jform_plans_min_visited_pages').attr('required', true);
				document.getElementById('jform_plans_min_visited_time_sec').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_min_visited_time_sec').attr('required', false);
				document.getElementById('jform_plans_mode_menu_or_url').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_mode_menu_or_url').attr('required', false);
				document.getElementById('jform_plans_menuitems').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_menuitems').attr('required', false);
				document.getElementById('jform_plans_url').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_url').attr('required', false);
			} else if ($('#jform_type').find("option:selected").attr('value') == '1') {
				document.getElementById('jform_plans_min_visited_pages').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_min_visited_pages').attr('required', false);
				document.getElementById('jform_plans_min_visited_time_sec').parentElement.parentElement.style.display = 'block';
				$('#jform_plans_min_visited_time_sec').attr('required', true);
				document.getElementById('jform_plans_mode_menu_or_url').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_mode_menu_or_url').attr('required', false);
				document.getElementById('jform_plans_menuitems').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_menuitems').attr('required', false);
				document.getElementById('jform_plans_url').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_url').attr('required', false);
			} else if ($('#jform_type').find("option:selected").attr('value') == '2') {
				document.getElementById('jform_plans_min_visited_pages').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_min_visited_pages').attr('required', false);
				document.getElementById('jform_plans_min_visited_time_sec').parentElement.parentElement.style.display = 'block';
				$('#jform_plans_min_visited_time_sec').attr('required', true);
				document.getElementById('jform_plans_mode_menu_or_url').parentElement.parentElement.style.display = 'block';
				if ($('#jform_plans_mode_menu_or_url').find("option:selected").attr('value') == 'url') {
					document.getElementById('jform_plans_menuitems').parentElement.parentElement.style.display = 'none';
					$('#jform_plans_menuitems').attr('required', false);
					document.getElementById('jform_plans_url').parentElement.parentElement.style.display = 'block';
					$('#jform_plans_url').attr('required', true);
				} else {
					document.getElementById('jform_plans_menuitems').parentElement.parentElement.style.display = 'block';
					$('#jform_plans_menuitems').attr('required', true);
					document.getElementById('jform_plans_url').parentElement.parentElement.style.display = 'none';
					$('#jform_plans_url').attr('required', false);
				}
			} else if ($('#jform_type').find("option:selected").attr('value') == '3') {
				document.getElementById('jform_plans_min_visited_pages').parentElement.parentElement.style.display = 'block';
				$('#jform_plans_min_visited_pages').attr('required', true);
				document.getElementById('jform_plans_min_visited_time_sec').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_min_visited_time_sec').attr('required', false);
				document.getElementById('jform_plans_mode_menu_or_url').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_mode_menu_or_url').attr('required', false);
				if ($('#jform_plans_mode_menu_or_url').find("option:selected").attr('value') == 'url') {
					document.getElementById('jform_plans_menuitems').parentElement.parentElement.style.display = 'none';
					$('#jform_plans_menuitems').attr('required', false);
					document.getElementById('jform_plans_url').parentElement.parentElement.style.display = 'block';
					$('#jform_plans_url').attr('required', true);
				} else {
					document.getElementById('jform_plans_menuitems').parentElement.parentElement.style.display = 'block';
					$('#jform_plans_menuitems').attr('required', true);
					document.getElementById('jform_plans_url').parentElement.parentElement.style.display = 'none';
					$('#jform_plans_url').attr('required', false);
				}
			} else if ($('#jform_type').find("option:selected").attr('value') == '4') {
				document.getElementById('jform_plans_min_visited_pages').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_min_visited_pages').attr('required', false);
				document.getElementById('jform_plans_min_visited_time_sec').parentElement.parentElement.style.display = 'block';
				$('#jform_plans_min_visited_time_sec').attr('required', true);
				document.getElementById('jform_plans_mode_menu_or_url').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_mode_menu_or_url').attr('required', false);
				document.getElementById('jform_plans_menuitems').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_menuitems').attr('required', false);
				document.getElementById('jform_plans_url').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_url').attr('required', false);
			} else if ($('#jform_type').find("option:selected").attr('value') == '5') {
				document.getElementById('jform_plans_min_visited_pages').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_min_visited_pages').attr('required', false);
				document.getElementById('jform_plans_min_visited_time_sec').parentElement.parentElement.style.display = 'block';
				$('#jform_plans_min_visited_time_sec').attr('required', true);
				document.getElementById('jform_plans_mode_menu_or_url').parentElement.parentElement.style.display = 'block';
				$('#jform_plans_mode_menu_or_url').attr('required', true);
				if ($('#jform_plans_mode_menu_or_url').find("option:selected").attr('value') == 'url') {
					document.getElementById('jform_plans_menuitems').parentElement.parentElement.style.display = 'none';
					$('#jform_plans_menuitems').attr('required', false);
					document.getElementById('jform_plans_url').parentElement.parentElement.style.display = 'block';
					$('#jform_plans_url').attr('required', true);
				} else {
					document.getElementById('jform_plans_menuitems').parentElement.parentElement.style.display = 'block';
					$('#jform_plans_menuitems').attr('required', true);
					document.getElementById('jform_plans_url').parentElement.parentElement.style.display = 'none';
					$('#jform_plans_url').attr('required', false);
				}
			} else {
				alert("todo failure Joommark.form.admin.js");
			}
		}
		// On Change
		$('#jform_hastarget').change(function () {
			if ($(this).find("option:selected").attr('value') == '1') {
				document.getElementById('jform_target_expectation').parentElement.parentElement.style.display = 'block';
				$('#jform_target_expectation').attr('required', true);
			} else {
				document.getElementById('jform_target_expectation').parentElement.parentElement.style.display = 'none';
				$('#jform_target_expectation').attr('required', false);
				$('#jform_target_expectation').val('0');
			}
			;
		});
		$('#jform_type').change(function () {
			if ($('#jform_type').find("option:selected").attr('value') == '0') {
				document.getElementById('jform_plans_min_visited_pages').parentElement.parentElement.style.display = 'block';
				$('#jform_plans_min_visited_pages').attr('required', true);
				document.getElementById('jform_plans_min_visited_time_sec').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_min_visited_time_sec').attr('required', false);
				$('#jjform_plans_min_visited_time_sec').val('0');
				document.getElementById('jform_plans_mode_menu_or_url').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_mode_menu_or_url').attr('required', false);
				$('#jform_plans_mode_menu_or_url').val('url');
				document.getElementById('jform_plans_menuitems').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_menuitems').attr('required', false);
				$('#jform_plans_menuitems').val('');
				document.getElementById('jform_plans_url').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_url').attr('required', false);
				$('#jform_plans_url').val('http://www.example.de');
			} else if ($('#jform_type').find("option:selected").attr('value') == '1') {
				document.getElementById('jform_plans_min_visited_pages').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_min_visited_pages').attr('required', false);
				$('#jform_plans_min_visited_pages').val('0');
				document.getElementById('jform_plans_min_visited_time_sec').parentElement.parentElement.style.display = 'block';
				$('#jform_plans_min_visited_time_sec').attr('required', true);
				document.getElementById('jform_plans_mode_menu_or_url').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_mode_menu_or_url').attr('required', false);
				$('#jform_plans_mode_menu_or_url').val('url');
				document.getElementById('jform_plans_menuitems').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_menuitems').attr('required', false);
				$('#jform_plans_menuitems').val('');
				document.getElementById('jform_plans_url').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_url').attr('required', false);
				$('#jform_plans_url').val('http://www.example.de');
			} else if ($('#jform_type').find("option:selected").attr('value') == '2') {
				document.getElementById('jform_plans_min_visited_pages').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_min_visited_pages').attr('required', false);
				$('#jform_plans_min_visited_pages').val('0');
				document.getElementById('jform_plans_min_visited_time_sec').parentElement.parentElement.style.display = 'block';
				$('#jform_plans_min_visited_time_sec').attr('required', true);
				document.getElementById('jform_plans_mode_menu_or_url').parentElement.parentElement.style.display = 'block';
				$('#jform_plans_mode_menu_or_url').attr('required', true);
				if ($('#jform_plans_mode_menu_or_url').find("option:selected").attr('value') == 'url') {
					document.getElementById('jform_plans_menuitems').parentElement.parentElement.style.display = 'none';
					$('#jform_plans_menuitems').attr('required', false);
					$('#jform_plans_menuitems').val('');
					document.getElementById('jform_plans_url').parentElement.parentElement.style.display = 'block';
					$('#jform_plans_url').attr('required', true);
				} else {
					document.getElementById('jform_plans_menuitems').parentElement.parentElement.style.display = 'block';
					$('#jform_plans_menuitems').attr('required', true);
					document.getElementById('jform_plans_url').parentElement.parentElement.style.display = 'none';
					$('#jform_plans_url').attr('required', false);
					$('#jform_plans_url').val('http://www.example.de');
				}
			} else if ($('#jform_type').find("option:selected").attr('value') == '3') {
				document.getElementById('jform_plans_min_visited_pages').parentElement.parentElement.style.display = 'block';
				$('#jform_plans_min_visited_pages').attr('required', true);
				document.getElementById('jform_plans_min_visited_time_sec').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_min_visited_time_sec').attr('required', false);
				$('#jform_plans_min_visited_time_sec').val('0');
				document.getElementById('jform_plans_mode_menu_or_url').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_mode_menu_or_url').attr('required', false);
				$('#jform_plans_mode_menu_or_url').val('url');
				document.getElementById('jform_plans_menuitems').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_menuitems').attr('required', false);
				$('#jform_plans_menuitems').val('');
				document.getElementById('jform_plans_url').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_url').attr('required', false);
				$('#jform_plans_url').val('http://www.example.de');
			} else if ($('#jform_type').find("option:selected").attr('value') == '4') {
				document.getElementById('jform_plans_min_visited_pages').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_min_visited_pages').attr('required', false);
				$('#jform_plans_min_visited_pages').val('0');
				document.getElementById('jform_plans_min_visited_time_sec').parentElement.parentElement.style.display = 'block';
				$('#jform_plans_min_visited_time_sec').attr('required', true);
				document.getElementById('jform_plans_mode_menu_or_url').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_mode_menu_or_url').attr('required', false);
				$('#jform_plans_mode_menu_or_url').val('url');
				document.getElementById('jform_plans_menuitems').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_menuitems').attr('required', false);
				$('#jform_plans_menuitems').val('');
				document.getElementById('jform_plans_url').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_url').attr('required', false);
				$('#jform_plans_url').val('http://www.example.de');
			} else if ($('#jform_type').find("option:selected").attr('value') == '5') {
				document.getElementById('jform_plans_min_visited_pages').parentElement.parentElement.style.display = 'none';
				$('#jform_plans_min_visited_pages').attr('required', false);
				$('#jform_plans_min_visited_pages').val('0');
				document.getElementById('jform_plans_min_visited_time_sec').parentElement.parentElement.style.display = 'block';
				$('#jform_plans_min_visited_time_sec').attr('required', true);
				document.getElementById('jform_plans_mode_menu_or_url').parentElement.parentElement.style.display = 'block';
				if ($('#jform_plans_mode_menu_or_url').find("option:selected").attr('value') == 'url') {
					document.getElementById('jform_plans_menuitems').parentElement.parentElement.style.display = 'none';
					$('#jform_plans_menuitems').attr('required', false);
					$('#jform_plans_menuitems').val('');
					document.getElementById('jform_plans_url').parentElement.parentElement.style.display = 'block';
					$('#jform_plans_url').attr('required', true);
				} else {
					document.getElementById('jform_plans_menuitems').parentElement.parentElement.style.display = 'block';
					$('#jform_plans_menuitems').attr('required', true);
					document.getElementById('jform_plans_url').parentElement.parentElement.style.display = 'none';
					$('#jform_plans_url').attr('required', false);
					$('#jform_plans_url').val('http://www.example.de');
				}
			} else {
				alert("todo failure Joommark.form.admin.js");
			}
			;
		});
		$('#jform_plans_mode_menu_or_url').change(function () {
				if ($('#jform_plans_mode_menu_or_url').find("option:selected").attr('value') == 'url') {
					document.getElementById('jform_plans_menuitems').parentElement.parentElement.style.display = 'none';
					$('#jform_plans_menuitems').attr('required', false);
					$('#jform_plans_menuitems').val('');
					document.getElementById('jform_plans_url').parentElement.parentElement.style.display = 'block';
					$('#jform_plans_url').attr('required', true);
				} else {
					document.getElementById('jform_plans_menuitems').parentElement.parentElement.style.display = 'block';
					$('#jform_plans_menuitems').attr('required', true);
					document.getElementById('jform_plans_url').parentElement.parentElement.style.display = 'none';
					$('#jform_plans_url').attr('required', false);
					$('#jform_plans_url').val('http://www.example.de');
				}
			;
		});




		/*
		 *
		 * Messages
		 *
		 */
		/* All menus assignment */
		// Hide fields on load
		if ($('#jform_allmenus').length) {
			if ($('#jform_allmenus').find("option:selected").attr('value') == '1') {
				document.getElementById('jform_menuitems_message').parentElement.parentElement.style.display = 'none';
				$('#jform_menuitems_message').attr('required', false);
				$('#jform_menuitems_message').val('');
			} else {
				document.getElementById('jform_menuitems_message').parentElement.parentElement.style.display = 'block';
				$('#jform_menuitems_message').attr('required', true);
			}
		}
		// On Change
		$('#jform_allmenus').change(function () {
			if ($('#jform_allmenus').find("option:selected").attr('value') == '1') {
				document.getElementById('jform_menuitems_message').parentElement.parentElement.style.display = 'none';
				$('#jform_menuitems_message').attr('required', false);
				//To do: empty chozen

			} else {
				document.getElementById('jform_menuitems_message').parentElement.parentElement.style.display = 'block';
				$('#jform_menuitems_message').attr('required', true);
			}
			;
		});


		/*
		$("#jform_allmenus").click(function () {
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

		window.addEvent('domready', function () {
			allMenusIsChecked = $("#jform_allmenus").is(':checked');
			disableElement($("#jform_menuitems_chzn"), allMenusIsChecked);
		});
		*/

	});
})(jQuery);



