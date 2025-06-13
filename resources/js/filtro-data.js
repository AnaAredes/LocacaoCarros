document.addEventListener('DOMContentLoaded', () => {
    const dataInicio = document.getElementById('data_inicio');
    const dataFim = document.getElementById('data_fim');

    if (dataInicio && dataFim) {
        dataInicio.addEventListener('change', () => {
            const dataSelecionada = new Date(dataInicio.value);
            dataSelecionada.setDate(dataSelecionada.getDate() + 1);
            dataFim.min = dataSelecionada.toISOString().split("T")[0];

            if (dataFim.value < dataFim.min) {
                dataFim.value = dataFim.min;
            }
        });
    }
});