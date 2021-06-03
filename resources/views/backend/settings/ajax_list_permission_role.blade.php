<div class="form-group col-sm-12">
    <hr>
    <h3>Rol / Permisos</h3>
</div>
<div class="row">
    @if($hasRolesPermission)
        <input type="hidden" id="permission" name="permission" value="true">
        @foreach($hasRolesPermission As $item)

            <div class="col-sm-3">
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="hidden" id="id_permission{{$item['menu_id']}}" name="id_permission[]" value="{{$item['menu_id']}}">
                            <input type="checkbox" id="ckeckPermission{{$item['menu_id']}}" checked="checked" disabled="disabled"> {{$item['name']}}
                        </label>
                    </div>
                </div>
            </div>
        @endforeach
    @else

        <div class="form-group col-sm-12">
            <div class="alert alert-dismissable alert-info">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <p>El rol no tiene permisos asignados, debe cargarle permisos al rol seleccionado.</p>
            </div>
        </div>
    @endif
</div>
