@extends('mtchome.template')

@section('content')

@if(Session::has('alert-success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{Session::get('alert-success')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@elseif(Session::has('alert-danger'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{Session::get('alert-danger')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif


<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Request Perbaikan</h3>
    </div>
    <div class="card-body">
        <form action="" id="form-complete">
            <div class="row">
                @csrf
                <div class="form-group col-md-2">
                    <label for="from">No. Permintaan : </label>



                </div>
                <div class="form-group col-md-3">
                    <input type="hidden" name="id_req" id="id_req" value="{{$request->id_perbaikan}}">
                    {{$request->no_perbaikan}}
                </div>
                <div class="form-group col-md-3">
                    <label for="no-permintaan">Tanggal : </label>
                    {{date_format(date_create($request->tanggal_rusak),'Y-m-d')}}

                </div>
                <div class="form-group col-md-3">
                    <label for="no-permintaan">Jam : </label>
                    {{date_format(date_create($request->tanggal_rusak),'H:i')}}
                </div>

            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="no-permintaan">Departemen : </label>
                </div>
                <div class="form-group col-md-3">

                    {{$request->departemen}}
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="no-permintaan">Shift : </label>
                </div>
                <div class="form-group col-md-3">

                    {{$request->shift}}
                </div>
                <div class="form-group col-md-2">
                    <label for="">User : </label>
                    {{$user->user_name}}
                </div>

            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="">No. Mesin : </label>
                </div>
                <div class="form-group col-md-3">

                    {{$request->no_induk_mesin}}
                </div>
                <div class="form-group col-md-6">
                    <label for="">Nama Mesin : </label>
                    {{$request->nama_mesin}}
                </div>

            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="">Masalah : </label>
                </div>

                <div class="form-group col-md-6">
                    {{$request->masalah}}
                </div>

            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="">Kondisi : </label>
                </div>

                <div class="form-group col-md-3">
                    {{$request->kondisi}}
                </div>
                <div class="form-group col-md-2">
                    <label for="">Maintenance : </label>

                </div>
                <div class="form-group col-md-4">
                    <ul>
                        @foreach ($operator as $k)
                        <li>
                            {{$k->nama}}
                        </li>
                        @endforeach
                    </ul>
                </div>

            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="penyebab">Penyebab : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control @error('masalah') is-invalid @enderror" name="penyebab"
                        id="penyebab" placeholder="Penyebab Kerusakan" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="penyebab">Mulai Perbaikan : </label>
                </div>
                <div class="form-group col-md-3">
                    <input type="datetime-local" class="form-control" name="tanggal_mulai" id="tanggal_mulai" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="tindakan">Tindakan : </label>
                </div>
                <div class="form-group col-md-4">
                    <textarea name="tindakan" id="tindakan" class="form-control" cols="30" rows="5"
                        placeholder="Tindakan Perbaikan" required></textarea>
                </div>
                <div class="form-group col-md-2">
                    <label for="tindakan">Selesai Perbaikan : </label>
                </div>
                <div class="form-group col-md-3">
                    <input type="datetime-local" class="form-control" name="tanggal_selesai" id="tanggal_selesai"
                        required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="inputpart">Part</label>

                    <button type="button" class="btn-xs btn-success" id="btn_parts"><i class="fa fa-plus"></i>
                        Sparepart</button>
                    <table class="table table-bordered" id="tb_use">
                        <thead>
                            <tr>
                                <th style="width: 100px">Item Code</th>
                                <th>Nama</th>
                                <th style="width: 20px">Qty</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>
                <div class="form-group col-md-2">
                    <label for="klasifikasi">Klasifikasi :</label>
                    <select name="klasifikasi" id="klasifikasi" class="form-control" required>
                        @foreach ($jenis as $l)
                        <option value="{{$l->key}}" {{( $l->key == $request->klasifikasi) ? 'selected' : ''}}>
                            {{$l->value}}</option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group col-md-4">
                    <ul>
                        <li>A : Mesin/Alat masih bisa beroperasi dan hanya perbaikan ringan</li>
                        <li>B : Mesin/Alat masih bisa beroperasi dan harus dihentikan saat perbaikan</li>
                        <li>C : Mesin/Alat tidak bisa beroperasi</li>
                        <li>D : Mesin/Alat Stop atau Over Haul dan dikerjakan pada hari libur</li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col col-md-6">
                    <input type="submit" id="btn-submit" class="btn btn-success" value="Simpan">
                </div>

                <div class="text-right">
                    <a href="{{url('/maintenance/schedule')}}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>

    </div>



    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="exampleModalCenter"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">List Spareparts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body table-responsive p-0">
                    <div class="container">

                        <table id="tb_spareparts" class="table table-bordered table-striped dataTable">
                            <thead>

                                <th></th>
                                <th>Item_code</th>
                                <th>Item</th>
                                <th>Spesifikasi</th>

                            </thead>
                        </table>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="laincheck">
                            <label class="form-check-label" for="exampleCheck1">Sparepart Lain</label>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Lain-lain :</label>
                            <input type="text" name="lain" id="lain" class="form-control" placeholder="Parts lain"
                                disabled>

                        </div>


                        <div class="form-group col-md-3">
                            <label for="qty_parts">Qty:</label>
                            <input type="number" class="form-control" name="qty_parts" id="qty_parts" placeholder="Qty">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    <button type="button" class="btn btn-primary" id="pilih_item">Pilih Item</button>


                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function(){
    var key = localStorage.getItem('npr_token');
    var list_parts =  $('#tb_spareparts').DataTable({
                            processing: true,
                            serverSide: true,
                            searching: true,
                            ordering: false,
                            ajax: {
                                            url: APP_URL+'/api/spareparts',
                                            type: "POST",
                                            headers: { "token_req": key },
                                        },
                             columnDefs : [{
                                            orderable : false,
                                            data : null,
    				                        defaultContent : '',
                                            className : 'select-checkbox',
                                            targets :   0,
					
					                        }],
					        select: {
                                        style :    'os',
                                        selector : 'td:first-child'
                                        },
                            columns: [
                                { data: null, name: 'check' },
                                { data: 'item_code', name: 'item_code' },
                                { data: 'item', name: 'item' },
                                { data: 'spesifikasi', name: 'spesifikasi' }
                               
                            ]
                        });
 $('#pilih_item').click(function() {
            var data = list_parts.row({ selected: true }).data();
            var qty = Number($('#qty_parts').val());
            var lain = $("#lain").val();
            if ($("#laincheck").prop('checked')) {
                if (lain == '' || lain == null) {
                    alert('Pilih data belum diisi !');
                }else{
                var newrow = '<tr><td><input type ="hidden" name="part_code[]" value="-" />-</td><td><input type ="hidden" name="part_name[]" value="'+lain+'" />'+lain+'</td><td><input type ="hidden" name="part_qty[]" value="'+qty+'" />'+qty+'</td><td><button type="button" class="btnSelect btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></td></tr>';
                    
                        $('#tb_use tbody').append(newrow); 
                        data = null;
                        $("#laincheck").prop("checked",false);
                        $("#lain").prop("disabled",true);
                        $("#lain").val('');
                        $('#qty_parts').val(''); 
                        $('#exampleModalCenter').modal('hide');
            }
            }else{

            if (!data) {
					alert('Pilih Item !');
				}else{
					if (qty <= 0|| qty == null) {
						alert('Qty belum diisi !');
					}else{
                        var newrow = '<tr><td><input type ="hidden" name="part_code[]" value="'+data.item_code+'" />'+data.item_code+'</td><td><input type ="hidden" name="part_name[]" value="'+data.item+' '+data.spesifikasi+'" />'+data.item+' '+data.spesifikasi+'</td><td><input type ="hidden" name="part_qty[]" value="'+qty+'" />'+qty+'</td><td><button type="button" class="btnSelect btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></td></tr>';
                    
                        $('#tb_use tbody').append(newrow);  
                        data = null;
                        $("#laincheck").prop("checked",false);
                        $("#lain").prop("disabled",true);
                        $("#lain").val('');
                        $('#qty_parts').val(''); 
                        $('#exampleModalCenter').modal('hide');
                      
					}
				}
            }
        });

        $('#tb_use').on('click','.btnSelect', function(){
          var currentRow=$(this).closest("tr"); 
          currentRow.remove();
         
        });

    $('#btn_parts').click(function(){
        list_parts.ajax.reload();
          $('#exampleModalCenter').modal('show');
        });

   

    $("#form-complete").submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();

   
        $.ajax({
                url: APP_URL+'/maintenance/postcomplete',
                type: 'POST',
                dataType: 'json',
                data: data,
                })
                .done(function(resp) {
                    if (resp.success) {
                       
                        alert(resp.message);
                        window.location.href = APP_URL+'/maintenance/schedule';
                    }
                    else
                   alert(resp.message);
                })
                .fail(function() {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                   
                })
                .always(function() {
                  
                });

                
    });

    $("#laincheck").click(function(){
        if (this.checked) {
            $("#lain").prop("disabled",false);
        }else{
            $("#lain").prop("disabled",true);
        }
    });

  
});
</script>



@endsection