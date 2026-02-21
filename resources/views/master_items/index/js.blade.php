<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    var start_date = '';
    var end_date = '';
    var data_per_fetch = 500;
    var data_fetched = 0;

    $(document).ready(function() {
        $('#table').DataTable({
            searching: false,
            order: [[0, 'desc']],
            columnDefs: [
                { targets: [2, 3, 8], render: function(data) { return data; } }
            ]
        });
        getData()
    });

    $('.btn-get-data').click(function() {
        getData()
    })

    function getData(){
        
        $('#loading-filter').show();
        var dataTableObj = $('#table').DataTable();
        var filter_kode = $('#filter-kode').val()
        var filter_nama = $('#filter-nama').val()
        var filter_harga_min = $('#filter-harga-min').val()
        var filter_harga_max = $('#filter-harga-max').val()
        dataTableObj.clear().draw();

        $.ajax({
            url: '{{url("master-items/search")}}',
            dataType: 'json',
            tryCount: 0,
            retryLimit: 3,
            data: 'kode=' + filter_kode + '&nama=' + filter_nama + '&hargamin=' + filter_harga_min + '&hargamax=' + filter_harga_max,
            success: function(results) {
                var data = results.data

                $.each(data, function(index, item) {
                    array_temp = [];
                    var harga_jual = item.harga_beli + item.harga_beli * item.laba / 100;
                    harga_jual = Math.round(harga_jual)
                    var kode = item.kode;

                    var html = `<a href="{{url('master-items/view/')}}/` + kode + `" class="btn btn-primary">View</a>`

                    array_temp.push(item.kode)
                    array_temp.push(item.nama)
                    
                    var foto_html = item.foto ? `<img src="{{asset('')}}` + item.foto + `" width="50" style="object-fit:cover">` : '-'
                    array_temp.push(foto_html)
                    var HTMLkat = '';
                    if(item.categories && item.categories.length > 0) {
                        $.each(item.categories, function(k, v) {
                            HTMLkat += '<span class="badge bg-secondary me-1">' + v.nama + '</span>';
                        });
                    } else {
                        HTMLkat += '-';
                    }
                    
                    array_temp.push(HTMLkat)
                    array_temp.push(item.jenis)
                    array_temp.push(item.harga_beli)
                    array_temp.push(harga_jual)
                    array_temp.push(item.supplier)
                    array_temp.push(html)


                    dataTableObj.row.add(array_temp).draw(true);
                });
                $('#loading-filter').hide();
            },
            error: function(xhr, textStatus, errorThrown) {
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    $.ajax(this);
                    return;
                }
                alert('Terjadi kesalahan server, tidak dapat mengambil data')
                $('#loading-filter').hide();

                return;
            }
        })
    }
</script>