{{--<input type="hidden" class="rating" data-filled="fa fa-bell fa-3x" data-empty="fa fa-bell-o fa-3x"/>--}}
{{--<span class="fa fa-star checked"></span>--}}
{{--<span class="fa fa-star checked"></span>--}}
{{--<span class="fa fa-star checked"></span>--}}
{{--<span class="fa fa-star"></span>--}}
{{--<span class="fa fa-star"></span>--}}
<link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>

<div class="container col-md-4">
    {{--<h2>Bootstrap star rating example</h2><br/>--}}

    <label for="input-1" class="control-label">Give a rating for Skill:</label>
    <input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="2"><br/>

    {{--<label for="input-2" class="control-label">Give a rating for Knowledge:</label>--}}
    {{--<input id="input-2" name="input-2" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="4"><br/>--}}

    {{--<label for="input-3" class="control-label">Give a rating for PHP:</label>--}}
    {{--<input id="input-3" name="input-3" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="5">--}}
</div>

<script>
    $("#input-id").rating();
</script>