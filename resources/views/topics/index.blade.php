<!-- begin:: Subheader -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">

            <h3 class="kt-subheader__title">話題</h3>

            <span class="kt-subheader__separator kt-subheader__separator--v"></span>

            <div class="kt-subheader__breadcrumbs">
                <a href="/" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <span class="kt-subheader__breadcrumbs-link">內容管理</span>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <a href="#" class="kt-subheader__breadcrumbs-link">話題</a>
            </div>
        </div>

        <div class="kt-subheader__toolbar">
            <a href="{{route('topics.create')}}" class="btn btn-label-brand btn-bold"><i
                    class="la la-plus"></i>@lang('crud.create')</a>
        </div>
    </div>
</div>
<!-- end:: Subheader -->

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <!--begin::Portlet-->
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-lg-6">
                    <button type="button" class="btn btn-danger btn-brand--icon" id="batch-delete-btn">
						<span>
							<i class="la la-trash"></i>
							<span>@lang('crud.delete')</span>
						</span>
                    </button>
                    &nbsp;&nbsp;
                    <button class="btn btn-warning btn-brand--icon" data-toggle="collapse" data-target="#filter-div">
						<span>
							<i class="la la-filter"></i>
							<span>@lang('crud.filter')</span>
						</span>
                    </button>
                </div>
                <div class="col-lg-6 kt-align-right">
                    <label>@lang('crud.sort-mode')：</label>
                    <div id="sort-mode" class="btn-group btn-group" role="group">
                        <button type="button" class="btn btn-secondary active" data-value="default">最新</button>
                        <button type="button" class="btn btn-secondary" data-value="hot">熱門</button>
                        <button type="button" class="btn btn-secondary" data-value="replied">回覆</button>
                        <button type="button" class="btn btn-secondary" data-value="custom">自訂</button>
                    </div>
                </div>
            </div>

            <div class="kt-separator kt-separator--md kt-separator--dashed"></div>
            <!--begin: Search Form -->
            <div id="filter-div" class="row kt-margin-b-20 collapse">
                <input type="hidden" class="filter-input" name="order">
                <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                    <label>分類:</label>
                    <select class="form-control filter-input" name="topic_category_id" aria-label="分類">
                        <option value="">Select</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                    <label>日期:</label>
                    <div class="lar-daterange input-group">
                        <input type="text" class="form-control lar-datepicker-input lar-datepicker-start filter-input"
                               name="start_date" placeholder="From" aria-label="From">
                        <div class="input-group-append">
                            <span class="input-group-text">~</span>
                        </div>
                        <input type="text" class="form-control lar-datepicker-input lar-datepicker-end filter-input"
                               name="end_date" placeholder="To" aria-label="To">
                    </div>
                </div>
                <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                    <label>作者:</label>
                    <input type="text" class="form-control filter-input" name="user_name" placeholder="Name"
                           aria-label="Name">
                </div>
                <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                    <label>內容:</label>
                    <div class="kt-input-icon kt-input-icon--right">
                        <input type="text" class="form-control filter-input" name="text_search"
                               placeholder="Search..." aria-label="Search">
                        <span class="kt-input-icon__icon kt-input-icon__icon--right">
								<span><i class="la la-search"></i></span>
							</span>
                    </div>
                </div>
                <div class="col-lg-12 kt-margin-t-20 kt-align-right">
                    <button class="btn btn-primary btn-brand--icon" id="search-btn">
						<span>
							<i class="la la-search"></i>
							<span>@lang('crud.search')</span>
						</span>
                    </button>
                    &nbsp;&nbsp;
                    <button class="btn btn-secondary btn-secondary--icon" id="reset-btn">
						<span>
							<i class="la la-close"></i>
							<span>@lang('crud.reset')</span>
						</span>
                    </button>
                </div>
            </div>
            <!--end: Search Form -->
            <!--begin: Datatable -->
            <table id="topic-datatable"
                   class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline"
                   data-url="{{ route('topics.index') }}">
                <thead>
                <tr>
                    <th data-priority="1">
                    </th>
                    <th data-priority="2">
                        <label class="kt-checkbox kt-checkbox--single kt-checkbox--solid" style="width: auto;">
                            <input type="checkbox" class="kt-group-checkable"><span></span> 話題
                        </label>
                    </th>
                    <th data-priority="4">
                        分類
                    </th>
                    <th data-priority="5">
                        狀態
                    </th>
                    <th data-priority="6">
                        時間
                    </th>
                    <th data-priority="3">
                        管理
                    </th>
                </tr>
                </thead>
                <tbody class="tbody">
                </tbody>
            </table>
            <!--end: Datatable -->
        </div>
    </div>
    <!--end::Portlet-->
</div>
