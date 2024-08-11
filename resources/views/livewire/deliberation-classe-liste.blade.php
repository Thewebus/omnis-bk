<div class="col-4 right-divider">
    <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table class="table table-bordered table-striped mb-0">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Classes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classes as $classe)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><a href="{{ route('admin.liste-classe-etudiants', $classe->id) }}">{{ $classe->nom }}</a></td>
                    <td>
                        <button class="btn btn-primary btn-block mt-3" type="button" wire:click="classeSelected({{ $classe }})"><i class="fa fa-eye"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>