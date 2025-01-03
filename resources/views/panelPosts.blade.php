@extends('layouts.base')
@section('title', 'Data Post')

@section('content')

<style type="text/css">
    .myFont {
        font-size: 16px;  
        font-weight: bold !important;
    }
</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Data Post</h2>
                <div class="d-flex flex-row-reverse" style="margin-bottom:10px;">
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table" id="tablePosts">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
     function getDataPosts(step=1) {
        let myTableName = 'tablePosts';

        let myTable = $(`#${myTableName}`).DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ordering: true,
            destroy: true,
            searching: true,
            dom: 'B<"clear">lfrtip',
            buttons: [
                'copy', 'excel', 'pdf'
            ],
            ajax: {
                url: "{{ url('panel/posts') }}",
                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                data: {},
                async: true,
                error: function (xhr, error, code) {
                    if(step<5){
                        step+=1;
                        getDataPosts(step)
                    }
                }
            },
            columns: [{ data: 'DT_RowIndex', title:'No', searchable: false},
                {data: 'title', title: 'Judul', className: "myFilter"},
                {data: 'content', title: 'Content', className: "myFilter"},
                {data: 'tags', title: 'Tag', className: "myFilter"},
                {data: 'action', width:'500', title: 'Action', orderable: false, searchable: false,
                    render: function ( data, type, row ) {

                        let idPost  = row.id;
                        let btnApprove = ``;

                        if(row.is_approved=='0'){
                            btnApprove = `<a class="btn btn-sm btn-icon btn-primary btn-circle mr-2 approve" title="Approve" data-id="${idPost}"><i class="fa fa-pencil-alt"></i></a>`;
                        }
                        let all = `${btnApprove}`;
                        return all;
                    } 
                },
            ],
            tfoot: $(`#${myTableName} tfoot`),
            // order: [[ 1, "asc" ]],
            scrollY: true,
            scrollX: true,
            pageLength: 5,
            lengthMenu: [
                [5, 10, 15, 20, 30, 40, 50, 100, 200, 500, 1000, -1],
                [5, 10, 15, 20, 30, 40, 50, 100, 200, 500, 1000, 'Semua']
            ],
            createdRow: function( row, data, dataIndex ) {
                $(row).attr('id_siswa', data['id']);
            },
            "fnInitComplete": function (oSettings) {
            },
        });

        $(`#${myTableName}_wrapper thead th`).each(function () {
            let title = $(this).text();
            let thisWidth = $(this).width();
            if ($(this).hasClass('myFilter')) {
                if(thisWidth < 60){ thisWidth = 100; }
                $(this).html(title+`<br> <input type="text" style="width:${thisWidth}px;" class="col-search-input" placeholder="Cari" />`);
            }
        });
        
        myTable.columns().every(function () {
            let table = this;
            $('input', this.header()).on('keyup change', function () {
                if (table.search() !== this.value) {
                    table.search(this.value).draw();
                }
            });
        });
    }

    $('document').ready(function () {
        getDataPosts()
    });
    
    $('body').on('click', '.approve', function (e) {
        e.preventDefault();
        let confirmed = confirm('Are you sure to Approve ?');
        let idPost = $(this).attr('data-id');

        if (confirmed) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}", Accept: "application/json",},
                url: `{{ url('panel/approve/${idPost}') }}`,
                type: "POST",
                dataType: 'json',
                success: function (resp) {
                    if(resp.status == true){
                        Swal.fire({
                            // position: 'top-end',
                            icon: 'success',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 1300
                        }).then((result) => {
                            getDataPosts()
                        });
                    } else {
                        Swal.fire({
                            position: 'centered',
                            icon: 'error',
                            title: `${resp.message}`,
                            showConfirmButton: true,
                            timer: 1500
                        }).then((result) => {
                        });
                    }
                },
                error: function (data) {
                    swal_error();
                }
            });
        }
    });

</script>
@endpush

@endsection
