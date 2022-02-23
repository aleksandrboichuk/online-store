function indexAjax(url) {
    $(document).ready(function() {
        let color = document.querySelectorAll('.color');
        let brand = document.querySelectorAll('.brand');
        let material = document.querySelectorAll('.material');
        let season = document.querySelectorAll('.season');
        let size = document.querySelectorAll('.size');

        var brands  = "" , colors  = "" , materials  = "", seasons  = "", sizes  = "";

        $('.color').find('input[type="checkbox"]').change(function () {
            $('.color').find('input[type="checkbox"]').not(this).prop('checked', false);
        });

        $('.brand').find('input[type="checkbox"]').change(function () {
            $('.brand').find('input[type="checkbox"]').not(this).prop('checked', false);
        });

        $('.material').find('input[type="checkbox"]').change(function () {
            $('.material').find('input[type="checkbox"]').not(this).prop('checked', false);
        });
        $('.season').find('input[type="checkbox"]').change(function () {
            $('.season').find('input[type="checkbox"]').not(this).prop('checked', false);
        });
        $('.size').find('input[type="checkbox"]').change(function () {
            $('.size').find('input[type="checkbox"]').not(this).prop('checked', false);
        });


        $('.btn-danger-filters').click(function () {
            var a = location.href;
            var b = a.split('?');
            window.location.href = b[0];
        });


        $('select[name="order-by"]').find('option').mouseup( function() {
            let orderBy = $('select[name="order-by"]').val();
            let from_price = parseInt($('input[name="from-price"]').val());
            let to_price = parseInt($('input[name="to-price"]').val());
            /* colors array */
            for (let i = 0; i < color.length; i++) {
                if (color[i].firstChild.checked) {
                    colors = color[i].textContent;
                    if(colors != "Всі") {
                        document.getElementById('color-title').textContent = "Колір (1)";
                    }else{
                        document.getElementById('color-title').textContent = "Колір";                        }
                }
            }
            /* brands array */

            for (let i = 0; i < brand.length; i++) {
                if (brand[i].firstChild.checked) {
                    brands = brand[i].textContent;
                    if(brands != "Всі") {
                        document.getElementById('brand-title').textContent = "Бренд (1)";
                    }else{
                        document.getElementById('brand-title').textContent = "Бренд";
                    }
                }
            }

            /* materials array */
            for (let i = 0; i < material.length; i++) {
                if (material[i].firstChild.checked) {
                    materials = material[i].textContent;
                    if(materials != "Всі") {
                        document.getElementById('material-title').textContent = "Матеріал (1)";
                    }else{
                        document.getElementById('material-title').textContent = "Матеріал";
                    }
                }
            }

            /* sizes array */
            for (let i = 0; i < size.length; i++) {
                if (size[i].firstChild.checked) {
                    sizes = size[i].textContent;
                    if(sizes != "Всі") {
                        document.getElementById('size-title').textContent = "Розмір (1)";
                    }else{
                        document.getElementById('size-title').textContent = "Розмір";
                    }
                }
            }
            /* seasons array */
            for (let i = 0; i < season.length; i++) {
                if (season[i].firstChild.checked) {
                    seasons = season[i].textContent;
                    if(seasons != "Всі"){
                        document.getElementById('season-title').textContent = "Сезон (1)";
                    }else{
                        document.getElementById('season-title').textContent = "Сезон";
                    }
                }
            }

            if ((colors != "") || (brands != "") || (materials != "")  || (seasons != "")  || (sizes != "") || !isNaN(from_price) || !isNaN(to_price)){
                $.ajax({
                    url: url  ,
                    type: "GET",
                    data: {
                        colors: colors,
                        brands: brands,
                        materials: materials,
                        seasons: seasons,
                        sizes: sizes,
                        orderBy: orderBy,
                        from_price: !isNaN(from_price) ? from_price : 0,
                        to_price: !isNaN(to_price) || to_price == 0 ? to_price : 1000000
                        // countries: countries
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data){
                        $('.products').html(data)
                    }
                });
            }

        });

        $(document).mouseup( function(e){
            var div = $( ".filter-item" );

            if( div.find('.fil-params').hasClass('fil-active')){
                let orderBy = $('select[name="order-by"]').val();
                let from_price = parseInt($('input[name="from-price"]').val());
                let to_price = parseInt($('input[name="to-price"]').val());

                /* colors array */
                for (let i = 0; i < color.length; i++) {
                    if (color[i].firstChild.checked) {
                        colors = color[i].textContent;
                        if(colors != "Всі") {
                            document.getElementById('color-title').textContent = "Колір (1)";
                        }else{
                            document.getElementById('color-title').textContent = "Колір";                        }
                    }
                }
                /* brands array */

                for (let i = 0; i < brand.length; i++) {
                    if (brand[i].firstChild.checked) {
                        brands = brand[i].textContent;
                        if(brands != "Всі") {
                            document.getElementById('brand-title').textContent = "Бренд (1)";
                        }else{
                            document.getElementById('brand-title').textContent = "Бренд";
                        }
                    }
                }

                /* materials array */
                for (let i = 0; i < material.length; i++) {
                    if (material[i].firstChild.checked) {
                        materials = material[i].textContent;
                        if(materials != "Всі") {
                            document.getElementById('material-title').textContent = "Матеріал (1)";
                        }else{
                            document.getElementById('material-title').textContent = "Матеріал";
                        }
                    }
                }

                /* sizes array */
                for (let i = 0; i < size.length; i++) {
                    if (size[i].firstChild.checked) {
                        sizes = size[i].textContent;
                        if(sizes != "Всі") {
                            document.getElementById('size-title').textContent = "Розмір (1)";
                        }else{
                            document.getElementById('size-title').textContent = "Розмір";
                        }
                    }
                }
                /* seasons array */
                for (let i = 0; i < season.length; i++) {
                    if (season[i].firstChild.checked) {
                        seasons = season[i].textContent;
                        if(seasons != "Всі"){
                            document.getElementById('season-title').textContent = "Сезон (1)";
                        }else{
                            document.getElementById('season-title').textContent = "Сезон";
                        }
                    }
                }

                if ((colors != "") || (brands != "") || (materials != "")  || (seasons != "")  || (sizes != "") || !isNaN(from_price) || !isNaN(to_price)){
                    $.ajax({
                        url: url ,
                        type: "GET",
                        data: {
                            colors: colors,
                            brands: brands,
                            materials: materials,
                            seasons: seasons,
                            sizes: sizes,
                            orderBy: orderBy,
                            from_price: !isNaN(from_price) ? from_price : 0,
                            to_price: !isNaN(to_price) || to_price == 0 ? to_price : 1000000
                            // countries: countries
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data){
                            $('.products').html(data)
                        }
                    });
                }
            }

            if ( !div.is(e.target)
                && div.has(e.target).length === 0 ) {
                div.find('.fil-params').removeClass('fil-active');
                div.find('.filter-img').attr('src', '/images/home/arrow-down.png')
            }

        })
    })
}