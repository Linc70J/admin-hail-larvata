<!-- begin:: Subheader -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">編輯用戶</h3>

            <span class="kt-subheader__separator kt-subheader__separator--v"></span>

            <div class="kt-subheader__breadcrumbs">
                <a href="/" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <span class="kt-subheader__breadcrumbs-link">用戶與權限</span>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <a href="{{route('users.index')}}" class="kt-subheader__breadcrumbs-link">用戶</a>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <a href="#" class="kt-subheader__breadcrumbs-link">編輯用戶</a>
            </div>
        </div>

        <div class="kt-subheader__toolbar">
            <a href="{{route('users.index')}}" class="btn btn-default btn-bold">Back</a>
        </div>
    </div>
</div>

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
@include('partials._flash_message')
<!--Begin::App-->
    <div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">
        <!--Begin:: App Aside Mobile Toggle-->
        <button class="kt-app__aside-close" id="kt_user_profile_aside_close">
            <i class="la la-close"></i>
        </button>
        <!--End:: App Aside Mobile Toggle-->

        <!--Begin:: App Aside-->
        <div class="kt-grid__item kt-app__toggle kt-app__aside" id="kt_user_profile_aside" style="opacity: 1;">
            <!--begin:: Widgets/Applications/User/Profile1-->
            <div class="kt-portlet ">
                <div class="kt-portlet__body kt-portlet__body--fit-y">
                    <!--begin::Widget -->
                    <div class="kt-widget kt-widget--user-profile-1" style="margin-top: 25px;">
                        <div class="kt-widget__head">
                            <div class="kt-widget__media">
                                <img
                                    src="{{$data->avatar ?? false ? $data->avatar->getUrl() : Theme::asset()->url('media/users/default.jpg')}}"
                                    alt="image">
                            </div>
                            <div class="kt-widget__content">
                                <div class="kt-widget__section">
                                    <a href="#" class="kt-widget__username">
                                        {{$data->name}}
                                        @if($data->hasVerifiedEmail())
                                            <i class="flaticon2-correct kt-font-success"></i>
                                        @endif
                                    </a>
                                    <span class="kt-widget__subtitle">
                                        {{$data->introduction}}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="kt-widget__body">
                            <div class="kt-widget__content">
                                <div class="kt-widget__info">
                                    <span class="kt-widget__label">帳號:</span>
                                    <a href="#" class="kt-widget__data">{{$data->email}}</a>
                                </div>
                                <div class="kt-widget__info">
                                    <span class="kt-widget__label">聯絡電話:</span>
                                    <a href="#" class="kt-widget__data">{{$data->contact_phone}}</a>
                                </div>
                            </div>
                            <div class="kt-widget__items">
                                <ul class="nav nav-fill" role="tablist">
                                    <li class="nav-item" style="width: 100%;">
                                        <a href="#personal-information" data-toggle="tab"
                                           class="kt-widget__item nav-link {{active_class($tab == 'personal-information')}}">
                        <span class="kt-widget__section">
                            <span class="kt-widget__icon">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"></polygon>
        <path
            d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
            fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
        <path
            d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
            fill="#000000" fill-rule="nonzero"></path>
    </g>
</svg>                            </span>
                            <span class="kt-widget__desc">
                                個人資訊
                            </span>
                        </span>
                                        </a>
                                    </li>
                                    <li class="nav-item" style="width: 100%;">
                                        <a href="#change-password" data-toggle="tab"
                                           class="kt-widget__item nav-link {{active_class($tab == 'change-password')}}">
                        <span class="kt-widget__section">
                            <span class="kt-widget__icon">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"></rect>
        <path
            d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z"
            fill="#000000" opacity="0.3"></path>
        <path
            d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z"
            fill="#000000" opacity="0.3"></path>
        <path
            d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z"
            fill="#000000" opacity="0.3"></path>
    </g>
</svg>                            </span>
                            <span class="kt-widget__desc">
                                變更密碼
                            </span>
                        </span>
                                        </a>
                                    </li>
                                    <li class="nav-item" style="width: 100%;">
                                        <a href="#settings" data-toggle="tab"
                                           class="kt-widget__item nav-link {{active_class($tab == 'settings')}}">
                        <span class="kt-widget__section">
                            <span class="kt-widget__icon">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"></rect>
        <path
            d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z"
            fill="#000000" opacity="0.3"></path>
        <path
            d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z"
            fill="#000000"></path>
    </g>
</svg>                            </span>
                            <span class="kt-widget__desc">
                                帳戶設定
                            </span>

                    </span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--end::Widget -->
                </div>
            </div>
            <!--end:: Widgets/Applications/User/Profile1-->
        </div>
        <!--End:: App Aside-->

        <!--Begin:: App Content-->
        <div class="kt-grid__item kt-grid__item--fluid kt-app__content tab-content">
            <div class="row tab-pane {{active_class($tab == 'personal-information')}}" id="personal-information"
                 role="tabpanel">
                @include('users.partials.personal-information')
            </div>
            <div class="row tab-pane {{active_class($tab == 'change-password')}}" id="change-password" role="tabpanel">
                @include('users.partials.change-password')
            </div>
            <div class="row tab-pane {{active_class($tab == 'settings')}}" id="settings" role="tabpanel">
                @include('users.partials.settings')
            </div>
        </div>
        <!--End:: App Content-->
    </div>
    <!--End::App-->
</div>
<!-- end:: Subheader -->
