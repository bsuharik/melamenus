
//For Single input validation
$(document).on('change', '[data-acceptable-extension]', function () {
    //var i = jQuery(this).prev('.custom-file-upload').clone();
    var current = jQuery(this);
    var valid_extension = current.attr('data-acceptable-extension').split(',');
    if (current[0].files.length <= 0 || typeof current[0].files.length == undefined) {
        current.val('');
        return false;
    }

    var file = jQuery(this)[0].files[0].name;
    var file_name = file;
    var file_size = jQuery(this)[0].files[0].size;

    // if (file_size > MAX_ATTACHMENT_SIZE) {
    //     current.val('');
    //     alert('<p class="text-danger custom-validation-message"><i class="fa fa-exclamation-circle"></i> Please select file having size less than ' + (MAX_ATTACHMENT_SIZE / MB) + 'MB.</p>');
    //     return false;
    // } 
    if (is_valid_attachment(file_name, valid_extension) == false) {
        current.val('');        
        current.next('#errorMessage').text('Only ' + valid_extension.join(', ') + ' extensions are allowed.');
        return false;
    }
});

function is_valid_attachment(file_name, valid_extension) {
    var file = file_name.toLowerCase(),
        extension = file.substring(file.lastIndexOf('.') + 1);
    if (jQuery.inArray(extension, valid_extension) == -1) {
        return false;
    } else {
        return true;
    }
}