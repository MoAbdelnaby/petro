<div class="modal fade create-role" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="rolesForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{__('app.roles.create_new')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="create-error">

                    </div>
                    <div class="form-group">
                        <label>{{__('app.roles.table.name')}} *</label>
                        <input required type="text" name="name" class="form-control name" aria-describedby="emailHelp" placeholder="{{__('app.roles.table.name')}}">
                        <div class="invalid-feedback name-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label>{{__('app.roles.table.display_name')}} *</label>
                        <input required type="text" name="display_name" class="form-control display_name" aria-describedby="emailHelp" placeholder="{{__('app.roles.table.display_name')}}">
                        <div class="invalid-feedback display_name-feedback"></div>
                    </div>
                    <hr>
                    @php
                        $groups = [];
                        $groups2 = [];
                    @endphp
                    <div class="kt-portlet__body">
                        <ul class="nav nav-pills nav-tabs-btn" role="tablist">

                            @foreach($permissions as $key=>$permission)
                                @if (!in_array($permission->group,$groups))
                                    <div class="{{array_push($groups,$permission->group)}}"></div>
                                    <li class="nav-item">
                                        <a class="nav-link {{$key==0 ? 'active':''}}" data-toggle="tab" href="#kt_tabs_{{$permission->group}}" role="tab" aria-selected="true">

                                            <span class="nav-link-title">{{$permission->group}}</span>

                                        </a>
                                    </li>
                                @endif

                            @endforeach
                        </ul>

                        <div class="tab-content">

                            @foreach($permissions as $key=>$permission)
                                @if (!in_array($permission->group,$groups2))
                                    <div class="{{array_push($groups2,$permission->group)}}"></div>
                                    <div class="tab-pane fade {{$key==0 ?'active show':''}}" id="kt_tabs_{{$permission->group}}" role="tabpanel">
                                            <div class="form-group row">
                                                @foreach($permissions as $key2=>$permission2)
                                                    @if($permission->group ==$permission2->group)
                                                        <span class="col-1"></span>
                                                        <div class="col-5  custom-control  custom-checkbox">

                                                            <input type="checkbox" id="{{$permission2->name}}" class="{{$permission2->display_name}} permissions custom-control-input" name="permissions[]" value="{{$permission2->name}}">
                                                            <label class="custom-control-label" for="{{$permission2->name}}">{{$permission2->display_name}}</label>

                                                        </div>

                                                    @endif
                                                @endforeach
                                            </div>
                                    </div>
                                @endif

                            @endforeach

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-brand close-form" data-dismiss="modal">{{__('app.roles.close')}}</button>
                    <button type="submit" class="btn btn-primary" id="store_roles">{{__('app.roles.save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
