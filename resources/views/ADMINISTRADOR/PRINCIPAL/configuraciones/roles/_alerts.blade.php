{{-- Alerts reutilizables para roles/usuarios --}}
@if(session('new_registration') == 'ok')
<script>Swal.fire({ icon:'success', confirmButtonColor:'#1C3146', title:'¡Guardado!', text:'Registro creado correctamente.' })</script>
@endif
@if(session('update') == 'ok')
<script>Swal.fire({ icon:'success', confirmButtonColor:'#1C3146', title:'¡Actualizado!', text:'Registro actualizado correctamente.' })</script>
@endif
@if(session('delete') == 'ok')
<script>Swal.fire({ icon:'success', confirmButtonColor:'#1C3146', title:'¡Eliminado!', text:'Registro eliminado correctamente.' })</script>
@endif
@if(session('error') == 'ok')
<script>Swal.fire({ icon:'warning', confirmButtonColor:'#1C3146', title:'No se puede eliminar', text:'Este registro está siendo utilizado o no puedes eliminarte a ti mismo.' })</script>
@endif
