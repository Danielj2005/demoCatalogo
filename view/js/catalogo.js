
const PHONE = "04244189963";

const createCatalogo = (id, nombre, precio, urlImage, estado) =>
        `<div class="fs-4 rounded-4 card p-2 producto-card" data-bs-theme="drk">
            <div data-categories="" class="product_${id} overflow-hidden">
            
                <div class="position-relative overflow-hidden mb-3" style="height: 15rem;">
                    <img src="${urlImage}" class="w-100 h-100 rounded-bottom-0 rounded-4" alt="Imagen del producto">
                    <div class="badge_precio_container">
                        <div class="bg_badge_precio badge border border-white position-relative rounded-5">
                            <span class="precio_card">${estado == 1 ? "$ "+ precio : 'AGOTADO'}</span>
                        </div>
                    </div>
                </div>
                <div class="text-start">
                    <a onclick="detallesProductoById(${id})" class="fs-6 text-muted mb-4 fw-semibold" data-bs-toggle="modal" data-bs-target="#exampleModal">${ nombre.toLowerCase().replace(/\b\w/g, char => char.toUpperCase()) }</a>
                    
                </div>
                <div class="">
                    <div class="row justify-content-around align-items-cente">
                        <div class="col-6 mb-2 text-center">
                            <button onclick="detallesProductoById(${id})" type="button" class="btn_details rounded-5 btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="bi bi-eye"></i>
                                <span class="small">Ver Detalles</span>
                            </button> 
                        </div>
                        <div class="col-6 mb-2 text-center">
                            <button id="${id}" producto="${nombre}" onclick="askWhatsApp(${id}, ${precio}, ${estado == 1 ? "$ "+ precio : 'AGOTADO'})" 
                                type="submit" class="btn btn-success rounded-5">
                                    <i class="bi bi-whatsapp"></i>
                                    <span class="small d-non">WhatsApp</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;


async function getCatalogo(page = 1) {
    try {
        const withoutProducts = `<div class="card border border-secondary rounded-4">
                            <div class="p-4 text-center"> 
                                <i class="bi bi-exclamation-triangle-fill fs-1"></i>
                                <h3 class="text-center text-danger fw-semibold mb-1 truncate mb-4">En este momento no hay productos disponibles.</h3> 
                            </div> 
                        </div> `;

        const per_page = 8;

        // Consultamos al PHP que trae los datos de MySQL
        const response = await fetch(`./controller/catalogo.php?page=${page}&per_page=${per_page}`);
        if (!response.ok) throw new Error("Error en la petición");

        const data = await response.json();
        if (data.status === "success") {

            // data.productos ya viene como objeto si ajustaste el PHP
            let productos = typeof data.productos === 'string' ? JSON.parse(data.productos) : data.productos;

            products.push(productos);
            categorys = data.categorias;

            const filtroCategorias = document.getElementById('category-filters');
            // Evitar duplicar opciones si ya se cargaron
            if (!filtroCategorias.dataset.inited) {
                categorys.forEach(categoria => {
                    const li = document.createElement('li');
                    li.className = "btn dropdown-item transition-all hover:bg-purple-500/20";
                    li.id = `dropdown-item-${categorys.indexOf(categoria)+1}`;

                    const btn = document.createElement('button');
                    btn.className = "category-btn btn";
                    btn.textContent = categoria;
                    btn.addEventListener('click', () => filterByCategory(categoria, categorys.indexOf(categoria)+1, 1));

                    li.appendChild(btn);
                    filtroCategorias.appendChild(li);
                });
                filtroCategorias.dataset.inited = '1';
            }

            // render
            renderCatalogo(productos);

            // render pagination
            renderPagination(data.total, data.per_page, data.page);
            
        }else{
            
            document.getElementById('main').innerHTML = withoutProducts;
        }

    } catch (error) {
        console.error("Error al cargar los productos:", error);
    }
}


function renderPagination(total, per_page, page) {
    const totalPages = Math.max(1, Math.ceil(total / per_page));

    const existing = document.getElementById('catalog-pagination');
    if (existing) existing.remove();

    const container = document.createElement('div');
    container.id = 'catalog-pagination';
    container.className = 'w-100 d-flex justify-content-center align-items-center my-5 gap-2 flex-wrap';

    // creacion del botón de paginacion "anterior"
    const prev = document.createElement('button');
    prev.className = 'btn btn-secondary ps-2 bi bi-arrow-left';
    prev.id = 'btn-last';

    prev.textContent = '  Anterior';
    prev.disabled = page <= 1;
    prev.addEventListener('click', () => getCatalogo(page - 1));
    container.appendChild(prev);
    
    // crear botones de páginas (limitar rango)
    const maxButtons = 7;
    let start = Math.max(1, page - Math.floor(maxButtons / 2));
    let end = Math.min(totalPages, start + maxButtons - 1);
    if (end - start < maxButtons - 1) {
        start = Math.max(1, end - maxButtons + 1);
    }

    for (let p = start; p <= end; p++) {
        const btn = document.createElement('button');
        btn.className = p === page ? 'btn btn-primary' : 'btn btn-outline-primary';
        btn.textContent = p;
        btn.addEventListener('click', () => getCatalogo(p));
        container.appendChild(btn);
    }

    // creacion del botón de paginacion "siguiente"
    const next = document.createElement('button');
    next.className = 'btn btn-primary';
    next.id = 'btn-next';

    
    next.textContent = 'Siguiente';
    next.disabled = page >= totalPages;
    next.addEventListener('click', () => getCatalogo(page + 1));
    container.appendChild(next);
    

    // creacion de icono del botón de paginacion "siguiente"
    const icon_next = document.createElement('i');
    icon_next.className = 'ps-1 bi bi-arrow-right';

    document.getElementById('main').appendChild(container);

    document.querySelector('#btn-next').appendChild(icon_next);
}

const detallesProductoById = async (id) => {
    try {
        const modalBody = document.getElementById('modalBody');

        modalBody.innerHTML = ``;

        const resp = await fetch(`./controller/producto.php?UID=${id}&details=true`);
        const detallesProducto = await resp.text();
        
        modalBody.innerHTML = detallesProducto;

        inicializarCarrusel();
    } catch (error) {
        console.error("No se pudo obtener los detallse del producto:", error);
    }
};
