@extends('layout.master')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Reportes</title>
  <style>
    table { width: 100%; border-collapse: collapse; };
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; };
    th { background-color: #f4f4f4; };
    img { max-width: 50px; height: auto; };
  </style>
</head>
<body>
<div class="w-[100vw] h-[100vh] bg-[url(/img/imglogin.jpg)] bg-no-repeat bg-cover pt-5 relative" >
    <div class= "bg-black/20 backdrop-blur-sm w-[100vw]  absolute inset-0 z-0"></div>

    <div class="w-[80%] md:w-[90%] h-[60%] bg-orange-600 m-auto mt-5 p-8 pt-3 rounded-xl relative shadow-xl">

      <div class=" w-[15%] h-[10%] md:h-[5%]  mb-5 md:mb-5 lg:mb-7 lg:mt-1 xl:mb-10 xl:w-[14%] 2xl:mb-12">
          <svg class="w-[30%] fill-zinc-800 hover:bg-zinc-800 hover:fill-orange-600 transition-all duration-500 ease-in-out rounded-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g id="arrow-left"><path d="M11,18.75a.74.74,0,0,1-.53-.22l-6-6a.75.75,0,0,1,0-1.06l6-6a.75.75,0,0,1,1.06,1.06L6.06,12l5.47,5.47a.75.75,0,0,1,0,1.06A.74.74,0,0,1,11,18.75Z"/><path d="M19,12.75H5a.75.75,0,0,1,0-1.5H19a.75.75,0,0,1,0,1.5Z"/></g></svg>
      </div>

      <div class="mb-2 relative bg-zinc-700 rounded-md w-[100%] p-5">
        <h1 class="text-2xl md:text-base xl:text-3xl lg:text-lg  ml-4 md:ml-1 md:mr-2 mr-4 lg:mr-2 font-semibold inline-block text-zinc-800 bg-orange-600 p-1 px-4 rounded-full">Lista de Reportes</h1>
        <input class="rounded-full pl-5 pr-12 py-2 bg-zinc-800 text-orange-600 inline w-[25%]" type="text" id="search" placeholder="Buscar...">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-[13%]  inline-block absolute  right-[47.3%] md:right-[39.1%] xl:right-[40.3%] lg:right-[43.5%] 2xl:right-[43%] top-[37%] md:top-[36%] xl:top-[38%] fill-orange-500"> viewBox="0 0 24 24"><g id="search"><path d="M10.77,18.3a7.53,7.53,0,1,1,7.53-7.53A7.53,7.53,0,0,1,10.77,18.3Zm0-13.55a6,6,0,1,0,6,6A6,6,0,0,0,10.77,4.75Z"/><path d="M20,20.75a.74.74,0,0,1-.53-.22L15.34,16.4a.75.75,0,0,1,1.06-1.06l4.13,4.13a.75.75,0,0,1,0,1.06A.74.74,0,0,1,20,20.75Z"/></g></svg>
        <div class="dropdown w-[30%]">

          <button class="dropdown-button bg-zinc-800 rounded-full w-[30%] p-1 inline-block">

            <svg class="w-[30%] inline-block fill-orange-500 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g id="filter-fill"><path d="M20.17,3.91a.76.76,0,0,0-.67-.41H4.5a.76.76,0,0,0-.67.41.73.73,0,0,0,.07.78L9.25,12v7.75a.76.76,0,0,0,.75.75h4a.76.76,0,0,0,.75-.75V12L20.1,4.69A.73.73,0,0,0,20.17,3.91Z"/></g></svg>
            <svg class="w-[40%] inline-block fill-orange-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g id="angle-down"><path d="M12,14.5a.74.74,0,0,1-.53-.22L8,10.78A.75.75,0,0,1,9,9.72l3,3,3-3A.75.75,0,0,1,16,10.78l-3.5,3.5A.74.74,0,0,1,12,14.5Z"/></g></svg>

          </button>

          <div class="dropdown-content bg-zinc-700 inline w-[120%] xl:w-[120%] lg:w-[130%]" id="dropdown-content">
           <button class="inline bg-zinc-800 m-auto text-center rounded-lg text-orange-600 p-2 ml-2 mb-1 hover:bg-orange-600 hover:text-zinc-800 lg:text-sm xl:text-lg md:text-sm" onclick="filterTable('name')">Por Nombre</button>
           <button class="inline bg-zinc-800 m-auto text-center rounded-lg text-orange-600 p-2 mb-1 hover:bg-orange-600 hover:text-zinc-800 lg:text-sm xl:text-lg md:text-sm" onclick="filterTable('date')">Por Fecha</button>
           <button class="inline bg-zinc-800 m-auto text-center rounded-lg text-orange-600 p-2 mb-1 hover:bg-orange-600 hover:text-zinc-800 lg:text-sm xl:text-lg md:text-sm" onclick="filterTable('type')">Por Tipo</button>
           <button class="inline bg-zinc-800 m-auto text-center rounded-lg text-orange-600 p-2 mb-1 hover:bg-orange-600 hover:text-zinc-800 lg:text-sm xl:text-lg md:text-sm" onclick="resetTable()">Todos</button>
          </div>

        </div>
        
      </div>
        
        
        <table class="w-[100%] border-separate bg-zinc-800  mb-5 rounded-md p-5">
            <thead>
              <tr>
                  <th class="bg-zinc-800 text-orange-600 rounded-md">Nombre</th>
                  <th class="bg-zinc-800 text-orange-600 rounded-md">Fecha</th>
                  <th class="bg-zinc-800 text-orange-600 rounded-md">Adjunto</th>
                  <th class="bg-zinc-800 text-orange-600 rounded-md">Acciones</th>
              </tr>
           </thead>
         <tbody id="report-list" class="bg-zinc-700 text-orange-600 rounded-md text-center">
            <!-- Aquí se insertarán los elementos dinámicamente -->
         </tbody>
         </table>
    </div>
 

  <script>
    // Simulación de datos desde el backend
    const reports = [
      { id: 1, name: "Reporte mensual", date: "2023-10-01", add: "Imagen", thumbnail: "https://via.placeholder.com/50" },
      { id: 2, name: "Foto evento", date: "2023-09-15", add: "Imagen", thumbnail: "https://via.placeholder.com/50" }
    ];

    // Función para renderizar la lista
    function renderReports(reports) {
      const list = document.getElementById("report-list");
      list.innerHTML = ""; // Limpiar lista anterior
      reports.forEach(report => {
        const row = `
          <tr>
            <td>${report.name}</td>
            <td>${report.date}</td>
            <td>${report.add}</td>
            <td>
              <img src="${report.thumbnail}" alt="Thumbnail">
              <button onclick="editReport(${report.id})">Editar</button>
              <button onclick="deleteReport(${report.id})">Eliminar</button>
            </td>
          </tr>
        `;
        list.innerHTML += row;
      });
    }

    // Funciones de ejemplo para acciones
    function editReport(id) {
      alert(`Editar reporte con ID: ${id}`);
    }

    function deleteReport(id) {
      if (confirm("¿Estás seguro de eliminar este reporte?")) {
        alert(`Reporte con ID: ${id} eliminado`);
      }
    }

    // Renderizar al cargar la página
    renderReports(reports);
  </script>
</div>
</body>
</html>
@endsection