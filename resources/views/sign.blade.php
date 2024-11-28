@props(['saveRoute', 'redirectRoute', 'delivery' => null])

<div class="flex flex-col">
    @if ($delivery !== null)
        <div class="flex flex-row justify-center gap-4">
            @if (!$delivery->signature)
                <div class="flex flex-col gap-3">
                    <h1 class="text-lg">{{ auth()->user()->fleet->name }}</h1>
                    <canvas id="signature-pad-signature" class="signature-pad rounded-lg shadow-lg" width="400" height="200"></canvas>
                </div>
            @endif

            @if (!$delivery->signature_team)
                <div class="flex flex-col gap-3">
                    <h1 class="text-lg">{{ $delivery->customer?->name }}</h1>
                    <canvas id="signature-pad-signatureTeam" class="signature-pad rounded-lg shadow-lg" width="400" height="200"></canvas>
                </div>
            @endif
        </div>
    @else
	<div class="flex flex-row justify-center gap-4">
        <div class="flex flex-col gap-3">
            <h1 class="text-lg">{{ auth()->user()->fleet->name }}</h1>
            <canvas id="signature-pad-signature" class="signature-pad rounded-lg shadow-lg" width="400" height="200"></canvas>
        </div>
	</div>
    @endif
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
    const delivery = @json($delivery);
    // https://github.com/szimek/signature_pad
    const signaturePadSignature = delivery?.signature === null || delivery === null
        ? new SignaturePad(document.getElementById('signature-pad-signature'), {
            backgroundColor: 'rgb(255, 255, 255)',
            penColor: 'rgb(0, 0, 0)'
        })
        : null;

    const signaturePadSignatureTeam = delivery?.signature_team === null
        ? new SignaturePad(document.getElementById('signature-pad-signatureTeam'), {
            backgroundColor: 'rgb(255, 255, 255)',
            penColor: 'rgb(0, 0, 0)'
        })
        : null;
    
    document.getElementById('save').addEventListener('click', function () {
		//event.preventDefault();
        let dataSignature = null, dataSignatureTeam = null;

        if (signaturePadSignature && !signaturePadSignature.isEmpty()) {
            dataSignature = signaturePadSignature.toDataURL('image/png');
            $('input[name="signature"]').val(dataSignature);
        }

        if (signaturePadSignatureTeam && !signaturePadSignatureTeam.isEmpty()) {
            dataSignatureTeam = signaturePadSignatureTeam.toDataURL('image/png');
            $('input[name="signatureTeam"]').val(dataSignatureTeam);
        }

        $.ajax({
            url: "{{ $saveRoute }}",
            type: "PUT",
            data: $('.auto_submit').serialize(),
            complete: function () {
                window.location.href = "{{ $redirectRoute }}";
            }
        });
    });

    document.getElementById('clear').addEventListener('click', function (event) {
        event.preventDefault();
        signaturePadSignature?.clear();
        signaturePadSignatureTeam?.clear();
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
