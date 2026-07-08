
const renderCatalogo = (productos) => {
    document.getElementById('producto-cards').innerHTML = productos.map((p) => createCatalogo(p.id, p.nombre, p.precio, p.images, p.estado)).join('');       
}