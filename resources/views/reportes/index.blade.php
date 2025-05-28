  <div class="overflow-y-auto flex-1 pr-2">
    <table class="w-full border-separate bg-zinc-800 mb-5 rounded-md p-5">
        <!-- ... existing table code ... -->
    </table>
  </div>

  <div class="mt-4 bg-orange-600 p-4 rounded-lg">
     {{ $reportes->links('pagination::tailwind') }}
  </div>
</div>

@if(session('success'))
<div id="successMessage" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
    {{ session('success') }}
</div>
@endif 