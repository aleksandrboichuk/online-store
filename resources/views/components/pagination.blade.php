<div class="pagination">
        @if (is_array($elements[0]) && count($elements[0]) > 1)
                <button class="next-page btn btn-default" id="{{count($elements[0])}}">Показати більше</button>
        @endif
</div>