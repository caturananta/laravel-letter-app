let x
function readFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        x = input.files
        reader.onload = function (e) {
            var htmlPreview =
                // '<img width="200" src="' + e.target.result + '" />'+
                // '<p>' + input.files[0].name + '</p>'
            '      <span class="mr-2 d-none d-lg-inline text-gray-600 small">' + input.files[0].name + '</span>\n'+
            '      <i class="fas fa-trash fa-sm" onclick="deletefile()"></i>';
            var wrapperZone = $(input).parent();
            var previewZone = $(input).parent().parent().find('.preview-zone');
            var boxZone = $(input).parent().parent().find('.preview-zone').find('.box').find('.box-body');
            wrapperZone.removeClass('dragover');
            previewZone.removeClass('hidden');
            boxZone.empty();
            boxZone.append(htmlPreview);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function deletefile(){
    var boxZone = $('.box-body');
    var previewZone = $('.preview-zone');
    var dropzone = $('.dropzone');
    boxZone.empty();
    previewZone.addClass('hidden');
    dropzone.val("")
}

$(".dropzone").change(function(){
    readFile(this);
});
$('.dropzone-wrapper').on('dragover', function(e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).addClass('dragover');
});
$('.dropzone-wrapper').on('dragleave', function(e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).removeClass('dragover');
});
