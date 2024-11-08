@props(['saveRoute', 'redirectRoute', 'id', 'name'])

<br>
<div class="flex flex-col">

	<div class="flex flex-col justify-center gap-4">
		<h1 class="text-lg">{{$name}}</h1>
		<canvas id="signature-pad-{{$id}}" class="signature-pad rounded-lg shadow-lg" width=400 height=200></canvas>
		
	</div>
	<div class="flex justify-center space-x-8 mt-4">
		<button id="clear{{$id}}" class="btn-danger">Borrar</button>
		<button id="save{{$id}}" class="btn-primary">Guardar</button>
	</div>
</div>
	


@push('head')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
@endpush

@push('js')
<script type="text/javascript">
	// https://github.com/szimek/signature_pad
	var signaturePad{{$id}} = new SignaturePad(document.getElementById('signature-pad-{{$id}}'), {
	  backgroundColor: 'rgb(255, 255, 255)',
	  penColor: 'rgb(0, 0, 0)'
	});

	var saveButton{{$id}} = document.getElementById('save{{$id}}');
	var cancelButton{{$id}} = document.getElementById('clear{{$id}}');

	saveButton{{$id}}.addEventListener('click', function (event) {
		//event.preventDefault();
	  var data = signaturePad{{$id}}.toDataURL('image/png');

	  $('input[name={{$id}}]').val(data)


			$.ajax({
            url : "{{ $saveRoute }}",
            type: "PUT",
            data: $('.auto_submit').serialize(),
            complete: function(xhr, status) {
            	window.location.href = "{{ $redirectRoute }}"
            }
        });
	});

	cancelButton{{$id}}.addEventListener('click', function (event) {
		event.preventDefault();
	  signaturePad{{$id}}.clear();
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