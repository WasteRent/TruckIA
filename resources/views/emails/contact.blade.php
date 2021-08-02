@component('mail::message')

# Solicitud de contacto desde TRUCK-i

### Nombre:  
{{ $data['firstname'] }}  
### Apellidos:  
{{ $data['lastname'] }}  
### Email:  
{{ $data['email'] }}  
### Tel:  
{{ $data['phone'] }}  

### Asunto:  
{{ $data['subject'] }}  

### Mensaje:  
{{ $data['message'] }}

@endcomponent
