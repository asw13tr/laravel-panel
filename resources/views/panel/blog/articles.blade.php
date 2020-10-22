@extends('panel/master')
@section('content')
<div class="row">
     <?php echo getAlert("fixed"); ?>
     <div class="col-md-12">
          <h3 class="m5 pull-left">Yazı Listesi</h3>
          <a href="{{ route('panel.blog.article.create') }}" class="btn btn-primary pull-right">Yeni Yazı</a>
          <div class="clearfix"></div>
          <?php echo listTableNavigation( route('panel.blog.articles'), url(Request::getRequestUri()) ); ?>
     </div>
     <div class="clearfix"></div>
     <div class="col-md-12">



     <div class="box box-default">

          <div class="box-body no-padding table-responsive">
               <table id="aswdatatable" class="table table-bordered table-hover table-striped">
                    <thead>
                         <tr>
                              <th width="25">#</th>
                              <th width="40"></th>
                              <th>Başlık</th>
                              <th>Kategoriler</th>
                              <th width="160">Yayımlanma</th>
                              <th style="min-width:50px; width:60px;"></th>
                              <th style="min-width:100px; width:100px;"></th>
                         </tr>
                    </thead>
                    <tbody>

                         @if($items)
                         @foreach($items as $item)
                         <tr>
                              <td align="center">{{ $item->id }}</td>
                              <td data-search="{{ $item->description }}">
                                  <?php $smallCover = empty($item->cover)? url('images/noimg.png') : getImgSrc($item->cover, 's');
                                        $largeCover = empty($item->cover)? url('images/noimg.png') : getImgSrc($item->cover); ?>
                                  <a data-fancybox="gallery" href="{{ $largeCover }}" class="tableCoverImg"><img src="{{ $smallCover }}" class="img-responsive"></a>
                              </td>
                              <td data-search="{{ $item->title }}" class="title">
                                  <a href="{{ route('panel.blog.article.edit', ['article'=>$item]) }}">{{ $item->title }}</a><br>
                                  <cite>{{ $item->summary }}</cite>
                              </td>
                              <td style="max-width:100px;"><?php echo $item->getCategoriesUrlAdmin(); ?></td>
                              <td>
                                  <div class="m0 p0"><span class="fa fa-calendar-plus-o"></span> <?php echo timestampToString($item->created_at); ?></div>
                                  <div class="m0 p0"><span class="fa fa-calendar-minus-o"></span> <?php echo timestampToString($item->updated_at); ?></div>
                                  <div class="m0 p0 text-green"><span class="fa  fa-calendar-check-o"></span> <?php echo timestampToString($item->p_time); ?></div>
                              </td>
                              <td class="row p0">
                                  <div class="col-xs-6 p0">
                                      <?php $hcClass = $item->hide_cover=="on"? 'danger' : 'success'; ?>
                                      <a href="{{ route('panel.blog.article.change_cover_visibilty', ['article'=>$item]) }}" class="ajaxChangeStatus btn btn-{{ $hcClass }} btn-xs"><span class="fa fa-photo"></span></a>
                                  </div>
                                  <div class="col-xs-6 p0">
                                      <?php $acClass = $item->allow_comments=="on"? 'success' : 'danger'; ?>
                                      <a href="{{ route('panel.blog.article.change_comments_permissions', ['article'=>$item]) }}" class="ajaxChangeStatus btn btn-{{ $acClass }} btn-xs"><span class="fa fa-comments"></span></a>
                                  </div>
                              </td>
                              <td class="row p0">
                                   <div class="col-xs-4 p0"><a href="{{ route('panel.blog.article.edit', ['article'=>$item]) }}" class="btn btn-primary btn-xs"><span class="fa fa-edit"></span></a></div>
                                   <div class="col-xs-4 p0">

                                        <a href="{{ route('panel.blog.article.change_status', ['article'=>$item]) }}" class="ajaxChangeStatus btn btn-{{ getBool($item->status, "published", "success", "danger") }} btn-xs"><span class="fa fa-eye"></span></a>

                                   </div>
                                   <div class="col-xs-4 p0">
                                        @if( $item->status != "trash" )
                                        <a href="{{ route('panel.blog.article.destroy', ['article'=>$item]) }}" class="btn btn-warning btn-xs"><span class="fa fa-trash-o"></span></a>
                                        @else
                                        <a href="{{ route('panel.blog.article.destroy', ['article'=>$item]) }}" class="btn btn-danger btn-xs"><span class="fa fa-times"></span></a>
                                        @endif
                                   </div>
                              </td>
                         </tr>
                         @endforeach
                         @endif

                    </tbody>
               </table>
          </div>
     </div>
     </div>






</div>

@endsection

@section('end')
@include('panel/inc/add-datatable')
@endsection
