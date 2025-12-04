<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>


<script>
    localStorage.clear();
    window.location.href = "{{ route('landing') }}";
</script>
