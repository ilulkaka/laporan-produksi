@extends('layout.main')
@section('content')

<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><b>List Schedule</b></h3>

                </div>
              <div class="row">
                  <div>
                  <a href="{{url('/maintenance/schedule')}}" class="btn btn-success">Input Schedule</a>
                  </div>
              
              </div>
              </div>

              <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Description</th>
                      <th>Lokasi</th>
                      <th>Mesin</th>
                      <th>No Induk Mesin</th>
                      <th>No Urur Mesin</th>
                      <th>Rencana Mulai</th>
                      <th>Operator</th>
                      <th>Item Code</th>
                      <th>Status</th>
                      <th>Hasil</th>
                    </tr>
                </thead>
                  <tbody>
                  @foreach ($tb_schedule ?? '' as $schedule)
                    <tr>
                      <td>{{$schedule -> schedule_id}}</td>
                      <td>{{$schedule -> description}}</td>
                      <td>{{$schedule -> lokasi}}</td>
                      <td>{{$schedule -> mesin}}</td>
                      <td>{{$schedule -> no_induk_mesin}}</td>
                      <td>{{$schedule -> no_urut_mesin}}</td>
                      <td>{{$schedule -> start_date}}</td>
                      <td>{{$schedule -> operator}}</td>
                      <td>{{$schedule -> item_code}}</td>
                      <td>{{$schedule -> status}}</td>
                      <td>{{$schedule -> hasil}}</td>
                      <a href="/user-edit/edit/{{ $schedule->id}} " class="btn btn-success"> <i class="fa fa-edit"></i></a>
                      <a href="/{{ $user->id}}" class="btn btn-danger" onclick="return confirm('Apakah anda akan menghapus item ini?')"
                        ><i class="fa fa-trash"></i></a></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
             
            </div>
          
          </div>
        </div>

@endsection