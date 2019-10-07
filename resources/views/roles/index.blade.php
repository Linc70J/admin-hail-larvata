<!-- begin:: Subheader -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">

            <h3 class="kt-subheader__title">職務</h3>

            <span class="kt-subheader__separator kt-subheader__separator--v"></span>

            <div class="kt-subheader__breadcrumbs">
                <a href="/" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <span class="kt-subheader__breadcrumbs-link">用戶與權限</span>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <a href="#" class="kt-subheader__breadcrumbs-link">職務</a>
            </div>
        </div>

        <div class="kt-subheader__toolbar">
            <a href="{{route('roles.create')}}" class="btn btn-label-brand btn-bold"><i
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
            </div>

            <div class="kt-separator kt-separator--md kt-separator--dashed"></div>
            <!--begin: Search Form -->
            <div id="filter-div" class="row kt-margin-b-20 collapse">
                <input type="hidden" class="filter-input" name="order">

                <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                    <label>職務:</label>
                    <input type="text" class="form-control filter-input" name="role_name" placeholder="Role Name"
                           aria-label="Name">
                </div>
                <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                    <label>權限:</label>
                    <input type="text" class="form-control filter-input" name="permission_name"
                           placeholder="Permission Name" aria-label="Permissions">
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
            <table id="role-datatable"
                   class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline"
                   data-url="{{ route('roles.index') }}">
                <thead>
                <tr>
                    <th data-priority="1">
                        <label class="kt-checkbox kt-checkbox--single kt-checkbox--solid" style="width: auto;">
                            <input type="checkbox" class="kt-group-checkable"><span></span> 職務名稱
                        </label>
                    </th>
                    <th data-priority="3">
                        權限
                    </th>
                    <th data-priority="2">
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
