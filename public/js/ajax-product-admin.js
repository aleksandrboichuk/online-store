function ajaxRequests(url) {
    $('select[name="cat-field"]').click(function () {
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
                $('select[name="category-field"]').html(data)
            }
        });
    });
    $('select[name="category-field"]').click(function () {
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
                $('select[name="sub-category-field"]').html(data)
            }
        });
    });
}
