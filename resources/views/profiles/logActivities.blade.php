<div class="row mb-4">
    <div class="col-12">

        {{-- row title --}}
        <div class="row mb-4">
            <h2 class="mb-0 text-violet fs-4 fw-bold">
                <i class="fa-solid fa-list"></i>
                Lista Log Attività
            </h2>
        </div>

        {{-- btn other action --}}
        <div class="row mb-4">
            <div class="dropdown">
                <button class="btn btn-transparent dropdown-toggle shadow fw-semibold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis"></i>
                    Altro
                </button>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li>
                        {{-- select all record --}}
                        <p onclick="selectAllRecord()" id="select_all_record" class="dropdown-item mb-0 cursor-pointer">Seleziona tutto</p>
                    </li>
                    <li>
                        {{-- deselect all record --}}
                        <p onclick="deselectAllRecord()" id="deselect_all_record" class="dropdown-item mb-0 cursor-pointer d-none">Deseleziona tutto</p>
                    </li>
                    <li>
                        {{-- delete selected record --}}
                        <p onclick="deleteSelectedRecord('{{route('log-activities.deleteSelected')}}')" class="dropdown-item mb-0 cursor-pointer" type="button">Elimina selezionati</p>
                    </li>
                </ul>
            </div>
        </div>

        {{-- row table log activities --}}
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-dark table-striped shadow">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">@sortablelink('action', 'Nome Azione', [], ['class' => 'link-violet'])</th>
                            <th scope="col">@sortablelink('created_at', 'Data Azione', [], ['class' => 'link-violet'])</th>
                            <th scope="col">@sortablelink('method', 'Metodo', [], ['class' => 'link-violet'])</th>
                            <th scope="col">@sortablelink('ip', 'Ip', [], ['class' => 'link-violet'])</th>
                            <th scope="col">@sortablelink('url', 'Url', [], ['class' => 'link-violet'])</th>
                            <th scope="col">@sortablelink('agent', 'Agent', [], ['class' => 'link-violet'])</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userLogActivities as $log)    
                            <tr>
                                <th class="d-flex align-items-center gap-2">
                                    {{-- check select --}}
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="log_id" name="log_id" value="{{$log->id}}" >
                                    </div>

                                    {{-- btn delete --}}
                                    <div class="btn-delete">
                                        <form action="{{route('log-activities.destroy', $log->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-violet shadow">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </th>
                                <th class="fw-normal">{{$log->action}}</th>
                                <th class="fw-normal">{{$log->created_at->format('d-m-Y H:i:s')}}</th>
                                <th class="fw-normal">{{$log->method}}</th>
                                <th class="fw-normal">{{$log->ip}}</th>
                                <th class="fw-normal">
                                    <a class="link-light-gray" href="{{$log->url}}">{{$log->url}}</a>
                                </th>
                                <th class="fw-normal">{{$log->agent}}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- row link page --}}
        <div class="row">
            <div class="links-paginate col-12 d-flex justify-content-center mt-4">
                {!! $userLogActivities->appends(\Request::except('page'))->render() !!}
            </div>
        </div>

    </div>
</div>