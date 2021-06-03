    @foreach ($item['children'] as $item)
        @if ($item['children'] == [])

            @php
                if($idRol){
                    $AdditionalPermissions=false;
                    $AdditionalPermissions=\App\Models\Menu::getAdditionalPermissions($item['id'], $idRol);
                }
            @endphp

            <tr>
                <td>
                    {{$item['name']}}
                </td>
                <td class="text-center">

                    <div class="icheck-info d-inline">
                        <input type="checkbox" id="menu_id{{$item['id']}}" name="menu_id[]" class="submenu{{$item['id']}} submenu" value="{{$item['id']}}"
                                {{ (isset($arrPermission) and in_array($item['id'], $arrPermission)) ?'checked' : ''}}>
                        <label for="menu_id{{$item['id']}}"></label>
                    </div>

                </td>

                <td class="text-center">
                    <div class="icheck-success d-inline">
                        <input type="checkbox" id="new{{$item['id']}}" name="new[]" value="{{$item['id']}}" {{ (isset($AdditionalPermissions) and
                        $AdditionalPermissions->new==true) ?'checked' : ''}}>
                        <label for="new{{$item['id']}}" style="color: #29292996">
                            Nuevo
                        </label>
                    </div>
                </td>

                <td class="text-center">

                    <div class="icheck-success d-inline">
                        <input type="checkbox" id="edit{{$item['id']}}" name="edit[]" value="{{$item['id']}}" {{ (isset($AdditionalPermissions) and
                        $AdditionalPermissions->edit==true) ?'checked' : ''}}>
                        <label for="edit{{$item['id']}}" style="color: #29292996">
                            Editar
                        </label>
                    </div>

                </td>

                <td class="text-center">

                    <div class="icheck-success d-inline">
                        <input type="checkbox" id="delet{{$item['id']}}" name="delet[]" value="{{$item['id']}}" {{ (isset($AdditionalPermissions) and
                        $AdditionalPermissions->delet==true) ?'checked' : ''}}>
                        <label for="delet{{$item['id']}}" style="color: #29292996">
                            Eliminar
                        </label>
                    </div>

                </td>
            </tr>
        @else
            <tr style="font-weight:600">
                <td colspan="6">
                    {{$item['name']}}
                </td>
            </tr>
            @include('backend.settings.list_submenu_permission_rol', [ 'item' => $item, 'idRol'=> isset($idRol) ? $idRol : '' ])
        @endif
    @endforeach
    <script>
        $(function () {
            $(".submenu").click(function () {
                if ($(this).is(':checked')) {
                    $('#new' + $(this).val()).prop("checked", this.checked);
                    $('#edit' + $(this).val()).prop("checked", this.checked);
                    $('#delet' + $(this).val()).prop("checked", this.checked);
                } else {
                    $('#new' + $(this).val()).prop("checked", false);
                    $('#new' + $(this).val()).prop("checked", false);
                    $('#edit' + $(this).val()).prop('checked', false);
                    $('#delet' + $(this).val()).prop('checked', false);
                }
            });
        });
    </script>

