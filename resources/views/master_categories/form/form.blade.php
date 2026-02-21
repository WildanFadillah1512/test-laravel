<form method="POST">
    @csrf
    @if(request()->has('redirect_to'))
        <input type="hidden" name="redirect_to" value="{{ request('redirect_to') }}">
    @endif
    <div class="form-group mb-2">
        <label>Kode Kategori</label>
        <input type="text" class="form-control" name="kode" required value="{{$item->kode ?? ''}}">
    </div>

    <div class="form-group mb-2">
        <label>Nama Kategori</label>
        <input type="text" class="form-control" name="nama" required value="{{$item->nama ?? ''}}">
    </div>

    <button class="btn btn-primary mt-3">Submit</button>
</form>
