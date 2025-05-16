// Este archivo contiene el código JavaScript necesario para renderizar el mapa de Honduras y mostrar la cantidad de estudiantes según su residencia.

document.addEventListener("DOMContentLoaded", function () {
    // Datos de ejemplo, estos deberían ser reemplazados por los datos reales obtenidos del controlador
    const data = [
        { region: "Atlántida", estudiantes: 120 },
        { region: "Choluteca", estudiantes: 80 },
        { region: "Colón", estudiantes: 60 },
        { region: "Comayagua", estudiantes: 100 },
        { region: "Cortés", estudiantes: 200 },
        { region: "Francisco Morazán", estudiantes: 150 },
        { region: "Islas de la Bahía", estudiantes: 40 },
        { region: "La Paz", estudiantes: 70 },
        { region: "Lempira", estudiantes: 90 },
        { region: "Ocotepeque", estudiantes: 30 },
        { region: "Olancho", estudiantes: 110 },
        { region: "Santa Bárbara", estudiantes: 130 },
        { region: "Valle", estudiantes: 50 },
        { region: "Yoro", estudiantes: 140 },
    ];

    // Función para renderizar el mapa
    function renderMap() {
        const mapContainer = document.getElementById("mapa-honduras");
        const svgMap = d3.select(mapContainer)
            .append("svg")
            .attr("width", 800)
            .attr("height", 600);

        // Cargar el mapa de Honduras (debe estar en formato SVG)
        d3.xml("path/to/honduras-map.svg").then(function (data) {
            svgMap.node().append(data.documentElement);

            // Agregar los datos de estudiantes a cada región
            data.forEach(region => {
                const estudiantes = data.find(d => d.region === region.id).estudiantes || 0;

                d3.select(`#${region.id}`)
                    .attr("fill", getColor(estudiantes))
                    .append("title")
                    .text(`${region.id}: ${estudiantes} estudiantes`);
            });
        });
    }

    // Función para determinar el color según la cantidad de estudiantes
    function getColor(estudiantes) {
        if (estudiantes > 150) return "#4caf50"; // Verde
        if (estudiantes > 100) return "#ffeb3b"; // Amarillo
        if (estudiantes > 50) return "#ff9800"; // Naranja
        return "#f44336"; // Rojo
    }

    renderMap();
});