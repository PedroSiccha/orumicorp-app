<table class="table table-striped">
  <thead>
      <tr>
          <th>Fecha</th>
          <th>AGENTE</th>
          <th>ÁREA</th>
          <th>IN</th>
          <th>IN-BREAK</th>
          <th>OUT-BREAK</th>
          <th>OUT</th>
      </tr>
  </thead>
  <tbody>
      @foreach ($formattedData as $date => $agents)
          @foreach ($agents as $agentName => $records)
              <tr>
                  <td>{{ $date }}</td>
                  <td>{{ $agentName }}</td>
                  <td>{{ $records['area'] ?? '' }}</td> <!-- Mostrar el área del agente -->
                  
                  @foreach (['IN', 'IN-BREAK', 'OUT-BREAK', 'OUT'] as $type)
                      <td>
                          @if (isset($records[$type]))
                              @foreach ($records[$type] as $entry)
                                  {{ $entry['hour'] }} <br>
                                  @if (!empty($entry['observation']))
                                      <span style="font-size: small;">{{ $entry['observation'] }}</span>
                                  @endif
                                  <br>
                              @endforeach
                          @endif
                      </td>
                  @endforeach
              </tr>
          @endforeach
      @endforeach
  </tbody>
</table>