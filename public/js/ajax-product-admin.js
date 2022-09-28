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
                $('select[name="category_id"]').html(data)
            }
        });
    });
    $('select[name="category_id"]').click(function () {
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
                $('select[name="category_sub_id"]').html(data)
            }
        });
    });
}
