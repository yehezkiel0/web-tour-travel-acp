@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            iziToast.show({
                message: '{{ $error }}',
                position: 'topRight',
                color: 'red'
            });
        </script>
    @endforeach
@endif

@if (session('success'))
    <script>
        iziToast.show({
            message: '{{ session('success') }}',
            position: 'topRight',
            color: 'green'
        });
    </script>
@endif

@if (session('error'))
    <script>
        iziToast.show({
            message: '{{ session('error') }}',
            position: 'topRight',
            color: 'red'
        });
    </script>
@endif
