<strong>Yeni Bağlantı Ekle</strong>
<div class="row box box-default p0 m0 mb10">
    <form id="createNavItemForm" action="{{ route('panel.nav.createItem', ['menu'=>$menu]) }}" method="post">
        @csrf
    <div class="col-sm-1 p5"><input type="number" name="menu_order" placeholder="Sıra" class="form-control"></div>
    <div class="col-sm-3  p5">
        <input type="hidden" name="slug" class="slugify_name"/>
        <div class="ajaxSearchQuery">
            <div class="ajaxSearchQueryInput" data-url="{{ route('panel.ajax.nav.item.search') }}" data-form="#createNavItemForm">
                <input type="text" name="name" id="name" placeholder="Bağlantı Başlığı" class="slugify form-control" autocomplete="off"/>
            </div>
            <div class="ajaxSearchQueryResult"></div>
        </div>
    </div>

    <div class="col-sm-3 p5"><input type="text" name="url" placeholder="Bağlantı Adresi" class="form-control"></div>

    <div class="col-sm-2 p5">
        <select name="target" class="form-control">
            <option value="0">Aynı pencerede açılsın</option>
            <option value="1">Yeni pencerede açılsın</option>
        </select>
   </div>
    <div class="col-sm-2 p5"><input type="text" name="css" placeholder="css" class="form-control"></div>
    <div class="col-sm-1  p5"><button type="submit" class="btn btn-primary btn-block">Oluştur</button></div>
    </form>
</div>
