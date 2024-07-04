@props(['saveRoute', 'redirectRoute'])

<br>
<div class="flex justify-center">
	<canvas id="signature-pad" class="signature-pad rounded-lg" width=400 height=200></canvas>
  
</div>
<div class="flex justify-center space-x-8 mt-4">
  <button id="clear" class="btn-danger">Borrar</button>
  <button id="save" class="btn-primary">Guardar</button>
</div>



@push('head')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
@endpush

@push('js')
<script type="text/javascript">
	// https://github.com/szimek/signature_pad
	var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
	  backgroundColor: 'rgb(255, 255, 255)',
	  penColor: 'rgb(0, 0, 0)'
	});

	var saveButton = document.getElementById('save');
	var cancelButton = document.getElementById('clear');

	saveButton.addEventListener('click', function (event) {
		//event.preventDefault();
	  var data = signaturePad.toDataURL('image/png');

	  $('input[name=signature]').val(data)


			$.ajax({
            url : "{{ $saveRoute }}",
            type: "PUT",
            data: $('.auto_submit').serialize(),
            complete: function(xhr, status) {
            	window.location.href = "{{ $redirectRoute }}"
            }
        });
	});

	cancelButton.addEventListener('click', function (event) {
		event.preventDefault();
	  signaturePad.clear();
	});

	// function resizeCanvas() {
	// 	alert('resize')
	//     const ratio =  Math.max(window.devicePixelRatio || 1, 1);
	//     canvas.width = canvas.offsetWidth * ratio;
	//     canvas.height = canvas.offsetHeight * ratio;
	//     canvas.getContext("2d").scale(ratio, ratio);
	//     signaturePad.clear(); // otherwise isEmpty() might return incorrect value
	// }
	// window.addEventListener("resize", resizeCanvas);
	// resizeCanvas();
</script>
@endpush