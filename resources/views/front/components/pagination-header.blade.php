<div class="topbar-filter {{ $filterClass ?? '' }}">
    <p>تعداد <span>{{ number_format($movies->total()) }} فیلم</span>  یافت شد</p>
    <label for="order">مرتب سازی:</label>
    <select name="order" id="order">
        <option value="popularity" {{ activeState(request('order'), 'popularity') }}>محبوبیت</option>
        <option value="year-asc" {{ activeState(request('order'), 'year-asc') }}>سال ساخت صعودی</option>
        <option value="year-desc" {{ activeState(request('order'), 'year-desc') }}>سال ساخت نزولی</option>
        <option value="alphabetic-asc" {{ activeState(request('order'), 'alphabetic-asc') }}>حروف الفبا صعودی</option>
        <option value="alphabetic-desc" {{ activeState(request('order'), 'alphabetic-desc') }}>حروف الفبا نزولی</option>
    </select>
    {{--                    <a href="movielist.html" class="list"><i class="ion-ios-list-outline "></i></a>--}}
    {{--                    <a  href="moviegrid.html" class="grid"><i class="ion-grid active"></i></a>--}}
</div>
