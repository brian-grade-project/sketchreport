@extends('layout.master')

@section('title', 'Test de Subida de Archivos')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Test de Subida de Archivos Multimedia</h1>
    
    <form id="uploadForm" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700">Título</label>
            <input type="text" name="titulo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700">Fecha</label>
            <input type="date" name="media_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700">Archivos</label>
            <input type="file" name="media[]" multiple class="mt-1 block w-full" required>
        </div>
        
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
            Probar Subida
        </button>
    </form>

    <div id="results" class="mt-8 hidden">
        <h2 class="text-xl font-bold mb-4">Resultados de la Validación</h2>
        <pre id="resultContent" class="bg-gray-100 p-4 rounded-md"></pre>
    </div>
</div>

<script>
document.getElementById('uploadForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    
    try {
        const response = await fetch('{{ route("multimedia.test-upload") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        
        const data = await response.json();
        
        document.getElementById('results').classList.remove('hidden');
        document.getElementById('resultContent').textContent = JSON.stringify(data, null, 2);
        
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('results').classList.remove('hidden');
        document.getElementById('resultContent').textContent = 'Error: ' + error.message;
    }
});
</script>
@endsection 