@extends('main2')

@section('content')
<style>
.card {
    height:150px;
}
canvas.drawing, canvas.drawingBuffer {
            position: absolute;
            left: 0;
            top: 0;
        }
</style>




<div class="row">
    <div class="col-sm-12 col-md-3 mb-1 ">
        <div class="card border-left-primary shadow  h-100 py-0">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-auto mr-1">
                        <label for='quantity'>Plant</label>
                        <select name='plant' id='plant' autofocus >
                            @foreach(App\Models\tblCip_Plants::whereIn('Plant',Auth::user()->plants())->orderBy('Plant')->get() as $plant)
                                <option value='{{ $plant->id }}'>{{ $plant->Plant }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id='cameraRow' class="row">
    <div class="col-xl-3 col-md-6 mb-1 ">
        <div class="card border-left-primary shadow  h-100 py-0">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-1">
                        <div id="reader" style='width:340px; '></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
<!-- Earnings (Monthly) Card Example -->
    <div class="col-12 col-md-3 mb-1 ">
        <div class="card border-left-primary shadow h-100 py-0">
            <div class="card-body" id='msgback' style='background-color: transparent'>
                <div class="row no-gutters align-items-center">
                    <div class="col mr-1">
                        <span id='msg'></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-sm-12 col-md-3 mb-1 ">
        <div class="card border-left-primary shadow  h-100 py-0">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-auto mr-1">
                        <label for='quantity'>Quantity</label>
                        <input type='number' id='quantity' name='quantity' placeholder='0.0' >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-3 mb-1 ">
        <div class="card border-left-primary shadow  h-100 py-0">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-auto mr-1">
                        <label for='received'>Received</label>
                        <input type='number' id='received' name='received' placeholder='0.0'>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
<!-- Earnings (Monthly) Card Example -->
    <div class="col-12 col-md-3 mb-1 ">
        <div class="card border-left-primary shadow  h-100 py-0">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-1">
                        <label for='code'>Chemical ID</label>
                        <input type='text' id='code' name='code'>
                        <input type='hidden' id='chemid' name='chemid'>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


        
<div class="row">
<!-- Earnings (Monthly) Card Example -->
    <div class="col-12 col-md-3 mb-1 ">
        <div class="card border-left-primary shadow  h-100 py-0">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-12 mr-1">
                    <button class='btn btn-success form-control' id='sbmit'>Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection


@section('javascript')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script src="/js/barcode.min.js" ></script>


@endsection
