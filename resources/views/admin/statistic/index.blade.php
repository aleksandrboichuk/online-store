@extends('layouts.admin')

@section('content')
    @if(session()->has('success-message'))
        <div class="alert alert-success alert-active" role="alert">
            <h4 class="alert-heading">Виконано!</h4>
            <p>{{session('success-message')}}</p>
            <hr>
            <div class="mb-0"><button type="button" class="btn btn-danger alert-btn alert-btn-close">Закрити</button></div>
        </div>
        @php(session()->forget('success-message'))
    @endif
    <section id="table_items">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="/admin">Панель Адміністратора</a> </li>
                <li class="active">Товари</li>
            </ol>
        </div>
        <div class="container">
            <div class="row">
                <div class="admin_statistic_dates">
                    <div class="date_start">
                        <label for="date-start">Дата початку</label>
                        <input type="date" id="date-start" name="date-start"/>
                    </div>
                    <div class="date_finish">
                        <label for="date-finish">Дата закінчення</label>
                        <input type="date" id="date-finish" name="date-finish"/>
                    </div>
                    <div class="btn-admin">
                       <button type="button" class="btn btn-default todo-btn">Переглянути</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive general-table-index general-table-index-with-pagination">
                <table class="table table-condensed table-admin-with-pagination">
                    <thead>
                    <tr class="general_menu">
                        <td><b>Популярні товари</b></td>
                        <td><b>К-сть замов.</b></td>
                        <td><b>Сума замов.</b></td>
                        <td><b>Попул. група категорій</b></td>
                        <td><b>Попул. категорія</b></td>
                        <td><b>Попул. під-категорія</b></td>
                        <td><b>Попул. бренд</b></td>
                        <td><b>Зареєстр. користувачів</b></td>
                    </tr>
                    </thead>
                    <tbody class="general-table">


                    </tbody>
                </table>
                {{--{{$products->appends(request()->query())->links('parts.pagination')}}--}}
            </div>
        </div>
    </section>

@endsection
@section('custom-js')
    <script>
        $(document).ready(function () {
            // $('.alert-btn-close').click(function () {
            //     $(this).parent().parent().removeClass('alert-active');
            // });
            //
            // let countPage = 1;
            // $('.next-page').click(function () {
            //     event.preventDefault();
            //     countPage += 1;
            //     let url = location.href;
            //     if (countPage <= $(this).attr('id')) {
            //         $.ajax({
            //             url: url.split('?page')[0] + '?page=' + countPage,
            //             type: "GET",
            //             success: function (data) {
            //                 $('.general-table').append(data)
            //             }
            //         });
            //     }
            //
            //     if (countPage == $(this).attr('id')) {
            //         $(this).css('display', 'none');
            //     }
            // });


            $(document).on('click','.todo-btn', function () {
                let date_start = $('input[name="date-start"]').val();
                let date_finish = $('input[name="date-finish"]').val();

                if(date_start.trim() != '' || date_finish.trim != ''){
                    $.ajax({
                        url: "{{route('statistic')}}",
                        type: "GET",
                        data: {
                            date_start: date_start,
                            date_finish: date_finish,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data){
                             $('.general-table').html(data)
                        }
                    });
                }

            });
        });
    </script>
@endsection