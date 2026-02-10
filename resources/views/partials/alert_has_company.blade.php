@if (session('has_company'))
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            window.AlertUtils.showErrorToast(@json(session('has_company')),1200);
        });
    </script>
@endif
