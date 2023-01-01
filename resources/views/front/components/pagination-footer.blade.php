<div class="topbar-filter">
    <label for="per-page">تعداد در هر صفحه:</label>
    <select name="per-page" id="per-page">
        <option value="10" {{ activeState(request('per-page'), 10) }}>10 فیلم</option>
        <option value="20" {{ activeState(request('per-page'), 20) }}>20 فیلم</option>
        <option value="30" {{ activeState(request('per-page'), 30) }}>30 فیلم</option>
        <option value="40" {{ activeState(request('per-page'), 40) }}>40 فیلم</option>
        <option value="50" {{ activeState(request('per-page'), 50) }}>50 فیلم</option>
        <option value="100" {{ activeState(request('per-page'), 100) }}>100 فیلم</option>
    </select>

    <div class="pagination2">
        <span>صفحه {{$movies->currentPage()}} از {{$movies->lastPage()}}:</span>
        {!! $movies->links('vendor.pagination.front') !!}
        <a href="{{ $movies->nextPageUrl() }}"><i class="ion-arrow-left-b"></i></a>
    </div>
</div>
