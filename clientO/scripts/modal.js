setInterval(function() { 
        $('#privacy_mdl').modal('show'); 
    }, 
    1000);

$(document).ready(function() {
    $('#captureSignature').signature({
        syncField: '#signatureJSON'
    });

    $('#clear2Button').click(function() {
        $('#captureSignature').signature('clear');
    });

    $('input[name="syncFormat"]').change(function() {
        var syncFormat = $('input[name="syncFormat"]:checked').val();
        $('#captureSignature').signature('option', 'syncFormat', syncFormat);
        console.log($('#signatureJSON').val());
        $('#dummy_img').attr('src', $('#signatureJSON').val());
    });

    $('#svgStyles').change(function() {
        $('#captureSignature').signature('option', 'svgStyles', $(this).is(':checked'));
    });
    
    var syncFormat = 'PNG';
    $('#captureSignature').signature('option', 'syncFormat', syncFormat);
    console.log($('#signatureJSON').val());

    $('#dummy_img').attr('src', $('#signatureJSON').val());
});

function get_image_data(eve) {
    if ($(captureSignature).signature('isEmpty') == true) {
        alert('The Signature is Empty');
        eve.preventDefault();
    }
}