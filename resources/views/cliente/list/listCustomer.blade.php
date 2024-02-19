{{-- <div class="ibox-content"> --}}
      <table class="table table-striped">
          <thead>
          <tr>
              <th>Fecha de Ingreso</th>
              <th>ID de Cliente</th>
              <th>Nombre del Cliente</th>
              <th>Acción</th>
          </tr>
          </thead>
          <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{  date("d/m/Y", strtotime($customer->date_admission)) }}</td>
                    <td>{{ $customer->code }}</td>
                    <td>{{ $customer->name }} {{ $customer->lastname }}</td>
                    <td>
                        <button class="btn btn-info " type="button"><i class="fa fa-check"></i></button>
                        <button class="btn btn-warning " type="button"><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger " type="button"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            @endforeach
          </tbody>
      </table>
  {{-- </div> --}}
