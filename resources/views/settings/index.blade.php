<!-- begin:: Subheader -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">

            <h3 class="kt-subheader__title">站點設定</h3>

            <span class="kt-subheader__separator kt-subheader__separator--v"></span>

            <div class="kt-subheader__breadcrumbs">
                <a href="/" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <span class="kt-subheader__breadcrumbs-link">站點管理</span>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <a href="#" class="kt-subheader__breadcrumbs-link">站點設定</a>
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
    <div class="alert alert-light alert-elevate" role="alert">
        <div class="alert-icon alert-icon-top"><i class="flaticon-warning kt-font-brand"></i></div>
        <div class="alert-text">
            <p>
                The layout builder helps to configure the layout with preferred options and preview it in real time.
                The configured layout options will be saved until you change or reset them.
                To use the layout builder choose the layout options and click the <code>Preview</code> button to preview
                the changes and click the <code>Export</code> to download the HTML template with its includable partials
                of this demo.
                In the downloaded folder the partials(header, footer, aside, topbar, etc) will be placed seperated from
                the base layout to allow you to integrate base layout into your application
            </p>
            <p>
                <span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--danger kt-badge--rounded">NOTE:</span>&nbsp;&nbsp;The
                downloaded version does not include the assets folder since the layout builder's main purpose is to help
                to generate the final HTML code without hassle.
            </p>
        </div>
    </div>

    <!--begin::Portlet-->
    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-left nav-tabs-line-primary"
                    role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_builder_skins" role="tab"
                           aria-selected="true">
                            Skins
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_builder_page" role="tab" aria-selected="false">
                            Page
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" action="" method="POST">
            <div class="kt-portlet__body">
                <div class="tab-content">
                    <div class="tab-pane active" id="kt_builder_skins">
                        <div class="kt-section kt-margin-t-30">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Header Skin:</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <select class="form-control" name="builder[layout][header][self][skin]">
                                            <option value="light" selected="">Light(default)</option>
                                            <option value="dark">Dark</option>
                                        </select>
                                        <div class="form-text text-muted">Select header skin</div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Header Menu Skin:</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <select class="form-control"
                                                name="builder[layout][header][menu][desktop][submenu][skin]">
                                            <option value="light" selected="">Light(default)</option>
                                            <option value="dark">Dark</option>
                                        </select>
                                        <div class="form-text text-muted">Select header skin</div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Logo Bar Skin:</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <select class="form-control" name="builder[layout][brand][self][skin]">
                                            <option value="dark" selected="">Dark(default)</option>
                                            <option value="light">Light</option>
                                        </select>
                                        <div class="form-text text-muted">Select logo bar skin</div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Aside Skin:</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <select class="form-control" name="builder[layout][aside][self][skin]">
                                            <option value="dark" selected="">Dark(default)</option>
                                            <option value="light">Light</option>
                                        </select>
                                        <div class="form-text text-muted">Select left aside skin</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="kt_builder_page">
                        <div class="kt-section kt-margin-t-30">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Page Loader:</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <select class="form-control" name="builder[layout][loader][type]">
                                            <option value="" selected="">Disabled</option>
                                            <option value="default">Spinner</option>
                                            <option value="spinner-message">Spinner &amp; Message</option>
                                            <option value="spinner-logo">Spinner &amp; Logo</option>
                                        </select>
                                        <div class="form-text text-muted">Select page loading indicator</div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Display Page Toolbar:</label>
                                    <div class="col-lg-9 col-xl-4">
                                        <input type="hidden" name="builder[layout][toolbar][display]" value="false">
                                        <span class="kt-switch kt-switch--icon-check">
										<label>
									        <input type="checkbox" name="builder[layout][toolbar][display]" value="true"
                                                   checked="">
									        <span></span>
									    </label>
									</span>
                                        <div class="form-text text-muted">Display or hide the page's right center
                                            toolbar(demos switcher, documentation and page builder links)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>
    <!--end::Portlet-->

    <!--begin::Modal-->
    <div class="modal fade kt-modal-purchase" id="kt-modal-purchase" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">reCaptcha Verification</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div id="alert-message" class="alert alert-danger kt-alert kt-alert--air kt-hide"
                         role="alert"></div>

                    <form class="kt-form">
                        <div class="form-group">
                            <script src="https://www.google.com/recaptcha/api.js"></script>
                            <div class="g-recaptcha" data-sitekey="6Lf92jMUAAAAANk8wz68r73rA2uPGr4_e0gn96BL">
                                <div style="width: 304px; height: 78px;">
                                    <div>
                                        <iframe
                                            src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6Lf92jMUAAAAANk8wz68r73rA2uPGr4_e0gn96BL&amp;co=aHR0cHM6Ly9rZWVudGhlbWVzLmNvbTo0NDM.&amp;hl=zh-TW&amp;v=Zy-zVXWdnDW6AUZkKlojAKGe&amp;size=normal&amp;cb=4xyoitt8r3cd"
                                            width="304" height="78" role="presentation" name="a-yx3yvjjyuv4k"
                                            frameborder="0" scrolling="no"
                                            sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox"></iframe>
                                    </div>
                                    <textarea id="g-recaptcha-response" name="g-recaptcha-response"
                                              class="g-recaptcha-response"
                                              style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submit-verify">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->
</div>
