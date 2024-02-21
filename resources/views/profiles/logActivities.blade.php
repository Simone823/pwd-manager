<div class="row mb-4">
    <div class="col-12">

        {{-- row title --}}
        <div class="row mb-4">
            <h2 class="mb-0 text-orange fs-4 fw-bold">
                <i class="fa-solid fa-list"></i>
                Lista Log Attività
            </h2>
        </div>

        {{-- row table log activities --}}
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-dark table-striped shadow">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">@sortablelink('action', 'Nome Azione', [], ['class' => 'link-orange'])</th>
                            <th scope="col">@sortablelink('created_at', 'Data Azione', [], ['class' => 'link-orange'])</th>
                            <th scope="col">@sortablelink('method', 'Metodo', [], ['class' => 'link-orange'])</th>
                            <th scope="col">@sortablelink('ip', 'Ip', [], ['class' => 'link-orange'])</th>
                            <th scope="col">@sortablelink('url', 'Url', [], ['class' => 'link-orange'])</th>
                            <th scope="col">@sortablelink('agent', 'Agent', [], ['class' => 'link-orange'])</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($userLogActivities) > 0)
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

                                                <button type="submit" class="btn btn-orange shadow">
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
                        
                            @else
                                <tr>
                                    <td colspan="50">
                                        <div class="wrapper-no-records">
                                            <strong>Info!</strong>
                                            Nessun record in tabella
                                        </div>
                                    </td>
                                </tr>
                        @endif
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