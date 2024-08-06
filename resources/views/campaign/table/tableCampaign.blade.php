<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($campaigns as $campaign)
            <tr>
                <td>{{ $campaign->id }}</td>
                <td>{{ $campaign->name }}</td>
                <td>{{ $campaign->description }}</td>
                <td>{{ $campaign->start_date }}</td>
                <td>{{ $campaign->end_date }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-warning " type="button" onclick="editarCampaign({idCampaign: '{{ $campaign->id }}', name: '{{ $campaign->name }}', description: '{{ $campaign->description }}', startDate: '{{ $campaign->start_date }}', endDate: '{{ $campaign->end_date }}', modal: '#modalEditarCampaign', inputId: '#idEditarCampaign', inputName: '#nameCampaignEdit', inputDescription: '#descriptionCampaignEdit', inputStartDate: '#initDateCampaignEdit', inputEndCampaign: '#endDateCampaignEdit'})"><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger " type="button" onclick="deleteCampaign({idCampaign: '{{ $campaign->id }}', name: '{{ $campaign->name }}', tableName: '#tabCampaing'})"><i class="fa fa-trash"></i></button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
