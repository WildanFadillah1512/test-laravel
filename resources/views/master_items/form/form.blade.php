<form method="POST" enctype="multipart/form-data">
    @csrf
    @if($method == 'edit')
    <div class="form-group">
        <label>Kode Barang</label>
        <input type="text" class="form-control" name="kode_barang" required readonly value="{{$item->kode ?? ''}}">
    </div>
    @endif

    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required  value="{{$item->nama ?? ''}}">
    </div>

    <div class="form-group">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required  value="{{$item->harga_beli ?? ''}}">
    </div>

    <div class="form-group">
        <label>Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" required  value="{{$item->laba ?? ''}}">
    </div>

    @php $selected = $item->supplier ?? ''; @endphp
    <div class="form-group">
        <label>Supplier</label>
        <select class="form-control" required name="supplier">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Tokopaedi') selected @endif>Tokopaedi</option>
            <option @if($selected == 'Bukulapuk') selected @endif>Bukulapuk</option>
            <option @if($selected == 'TokoBagas') selected @endif>TokoBagas</option>
            <option @if($selected == 'E Commurz') selected @endif>E Commurz</option>
            <optio @if($selected == 'Blublu') selected @endif>Blublu</option>
        </select>
    </div>

    @php $selected = $item->jenis ?? ''; @endphp
    <div class="form-group">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Obat') selected @endif>Obat</option>
            <option @if($selected == 'Alkes') selected @endif>Alkes</option>
            <option @if($selected == 'Matkes') selected @endif>Matkes</option>
            <optio @if($selected == 'Umum') selected @endif>Umum</option>
            <optio @if($selected == 'ATK') selected @endif>ATK</option>
        </select>
    </div>

    <div class="form-group mt-2">
        <label class="d-flex justify-content-between align-items-center mb-1 w-100">
            <span>Kategori</span>
            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                Tambah Kategori Baru
            </button>
        </label>
        @php 
            $selectedCategories = isset($item->categories) ? $item->categories->pluck('id')->toArray() : [];
        @endphp
        <select class="form-control" name="categories[]" id="categoriesSelect" multiple>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @if(in_array($cat->id, $selectedCategories)) selected @endif>
                    {{ $cat->kode }} - {{ $cat->nama }}
                </option>
            @endforeach
        </select>
        <small class="text-muted" id="categoriesHelp">Tahan tombol Ctrl (Windows) atau Command (Mac) untuk memilih lebih dari satu.</small>
        @if($categories->count() == 0)
            <div class="alert alert-warning mt-2 mb-0" id="emptyCategoryAlert" role="alert">
                Belum ada kategori yang dibuat. Silakan klik tombol <strong>Tambah Kategori Baru</strong> di atas.
            </div>
        @endif
    </div>
    </div>

    <div class="form-group mt-2">
        <label>Foto</label>
        @if(isset($item->foto) && $item->foto)
            <div class="mb-2">
                <img src="{{ asset($item->foto) }}" alt="Foto Item" width="100">
            </div>
        @endif
        <input type="file" class="form-control" name="foto" accept="image/*">
    </div>

    <button class="btn btn-primary mt-3">Submit</button>

</form>

<!-- Modal Add Category -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger d-none" id="modalError">Tolong lengkapi semua isian!</div>
        <div class="form-group mb-2">
            <label>Kode Kategori</label>
            <input type="text" class="form-control" id="modalKodeCat" required>
        </div>
        <div class="form-group mb-2">
            <label>Nama Kategori</label>
            <input type="text" class="form-control" id="modalNamaCat" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="btnSaveCategory">Simpan Kategori</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>
    $(document).ready(function() {
        $('#btnSaveCategory').click(function() {
            var kode = $('#modalKodeCat').val();
            var nama = $('#modalNamaCat').val();
            
            if(kode == '' || nama == '') {
                $('#modalError').removeClass('d-none');
                return;
            }

            var btn = $(this);
            btn.prop('disabled', true).text('Menyimpan...');

            $.ajax({
                url: '{{ url("master-categories/api/store") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    kode: kode,
                    nama: nama
                },
                success: function(response) {
                    if(response.status == 200) {
                        var cat = response.data;
                        var newOption = new Option(cat.kode + ' - ' + cat.nama, cat.id, true, true);
                        $('#categoriesSelect').append(newOption).trigger('change');
                        
                        $('#emptyCategoryAlert').addClass('d-none');
                        $('#categoriesSelect').removeClass('d-none');
                        $('#addCategoryModal').modal('hide');
                        $('#modalKodeCat').val('');
                        $('#modalNamaCat').val('');
                        $('#modalError').addClass('d-none');
                    } else {
                        alert("Terjadi kesalahan saat menyimpan kategori.");
                    }
                },
                error: function(xhr) {
                    alert("A network error occurred.");
                },
                complete: function() {
                    btn.prop('disabled', false).text('Simpan Kategori');
                }
            });
        });
    });
</script>