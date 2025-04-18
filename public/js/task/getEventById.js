function getEventById(id, modal) {
    $.post(getEventByIdRoute, { id: id, _token: token }).done(function(data) {
        console.log('DATA RESPONSE', data);
        console.log('DATA CLIENT', data.customer);
        console.log('DATA AGENT', data.agent);

        mostrarModalEditarEvento({
            id: data.id,
            date: data.date,
            name: data.name,
            description: data.description,
            timeStart: new Date(data.start).toTimeString().slice(0,5),
            timeEnd: new Date(data.end).toTimeString().slice(0,5),
            priority_id: data.priority_id,
            agent_code: data.agent.code,
            agent_name: `${data.agent.name} ${data.agent.lastname}`,
            customer_code: data.customer.code,
            customer_name: `${data.customer.name} ${data.customer.lastname}`
        });

        $('#modalRegistrarEvento').modal('show');
    });
}

