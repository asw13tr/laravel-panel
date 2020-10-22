@extends('panel/master')
@section('headAfter')

@endsection
@section('content')
<div class="row">
     <?php echo getAlert("fixed"); ?>
     <div class="col-md-12">
          <h3 class="m5 pull-left">Menüler</h3>
     </div>
     <div class="clearfix"></div>
    <div class="col-md-12 pb10">
        <div class="col-sm-12 pl0">Yeni Menü Oluştur</div>
        <form action="{{ route('panel.nav.createMenu') }}" method="post">
            <div class="col-xs-9 col-md-6 p0">
                @csrf
                <input type="text" class="form-control slugify" name="navName" id="navName" placeholder="Menü adını yazın">
                <input type="hidden" class="slugify_navName" name="navSlug"/>
            </div>
            <div class="col-xs-3 col-md-2"><button type="submit" class="btn btn-primary">Oluştur</button></div>
        </form>
    </div>
    <div class="clearfix"></div>
     <div class="col-md-12">





     <div class="box box-default">

          <div class="box-body no-padding table-responsive">
               <table id="aswdatatable" class="table table-bordered table-hover table-striped">
                    <thead>
                         <tr>
                              <th width="25">#</th>
                              <th>Menü</th>
                              <th>Kod</th>
                              <th width="60"></th>
                         </tr>
                    </thead>
                    <tbody>

                         @isset($items)
                         @foreach($items as $item)
                         <?php
                         $kod = "get_nav('".$item->slug."')";
                         ?>
                         <tr>
                              <td align="center">{{ $item->id }}</td>
                              <td data-seach="{{ $item->name }}">{{ $item->name }}</td>
                              <td><code><?php echo $kod; ?></code></td>


                              <td class="row p0">
                                   <div class="col-xs-6 p0"><a href="{{ route('panel.nav.items', ['menu'=>$item]) }}" class="btn btn-primary btn-xs"><span class="fa fa-edit"></span></a></div>
                                   <div class="col-xs-6 p0">
                                       <form action="{{ route('panel.nav.deleteMenu', ['menu'=>$item]) }}" method="post" class="deleteMenu">
                                           @csrf
                                           <input type="hidden" name="id" value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-danger btn-xs"><span class="fa fa-times"></span></button>
                                        </form>
                                   </div>
                              </td>

                         </tr>
                         @endforeach
                         @endisset

                    </tbody>
               </table>
          </div>
     </div>
     </div>






</div>

@endsection

@section('end')
@include('panel/inc/add-datatable')
<script type="text/javascript">
    $('form.deleteMenu').on('submit', function(){
        if(!confirm("Bu menüyü silmek istediğinize emin misiniz? Menü içerisindeki tüm linkler silinecektir.")){
            return false;
        }
    });
</script>
@endsection
