document.addEventListener('DOMContentLoaded', function () {
    const precioRange = document.getElementById('precio_range');
    const precioMinDisplay = document.getElementById('precio_min_display');
    const precioMaxDisplay = document.getElementById('precio_max_display');
    const resultadosDiv = document.getElementById('resultados');

    precioRange.addEventListener('input', function () {
        precioMinDisplay.textContent = precioRange.value;
        precioMaxDisplay.textContent = precioRange.max;
    });

    precioRange.addEventListener('change', function () {
        const precioMin = 0;
        const precioMax = precioRange.value;

        // Enviar datos al servidor mediante AJAX
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                resultadosDiv.innerHTML = xhr.responseText;
            }
        };

        xhr.open('POST', 'filtrar.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send(`precio_min=${precioMin}&precio_max=${precioMax}`);
    });
});

document.getElementById('precio_range').addEventListener('input', function() {
    // Obtener los valores actuales del rango de precios
    var precioMin = document.getElementById('precio_range').value;
    var precioMax = document.getElementById('precio_max_display').textContent;

    // Realizar la solicitud AJAX a filtro.php
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'filtro.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Actualizar los resultados en el div #resultados
            document.getElementById('resultados').innerHTML = xhr.responseText;
        }
    };
    xhr.send('precio_min=' + precioMin + '&precio_max=' + precioMax);
});
