
$(document).ready(function() {
    $('#rightEyeForm').submit(function(e) {
        e.preventDefault()
    
        $.ajax({
            type: 'POST',
            url: 'rightEyeProcess.php',
            data: $(this).serialize(),
            method: 'POST',
            success: function(resp) {
                $('#error_msg').html(resp);
            }
        })
    })
})






$(document).ready(function() {
    $('#leftEyeForm').submit(function(e) {
        e.preventDefault()

        $.ajax({
            type: 'POST',
            url: 'leftEyeProcess.php',
            data: $(this).serialize(),
            method: 'POST',
            success: function(resp) {
                $('#error_msg').html(resp);
            }
        })
    })
})




