<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<div class="container">
    <div class="row">
        <div class="social-buttons col-md-6">
            <a class="btn btn-facebook btn-lg" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}" target="_blank">
                <span class="fa fa-facebook"></span>
            </a>

            <a class="btn btn-twitter btn-lg" href="https://twitter.com/intent/tweet?url={{ urlencode($url) }}" target="_blank">
                {{--<i class="fa fa-twitter-square"></i>--}}
                <span class="fa fa-twitter"></span>
            </a>

            <a class="btn btn-google btn-lg" href="https://plus.google.com/share?url={{ urlencode($url) }}" target="_blank">
                <span class="fa fa-google-plus"></span>
            </a>
            {{--<a class="btn btn-email btn-lg" href="https://mail.google.com/share?url={{ urlencode($url) }}" target="_blank">--}}
                {{--<span class="fa fa-envelope"></span>--}}
            {{--</a>--}}
        </div>
    </div>
</div>