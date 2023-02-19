function ajaxRequests(url) {
    $('select[name="category_group_id"]').click(function () {
        var categoryGroup = $(this).val();
        $.ajax({
            url: url,
            type: "GET",
            data: {
                categoryGroup: categoryGroup,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                $('select[name="category"]').html(data)
            }
        });
    });
    $('select[name="category"]').click(function () {
        var category = $(this).val();
        $.ajax({
            url: url,
            type: "GET",
            data: {
                category: category,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                $('select[name="category_id"]').html(data)
            }
        });
    });
}

$(document).ready(function () {
    var countImages = 1;
    $('.add-image').click(function () {
        $(this).parent().before(function () {
            return '<div class="add-block">\n' +
                '                <label for="image">Детальне зобр. №'+ countImages + '  </label>\n' +
                '                   <input type="file" name="additional-image-'+ countImages +'" accept=".jpg, .jpeg, .png">\n' +
                '                </div>'
        });
        countImages += 1;
        if(countImages == 7){
            $(this).attr('disabled', 'disabled').css('background-color', '#6fa1f4');
        }
    });
});
