<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css" />
<?php
    require_once("_header.php");
    require_once("_nav.php");
    require_once("_menu.php");
?>
<style type="text/css">

</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-light">Hemen Paylaş</div>
            <div class="card-body">
				Share Yapılıyor

				<!-- Resmi base64 çeviriyor -->
				<button type="button" class="upload-result" >Sonuç</button>
				 
				<!-- yükleme Butonu -->
				<input id="upload" value="Dosya Seçin" accept="image/*" type="file">
				
				<!-- panel -->
            	<div id="upload-demo"></div> 
			</div> 
		</div> 
			<!-- gösterim -->
            <img id="img" src=""/><br/>
            <div id="imagebase64"></div> 
    </div>
</div>
<?php
    require_once("_footer.php");
?>

<script src="./vendor/exif-js/exif.js"></script>
<script src="./vendor/croppie/croppie.min.js"></script>

<script>
 demoUpload();


	// function output(node) {
	// 	var existing = $('#result .croppie-result');
	// 	if (existing.length > 0) {
	// 		existing[0].parentNode.replaceChild(node, existing[0]);
	// 	}
	// 	else {
	// 		$('#result')[0].appendChild(node);
	// 	}
	// }

	// function popupResult(result) {
	// 	var html;
	// 	if (result.html) {
	// 		html = result.html;
	// 	}
	// 	if (result.src) {
	// 		html = '<img src="' + result.src + '" />';
	// 	}
	// 	swal({
	// 		title: '',
	// 		html: true,
	// 		text: html,
	// 		allowOutsideClick: true
	// 	});
	// 	setTimeout(function(){
	// 		$('.sweet-alert').css('margin', function() {
	// 			var top = -1 * ($(this).height() / 2),
	// 				left = -1 * ($(this).width() / 2);

	// 			return top + 'px 0 0 ' + left + 'px';
	// 		});
	// 	}, 1);
	// }

function demoUpload() {
		var $uploadCrop;

		function readFile(input) {
 			if (input.files && input.files[0]) {
	            var reader = new FileReader();

	            reader.onload = function (e) {
					$('#upload-demo').addClass('ready');
	            	$uploadCrop.croppie('bind', {
						url: e.target.result
	            	}).then(function(){
	            		console.log('jQuery bind complete');
	            	});

	            }

	            reader.readAsDataURL(input.files[0]);
	        }
	        else {
		        swal("Dikkat!","Sorry - you're browser doesn't support the FileReader API","warning");
		    }
		}

		$uploadCrop = $('#upload-demo').croppie({
			enableExif: true,
			viewport: {
				width: 480,
				height: 270,
				type: 'square'
            },
            boundary: {
                width:510,
                height:300
            },
			format:'jpeg'|'png',
		});

        $('#upload').on('change', function () { readFile(this); });

		$('.upload-result').on('click', function (ev) {
			//$uploadCrop.toggle();
			$uploadCrop.croppie('result', {
				type: 'canvas',
				size: { width:1920, height:1080 } //'viewport' fotoğrafın çıktı formatı
			}).then(function (resp) {
                $('#img').attr('src',resp);
                $('#imagebase64').html(resp);
				// popupResult({
				// 	src: resp
				// });
			});
		});

		$('.upload-test').on('click', function (ev) {
			// <div id="upload-demo" style="display:none;"></div> 
			$('#upload-demo').toggle();
			//$('#upload-demo').croppie('bind') 
		});
	}

</script>