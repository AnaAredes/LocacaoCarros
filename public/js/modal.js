const properties = window.properties || [];
let selectedPropertyId = null;

function verDetalhes() {
    if (selectedPropertyId !== null) {
        window.location.href = '/detalhes/' + selectedPropertyId;
    }
}

function openModal(id) {
    selectedPropertyId = id;
    const property = properties.find(p => p.id === id);
    if (!property) return;

    document.getElementById('modalImagem').src = property.imageUrl ||
        'https://plus.unsplash.com/premium_photo-1686782502443-1d56f3beb9e3?w=600&auto=format&fit=crop&q=60';
    document.getElementById('modalTitulo').textContent = property.modelo;
    document.getElementById('modalPassageiros').textContent = `${property.numero_passageiros} passageiros`;
    document.getElementById('modalCombustivel').textContent = `${property.combustivel}`;
    document.getElementById('modalTransmissao').textContent = `${property.transmissao}`;
    document.getElementById('modalPreco').innerHTML =
        `${property.preco_diario.toLocaleString('pt-PT', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).replace('.', ',')} € <span class="text-sm font-normal text-gray-600">/por dia</span>`;

    document.getElementById('propertyModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('propertyModal').classList.add('hidden');
    document.body.style.overflow = '';
}

document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('propertyModal');
    if (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === this) closeModal();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });
    }
});