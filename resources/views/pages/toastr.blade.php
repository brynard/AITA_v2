  {{-- toastr js --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

  <script>
      @if (session('success'))
          toastr.success('{{ session('success') }}');
      @endif
  </script>
  <script src="{{ asset('assets/js/project.js') }}"></script>
