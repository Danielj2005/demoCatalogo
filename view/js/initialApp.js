
function verImagen(url, producto) {
    let i = 0;

    const data = url.split(",");

    alert.fire({
        title: `${producto}`,
        html: getCarrusel(data, i),
        confirmButtonText: 'Cerrar'
    });
    inicializarCarrusel();
}



function initCustomSelect() {
    const select = document.getElementById('categoryMultiSelect');
    const container = document.getElementById('tag-container');
    
    // 1. Generar etiquetas basadas en las opciones del select
    Array.from(select.options).forEach(option => {
        const tag = document.createElement('span');
        tag.textContent = option.text;
        tag.dataset.value = option.value;
        
        // Estilo base de la etiqueta (DanikatStyle)
        tag.className = 'btn rounded-5 small btn-outline-primary text-muted';
        
        // Evento al hacer clic
        tag.onclick = () => {
            option.selected = !option.selected; // Alternar selección en el select oculto
            
            // Alternar estilos visuales
            if (option.selected) {
                tag.classList.remove('btn-outline-primary', 'text-muted');
                tag.classList.add('btn-primary');
            } else {
                tag.classList.add('btn-outline-primary', 'text-muted');
                tag.classList.remove('btn-primary');
            }
        };
        
        container.appendChild(tag);
    });
}



/**
 * Copia cualquier texto al portapapeles en Desktop y Mobile.
 * @param {string} text - El texto que se desea copiar.
 * @returns {Promise<boolean>} - Devuelve true si se copió con éxito.
 */
async function copyToClipboard(text) {
    // Método 1: API Moderna (Navigator Clipboard)
    if (navigator.clipboard && window.isSecureContext) {
        try {
            await navigator.clipboard.writeText(text);
            Toastify({
                text: "Precio Copiado correctamente",
                duration: 3000,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "#198754",
                }
            }).showToast();
            return true;
        } catch (err) {
            console.warn("Fallo con navigator.clipboard, usando fallback...", err);
            
            Toastify({
                text: "Error al Copiar el texto",
                duration: 300000,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "#dc3545",
                }
            }).showToast();
        }
    }
}



// Ejecutar al cargar la página o el modal
document.addEventListener('DOMContentLoaded', () => {
    initCustomSelect();
    getProductos();
});
