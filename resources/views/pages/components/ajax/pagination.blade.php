@if(count($products) > 0 )
    @foreach($products as $item)
        @include('components.product')
    @endforeach
@else
    <div class="col-sm-9 no-found">
      Вибачте, за вашим запитом товари не знайдені.
    </div>
@endif

<!--end products-->
