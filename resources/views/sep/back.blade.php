@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12 border py-2">
                        <form action="{{ route('sep/verify.php') }}" method="post" id="frm">
                            @csrf
                            <input type="hidden" name="State" value="<?=$_POST['State']; ?>" />
                            <input type="hidden" name="StateCode" value="<?=$_POST['StateCode']; ?>" />
                            <input type="hidden" name="ResNum" value="<?=$_POST['ResNum']; ?>" />
                            <input type="hidden" name="MID" value="<?=$_POST['MID']; ?>" />
                            <input type="hidden" name="RefNum" value="<?=$_POST['RefNum']; ?>" />
                            <input type="hidden" name="CID" value="<?=$_POST['CID'] ?>" />
                            <input type="hidden" name="TRACENO" value="<?=$_POST['TRACENO'] ?>" />
                            <input type="hidden" name="SecurePan" value="<?=$_POST['SecurePan'] ?>" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('script')
    <script>
        $("#frm").submit();
    </script>
@endsection