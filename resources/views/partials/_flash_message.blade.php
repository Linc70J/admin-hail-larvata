@if ($errors = Session::get('errors'))
    <div class="row">
        <div class="col">
            <div class="alert alert-danger" role="alert">
                <div class="alert-text">
                    @if($message = Session::get('message'))
                        <h4 class="alert-heading">{{$message}}</h4>
                    @endif
                    <ul class="list-unstyled">
                        @foreach ($errors as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@elseif($message = Session::get('message'))
    <div class="row">
        <div class="col">
            <div class="alert alert-success" role="alert">
                <div class="alert-text">
                    <h4 class="alert-heading">{{$message}}</h4>
                </div>
            </div>
        </div>
    </div>
@endif
