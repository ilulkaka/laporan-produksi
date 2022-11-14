@extends('layout.main')
@section('content')

@if(Session::has('alert-success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{Session::get('alert-success')}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
<form action="{{url('/post_perbaikan')}}" method="POST">
  <div class="text secondary" style="padding-top:0px;padding-bottom:15px">
    <h3><b>Form Perbaikan</b></h3>
  </div>
  @csrf
  <div class="form-row">
    <div class="form-group col-md-3">
      <label for="tanggalrusak">Tanggal</label>
      <input type="datetime-local" class="form-control" name="tanggal_rusak" id="tanggal_rusak">
    </div>
    <div class="form-group col-md-3">
      <label for="from">Dari</label>
      <select class="form-control departemen" id="departemen" name="dept_code" placeholder="Dari Departemen">
        <option value="">Pilih Departemen</option>
        @foreach($departemen as $k)
        <option value="{{$k->KODE_DEPARTEMEN}}">{{$k->DEPT_SECTION}}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group col-md-3">
      <label for="nopermintaan">No Permintaan</label>
      <input type="hidden" id="nama_departemen" name="departemen">
      <input type="text" class="form-control @error('nopermintaan') is-invalid @enderror" name="nopermintaan"
        id="nopermintaan" placeholder="No Permintaan" value="{{ old('nopermintaan') }}">
    </div>
    <div class="form-group col-md-3">
      <label for="shift">Shift</label>
      <select name="shift" id="shift" class="form-control" required>
        <option value="">Pilih Shift...</option>
        <option value="NonShift">Non Shift</option>
        <option value="shift1">Shift 1</option>
        <option value="shift2">Shift 2</option>
        <option value="shift3">Shift 3</option>
      </select>
    </div>

  </div>

  <div class="form-row">
    <div class="form-group col-md-3">
      <label>No Induk Mesin</label>
      <select name="no_induk_mesin" id="no_induk_mesin"
        class="form-control select2 @error('no_induk_mesin') is-invalid @enderror" style="width: 100%;" required>
        <option>-------Pilih Nomer Mesin--------</option>
        @foreach($mesin as $y)

        <option value="{{$y->nama_mesin}}">{{$y->no_induk}}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group col-md-6">
      <label for="mesin">Mesin</label>
      <input type="hidden" name="no_induk" id="no_induk">
      <input type="text" class="form-control @error('mesin') is-invalid @enderror" name="mesin" id="mesin"
        placeholder="Nama Mesin/Alat" required>
    </div>

  </div>
  <div class="form-row">

    <div class="form-group col-md-3">
      <label for="inputmasalah">Masalah</label>
      <input type="text" class="form-control @error('masalah') is-invalid @enderror" name="masalah" id="masalah"
        placeholder="Bagian yang bermasalah" required>
    </div>
    <div class="form-group col-md-4">
      <label for="inputkondisi">Kondisi</label>
      <input type="text" class="form-control @error('kondisi') is-invalid @enderror" name="kondisi" id="kondisi"
        placeholder="Kondisi Mesin yang bermasalah">
    </div>
    <div class="form-group col-md-5">
      <label for="penyebab">Penyebab</label>
      <input type="text" class="form-control @error('penyebab') is-invalid @enderror" name="penyebab" id="penyebab"
        placeholder="Penyebab Kerusakan" required>
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputtindakan">Tindakan</label>
      <textarea name="tindakan" id="tindakan" class="form-control" cols="30" rows="5" placeholder="Tindakan Perbaikan"
        required></textarea>

    </div>
    <div class="form-group col-md-6">
      <label for="inputpart">Part</label>

      <button type="button" class="btn-xs btn-success" id="btn_parts"><i class="fa fa-plus"></i></button>
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
  </div>
  <div class="form-row">
    <div class="form-group col-md-3">
      <label for="tanggalmulai">Tanggal Mulai</label>
      <input type="datetime-local" class="form-control" name="tanggal_mulai" id="tanggal_mulai"
        placeholder="Tanggal Mulai Perbaikan" required>
    </div>
    <div class="form-group col-md-3">
      <label for="tanggalselesai">Tanggal Selesai</label>
      <input type="datetime-local" class="form-control" name="tanggal_selesai" id="tanggal_selesai"
        placeholder="Tanggal Selesai Perbaikan" required>
    </div>
    <div class="form-group col-md-2">
      <label for="inputoperator">Operator</label>

      <select name="operator" id="operator" class="form-control @error('operator') is-invalid @enderror">
        <option>-------Pilih Operator--------</option>
        @foreach($operator as $o)
        <option value="{{$o->NIK}}">{{$o->NAMA}}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group col-md-1">
      <label for="klasifikasi">Klasifikasi</label>
      <select name="klasifikasi" id="klasifikasi" class="form-control @error('klasifikasi') is-invalid @enderror"
        required>
        <option value="">Pilih Kode...</option>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
      </select>
    </div>
    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="totaljamperbaikan">Total Jam Perbaikan</label>
        <input type="time" class="form-control" name="total_jam_perbaikan" id="total_jam_perbaikan"
          placeholder="Total Jam Perbaikan" disabled="disabled">
      </div>
      <div class="form-group col-md-3">
        <label for="totaljamkerusakan">Total Jam Kerusakan</label>
        <input type="time" class="form-control" name="total_jam_kerusakan" id="total_jam_kerusakan"
          placeholder="Total Jam Kerusakan" disabled="disabled">
      </div>
      <div class="form-group col-md-3">
        <label for="totaljammenunggu">Total Jam Menunggu</label>
        <input type="time" class="form-control" name="total_jam_menunggu" id="total_jam_menunggu"
          placeholder="Total Jam Menunggu" disabled="disabled">
      </div>
    </div>
  </div>

  <input type="submit" value="Update" class="btn btn-primary">
  <td><a href="{{url('/maintenance/perbaikan')}}" class="btn btn-secondary">Cancel</a></td>
</form>

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
      <div class="modal-body">
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
          <input type="text" name="lain" id="lain" class="form-control" placeholder="Parts lain" disabled>

        </div>
        <div class="form-group col-md-3">
          <label for="qty_parts">Qty:</label>
          <input type="text" class="form-control" name="qty_parts" id="qty_parts" placeholder="Qty">
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




<!-- jQuery -->

<script src="{{asset('/assets/plugins/select2/js/select2.min.js')}}"></script>

<!-- Tempusdominus Bootstrap 4 -->

<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>

<script>
  $(function () {
    //Initialize Select2 Elements
   // $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    })

    $('#operator').select2({
      theme: 'bootstrap4'
    })

   

});
</script>
<script type="text/javascript">
  $(document).ready(function() {
    var key = localStorage.getItem('npr_token');
    var list_parts =  $('#tb_spareparts').DataTable({
                            processing: true,
                            serverSide: true,
                            searching: true,
                            ordering: false,
                            ajax: {
                                            url: APP_URL+'/api/spareparts',
                                            type: "POST",
                                            headers: { "token_req": key }
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
        $('#btn_parts').click(function(){
          $('#exampleModalCenter').modal('show');
        });

        $('#tb_use').on('click','.btnSelect', function(){
          var currentRow=$(this).closest("tr"); 
          currentRow.remove();
         
        });

        $('#test').click(function(){
          var arrdata=[];
          $('#tb_use tr').each(function(){
            var currentRow=$(this);

            var col1_value=currentRow.find("td:eq(0)").text();
            var col2_value=currentRow.find("td:eq(1)").text();
            var col3_value=currentRow.find("td:eq(2)").text();
            
            var obj={};
            obj.item_code=col1_value;
            obj.item=col2_value;
            obj.qty=col3_value;
           
            arrdata.push(obj);
              });

              arrdata.splice(0,1);
              console.log(arrdata);
        });
        $("#laincheck").click(function(){
        if (this.checked) {
            $("#lain").prop("disabled",false);
        }else{
            $("#lain").prop("disabled",true);
        }
    });

function check_item(itemCode, qty_in, data) {
  var row = 0;
  $('#tb_use tr').each(function(){
            var currentRow=$(this);
            var col1_value=currentRow.find("td:eq(0)").text();
            var col2_value=currentRow.find("td:eq(1)").text();
            var col3_value=currentRow.find("td:eq(2)").text();
            var qty = Number(col3_value);

          if (row == 0){
            $('#tb_use tr:last').after('<tr><td>'+data.item_code+'</td><td>'+data.item+' '+data.spesifikasi+'</td><td>'+qty_in+'</td><td><button type="button" class="btnSelect btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></td></tr>');
          }else{
            if (itemCode == col1_value) {
            currentRow.find("td:eq(2)").html(qty_in+qty);
          }else{
            $('#tb_use tr:last').after('<tr><td>'+data.item_code+'</td><td>'+data.item+' '+data.spesifikasi+'</td><td>'+qty_in+'</td><td><button type="button" class="btnSelect btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></td></tr>');
          }
          }
         
          
           row = row+1;
          });  
}
});
</script>

<script src="{{asset('/assets/script/perbaikan.js')}}"></script>

@endsection