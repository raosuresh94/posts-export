window.addEventListener('load', function () {

	//Set Export button after Add New button
	if (typenow == 'post') {
		//Element where add Export button
		var container = document.querySelector('#wpbody-content .page-title-action');

		//Create Anchor Element
		var anchor = document.createElement('a');
		anchor.href = '#';
		anchor.classList.add('page-title-action');
		anchor.text = 'Export';
		anchor.id = 'post-export-btn';
		container.parentNode.insertBefore(anchor, container.nextSibling);
	}

	//Run AJAX after Export button Clicked!
	var exportBtn = document.getElementById('post-export-btn');
	if (typeof exportBtn != 'undefined') {
		exportBtn.addEventListener('click', function (e) {
			e.preventDefault();
			var request = new XMLHttpRequest();
			var data = new FormData();
			data.append('action', 'export_posts');
			data.append('post_type', typenow);
			swal({
				title: "Info",
				text: 'Exporting...',
				icon: "info",
				button: false,
			});
			request.onload = function () {
				if (request.readyState = 4) {
					if (request.status == 200) {
						var response = JSON.parse(request.responseText);
						swal({
							title: "Good job!",
							text: response.message,
							icon: "success",
							button: false,
							content: {
								element: "a",
								attributes: {
									href: response.path,
									text: 'Download CSV',
									className: 'swal-button swal_new',
									target: '_blank',
								},
							},
						});
					}
				}
			}
			request.open('POST', ajaxurl, true);
			request.send(data);
		});
	}
});