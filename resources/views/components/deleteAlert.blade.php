@push('scripts')
    <script>
        document.querySelector('form button.btn-danger.delete-all').addEventListener('click', function(event) {
            event.preventDefault();

            swal({
                dangerMode: true,
                title: 'Você tem certeza disso?',
                text: 'Todas as notícias serão excluídas permanentemente!',
                icon: 'warning',
                buttons: ["Não, cancele essa ação!", "Sim, eu aceito!"],
            }).then(function(value) {
                if (value) {
                    document.querySelector('form.delete-tidings').submit();
                }
            });
        });
   </script>
@endpush