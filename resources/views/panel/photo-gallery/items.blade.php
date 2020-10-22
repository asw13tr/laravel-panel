@extends('panel/master')
@section('headAfter')

@endsection
@section('content')
<div class="row">
     <?php echo getAlert("fixed"); ?>
     <div class="col-md-12">
          <h3 class="m5 pull-left">{{ $gallery->name }} <small>(Galeri Düzenle)</small></h3>
     </div>
     <div class="clearfix"></div>


     <div class="col-md-12">
     <?php // @include('panel/nav/item-form') ?>







     <div class="box box-default">
         @isset($items)
          <div class="box-body no-padding table-responsive">
               <table id="aswnavtable" class="table table-bordered table-hover table-striped">
                    <thead>
                         <tr>
                              <th width="60">Sıra</th>
                              <th>Hedef (Url)</th>
                              <th>Url</th>
                              <th>Hedef</th>
                              <th>Css</th>
                              <th width="70"></th>
                         </tr>
                    </thead>
                    <tbody>


                         @foreach($items as $item)
                         <tr id="item{{ $item->id }}">
                         <form class="ajaxNavItemForm" data-id="{{ $item->id }}" id="itemForm{{ $item->id }}" action="{{ route('panel.ajax.nav.item.update', ['nav'=>$item]) }}" method="post">
                            <td><input type="text" name="menu_order" value="{{ $item->menu_order }}" class="form-control input-sm"></td>
                            <td><input type="text" name="name" value="{{ $item->name }}" class="form-control input-sm"></td>
                            <td><input type="text" name="url" value="{{ $item->url }}" class="form-control input-sm"></td>
                            <td><input type="text" name="alt" value="{{ $item->alt }}" class="form-control input-sm"></td>

                            <td class="row p0">
                                <div class="col-xs-6 p1">
                                    <button type="submit" name="action" value="update" class="actionButton btn btn-block btn-success btn-xs saveItem"><span class="fa fa-check"></span></button>
                                </div>
                                <div class="col-xs-6 p1">
                                    <button type="submit" name="action" value="delete" class="actionButton btn btn-block btn-danger btn-xs deleteItem"><span class="fa fa-times"></span></button>
                                </div>
                            </td>
                         </form>
                         </tr>
                         @endforeach




                    </tbody>
               </table>
          </div>
          <div class="box-footer">
              <button type="button" class="btn btn-primary pull-right" id="allItemsUpdate"><span class="fa fa-save"></span> Hepsini Güncelle</button>
          </div>
          @endisset
     </div>
     </div>







</div>

@endsection

@section('end')
<script type="text/javascript" src="{{ url('panel/dist/js/navigations.js') }}"></script>

@endsection
