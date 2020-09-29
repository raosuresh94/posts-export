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
			var link = document.createElement('a');
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
						var data = ['\ufeff' + request.responseText];
						var fileObj = new Blob(data, { type: 'text/csv;charset=utf-8;' });
						var fileurl = URL.createObjectURL(fileObj);
						link.href = fileurl;
						link.download = typenow + '.csv';
						document.body.appendChild(link);
						link.click();
						document.body.removeChild(link);
						//Response Message
						swal({
							title: "Good job!",
							text: 'File has been exported successfully!',
							icon: "success",
							button: false,
							timer: 3000
						});
					}
				}
			}
			request.open('POST', ajaxurl, true);
			request.send(data);
		});
	}
});