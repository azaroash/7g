<script>
    function showUser(str) {
        if (str==''){
            document.getElementById("txtHint").innerHTML="";
            return;
        }
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        }
        else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function () {
            if (this.readyState==4 && this.status==200) {
                document.getElementById("txtHint").innerHTML=this.responseText;
            }
        }
        xmlhttp.open("GET", "RegisterPurchaseController.php?$id="+str, true);
        xmlhttp.send();
    }
</script>

<form method="POST" action="{{ route('registerPurhcase') }}" aria-label="{{ __('Register Purchase') }}">
    @csrf

    <div class="form-group row">
        <label for="id" class="col-md-4 col-form-label text-md-right">{{ __('User ID') }}</label>

        <div class="col-md-6">
            <input id="userId" type="text" class="form-control{{ $errors->has('userId') ? ' is-invalid' : '' }}" name="userId" value="{{ old('userId') }}" required autofocus>

            @if ($errors->has('userId'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('userId') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount') }}</label>

        <div class="col-md-6">
            <input id="amount" type="text" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" value="{{ old('amount') }}" required autofocus>

            @if ($errors->has('amount'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('amount') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Register') }}
            </button>
        </div>
    </div>
</form>
