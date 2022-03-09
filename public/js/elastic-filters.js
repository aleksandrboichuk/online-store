$(document).ready(function() {
    let color = document.querySelectorAll('.color');
    let brand = document.querySelectorAll('.brand');
    let material = document.querySelectorAll('.material');
    let season = document.querySelectorAll('.season');
    let size = document.querySelectorAll('.size');


    let full_url = location.href.split('?');
    let url = full_url[0];

    if(full_url.length > 1){
        let params = full_url[1].split('&');
        for(let i = 0; i < params.length; i++){
            var filterParams = params[i].split('=');
            var filterValues = filterParams[1].split('+');
            if (filterValues.length < 2){
                filterValues = filterParams[1].split('%20');
            }
            if(filterParams[0] == 'colors'){
                $('span[id="color-title"]').parent().addClass('filter-title-active');
                $('span[id="color-title"]').text('Колір ' + '(' + filterValues.length.toString() + ')');
                for (let a = 0; a < color.length; a++) {
                    for( let b = 0; b < filterValues.length; b++){
                        if (color[a].firstChild.getAttribute('id') == filterValues[b]) {
                            color[a].firstChild.checked = true;
                        }
                    }
                }
            }
            if(filterParams[0] == 'brands'){
                $('span[id="brand-title"]').parent().addClass('filter-title-active');
                $('span[id="brand-title"]').text('Бренд ' + '(' + filterValues.length.toString() + ')');
                for (let a = 0; a < brand.length; a++) {
                    for( let b = 0; b < filterValues.length; b++){
                        if (brand[a].firstChild.getAttribute('id') == filterValues[b]) {
                            brand[a].firstChild.checked = true;
                        }
                    }
                }
            }
            if(filterParams[0] == 'materials'){
                $('span[id="material-title"]').parent().addClass('filter-title-active');
                $('span[id="material-title"]').text('Матеріал ' + '(' + filterValues.length.toString() + ')');
                for (let a = 0; a < material.length; a++) {
                    for( let b = 0; b < filterValues.length; b++){
                        if (material[a].firstChild.getAttribute('id') == filterValues[b]) {
                            material[a].firstChild.checked = true;
                        }
                    }
                }
            }
            if(filterParams[0] == 'seasons'){
                $('span[id="season-title"]').parent().addClass('filter-title-active');
                $('span[id="season-title"]').text('Сезон ' + '(' + filterValues.length.toString() + ')');
                for (let a = 0; a < season.length; a++) {
                    for( let b = 0; b < filterValues.length; b++){
                        if (season[a].firstChild.getAttribute('id') == filterValues[b]) {
                            season[a].firstChild.checked = true;
                        }
                    }
                }
            }
            if(filterParams[0] == 'sizes'){
                $('span[id="size-title"]').parent().addClass('filter-title-active');
                $('span[id="size-title"]').text('Розмір ' + '(' + filterValues.length.toString() + ')');
                for (let a = 0; a < size.length; a++) {
                    for( let b = 0; b < filterValues.length; b++){
                        if (size[a].firstChild.getAttribute('id') == filterValues[b]) {
                            size[a].firstChild.checked = true;
                        }
                    }
                }
            }
            if(filterParams[0] == 'priceFrom'){
                $('span[id="price-title"]').parent().addClass('filter-title-active');
                $('input[name="from-price"]').val(filterValues[0]);
            }
            if(filterParams[0] == 'priceTo'){
                $('span[id="price-title"]').parent().addClass('filter-title-active');
                $('input[name="to-price"]').val(filterValues[0]);
            }

            if(filterParams[0] == 'orderBy'){
                if(filterValues.length < 2){
                    var orderBy = filterValues[0];

                   if(filterValues[0] == 'count'){
                       $('select[name="order-by"]').find('option[value="count"]').prop('selected', true);
                   }else if(filterValues[0] == 'price-asc'){
                       $('select[name="order-by"]').find('option[value="price-asc"]').prop('selected', true);
                   }else if(filterValues[0] == 'price-desc'){
                       $('select[name="order-by"]').find('option[value="price-desc"]').prop('selected', true);
                   }else if(filterValues[0] == 'created_at'){
                       $('select[name="order-by"]').find('option[value="created_at"]').prop('selected', true);
                   }else if(filterValues[0] == 'discount'){
                       $('select[name="order-by"]').find('option[value="discount"]').prop('selected', true);
                   }
                }
            }

        }

    }

    $(document).mouseup(function (e) {
        // let orderBy = $('select[name="order-by"]').val();
        // let priceFrom = parseInt($('input[name="from-price"]').val());
        // let priceTo = parseInt($('input[name="to-price"]').val());

        var div = $(".filter-item");
        // if (div.find('.fil-params').hasClass('fil-active')) {
        //
        // }
        if( div.find('.fil-params').hasClass('fil-active')) {
            if (!div.is(e.target) && div.has(e.target).length === 0) {
                var brands = [], colors = [], materials = [], seasons = [], sizes = [];
                div.find('.fil-params').removeClass('fil-active');
                div.find('.filter-img').attr('src', '/images/home/arrow-down.png');
                let priceFrom = parseInt($('input[name="from-price"]').val());
                let priceTo = parseInt($('input[name="to-price"]').val());

                if (isNaN(priceFrom) && isNaN(priceTo)) {
                    $('input[name="from-price"]').val('');
                    $('input[name="to-price"]').val('');
                    priceFrom = 0;
                    priceTo = 0;
                }else if(isNaN(priceFrom) && !isNaN(priceTo)){
                    $('input[name="from-price"]').val('0');
                    priceFrom = 0;
                }else if(!isNaN(priceFrom) && isNaN(priceTo)){
                    $('input[name="from-price"]').val('0');
                    $('input[name="to-price"]').val(priceFrom.toString());
                    priceTo = priceFrom;
                    priceFrom = 0;
                }else if(!isNaN(priceFrom) && !isNaN(priceTo)){
                    if(priceFrom > priceTo){
                        let a = priceFrom;
                        priceFrom = priceTo;
                        priceTo = a;
                        $('input[name="from-price"]').val(priceFrom.toString());
                        $('input[name="to-price"]').val(priceTo.toString());
                    }
                }

                /* colors array */
                for (let i = 0; i < color.length; i++) {
                    if (color[i].firstChild.checked) {
                        colors.push(color[i].firstChild.getAttribute('id'));
                    }
                }
                /* brands array */

                for (let i = 0; i < brand.length; i++) {
                    if (brand[i].firstChild.checked) {
                        brands.push(brand[i].firstChild.getAttribute('id'));
                    }
                }

                /* materials array */
                for (let i = 0; i < material.length; i++) {
                    if (material[i].firstChild.checked) {
                        materials.push(material[i].firstChild.getAttribute('id'));

                    }
                }

                /* sizes array */
                for (let i = 0; i < size.length; i++) {
                    if (size[i].firstChild.checked) {
                        sizes.push(size[i].firstChild.getAttribute('id'));

                    }
                }
                /* seasons array */
                for (let i = 0; i < season.length; i++) {
                    if (season[i].firstChild.checked) {
                        seasons.push(season[i].firstChild.getAttribute('id'));
                    }
                }

                //
                if (colors.length > 0 || brands.length > 0 || materials.length > 0 || sizes.length > 0 || seasons.length > 0 || !isNaN(priceFrom) && !isNaN(priceTo)) {
                    if (colors.length > 0) {

                        if (url.split('?').length > 1) {
                            url += '&colors=' + colors.join('+')
                        } else {
                            url += '?colors=' + colors.join('+')
                        }

                    }

                    if (brands.length > 0) {
                        if (url.split('?').length > 1) {
                            url += '&brands=' + brands.join('+')
                        } else {
                            url += '?brands=' + brands.join('+')
                        }
                    }

                    if (materials.length > 0) {
                        if (url.split('?').length > 1) {
                            url += '&materials=' + materials.join('+')
                        } else {
                            url += '?materials=' + materials.join('+')
                        }
                    }

                    if (sizes.length > 0) {
                        if (url.split('?').length > 1) {
                            url += '&sizes=' + sizes.join('+')
                        } else {
                            url += '?sizes=' + sizes.join('+')
                        }
                    }
                    if (seasons.length > 0) {
                        if (url.split('?').length > 1) {
                            url += '&seasons=' + seasons.join('+')
                        } else {
                            url += '?seasons=' + seasons.join('+')
                        }
                    }

                    if(priceTo !=0){
                        if (url.split('?').length > 1) {
                            url += '&priceFrom=' + priceFrom.toString() + '&priceTo=' + priceTo.toString();
                        } else {
                            url += '?priceFrom=' + priceFrom.toString() + '&priceTo=' + priceTo.toString();
                        }
                    }

                   if(typeof orderBy !== 'undefined'){
                       if (url.split('?').length > 1) {
                           url += '&orderBy=' + orderBy;
                       } else {
                           url += '?orderBy=' + orderBy;
                       }
                   }
                }

                window.location.href = url;
            }
        }

    });

    $('select[name="order-by"]').find('option').mouseup( function() {
            var brands = [], colors = [], materials = [], seasons = [], sizes = [];

            let priceFrom = parseInt($('input[name="from-price"]').val());
            let priceTo = parseInt($('input[name="to-price"]').val());

            if (isNaN(priceFrom) && isNaN(priceTo)) {
                $('input[name="from-price"]').val('');
                $('input[name="to-price"]').val('');
                priceFrom = 0;
                priceTo = 0;
            }else if(isNaN(priceFrom) && !isNaN(priceTo)){
                $('input[name="from-price"]').val('0');
                priceFrom = 0;
            }else if(!isNaN(priceFrom) && isNaN(priceTo)){
                $('input[name="from-price"]').val('0');
                $('input[name="to-price"]').val(priceFrom.toString());
                priceTo = priceFrom;
                priceFrom = 0;
            }else if(!isNaN(priceFrom) && !isNaN(priceTo)){
                if(priceFrom > priceTo){
                    let a = priceFrom;
                    priceFrom = priceTo;
                    priceTo = a;
                    $('input[name="from-price"]').val(priceFrom.toString());
                    $('input[name="to-price"]').val(priceTo.toString());
                }
            }

            /* colors array */
            for (let i = 0; i < color.length; i++) {
                if (color[i].firstChild.checked) {
                    colors.push(color[i].firstChild.getAttribute('id'));
                }
            }
            /* brands array */

            for (let i = 0; i < brand.length; i++) {
                if (brand[i].firstChild.checked) {
                    brands.push(brand[i].firstChild.getAttribute('id'));
                }
            }

            /* materials array */
            for (let i = 0; i < material.length; i++) {
                if (material[i].firstChild.checked) {
                    materials.push(material[i].firstChild.getAttribute('id'));

                }
            }

            /* sizes array */
            for (let i = 0; i < size.length; i++) {
                if (size[i].firstChild.checked) {
                    sizes.push(size[i].firstChild.getAttribute('id'));

                }
            }
            /* seasons array */
            for (let i = 0; i < season.length; i++) {
                if (season[i].firstChild.checked) {
                    seasons.push(season[i].firstChild.getAttribute('id'));
                }
            }

            //
            if (colors.length > 0 || brands.length > 0 || materials.length > 0 || sizes.length > 0 || seasons.length > 0 || !isNaN(priceFrom) && !isNaN(priceTo)) {
                if (colors.length > 0) {

                    if (url.split('?').length > 1) {
                        url += '&colors=' + colors.join('+')
                    } else {
                        url += '?colors=' + colors.join('+')
                    }

                }

                if (brands.length > 0) {
                    if (url.split('?').length > 1) {
                        url += '&brands=' + brands.join('+')
                    } else {
                        url += '?brands=' + brands.join('+')
                    }
                }

                if (materials.length > 0) {
                    if (url.split('?').length > 1) {
                        url += '&materials=' + materials.join('+')
                    } else {
                        url += '?materials=' + materials.join('+')
                    }
                }

                if (sizes.length > 0) {
                    if (url.split('?').length > 1) {
                        url += '&sizes=' + sizes.join('+')
                    } else {
                        url += '?sizes=' + sizes.join('+')
                    }
                }
                if (seasons.length > 0) {
                    if (url.split('?').length > 1) {
                        url += '&seasons=' + seasons.join('+')
                    } else {
                        url += '?seasons=' + seasons.join('+')
                    }
                }

                if(priceTo !=0){
                    if (url.split('?').length > 1) {
                        url += '&priceFrom=' + priceFrom.toString() + '&priceTo=' + priceTo.toString();
                    } else {
                        url += '?priceFrom=' + priceFrom.toString() + '&priceTo=' + priceTo.toString();
                    }
                }


            }

            if (url.split('?').length > 1) {
                url += '&orderBy=' + $(this).val();
            } else {
                url += '?orderBy=' + $(this).val();
            }

            window.location.href = url;
    });

    $('.btn-danger-filters').click(function () {
        let base_url = location.href.split('?');
        window.location.href = base_url[0];
    });
});